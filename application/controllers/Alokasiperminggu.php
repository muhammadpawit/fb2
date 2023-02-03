<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alokasiperminggu extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/alokasiperminggu/';
		$this->url=BASEURL.'Alokasiperminggu/';
		$this->load->model('AdjustModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data['title']='Alokasi Mingguan ';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}
}