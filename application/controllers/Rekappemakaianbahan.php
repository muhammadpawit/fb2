<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekappemakaianbahan extends CI_Controller {

	public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/rekappemakaianalat/';
		$this->url=BASEURL.'Rekappemakaianbahan/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
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
		// Revert to IN for total count to avoid massive Cartesian join overhead
		$jumlah_data = $this->GlobalModel->QueryManualRow("SELECT COUNT(*) as total FROM gudang_persediaan_item WHERE hapus=0 AND nama_item IN(SELECT nama_item_keluar FROM gudang_bahan_keluar WHERE hapus=0)");
		
		$this->load->library('pagination');
		$config['base_url'] = BASEURL.'Rekappemakaianbahan?tanggal1='.$tanggal1.'&tanggal2='.$tanggal2.'&bag='.$bag;
		$config['total_rows'] = isset($jumlah_data['total']) ? $jumlah_data['total'] : 0;
		$config['per_page'] = 10;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		
		$config['full_tag_open'] = '<nav><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');

		// Prevent PHP 8.1+ deprecation warning in CI Pagination (ctype_digit null)
		if (!isset($_GET['page'])) {
			$_GET['page'] = 0;
		}

		$this->pagination->initialize($config);
		$from = $this->input->get('page') ? (int)$this->input->get('page') : 0;
		$data['pagination'] = $this->pagination->create_links();
		$data['no'] = $from + 1;

		// Revert to IN for the items query
		$sql="SELECT * FROM gudang_persediaan_item WHERE hapus=0 AND nama_item IN(SELECT nama_item_keluar FROM gudang_bahan_keluar WHERE hapus=0) ORDER BY nama_item LIMIT ".$config['per_page']." OFFSET ".$from;
		$results=$this->GlobalModel->QueryManual($sql);
		
		// Optimize: run query once instead of inside loop
		$po_list = $this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po WHERE status=1 ORDER BY nama_jenis_po ");
		
		$item_names = [];
		foreach($results as $row){
			$item_names[] = "'".$this->db->escape_str(strtolower($row['nama_item']))."'";
			$data['alat'][]=array(
				'id'=>$row['id_persediaan'],
				'nama'=>strtolower($row['nama_item']),
				'po'=>$po_list,
			);
		}

		$usage_map = [];
		// initialize map
		foreach($results as $row) {
			$item = strtolower($row['nama_item']);
			foreach($po_list as $po) {
				$usage_map[$item][$po['nama_jenis_po']] = ['yard' => 0, 'roll' => 0];
			}
		}

		if (!empty($item_names)) {
			$item_names_str = implode(",", $item_names);
			$sql_usage = "SELECT lower(nama_item_keluar) as item, kode_po, SUM(ukuran_item_keluar) as yard, SUM(jumlah_item_keluar) as roll FROM gudang_bahan_keluar WHERE hapus=0 ";
			if(!empty($tanggal1)){
				$sql_usage.="AND DATE(created_date) BETWEEN '$tanggal1' AND '$tanggal2'  ";
			}
			$sql_usage.=" AND lower(nama_item_keluar) IN ($item_names_str) ";
			$sql_usage .= " GROUP BY lower(nama_item_keluar), kode_po ";
			
			$usage_results = $this->GlobalModel->QueryManual($sql_usage);
			foreach($usage_results as $u) {
				$item = strtolower($u['item']);
				$kode_po = $u['kode_po'];
				foreach($po_list as $po) {
					$nama_po = $po['nama_jenis_po'];
					if(strpos($kode_po, $nama_po) === 0) { // similar to LIKE 'PO%'
						$usage_map[$item][$nama_po]['yard'] += $u['yard'];
						$usage_map[$item][$nama_po]['roll'] += $u['roll'];
					}
				}
			}
		}
		$data['usage_map'] = $usage_map;



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
