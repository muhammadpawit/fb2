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
        // $data['title']          = 'STOK PO YANG BEREDAR ';
        $data['title']          = '';
        $details                = [];
        $data['lokasi']         = array(
            array(
                'id'        =>1,
                'lokasi'    => 'Serang',
                'details'   => [],
            ),
            array(
                'id'        =>2,
                'lokasi'    => 'Jawa',
                'details'   => [],
            ),
            array(
                'id'        =>3,
                'lokasi'    => 'Sukabumi',
                'details'   => [],
            ),
            array(
                'id'        =>4,
                'lokasi'    => 'Pusat',
                'details'   => 'sablon, bordir KLO', // sablon, bordir, KLO (sudah dipotong tapi belum di bordir dan di sablon)
            ),
            array(
                'id'        =>5,
                'lokasi'    => 'Bogor',
                'details'   => [],
            ),
        );
        $data['jenis_kemeja']           = $this->GlobalModel->GetData('master_jenis_po',array('status'=>1,'tampil'=>1,'idjenis'=>1));
        $data['jenis']                  = $this->GlobalModel->GetData('master_jenis_po',array('status'=>1,'tampil'=>1,'idjenis'=>2));
        $data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
    }

    function detail(){
        $post = $this->input->post();
        if($post['proses']=='PENDING'){
            $detail = $this->ReportModel->pendingPoDetail($post['id']);
        }else{
            $detail = $this->ReportModel->BeredarPoDetail($post['id'],$post['proses']);
        }

        echo json_encode($detail);
    }


    function detailKirim(){
        $post = $this->input->post();
        $detail = $this->ReportModel->getJumlahJenisPoCmtGrupDetail($post['id'],$post['proses']);
        echo json_encode($detail);
    }

    function detailberedar(){
        $post = $this->input->post();
        $detail = $this->ReportModel->BeredarPoPerjalanan($post['id'],'DETAIL');
        echo json_encode($detail);
    }

}