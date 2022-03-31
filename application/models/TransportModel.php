<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransportModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}


	public function getdata($data){
		$hasil=[];
		$sql=" SELECT * FROM pendapatan_transport WHERE hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(tanggal) BETWEEN ".$data['tanggal1'].'  AND '.$data['tanggal2'].'';
		}

		$sql.=" ORDER BY id DESC ";
		if($data['limit']<1){
			$sql.=" LIMIT 20";
		}
		$data=$this->GlobalModel->QueryManual($sql);
		$cmt=null;
		foreach($data as $d){
			$cmt=$this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$d['idcmt']));
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>$d['tanggal'],
				'namacmt'=>$cmt['cmt_name'],
				'nominal'=>$d['nominal'],
				'keterangan'=>$d['keterangan'],
			);
		}
		return $hasil;
	}

	public function insert_pendapatan($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>$p['tanggal'],
					'idcmt'=>$p['idcmt'],
					'nominal'=>$p['nominal'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0
				);
				$this->db->insert('pendapatan_transport',$insert);
			}
		}
	}

	public function hapus_pendapatan($id){
		$this->db->update('pendapatan_transport',array('hapus'=>1),array('id'=>$id));
	}

	// driver
	public function getdata_driver($data){
		$hasil=[];
		$sql=" SELECT * FROM transport_driver WHERE hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(tanggal) BETWEEN ".$data['tanggal1'].'  AND '.$data['tanggal2'].'';
		}

		$sql.=" ORDER BY id DESC ";
		if($data['limit']<1){
			$sql.=" LIMIT 20";
		}
		$data=$this->GlobalModel->QueryManual($sql);
		$cmt=null;
		foreach($data as $d){
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>$d['tanggal'],
				'namacmt'=>$d['namadriver'],
				'nominal'=>$d['nominal'],
				'keterangan'=>$d['keterangan'],
			);
		}
		return $hasil;
	}

	public function insert_driver($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>$p['tanggal'],
					'namadriver'=>$p['namadriver'],
					'nominal'=>$p['nominal'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0
				);
				$this->db->insert('transport_driver',$insert);
			}
		}
	}

	public function hapus_driver($id){
		$this->db->update('transport_driver',array('hapus'=>1),array('id'=>$id));
	}


	public function getdata_where($tanggal){
		$hasil=[];
		$sql=" SELECT * FROM pendapatan_transport WHERE hapus=0 ";
		$sql .= " AND DATE(tanggal) ='".$tanggal."' ";
		$data=$this->GlobalModel->QueryManual($sql);
		$cmt=null;
		foreach($data as $d){
			$cmt=$this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$d['idcmt']));
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>$d['tanggal'],
				'namacmt'=>$cmt['cmt_name'],
				'nominal'=>$d['nominal'],
				'keterangan'=>$d['keterangan'],
			);
		}
		return $hasil;
	}
	
	public function getdata_drive_where($tanggal){
		$hasil=[];
		$sql=" SELECT * FROM transport_driver WHERE hapus=0 ";
		$sql .= " AND DATE(tanggal) ='".$tanggal."' ";
		$data=$this->GlobalModel->QueryManual($sql);
		$cmt=null;
		foreach($data as $d){
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>$d['tanggal'],
				'namacmt'=>$d['namadriver'],
				'nominal'=>$d['nominal'],
				'keterangan'=>$d['keterangan'],
			);
		}
		return $hasil;
	}

}