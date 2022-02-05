<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdjustModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}


	public function kirimgudang($data){
		$hasil=[];
		$sql=" SELECT * FROM adjust_kirimgudang WHERE hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(tanggal) BETWEEN ".$data['tanggal1'].'  AND '.$data['tanggal2'].'';
		}

		if(isset($data['tampil'])){
			$sql.=" AND tampil='".$data['tampil']."'";
		}

		$sql.="ORDER BY id DESC ";
		$data=$this->GlobalModel->QueryManual($sql);
		foreach($data as $d){
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>$d['tanggal'],
				'nama'=>$d['nama_po'],
				'po'=>$d['jml_po'],
				'dz'=>$d['jml_dz'],
				'pcs'=>$d['jml_pcs'],
				'total'=>$d['total'],
				'tampil'=>$d['tampil'],
			);
		}
		return $hasil;
	}

	public function kirimgudang_insert($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>date('Y-m-d'),
					'nama_po'=>$p['nama_po'],
					'jml_po'=>$p['jml_po'],
					'jml_dz'=>$p['jml_dz'],
					'jml_pcs'=>$p['jml_pcs'],
					'total'=>$p['total'],
					'tampil'=>1,
					'hapus'=>0
				);
				$this->db->insert('adjust_kirimgudang',$insert);
			}
		}
	}

	public function kirimgudang_tampil($id){
		$this->db->update('adjust_kirimgudang',array('tampil'=>1),array('id'=>$id));
	}

	public function kirimgudang_hide($id){
		$this->db->update('adjust_kirimgudang',array('tampil'=>2),array('id'=>$id));
	}

	public function kirimgudang_hapus($id){
		$this->db->update('adjust_kirimgudang',array('hapus'=>1),array('id'=>$id));
	}

	public function kirimgudang_detail($data){
		$hasil=[];
		$sql=" SELECT * FROM adjust_kirimgudang_detail WHERE hapus=0 ";
		if(isset($data['tampil'])){
			$sql.=" AND tampil='".$data['tampil']."'";
		}
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(tanggal) BETWEEN ".$data['tanggal1'].'  AND '.$data['tanggal2'].'';
		}
		$sql.="ORDER BY id DESC ";
		$data=$this->GlobalModel->QueryManual($sql);
		foreach($data as $d){
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>date('d-m-Y',$d['tanggal']),
				'jenis'=>$d['idjenis'],
				'nama'=>$d['nama_po'],
				'po'=>$d['jml_po'],
				'dz'=>$d['jml_dz'],
				'pcs'=>$d['jml_pcs'],
				'total'=>$d['total'],
				'tampil'=>$d['tampil'],
			);
		}
		return $hasil;
	}

	public function kirimgudang_detail_insert($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>date('Y-m-d'),
					'idjenis'=>$p['idjenis'],
					'nama_po'=>$p['nama_po'],
					'jml_po'=>$p['jml_po'],
					'jml_dz'=>$p['jml_dz'],
					'jml_pcs'=>$p['jml_pcs'],
					'total'=>$p['total'],
					'tampil'=>1,
					'hapus'=>0
				);
				$this->db->insert('adjust_kirimgudang',$insert);
			}
		}
	}

	public function kirimgudang_detail_tampil($id){
		$this->db->update('adjust_kirimgudang_detail',array('tampil'=>1),array('id'=>$id));
	}

	public function kirimgudang_detail_hide($id){
		$this->db->update('adjust_kirimgudang_detail',array('tampil'=>2),array('id'=>$id));
	}

	public function kirimgudang_detail_hapus($id){
		$this->db->update('adjust_kirimgudang_detail',array('hapus'=>1),array('id'=>$id));
	}

	public function adjust_kirimsetorcmt($data){
		$hasil=[];
		$sql=" SELECT * FROM adjust_kirimsetorcmt WHERE hapus=0 ";
		if(isset($data['tampil'])){
			$sql.=" AND tampil='".$data['tampil']."'";
		}
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(tanggal) BETWEEN ".$data['tanggal1'].'  AND '.$data['tanggal2'].'';
		}
		$sql.="ORDER BY id DESC ";
		$data=$this->GlobalModel->QueryManual($sql);
		foreach($data as $d){
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>date('d-m-Y',strtotime($d['tanggal'])),
				'nama'=>$d['nama_po'],
				'kirim_po'=>$d['kirim_po'],
				'kirim_dz'=>$d['kirim_dz'],
				'kirim_pcs'=>$d['kirim_pcs'],
				'total'=>null,
				'setor_po'=>$d['setor_po'],
				'setor_dz'=>$d['setor_dz'],
				'setor_pcs'=>$d['setor_pcs'],
				'tampil'=>$d['tampil'],
			);
		}
		return $hasil;
	}

	public function kirimsetor_insert($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>$p['tanggal'],
					'nama_po'=>$p['nama_po'],
					'kirim_po'=>$p['kirim_po'],
					'kirim_dz'=>$p['kirim_dz'],
					'kirim_pcs'=>$p['kirim_pcs'],
					'setor_po'=>$p['setor_po'],
					'setor_dz'=>$p['setor_dz'],
					'setor_pcs'=>$p['setor_pcs'],
					'tampil'=>1,
					'hapus'=>0
				);
				$this->db->insert('adjust_kirimsetorcmt',$insert);
			}
		}
	}

	public function kirimsetor_tampil($id){
		$this->db->update('adjust_kirimsetorcmt',array('tampil'=>1),array('id'=>$id));
	}

	public function kirimsetor_hide($id){
		$this->db->update('adjust_kirimsetorcmt',array('tampil'=>2),array('id'=>$id));
	}

	public function kirimsetor_hapus($id){
		$this->db->update('adjust_kirimsetorcmt',array('hapus'=>1),array('id'=>$id));
	}

	public function adjust_kirimsetorcmt_detail($data){
		$hasil=[];
		$sql=" SELECT * FROM adjust_kirimsetorcmt_detail WHERE hapus=0 ";
		if(isset($data['tampil'])){
			$sql.=" AND tampil='".$data['tampil']."'";
		}
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(tanggal) BETWEEN ".$data['tanggal1'].'  AND '.$data['tanggal2'].'';
		}
		$sql.="ORDER BY id DESC ";
		$data=$this->GlobalModel->QueryManual($sql);
		foreach($data as $d){
			$hasil[]=array(
				'id'=>$d['id'],
				'tanggal'=>date('d-m-Y',$d['tanggal']),
				'jenis'=>$d['idjenis'],
				'nama'=>$d['nama_po'],
				'kirim_po'=>$d['jmlkirim_po'],
				'kirim_dz'=>$d['jmlkirim_dz'],
				'kirim_pcs'=>$d['jmlkirim_pcs'],
				'setor_po'=>$d['jmlsetor_po'],
				'setor_dz'=>$d['jmlsetor_dz'],
				'setor_pcs'=>$d['jmlsetor_pcs'],
			);
		}
		return $hasil;
	}


	public function kirimsetor_detail_insert($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>$p['tanggal'],
					'idjenis'=>$p['idjenis'],
					'nama_po'=>$p['nama_po'],
					'kirim_po'=>$p['kirim_po'],
					'kirim_dz'=>$p['kirim_dz'],
					'kirim_pcs'=>$p['kirim_pcs'],
					'setor_po'=>$p['setor_po'],
					'setor_dz'=>$p['setor_dz'],
					'setor_pcs'=>$p['setor_pcs'],
					'tampil'=>1,
					'hapus'=>0
				);
				$this->db->insert('adjust_kirimsetorcmt_detail',$insert);
			}
		}
	}

	public function kirimsetor_detail_tampil($id){
		$this->db->update('adjust_kirimsetorcmt_detail',array('tampil'=>1),array('id'=>$id));
	}

	public function kirimsetor_detail_hide($id){
		$this->db->update('adjust_kirimsetorcmt_detail',array('hide'=>2),array('id'=>$id));
	}

	public function kirimsetor_detail_hapus($id){
		$this->db->update('adjust_kirimsetorcmt',array('hapus'=>1),array('id'=>$id));
	}


}