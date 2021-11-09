<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Alokasi extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

	}

	public function alokasiview()
	{
		$viewData['alokasi'] = $this->GlobalModel->queryManual('SELECT * FROM alokasi al JOIN master_size ms ON al.id_master_size=ms.id_master_size');

		$this->load->view('global/header');
		$this->load->view('gudang/alokasi/view',$viewData);
		$this->load->view('global/footer');
	}

	public function tambahalokasi()
	{
		$viewData['size'] = $this->GlobalModel->getData('master_size',null);
		$viewData['namaPo'] = $this->GlobalModel->getData('master_jenis_po',null);

		$this->load->view('global/header');
		$this->load->view('gudang/alokasi/tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function tambahalokasiAct()
	{
		$post = $this->input->post();

		$dataInserted = array(
			'nama_jenis_po'	=> $post['namaPo'],
			'id_master_size'	=>	$post['size']
		);

		$this->GlobalModel->insertData('alokasi',$dataInserted);
		redirect(BASEURL.'alokasi/alokasiview');
	}

	public function deleteAlokasi($id='')
	{
		$this->GlobalModel->deleteData('alokasi',array('id_alokasi'=>$id));
		redirect(BASEURL.'alokasi/alokasiview');
	}

	public function editAlokasi($id='')
	{
		$viewData['alokasi'] = $this->GlobalModel->getDataRow('alokasi',array('id_alokasi'=>$id));
		$viewData['size'] = $this->GlobalModel->getData('master_size',null);
		$viewData['namaPo'] = $this->GlobalModel->getData('master_jenis_po',null);

			// pre($viewData);
		$this->load->view('global/header');
		$this->load->view('gudang/alokasi/edit',$viewData);
		$this->load->view('global/footer');
	}

	public function editAlokasiAct($id='')
	{
		$post = $this->input->post();

		$dataInserted = array(
			'nama_jenis_po'	=> $post['namaPo'],
			'id_master_size'	=>	$post['size']
		);

		$this->GlobalModel->updateData('alokasi',array('id_alokasi'=>$id),$dataInserted);
		redirect(BASEURL.'alokasi/alokasiview');
	}

	public function insertAlokasiItem($id='')
	{
		$viewData['po'] = $this->GlobalModel->queryManualRow('SELECT * FROM alokasi al JOIN master_size sz ON al.id_master_size=sz.id_master_size WHERE al.id_alokasi="'.$id.'"');
		$viewData['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
			// pre($viewData);
		$this->load->view('global/header');
		$this->load->view('gudang/alokasi/insert-alokasi-item',$viewData);
		$this->load->view('global/footer');
	}

	public function insertAlokasiItemAct($value='')
	{
		$post = $this->input->post();

		foreach ($post['idPersediaan'] as $key => $idPersediaan) {
			$dataInserted = array(
				'id_persediaan'	=> $idPersediaan,
				'qty_alokasi_po'	=>	$post['jumlah'][$key],
				'id_alokasi'	=> $post['idalokasi'],
				'satuan_alokasi'		=>	$post['satuanJml'][$key]
			);

			$this->GlobalModel->insertData('alokasi_item',$dataInserted);
		}

		redirect(BASEURL.'alokasi/alokasiview');
	}

	public function kalkulasiAlokasi($id='')
	{
		$get = $this->input->get();
		$viewData['itemKalkulasi']	=	$this->GlobalModel->queryManual('SELECT * FROM alokasi_item ai JOIN gudang_persediaan_item gpi ON ai.id_persediaan=gpi.id_persediaan WHERE ai.id_alokasi="'.$id.'"');
		// pre($viewData);
		$viewData['alokasi'] = $this->GlobalModel->queryManualRow('SELECT * FROM alokasi al JOIN master_size ms ON al.id_master_size=ms.id_master_size WHERE al.id_alokasi="'.$id.'"');
		if (!empty($get)) {
			$viewData['lusin'] = $get['lusin'];
		} else {
			$viewData['lusin'] = "";
		}
		$this->load->view('global/header');
		$this->load->view('gudang/alokasi/kalkulasi-alokasi',$viewData);
		$this->load->view('global/footer');
	}
}
