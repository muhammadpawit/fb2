<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapkasbon extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/rekapkasbon/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Rekapkasbon/';
		$this->load->model('KasbonModel');
	}

	public function index(){
		$data=[];
		$data['title']='Rekap Kasbon Bulanan';
		$get=$this->input->get();
		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=date('n');
		}
		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=date('Y');
		}
		
		$data['bulans']=$bulan;
		$data['tahun']=$tahun;
		$data['bulan']=nama_bulan();
		$results=$this->GlobalModel->GetData('karyawan',array('hapus'=>0));
		$no=1;
		$kasbon=[];
		$tgl=0;
		foreach($results as $k){
			$divisi=$this->GlobalModel->GetDataRow('divisi',array('hapus'=>0,'id'=>$k['divisi']));
			$kasbon=$this->KasbonModel->kasbon($bulan,$tahun,$k['id']);
			$data['kar'][]=array(
				'no'=>$no,
				'id'=>$k['id'],
				'nama'=>$k['nama'],
				'bagian'=>!empty($divisi)?$divisi['nama']:'',
				'tgl'=>date('d M Y',strtotime($k['tglmasuk'])),
				'lama'=>lamabekerja($k['id']),
				'gaji'=>$k['gajipokok'],
				'kasbon'=>$this->KasbonModel->getsumkasbon($k['id'],$bulan,$tahun),
				'sisapinjaman'=>0,
				'pinjaman'=>0,
				//'sisagaji'=>$k['gajipokok'],
				'keterangan'=>null,
			);
			$no++;
		}
		$tgl=$this->KasbonModel->tgl($bulan,$tahun);
		$data['tgl']=$tgl;
		//pre($data['kar']);
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

}