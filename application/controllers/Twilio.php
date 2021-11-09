<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twilio extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->library('Twilio');
	}

	function index()
	{
		$this->load->library('twilio');

		$from = '+14155238886';
		$to = '+6281297386043';
		$message = 'This is a test...';

		$response = $this->twilio->sms($from, $to, $message);


		if($response->IsError)
			echo 'Error: ' . $response->ErrorMessage;
		else
			echo 'Sent message to ' . $to;
	}

}

/* End of file twilio_demo.php */