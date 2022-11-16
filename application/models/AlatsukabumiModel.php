<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AlatsukabumiModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function show($data){
		$hasil=[];
		$sql="SELECT als.*, p.nama FROM alat_sukabumi als JOIN product p ON(p.product_id=als.idproduk) WHERE als.hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}

		$sql.=" ORDER BY id DESC ";
		$result=$this->GlobalModel->QueryManual($sql);
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'id'=>$r['id'],
					'tanggal'=>date("Y-m-",strtotime($r['tanggal'])),
					'nama'=>$r['nama'],
					'satuan'=>$r['satuan'],
					'keterangan'=>$r['keterangan'],
				);
			}
		}
		return $hasil;
	}

	public function insert($data){
		foreach($data['prods'] as $p){
			$insert=array(
				'tanggal'=>$p['tanggal'],
				'idproduk'=>$p['idproduk'],
				'jumlah_kirim'=>$p['jumlah_kirim'],
				'jumlah_terima'=>0,
				'tanggal_terima'=>null,
				'satuan'=>$p['satuan'],
				'keterangan'=>$p['keterangan'],
				'pembuat'=>callSessUser('nama_user'),
				'status'=>1, // 1 dikirim. 2 diterima
				'hapus'=>0,
			);
			$this->insert('alat_sukabumi',$insert);
		}
	}

	public function terima($id,$tanggal){
		$update=array(
			'status'=>2,
			'tanggal_terima'=>$tanggal,
		);
		$$id=array(
			'id'=>$id,
		);
		$this->db->update('alat_sukabumi',$update,$where);
	}

}