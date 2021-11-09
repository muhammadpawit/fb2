<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alokasimingguan extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/kelolapo/';
	}


	public function index(){
		$data=[];
		$data['title']='Alokasi PO Mingguan';
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM alokasi_mingguan WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$data['products']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $result){
			$data['products'][]=array(
				'no'=>$no++,
				'tanggal'=>date('Y-m-d',strtotime($result['tanggal'])),
				'periode'=>$result['periode'],
				'keterangan'=>$result['keterangan'],
				'detail'=>BASEURL.'Alokasimingguan/view/'.$result['id'],
				'edit'=>BASEURL.'Alokasimingguan/edit/'.$result['id'],
				'hapus'=>BASEURL.'Alokasimingguan/hapusAll/'.$result['id'],
			);
		}
		$data['page']=$this->page.'alokasimingguan';
		$data['tambah']=BASEURL.'Alokasimingguan/add';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=[];
		$data['batal']=BASEURL.'Alokasimingguan';
		$data['action']=BASEURL.'Alokasimingguan/save';
		$data['po']=$this->GlobalModel->QueryManual("SELECT * FROM produksi_po WHERE kode_po NOT IN(SELECT kode_po FROM konveksi_buku_potongan) AND hapus=0 ");
		$data['page']=$this->page.'alokasimingguan_add';
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		if(isset($data['products'])){
			$insert=array(
				'tanggal'=>$data['tanggal'],
				'periode'	=>$data['periode'],
				'keterangan'	=>$data['keterangan'],
				'hapus'	=>0,
			);
			$this->db->insert('alokasi_mingguan',$insert);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$det=array(
					'idalokasi'=>$id,
					'po1'=>$p['po1'],
					'po2'=>$p['po2'],
					'jml_dz1'=>$p['jml_dz1'],
					'jml_dz2'	=>$p['jml_dz2'],
					'jumlah'	=>$p['jumlah'],
					'model'=>$p['model'],
					'keterangan'=>$p['keterangan'],
				);
				$this->db->insert('alokasi_mingguan_detail',$det);
			}
			$this->session->set_flashdata('msg','Data berhasil ditambah');
			redirect(BASEURL.'Alokasimingguan');
		}
	}

	public function view($id){
		$data=[];
		$data['title']="Alokasi Mingguan";
		$data['u']=$this->GlobalModel->GetdataRow('alokasi_mingguan',array('id'=>$id));
		$data['d']=$this->GlobalModel->Getdata('alokasi_mingguan_detail',array('idalokasi'=>$id));
		$data['batal']=BASEURL.'Alokasimingguan';
		$data['excel']=BASEURL.'Alokasimingguan/view/'.$id.'?&excel=true';
		
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'alokasimingguan_excel',$data);
		}else{
			$data['page']=$this->page.'alokasimingguan_view';
			$this->load->view($this->layout,$data);	
		}
		
	}

	public function edit($id){
		$data=[];
		$data['u']=$this->GlobalModel->GetdataRow('alokasi_mingguan',$id);
		$data['d']=$this->GlobalModel->GetdataRow('alokasi_mingguan_detail',$id);
		$data['batal']=BASEURL.'Alokasimingguan';
		$data['action']=BASEURL.'Alokasimingguan/editsave';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'alokasimingguan_excel',$data);
		}else{
			$data['page']=$this->page.'alokasimingguan_edit';
			$this->load->view($this->layout,$data);	
		}
	}

	public function editsave(){
		$data=$this->input->post();
		if(isset($data['products'])){
			$insert=array(
				'tanggal'=>$data['tanggal'],
				'periode'	=>$data['periode'],
				'keterangan'	=>$data['keterangan'],
				'hapus'	=>0,
			);
			$this->db->update('alokasi_mingguan',$insert,array('id'=>$data['id']));
			foreach($data['products'] as $p){
				$det=array(
					'po1'=>$p['po1'],
					'po2'=>$p['po2'],
					'jml_dz1'=>$p['jml_dz1'],
					'jml_dz2'	=>$p['jml_dz2'],
					'model'=>$p['model'],
					'keterangan'=>$p['keterangan'],
				);
				$this->db->update('alokasi_mingguan_detail',$det,array('id'=>$p['id']));
			}
			$this->session->set_flashdata('msg','Data berhasil diubah');
			redirect(BASEURL.'Alokasimingguan');
		}
	}

	public function hapusAll($id){
		$insert=array(
			'hapus'	=>1,
		);
		$this->db->update('alokasi_mingguan',$insert,array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Alokasimingguan');
	}

	public function hapusRinci($id){
		$insert=array(
			'hapus'	=>1,
		);
		$this->db->update('alokasi_mingguan_detail',$insert,array('id'=>$id));
		echo "ok";
	}
}