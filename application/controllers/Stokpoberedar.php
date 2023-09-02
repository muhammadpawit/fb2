<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stokpoberedar extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/stokpoberedar/';
		$this->url=BASEURL.'Stokpoberedar/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

    function index(){
        $data                   = [];
        $data['title']          = 'STOK PO KAOS YANG BEREDAR ';
        $data['lokasi']         = array(
            array(
                'id'        =>1,
                'lokasi'    => 'Serang'
            ),
            array(
                'id'        =>2,
                'lokasi'    => 'Jawa'
            ),
            array(
                'id'        =>3,
                'lokasi'    => 'Sukabumi'
            ),
            array(
                'id'        =>4,
                'lokasi'    => 'Pusat'
            ),
            array(
                'id'        =>5,
                'lokasi'    => 'Bogor'
            ),
        );
        $data['jenis']                  = $this->GlobalModel->GetData('master_jenis_po',array('status'=>1,'tampil'=>1));
        $data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
    }

}