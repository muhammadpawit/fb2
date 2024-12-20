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
		$sql=" SELECT COALESCE(sum(nominal)) as total FROM transferan where hapus=0 ";
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

	public function alokasi_cash($tanggal,$bagian){
		$hasil=[];
		$sql="SELECT * FROM aruskas WHERE hapus=0 AND bagian='$bagian'";
		$sql.=" AND DATE(tanggal) ='".date('Y-m-d',strtotime($tanggal))."' ";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			$hasil=$data;
		}
		return $hasil;
	}

	public function alokasi_transfer($tanggal,$bagian){
		$hasil=[];
		$sql="SELECT * FROM alokasi_transferan WHERE hapus=0 AND bagian='$bagian'";
		$sql.=" AND DATE(tanggal) ='".date('Y-m-d',strtotime($tanggal))."' ";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			$hasil=$data;
		}
		return $hasil;
	}

	public function alokasi_transfer_giro($tanggal,$bagian,$pengalokasian){
		$hasil=[];
		$sql="SELECT COALESCE(sum(nominal),0) as nominal FROM alokasi_transferan WHERE hapus=0 AND bagian='$bagian'";
		$sql.=" AND DATE(tanggal) ='".date('Y-m-d',strtotime($tanggal))."' and pengalokasian='".$pengalokasian."' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['nominal'];
		}
		return $hasil;
	}	

	public function keterangan_bordir($tanggal,$bagian){
		$hasil=[];
		$sql=" SELECT * FROM aruskas where hapus=0 ";
		$sql.=" AND DATE(tanggal) ='".$tanggal."' and bagian='$bagian' AND saldokeluar>0 ";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			foreach($data as $d){
				$hasil[]=$d['keterangan'];
			}
		}
		return $hasil;
	}

	public function alokasi_transferan($tanggal,$bagian,$pengalokasian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(nominal),0) as total FROM transferan where hapus=0 ";
		$sql.=" AND DATE(tanggal) ='".$tanggal."' and bagian='$bagian' AND alokasi='$pengalokasian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}

		return $hasil;
	}


	public function keterangan_transferan($tanggal,$bagian){
		$hasil=[];
		$sql=" SELECT keterangan FROM transferan where hapus=0 ";
		$sql.=" AND DATE(tanggal) ='".$tanggal."' and bagian='$bagian'";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			foreach($data as $d){
				$hasil[]=$d['keterangan'];
			}
		}
		return $hasil;
	}

	public function transferan_bordir_between($tanggal1,$tanggal2,$bagian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(nominal),0) as total FROM transferan where hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and bagian='$bagian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}
		return $hasil;
	}

	public function kas_masuk_bordir_between($tanggal1,$tanggal2,$bagian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(saldomasuk),0) as total FROM aruskas where hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and bagian='$bagian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}

		return $hasil;
	}

	public function alokasi_bordir_between($tanggal1,$tanggal2,$bagian,$pengalokasian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(saldokeluar),0) as total FROM aruskas where hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND bagian='$bagian' AND pengalokasian='$pengalokasian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}
		return $hasil;
	}

	public function alokasi_transferan_between($tanggal1,$tanggal2,$bagian,$pengalokasian){
		$hasil=0;
		$sql=" SELECT COALESCE(sum(nominal),0) as total FROM transferan where hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and bagian='$bagian' AND alokasi='$pengalokasian' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total'];
		}

		return $hasil;
	}

	public function alokasi_transfer_giro_between($tanggal1,$tanggal2,$bagian,$pengalokasian){
		$hasil=[];
		$sql="SELECT COALESCE(sum(nominal),0) as nominal FROM alokasi_transferan WHERE hapus=0 AND bagian='$bagian'";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and pengalokasian='".$pengalokasian."' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['nominal'];
		}
		return $hasil;
	}	


}