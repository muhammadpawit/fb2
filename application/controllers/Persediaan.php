<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persediaan extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
	}

	public function persediaan()
	{
		$this->load->view('global/header');
		$this->load->view('gudang/persediaan/persediaan-view');
		$this->load->view('global/footer');
	}

	public function persediaantambah()
	{
		$this->load->view('global/header');
		$this->load->view('gudang/persediaan/persediaan-tambah');
		$this->load->view('global/footer');
	}
}
