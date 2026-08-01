<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransportModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function getdata($data){
		$sql=" SELECT p.*, c.cmt_name as namacmt FROM pendapatan_transport p LEFT JOIN master_cmt c ON c.id_cmt=p.idcmt WHERE p.hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(p.tanggal) BETWEEN '".$data['tanggal1']."'  AND '".$data['tanggal2']."' ";
		}

		$sql.=" ORDER BY p.id DESC ";
		if($data['limit']<1){
			$sql.=" LIMIT 20";
		}
		return $this->db->query($sql)->result_array();
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
		$sql=" SELECT id, tanggal, cash, pengisian_etol, saldo_awal_etol, pemakaian_etol, sisa_etol, solar, uangmakan as uang_makan, biayalain as biaya_lain, namadriver as namacmt, nominal, sisa_cash, km, tujuan, keterangan, keterangan2 FROM transport_driver WHERE hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(tanggal) BETWEEN '".$data['tanggal1']."'  AND '".$data['tanggal2']."' ";
		}

		$sql.=" ORDER BY id DESC ";
		if($data['limit']<1){
			$sql.=" LIMIT 20";
		}
		return $this->db->query($sql)->result_array();
	}

	public function insert_driver($data){
		// pre($data);
		if(isset($data['products'])){
			foreach($data['products'] as $d){
				$insert=array(
					'tanggal'=>$d['tanggal'],
					'cash' => $d['cash'], // Cash
					'pengisian_etol' => $d['pengisian_etoll'], // E-Toll Pengisian
					'saldo_awal_etol' => $d['saldo_awal_etoll'], // E-Toll Saldo Awal
					'pemakaian_etol' => $d['pemakaian_etoll'], // E-Toll Pemakaian
					'sisa_etol' => $d['sisa_etoll'], // E-Toll Sisa
					'solar' => $d['solar'], // Solar
					'uangmakan' => $d['uang_makan'], // Uang Makan
					'biayalain' => $d['biaya_lain'], // Biaya Lain-Lain
					'namadriver'=>$d['namadriver'],
					'nominal'=>$d['nominal'],
					'sisa_cash' => $d['sisa_cash'], // Sisa Cash
					'km' => $d['km'], // KM
					'tujuan' => $d['tujuan'], // Tujuan
					'keterangan'=>$d['keterangan'],
					'keterangan2'=>$d['keterangan2'],
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
		$sql=" SELECT p.id, p.tanggal, c.cmt_name as namacmt, p.nominal, p.keterangan FROM pendapatan_transport p LEFT JOIN master_cmt c ON c.id_cmt=p.idcmt WHERE p.hapus=0 AND DATE(p.tanggal) ='".$tanggal."' ";
		return $this->db->query($sql)->result_array();
	}
	
	public function getdata_drive_where($tanggal){
		$sql=" SELECT id, tanggal, namadriver as namacmt, nominal, keterangan FROM transport_driver WHERE hapus=0 AND DATE(tanggal) ='".$tanggal."' ";
		return $this->db->query($sql)->result_array();
	}

	public function get_driver_by_id($id){
		return $this->db->get_where('transport_driver', ['id' => $id])->row_array();
	}

	public function update_driver($data){
		if(isset($data['products'])){
			foreach($data['products'] as $d){
				$id = $d['id'];
				$update=array(
					'tanggal'=>$d['tanggal'],
					'cash' => $d['cash'],
					'pengisian_etol' => $d['pengisian_etoll'],
					'saldo_awal_etol' => $d['saldo_awal_etoll'],
					'pemakaian_etol' => $d['pemakaian_etoll'],
					'sisa_etol' => $d['sisa_etoll'],
					'solar' => $d['solar'],
					'uangmakan' => $d['uang_makan'],
					'biayalain' => $d['biaya_lain'],
					'namadriver'=>$d['namadriver'],
					'nominal'=>$d['nominal'],
					'sisa_cash' => $d['sisa_cash'],
					'km' => $d['km'],
					'tujuan' => $d['tujuan'],
					'keterangan'=>$d['keterangan'],
					'keterangan2'=>$d['keterangan2']
				);
				$this->db->update('transport_driver', $update, ['id' => $id]);
			}
		}
	}

	public function hitung_ulang_driver($ids){
		if(empty($ids)) return false;
		foreach($ids as $id){
			$d = $this->db->get_where('transport_driver', ['id' => $id])->row_array();
			if($d){
				$pengisian_etol = (float)$d['pengisian_etol'];
				$saldo_awal_etol = (float)$d['saldo_awal_etol'];
				$pemakaian_etol = (float)$d['pemakaian_etol'];
				$solar = (float)$d['solar'];
				$uangmakan = (float)$d['uangmakan'];
				$biayalain = (float)$d['biayalain'];
				$cash = (float)$d['cash'];

				$sisa_etol = $pengisian_etol + $saldo_awal_etol - $pemakaian_etol;
				$nominal = $pengisian_etol + $solar + $uangmakan + $biayalain;
				$sisa_cash = $cash - $nominal;

				$update = [
					'sisa_etol' => $sisa_etol,
					'nominal' => $nominal,
					'sisa_cash' => $sisa_cash
				];
				$this->db->update('transport_driver', $update, ['id' => $id]);
			}
		}
		return true;
	}

}
