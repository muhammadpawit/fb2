<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rinciankirimgudang extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/rinciankirimgudang/';
		$this->url=BASEURL.'Rinciankirimgudang/';
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
	}

	function index(){
		$data=array();
		$data['title']='Laporan Rincian Pengiriman Gudang';
		$get=$this->input->get();
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

		$sql='SELECT fkg.*, p.kode_artikel FROM finishing_kirim_gudang fkg LEFT JOIN produksi_po p ON(p.kode_po=fkg.kode_po) WHERE id_finishing_kirim_gudang>0 ';
		if(isset($tanggal1)){
			$sql.=" AND date(tanggal_kirim) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}

		$data['notarincian'] = $this->GlobalModel->queryManual($sql);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		if(isset($get['excel'])){
			$this->load->view($this->page.'kirimgudang_excel',$data);
		}else{
			$data['page']=$this->page.'laporankirimgudangharian';
			$this->load->view($this->layout,$data);	
		}
		
	}

}