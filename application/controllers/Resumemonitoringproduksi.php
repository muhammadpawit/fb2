<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resumemonitoringproduksi extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/resumemonitoringproduksi/';
		$this->load->model('ReportModel');
		$this->load->model('M_potonganoperator');
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

    function index(){
        $data               = [];
        $data['title']      = '';
        $get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=periodeproduksi()['tahun'].'-'.periodeproduksi()['bulan'].'-01';
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
        $arpo=array(
			array('type'=>'Kemeja','id'=>1),
			array('type'=>'Kaos','id'=>2),
			array('type'=>'Celana','id'=>3),
		);
        $i=1;
		$potongan=0;
        foreach($arpo as $arp){
			$data['prods'][]=array(
				'no'=>$i,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'jml_potongan' => $this->ReportModel->ppcsjml_filter($arp['id'],$tanggal1,$tanggal2),
				'pcs_potongan' =>$this->ReportModel->ppcs_filter($arp['id'],$tanggal1,$tanggal2),
				'jml_kirim'=>$this->ReportModel->countdashkirim($arp['id'],$tanggal1,$tanggal2),
				'pcs_kirim'=>$this->ReportModel->rpdashkirim($arp['id'],$tanggal1,$tanggal2),
				'jml_setor'=>$this->ReportModel->countdashsetor($arp['id'],$tanggal1,$tanggal2),
				'pcs_setor'=>$this->ReportModel->rpdashsetor($arp['id'],$tanggal1,$tanggal2),
				'jml_kirim_gudang'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'pcs_kirim_gudang'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
			);
			$i++;
		}
        $data['page']       = $this->page.'index';
        $this->load->view($this->layout,$data);
    }

}