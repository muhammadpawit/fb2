<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends CI_Controller {

	public $layout;
	public $page;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;
	public $uri;

	function __construct() {
		parent::__construct();
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function finishing(){
		$data=[];
		$data['title']='Daftar Pengeluaran Finishing';
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$sql="SELECT * FROM pengeluaran_finishing WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY tanggal DESC ";
		$data['products']=$this->GlobalModel->queryManual($sql);
		
		$data['tambah']=BASEURL.'Pengeluaran/finishing_add';
		$data['page']=$this->page.'pengeluaran/finishing_list';
		$this->load->view($this->layout,$data);
	}

	public function finishing_add(){
		$data=array();
		$data['title']='Tambah Pengeluaran Finishing';
		$data['action']=BASEURL.'Pengeluaran/finishing_save';
		$data['page']=$this->page.'pengeluaran/finishing_form';
		$this->load->view($this->layout,$data);
	}

	public function finishing_save(){
		$post=$this->input->post();
		$insertData = array(
			'tanggal'		=>	$post['tanggal'],
			'keterangan'	=>	$post['keterangan'],
			'nominal'		=>	$post['nominal'],
			'hapus'			=>	0,
		);
		$this->GlobalModel->insertData('pengeluaran_finishing',$insertData);
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Pengeluaran/finishing');
	}

	public function finishing_edit($id){
		$data=array();
		$data['title']='Edit Pengeluaran Finishing';
		$data['action']=BASEURL.'Pengeluaran/finishing_edit_save/'.$id;
		$data['p']=$this->GlobalModel->getDataRow('pengeluaran_finishing',array('id'=>$id));
		$data['page']=$this->page.'pengeluaran/finishing_form';
		$this->load->view($this->layout,$data);
	}

	public function finishing_edit_save($id){
		$post=$this->input->post();
		$updateData = array(
			'tanggal'		=>	$post['tanggal'],
			'keterangan'	=>	$post['keterangan'],
			'nominal'		=>	$post['nominal'],
		);
		$this->GlobalModel->updateData('pengeluaran_finishing',array('id'=>$id),$updateData);
		$this->session->set_flashdata('msg','Data Berhasil Diubah');
		redirect(BASEURL.'Pengeluaran/finishing');
	}

	public function finishing_delete($id){
		$updateData = array(
			'hapus'	=>	1,
		);
		$this->GlobalModel->updateData('pengeluaran_finishing',array('id'=>$id),$updateData);
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect(BASEURL.'Pengeluaran/finishing');
	}
}
