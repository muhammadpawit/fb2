<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RekapbarangmasukModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getdata($data){
		$hasil=[];
		$sin="SELECT id, jenis from penerimaan_item WHERE hapus=0 ";
		
		if(!empty($data['tanggal1'])){
			$sin.=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}else{
			if(!empty($data['bulan'])){
				$sin.=" AND MONTH(tanggal)='".$data['bulan']."' ";
			}

			if(!empty($data['tahun'])){
				$sin.=" AND YEAR(tanggal)='".$data['tahun']."' ";
			}
		}

		if(!empty($data['supplier'])){
			$sin.=" AND supplier='".$data['supplier']."' ";
		}

		$in=$this->GlobalModel->QueryManual($sin);
		if(!empty($in)){
			foreach($in as $i){
				$hasil[]=$i['id'];
			}
		}
		$id=implode(",",$hasil);
		$details=[];
		if(!empty($id)){
			//$details=$this->GlobalModel->QueryManual("SELECT nama, SUM(jumlah) as qty, harga FROM penerimaan_item_detail WHERE penerimaan_item_id IN(".$id.") GROUP BY id_persediaan");
			 
			$details=$this->GlobalModel->QueryManual("SELECT nama, IF(jenis = 1, SUM(ukuran), SUM(jumlah)) AS qty, harga FROM penerimaan_item_detail WHERE penerimaan_item_id IN(".$id.") GROUP BY id_persediaan");
		}
		return $details;
	}

}