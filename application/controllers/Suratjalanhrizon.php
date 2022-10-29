<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratjalanhrizon extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/sjtagihanbordir/';
		$this->url=BASEURL.'Suratjalanhrizon/';
	}

	public function index()
	{
		$data=[];
		$data['title']='Surat Jalan Tagihan Bordir';
		$data['products']=array();
		$no=1;
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}

		if(isset($get['bag'])){
			$bag=$get['bag'];
			$url.='&bag='.$bag;
			$data['bagi']=$this->GlobalModel->GetDataRow('bagian_pengambilan',array('id'=>$bag));
		}else{
			$bag=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['bag']=$bag;

		$sql="SELECT std.*, st.pemilik, st.periode FROM sj_tagihanbordir_detail std ";
		$sql.=" JOIN sj_tagihanbordir st ON(st.id=std.idsj) ";
		$sql.=" WHERE std.hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(std.tgl) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY std.id DESC ";
		$data['products']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$data['products'][]=array(
				'id'=>$row['id'],
				'idsj'=>$row['idsj'],
				'tanggal'=>date('Y-m-d',strtotime($row['tgl'])),
				'idpo'=>$row['idpo'],
				'namapo'=>$row['namapo'],
				'keterangan'=>$row['keterangan'],
				'size'=>$row['size'],
				'sticth'=>$row['sticth'],
				'qty'=>$row['qty'],
				'totalsticth'=>$row['totalsticth'],
				'harga'=>$row['harga'],
				'total'=>$row['total'],
				'ket'=>$row['ket'],
				'hapus'=>$this->url.'Hapus/'.$row['id'],
			);
		}
		$data['tambah']=$this->url.'add';
		$data['excel']=BASEURL.'Suratjalanhrizon/excel?&excel=2'.$url;
		$data['bagian']=$this->GlobalModel->getData('bagian_pengambilan',array());
		if(isset($get['excel'])){
			//if(!empty($bag)){
				$this->load->view($this->page.'excel',$data);
			/*}else{
				echo "<script>alert('bagian harus dipilih');location='".BASEURL.'Suratjalanhrizon'."'</script>";
			}*/
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
		
	}

	public function excel()
	{
		$data=[];
		$data['title']='Surat Jalan Tagihan Bordir ';
		$data['products']=array();
		$no=1;
		$get=$this->input->get();
		$url='';
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
			$url.='&tanggal1='.$tanggal1;
		}else{
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
			$url.='&tanggal2='.$tanggal2;
		}else{
			$tanggal2=null;
		}

		if(isset($get['bag'])){
			$bag=$get['bag'];
			$url.='&bag='.$bag;
			$data['bagi']=$this->GlobalModel->GetDataRow('bagian_pengambilan',array('id'=>$bag));
		}else{
			$bag=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['bag']=$bag;

		$sql="SELECT std.*, st.pemilik, st.periode FROM sj_tagihanbordir_detail std ";
		$sql.=" JOIN sj_tagihanbordir st ON(st.id=std.idsj) ";
		$sql.=" WHERE std.hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(std.tgl) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY std.id DESC ";
		$data['products']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$data['products'][]=array(
				'id'=>$row['id'],
				'idsj'=>$row['idsj'],
				'tanggal'=>date('Y-m-d',strtotime($row['tgl'])),
				'idpo'=>$row['idpo'],
				'namapo'=>$row['namapo'],
				'keterangan'=>$row['keterangan'],
				'size'=>$row['size'],
				'sticth'=>$row['sticth'],
				'qty'=>$row['qty'],
				'totalsticth'=>$row['totalsticth'],
				'harga'=>$row['harga'],
				'total'=>$row['total'],
				'ket'=>$row['ket'],
				'hapus'=>$this->url.'Hapus/'.$row['id'],
			);
		}
		$data['tambah']=$this->url.'add';
		$data['excel']=BASEURL.'Barangkeluar/excel?&excel=2'.$url;
		$data['pemilik']=$this->GlobalModel->getData('pemilik_poluar',array('hapus'=>0));
		$this->load->view($this->page.'excel',$data);	
	}

	public function add(){
		$data = [];
		$data['title']='Tambah Barang Keluar Harian';
		$data['pemilik']=$this->GlobalModel->getData('pemilik_poluar',array('hapus'=>0));
		$data['barang'] = $this->GlobalModel->getData('master_po_luar',array('hapus'=>0));
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['page']=$this->page.'add';
		$data['action']=$this->url.'save';
		$data['cancel']=$this->url.'';
		$this->load->view($this->layout,$data);
	}

	public function detail($id){
		$data = [];
		$data['title']='Rincian Barang Keluar Harian';
		$data['d']=$this->GlobalModel->getDataRow('barangkeluarharian',array('id'=>$id));
		$data['dets']=$this->GlobalModel->getData('barangkeluarharian_detail',array('idbarangkeluarharian'=>$id));
		$data['page']=$this->page.'detail';
		$data['cancel']=$this->url;
		$this->load->view($this->layout,$data);
	}

	public function hapus($id){
		$this->db->update('sj_tagihanbordir_detail',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect($this->url);
	}

	public function save()
	{
		$data = $this->input->post();
		//pre($data);
		$dataInserted = array(
			'tanggal'=>$data['tanggal1'],
			'periode'=>date('d F Y',strtotime($data['tanggal1'])).'-'.date('d F Y',strtotime($data['tanggal2'])),
			'pemilik'=>$data['pemilik'],
			'hapus'=>0,
		);
		$this->db->insert('sj_tagihanbordir',$dataInserted);
		$id=$this->db->insert_id();
		foreach($data['products'] as $p){
			$detail=array(
				'idsj'=>$id,
				'tgl'=>$p['tgl'],
				'idpo'=>$p['idpo'],
				'namapo'=>$p['namapo'],				
				'keterangan'=>$p['keterangan'],
				'size'=>$p['size'],
				'sticth'=>$p['sticth'],
				'qty'=>$p['qty'],
				'totalsticth'=>$p['totalsticth'],
				'harga'=>$p['harga'],
				'total'=>$p['total'],
				'ket'=>$p['ket'],
				'hapus'=>0
			);
			$this->db->insert('sj_tagihanbordir_detail',$detail);
		}
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect($this->url);
	}

	public function searchbordir(){
		$data=$this->input->get();
		//echo ($data['id']);exit;
		$json=[];
		$sql="SELECT po.id,po.nama FROM master_po_luar po WHERE po.hapus=0 AND po.id IN(SELECT kode_po from kelola_mesin_bordir WHERE hapus=0 group by kode_po) ";
		$sql.=" AND lower(po.nama) like '%".strtolower($data['search'])."%' ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $r){
			//$count=$this->GlobalModel->QueryManual("SELECT * FROM kelola_mesin_bordir WHERE hapus=0 AND kode_po='".$r['id']."' ");
			$count=$this->GlobalModel->QueryManual("SELECT SUM(jumlah_naik_mesin) as jumlah_naik_mesin,stich,bagian_bordir,size,laporan_perkalian_tarif FROM kelola_mesin_bordir WHERE hapus=0 AND kode_po='".$r['id']."' GROUP BY stich,bagian_bordir ");
			$json[]=array(
				'value'=>$r['id'],
				'label'=>$r['nama'],
				'count'=>count($count),
				'details'=>$count,
				// 'size'=>$r['size'],
				// 'bagian_bordir'=>$r['bagian_bordir'],
			);
		}

		echo json_encode($json);
	}

}
