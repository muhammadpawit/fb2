<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// application/models/BiayaHppPerpoModel.php
defined('BASEPATH') OR exit('No direct script access allowed');

class BiayaHppPerpoModel extends CI_Model {
    protected $table = 'biaya_hpp_perpo';

    public function getData() {
        $hasil = [];
		$sql = "SELECT a.*, p.kode_po, c.nama_biaya FROM biaya_hpp_perpodetail a
			JOIN produksi_po p ON p.id_produksi_po=a.idpo
			JOIN biaya_hpp_perpo c ON c.id=a.idbiayapo
		 WHERE a.hapus=0 ";
		 $hasil = $this->GlobalModel->QueryManual($sql);
		 return $hasil;
    }

	public function getDataPO($po) {
        $hasil = [];
		$sql = "SELECT a.*, p.kode_po, c.nama_biaya FROM biaya_hpp_perpodetail a
			JOIN produksi_po p ON p.id_produksi_po=a.idpo
			JOIN biaya_hpp_perpo c ON c.id=a.idbiayapo
		 WHERE a.hapus=0 AND a.idpo='$po' ";
		 $hasil = $this->GlobalModel->QueryManual($sql);
		 return $hasil;
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}

