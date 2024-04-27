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
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
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
		// $sql="SELECT pid.id_persediaan,pid.nama as namaitem,pi.tanggal,pid.harga,ms.nama as supplier FROM `penerimaan_item_detail` pid JOIN penerimaan_item pi ON (pi.id=pid.penerimaan_item_id) LEFT JOIN master_supplier ms ON ms.id=pi.supplier WHERE pid.id_persediaan > 0 ";
		// $sql.=" GROUP BY pid.id_persediaan,pid.harga ORDER BY pid.nama ASC ";
		// $results=$this->GlobalModel->QueryManual($sql);
		$results = $this->GlobalModel->QueryManual("SELECT * FROM master_supplier where hapus=0 and category > 0 ORDER BY nama ASC, category ASC ");
		$no=1;
		$absen=[];
		$item=[];
		foreach($results as $r){
			$item = $this->GlobalModel->GetData('product',array('hapus'=>0,'supplier'=>$r['id']));
			$data['prods'][]=array(
				'no'=>$no,
				'tanggal'=>null,
				'id'=>null,
				'namaitem'=>null,
				'harga'=>null,
				'supplier'=>$r['nama'],
				'item'	=> $item,
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