<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crosscekstokbahan extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/';
		$this->url=BASEURL.'Crosscekstokbahan/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Laporan Harian Bahan';
		$pi=$this->GlobalModel->QueryManualRow("SELECT * FROM penerimaan_item WHERE hapus=0 AND lower(keterangan)='bahan masuk' ORDER BY tanggal DESC LIMIT 1 ");
		$bk=$this->GlobalModel->QueryManualRow("SELECT * FROM barangkeluar_harian WHERE hapus=0 AND jenis=3 ORDER BY tanggal DESC LIMIT 1 ");

		$pidate = strtotime($pi['tanggal']);
		$bkdate = strtotime($bk['tanggal']);
		if($pidate>$bkdate){
			$update=$pi['tanggal'];
		}else{
			$update=$bk['tanggal'];
		}
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=$update;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=$update;
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
		$data['update']=$update;
		$data['kaos']	= [];
		$data['celana']	= [];
		$data['kemeja']	= [];
		//pre($pidate. '  bk ' .$bkdate);
		$sql="SELECT gpi.* , p.kategori, p.tipe, p.keterangan_tipe FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) 
		LEFT JOIN kategori_barang k ON k.id=p.kategori
		WHERE gpi.hapus=0 ";
		$sql.=" AND k.tampildicrosscek IN(1) ";
		if(!empty($jenis)){
			$sql.=" AND p.jenis='".$jenis."'";
		}
		if(!empty($kategori)){
			$sql.=" AND p.kategori='".$kategori."'";
		}
		if(!empty($supplier)){
			$sql.=" AND gpi.supplier='".$supplier."'";
		}
		//$sql.=" GROUP BY p.nama ASC ,p.product_id ,p.kategori ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($results);
		$no=1;
		$no2=1;
		$no3=1;
		$stokawal=[];
		$stokmasuk=[];
		$stokkeluar=[];
		$stokakhirroll=0;
		$stokakhiryard=0;
		$stokakhirharga=0;
		$warna=null;
		$data['prods']=[];
		$utuh=1;
		$bahansisa=1;
		$terpakai=1;
		$takterpakai=1;
		$data['terpakai']=[];
		$data['takterpakai']=[];
		$data['kaos_sisa']=[];
		$data['bahansisa']=[];
		$data['singlet']=[];
		foreach($results as $row){
			$stokawal=$this->ReportModel->stokawal($row['id_persediaan'],$tanggal1);
			$stokmasuk=$this->ReportModel->stokmasuk($row['id_persediaan'],$tanggal1,$tanggal1);
			$stokkeluar=$this->ReportModel->stokkeluar($row['id_persediaan'],$tanggal1,$tanggal1);
			$stokakhirroll=$this->ReportModel->stok_akhir_bahan($row['id_persediaan']);
			//if($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll']) > 0){
				
				$data['kaos'][]=array(
					'no'=>$utuh++,
					'nama'	=>strtolower($row['nama_item']),
					'warna'	=>strtolower($row['warna_item']),
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
					//'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
					'stokakhirroll'=>!empty($stokakhirroll['roll'])?$stokakhirroll['roll']:0,
					'stokakhiryard'=>!empty($stokakhirroll['yard'])?$stokakhirroll['yard']:0,
					'stokakhirharga'=>$row['harga_item'],
					'total'=>!empty($stokakhirroll['roll'])?$row['harga_item']*($stokakhirroll['yard']):0,
					'ket'=>null,
				);
				
			//}
		}
		
		$data['crosscek']=[];
		$data['crosscek']=$this->ReportModel->crosscek('ADMIN_BAHAN');
		//pre($data);
		$data['supplier']=$this->GlobalModel->GetData('master_supplier',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanbulananbahan_excel',$data);	
		}else{
			$data['page']=$this->page.'dash/laporanbulananbahan';
			$this->load->view($this->layout,$data);	
		}
		
	}
}