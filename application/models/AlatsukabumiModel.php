<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AlatsukabumiModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function show($data){
		$hasil=[];
		$sql="SELECT als.*, p.nama as namaalat FROM alat_sukabumi als JOIN product p ON(p.product_id=als.id_persediaan) WHERE als.hapus=0 ";
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
					'nama'=>$r['namaalat'],
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
					'idbarangkeluar'=>$p['idbarangkeluar'],
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

	public function stock($data){
		$hasil=[];
		$sql="SELECT a.*, p.nama as namaalat FROM stok_barang_skb a LEFT JOIN product p ON(p.product_id=a.id_persediaan) WHERE a.hapus=0 ";
		$sql.=" ORDER BY p.nama ASC ";
		$result=$this->GlobalModel->QueryManual($sql);
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'id'=>$r['id_persediaan'],
					'nama'=>$r['namaalat'],
					'jumlah'=>$r['stock'],
					'satuan'=>$r['satuan'],
				);
			}
		}
		return $hasil;
	}

	public function distribusi($data){
		$hasil=[];
		$sql="SELECT d.*, mc.cmt_name, s.nama, s.satuan FROM distribusi_alat_sukabumi d ";
		$sql.=" LEFT JOIN master_cmt mc ON mc.id_cmt=d.idcmt ";
		$sql.=" LEFT JOIN stok_barang_skb s ON s.id_persediaan=d.id_persediaan ";
		$sql.=" WHERE d.hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(d.tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}

		$sql.=" ORDER BY d.id DESC ";
		$result=$this->GlobalModel->QueryManual($sql);
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'id'=>$r['id'],
					'tanggal'=>date("d-m-Y",strtotime($r['tanggal'])),
					'nama'=>strtolower($r['cmt_name']),
					'alat'=>strtolower($r['nama']),
					'jumlah'=>$r['jumlah'],
					'satuan'=>$r['satuan'],
					'keterangan'=>strtolower($r['keterangan']),
					'validasi'=>$r['validasi'],
					'nomorsj'=>$r['nomorsj'],
				);
			}
		}
		return $hasil;
	}

	public function distribusi_save(){
		$post = $this->input->post();
		if($post['jumlah'] >0){
			$insert = array(
				'tanggal' => isset($post['tanggal']) ? $post['tanggal'] : date('Y-m-d'),
				'id_persediaan' => $post['id_persediaan'],
				'idcmt'	=> $post['idcmt'],
				'jumlah' => $post['jumlah'],
				'keterangan' => $post['keterangan'],
				'hapus'=>0,
				'validasi'=>0,
				'nomorsj'=>isset($post['nomorsj'])? $post['nomorsj']:null,
			);
			$this->db->insert('distribusi_alat_sukabumi',$insert);
			$id = $this->db->insert_id();
			$this->db->query("UPDATE stok_barang_skb set stock=stock-'".$post['jumlah']."' WHERE id_persediaan='".$post['id_persediaan']."' ");
			user_activity(callSessUser('id_user'),1,' menambahkan distribusi alat dengan id '.$id);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan. Stok alat habis<br>'.json_encode($post));
			redirect($this->url.'distribusi');
		}
	}

	public function distribusi_hapus($id){
		$transaksi = $this->GlobalModel->GetDataRow('distribusi_alat_sukabumi',array('id'=>$id));
		$this->db->update(
			'distribusi_alat_sukabumi',
			array(
				'hapus'=>1
			),
			array(
				'id'=>$id
			)
		);
		$this->db->query("UPDATE stok_barang_skb set stock=stock+'".$transaksi['jumlah']."' WHERE id_persediaan='".$transaksi['id_persediaan']."' ");
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		user_activity(callSessUser('id_user'),1,' hapus distribusi alat-alat dengan id '.$id);
		redirect($this->url.'distribusi');
	}

	public function distribusi_validasi($id){
		$transaksi = $this->GlobalModel->GetDataRow('distribusi_alat_sukabumi',array('id'=>$id));
		$this->db->update(
			'distribusi_alat_sukabumi',
			array(
				'validasi'=>1
			),
			array(
				'id'=>$id
			)
		);

		$cmt = $this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$transaksi['idcmt']));
		$insert_stok = array(
			'id_persediaan' => $transaksi['id_persediaan'],
			'tanggal' => isset($transaksi['tanggal']) ? $transaksi['tanggal'] : date('Y-m-d'),
			'keterangan' => $transaksi['keterangan'] . ' '.$cmt['cmt_name'],
			'stokawal'	=>0,
			'masuk'		=>$transaksi['jumlah'],
			'keluar'	=>0,
			
		);

		user_activity(callSessUser('id_user'),1,' validasi distribusi alat-alat dengan id '.$id);
		
		$this->session->set_flashdata('msg','Data berhasil divalidasi');
		redirect($this->url.'distribusi');
	}

}