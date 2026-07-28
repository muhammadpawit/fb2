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
		$data['prods'] = $this->_get_data(3);
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
		$data['prods'] = $this->_get_data(2);
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['sel_supplier'] = $this->input->get('supplier');
		$data['action'] = BASEURL . 'Verifikasibarangmasuk/bordir';
		$data['page'] = 'newtheme/page/verifikasibarangmasuk/list';
		$this->load->view('newtheme/page/main', $data);
	}
}
