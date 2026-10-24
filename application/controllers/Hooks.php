<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * // redeploy
 * GitHub Webhook - auto pull branch temabaru
 * URL : BASEURL.'Hooks/pull'
 * Set di GitHub: Settings > Webhooks > Payload URL = https://domain/Hooks/pull
 *   Content type: application/json, Secret: sama dengan $secret di bawah, event: push
 */
class Hooks extends CI_Controller
{

	private $secret = 'Lasjk&^a98';
	private $branch = 'temabaru';

	public function __construct()
	{
		parent::__construct();
	}

	public function pull()
	{
		$payload = file_get_contents('php://input');

		// Validasi signature GitHub
		$sig = isset($_SERVER['HTTP_X_HUB_SIGNATURE_256']) ? $_SERVER['HTTP_X_HUB_SIGNATURE_256'] : '';
		if (empty($sig) && function_exists('getallheaders')) {
			$headers = getallheaders();
			foreach ($headers as $k => $v) {
				if (strcasecmp($k, 'X-Hub-Signature-256') === 0) {
					$sig = $v;
					break;
				}
			}
		}

		$expected = 'sha256=' . hash_hmac('sha256', $payload, $this->secret);
		if (empty($sig) || !hash_equals($expected, $sig)) {
			$reason = empty($sig) ? 'Header X-Hub-Signature-256 tidak ada/kosong' : 'Signature tidak cocok (periksa Secret di GitHub)';
			$this->write_log("[403 Invalid signature] " . $reason . " | Received: " . ($sig ? substr($sig, 0, 15) . '...' : '(empty)'));
			return $this->respond(403, 'Invalid signature');
		}

		$event = isset($_SERVER['HTTP_X_GITHUB_EVENT']) ? $_SERVER['HTTP_X_GITHUB_EVENT'] : '';
		if ($event === 'ping') {
			return $this->respond(200, 'pong');
		}
		if ($event !== 'push') {
			return $this->respond(200, 'Event diabaikan: ' . $event);
		}

		$data = json_decode($payload, true);
		$ref  = isset($data['ref']) ? $data['ref'] : '';
		if ($ref !== 'refs/heads/' . $this->branch) {
			return $this->respond(200, 'Branch diabaikan: ' . $ref);
		}

		$after = isset($data['after']) ? substr($data['after'], 0, 8) : '-';
		$headMsg = isset($data['head_commit']['message']) ? trim(strtok($data['head_commit']['message'], "\n")) : '';
		$this->write_log("[PULL INCOMING] Commit: $after | Msg: $headMsg");

		// Kirim response 200 OK ke GitHub secepatnya agar tidak kena batas timeout 10 detik dari GitHub
		$this->respondEarly(200, array(
			'status'  => 200,
			'message' => "Webhook received for commit $after. Pulling in background..."
		));

		// Jalankan git pull di server
		$this->executePull();
	}

	/**
	 * Eksekusi git fetch & git reset --hard
	 */
	private function executePull()
	{
		$start = microtime(true);
		$dir = escapeshellarg(FCPATH);
		$br  = escapeshellarg($this->branch);

		// Flag aman: tidak prompt password terminal, bypass host check SSH, dan safe.directory
		$cmd = "cd $dir && export PATH=/usr/local/bin:/usr/bin:/bin:\$PATH && export GIT_TERMINAL_PROMPT=0 && export GIT_SSH_COMMAND=\"ssh -o BatchMode=yes -o StrictHostKeyChecking=no\" && git -c safe.directory=* fetch origin $br 2>&1 && git -c safe.directory=* reset --hard origin/$br 2>&1";

		try {
			list($code, $out) = $this->run($cmd);
		} catch (Throwable $e) {
			$code = 1;
			$out  = 'Exception: ' . $e->getMessage();
		}

		$duration = round(microtime(true) - $start, 2);
		$this->write_log("[PULL FINISHED exit $code duration {$duration}s]\n" . $out);

		return array($code, $out);
	}

	/**
	 * Kirim response HTTP ke GitHub dan tutup koneksi secepatnya,
	 * lalu biarkan PHP lanjut mengeksekusi git pull di background.
	 */
	private function respondEarly($status, $data)
	{
		$body = json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR);

		if (function_exists('apache_setenv')) {
			@apache_setenv('no-gzip', '1');
		}
		@ini_set('zlib.output_compression', 'Off');

		while (ob_get_level() > 0) {
			@ob_end_clean();
		}

		http_response_code($status);
		header('Status: ' . $status);
		header('Content-Type: application/json; charset=UTF-8');
		header('Content-Length: ' . strlen($body));
		header('Connection: close');

		echo $body;

		// Tutup koneksi ke GitHub secepatnya
		if (function_exists('litespeed_finish_request')) {
			litespeed_finish_request();
		} elseif (function_exists('fastcgi_finish_request')) {
			fastcgi_finish_request();
		} else {
			@ob_flush();
			@flush();
			if (session_id()) {
				session_write_close();
			}
		}

		// Pastikan proses PHP tetap lanjut setelah koneksi HTTP ke GitHub ditutup
		ignore_user_abort(true);
		set_time_limit(300);
	}

	/**
	 * Lihat log git pull dari browser:
	 * URL: https://domain/Hooks/log?key=Lasjk&^a98
	 */
	public function log()
	{
		$key = $this->input->get('key');
		if ($key !== $this->secret) {
			return $this->respond(403, 'Forbidden');
		}

		$logFile = APPPATH . 'logs/git_hook.log';
		if (!file_exists($logFile)) {
			return $this->respond(200, 'Belum ada log.');
		}

		$lines = file($logFile);
		$lastLines = array_slice($lines, -150);

		$this->output
			->set_status_header(200)
			->set_content_type('text/plain; charset=UTF-8')
			->set_output(implode('', $lastLines));
	}

	public function log_view()
	{
		return $this->log();
	}

	/**
	 * Trigger manual pull dari browser jika dibutuhkan:
	 * URL: https://domain/Hooks/manual?key=Lasjk&^a98
	 */
	public function manual()
	{
		$key = $this->input->get('key');
		if ($key !== $this->secret) {
			return $this->respond(403, 'Forbidden');
		}

		$this->write_log("[MANUAL PULL TRIGGERED]");
		list($code, $out) = $this->executePull();

		$this->output
			->set_status_header($code === 0 ? 200 : 500)
			->set_content_type('text/plain; charset=UTF-8')
			->set_output("Exit code: $code\n\n" . $out);
	}

	/**
	 * Jalankan perintah shell memakai fungsi yang tersedia di hosting.
	 */
	private function run($cmd)
	{
		$disabled = array_map('trim', explode(',', (string) ini_get('disable_functions')));
		$can = function ($f) use ($disabled) {
			return function_exists($f) && !in_array($f, $disabled);
		};

		if ($can('exec')) {
			exec($cmd, $output, $code);
			return array($code, implode("\n", $output));
		}
		if ($can('proc_open')) {
			$p = proc_open($cmd, array(1 => array('pipe', 'w'), 2 => array('pipe', 'w')), $pipes);
			if (is_resource($p)) {
				$out = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
				fclose($pipes[1]);
				fclose($pipes[2]);
				return array(proc_close($p), $out);
			}
		}
		if ($can('shell_exec')) {
			$out = shell_exec($cmd . '; echo "__EXIT:$?"');
			$code = preg_match('/__EXIT:(\d+)\s*$/', (string) $out, $m) ? (int) $m[1] : 1;
			return array($code, preg_replace('/__EXIT:\d+\s*$/', '', (string) $out));
		}
		if ($can('system')) {
			ob_start();
			system($cmd, $code);
			return array($code, ob_get_clean());
		}

		return array(1, 'Tidak ada fungsi shell yang diizinkan (exec/proc_open/shell_exec/system). disable_functions: ' . ini_get('disable_functions'));
	}

	private function write_log($msg)
	{
		@file_put_contents(APPPATH . 'logs/git_hook.log', date('Y-m-d H:i:s') . ' ' . $msg . "\n\n", FILE_APPEND);
	}

	private function respond($status, $msg)
	{
		$msg = function_exists('mb_convert_encoding') ? mb_convert_encoding((string) $msg, 'UTF-8', 'UTF-8') : (string) $msg;
		$this->output
			->set_status_header($status)
			->set_content_type('application/json')
			->set_output(json_encode(array('status' => $status, 'message' => $msg), JSON_PARTIAL_OUTPUT_ON_ERROR));
	}
}
