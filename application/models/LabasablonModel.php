<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LabasablonModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function pendapatan($tanggal1,$tanggal2){

		$results=array();
		$hasil = [];
		$sql="SELECT ps.idcmt as id_master_cmt, mc.cmt_name as nama_cmt, SUM(ps.total_pendapatan) as jumlah 
			FROM pembayaran_sablon ps 
			JOIN master_cmt mc ON mc.id_cmt=ps.idcmt 
			WHERE ps.hapus=0 
			AND DATE(ps.tanggal_bayar) BETWEEN '".$tanggal1."' AND '".$tanggal2."' 
			GROUP BY ps.idcmt";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$hasil[]=array(
				'no'=>$no++,
				'cmt'=>	$r['nama_cmt'],
				'jumlah'=>	($r['jumlah']),
			);
			
		}
		return $hasil;
	}

	function pengeluaran($tanggal1,$tanggal2){
		$data['pengeluaran']=[];
		$sqlp="SELECT COALESCE(SUM(belanjacat)) as belanjacat,
		COALESCE(SUM(upahtukang_harian)) as upahtukang_harian,
		COALESCE(SUM(upahtukang_borongan)) as upahtukang_borongan,
		COALESCE(SUM(biayalain)) as biayalain,
		COALESCE(SUM(tokenlistrik)) as tokenlistrik 
		FROM pengeluaran_sablon WHERE hapus=0 ";
		$sqlp.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and hapus=0";
		// AND idcmt='".$cmt."' 
		$sqlp.=" GROUP BY tanggal ";
		$res=$this->GlobalModel->querymanual($sqlp);
		// pre($res);
		$p=1;
		foreach($res as $r){
			$data['pengeluaran']=array(
				// 'no'=>$p++,
				'Belanja Cat'=>($r['belanjacat']),
				'Upah Tukang Harian'=>($r['upahtukang_harian']),
				'Upah Tukang Borongan'=>($r['upahtukang_borongan']),
				'biayalain'=>($r['biayalain']),
				'Token Listrik '=>($r['tokenlistrik']),
				// 'total'=>($r['total']),
			);
		}
		return $data['pengeluaran'];
	}

}