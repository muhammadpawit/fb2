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
		$expected = 'sha256=' . hash_hmac('sha256', $payload, $this->secret);
		if (empty($sig) || !hash_equals($expected, $sig)) {
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
		exec($cmd, $output, $code);

		$log = date('Y-m-d H:i:s') . " [exit $code]\n" . implode("\n", $output) . "\n\n";
		@file_put_contents(APPPATH . 'logs/git_hook.log', $log, FILE_APPEND);

		return $this->respond($code === 0 ? 200 : 500, implode("\n", $output));
	}

	private function respond($status, $msg)
	{
		$this->output
			->set_status_header($status)
			->set_content_type('application/json')
			->set_output(json_encode(array('status' => $status, 'message' => $msg)));
	}
}
