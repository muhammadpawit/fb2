<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resumetotalpo extends CI_Controller {


	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('GlobalModel');
		$this->page='newtheme/page/resumetotalpo/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Resumetotalpo/';
	}


	public function index(){
		$data['title']='Resume Total PO';
		$data['page']=$this->page.'index';
		$this->load->view($this->layout,$data);
	}
}