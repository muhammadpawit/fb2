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
			$this->log("[403 Invalid signature] " . $reason . " | Received: " . ($sig ? substr($sig, 0, 15) . '...' : '(empty)'));
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

		$dir = escapeshellarg(FCPATH);
		$br  = escapeshellarg($this->branch);
		$cmd = "cd $dir && git fetch origin $br 2>&1 && git reset --hard origin/$br 2>&1";

		try {
			list($code, $out) = $this->run($cmd);
		} catch (Throwable $e) {
			$code = 1;
			$out  = 'Exception: ' . $e->getMessage();
		}

		$this->log("[exit $code]\n" . $out);
		return $this->respond($code === 0 ? 200 : 500, $out);
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

	private function log($msg)
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
