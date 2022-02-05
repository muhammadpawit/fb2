<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonitoringpojeansModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}


	public function getdata($data){
		$hasil=[];
		$sql=" SELECT kbp.refpo,fkg.kode_po,fkg.jumlah_piece_diterima as jmlkg,kks.id_master_cmt,kks.qty_tot_pcs,fkg.created_date as tglkg FROM konveksi_buku_potongan kbp JOIN finishing_kirim_gudang fkg ON(kbp.refpo=fkg.kode_po) JOIN kelolapo_kirim_setor kks ON(kks.kode_po=fkg.kode_po) WHERE refpo<>'' ";
		$sql.=" AND kks.progress='KIRIM' and kks.kategori_cmt='JAHIT' ";
		if(!empty($data['tanggal1'])){
			$sql .= " AND DATE(fkg.created_date) BETWEEN '".$data['tanggal1']."'  AND '".$data['tanggal2']."' ";
		}
		$sql.=" GROUP BY kbp.refpo ";
		$sql.=" ORDER BY fkg.created_date DESC ";

		if($data['limit']<1){
			$sql.=" LIMIT 20";
		}
		$data=$this->GlobalModel->QueryManual($sql);
		$kirim=0;
		$cmt=null;
		$status=null;
		$keterangan=null;
		$packings=null;
		foreach($data as $d){
			//$kirim=$this->GlobalModel->QueryManualRow("SELECT FROM kelolapo_kirim_setor WHERE kode");
			$cmt=$this->GlobalModel->QueryManualRow("SELECT * FROM master_cmt WHERE id_cmt='".$d['id_master_cmt']."' ");
			$packing=$this->GlobalModel->QueryManualRow("SELECT create_date,SUM(qty_tot_pcs) as pcs FROM kelolapo_kirim_setor WHERE kode_po='".$d['refpo']."' AND progress='SETOR' and kategori_cmt='JAHIT' AND id_master_cmt='".$d['id_master_cmt']."' ");
			$hasil[]=array(
				'id'=>null,
				'namacmt'=>$cmt['cmt_name'],
				'kode_po'=>$d['refpo'],
				'kirim'=>$d['qty_tot_pcs'],
				'tglpacking'=>!empty($packing)?date('d-m-Y',strtotime($packing['create_date'])):'',
				'pcspacking'=>!empty($packing)?$packing['pcs']:'',
				'tglkg'=>date('d-m-Y',strtotime($d['tglkg'])),
				'jmlkg'=>$d['jmlkg'],
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
			$sql .= " AND DATE(tanggal) BETWEEN ".$data['tanggal1'].'  AND '.$data['tanggal2'].'';
		}

		$sql.="ORDER BY id DESC ";
		if($data['limit']<1){
			$sql.=" LIMIT 20";
		}
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

	public function insert_driver($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>$p['tanggal'],
					'namadriver'=>$p['namadriver'],
					'nominal'=>$p['nominal'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0
				);
				$this->db->insert('transport_driver',$insert);
			}
		}
	}

	public function hapus_driver($id){
		$this->db->update('transport_driver',array('hapus'=>1),array('id'=>$id));
	}

	

}