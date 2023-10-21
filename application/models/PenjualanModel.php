<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PenjualanModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table='penjualan_online';
	}

	public function getDataPenjualan(){
		$query =
		"SELECT a.*,b.nama as namacustomer,  b.no_hp, c.nama as marketplace FROM penjualan_online a 
		LEFT JOIN customer b ON b.id=a.customer_id
		LEFT JOIN marketplace c ON c.id=a.marketplace_id
		WHERE a.hapus=0 ";
		return $this->db->query($query)->result_array();
	}

	public function getDataPenjualanDetail($id){
		$query =
		"SELECT a.*,b.nama as namacustomer,  b.*, c.nama as marketplace FROM penjualan_online a 
		LEFT JOIN customer b ON b.id=a.customer_id
		LEFT JOIN marketplace c ON c.id=a.marketplace_id
		WHERE a.hapus=0 AND a.id='".$id."' ";
		return $this->db->query($query)->row_array();
	}

	public function getDataPenjualanProductDetail($id){
		$query =
		"SELECT a.*, b.kode_po FROM penjualan_online_product a
		LEFT JOIN produksi_po b ON b.id_produksi_po=a.id_po
		WHERE a.penjualan_id='".$id."' ";
		return $this->db->query($query)->result_array();
	}

	public function insertPenjualan($input){
		$total_harga=0;
		$total_discount=0;
		$total=0;
		$insert = array(
			'tanggal' 			=> date('Y-m-d',strtotime($input['tanggal'])),
			'marketplace_id'		=> $input['marketplace_id'],
			'customer_id'		=> $input['customer_id'],
			'biaya_pengiriman'	=> $input['biaya_pengiriman'],
			'ekspedisi_id'		=> $input['ekspedisi_id'],
			'no_resi'			=> $input['no_resi'],
			'hapus'				=> 0,
		);
		$save = $this->db->insert($this->table,$insert);
		$id=$this->db->insert_id();
		foreach($input['products'] as $p){

			$total_harga+=($p['harga']*$p['quantity']);
			$total_discount+=($p['discount']);
			// $total+=($total_harga);

			$detail = array(
				'penjualan_id' 		=> $id,
				'id_po'				=> $p['id_po'],
				'size'				=> $p['size'],
				'quantity'			=> $p['quantity'],
				'harga'				=> $p['harga'],
				'discount'			=> $p['discount'],
				'jumlah'			=> ( ($p['harga']*$p['quantity'])-$p['discount'] ),
				'hapus'				=> 0,
			);
			$this->db->insert('penjualan_online_product',$detail);
		}
		$biaya_pengiriman=$input['biaya_pengiriman'];
		$total=($total_harga-$total_discount+$biaya_pengiriman);
		$marketplace = $this->GlobalModel->getDataRow('marketplace',array('id'=>$input['marketplace_id']));
		$no_order=substr(strtoupper($marketplace['nama']),0,3).'-'.$id;
		$this->db->update($this->table,array('no_order'=>$no_order,'total'=>$total,'total_harga'=>$total_harga,'total_discount'=>$total_discount),array('id'=>$id));
		if($save==TRUE){
			return $hasil = array(
				'success' 		=> true,
				'message'		=> 'success',
			);
		}else{
			return $hasil = array(
				'success' 		=> false,
				'message'		=> 'failed',
			);
		}
	}

	public function getDataEkspedisi(){
		$query =
		"SELECT * FROM ekspedisi
		WHERE hapus=0 and status=1
		ORDER BY nama 
		 ";
		return $this->db->query($query)->result_array();
	}

	public function getDataMarketplace(){
		$query =
		"SELECT * FROM marketplace
		WHERE hapus=0 
		ORDER BY nama 
		 ";
		return $this->db->query($query)->result_array();
	}


}