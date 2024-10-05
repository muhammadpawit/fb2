<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GajiSablonModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($data){
        $results=array();
		$data['prods']=[];
		$sql		  ="SELECT a.*, 
							CASE 
								WHEN a.namatim = 197 THEN m.nama
								ELSE p.kode_po
							END AS kode_po,
							k.nama AS namakar
						FROM gaji_sablon_borongan a ";
		$sql 		  .=" LEFT JOIN produksi_po p ON p.id_produksi_po = a.idpo  ";
		$sql 		  .=" LEFT JOIN master_po_luar m ON m.id = a.idpo  ";
		$sql 		  .=" LEFT JOIN karyawan_harian k ON k.id = a.namatim   ";
		$sql 		  .=" WHERE a.hapus=0 ";
		if(!empty($data['namatim'])){
			$sql .=" AND namatim='".$data['namatim']."' ";
		}
		if(!empty($data['tanggal1'])){
			$sql .=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
        return $results;
    }


   

}