<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penggajian extends CI_Controller {


	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->main='newtheme/page/main';
		$this->type=$this->db->query("SELECT * FROM master_harga_gaji WHERE hapus=0")->result_array();
	}


	public function index($jenis){
		$data=array();
		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$setujui=akses($user['id_user'],3);
		}
		$data['setujui']=$setujui;
		$data['type']=$this->type;
		//$data['title']=$this->type[$jenis];
		$data['title']='Master Gaji Harian & Borongan';
		$data['action']=BASEURL.'Penggajian/save/'.$jenis;
		$data['edit']=BASEURL.'Penggajian/edit/'.$jenis.'/';
		$data['hapus']=BASEURL.'Penggajian/hapus/'.$jenis.'/';
		$data['page']=$this->page.'penggajian/harga';
		$data['products']=array();
		$data['products']=$this->db->query("SELECT * FROM master_harga_gaji WHERE jenis IN($jenis) AND hapus=0 ")->result_array();
		$this->load->view($this->main,$data);
	}

	public function Save($jenis){
		$data=$this->input->post();
		$insert=array(
			'jenis'=>$data['jenis'],
			'keterangan'=>$data['keterangan'],
			'nominal'=>$data['nominal'],
			'hapus'=>0
		);
		$this->db->insert('master_harga_gaji',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Penggajian/index/'.$jenis);
	}

	public function edit($jenis){
		$data=$this->input->post();
		foreach($data['products'] as $p){
			$update=array(
				'id'=>$p['id'],
				'nominal'=>$p['nominal'],
			);
			$this->db->update('master_harga_gaji',$update,array('id'=>$p['id']));
		}

		$this->session->set_flashdata('msg','Data berhasil dirubah');
		redirect(BASEURL.'Penggajian/index/'.$jenis);
	}

	public function hapus($jenis,$id){
		$this->db->update('master_harga_gaji',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Penggajian/index/'.$jenis);
	}


}