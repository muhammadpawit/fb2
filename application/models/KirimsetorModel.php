<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class kirimsetorModel extends CI_Model {



	function __construct() {

		parent::__construct();

	}

	public function kirimgudangharianresume($data){
		$hasil=[];
		$results=[];
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai,tujuan, kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.kode_po=kg.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		//$sql.=" AND kg.susulan IN(2) ";
		$sql.="GROUP BY mjp.nama_jenis_po ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$jumlah=$row['jml'];
			if($row['nama_jenis_po']=="SKF"){
				$jumlah=($row['jml']*$row['perkalian']);
			}
			$hasil[]=array(
				'jml'=>$jumlah - $this->kirimgudangharian_jml($data,$row['nama_jenis_po']),
				'nama'=>$row['nama_jenis_po'],
				'pcs'=>$row['pcs'],
				'nilai'=>$row['nilai']
			);
		}
		return $hasil;
	}

	public function kirimgudangharian_jml($data,$namapo){
		$hasil=[];
		$results=[];
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.kode_po=kg.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		//$sql.=" AND kg.susulan IN(2) ";
		$sql.=" AND mjp.nama_jenis_po='".$namapo."' ";
		$sql.=" AND lower(kg.keterangan) LIKE 'kirim sample%' ";
		$sql.="GROUP BY mjp.nama_jenis_po,kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		$jumlah=0;
		foreach($results as $row){
			$jumlah=$row['jml'];
		}
		return $jumlah;
	}

	public function kirimgudangharian_group($data){
		$hasil=[];
		$results=[];
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.kode_po=kg.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		$sql.=" AND kg.susulan IN(2) ";
		//$sql.=" AND lower(kg.keterangan) NOT LIKE 'Kirim Sample%' ";
		$sql.="GROUP BY kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$jumlah=$row['jml'];
			if($row['nama_jenis_po']=="SKF"){
				$jumlah=($row['jml']*$row['perkalian']);
			}
			if(strtolower($row['keterangan']) == 'kirim sample' ){
				$jumlah-= $this->kirimgudangharian_jml($data,$row['nama_jenis_po']);
			}
			$hasil[]=array(
				'hari'=>hari(date('l',strtotime($row['tanggal_kirim']))),
				'tanggal'=>date('d-m-Y',strtotime($row['tanggal_kirim'])),
				'jml'=>$jumlah,
				'pcs'=>$row['pcs'],
				'nama'=>$row['nama_jenis_po'],
				'nilai'=>$row['nilai'],
				'tujuan'=>$row['tujuan'],
				'keterangan'=> $row['keterangan'],
			);
		}
		return $hasil;
	}

	public function kirimgudangharian_hari($data,$hari){
		$hasil=[];
		$results=[];
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.kode_po=kg.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		//$sql.=" AND kg.susulan IN(2) ";
		//$sql.=" AND lower(kg.keterangan) NOT LIKE 'kirim sample%' ";
		$sql.="GROUP BY mjp.nama_jenis_po,kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			if( strtolower(hari(date('l',strtotime($row['tanggal_kirim'])))) == strtolower($hari) ){
				$jumlah=$row['jml'];
				if($row['nama_jenis_po']=="SKF"){
					$jumlah=($row['jml']*$row['perkalian']);
				}
				
				$hasil[]=array(
					'hari'=>hari(date('l',strtotime($row['tanggal_kirim']))),
					'tanggal'=>date('d-m-Y',strtotime($row['tanggal_kirim'])),
					'jml'=>$jumlah-$this->kirimgudangharian_jml($data,$row['nama_jenis_po']),
					'pcs'=>$row['pcs'],
					'dz'=>$row['pcs']/12,
					'nama'=>$row['nama_jenis_po'],
					'nilai'=>$row['nilai'],
					'tujuan'=>$row['tujuan'],
					'keterangan'=> 'H Soleh ('. $row['keterangan'].')',
				);
			}
			
		}
		return $hasil;
	}

	public function kirimgudangharian($data){
		$hasil=[];
		$results=[];
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.kode_po=kg.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		$sql.=" AND kg.susulan IN(2) ";
		//$sql.=" AND lower(kg.keterangan) NOT LIKE 'Kirim Sample%' ";
		$sql.="GROUP BY mjp.nama_jenis_po,kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$jumlah=$row['jml'];
			if($row['nama_jenis_po']=="SKF"){
				$jumlah=($row['jml']*$row['perkalian']);
			}
			if(strtolower($row['keterangan']) == 'kirim sample' ){
				$jumlah-= $this->kirimgudangharian_jml($data,$row['nama_jenis_po']);
			}
			$hasil[]=array(
				'hari'=>hari(date('l',strtotime($row['tanggal_kirim']))),
				'tanggal'=>date('d-m-Y',strtotime($row['tanggal_kirim'])),
				'jml'=>$jumlah,
				'pcs'=>$row['pcs'],
				'nama'=>$row['nama_jenis_po'],
				'nilai'=>$row['nilai'],
				'tujuan'=>$row['tujuan'],
				'keterangan'=> $row['keterangan'],
			);
		}
		return $hasil;
	}

	public function rekapjumlah($jenis,$cmt,$proses,$bulan,$tahun){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($bulan)){
			$sql.=" AND MONTH(kbp.create_date) ='".$bulan."' ";
		}
		if(!empty($tahun)){
			$sql.=" AND YEAR(kbp.create_date) ='".$tahun."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=0;
			return $out;
		}		
	}

	public function rekapjumlah_tgl($jenis,$cmt,$proses,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total, mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0 AND mjp.idjenis IN(1,2,3) and mjp.tampil=1 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		if(!empty($tanggal2)){
			//$sql.=" AND DATE(kbp.create_date) ='".$tanggal2."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']*$hasil['perkalian']:'');
		}else{
			$out=0;
			return $out;
		}		
	}

	public function rekappcs($jenis,$cmt,$proses,$bulan,$tahun){
		$hasil=null;
		$sql="SELECT SUM(kbp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($bulan)){
			$sql.=" AND MONTH(kbp.create_date) ='".$bulan."' ";
		}
		if(!empty($tahun)){
			$sql.=" AND YEAR(kbp.create_date) ='".$tahun."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=0;
			return $out;
		}		
	}

	public function rekappcs_tgl($jenis,$cmt,$proses,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT SUM(kbp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0 AND mjp.idjenis IN(1,2,3) and mjp.tampil=1 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		if(!empty($tanggal2)){
			//$sql.=" AND DATE(kbp.create_date) ='".$tanggal2."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		$bangkenya=0;
		if($proses=='SETOR'){
			// bangke 
			
			$bangke="SELECT COALESCE(SUM(bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and kbp.id_master_cmt='$cmt' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='$proses' and mjp.id_jenis_po='$jenis' AND kbp.hapus=0";
			if(!empty($tanggal1)){
				$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
			$dbangke=$this->db->query($bangke)->row();
			
			if(!empty($dbangke)){
				$bangkenya=$dbangke->total;
			}
		}
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']-$bangkenya:'');
		}else{
			$out=0;
			return $out;
		}		
	}

	public function kirimgudang($data){
		$hasil=[];
		$results=[];
		$sql="SELECT kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.kode_po=kg.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and MONTH(tanggal_kirim) ='".$data['bulan']."' AND YEAR(tanggal_kirim) ='".$data['tahun']."' ";
		$sql.="GROUP BY mjp.nama_jenis_po,kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$jumlah=$row['jml'];
			if($row['nama_jenis_po']=="SKF"){
				$jumlah=($row['jml']*$row['perkalian']);
			}
			$hasil[]=array(
				'hari'=>hari(date('l',strtotime($row['tanggal_kirim']))),
				'tanggal'=>date('d-m-Y',strtotime($row['tanggal_kirim'])),
				'jml'=>$jumlah,
				'nama'=>$row['nama_jenis_po'],
				'nilai'=>$row['nilai']
			);
		}
		return $hasil;
	}

	public function awaljumlah($jenis,$tanggal1,$tanggal2,$cmt,$proses,$kategori){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) < '$tanggal1' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function awaldz($jenis,$tanggal1,$tanggal2,$cmt,$proses,$kategori){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) < '$tanggal1' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function jumlah($jenis,$tanggal1,$tanggal2,$cmt,$proses,$kategori){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function dz($jenis,$tanggal1,$tanggal2,$cmt,$proses,$kategori){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	/*

	public function awaljumlah($jenis,$tanggal1,$tanggal2,$cmt,$proses){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) < '$tanggal1' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function awaldz($jenis,$tanggal1,$tanggal2,$cmt,$proses){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) < '$tanggal1' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function jumlah($jenis,$tanggal1,$tanggal2,$cmt,$proses){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function dz($jenis,$tanggal1,$tanggal2,$cmt,$proses){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}
	*/

	public function rjumlah($jenis,$bulan,$tahun,$cmt,$proses,$kategori){
		$hasil=null;
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		
		if(!empty($bulan)){
			$sql.=" AND MONTH(kbp.create_date) ='".$bulan."' ";
		}
		if(!empty($tahun)){
			$sql.=" AND YEAR(kbp.create_date) ='".$tahun."' ";
		}

		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function rdz($jenis,$bulan,$tahun,$cmt,$proses,$kategori){
		$hasil=null;
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.kode_po=kbp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		

		if(!empty($bulan)){
			$sql.=" AND MONTH(kbp.create_date) ='".$bulan."' ";
		}
		if(!empty($tahun)){
			$sql.=" AND YEAR(kbp.create_date) ='".$tahun."' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']:'');
		}else{
			$out=null;
			return $out;
		}
	}

	public function stok($id,$jenis){
		$sj=[];
		$sql="SELECT COUNT(*) as jml, SUM(jumlah_pcs/12) as dz,kd.kode_po FROM kirimcmt k JOIN kirimcmt_detail kd ON(kd.idkirim=k.id)  JOIN produksi_po p ON(p.kode_po=kd.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and idcmt='".$id."' AND mjp.idjenis='$jenis' AND k.hapus=0 and kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
		$sj=$this->GlobalModel->queryManualRow($sql);
		return $sj;
	}

	public function sablon_detail($id){
		$sj=[];
		$surat=[];
		$sql="SELECT * FROM kirimcmtsablon_detail WHERE hapus=0 and idkirim='".$id."' ";
		$sj=$this->GlobalModel->queryManual($sql);
		foreach($sj as $k){
			$surat[]=$k['kode_po'];
		}
		$hasil=implode(", ", $surat);
		return $hasil;
	}

	public function stok_baru_kaos($id,$jenis,$tanggal){
		$sj=[];
		//$sql="SELECT k.nosj,kd.*,mjp.perkalian FROM kirimcmt k JOIN kirimcmt_detail kd ON(kd.idkirim=k.id)  JOIN produksi_po p ON(p.kode_po=kd.kode_po) ";
		//$sql .="LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE mjp.idjenis IN('$jenis') AND idcmt='".$id."' AND k.hapus=0 and kd.hapus=0 AND kd.kode_po NOT IN (SELECT kode_po FROM setorcmt_detail WHERE hapus=0 ) ";
		//$sql.=" AND DATE(k.tanggal) <'".$tanggal."' ";
		$sql=" SELECT count(ks.kode_po) as total,sum(qty_tot_pcs) as pcs,mjp.perkalian FROM kelolapo_kirim_setor ks JOIN produksi_po p ON(p.kode_po=ks.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po)  WHERE p.hapus=0 AND ks.kategori_cmt='JAHIT' AND ks.progress='KIRIM' AND ks.id_master_cmt='$id' AND mjp.idjenis IN('$jenis')  AND DATE(ks.create_date) <'$tanggal' AND ks.kode_po NOT IN (SELECT kode_po FROM kelolapo_kirim_setor ";
		$sql.="  WHERE id_master_cmt='$id' AND progress='SETOR' AND DATE(create_date) <'$tanggal' AND mjp.idjenis IN('$jenis') ) ";
		$sj=$this->GlobalModel->queryManual($sql);
		// pre($sql);
		$hasil=[];
		$i=0;
		if(!empty($sj)){
			foreach($sj as $s){
				// if( ($s['jumlah_pcs']-$s['totalsetor'])>0 ){
				// 	$hasil[]=$s['kode_po'];
					$hasil=array(
						'jml'=>($s['total']*$s['perkalian']),
						'dz'=>number_format($s['pcs']/12,2),
					);
				// }
			}
		}

		return $hasil;
	}

	public function stok_baru($id,$jenis){
		$sj=[];
		$sql="SELECT k.nosj,kd.*,mjp.perkalian FROM kirimcmt k JOIN kirimcmt_detail kd ON(kd.idkirim=k.id)  JOIN produksi_po p ON(p.kode_po=kd.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis IN('$jenis') AND idcmt='".$id."' AND k.hapus=0 and kd.hapus=0 AND kd.kode_po NOT IN (SELECT kode_po FROM setorcmt_detail WHERE hapus=0 ) ";
		$sj=$this->GlobalModel->queryManual($sql);
		$hasil=[];
		$i=0;
		if(!empty($sj)){
			foreach($sj as $s){
				if( ($s['jumlah_pcs']-$s['totalsetor'])>0 ){
					$hasil[]=$s['kode_po'];
					$i+=(1*$s['perkalian']);
				}
			}
		}
		return $i;
	}

}
