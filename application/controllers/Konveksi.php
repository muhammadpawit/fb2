<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konveksi extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function produksipo()
	{
		$results	=array();
		$data['po'] =array();
		$results	= $this->GlobalModel->queryManual('SELECT * FROM produksi_po prod_po JOIN proggresion_po prog ON prod_po.id_proggresion_po = prog.id_proggresion_po ');
		foreach($results as $result){
			$action=array();
			if($result['status']==0){
				$action[] = array(
					'text' => '<i class="fa fa-pencil"></i>&nbsp;Edit',
					'href' =>  BASEURL.'konveksi/produksipoedit/'.$result['kode_po'],
				);	
			}
			
			$action[] = array(
				'text' => '<i class="fa fa-eye"></i>&nbsp;Detail',
				'href' =>  BASEURL.'konveksi/produksipodetail/'.$result['kode_po'],
			);
			$data['po'][]=array(
				'id_produksi_po'=>$result['id_produksi_po'],
				'kode_po'=>$result['kode_po'],
				'nama_po'=>$result['nama_po'],
				'jenis_po'=>$result['jenis_po'],
				'kategori'=>$result['kategori_po'],
				'tanggal'=>date('d/m/Y',strtotime($result['created_date'])),
				'status'=>$result['status'],
				'nama_progress'=>$result['nama_progress'],
				'action'=>$action,
			);
		}
		
		$this->load->view('global/header');
		$this->load->view('konveksi/produksipo/produksi-po-view',$data);
		$this->load->view('global/footer');
	}

	public function tambahproduksipo()
	{
		$viewData['namaPO']	= $this->GlobalModel->getData('master_nama_po',null);
		$viewData['progress'] = $this->GlobalModel->getData('proggresion_po',null);
		$viewData['JenisPo'] = $this->GlobalModel->getData('master_jenis_po',null);
		$viewData['jenisKaos'] = $this->GlobalModel->getData('master_jenis_kaos',null);
		$this->load->view('global/header');
		$this->load->view('konveksi/produksipo/produksi-po-tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function produksipodetail($id='')
	{
		$viewData['prod'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$id));
		$this->load->view('global/header');
		$this->load->view('konveksi/produksipo/produksi-detail',$viewData);
		$this->load->view('global/footer');
	}
	public function produksipoedit($id='')
	{
		$viewData['prod'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$id));
		$this->load->view('global/header');
		$this->load->view('konveksi/produksipo/po_edit',$viewData);
		$this->load->view('global/footer');
	}
	public function editproduksipoOnCreate(){
		$post=$this->input->post();
		$dataInsert = array(
			'created_date'	=> $post['tanggalProd'],
			'kategori_po'	=> $post['kategoriPo'],
			'updated_date'=>date('Y-m-d'),
		);
		$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kodePO']),$dataInsert);
		$this->session->set_flashdata('msg','Data berhasil diubah');
		redirect(BASEURL.'konveksi/produksipo');
	}
	public function jenisPoKodeArtikel(){
		$get = $this->input->get();
		$viewData = $this->GlobalModel->getDataRow('master_jenis_po',array('nama_jenis_po' => $get['id']));
		echo json_encode($viewData);
	}

	public function tambahproduksipoOnCreate()
	{
		$post  = $this->input->post();
		$dataInsert = array(
			'kode_po'	=> $post['namaPO'].$post['kodePO'],
			'kategori_po'	=> $post['kategoriPo'],
			'nama_po'	=> $post['namaPO'],
			'kode_artikel'	=> $post['artikel'],
			//'id_proggresion_po'	=> $post['progress'],
			'id_proggresion_po'	=>1,
			'created_date'	=> $post['tanggalProd'],
			'jenis_po'	=> $post['jenisPo'],
			'status'=>0,
		);
		$this->GlobalModel->insertData('produksi_po',$dataInsert);
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'konveksi/produksipo');
	}

	public function searchItemBahanPo($value='')
	{
		$getId = $this->input->get('id');
		$data = $this->GlobalModel->getDataRow('gudang_bahan_keluar',array('id_item_keluar'=>$getId));
		echo json_encode($data);
	}

	public function demoPdf($value='')
	{
		$data = array(
        "dataku" => array(
            "nama" => "Petani Kode",
            "url" => "http://petanikode.com"
        )
    );

		$this->load->library('pdf');
		$this->pdf->folder(FCPATH.'assets/');
		$this->pdf->filename('save.pdf');
		$this->pdf->paper('A4', 'portrait');
        $this->pdf->html($this->load->view('laporan_pdf', $data, true));

 		$this->pdf->create();

	}

}