<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Gajisablon extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->url=BASEURL.'Gajisablon/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function harian(){
		$data=[];
		$data['title'] = 'Gaji Sablon Harian ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['kar']=$this->GlobalModel->GetData('karyawan_harian',array('hapus'=>0,'bagian'=>'Sablon Harian'));
		$data['kartustok']=[];
		$data['tambah']=$this->url.'add';
		$data['prods']=[];
		$sql		  =" SELECT a.*, b.nama, d.*  FROM gaji_sablon_harian a LEFT JOIN karyawan_harian b ON b.id=a.id_karyawan_harian ";
		$sql		  .=" JOIN gaji_sablon_harian c ON c.id";
		$sql 		  .= " LEFT JOIN gaji_sablon_harian_detail d ON d.idgaji=a.id ";
		$sql 		  .=" WHERE a.hapus=0 AND b.hapus=0 ";
		$data['prods']=$this->GlobalModel->QueryManual($sql);
		// pre($data['prods']);
		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/kartustok_excel',$data);
		}else{
			$data['page']='gudang/gajisablon/harian';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	public function hariandetail($id){
		$data=[];
		$data['title'] = 'Gaji Sablon Harian ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['kartustok']=[];
		$data['tambah']=$this->url.'add';
		$data['prods']=[];
		$sql		  =" SELECT a.*, b.nama  FROM gaji_sablon_harian a LEFT JOIN karyawan_harian b ON b.id=a.id_karyawan_harian ";
		$sql 		  .=" WHERE a.hapus=0 AND b.hapus=0 ";
		$data['prods']=$this->GlobalModel->QueryManual($sql);

		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/kartustok_excel',$data);
		}else{
			$data['page']='gudang/gajisablon/hariandetail';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	public function add(){
		$data=[];
		$data['title'] = 'Form Gaji Sablon Harian ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['prods']=[];
		$data['action']=$this->url.'save';
		$data['cancel']=$this->url.'harian';
		$data['kar']=$this->GlobalModel->GetData('karyawan_harian',array('hapus'=>0,'bagian'=>'Sablon Harian'));
		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/kartustok_excel',$data);
		}else{
			$data['page']='gudang/gajisablon/harian_form';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	public function cari($id='')
	{
		$getId = $this->input->get('id');
		
		$data = $this->GlobalModel->QueryManualRow(
			"SELECT * FROM karyawan_harian WHERE hapus=0 AND id='".$getId."' "
		);
		echo json_encode($data);
	}

	function save(){
		$post = $this->input->post();
		$insert = array(
			'periode' 				=> $post['periode'],
			'id_karyawan_harian'	=> $post['id_karyawan_harian'],
			'gajiperhari'			=> $post['gaji'],
			'hapus'					=> 0,
		);
		$this->db->insert('gaji_sablon_harian',$insert);
		$id=$this->db->insert_id();
		$insert_detail = array(
			'idgaji'	=> $id,
			'senin'		=> $post['senin'],
			'selasa'	=> $post['selasa'],
			'rabu'		=> $post['rabu'],
			'kamis'		=> $post['kamis'],
			'jumat'		=> $post['jumat'],
			'sabtu'		=> $post['sabtu'],
		);
		$this->db->insert('gaji_sablon_harian_detail',$insert_detail);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url.'harian');
	}

}