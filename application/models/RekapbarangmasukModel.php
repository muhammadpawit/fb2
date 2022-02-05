<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RekapbarangmasukModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getdata($data){
		$hasil=[];
		$sin="SELECT id from penerimaan_item WHERE hapus=0 ";
		if(!empty($data['bulan'])){
			$sin.=" AND MONTH(tanggal)='".$data['bulan']."' ";
		}

		if(!empty($data['tahun'])){
			$sin.=" AND YEAR(tanggal)='".$data['tahun']."' ";
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
		$details=$this->GlobalModel->QueryManual("SELECT nama, SUM(jumlah) as qty, harga FROM penerimaan_item_detail WHERE penerimaan_item_id IN(".$id.") GROUP BY id_persediaan");
		return $details;
	}

}