<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listhargasupplier extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/listhargasupplier/';
		$this->url=BASEURL.'Listhargasupplier/';
	}

	public function index(){
		$data=[];
		$data['title']='Laporan List Harga Supplier';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 day"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$sql="SELECT pid.id_persediaan,pid.nama as namaitem,pi.tanggal,pid.harga,ms.nama as supplier FROM `penerimaan_item_detail` pid JOIN penerimaan_item pi ON (pi.id=pid.penerimaan_item_id) LEFT JOIN master_supplier ms ON ms.id=pi.supplier WHERE pid.id_persediaan > 0 ";

		$sql.=" GROUP BY pid.id_persediaan,pid.harga ORDER BY pid.nama ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$absen=[];
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no,
				'tanggal'=>$r['tanggal'],
				'id'=>$r['id_persediaan'],
				'namaitem'=>$r['namaitem'],
				'harga'=>$r['harga'],
				'supplier'=>$r['supplier'],
			);
			$no++;
		}
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}
}