<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekappembayarancmt extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('PembayaranModel');
		$this->page='newtheme/page/rekappembayarancmt/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

    public function index(){
        $data               = [];
        $data['title']      = 'Rekap Pembayaran CMT';
        $get                = $this->input->get();
        if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
        $data['tanggal1']           = $tanggal1;
        $data['tanggal2']           = $tanggal2;
        $data['periode']            = $this->PembayaranModel->getPeriode($tanggal1,$tanggal2);
        $cmt                        = $this->PembayaranModel->getRekapCmt($tanggal1,$tanggal2);
        $prods                      = [];
        $no                         = 1;
        foreach($cmt as $c){
            $tgl                        = $this->PembayaranModel->getRekapTgl($tanggal1,$tanggal2,$c['id_cmt']);
            $jumlah                        = $this->PembayaranModel->getSum($tanggal1,$tanggal2,$c['id_cmt']);
            $prods[] = array(
                'no'        => $no,
                'nama'      => strtolower($c['cmt_name']),
                'tgl'       => $tgl,
                'jumlah'    => $jumlah->total,
            );
            $no++;
        }
        $data['prods']              = $prods;
        $data['total']            = $this->PembayaranModel->getTotalPeriode($tanggal1,$tanggal2);
        //pre($data['total']);
        if(isset($get['excel'])){
            $this->load->view($this->page.'excel',$data);	
        }else{
            $data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);	
        }
    }

}