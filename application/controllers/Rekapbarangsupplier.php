<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapbarangsupplier extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/rekapbarangsupplier/';
		$this->layout='newtheme/page/main';
		$this->url=BASEURL.'Rekapbarangsupplier/';
	}

	public function index(){
		$data=array();
		$data['title']='Rekap Barang Masuk Supplier';
		$data['n']=1;
		$data['action']=$this->url.'rekapbarangsupplier_save';
		$data['prods']=[];
		$data['bulan']=nama_bulan();
		$data['supp']=$this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$get=$this->input->get();
		
		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=null;
		}

		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=null;
		}

		if(isset($get['supplier'])){
			$supplier=$get['supplier'];
		}else{
			$supplier=null;
		}

		$data['tahun']=$tahun;
		$data['bulans']=$bulan;
		$data['supplier']=$supplier;
		//pre(bulan());
		$sql="SELECT rekapbarangsupplier.* FROM rekapbarangsupplier ";

		if(!empty($bulan)  && !empty($tahun)){
			$sql.=" JOIN rekapbarangsupplier_detail ON rekapbarangsupplier.id=rekapbarangsupplier_detail.idrekap ";
			$sql.=" WHERE rekapbarangsupplier_detail.hapus=0 AND rekapbarangsupplier.hapus=0 ";
			$sql.=" AND MONTH(tanggal_awal)='".$bulan."' AND YEAR(tanggal_awal)='".$tahun."' ";
			
			if(!empty($supplier)){
				$sql.=" AND supplier='".$supplier."' ";
			}

			$sql.=" GROUP BY supplier ";
		}else if(!empty($tahun)){
			$sql.=" JOIN rekapbarangsupplier_detail ON rekapbarangsupplier.id=rekapbarangsupplier_detail.idrekap ";
			$sql.=" WHERE rekapbarangsupplier_detail.hapus=0 AND rekapbarangsupplier.hapus=0 ";
			$sql.=" AND YEAR(tanggal_awal)='".$tahun."' ";
			
			if(!empty($supplier)){
				$sql.=" AND supplier='".$supplier."' ";
			}

			$sql.=" GROUP BY supplier ";
		}else if(!empty($bulan)){
			$sql.=" JOIN rekapbarangsupplier_detail ON rekapbarangsupplier.id=rekapbarangsupplier_detail.idrekap ";
			$sql.=" WHERE rekapbarangsupplier_detail.hapus=0 AND rekapbarangsupplier.hapus=0 ";
			$sql.=" AND MONTH(tanggal_awal)='".$bulan."'  ";
			
			if(!empty($supplier)){
				$sql.=" AND supplier='".$supplier."' ";
			}

			$sql.=" GROUP BY supplier ";
		}else{
			$sql.="  WHERE hapus=0 ";
			if(!empty($supplier)){
				$sql.=" AND supplier='".$supplier."' ";
			}
		}


		$results=$this->GlobalModel->QueryManual($sql);
		$details=[];
		foreach($results as $r){
			$s=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$r['supplier']));
			$data['prods'][]=array(
				'id'=>$r['id'],
				'periode'=>$r['periode'],
				'ket'=>$r['keterangan'],
				'nama'=>$s['nama'],
				'detail'=>$this->url.'detail/'.$r['id'],
				'rincian'=>$this->rincian($r['id']),
			);
		}
		$data['tambah']=$this->url.'add';
		if(isset($get['excel'])){
			$this->load->view($this->page.'list_excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

	public function rincian($id){
		$data['d']=array();
		$data['title']='Detail Rekap Barang Masuk Supplier';
		$data['cancel']=$this->url;
		$data['k']=$this->GlobalModel->getDataRow('rekapbarangsupplier',array('hapus'=>0,'id'=>$id));
		$s=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$data['k']['supplier']));
		$data['nama']=$s['nama'];
		$results=$this->GlobalModel->getData('rekapbarangsupplier_detail',array('hapus'=>0,'idrekap'=>$id));
		$total=0;
		foreach($results as $r){
			$total=$this->ReportModel->totalsup($data['k']['supplier'],$r['tanggal_awal'],$r['tanggal_akhir']);
			$data['d'][]=array(
				'tanggal_awal'=>$r['tanggal_awal'],
				'tanggal_akhir'=>$r['tanggal_akhir'],
				'nama'=>$s['nama'],
				'total'=>!empty($total)?$total:0,
			);
		}
		return $data['d'];
	}

	public function add(){
		$data=array();
		$data['title']='Input Rekap Barang Masuk Supplier';
		$data['simpan']=$this->url.'save';
		$data['sup']=$this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$data['page']=$this->page.'form';
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		$insert=array(
			'keterangan'=>$data['keterangan'],
			'periode'=>$data['periode'],
			'supplier'=>$data['supplier'],
			'hapus'=>0,
		);
		$this->db->insert('rekapbarangsupplier',$insert);
		$id=$this->db->insert_id();
		foreach($data['prods'] as $p){
			$idd=array(
				'idrekap'=>$id,
				'tanggal_awal'=>$p['tanggal_awal'],
				'tanggal_akhir'=>$p['tanggal_akhir'],
				'hapus'=>0,
			);
			$this->db->insert('rekapbarangsupplier_detail',$idd);
		}
		//pre($data);
		$this->session->set_flashdata('msg','Berhasil Di Simpan');
		redirect($this->url);
	}

	public function detail($id){
		$data=array();
		$data['title']='Detail Rekap Barang Masuk Supplier';
		$data['cancel']=$this->url;
		$data['k']=$this->GlobalModel->getDataRow('rekapbarangsupplier',array('hapus'=>0,'id'=>$id));
		$s=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$data['k']['supplier']));
		$data['nama']=$s['nama'];
		$results=$this->GlobalModel->getData('rekapbarangsupplier_detail',array('hapus'=>0,'idrekap'=>$id));
		$total=0;
		foreach($results as $r){
			$total=$this->ReportModel->totalsup($data['k']['supplier'],$r['tanggal_awal'],$r['tanggal_akhir']);
			$data['d'][]=array(
				'tanggal_awal'=>$r['tanggal_awal'],
				'tanggal_akhir'=>$r['tanggal_akhir'],
				'nama'=>$s['nama'],
				'total'=>!empty($total)?$total:0,
			);
		}
		$data['page']=$this->page.'detail';
		$this->load->view($this->layout,$data);
	}
}