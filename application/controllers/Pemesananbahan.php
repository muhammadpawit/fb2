<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Pemesananbahan extends CI_Controller
{
	public $login;
	public $auth;

	function __construct()
	{
		parent::__construct();
		$this->login = BASEURL . 'login';
		$this->auth = $this->session->userdata('id_user');
		if (empty($this->auth)) {
			redirect($this->login);
		}
	}

	public function index()
	{
		$data = array();
		$data['title'] = 'Daftar Pemesanan Bahan';
		$data['url'] = BASEURL . 'Pemesananbahan';
		$data['tambah'] = BASEURL . 'Pemesananbahan/tambah';
		
		$get = $this->input->get();
		if (isset($get['tanggal1'])) {
			$tanggal1 = $get['tanggal1'];
		} else {
			$tanggal1 = date('Y-m-d', strtotime("-7 days"));
		}
		if (isset($get['tanggal2'])) {
			$tanggal2 = $get['tanggal2'];
		} else {
			$tanggal2 = date('Y-m-d');
		}
		if (isset($get['cat'])) {
			$cat = $get['cat'];
		} else {
			$cat = null;
		}
		if (isset($get['supplier'])) {
			$sups = $get['supplier'];
		} else {
			$sups = null;
		}
		if (isset($get['status_pembayaran'])) {
			$status_pembayaran = $get['status_pembayaran'];
		} else {
			$status_pembayaran = null;
		}
		if (isset($get['tipepembayaran'])) {
			$tipepembayaran = $get['tipepembayaran'];
		} else {
			$tipepembayaran = null;
		}

		$sql = 'SELECT * FROM pemesanan_bahan WHERE hapus=0 ';

		if (!empty($tanggal1)) {
			$sql .= " AND date(tanggal) BETWEEN '" . $tanggal1 . "' AND '" . $tanggal2 . "' ";
		}
		if (!empty($cat) && $cat != '*') {
			$sql .= " AND jenis='" . $cat . "' ";
		}
		if (!empty($sups) && $sups != '*') {
			$sql .= " AND supplier='" . $sups . "' ";
		}
		if (!empty($status_pembayaran) && $status_pembayaran != '*') {
			$sql .= " AND status_pembayaran='" . $status_pembayaran . "' ";
		}
		if (!empty($tipepembayaran) && $tipepembayaran != '*') {
			$sql .= " AND tipepembayaran='" . $tipepembayaran . "' ";
		}

		$sql .= " ORDER BY id DESC";
		$results = $this->GlobalModel->queryManual($sql);
		
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['n'] = 1;
		$data['items'] = array();
		
		foreach ($results as $result) {
			$action = array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL . 'Pemesananbahan/detail/' . $result['id'],
			);

			$supplier = $this->GlobalModel->getDataRow('master_supplier', array('id' => $result['supplier']));
			$products = $this->GlobalModel->getData('pemesanan_bahan_detail', array('hapus' => 0, 'pemesanan_bahan_id' => $result['id']));
			
			$data['items'][] = array(
				'id' => $result['id'],
				'tanggal' => date('d-m-Y', strtotime($result['tanggal'])),
				'nosj' => $result['nosj'],
				'keterangan' => $result['keterangan'],
				'supplier' => empty($supplier) ? '' : $supplier['nama'],
				'supplier_id' => $result['supplier'],
				'jenis' => $result['jenis'],
				'tipepembayaran' => $result['tipepembayaran'],
				'action' => $action,
				'prods' => $products,
			);
		}
		
		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		$data['cat'] = $cat;
		$data['suppliers_id'] = $sups;
		$data['status_pembayaran'] = $status_pembayaran;
		$data['tipepembayaran'] = $tipepembayaran;

		$data['page'] = 'pemesananbahan/list';
		$this->load->view('newtheme/page/main', $data);
	}

	public function tambah()
	{
		$data = array();
		$data['title'] = 'Form Pemesanan Bahan';
		$data['url'] = BASEURL . 'Pemesananbahan';
		$data['action'] = BASEURL . 'Pemesananbahan/simpan';
		
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['karyawan'] = $this->GlobalModel->getData('karyawan', array('hapus' => 0, 'status_resign' => 1));
		$data['barang'] = $this->GlobalModel->getData('gudang_persediaan_item', array('hapus' => 0));

		$data['page'] = 'pemesananbahan/form';
		$this->load->view('newtheme/page/main', $data);
	}

	public function simpan()
	{
		$data = $this->input->post();
		if (isset($data['products']) && !empty($data['products'])) {
			$it = array(
				'tanggal' => isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d'),
				'supplier' => $data['supplier'],
				'nosj' => $data['nosj'],
				'keterangan' => isset($data['keterangan']) ? $data['keterangan'] : '-',
				'jenis' => $data['jenis'],
				'tipepembayaran' => $data['tipepembayaran'],
				'hapus' => 0
			);
			$this->db->insert('pemesanan_bahan', $it);
			$id = $this->db->insert_id();

			if (isset($_FILES['lampiran']['name']) && !empty($_FILES['lampiran']['name'])) {
				$config['upload_path'] = './uploads/lampiran/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$this->load->library('upload', $config);
				
				if (!file_exists($config['upload_path'])) {
					mkdir($config['upload_path'], 0777, true);
				}

				if ($this->upload->do_upload('lampiran')) {
					$upload_data = $this->upload->data();
					$fileName = $config['upload_path'] . $upload_data['file_name'];
					$fileType = $upload_data['file_type'];

					if ($fileType == 'image/jpeg' || $fileType == 'image/jpg') {
						$compressedFileName = $fileName . '_compressed.jpg';
						$source = imagecreatefromjpeg($fileName);
						imagejpeg($source, $compressedFileName, 75);
						imagedestroy($source);
						unlink($fileName);
						$fileName = $compressedFileName;
					}

					$this->db->update('pemesanan_bahan', array('lampiran' => $fileName), array('id' => $id));
				}
			}

			foreach ($data['products'] as $p) {
				$detail = array(
					'pemesanan_bahan_id' => $id,
					'id_persediaan' => isset($p['id_persediaan']) ? $p['id_persediaan'] : null,
					'nama' => $p['nama'],
					'ukuran' => isset($p['ukuran']) ? $p['ukuran'] : null,
					'satuanukuran' => isset($p['satuanukuran']) ? $p['satuanukuran'] : null,
					'satuanJml' => isset($p['satuanJml']) ? $p['satuanJml'] : null,
					'jumlah' => $p['jumlah'],
					'harga' => $p['harga'],
					'keterangan' => isset($p['keterangan']) ? $p['keterangan'] : '',
					'tanggal' => $it['tanggal'],
					'jenis' => $it['jenis'],
					'id_karaywan' => isset($p['id_karaywan']) ? $p['id_karaywan'] : null,
					'nama_karyawan' => isset($p['nama_karyawan']) ? $p['nama_karyawan'] : null,
					'hapus' => 0
				);
				$this->db->insert('pemesanan_bahan_detail', $detail);
			}

			$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		} else {
			$this->session->set_flashdata('gagal', 'Item pemesanan kosong');
		}
		redirect(BASEURL . 'Pemesananbahan');
	}

	public function detail($id)
	{
		$data = array();
		$data['title'] = 'Detail Pemesanan Bahan';
		$data['url'] = BASEURL . 'Pemesananbahan';

		$this->db->select('pemesanan_bahan.*, master_supplier.nama as nama_supplier');
		$this->db->from('pemesanan_bahan');
		$this->db->join('master_supplier', 'master_supplier.id = pemesanan_bahan.supplier', 'left');
		$this->db->where('pemesanan_bahan.id', $id);
		$data['results'] = $this->db->get()->row_array();

		$this->db->where('pemesanan_bahan_id', $id);
		$this->db->where('hapus', 0);
		$data['products'] = $this->db->get('pemesanan_bahan_detail')->result_array();

		$data['page'] = 'pemesananbahan/detail';
		$this->load->view('newtheme/page/main', $data);
	}

	public function hapus($id)
	{
		$this->db->update('pemesanan_bahan', array('hapus' => 1), array('id' => $id));
		$this->db->update('pemesanan_bahan_detail', array('hapus' => 1), array('pemesanan_bahan_id' => $id));
		
		$this->session->set_flashdata('msg', 'Data berhasil dihapus');
		redirect(BASEURL . 'Pemesananbahan');
	}

	public function batal_terima($pemesanan_detail_id)
	{
		// Cari penerimaan_item_detail yang terkait
		$penerimaan = $this->db->get_where('penerimaan_item_detail', array('id_pengajuan_detail' => $pemesanan_detail_id, 'hapus' => 0))->row_array();
		if ($penerimaan) {
			// Panggil metode hapus penerimaan di Gudang.php, atau jalankan logic-nya di sini
			$id = $penerimaan['id'];
			
			$kartustok = array(
				'tanggal' => date('Y-m-d H:i:s'),
				'idproduct' => $penerimaan['id_persediaan'],
				'nama' => $penerimaan['nama'],
				'saldomasuk_uk' => $penerimaan['ukuran'],
				'saldomasuk_qty' => $penerimaan['jumlah'],
				'harga' => 0,
				'keterangan' => 'Pembatalan Penerimaan item masuk oleh ' . callSessUser('nama_user'),
			);
			kartustok($kartustok, 2);
			$this->db->query("UPDATE product set ukuran_item =ukuran_item-'" . $penerimaan['ukuran'] . "', quantity = quantity-'" . $penerimaan['jumlah'] . "' WHERE product_id='" . $penerimaan['id_persediaan'] . "' ");
			$this->db->query("UPDATE gudang_persediaan_item set ukuran_item =ukuran_item-'" . $penerimaan['ukuran'] . "', jumlah_item = jumlah_item-'" . $penerimaan['jumlah'] . "' WHERE id_persediaan='" . $penerimaan['id_persediaan'] . "' ");
			
			$this->db->update('pemesanan_bahan_detail', array('status_penerimaan' => 0), array('id' => $pemesanan_detail_id));
			$this->db->update('penerimaan_item_detail', array('hapus' => 1), array('id' => $id));

			// Batalin ke invoice utang usaha
			$invoice_detail = $this->db->get_where('acc_pembelian_detail', ['id_penerimaan_detail' => $id])->row_array();
			if ($invoice_detail) {
				$this->db->query("UPDATE acc_pembelian SET total = total - " . $invoice_detail['nominal'] . " WHERE id = " . $invoice_detail['id_pembelian']);
				$this->db->where('id_penerimaan_detail', $id);
				$this->db->delete('acc_pembelian_detail');
			}

			user_activity(callSessUser('id_user'), 1, ' membatalkan penerimaan dengan id ' . $id);
			$this->session->set_flashdata('msg', 'Penerimaan Berhasil Dibatalkan');
		} else {
			$this->session->set_flashdata('gagal', 'Data penerimaan tidak ditemukan.');
		}
		
		redirect(BASEURL . 'Pemesananbahan');
	}
}
