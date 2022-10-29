<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alokasikeuanganbordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/alokasikeuanganbordir/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Alokasikeuanganbordir/';
	}

	public function index(){
		$data=array();
		$data['title']='Alokasi Keuangan Bordir';
		$data['n']=1;
		$data['action']=$this->url.'transaksibanksave';
		$data['mutasi']=BASEURL.'Keuangan/mutasibank/';
		$data['page']=$this->page.'list';
		$data['products']=$this->GlobalModel->getData('bank',array('hapus'=>0));
		$data['alokasi']=$this->GlobalModel->QueryManual("SELECT * FROM pengalokasian WHERE hapus=0 AND bagian=2 AND id NOT IN (17,18,19)");
		$this->load->view('newtheme/page/main',$data);
	}

	public function transaksibanksave(){
		$data=$this->input->post();
		//pre($data);
		$cursaldo=$this->GlobalModel->getDataRow('bank',array('id'=>$data['bank_id']));
		$saldomasuk=0;
		$saldokeluar=0;
		if($data['jenis']==1){
			$saldomasuk=$data['nominal'];
			$saldokeluar=0;
		}else{
			$saldomasuk=0;
			$saldokeluar=$data['nominal'];
		}
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'tgltransaksi'=>date('Y-m-d H:i:s'), // tanggal input
			'bank_id'=>$data['bank_id'],
			'saldoawal'=>$cursaldo['saldo'],
			'saldomasuk'=>$saldomasuk,
			'saldokeluar'=>$saldokeluar,
			'saldo'=>$cursaldo['saldo']+$saldomasuk-$saldokeluar,
			'keterangan'=>$data['keterangan'],
			'referensi'=>0,
			'bagian'=>$data['bagian'],
			'pengalokasian'=>$data['pengalokasian'],
			'hapus'=>0
		);
		$this->db->insert('aruskas',$insert);
		$ref=$this->db->insert_id();
		$this->db->update('aruskas',array('referensi'=>$ref),array('id'=>$ref));
		if($data['jenis']==1){
			$this->db->query("UPDATE bank set saldo=saldo+'".$data['nominal']."' ");
		}else{
			$this->db->query("UPDATE bank set saldo=saldo-'".$data['nominal']."' ");
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url);
	}


}