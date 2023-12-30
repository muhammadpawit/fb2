<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OnlineModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->MainTable='master_po_online';
	}

	public function getMasterPoOnline(){
		$query =
		"SELECT a.*,b.cmt_name as namacmt,c.kode_po as kode_po FROM master_po_online a 
		LEFT JOIN master_cmt b ON b.id_cmt=a.id_cmt
		LEFT JOIN produksi_po c ON c.id_produksi_po=a.id_po
		WHERE a.hapus=0 AND c.hapus=0 ";
		return $this->db->query($query)->result_array();
	}

	public function getMasterPoOnlineDetail($id){
		$query =
		"SELECT a.*,b.cmt_name as namacmt,c.kode_po as kode_po FROM master_po_online a 
		LEFT JOIN master_cmt b ON b.id_cmt=a.id_cmt
		LEFT JOIN produksi_po c ON c.id_produksi_po=a.id_po
		WHERE a.hapus=0 AND c.hapus=0 AND a.id='$id' ";
		return $this->db->query($query)->row_array();
	}

	function insert($data){
		$insert = array(
			'id_po' => $data['id_po'],
			'id_cmt' => $data['id_cmt'],
			'harga' => $data['harga'],
			'dz' => isset($data['dz']) ? $data['dz']:0,
			'pcs' => isset($data['pcs']) ? $data['pcs']:0,
			'hapus' =>0,
		);
		$this->db->insert('master_po_online',$insert);
		$last_id = $this->db->insert_id();
		foreach($data['products'] as $p){
			for($i=$p['id_size_from']; $i<=$p['id_size_to']; $i++){
				$detail=array(
					'id_master_po_online' => $last_id,
					'id_size'			  => $i,
					'id_serian'			  => $p['id_serian'],
					'pcs'				  => isset($p['pcs']) ? $p['pcs']:0,
					'hapus'			      => 0,
				);
				$this->db->insert('master_po_online_detail',$detail);
			}
		}
		if($last_id>0){
			return TRUE;
		}else{
			return false;
		}
	}

	function terima($data){
		$pcs=0;
		foreach($data['prods'] as $p){
			$pcs+=$p['pcs'];
			$update = array(
				'pcs' => $p['pcs']
			);
			$where = array(
				'id'	=> $p['id']
			);
			$update = $this->db->update('master_po_online_detail',$update,$where);
		}
		$this->db->update('master_po_online',array('pcs'=>$pcs),array('id'=>$data['id']));
		return $update;
	}

	public function getDataStok(){
		$hasil = [];
		// $query =
		// "SELECT a.id,a.id_master_po_online,a.id_serian,a.pcs,b.harga,c.kode_po,
		// b.harga, c.kode_po,d.nama as serian, e.nama as id_size 
		// FROM master_po_online_detail a 
		// LEFT JOIN master_po_online b ON b.id = a.id_master_po_online
		// LEFT JOIN produksi_po c ON c.id_produksi_po=b.id_po
		// LEFT JOIN master_po_online_serian d ON d.id=a.id_serian
		// LEFT JOIN size_po_online e ON e.id=a.id_size
		// WHERE a.hapus=0 AND b.hapus=0 AND a.pcs > 0 
		// ";
		$query =
		"SELECT b.id,b.pcs, c.kode_po
		FROM master_po_online_detail a 
		LEFT JOIN master_po_online b ON b.id = a.id_master_po_online
		LEFT JOIN produksi_po c ON c.id_produksi_po=b.id_po
		WHERE a.hapus=0 AND a.pcs > 0 
		GROUP BY kode_po 
		";
		$data = $this->db->query($query)->result_array();
		if(!empty($data)){
			foreach($data as $d){
				$hasil[]=array(
					'id'		=> $d['id'],
					'kode_po'	=> $d['kode_po'],
					'total'		=> $d['pcs'],
					'detail'	=> $this->detailOnlinePO($d['id']),
					// 'jml_serian' => $this->getSerianPo($d['id'])['total'],
					// 'size'		=> $this->getSizePo($d['id'])['data'],
					// 'jumlah_size'=> $this->getSizePo($d['id'])['total'],
					// 'ket'		=> null,
				);
			}
		}
		return $hasil;
	}

	function detailOnlinePO($id_master_po_online){
		$hasil=[];
		$query = "SELECT a.id_serian, b.nama, c.nama as namasize FROM master_po_online_detail a ";
		$query .= " LEFT JOIN master_po_online_serian b ON b.id=a.id_serian ";
		$query .= " LEFT JOIN size_po_online c ON c.id=a.id_size ";
		$query .=" WHERE id_master_po_online='".$id_master_po_online."'  AND a.hapus=0  ";
		$query .=" GROUP BY b.nama ";
		$data = $this->db->query($query)->result_array();
		foreach($data as $d){
			$hasil[] = array(
				'idserian' => $d['id_serian'],
				'serian' => $d['nama'],
				// 'size' => $d['namasize'],
				// 'qty' => $d['total'],
			);
		}
		return $hasil;
	}

	function getPcs($id_master_po_online,$idserian,$idsize){
		$sql ="SELECT a.pcs FROM master_po_online_detail a ";
		// $sql .= " LEFT JOIN master_po_online_serian b ON b.id=a.id_serian ";
		$sql .=" WHERE a.id_master_po_online='".$id_master_po_online."' AND a.id_serian='".$idserian."' AND a.id_size='".$idsize."' AND a.hapus=0 ";
		$data = $this->db->query($sql)->row();
		return !empty($data) ? $data->pcs : '';
	}

	function getSerianPo($id_master_po_online){
		$hasil=[];
		$query = "SELECT b.id as id_serian, b.nama, a.pcs FROM master_po_online_detail a ";
		$query .= " LEFT JOIN master_po_online_serian b ON b.id=a.id_serian ";

		$query .=" WHERE a.id_master_po_online='".$id_master_po_online."'  AND a.hapus=0 ";

		$query .=" GROUP BY b.nama ORDER BY b.nama  ";
		$data = $this->db->query($query)->result_array();
		return $hasil[] = array(
			'data' => $data,
			'total' => count($data),
		);
	}

	function getSizePo($id_master_po_online){
		$hasil=[];
		$query = "SELECT b.id as id_size, b.nama FROM master_po_online_detail a ";
		$query .= " LEFT JOIN size_po_online b ON b.id=a.id_size ";

		$query .=" WHERE a.id_master_po_online='".$id_master_po_online."' AND a.hapus=0 ";

		$query .=" GROUP BY b.id ORDER BY b.id ASC  ";
		$data = $this->db->query($query)->result_array();
		return $hasil[] = array(
			'data' => $data,
			'total' => count($data),
		);
	}

	function getPo($id){
		$query =
		"SELECT a.id,a.id_master_po_online,a.id_serian,a.pcs,b.harga,c.kode_po,
		b.harga, c.kode_po,d.nama as serian, e.nama as id_size FROM master_po_online_detail a 
		LEFT JOIN master_po_online b ON b.id = a.id_master_po_online
		LEFT JOIN produksi_po c ON c.id_produksi_po=b.id_po
		LEFT JOIN master_po_online_serian d ON d.id=a.id_serian
		LEFT JOIN size_po_online e ON e.id=a.id_size
		WHERE a.hapus=0 AND b.hapus=0 AND a.id=$id ";
		return $this->db->query($query)->row_array();
	}

	function getMasterPoDetail($id){
		$query =
		"SELECT a.id,a.id_master_po_online,a.id_serian,a.pcs,b.harga,c.kode_po,
		b.harga, c.kode_po,d.nama as serian, e.nama as id_size FROM master_po_online_detail a 
		LEFT JOIN master_po_online b ON b.id = a.id_master_po_online
		LEFT JOIN produksi_po c ON c.id_produksi_po=b.id_po
		LEFT JOIN master_po_online_serian d ON d.id=a.id_serian
		LEFT JOIN size_po_online e ON e.id=a.id_size
		WHERE a.hapus=0 AND b.hapus=0 AND b.id=$id ";
		return $this->db->query($query)->result_array();
	}

	public function getSerian(){
		$query =
		"SELECT * FROM master_po_online_serian
		WHERE hapus=0 ";
		return $this->db->query($query)->result_array();
	}

	public function getDataStokGroupBySize(){
		$query =
		"SELECT COALESCE(SUM(a.pcs),0) as stok ,c.kode_po,e.nama as id_size 
		FROM master_po_online_detail a 
		LEFT JOIN master_po_online b ON b.id = a.id_master_po_online
		LEFT JOIN produksi_po c ON c.id_produksi_po=b.id_po
		LEFT JOIN master_po_online_serian d ON d.id=a.id_serian
		LEFT JOIN size_po_online e ON e.id=a.id_size
		WHERE a.hapus=0 AND b.hapus=0 AND a.pcs > 0 
		GROUP BY c.kode_po, e.nama 
		";
		return $this->db->query($query)->result_array();
	}

	function updateDetail($data){
		foreach($data['prods'] as $p){
			
			$update = array(
				'id_size' => $p['id_size'],
				'id_serian' => $p['id_serian']
			);
			$where = array(
				'id'	=> $p['id']
			);
			$update = $this->db->update('master_po_online_detail',$update,$where);
		}
		return $update;
	}

	

}