<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class kirimsetorModel extends CI_Model {



	function __construct() {

		parent::__construct();

	}

	public function kirimgudangharianresume($data){
		$hasil=[];
		$results=[];
		$sql="SELECT COALESCE(SUM(jumlah_piece_diterima/12),0) as pcs,mjp.nama_jenis_po,count(kg.kode_po) as jml,SUM(kg.jumlah_harga_piece) as nilai,mjp.perkalian FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		//$sql.=" AND kg.susulan IN(2) ";
		if(isset($data['online'])){
			$sql.=" AND mjp.online='".$data['online']."' ";
		}
		$sql.=" AND lower(kg.keterangan) NOT IN('kirim sample','po susulan') ";
		$sql.="GROUP BY mjp.nama_jenis_po";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$jumlah=$row['jml'];
			if($row['nama_jenis_po']=="SKF"){
				$jumlah=($row['jml']*$row['perkalian']);
			}
			$hasil[]=array(
				'jml'=>$jumlah,
				'nama'=>$row['nama_jenis_po'],
				'pcs'=>$row['pcs']+$this->kirimgudangharianresume_dz($data,$row['nama_jenis_po']),
				'nilai'=>$row['nilai']
			);
		}
		return $hasil;
	}

	public function kirimgudangharianresume_dz($data,$namapo){
		$hasil=0;
		$results=[];
		$sql="SELECT COALESCE(SUM(jumlah_piece_diterima/12),0) as pcs FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		//$sql.=" AND kg.susulan IN(2) ";
		$sql.=" AND mjp.nama_jenis_po='".$namapo."' ";
		$sql.=" AND lower(kg.keterangan) IN('kirim sample','po susulan') ";
		$sql.="GROUP BY mjp.nama_jenis_po";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil=($row['pcs']);
		}
		return $hasil;
	}

	public function kirimgudangharian_jml($data,$namapo, $tanggal){ // untuk mengurangi jumlah po yang tampil, karena po sample dan po susulan tidak dihitung dalam jumlah po
		$hasil=[];
		$results=[];
		$susulan=0;
		$susulan=$this->kirimgudangharian_jml_susulan($data,$namapo,$tanggal);
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		if(!empty($tanggal)){
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) ='".$tanggal."'";
		}else{
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."'";
		}
		//$sql.=" AND kg.susulan IN(2) ";
		$sql.=" AND mjp.nama_jenis_po='".$namapo."' ";
		$sql.=" AND lower(kg.keterangan) IN('kirim sample','po susulan') ";
		$sql.="GROUP BY mjp.nama_jenis_po ";
		$results=$this->GlobalModel->QueryManual($sql);
		$jumlah=0;
		$dz=0;
		$nilai=0;
		foreach($results as $row){
			$jumlah=$row['jml'];
			$dz=$row['pcs']/12;
			$nilai=$row['nilai'];
		}
		$hasil = array(
			'jumlah' 	=> $jumlah+$susulan['jumlah'],
			'dz'		=> $dz,
			'nilai'		=> $nilai,
		);
		return $hasil;
	}

	public function kirimgudangharian_jml_susulan($data,$namapo, $tanggal){ // untuk mengurangi jumlah po yang tampil, karena po sample dan po susulan tidak dihitung dalam jumlah po
		$hasil=[];
		$results=[];
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		if(!empty($tanggal)){
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) ='".$tanggal."'";
		}else{
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."'";
		}
		//$sql.=" AND kg.susulan IN(2) ";
		$sql.=" AND mjp.nama_jenis_po='".$namapo."' ";
		$sql.=" AND lower(kg.keterangan) LIKE 'po susulan%' ";
		$sql.="GROUP BY mjp.nama_jenis_po ";
		$results=$this->GlobalModel->QueryManual($sql);
		$jumlah=0;
		$dz=0;
		$nilai=0;
		foreach($results as $row){
			//$jumlah=$row['jml'];
		}
		$hasil = array(
			'jumlah' 	=> $jumlah,
		);
		return $hasil;
	}

	public function kirimgudangharian_group($data){
		$hasil=[];
		$results=[];
		$sql="SELECT kg.tanggal_kirim,kg.keterangan FROM finishing_kirim_gudang kg 
			JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		//$sql.=" AND kg.susulan IN(2) ";
		//$sql.=" AND lower(kg.keterangan) NOT LIKE 'Kirim Sample%' ";
		if(isset($data['online'])){
			$sql.=" AND mjp.online='".$data['online']."' ";
		}
		$sql.="GROUP BY kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'hari'=>hari(date('l',strtotime($row['tanggal_kirim']))),
				'tanggal'=>date('d-m-Y',strtotime($row['tanggal_kirim'])),
				'jml'=>$this->kirimgudangharian_jml_group_sum($row['tanggal_kirim'])['total'],
				'pcs'=>null,
				'dz'=>$this->kirimgudangharian_jml_group($row['tanggal_kirim'])['jumlah'],
				'nama'=>null,
				'nilai'=>$this->kirimgudangharian_jml_group($row['tanggal_kirim'])['nilai'],
				'tujuan'=>null,
				'keterangan'=>$this->kirimgudangharian_jml_group($row['tanggal_kirim'])['keterangan'],
			);
		}
		return $hasil;
	}

	public function kirimgudangharian_jml_group($tanggal){
		$hasil=[];
		$results=[];
		$sql="SELECT kg.keterangan,COALESCE(SUM(kg.jumlah_piece_diterima/12),0) as jml,SUM(kg.jumlah_harga_piece) as nilai FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		if(!empty($tanggal)){
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) ='".$tanggal."'";
		}else{
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."'";
		}
		//$sql.=" AND kg.susulan IN(2) ";
		//$sql.=" AND mjp.nama_jenis_po='".$namapo."' ";
		$sql.=" AND lower(kg.keterangan) IN('kirim sample','po susulan') ";
		
		$sql.="GROUP BY kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		$jumlah=0;
		$nilai=0;
		$keterangan='';
		foreach($results as $row){
			$jumlah=$row['jml'];
			$nilai=$row['nilai'];
			$keterangan=$row['keterangan'];
		}
		$hasil = array(
			'jumlah' => $jumlah,
			'nilai'  => $nilai,
			'keterangan'=>$keterangan,
		);
		return $hasil;
	}

	public function kirimgudangharian_jml_group_sum($tanggal){
		$hasil=[];
		$results=[];
		$sql="SELECT COUNT(kg.kode_po) as total FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		if(!empty($tanggal)){
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) ='".$tanggal."'";
		}else{
			$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."'";
		}
		//$sql.=" AND kg.susulan IN(2) ";
		//$sql.=" AND mjp.nama_jenis_po='".$namapo."' ";
		$sql.=" AND lower(kg.keterangan) NOT IN('kirim sample','po susulan') ";
		
		$sql.="GROUP BY kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		$jumlah=0;
		$nilai=0;
		$keterangan='';
		foreach($results as $row){
			$jumlah=$row['total'];
			
		}
		$hasil = array(
			'total' => $jumlah,
		);
		return $hasil;
	}

	public function kirimgudangharian_hari($tanggal,$hari,$data){
		$hasil=[];
		$results=[];
		$tanggal=date('Y-m-d',strtotime($tanggal));
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan,kg.nama_penerima FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 ";
		$sql.=" and DATE(tanggal_kirim)='".$tanggal."' ";
		if(isset($data['online'])){
			$sql.=" AND mjp.online='".$data['online']."' ";
		}
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
					'tgl'=>date('Y-m-d',strtotime($row['tanggal_kirim'])),
					'jml'=>$jumlah-$this->kirimgudangharian_jml($tanggal,$row['nama_jenis_po'],$row['tanggal_kirim'])['jumlah'],
					'pcs'=>$row['pcs'],
					'dz'=>($row['pcs']/12) - $this->kirimgudangharian_jml($tanggal,$row['nama_jenis_po'],$row['tanggal_kirim'])['dz'],
					'nama'=>$row['nama_jenis_po'],
					'nilai'=>$row['nilai'] - $this->kirimgudangharian_jml($tanggal,$row['nama_jenis_po'],$row['tanggal_kirim'])['nilai'],
					'tujuan'=>$row['tujuan'],
					'keterangan'=> $row['nama_penerima'].' '.$row['tujuan'].' ('. $row['keterangan'].')',
				);
			}
			
		}
		return $hasil;
	}

	public function kirimgudangharian($data){
		$hasil=[];
		$results=[];
		$sql="SELECT SUM(jumlah_piece_diterima) as pcs,kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai, tujuan,
		kg.keterangan FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
		$sql.=" p.hapus=0 and DATE(tanggal_kirim) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		//$sql.=" AND kg.susulan IN(2) ";
		//$sql.=" AND lower(kg.keterangan) NOT LIKE 'Kirim Sample%' ";
		$sql.="GROUP BY mjp.nama_jenis_po,kg.tanggal_kirim ORDER BY kg.tanggal_kirim";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$jumlah=$row['jml'];
			if($row['nama_jenis_po']=="SKF"){
				$jumlah=($row['jml']*$row['perkalian']);
			}
			if(strtolower($row['keterangan']) == 'kirim sample' ){
				$jumlah-= $this->kirimgudangharian_jml($data,$row['nama_jenis_po'],$row['tanggal_kirim']);
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
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
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
		$sql="SELECT count(kbp.kode_po) as total, mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0 AND mjp.idjenis IN(1,2,3) and mjp.tampil=1 ";
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
		$sql="SELECT SUM(kbp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.kategori_cmt='JAHIT' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
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
		$sql="SELECT SUM(kbp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0  AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0 AND mjp.idjenis IN(1,2,3) and mjp.tampil=1 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		if(!empty($jenis)){
			$sql.=" AND mjp.id_jenis_po='$jenis' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		$bangkenya=0;
		$sisa=0;
		if($proses=='SETOR'){
			// bangke 
			
			$bangke="SELECT COALESCE(SUM(bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and kbp.id_master_cmt='$cmt' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='$proses' and mjp.id_jenis_po='$jenis' AND kbp.hapus=0";
			if(!empty($tanggal1)){
				$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
			$dbangke=$this->db->query($bangke)->row();

			// pengembalian bangke
			$susulan=[];
			$kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(qty),0) as total FROM pengembalian_bangke where hapus=0 and kode_po LIKE '%".$jenis."%' ");
			$pot_drikeu=$this->GlobalModel->QueryManualRow("SELECT * FROM potongan_bangke where hapus=0 and kode_po LIKE '%".$jenis."%' ");
			if(empty($pot_drikeu)){
				$diterima_seharusnya=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$jenis."%' GROUP BY id_kelolapo_rincian_setor_cmt ORDER BY id_kelolapo_rincian_setor_cmt ASC LIMIT 1 ");
				$bangke=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$jenis."%' ");
				$kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_lusin*12)+SUM(rincian_piece+rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$jenis."%'  ");
				$sisa = $kembali['total'];
			}else{
				$susulan=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$jenis."%' GROUP BY id_kelolapo_rincian_setor_cmt LIMIT 18446744073709551615 OFFSET 1");
				// $sisa = $bangke['total']-$kembali['total'];
				$susul = !empty($susulan['total']) ? $susulan['total']:0;
				$sisa = $dbangke->total;
			}

			// pre($bangke['total']);
			
			if(!empty($dbangke)){
				$bangkenya=$sisa;
			}
		}
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']-$bangkenya+$sisa:'');
			// return $sisa;
		}else{
			$out=0;
			return $out;
		}		
	}

	public function kirimgudang($data){
		$hasil=[];
		$results=[];
		$sql="SELECT kg.tanggal_kirim,count(kg.kode_po) as jml,mjp.nama_jenis_po,mjp.perkalian,SUM(kg.jumlah_harga_piece) as nilai FROM finishing_kirim_gudang kg JOIN produksi_po p ON(p.id_produksi_po=kg.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE ";
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
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
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
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
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
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
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
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
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
		$sql="SELECT count(kbp.kode_po) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		
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
		$sql="SELECT SUM(qty_tot_pcs/12) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis='$jenis' AND kbp.kategori_cmt='$kategori' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0";
		

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
		$sql="SELECT COUNT(*) as jml, SUM(jumlah_pcs/12) as dz,kd.kode_po FROM kirimcmt k JOIN kirimcmt_detail kd ON(kd.idkirim=k.id)  JOIN produksi_po p ON(p.id_produksi_po=kd.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and idcmt='".$id."' AND mjp.idjenis='$jenis' AND k.hapus=0 and kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
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
		$sql=" SELECT count(ks.kode_po) as total,sum(qty_tot_pcs) as pcs,mjp.perkalian FROM kelolapo_kirim_setor ks JOIN produksi_po p ON(p.id_produksi_po=ks.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po)  WHERE p.hapus=0 AND ks.kategori_cmt='JAHIT' AND ks.progress='KIRIM' AND ks.id_master_cmt='$id' AND mjp.idjenis IN('$jenis')  AND DATE(ks.create_date) <'$tanggal' AND ks.idpo NOT IN (SELECT kode_po FROM kelolapo_kirim_setor ";
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
		$sql="SELECT k.nosj,kd.*,mjp.perkalian FROM kirimcmt k JOIN kirimcmt_detail kd ON(kd.idkirim=k.id)  JOIN produksi_po p ON(p.id_produksi_po=kd.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.idjenis IN('$jenis') AND idcmt='".$id."' AND k.hapus=0 and kd.hapus=0 AND kd.idpo NOT IN (SELECT kode_po FROM setorcmt_detail WHERE hapus=0 ) ";
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

	public function rekapjumlah_tglklo($jenis,$cmt,$proses,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT count(DISTINCT kbp.kode_po) as total, mjp.perkalian FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and mjp.id_jenis_po='$jenis' AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0 AND mjp.idjenis IN(1,2,3) and mjp.tampil IN (1,2) ";
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

	public function rekappcs_tglklo($jenis,$cmt,$proses,$tanggal1,$tanggal2){
		$hasil=null;
		$sql="SELECT SUM(kbp.qty_tot_pcs) as total FROM `kelolapo_kirim_setor` kbp JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 AND kbp.id_master_cmt='$cmt' AND kbp.progress='$proses' AND kbp.hapus=0 AND mjp.idjenis IN(1,2,3) and mjp.tampil IN (1,2) ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		if(!empty($jenis)){
			$sql.=" AND mjp.id_jenis_po='$jenis' ";
		}
		$row=$this->db->query($sql)->row_array();
		$hasil=$row;
		$bangkenya=0;
		$sisa=0;
		if($proses=='SETOR'){
			// bangke 
			
			$bangke="SELECT COALESCE(SUM(bangke_qty),0) as total FROM kelolapo_rincian_setor_cmt rpo ";
			$bangke.=" LEFT JOIN kelolapo_kirim_setor kbp ON kbp.kode_po=rpo.kode_po LEFT JOIN produksi_po p ON(p.id_produksi_po=kbp.idpo) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=p.nama_po) WHERE p.hapus=0 and kbp.id_master_cmt='$cmt' and  mjp.tampil=1 AND kbp.kategori_cmt='JAHIT' AND kbp.progress='$proses'  AND kbp.hapus=0";
			if(!empty($tanggal1)){
				$bangke.=" AND DATE(kbp.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}

			if(!empty($jenis)){
				$bangke.=" AND mjp.id_jenis_po='$jenis' ";
			}
			$dbangke=$this->db->query($bangke)->row();

			// pengembalian bangke
			$susulan=[];
			$kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(qty),0) as total FROM pengembalian_bangke where hapus=0 and kode_po LIKE '%".$jenis."%' ");
			$pot_drikeu=$this->GlobalModel->QueryManualRow("SELECT * FROM potongan_bangke where hapus=0 and kode_po LIKE '%".$jenis."%' ");
			if(empty($pot_drikeu)){
				$diterima_seharusnya=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$jenis."%' GROUP BY id_kelolapo_rincian_setor_cmt ORDER BY id_kelolapo_rincian_setor_cmt ASC LIMIT 1 ");
				$bangke=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$jenis."%' ");
				$kembali=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(rincian_lusin*12)+SUM(rincian_piece+rincian_bangke),0) as total FROM kelolapo_rincian_setor_cmt_finish where kode_po LIKE '%".$jenis."%'  ");
				$sisa = $kembali['total'];
			}else{
				$susulan=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima),0) as total FROM kelolapo_rincian_setor_cmt  where kode_po LIKE '%".$jenis."%' GROUP BY id_kelolapo_rincian_setor_cmt LIMIT 18446744073709551615 OFFSET 1");
				// $sisa = $bangke['total']-$kembali['total'];
				$susul = !empty($susulan['total']) ? $susulan['total']:0;
				$sisa = $dbangke->total;
			}

			// pre($bangke['total']);
			
			if(!empty($dbangke)){
				$bangkenya=$sisa;
			}
		}
		if($hasil['total']>0){
			return ($hasil['total']>0?$hasil['total']-$bangkenya+$sisa:'');
			// return $hasil['total'];
		}else{
			$out=0;
			return $out;
		}		
	}

}
