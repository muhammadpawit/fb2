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

	

}