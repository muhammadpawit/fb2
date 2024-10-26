<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LababordirModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getPodalam($data){
		$sql="SELECT sum(total_stich) as total_stich FROM kelola_mesin_bordir WHERE hapus=0 and jenis=1 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND date(created_date) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		if(!empty($data['nomesin'])){
			$sql.=" AND mesin_bordir='".$data['nomesin']."' ";
		}
		$d=$this->db->query($sql);
		return $d->result_array();
	}

	public function Getkeluar($data){
		$aruskas=0;
		$tf=0;
		$hasil=0;
		$sql1="SELECT SUM(saldokeluar) as total FROM aruskas WHERE hapus=0 AND bagian=2 ";
		if(!empty($data['tanggal1'])){
			$sql1.=" AND date(tanggal) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$s1=$this->GlobalModel->QueryManualRow($sql1);
		if(!empty($s1)){
			$aruskas=$s1['total'];
		}

		$sql2="SELECT SUM(nominal) as total FROM transferan WHERE hapus=0 AND bagian=2 ";
		if(!empty($data['tanggal1'])){
			$sql2.=" AND date(tanggal) between '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$s2=$this->GlobalModel->QueryManualRow($sql2);
		if(!empty($s2)){
			$tf=$s2['total'];
		}

		$hasil=($aruskas+$tf);
		return $hasil;
	}


	public function operasional($tanggal1,$tanggal2,$pengalokasian){
		$hasil=0;
		$sql="SELECT COALESCE(SUM(nominal),0) as total FROM alokasi_transferan WHERE hapus=0 AND bagian='2' AND pengalokasian =$pengalokasian ";
		$sql.=" AND DATE(tanggal) BETWEEN '".date('Y-m-d',strtotime($tanggal1))."' AND '".date('Y-m-d',strtotime($tanggal2))."' ";
		$data=$this->GlobalModel->QueryManualRow($sql);
		if(!empty($data['total'])){
			$hasil=$data['total'];
		}
		return $hasil;
	}

}