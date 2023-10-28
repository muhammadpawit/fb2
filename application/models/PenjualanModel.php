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

	public function getAnalisaDataPenjualan(){
		$analisa=[];
		$tanggal_awal = date('Y-m-d',strtotime("sunday last week"));
		$tanggal_akhir = date('Y-m-d',strtotime("saturday this week"));

		// penjualan minggu ini
		$between = " AND DATE(tanggal) BETWEEN '".$tanggal_awal."' AND '".$tanggal_akhir."' ";
		$wherin = $this->db->query("SELECT id FROM penjualan_online WHERE hapus=0 $between ")->result();
		$idIn=[];
		foreach($wherin as $w){
			$idIn[]=$w->id;
		}
		$whereIN = implode(",",$idIn);
		$minggu_ini = "
			SELECT a.*, b.nama_po, d.nama as marketplace FROM penjualan_online_product a
			LEFT JOIN produksi_po b ON b.id_produksi_po = a.id_po
			LEFT JOIN penjualan_online c ON c.id=a.penjualan_id
			LEFT JOIN marketplace d ON d.id=c.marketplace_id
			WHERE 1=1
		";
		if(!empty($whereIN)){
			$minggu_ini .=" AND a.penjualan_id IN($whereIN) ";
		}else{
			$minggu_ini .=" AND a.penjualan_id IN(0) ";
		}

		$minggu_ini.=" GROUP BY b.nama_po, a.size ";
		$data = $this->db->query($minggu_ini)->result_array();

		// PENJUALAN BULAN BERJALAN
		$bulan = $this->db->query("
			SELECT 
			COALESCE(SUM(a.total),0) as total_penjualan
			
			FROM penjualan_online a
			
			WHERE a.hapus=0 AND MONTH(a.tanggal)='".date('m')."' AND YEAR(a.tanggal)='".date('Y')."'
			
		")->row();
		$bulanQTY = $this->db->query("
			SELECT 
			COALESCE(SUM(b.quantity),0) as quantity
			FROM penjualan_online a
			LEFT JOIN penjualan_online_product b ON a.id=b.penjualan_id
			WHERE a.hapus=0 AND MONTH(a.tanggal)='".date('m')."' AND YEAR(a.tanggal)='".date('Y')."'
			
		")->row();

		$bulan_lalu = $this->db->query("
			SELECT 
			COALESCE(SUM(a.total),0) as total_penjualan
			
			FROM penjualan_online a
			
			WHERE a.hapus=0 AND MONTH(a.tanggal)='".date('m',strtotime("-1 month"))."' AND YEAR(a.tanggal)='".date('Y')."'
			
		")->row();
		$bulanQTY_lalu = $this->db->query("
			SELECT 
			COALESCE(SUM(b.quantity),0) as quantity
			FROM penjualan_online a
			LEFT JOIN penjualan_online_product b ON a.id=b.penjualan_id
			WHERE a.hapus=0 AND MONTH(a.tanggal)='".date('m',strtotime("-1 month"))."' AND YEAR(a.tanggal)='".date('Y')."'
			
		")->row();

		$analisa = array(
			'minggu_ini' 	=> $data,
			'total_bulan'	=> $bulan,
			'qty_bulan'		=> $bulanQTY,
			'total_bulan_lalu'	=> $bulan_lalu,
			'qty_bulan_lalu'		=> $bulanQTY_lalu,
		);
		// pre($analisa);
		return $analisa;
	}


}