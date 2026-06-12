<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GajiSablonModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data){
        $results=array();
		$data['prods']=[];
		$sql		  ="SELECT a.*, 
							m.nama AS kode_po,
							k.nama AS namakar,
							c.cmt_name
						FROM gaji_sablon_borongan a ";
		$sql 		  .=" LEFT JOIN master_po_luar m ON m.id = a.idpo  ";
		$sql 		  .=" LEFT JOIN karyawan_harian k ON k.id = a.namatim   ";
		$sql 		  .=" LEFT JOIN master_cmt c ON c.id_cmt = a.idcmt   ";
		$sql 		  .=" WHERE a.hapus=0 ";
		if(!empty($data['namatim'])){
			$sql .=" AND namatim='".$data['namatim']."' ";
		}
		if(!empty($data['idcmt'])){
			$sql .=" AND a.idcmt='".$data['idcmt']."' ";
		}
		if(!empty($data['tanggal1'])){
			$sql .=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
        return $results;
    }


    function getDalam($data){
        $results=array();
		$sql		  ="SELECT a.*, 
							p.kode_po AS kode_po,
							k.nama AS namakar,
							c.cmt_name
						FROM gaji_sablon_borongan a ";
		$sql 		  .=" LEFT JOIN produksi_po p ON p.id_produksi_po = a.idpo  ";
		$sql 		  .=" LEFT JOIN karyawan_harian k ON k.id = a.namatim   ";
		$sql 		  .=" LEFT JOIN master_cmt c ON c.id_cmt = a.idcmt   ";
		$sql 		  .=" WHERE a.hapus=0 AND a.jenis='dalam' ";
		if(!empty($data['namatim'])){
			$sql .=" AND namatim='".$data['namatim']."' ";
		}
		if(!empty($data['idcmt'])){
			$sql .=" AND a.idcmt='".$data['idcmt']."' ";
		}
		if(!empty($data['tanggal1'])){
			$sql .=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
        return $results;
    }

   

}