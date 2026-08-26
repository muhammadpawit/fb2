<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Verifikasibarangmasuk extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->auth = $this->session->userdata('id_user');
		if (empty($this->auth)) {
			redirect(BASEURL . 'login');
		}
	}

	private function _get_data($kategori)
	{
		// Cek keberadaan kolom status_penerimaan seperti di controller Gudang
		if (!$this->db->field_exists('status_penerimaan', 'pengajuan_harian_new_detail')) {
			$this->db->query("ALTER TABLE pengajuan_harian_new_detail ADD status_penerimaan TINYINT(1) NULL DEFAULT NULL COMMENT '0 belum diterima, 1 sudah diterima'");
			$this->db->query("UPDATE pengajuan_harian_new_detail SET status_penerimaan = 1 WHERE status_penerimaan IS NULL");
			$this->db->query("ALTER TABLE pengajuan_harian_new_detail MODIFY status_penerimaan TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0 belum diterima, 1 sudah diterima'");
		}

		$supplier_id = $this->input->get('supplier');
		$where_supplier = "";

		if (!empty($supplier_id)) {
			$supplier = $this->GlobalModel->getDataRow('master_supplier', array('id' => $supplier_id, 'hapus' => 0));
			if (!empty($supplier)) {
				$supplier_name = $this->db->escape(strtolower(trim($supplier['nama'])));
				$where_supplier = " AND (d.supplier_id = " . (int)$supplier_id . " OR LOWER(TRIM(d.supplier)) = {$supplier_name}) ";
			} else {
				return array();
			}
		}

		$sql = "
			SELECT
				d.id,
				d.idpengajuan,
				h.tanggal,
				d.nama_item,
				d.jumlah,
				d.satuan,
				d.harga,
				d.pembayaran,
				d.keterangan,
				d.supplier,
				p.product_id AS id_persediaan,
				p.warna_item,
				p.satuan_ukuran_item,
				p.satuan AS satuan_jumlah_item,
				p.harga_beli
			FROM pengajuan_harian_new_detail d
			JOIN pengajuan_harian_new h ON h.id = d.idpengajuan
			LEFT JOIN product p ON (p.product_id = d.product_id OR LOWER(TRIM(p.nama)) = LOWER(TRIM(d.nama_item))) AND p.hapus = 0
			WHERE h.hapus = 0
				AND d.hapus = 0
				AND h.status = 1
				AND h.kategori = " . (int)$kategori . "
				AND d.status_penerimaan = 0
				{$where_supplier}
			ORDER BY h.tanggal DESC, d.id DESC
		";

		return $this->GlobalModel->queryManual($sql);
	}

	public function konveksi()
	{
		$data = array();
		$data['title'] = 'Verifikasi Barang Masuk Konveksi';
		$data['kategori'] = 3;
		$data['prods'] = $this->_get_data(3);
		$data['karyawan'] = $this->GlobalModel->getData('karyawan', array('hapus' => 0, 'status_resign' => 1));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['sel_supplier'] = $this->input->get('supplier');
		$data['action'] = BASEURL . 'Verifikasibarangmasuk/konveksi';
		$data['page'] = 'newtheme/page/verifikasibarangmasuk/list';
		$this->load->view('newtheme/page/main', $data);
	}

	public function bordir()
	{
		$data = array();
		$data['title'] = 'Verifikasi Barang Masuk Bordir';
		$data['kategori'] = 2;
		$data['prods'] = $this->_get_data(2);
		$data['karyawan'] = $this->GlobalModel->getData('karyawan', array('hapus' => 0, 'status_resign' => 1));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['sel_supplier'] = $this->input->get('supplier');
		$data['action'] = BASEURL . 'Verifikasibarangmasuk/bordir';
		$data['page'] = 'newtheme/page/verifikasibarangmasuk/list';
		$this->load->view('newtheme/page/main', $data);
	}

	public function sukabumi()
	{
		$data = array();
		$data['title'] = 'Verifikasi Barang Masuk Sukabumi';
		$data['kategori'] = 4;
		$data['prods'] = $this->_get_data(4);
		$data['karyawan'] = $this->GlobalModel->getData('karyawan', array('hapus' => 0, 'status_resign' => 1));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['sel_supplier'] = $this->input->get('supplier');
		$data['action'] = BASEURL . 'Verifikasibarangmasuk/sukabumi';
		$data['page'] = 'newtheme/page/verifikasibarangmasuk/list';
		$this->load->view('newtheme/page/main', $data);
	}

	public function sablon()
	{
		$data = array();
		$data['title'] = 'Verifikasi Barang Masuk Sablon';
		$data['kategori'] = 1;
		$data['prods'] = $this->_get_data(1);
		$data['karyawan'] = $this->GlobalModel->getData('karyawan', array('hapus' => 0, 'status_resign' => 1));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['sel_supplier'] = $this->input->get('supplier');
		$data['action'] = BASEURL . 'Verifikasibarangmasuk/sablon';
		$data['page'] = 'newtheme/page/verifikasibarangmasuk/list';
		$this->load->view('newtheme/page/main', $data);
	}

	public function simpan()
	{
		$data = $this->input->post();
		if (isset($data['products'])) {
			if (!empty($data['products'])) {
				$tanggal_terima = isset($data['tanggal']) && !empty($data['tanggal']) ? $data['tanggal'] : date('Y-m-d');
				$nosj = isset($data['nosj']) && !empty($data['nosj']) ? $data['nosj'] : 'SJ-' . date('YmdHis');
				
				$it = array(
					'tanggal' => $tanggal_terima,
					'supplier' => $data['supplier'],
					'nosj' => $nosj,
					'keterangan' => 'Verifikasi Barang Masuk',
					'jenis' => $data['jenis'],
					'tipepembayaran' => $data['tipepembayaran'],
					'hapus' => 0
				);
				$this->db->insert('penerimaan_item', $it);
				$id = $this->db->insert_id();

				foreach ($data['products'] as $p) {
					$itd = array(
						'penerimaan_item_id' => $id,
						'id_persediaan' => $p['id_persediaan'],
						'id_pengajuan_detail' => isset($p['id_pengajuan_detail']) ? $p['id_pengajuan_detail'] : null,
						'id_karaywan' => isset($p['id_karaywan']) ? $p['id_karaywan'] : null,
						'nama_karyawan' => isset($p['nama_karyawan']) ? $p['nama_karyawan'] : null,
						'nama' => $p['nama'],
						'ukuran' => $p['ukuran'],
						'satuanukuran' => $p['satuanukuran'],
						'jumlah' => $p['jumlah'],
						'satuanJml' => $p['satuanJml'],
						'harga' => $p['harga'],
						'keterangan' => $p['keterangan'],
						'tanggal' => $tanggal_terima,
						'jenis' => $data['jenis'],
						'hapus' => 0
					);
					$this->db->insert('penerimaan_item_detail', $itd);
					if (!empty($p['id_pengajuan_detail'])) {
						$this->db->update('pengajuan_harian_new_detail', array('status_penerimaan' => 1), array('id' => $p['id_pengajuan_detail']));
					}
					
					$kartustok = array(
						'tanggal' => date('Y-m-d'),
						'idproduct' => $p['id_persediaan'],
						'nama' => $p['nama'],
						'saldomasuk_uk' => $p['ukuran'],
						'saldomasuk_qty' => $p['jumlah'],
						'harga' => $p['harga'],
						'keterangan' => 'Verifikasi Barang Masuk',
					);
					kartustok($kartustok, 1);
					$this->db->query("UPDATE product set ukuran_item=ukuran_item+" . $p['ukuran'] . ",quantity=quantity+'" . $p['jumlah'] . "', harga_beli='" . $p['harga'] . "' WHERE product_id='" . $p['id_persediaan'] . "' ");
					$this->db->query("UPDATE gudang_persediaan_item set ukuran_item=ukuran_item+" . $p['ukuran'] . ", jumlah_item=jumlah_item+'" . $p['jumlah'] . "' WHERE id_persediaan='" . $p['id_persediaan'] . "' ");
				}
				$this->session->set_flashdata('msg', 'Data verifikasi barang berhasil disimpan dan dimasukkan ke stok Gudang');
			}
		}
		
		$redirect_url = 'konveksi';
		if ($data['jenis'] == 2) {
			$redirect_url = 'bordir';
		} else if ($data['jenis'] == 4) {
			$redirect_url = 'sukabumi';
		} else if ($data['jenis'] == 1) {
			$redirect_url = 'sablon';
		}
		redirect(BASEURL . 'Verifikasibarangmasuk/' . $redirect_url . '?supplier=' . $data['supplier']);
	}
}
