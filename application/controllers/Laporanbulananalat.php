<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanbulananalat extends CI_Controller {
	
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
		//pre("Coming soon");
		$data['title']='Laporan Bulanan Alat-alat';
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
			$jenis=null;
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

		$sql="SELECT gpi.* FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) WHERE gpi.hapus=0 ";
		if(!empty($jenis)){
			$sql.=" AND p.jenis='".$jenis."'";
		}
		
		if(!empty($kategori)){
			$sql.=" AND p.kategori='".$kategori."' ";
			$url.="&kategori=".$kategori;
		}else{
			$sql.=" AND p.kategori IN(1,2,3,4,5,6,7,8,9,10,11,13,14) ";
		}

		// /$sql.=" AND p.product_id=1181 ";

		if(!empty($supplier)){
			$sql.=" AND gpi.supplier='".$supplier."'";
		}
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($results);
		$no=1;
		$stokawal=0;
		$stokmasuk=0;
		$stokkeluar=0;
		$warna=null;
		$data['prods']=[];
		$barangmasukterakhir=null;
		$ratarata=0;
		foreach($results as $row){
			$stokawal=$this->ReportModel->stokawal_alat($row['id_persediaan'],$tanggal1);
			$stokmasuk=$this->ReportModel->stokmasuk_alat($row['id_persediaan'],$tanggal1,$tanggal2);
			$stokkeluar=$this->ReportModel->stokkeluar_alat($row['id_persediaan'],$tanggal1,$tanggal2);
			$barangmasukterakhir=$this->ReportModel->barangmasukterakhir($row['id_persediaan'],$tanggal1,$tanggal2);
			$ratarata=$this->ReportModel->rataratabarangkeluar($row['id_persediaan'],$tanggal1,$tanggal2);
			//pre($stokkeluar);
			$data['prods'][]=array(
				'no'=>$no++,
				'nama'	=>$row['nama_item'],
				'warna'	=>$row['warna_item'],
				'kode'=>null,
				'stokawal'=>$stokawal,
				'stokawalyard'=>0,
				'stokawalharga'=>$row['harga_item'],
				'stokmasuk'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
				'stokmasukyard'=>0,
				'stokmasukharga'=>$row['harga_item'],
				'stokkeluarroll'=>$stokkeluar,
				'stokkeluaryard'=>0,
				'stokkeluarharga'=>$row['harga_item'],
				'stokakhirroll'=>($stokawal+($stokmasuk['roll']-$stokkeluar)),
				'stokakhiryard'=>0,
				'stokakhirharga'=>$row['harga_item'],
				'total'=>round($row['harga_item']*($stokawal+($stokmasuk['yard']-$stokkeluar))),
				'ket'=>!empty($barangmasukterakhir)?'barang masuk terakhir '.$barangmasukterakhir['jumlah'].' '.$barangmasukterakhir['satuanJml'].' tanggal '.date('d-m-Y',strtotime($barangmasukterakhir['tanggal'])).'.<br> Rata-rata '.number_format($ratarata,2).' '.$barangmasukterakhir['satuanJml']:null,
				'satuan'=>$row['satuan_jumlah_item'],
			);
		}
		
		$data['supplier']=$this->GlobalModel->GetData('master_supplier',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanbulananalat_excel',$data);	
		}else{
			$data['page']=$this->page.'laporanbulananalat.php';
			$this->load->view($this->layout,$data);	
		}
		
	}
}