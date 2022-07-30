<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekappemakaianbahan extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/rekappemakaianalat/';
		$this->url=BASEURL.'Rekappemakaianbahan/';
	}

	public function index()
	{
		$data=[];
		$data['title']='Rekap Pemakaian Alat-alat ';
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

		$sql="SELECT * FROM master_jenis_po WHERE status=1 ";
		$sql.=" ORDER BY nama_jenis_po ";
		$data['products']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$data['products'][]=array(
				'id'=>$row['id_jenis_po'],
				'nama'=>$row['nama_jenis_po'],
			);
		}

		$data['alat']=[];
		$sql="SELECT * FROM gudang_persediaan_item WHERE hapus=0 AND nama_item IN(SELECT nama_item_keluar FROM gudang_bahan_keluar WHERE hapus=0) ";
		$sql.=" ORDER BY nama_item ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$po=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po WHERE status=1 ORDER BY nama_jenis_po ");
			$data['alat'][]=array(
				'id'=>$row['id_persediaan'],
				'nama'=>strtolower($row['nama_item']),
				'po'=>$po,
			);
		}


		$data['tambah']=$this->url.'add';
		$data['excel']=BASEURL.'Rekappemakaianbahan?&excel=2'.$url;
		$data['bagian']=$this->GlobalModel->getData('bagian_pengambilan',array());
		if(isset($get['excel'])){
			$this->load->view($this->page.'rekapbahan_excel',$data);
		}else{
			$data['page']=$this->page.'rekapbahan';
			$this->load->view($this->layout,$data);
		}
		
	}

	public function excel()
	{
		$data=[];
		$data['title']='Barang Keluar Harian';
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

		$sql="SELECT SUM(ukuran_item_keluar) as jumlah, nama_item_keluar as nama,satuan_item_keluar as satuan FROM gudang_bahan_keluar WHERE hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		if(!empty($bag)){
			$sql.=" AND bk.bagian = '".$bag."'";
		}
		$sql.=" GROUP BY nama_item_keluar ORDER BY nama_item_keluar ASC ";
		$data['products']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$tag=[];
		foreach($results as $row){
			$tgl=$this->GlobalModel->QueryManual("SELECT barangkeluarharian_detail.tanggal from barangkeluarharian_detail  JOIN barangkeluarharian bk ON (bk.id=barangkeluarharian_detail.idbarangkeluarharian) WHERE barangkeluarharian_detail.hapus=0 AND DATE(barangkeluarharian_detail.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and bagian=".$bag." ORDER BY barangkeluarharian_detail.tanggal ASC ");
			foreach($tgl as $t){
				$tag[]=date('d/m',strtotime($t['tanggal']));
			}
			$data['products'][]=array(
				//'tanggal'=>implode('',$tag),
				'tanggal'=>date('d/m',strtotime($tanggal2)).' s.d '.date('d/m',strtotime($tanggal2)),
				'nama'=>$row['nama'],
				'jumlah'=>$row['jumlah'],
				'satuan'=>$row['satuan'],
				'keterangan'=>null,
			);
		}
		$data['tambah']=$this->url.'add';
		$data['excel']=BASEURL.'Barangkeluar/excel?&excel=2'.$url;
		$data['bagian']=$this->GlobalModel->getData('bagian_pengambilan',array());
		if(isset($get['excel'])){
			if(!empty($bag)){
				$this->load->view($this->page.'excel',$data);
			}else{
				echo "<script>alert('bagian harus dipilih');location='".BASEURL.'Barangkeluar'."'</script>";
			}
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
		
	}

	public function add(){
		$data = [];
		$data['title']='Tambah Barang Keluar Harian';
		$data['bagian']=$this->GlobalModel->getData('bagian_pengambilan',array());
		$data['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
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
		$this->db->update('barangkeluarharian_detail',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect($this->url);
	}

	public function save()
	{
		$data = $this->input->post();
		//pre($data);
		$dataInserted = array(
			'tanggal'=>$data['tanggal'],
			'bagian'=>$data['bagian'],
			'pengambil'=>$data['pengambil'],
			'gudang'=>$data['gudang'],
			'hapus'=>0,
			'created_at'=>date('Y-m-d H:i:s'),
			'oleh'=>callSessUser('nama_user'),
		);
		$this->db->insert('barangkeluarharian',$dataInserted);
		$id=$this->db->insert_id();
		foreach($data['products'] as $p){
			$detail=array(
				'tanggal'=>$data['tanggal'],
				'idbarangkeluarharian'=>$id,
				'idpersediaan'=>$p['idpersediaan'],
				'nama'=>$p['nama'],
				'satuan'=>$p['satuan'],
				'jumlah'=>$p['jumlah'],
				'keterangan'=>$p['keterangan'],
				'hapus'=>0
			);
			$this->db->insert('barangkeluarharian_detail',$detail);
			$kartustok=array(
				'tanggal'=>$data['tanggal'],
				'idproduct'=>$p['idpersediaan'],
				'nama'=>$p['nama'],
				'saldomasuk_uk'=>0,
				'saldomasuk_qty'=>$p['jumlah'],
				'harga'=>$p['harga'],
				'keterangan'=>'Pengeluaran barang harian oleh '.$data['pengambil'],
			);
			kartustok($kartustok,2);
			$this->db->query("UPDATE product set quantity = quantity-'".$p['jumlah']."' WHERE product_id='".$p['idpersediaan']."' ");
			$this->db->query("UPDATE gudang_persediaan_item set jumlah_item = jumlah_item-'".$p['jumlah']."' WHERE id_persediaan='".$p['idpersediaan']."' ");
		}

		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect($this->url);
	}

}
