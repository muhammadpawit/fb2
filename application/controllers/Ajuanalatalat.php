<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajuanalatalat extends CI_Controller
{

	public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;
	public $ReportModel;
	public $upload;
	public $viewData;
	public $pdfgenerator;
	public $pagination;
	public $uri;
	public $pdf;
	public $data;
	public $bg_warning;
	public $bg_danger;
	public $bg_success;
	public $bg_info;
	public $AjuanalatModel;
	public $AlatsukabumiModel;

	function __construct()
	{
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout = 'newtheme/page/main';
		$this->page = 'newtheme/page/ajuanalatalat/';
		$this->url = BASEURL . 'Ajuanalatalat/';
		$this->load->model('AjuanalatModel');
		$this->login 		= BASEURL . 'login';
		$this->auth 	= $this->session->userdata('id_user');
		if (empty($this->auth)) {
			redirect($this->login);
		}
	}

	public function index($id)
	{
		$data = [];
		$data['title'] = "Ajuan ";
		$data['title'] .= $id == 1 ? 'Bordir' : 'Konveksi';
		$data['title'] .= ' Mingguan ';
		$get = $this->input->get();
		$url = '';
		$tanggalterakhir = $this->GlobalModel->QueryManualRow("SELECT tanggal from ajuanalatalat where tanggal <> '0000-00-00' order by id desc limit 1");
		if (isset($get['tanggal1'])) {
			$tanggal1 = $get['tanggal1'];
			$url .= '&tanggal1=' . $tanggal1;
		} else {
			$tanggal1 = $tanggalterakhir['tanggal'];
		}
		if (isset($get['tanggal2'])) {
			$tanggal2 = $get['tanggal2'];
			$url .= '&tanggal2=' . $tanggal2;
		} else {
			$tanggal2 = date('Y-m-d');
		}

		if (isset($get['spv'])) {
			$spv = $get['spv'];
			$url .= '&spv=' . $spv;
			$tanggal1 = $tanggalterakhir['tanggal'];
			$tanggal2 = date('Y-m-d');
		} else {
			$spv = null;
			$tanggal2 = date('Y-m-d');
		}

		$data['spv']	 = $spv;
		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		$filter = array(
			'tanggal1' => $tanggal1,
			'tanggal2' => $tanggal2,
			'bagian' => $id,
			'spv' => $spv,
		);
		$data['prods'] = $this->AjuanalatModel->getshow($filter);
		//pre($data['prods']);
		$data['acc']  = $this->url . 'acc';
		$data['id'] = $id;
		$data['type'] = $id;
		$data['prods_rincian'] = $this->AjuanalatModel->rincian($data['prods'], null);
		//pre($data['prods_rincian']);
		$data['tambah'] = $this->url . 'tambah' . '/' . $id;
		if (!isset($get['excel'])) {
			$data['page'] = $this->page . 'list';
			$this->load->view($this->layout, $data);
		} else {
			$this->load->view($this->page . 'excel', $data);
		}
	}

	function acc()
	{
		$post = $this->input->post();
		// pre($post);
		if (!isset($post['prods']) || empty($post['prods'])) {
			if ($this->input->is_ajax_request()) {
				echo json_encode(['success' => false, 'msg' => 'Data item tidak ditemukan.']);
				exit;
			}
			$this->session->set_flashdata('error', 'Data item tidak ditemukan');
			redirect($this->url . $post['bagian'] . '?&spv=true');
		}

		foreach ($post['prods'] as $p) {
			$update = array(
				'acc_ajuan' => (isset($p['acc_ajuan']) && $p['acc_ajuan'] !== '') ? $p['acc_ajuan'] : 0,
			);
			$where = array(
				'id' => $p['id']
			);
			$this->db->update('ajuanalatalat', $update, $where);
		}

		// masuk ke ajuan harian,
		// untuk kategori bagian : jika di ajuan bagian berisi : 
		$bagian = $post['bagian'];
		$cat = 0;
		if ($bagian == 1) {
			$cat = 2;
		} else if ($bagian == 2) {
			$cat = 3;
		} else {
			$cat = 1;
		}
		$cekajuan_harian = $this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE kategori='" . $cat . "' AND from_mingguan IS NOT NULL AND DATE(tanggal)='" . $post['tanggal'] . "' AND hapus=0 ");
		// pre($cekajuan_harian);
		if (empty($cekajuan_harian)) {
			$ip = array(
				'kategori' => $cat,
				'cash' => 0,
				'transfer' => 0,
				'status' => 1,
				'hapus' => 0,
				'tanggal' => date('Y-m-d', strtotime($post['tanggal'])),
				'keterangan' => '',
				'dibuat' => date('Y-m-d H:i:s'),
				'from_mingguan' => TRUE
			);
			$this->db->insert('pengajuan_harian_new', $ip);
			$id = $this->db->insert_id();
			$transfer = 0;
			$cash = 0;
			foreach ($post['prods'] as $p) {
				$item = $this->GlobalModel->GetDataRow('product', array('product_id' => $p['product_id']));
				$supplier = $this->GlobalModel->GetDataRow('master_supplier', array('id' => $p['supplier']));
				if ($p['pembayaran'] == 2) {
					$transfer += ($item['harga_beli'] * $p['acc_ajuan']);
				} else {
					$cash += ($item['harga_beli'] * $p['acc_ajuan']);
				}
				$rip = array(
					'idpengajuan' => $id,
					'nama_item' => $item['nama'],
					'jumlah' => (isset($p['acc_ajuan']) && $p['acc_ajuan'] !== '') ? $p['acc_ajuan'] : 0,
					'satuan' => $p['satuan'],
					'harga' => $item['harga_beli'],
					'pembayaran' => (isset($p['pembayaran']) && $p['pembayaran'] !== '') ? $p['pembayaran'] : null, // transfer & cash
					'supplier_id' => isset($supplier['id']) ? $supplier['id'] : (isset($p['supplier']) && $p['supplier'] !== '' ? $p['supplier'] : null),
					'supplier' => isset($supplier['nama']) ? $supplier['nama'] : null,
					'product_id' => isset($item['product_id']) ? $item['product_id'] : (isset($p['product_id']) && $p['product_id'] !== '' ? $p['product_id'] : null),
					'keterangan' => $p['keterangan'],
					'status' => 1,
					'id_from_mingguan' => $p['id']
				);
				$this->db->insert('pengajuan_harian_new_detail', $rip);
			}
			$this->db->update('pengajuan_harian_new', array('cash' => $cash, 'transfer' => $transfer), array('id' => $id));
		} else {
			$id = $cekajuan_harian['id'];
			$transfer = 0;
			$cash = 0;
			foreach ($post['prods'] as $p) {
				$item = $this->GlobalModel->GetDataRow('product', array('product_id' => $p['product_id']));
				$supplier = $this->GlobalModel->GetDataRow('master_supplier', array('id' => $p['supplier']));
				if ($p['pembayaran'] == 2) {
					$transfer += ($item['harga_beli'] * $p['acc_ajuan']);
				} else {
					$cash += ($item['harga_beli'] * $p['acc_ajuan']);
				}
				$rip = array(
					'idpengajuan' => $id,
					'nama_item' => $item['nama'],
					'jumlah' => (isset($p['acc_ajuan']) && $p['acc_ajuan'] !== '') ? $p['acc_ajuan'] : 0,
					'satuan' => $p['satuan'],
					'harga' => $item['harga_beli'],
					'pembayaran' => 2, // transfer
					'supplier_id' => isset($supplier['id']) ? $supplier['id'] : (isset($p['supplier']) && $p['supplier'] !== '' ? $p['supplier'] : null),
					'supplier' => isset($supplier['nama']) ? $supplier['nama'] : null,
					'product_id' => isset($item['product_id']) ? $item['product_id'] : (isset($p['product_id']) && $p['product_id'] !== '' ? $p['product_id'] : null),
					'keterangan' => $p['keterangan'],
					'id_from_mingguan' => $p['id'],
					'status' => 1
				);
				$this->db->insert('pengajuan_harian_new_detail', $rip);
			}
			$this->db->update('pengajuan_harian_new', array('cash' => $cash, 'transfer' => $transfer), array('id' => $id));
		}

		$image_data = $this->input->post('image_data');
		if (!empty($image_data)) {
			$this->db->update('pengajuan_harian_new', array('paraf' => $image_data), array('id' => $id));
		}

		if ($this->input->is_ajax_request()) {
			echo json_encode(['success' => true, 'msg' => 'Data Berhasil disimpan']);
			exit;
		}

		$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		redirect($this->url . $post['bagian'] . '?&spv=true');
	}

	public function tambah($id)
	{
		$data = [];
		$data['title'] = "Form Ajuan alat-alat ";
		$data['title'] .= $id == 1 ? 'Bordir' : 'Konveksi';
		$get = $this->input->get();
		$url = '';
		if (isset($get['tanggal1'])) {
			$tanggal1 = $get['tanggal1'];
			$url .= '&tanggal1=' . $tanggal1;
		} else {
			$tanggal1 = null;
		}
		if (isset($get['tanggal2'])) {
			$tanggal2 = $get['tanggal2'];
			$url .= '&tanggal2=' . $tanggal2;
		} else {
			$tanggal2 = null;
		}
		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		$filter = array(
			'tanggal1' => $tanggal1,
			'tanggal2' => $tanggal2,
		);
		$data['barang'] = $this->GlobalModel->QueryManual("SELECT * FROM gudang_persediaan_item WHERE hapus=0 AND id_persediaan IN (SELECT idpersediaan FROM barangkeluarharian_detail WHERE hapus=0 GROUP BY idpersediaan) ORDER BY nama_item ASC");
		$data['action'] = $this->url . 'save_ajuanalat';
		$data['cancel'] = $this->url . $id;
		$data['page'] = $this->page . 'tambah';
		$data['type'] = $id;
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', null);
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang', null);
		$data['products'] = $this->GlobalModel->getData('product', array('hapus' => 0));
		$this->load->view($this->layout, $data);
	}

	public function cari($id = '')
	{
		$tgl = $this->input->get('tgl');
		$getId = $this->input->get('id');
		//$data = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$getId));
		$sql = "SELECT * FROM barangkeluarharian_detail WHERE hapus=0 and idpersediaan='" . $getId . "' AND tanggal <='" . $tgl . "' ORDER BY tanggal DESC LIMIT 1 ";
		$data = $this->GlobalModel->QueryManualRow($sql);
		echo json_encode($data);
	}

	public function save()
	{
		$data = $this->input->post();
		//pre($data);
		$this->AlatsukabumiModel->insert($data);
		$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		redirect($this->url);
	}

	public function distribusi()
	{
		$data = [];
		$data['title'] = 'Pengiriman Alat-alat Di Sukabumi Ke CMT ';
		$get = $this->input->get();
		$url = '';
		if (isset($get['tanggal1'])) {
			$tanggal1 = $get['tanggal1'];
			$url .= '&tanggal1=' . $tanggal1;
		} else {
			$tanggal1 = null;
		}
		if (isset($get['tanggal2'])) {
			$tanggal2 = $get['tanggal2'];
			$url .= '&tanggal2=' . $tanggal2;
		} else {
			$tanggal2 = null;
		}
		if (isset($get['cmt'])) {
			$cmt = $get['cmt'];
			$url .= '&cmt=' . $cmt;
		} else {
			$cmt = null;
		}
		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		$data['selcmt'] = $cmt;
		$filter = array(
			'tanggal1' => $tanggal1,
			'tanggal2' => $tanggal2,
		);
		$data['prods'] = $this->AlatsukabumiModel->distribusi($filter);
		$data['action'] = $this->url . 'distribusi_save';
		$data['cmt']	= $this->GlobalModel->GetData('master_cmt', array('hapus' => 0, 'lokasi' => 3));
		$data['alat']	= $this->GlobalModel->GetData('stok_barang_skb', array('hapus' => 0));
		$data['page'] = $this->page . 'distribusi';
		$this->load->view($this->layout, $data);
	}

	public function distribusi_save()
	{
		$this->AlatsukabumiModel->distribusi_save();
		$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		redirect($this->url . 'distribusi');
	}

	public function cariproduct($id = '')
	{
		$getId = $this->input->get('id');
		$data = $this->GlobalModel->getDataRow('stok_barang_skb', array('id_persediaan' => $getId));
		echo json_encode($data);
	}

	public function distribusi_hapus($id)
	{
		$this->AlatsukabumiModel->distribusi_hapus($id);
	}

	public function distribusi_validasi($id)
	{
		$this->AlatsukabumiModel->distribusi_validasi($id);
	}

	function save_ajuanalat()
	{
		$data = $this->input->post();
		// pre($data);
		foreach ($data['utama'] as $p) {
			$ajuan = ($p['kebutuhan'] - $p['stok']);
			$insert = array(
				'id_persediaan' => $p['product_id'],
				'kebutuhan'		=> $p['kebutuhan'],
				'stok'			=> $p['stok'],
				'ajuan'			=> $ajuan,
				'tanggal'		=> $p['tanggal'],
				'keterangan'	=> $p['keterangan'],
				'bagian'		=> $data['bagian'],
				'supplier_id'	=> $p['supplier_id'],
				'pembayaran'	=> $p['pembayaran'],
				'hapus'			=> 0,
			);
			$this->db->insert('ajuanalatalat', $insert);
			$id = $this->db->insert_id();
			if (isset($data['products'])) {
				foreach ($data['products'] as $p) {
					$insert = array(
						'idajuan' => $id,
						'tanggal' => $data['tanggal'],
						'tanggal2' => $data['tanggal'],
						'kode_po' => $p['kode_po'],
						'jumlah_po' => $p['jumlah_po'],
						'rincian_po' => $p['rincian_po'],
						// 'jml_pcs'=>str_replace(",", ".", $p['jml_pcs']),
						// 'jml_dz'=>str_replace(",", ".", $p['jml_dz']),
						'jml_pcs' => $p['jml_pcs'],
						'jml_dz' => $p['jml_dz'],
						'keterangan' => $p['keterangan'],
						'hapus' => 0,
					);
					$this->db->insert('ajuanalatalat_detail', $insert);
				}
				// $this->db->update('ajuanalatalat',array('ajuan_kebutuhan'=>$totalajuan,'jml_ajuan'=>$totalajuan-$data['stok']),array('id'=>$id));
			}
		}


		$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		redirect($this->url . $data['bagian']);
	}

	public function cariproduct_stok($id = '')
	{
		$getId = $this->input->get('id');
		$type = $this->input->get('id');
		if ($type == 1) {
			$data = $this->GlobalModel->getDataRow('product', array('product_id' => $getId));
		} else {
			$data = $this->GlobalModel->getDataRow('product', array('product_id' => $getId));
		}

		echo json_encode($data);
	}

	public function cariproduct_stok_skb($id = '')
	{
		$getId = $this->input->get('id');
		$type = $this->input->get('id');
		if ($type == 1) {
			$data = $this->GlobalModel->getDataRow('stok_barang_skb', array('id_persediaan' => $getId));
		} else {
			$data = $this->GlobalModel->getDataRow('stok_barang_skb', array('id_persediaan' => $getId));
		}

		echo json_encode($data);
	}

	public function Ajuanalatalat_hapus($id)
	{
		$data = [];
		$this->db->update('ajuanalatalat', array('hapus' => 1), array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus');
		redirect($this->url . $data['bagian']);
	}

	public function Ajuanalatalat_edit($id)
	{
		$data = [];
		$data['title'] = "Ajuan alat-alat ";
		$data['title'] .= $id == 1 ? 'Bordir' : 'Konveksi';
		$data['prods'] = $this->AjuanalatModel->getshowId($id);
		$data['kd'] = $this->GlobalModel->getData('ajuanalatalat_detail', array('hapus' => 0, 'idajuan' => $id));
		$id_persediaan = $data['prods']['id_persediaan'];
		//pre($data['prods']);
		$data['prods_rincian'] = $this->AjuanalatModel->rincian($data['prods'], $id_persediaan);
		$data['id'] = $id;
		$data['type'] = $id;
		$data['barang'] = $this->GlobalModel->QueryManual("SELECT * FROM gudang_persediaan_item WHERE hapus=0 AND id_persediaan IN (SELECT idpersediaan FROM barangkeluarharian_detail WHERE hapus=0 GROUP BY idpersediaan) ORDER BY nama_item ASC");
		$data['action'] = $this->url . 'edit_ajuanalat';
		$get = $this->input->get();
		$url = '';
		if (isset($get['spv'])) {
			$url .= '?&spv=true';
		}
		$data['cancel'] = $this->url . $data['prods']['bagian'] . $url;

		if (!isset($get['excel'])) {
			$data['page'] = $this->page . 'edit';
			$this->load->view($this->layout, $data);
		} else {
			$this->load->view($this->page . 'excel', $data);
		}
	}

	public function edit_ajuanalat()
	{
		$post = $this->input->post();
		// pre($post);
		$update = array(
			'keterangan' 	=> $post['keterangan'],
			'ajuan'	 		=> $post['kebutuhan'] - $post['stok'],
			'tanggal'		=> $post['tanggal'],
		);
		$where = array(
			'id' => $post['id']
		);
		$this->db->update('ajuanalatalat', $update, $where);
		foreach ($post['details'] as $d) {
			$updateD = array(
				'kode_po' => $d['kode_po'],
				'jumlah_po' => $d['jumlah_po'],
				'rincian_po' => $d['rincian_po'],
				'jml_pcs' => $d['jml_pcs'],
				'jml_dz' => $d['jml_dz'],
				'keterangan' => $d['keterangan'],
			);
			$this->db->update('ajuanalatalat_detail', $updateD, array('id' => $d['id']));
		}
		$this->session->set_flashdata('msg', 'Data berhasil diubah');
		redirect($this->url . $post['bagian']);
	}
}
