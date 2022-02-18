<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_potonganoperator extends CI_Model {

	function __construct() {
	
		parent::__construct();
	}

	function getData($data){

		$hasil=[];
		$sql="SELECT * FROM potongan_operator WHERE hapus=0 ";
		
		if(!empty($data['nama'])){
			$sql.=" AND lower(nama) LIKE '%".strtolower($data['nama'])."%' ";
		}

		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal1']."'";
		}
		$sql.=" ORDER BY id DESC ";
		$hasil=$this->db->query($sql)->result_array();

		return $hasil;
	}

	function insert($data){
		$operator=explode(",", $data['operator']);
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'idkaryawan'=>$operator[0],
			'nama'=>$operator[1],
			'nominal'=>$data['nominal'],
			'jenis_potongan'=>$data['jenis_potongan'],
			'keterangan'=>$data['keterangan'],
			'tempat'=>$data['tempat'],
			'hapus'=>0,
		);
		$this->db->insert('potongan_operator',$insert);
	}

	function delete($data){
		$update=array(
			'hapus'=>1,
		);
		$where=array(
			'id'=>$data['id'],
		);
		$this->db->update('potongan_operator',$update,$where);
	}

	function getSumPotongan($id,$tanggal,$jenis){
		$hasil=0;
		$sql="SELECT SUM(nominal) as total FROM potongan_operator WHERE hapus=0 ";
		$sql.=" AND jenis_potongan='$jenis' AND idkaryawan='$id' AND DATE(tanggal)='$tanggal' ";
		$row=$this->db->query($sql)->row_array();
		if(!empty($row)){
			$hasil=$row['total'];
		}
		return $hasil;
	}


}
