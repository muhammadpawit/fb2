<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BulananModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    function get(){
        $query =" SELECT LPAD(MONTH(tanggal_kirim), 2, '0') as bulan, YEAR(tanggal_kirim) as tahun FROM finishing_kirim_gudang fkg ";
        $query .=" JOIN produksi_po pp ON pp.kode_po=fkg.kode_po WHERE pp.hapus=0 ";
        $query .=" GROUP BY MONTH(tanggal_kirim), YEAR(tanggal_kirim) ";
        return $this->db->query($query)->result_array();
    }

}