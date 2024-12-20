<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Alokasitransferbordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/alokasitransfer/';
		$this->url=BASEURL.'Alokasitransferbordir/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Alokasi Transfer Bordir';
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$bagian=2;
		$sql = "SELECT * FROM alokasi_transferan WHERE hapus=0 AND bagian='$bagian' ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$data['prods']=[];
		foreach($results as $r){
			$data['prods'][]=array(
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'keterangan'=>$r['keterangan'],
				'nominal'=>$r['nominal'],
				'hapus' => $this->url.'/hapus/'.$r['id'],
			);
		}
		$data['action']=$this->url.'save';
		$data['alokasi']=$this->GlobalModel->Getdata("pengalokasian",array('hapus'=>0,'bagian'=>2));
		$data['page']=$this->page.'bordir';
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		$insert=array(
			'tanggal'=>$data['tanggal'],
			//'bagian'=>$data['bagian'],
			'bagian'=>2,
			'nominal'=>$data['nominal'],
			'keterangan'=>$data['keterangan'],
			'pengalokasian'=>$data['pengalokasian'],
			'hapus'=>0,
		);
		$this->db->insert('alokasi_transferan',$insert);
		$this->session->set_flashdata('msg','Berhasil Di Simpan');
		redirect($this->url);
	}

	public function hapus($id){
		$insert=array(
			'hapus'=>1,
		);
		$this->db->update('alokasi_transferan',$insert,array('id'=>$id));
		user_activity(callSessUser('id_user'),1,' menghapus alokasi transfer bordir dengan id '.$id);
		$this->session->set_flashdata('msg','Berhasil Di Hapus');
		redirect($this->url);
	}
}