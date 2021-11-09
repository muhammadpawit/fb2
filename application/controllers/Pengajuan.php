<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
	}


	public function pangajuancalculator()
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
		$this->load->view('global/header');
		$this->load->view('gudang/pengajuan/pengajuan-calculator',$viewData);
		$this->load->view('global/footer');
	}

	public function pangajuancalculatorOnCreate()
	{
		$post = $this->input->post();

		$viewData['pengajuan'] = calculatorPengajuanKDO($post['jenisPo'],$post['jmlLusin']);
		
		$this->load->view('global/header');
		$this->load->view('gudang/pengajuan/pengajuan-calculator-show',$viewData);
		$this->load->view('global/footer');
	}

	public function pengajuanbarang()
	{
		$viewData['item'] = $this->GlobalModel->queryManual('SELECT DISTINCT kode_pengajuan,created_date FROM gudang_pengajuan_item');
		$this->load->view('global/header');
		$this->load->view('gudang/pengajuan/pengajuan-barang',$viewData);
		$this->load->view('global/footer');
	}
	public function pengajuanbarangTambah()
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
		$this->load->view('global/header');
		$this->load->view('gudang/pengajuan/pengajuan-barang-tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function pengajuanitemOnPrint()
	{
		$post = $this->input->post();
		$viewData['post'] = $post;
		$this->load->view('global/header');
		$this->load->view('gudang/pengajuan/pengajuan-alat-barang',$viewData);
		$this->load->view('global/footer');
	}

	public function pengajuanitemOnCreate()
	{
			$post = $this->input->post();
		foreach ($post['id'] as $key => $nama) {
			$dataInsertPersediaan = array(
				'nama_barang_pengajuan'			=>	$post['namaBarang'][$key],
				'nama_po_pengajuan'				=>	$post['namaPo'][$key],
				'jumlah_po_pengajuan'			=>	$post['perPo'][$key],
				'kebutuhan_po_pengajuan'		=>	$post['kebutuhan'][$key],
				'stok_item_pengajuan'			=>	$post['stok'][$key],
				'satuan_jumlah_pengajuan'		=>	$post['satuanJml'][$key],
				'item_pengajuan'				=>	$post['ajuan'][$key],
				'keterangan_pengajuan'			=>	$post['keterangan'][$key],
				'created_date'					=>	$post['date'][$key],
				'id_persediaan'					=>	$nama,
				'kode_pengajuan'				=>	$post['kodeTF']
			);
			
			$this->GlobalModel->insertData('gudang_pengajuan_item',$dataInsertPersediaan);
		}
		
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'pengajuan/pengajuanbarang');
	}

	public function pengajuanitemDetail()
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_pengajuan_item',null);
		$this->load->view('global/header');
		$this->load->view('gudang/pengajuan/pengajuan-detail',$viewData);
		$this->load->view('global/footer');
	}

	
}
