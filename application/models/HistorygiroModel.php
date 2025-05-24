<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HistorygiroModel extends CI_Model {

    private $table = 'supplier_giro'; // Sesuaikan dengan nama tabel Anda

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Ambil semua data pembelian
     * @return array
     */
    public function get_all() {
        $this->db->order_by('tanggal', 'desc');
        return $this->db->get($this->table)->result();
    }

    /**
     * Ambil data pembelian berdasarkan ID
     * @param int $id
     * @return object
     */
    public function get_by_id($id) {
    $this->db->select('supplier_giro.*, master_supplier.nama as namasupplier, master_supplier.alamat, master_supplier.telephone');
    $this->db->from($this->table);
    $this->db->join('master_supplier', 'supplier_giro.supplier_id = master_supplier.id', 'left');
    $this->db->where('supplier_giro.id', $id);
    return $this->db->get()->row();
}

    /**
     * Simpan data pembelian baru
     * @param array $data
     * @return int ID data yang baru disimpan
     */
    public function save($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update data pembelian
     * @param array $where
     * @param array $data
     * @return bool
     */
    public function update($where, $data) {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    /**
     * Hapus data pembelian
     * @param int $id
     * @return bool
     */
    public function delete_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Hitung total jumlah pembelian
     * @return float
     */
    public function get_total_pembelian() {
        $this->db->select_sum('jumlah');
        $result = $this->db->get($this->table)->row();
        return $result->jumlah ?? 0;
    }

    /**
     * Ambil data pembelian dengan pagination
     * @param int $limit
     * @param int $start
     * @return array
     */
    public function get_pembelian_paginated($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->order_by('tanggal', 'desc');
        return $this->db->get($this->table)->result();
    }

    /**
     * Hitung total records untuk pagination
     * @return int
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
}