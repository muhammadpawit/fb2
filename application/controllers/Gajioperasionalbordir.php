<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gajioperasionalbordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->load->model('ReportModel');
		$this->load->model('M_potonganoperator');
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Gaji Operasional Bordir Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('first day of this month'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND bagian='OpsBordir' ";
		$sql.=" ORDER BY id DESC";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'bagian'=>'Harian '.$r['bagian'],
				'detail'=>BASEURL.'Gajioperasionalbordir/pressqcdetail/'.$r['id'],
				'excel'=>BASEURL.'Gajioperasionalbordir/pressqcdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gajioperasionalbordir/pressqcadd';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/pressqc';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function pressqcadd(){
		$data=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Tambah Gaji Operasional Bordir';
		$lembur=0;
		$data['harian']=[];
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE hapus=0 and tipe=1 AND bagian LIKE '%Bordir%' ");
		foreach($results as $r){
			$lembur=$this->GlobalModel->QueryManualRow("SELECT SUM(jml_jam*upah) as total FROM lembur_harian WHERE hapus=0 AND idkaryawan='".$r['id']."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
			$data['harian'][]=array(
				'id'=>$r['id'],
				'nama'=>$r['nama'],
				'gaji'=>$r['gaji'],
				'bagian'=>$r['bagian'],
				'lembur'=>!empty($lembur)?$lembur['total']:0,
			);
		}
		//pre($data['harian']);
		$data['action']=BASEURL.'Gajioperasionalbordir/pressqcsave';
		$data['page']=$this->page.'finishing/gaji_finishing';
		$this->load->view($this->page.'main',$data);
	}

	public function pressqcsave(){
		$data=$this->input->post();
		$cek=$this->GlobalModel->getDataRow('gaji_finishing',array('tanggal1'=>$data['tanggal1'],'hapus'=>0,'bagian'=>'OpsBordir'));
		//pre($data);
		if(!empty($cek)){
			$this->session->set_flashdata('msgt','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Gaji/pressqcadd');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'bagian'=>'OpsBordir',
			'hapus'=>0,
		);
		$this->db->insert('gaji_finishing',$insert);
		$id=$this->db->insert_id();
		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){
				$detail=array(
					'idgaji'=>$id,
					'idkaryawan'=>$p['idkaryawan'],
					'nama'=>$p['nama'],
					'senin'=>isset($p['senin'])?1:0,
					'selasa'=>isset($p['selasa'])?1:0,
					'rabu'=>isset($p['rabu'])?1:0,
					'kamis'=>isset($p['kamis'])?1:0,
					'jumat'=>isset($p['jumat'])?1:0,
					'sabtu'=>isset($p['sabtu'])?1:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lemburs'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
					'claim'=>$p['claim'],
					'pinjaman'=>$p['pinjaman'],
				);
				$this->db->insert('gaji_finishing_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Gajioperasionalbordir');
	}

	public function pressqcdetail($id){
		$data=[];
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['title']='Resume Gaji Karyawan Operasional Bordir Forboys';
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>$d['senin']==1?$gaji['gaji']:0,
					'selasa'=>$d['selasa']==1?$gaji['gaji']:0,
					'rabu'=>$d['rabu']==1?$gaji['gaji']:0,
					'kamis'=>$d['kamis']==1?$gaji['gaji']:0,
					'jumat'=>$d['jumat']==1?$gaji['gaji']:0,
					'sabtu'=>$d['sabtu']==1?$gaji['gaji']:0,
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
					'claim'=>$d['claim'],
					'pinjaman'=>$d['pinjaman'],
				);
			}
		}
		$data['kembali']=BASEURL.'Gajioperasionalbordir';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/finishing_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

}
