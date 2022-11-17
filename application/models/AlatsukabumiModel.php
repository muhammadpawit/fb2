<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AlatsukabumiModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function show($data){
		$hasil=[];
		$sql="SELECT als.*, p.nama FROM alat_sukabumi als JOIN product p ON(p.product_id=als.id_persediaan) WHERE als.hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}

		$sql.=" ORDER BY id DESC ";
		$result=$this->GlobalModel->QueryManual($sql);
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'id'=>$r['id'],
					'tanggal'=>date("d-m-Y",strtotime($r['tanggal'])),
					'nama'=>$r['nama'],
					'jumlah'=>$r['jumlah_terima'],
					'satuan'=>$r['satuan'],
					'keterangan'=>$r['keterangan'],
				);
			}
		}
		return $hasil;
	}

	public function insert($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>date('Y-m-d'),
					'id_persediaan'=>$p['idpersediaan'],
					'nama'=>$p['nama'],
					'jumlah_kirim'=>$p['jumlah'],
					'jumlah_terima'=>$p['terima'],
					'tanggal_terima'=>$data['tanggal'],
					'satuan'=>$p['satuan'],
					'keterangan'=>$p['keterangan'],
					'pembuat'=>callSessUser('nama_user').' pada '.date('d-m-Y H:i:s'),
					'status'=>2, // 1 dikirim. 2 diterima
					'hapus'=>0,
				);
				$this->db->insert('alat_sukabumi',$insert);
				$cek=$this->GlobalModel->getDataRow('stok_barang_skb',array('hapus'=>0,'id_persediaan'=>$p['idpersediaan']));
				if(!empty($cek)){
					$this->db->query("UPDATE stok_barang_skb SET stock=stock+'".$p['terima']."' WHERE id_persediaan='".$p['idpersediaan']."' AND hapus=0 ");
				}else{
					$insertbarang=array(
						'id_persediaan'=>$p['idpersediaan'],
						'nama'=>$p['nama'],
						'stock'=>$p['terima'],
						'satuan'=>$p['satuan'],
						'hapus'=>0,
					);
					$this->db->insert('stok_barang_skb',$insertbarang);
				}
			}
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