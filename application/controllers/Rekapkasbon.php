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
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Rekap Kasbon Bulanan';
		$get=$this->input->get();
		$url='';
		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
			$url .= '&bulan='.$bulan;
		}else{
			$bulan=date('Y-m-d');
		}
		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
			$url .= '&tahun='.$tahun;
		}else{
			$tahun=date('Y-m-d');
		}

		if(isset($get['divisi'])){
			$divisi=$get['divisi'];
			$url .= '&divisi='.$divisi;
		}else{
			$divisi=null;
		}
		
		$data['bulans']=$bulan;
		$data['tahun']=$tahun;
		$data['divisi']=$divisi;
		$data['divisis']=table('divisi');
		$data['bulan']=nama_bulan();
		$results=karyawan();
		$no=1;
		$kasbon=[];
		$tgl=0;
		$pinjaman=null;
		$sisapinjaman=0;
		$data['kar']=[];
		foreach($results as $k){
			$divisi=$this->GlobalModel->GetDataRow('divisi',array('hapus'=>0,'id'=>$k['divisi']));
			$kasbon=$this->KasbonModel->kasbon($bulan,$tahun,$k['id']);
			$pinjaman = $this->GlobalModel->QueryManualRow("SELECT * FROM pinjaman_karyawan WHERE hapus=0 AND status IN(1,2) AND idkaryawan='".$k['id']."' ");
			$sisapinjaman = $this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(totalpinjaman-totalpotongan)) as sisa FROM pinjaman_karyawan WHERE hapus=0 AND status IN(1,2) AND idkaryawan='".$k['id']."' ");
			$data['kar'][]=array(
				'no'=>$no,
				'id'=>$k['id'],
				'nama'=>$k['nama'],
				'bagian'=>!empty($divisi)?$divisi['nama']:'',
				'tgl'=>date('d M Y',strtotime($k['tglmasuk'])),
				'lama'=>lamabekerja($k['id']),
				'gaji'=>$k['gajipokok'],
				'kasbon'=>$this->KasbonModel->getsumkasbon($k['id'],$bulan,$tahun),
				'sisapinjaman'=>!empty($sisapinjaman) ? $sisapinjaman['sisa'] : 0,
				'pinjaman'=>!empty($pinjaman) ? $pinjaman['totalpinjaman'] : 0,
				//'sisagaji'=>$k['gajipokok'],
				'keterangan'=>null,
			);
			$no++;
		}
		$tgl=$this->KasbonModel->tgl($bulan,$tahun);
		$data['tgl']=$tgl;
		$data['pdf']=BASEURL.'Rekapkasbon/?pdf=true'.$url;
		if(isset($get['pdf'])){
			$ttd		 = $this->GlobalModel->GetDataRow('user',array('bagian_user'=>1));
			$data['ttd'] = $ttd['ttd'];
			
			$html =  $this->load->view($this->page.'/list_pdf',$data,true);
			$this->load->library('pdfgenerator');
			$this->data['title_pdf'] = 'Rekap Kasbon';

			// Menentukan ukuran kertas dan orientasi
			$paper = array(0, 0, 800, 1200);  // Ukuran kertas kustom (sesuaikan jika perlu)
			$orientation = "portrait";  // Orientasi halaman

			// HTML Header (optional)
			$headerContent = $this->load->view('newtheme/page/pdf/header', $data, true);
			$footerContent =null;
			$htmlWithHeaderFooter = $headerContent . $html . $footerContent;
			$this->pdfgenerator->generate($htmlWithHeaderFooter, $this->data['title_pdf'], $paper, $orientation);
		}else{
			
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

}