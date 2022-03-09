<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Saving extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/saving/';
		$this->url=BASEURL.'Saving/';
	}

	public function index(){
		$data['title']='Saving Pembayaran Tim Potong';
		$data['products']=[];
		$no=1;
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');;
		}

		if(isset($get['cmt'])){
			$tim=$get['cmt'];
		}else{
			$tim=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tim']=$tim;
		$sql="SELECT * FROM gaji_timpotong WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		if(!empty($tim)){
			$sql.=" AND timpotong='".$tim."' ";
		}
		$data['products']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$total=0;
		$nama=null;
		foreach($results as $result){
			$nama=$this->GlobalModel->getdataRow('timpotong',array('id'=>$result['timpotong']));
			$total+=($result['saving']);
			$data['products'][]=array(
				'no'=>$no++,
				'nama'=>strtolower($nama['nama']),
				'periode'=>$result['periode'],
				'jumlah'=>$result['saving'],
			);
		}
		$data['total']=$total;
		$data['timpotong']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

}