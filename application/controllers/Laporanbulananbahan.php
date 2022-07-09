<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanbulananbahan extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->url=base_url().'Laporanbulananbahan/';
		$this->page='newtheme/page/laporanbulananbahan/';
		$this->layout='newtheme/page/main';
	}


	public function index(){
		$data=[];
		$data['title']='Laporan Bulanan Bahan';
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

		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=4;
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
		}else{
			$kategori=null;
		}

		if(isset($get['supplier'])){
			$supplier=$get['supplier'];
		}else{
			$supplier=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['kategori']=$kategori;
		$sql="SELECT gpi.* FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) WHERE gpi.hapus=0 ";
		if(!empty($jenis)){
			$sql.=" AND p.jenis='".$jenis."'";
		}
		if(!empty($kategori)){
			$sql.=" AND p.kategori='".$kategori."'";
		}
		if(!empty($supplier)){
			$sql.=" AND gpi.supplier='".$supplier."'";
		}
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$no=1;
		$stokawal=[];
		$stokmasuk=[];
		$stokkeluar=[];
		$stokakhirroll=0;
		$stokakhiryard=0;
		$stokakhirharga=0;
		$warna=null;
		$data['prods']=[];
		foreach($results as $row){
			$stokawal=$this->ReportModel->stokawal($row['id_persediaan'],$tanggal1);
			$stokmasuk=$this->ReportModel->stokmasuk($row['id_persediaan'],$tanggal1,$tanggal2);
			$stokkeluar=$this->ReportModel->stokkeluar($row['id_persediaan'],$tanggal1,$tanggal2);
			$data['prods'][]=array(
				'no'=>$no++,
				'nama'	=>$row['nama_item'],
				'warna'	=>$row['warna_item'],
				'kode'=>null,
				//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
				'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
				'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
				'stokawalharga'=>$row['harga_item'],
				'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
				'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
				'stokmasukharga'=>$row['harga_item'],
				'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
				'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
				'stokkeluarharga'=>$row['harga_item'],
				'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
				'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
				'stokakhirharga'=>$row['harga_item'],
				'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
				'ket'=>null,
			);
		}
		
		$data['supplier']=$this->GlobalModel->GetData('master_supplier',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanbulananbahan_excel',$data);	
		}else{
			$data['page']=$this->page.'laporanbulananbahan';
			$this->load->view($this->layout,$data);	
		}
		
	}
}