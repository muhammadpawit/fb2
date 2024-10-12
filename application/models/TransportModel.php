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
			$sql .= " AND DATE(tanggal) BETWEEN '".$data['tanggal1']."'  AND '".$data['tanggal2']."' ";
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
				'cash' => $d['cash'], // Cash
				'pengisian_etol' => $d['pengisian_etol'], // E-Toll Pengisian
				'saldo_awal_etol' => $d['saldo_awal_etol'], // E-Toll Saldo Awal
				'pemakaian_etol' => $d['pemakaian_etol'], // E-Toll Pemakaian
				'sisa_etol' => $d['sisa_etol'], // E-Toll Sisa
				'solar' => $d['solar'], // Solar
				'uang_makan' => $d['uangmakan'], // Uang Makan
				'biaya_lain' => $d['biayalain'], // Biaya Lain-Lain
				'namacmt'=>$d['namadriver'],
				'nominal'=>$d['nominal'],
				'sisa_cash' => $d['sisa_cash'], // Sisa Cash
				'km' => $d['km'], // KM
				'tujuan' => $d['tujuan'], // Tujuan
				'keterangan'=>$d['keterangan'],
				'keterangan2'=>$d['keterangan2'],
			);
		}
		return $hasil;
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