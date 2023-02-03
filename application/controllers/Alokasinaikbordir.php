<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alokasinaikbordir extends CI_Controller {


	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('GlobalModel');
		$this->page='newtheme/page/alokasinaikbordir/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Alokasinaikbordir/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}


	public function index(){
		$data['title']='Alokasi naik PO Bordir';
		$data['page']=$this->page.'index';
		$this->load->view($this->layout,$data);
	}
}