
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pinjamancmt extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/pinjamancmt/';
		$this->layout='newtheme/page/main';
		$this->link=BASEURL.'Pinjamancmt/';
	}

public function index(){
		$data=array();
		$data['title']='List Pinjaman';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
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
		$data['n']=1;
		$data['action']=$this->link.'pinjamansave';;
		$data['products']=array();
		$products=$this->GlobalModel->getData('pinjaman_cmt',array('hapus'=>0));
		foreach($products as $p){
			$hari=date('l',strtotime($p['tanggal']));
			$karyawan=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$p['idcmt']));
			$data['products'][]=array(
				'tanggal'=>hari($hari).', '.date('d-m-Y',strtotime($p['tanggal'])),
				'nama'=>strtolower($karyawan['cmt_name']),
				'totalpinjaman'=>number_format($p['totalpinjaman']),
				'totalpotongan'=>number_format($p['totalpotongan']),
				'sisa'=>number_format(($p['totalpinjaman']-$p['totalpotongan'])),
				'keterangan'=>$p['keterangan'],
				'status'=>$p['status'],
				'edit'=>$this->link.'pinjamankaryawanedit/'.$p['id'],
				'rincian'=>$this->link.'rincianpinjaman/'.$p['id'],
			);
		}
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0));
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function pinjamansave(){
		$data=$this->input->post();
		$insert=array(
			'idcmt'=>$data['idcmt'],
			'tanggal'=>$data['tanggal'],
			'totalpinjaman'=>$data['totalpinjaman'],
			'totalpotongan'=>0,
			'keterangan'=>$data['keterangan'],
			'status'=>1,
			'hapus'=>0,
		);
		$this->db->insert('pinjaman_cmt',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->link);
	}

	public function rincianpinjaman($id){
		$data=array();
		$get=$this->input->get();
		$data['n']=1;
		$data['products']=array();
		$data['cancel']=$this->link;
		$data['products']=$this->db->query("SELECT pk.*, k.cmt_name as nama FROM pinjaman_cmt pk LEFT JOIN master_cmt k ON (k.id_cmt=pk.idcmt) WHERE pk.id='$id' ")->row_array();
		$data['d']=$this->GlobalModel->getDataRow('pinjaman_cmt',array('id'=>$id));
		$data['details']=$this->GlobalModel->getData('potongan_pinjaman_cmt',array('idpinjaman'=>$id));
		//pre($data['products']);
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'detail';
			$this->load->view($this->layout,$data);
		}
	}

}