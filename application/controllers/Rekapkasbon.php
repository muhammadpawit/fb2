<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapkasbon extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Rekapkasbon/';
	}

	public function index(){
		$data=[];
		$data['title']='Rekap Kasbon Bulanan';
		$months = array();
		for ($i = 0; $i < 12; $i++) {
		    $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
		    $months['bulan'][] = array(
				'bulan'=>date('n', $timestamp),
				'nama'=>date('F', $timestamp),
			);
		}
		$this->load->view($this->layout,$data);
	}

}