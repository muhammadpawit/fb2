<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Gajisablon extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->url=BASEURL.'Gajisablon/';
		$this->login 		= BASEURL.'login';
		$this->load->model('GajiSablonModel');
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function harian(){
		$data=[];
		$data['title'] = 'Gaji Sablon Harian ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['id_karyawan_harian'])){
			$id_karyawan_harian=$get['id_karyawan_harian'];
		}else{
			$id_karyawan_harian=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['kar']=$this->GlobalModel->GetData('karyawan_harian',array('hapus'=>0,'bagian'=>'Sablon Harian'));
		$data['kartustok']=[];
		$data['tambah']=$this->url.'add';
		$data['prods']=[];
		$sql		  =" SELECT a.*, b.nama, d.*  FROM gaji_sablon_harian a LEFT JOIN karyawan_harian b ON b.id=a.id_karyawan_harian ";
		$sql		  .=" JOIN gaji_sablon_harian c ON c.id";
		$sql 		  .= " LEFT JOIN gaji_sablon_harian_detail d ON d.idgaji=a.id ";
		$sql 		  .=" WHERE a.hapus=0 AND b.hapus=0 ";
		if(!empty($id_karyawan_harian)){
			$sql.=" AND a.id_karyawan_harian='".$id_karyawan_harian."' ";
		}
		$sql 		  .=" GROUP BY id_karyawan_harian, periode ";
		$data['prods']=$this->GlobalModel->QueryManual($sql);
		// pre($data['prods']);
		if(isset($get['excel'])){
			$this->load->view('gudang/gajisablon/harianexcel',$data);
		}else{
			$data['page']='gudang/gajisablon/harian';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	public function hariandetail($id){
		$data=[];
		$data['title'] = 'Gaji Sablon Harian ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['kartustok']=[];
		$data['tambah']=$this->url.'add';
		$data['prods']=[];
		$sql		  =" SELECT a.*, b.nama  FROM gaji_sablon_harian a LEFT JOIN karyawan_harian b ON b.id=a.id_karyawan_harian ";
		$sql 		  .=" WHERE a.hapus=0 AND b.hapus=0 ";
		$data['prods']=$this->GlobalModel->QueryManual($sql);

		if(isset($get['excel'])){
			$this->load->view('newtheme/page/main/gudang/persediaan/kartustok_excel',$data);
		}else{
			$data['page']='gudang/gajisablon/hariandetail';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	public function add(){
		$data=[];
		$data['title'] = 'Form Gaji Sablon Harian ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['prods']=[];
		$data['action']=$this->url.'save';
		$data['cancel']=$this->url.'harian';
		$data['kar']=$this->GlobalModel->GetData('karyawan_harian',array('hapus'=>0,'bagian'=>'Sablon Harian'));
		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/kartustok_excel',$data);
		}else{
			$data['page']='gudang/gajisablon/harian_form';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	public function cari($id='')
	{
		$getId = $this->input->get('id');
		
		$data = $this->GlobalModel->QueryManualRow(
			"SELECT * FROM karyawan_harian WHERE hapus=0 AND id='".$getId."' "
		);
		echo json_encode($data);
	}

	function save(){
		$post = $this->input->post();
		$insert = array(
			'periode' 				=> $post['periode'],
			'id_karyawan_harian'	=> $post['id_karyawan_harian'],
			'gajiperhari'			=> $post['gaji'],
			'hapus'					=> 0,
		);
		$this->db->insert('gaji_sablon_harian',$insert);
		$id=$this->db->insert_id();
		$insert_detail = array(
			'idgaji'	=> $id,
			'senin'		=> $post['senin'],
			'selasa'	=> $post['selasa'],
			'rabu'		=> $post['rabu'],
			'kamis'		=> $post['kamis'],
			'jumat'		=> $post['jumat'],
			'sabtu'		=> $post['sabtu'],
		);
		$this->db->insert('gaji_sablon_harian_detail',$insert_detail);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url.'harian');
	}

	function hapusharian($id){
		$post = $this->input->post();
		$insert = array(
			'hapus'					=> 1,
		);
		$this->db->update('gaji_sablon_harian',$insert,array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect($this->url.'harian');
	}

	public function brongan(){
		$data=[];
		$data['title'] = 'Gaji Sablon Borongan ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['namatim'])){
			$namatim=$get['namatim'];
		}else{
			$namatim=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['namatim']=$namatim;
		$data['kar']=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE LOWER(bagian) LIKE '%tukang cetak%' ");
		$data['kartustok']=[];
		$data['tambah']=$this->url.'addborongan';
		$filter = array(
			'tanggal1' => $tanggal1,
			'tanggal2' => $tanggal2,
			'namatim' => $namatim,
		);
		$data['prods'] = $this->GajiSablonModel->get($filter);
		// pre($data['prods']);
		if(isset($get['excel'])){
			$this->load->view('gudang/gajisablon/boronganexcel',$data);
		}else{
			$data['page']='gudang/gajisablon/borongan';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	public function addborongan(){
		$data=[];
		$data['title'] = 'Form Gaji Sablon Borongan ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['prods']=[];
		$data['action']=$this->url.'save_borongan';
		$data['cancel']=$this->url.'brongan';
		$po	= $this->GlobalModel->QueryManual('SELECT id_produksi_po, kode_po FROM produksi_po WHERE hapus=0 ');
		$data['cmt']	= $this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE hapus=0 and cmt_job_desk='Sablon' ");
		$poluar	= $this->GlobalModel->QueryManual('SELECT id as id_produksi_po, nama as kode_po FROM master_po_luar WHERE hapus=0 ');
		$data['po']=array_merge($po,$poluar);
		// pre($data['po']);
		$data['poluar'] = 
		$data['kar']=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE LOWER(bagian) LIKE '%tukang cetak%' ");
		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/kartustok_excel',$data);
		}else{
			$data['page']='gudang/gajisablon/borongan_form';
		$this->load->view('newtheme/page/main',$data);
		}
	}

	function save_borongan(){
		$post = $this->input->post();
		// pre($post);
		foreach($post['prods'] as $p){
			$insert = array(
				'tanggal' 	=> $post['tanggal'],
				'idcmt' 	=> $post['idcmt'],
				'namatim' 	=> $post['id_karyawan_harian'],
				'idpo' 		=> $p['kodepo'],
				'gambar' 	=> $p['gambar'],
				'model' 	=> $p['model'],
				'dz' 		=> $p['lusin'],
				'putaran' 	=> $p['putaran'],
				'harga' 	=> $p['harga'],
				'total' 	=> ($p['lusin']*$p['putaran']*$p['harga']),
				'hapus'		=> 0,
			);
			$this->db->insert('gaji_sablon_borongan',$insert);
		}
		
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->url.'brongan');
	}

	function hapusborongan($id){
		$post = $this->input->post();
		$insert = array(
			'hapus'		=> 1,
		);
		$this->db->update('gaji_sablon_borongan',$insert,array('id'=>$id));
		
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect($this->url.'brongan');
	}

}