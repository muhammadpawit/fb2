<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjuanKemejaModel extends CI_Model {

    // Fungsi untuk mengambil semua data
    public function get_all($data) {
        
        // Mulai query dengan LEFT JOIN
        $this->db->select('ajuan_kemeja_baru.*, product.nama AS nama_produk'); // Pilih semua kolom dari ajuan_kemeja_baru dan kolom nama dari product
        $this->db->from('ajuan_kemeja_baru');
        $this->db->join('product', 'product.product_id = ajuan_kemeja_baru.nama_barang', 'left'); // LEFT JOIN tabel product dengan ajuan_kemeja_baru

        // Cek apakah tanggal1 dan tanggal2 ada dalam array $data
        if (!empty($data['tanggal1']) && !empty($data['tanggal2'])) {
            $this->db->where('DATE(ajuan_kemeja_baru.tanggal) >=', $data['tanggal1']); // Sesuaikan dengan kolom tanggal di tabel ajuan_kemeja_baru
            $this->db->where('DATE(ajuan_kemeja_baru.tanggal) <=', $data['tanggal2']);
        }

        $this->db->where('ajuan_kemeja_baru.hapus',0);

        // Eksekusi query dan kembalikan hasilnya
        return $this->db->get()->result_array();
        
    }

    // Fungsi untuk mengambil data berdasarkan ID
    public function get_by_id($id) {
        return $this->db->get_where('ajuan_kemeja_baru', ['id' => $id])->row();
    }

    // Fungsi untuk menambahkan data baru
    public function insert($data) {
        return $this->db->insert('ajuan_kemeja_baru', $data);
    }

    // Fungsi untuk mengupdate data berdasarkan ID
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('ajuan_kemeja_baru', $data);
    }

    // Fungsi untuk menghapus data berdasarkan ID
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->update('ajuan_kemeja_baru',array('hapus'=>1));
    }
}
