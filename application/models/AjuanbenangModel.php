<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjuanbenangModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_Data($filter){
		$hasil=[];
		$sql="SELECT * FROM ajuan_benang WHERE hapus=0 ";
		if(!empty($filter['tanggal1'])){
			$sql.=" AND DATE(tanggal_ajuan) BETWEEN '".$filter['tanggal1']."' AND '".$filter['tanggal2']."' ";
		}
		$sql.-" ORDER BY tanggal_ajuan DESC ";
		$data=$this->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			$hasil=$data;
		}
		return $hasil;
	}

	function save_data($data){
		$insert=array(
			'tanggal_ajuan'=>$data['tanggal'],
			'tanggal_acc'=>null,
			'keterangan'=>$data['keterangan'],
			'status'=>1, // 1 diajukan, 2 ditolak, 3 diterima
			'hapus'=>0,
		);
		$this->db->insert('ajuan_benang',$insert);
		$id=$this->db->insert_id();

		foreach($data['prods'] as $$p){
			$detail=array(
				'id_ajuan_benang'=>$id,
				'tanggal'=>$data['tanggal'],
				'id_persediaan'=>$p['id_persediaan'],
				'nama'=>$p['nama'],
				'kebutuhan'=>$p['kebutuhan'],
				'stok_jkt'=>$p['stok_jkt'],
				'stok_skb'=>$p['stok_skb'],
			);
		}
	}
}