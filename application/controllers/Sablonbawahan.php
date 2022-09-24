<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sablonbawahan extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->url=BASEURL.'Sablonbawahan/';
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/sablonbawahan/';
	}

	public function index(){
		$data=[];
		$data['title']='Sablon Bawahan Untuk HPP';
		$data['tambah']=$this->url.'add';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=[];
		$data['title']='Tambah Sablon Bawahan Untuk HPP';
		$data['kembali']=$this->url;
		$data['action']=$this->url.'save';
		$data['page']=$this->page.'add';
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		//pre($data);
		$po=explode(',',$data['po']);
		$job=explode(',',$data['job']);
		$cmt=explode(',',$data['cmt']);
		$insert=array(
			'idpo'=>$po[0],
			'kode_po'=>$po[1],
			'idjob'=>$job[0],
			'namajob'=>$job[1],
			'price'=>$job[2],
			'tanggal'=>date('Y-m-d'),
			'idcmt'=>$cmt[0],
			'namacmt'=>$cmt[1],
			'keterangan'=>$data['keterangan'],
			'hapus'=>0
		);
		//pre($insert);
		$this->db->insert('sablonbawahan',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect($this->url);
	}

	public function hapus($id){
		$update=array(
			'hapus'=>1
		);
		$where=array('id'=>$id);
		$this->db->update('sablonbawahan',$update,$where);
		$this->session->set_flashdata('msg','Data Alokasi Berhasil Di Hapus');
		redirect($this->url);
	}
}