<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapkasbon extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/rekapkasbon/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Rekapkasbon/';
	}

	public function index(){
		$data=[];
		$data['title']='Rekap Kasbon Bulanan';
		$data['bulan']=nama_bulan();

		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

}