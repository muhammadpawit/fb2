<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanmingguanModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function kas_masuk_bordir($tanggal,$bagian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(saldomasuk),0) as total FROM aruskas where hapus=0 ";
		$sql.=" AND DATE(tanggal) ='".$tanggal."' and bagian='$bagian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}

		return $hasil;
	}

	public function transferan_bordir($tanggal,$bagian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(nominal),0) as total FROM transferan where hapus=0 ";
		$sql.=" AND DATE(tanggal) ='".$tanggal."' and bagian='$bagian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}
		return $hasil;
	}

	public function alokasi_bordir($tanggal,$bagian,$pengalokasian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(saldokeluar),0) as total FROM aruskas where hapus=0 ";
		$sql.=" AND DATE(tanggal) ='".$tanggal."' and bagian='$bagian' AND pengalokasian='$pengalokasian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}
		return $hasil;
	}

	public function keterangan_bordir($tanggal,$bagian){
		$hasil=[];
		$sql=" SELECT * FROM aruskas where hapus=0 ";
		$sql.=" AND DATE(tanggal) ='".$tanggal."' and bagian='$bagian' AND saldomasuk>0 ";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			foreach($data as $d){
				$hasil[]=$d['keterangan'];
			}
		}
		return $hasil;
	}


}