<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class GlobalModel extends CI_Model {



	function __construct() {

		parent::__construct();
		$this->db2 = $this->load->database('second', TRUE);

	}

	// setor

	public function getStokPOs($idcmt,$idjenis){
		$query="SELECT count(*) as jmlpo,SUM(kd.totalsetor) as pcs FROM setorcmt_detail kd JOIN setorcmt k ON(k.id=kd.idsetor) LEFT JOIN produksi_po pp ON(kd.kode_po=pp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.nama_po) WHERE k.idcmt='$idcmt' AND mjp.id_jenis_po='$idjenis' AND k.hapus=0 AND kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
		$dataReturn = $this->db->query($query)->row_array();
		return $dataReturn;
	}

	public function getStokrincianposetor($idcmt,$idjenis){
		$rp=null;
		$hasil=null;
		$query="SELECT kd.kode_po FROM setorcmt_detail kd JOIN setorcmt k ON(k.id=kd.idsetor) LEFT JOIN produksi_po pp ON(kd.kode_po=pp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.nama_po) WHERE k.hapus=0 AND kd.hapus=0 AND k.idcmt='$idcmt' AND mjp.id_jenis_po='$idjenis' AND kd.jumlah_pcs<>kd.totalsetor ";
		$dataReturn = $this->db->query($query)->result_array();
		foreach($dataReturn as $r){
				$rp[]=$r['kode_po'];
		}
		if(!empty($dataReturn)){
			$hasil=implode(",<br>", $rp);
		}
		return $hasil;
	}


	// end setor

	function dataproduct($table,$number,$offset,$data){

		if(!empty($data['product_id'])){
			$where=array(
				'hapus'=>0,
				'product_id'=>$data['product_id'],
			);
		}else if(!empty($data['jenis'])){
			$where=array(
				'hapus'=>0,
				'jenis'=>$data['jenis'],
			);
		}else{
			$where=array(
				'hapus'=>0
			);
		}
		return $query = $this->db->get_where($table,$where,$number,$offset)->result_array();		

	}

	function jumlah_dataproduct($table,$data){
		if(!empty($data['product_id'])){
			$where=array(
				'hapus'=>0,
				'product_id'=>$data['product_id'],
			);
		}else if(!empty($data['jenis'])){
			$where=array(
				'hapus'=>0,
				'jenis'=>$data['jenis'],
			);
		}else{
			$where=array(
				'hapus'=>0
			);
		}
		return $this->db->get_where($table,$where)->num_rows();

	}

	public function getStokPO($idcmt,$idjenis){
		$query="SELECT count(*) as jmlpo,SUM(kd.jumlah_pcs-kd.totalsetor) as pcs,mjp.perkalian FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) LEFT JOIN produksi_po pp ON(kd.kode_po=pp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.nama_po) WHERE k.idcmt='$idcmt' AND mjp.id_jenis_po='$idjenis' AND k.hapus=0 AND kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
		$dataReturn = $this->db->query($query)->row_array();
		return $dataReturn;
	}

	public function getStokrincianpo($idcmt,$idjenis){
		$rp=null;
		$hasil=null;
		$query="SELECT kd.kode_po FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) LEFT JOIN produksi_po pp ON(kd.kode_po=pp.kode_po) LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.nama_po) WHERE k.hapus=0 AND kd.hapus=0 AND k.idcmt='$idcmt' AND mjp.id_jenis_po='$idjenis' AND kd.jumlah_pcs<>kd.totalsetor ";
		$dataReturn = $this->db->query($query)->result_array();
		foreach($dataReturn as $r){
				$rp[]=$r['kode_po'];
				//$rp[]='<a href="'.BASEURL.'Kelolapo/kirimsetorcmt?kode_po='.$r['kode_po'].'">'.$r['kode_po'].'</a>';
		}
		if(!empty($dataReturn)){
			$hasil=implode(",<br>", $rp);
		}
		return $hasil;
	}


	function datapo($table,$number,$offset,$data){
		if(!empty($data['kode_po'])){
			$kode_po=$data['kode_po'];
			$where=array(
				'hapus'=>0,
				'kode_po'=>$kode_po,
			);
		}else if(!empty($data['jenis_po'])){
			$where=array(
				'hapus'=>0,
				'nama_po'=>$data['jenis_po'],
			);
		}else{
			$where=array(
				'hapus'=>0,
			);
		}
		$order=array(
			'id_produksi_po'=>'DESC',
		);
		$sql=" SELECT * FROM produksi_po WHERE hapus=0 ";
		if(!empty($data['kode_po'])){
			$sql.=" AND kode_po='".$data['kode_po']."' ";
		}
		if(!empty($data['jenis_po'])){
			$sql.=" AND kode_po LIKE '".$data['jenis_po']."%' ";
		}
		$sql.=" ORDER BY id_produksi_po DESC ";
		$sql .= " LIMIT " . (int)$number . " OFFSET " . (int)$offset;
		$query=$this->db->query($sql);
		return $query->result_array();
		//return $query = $this->db->get_where($table,$where,$number,$offset)->result_array();		

	}
	
	function data($table,$number,$offset){
		$where=array(
			'hapus'=>0
		);
		return $query = $this->db->get_where($table,$where,$number,$offset)->result_array();		

	}

	function jumlah_data($table){

		return $this->db->get($table)->num_rows();

	}

	public function jumlah_data_where($table,$data){
		$sql='SELECT * FROM '.$table.' WHERE hapus=0 ';
		if(!empty($data['kode_po'])){
			$sql.=" AND kode_po='".$data['kode_po']."' ";
		}
		if(!empty($data['jenis_po'])){
			$sql.=" AND nama_po='".$data['jenis_po']."' ";
		}
		$query = $this->db->query($sql);
		return $query->num_rows();
	}




	public function insertData($table,$data)

	{

		return $this->db->insert($table,$data);

	}



	public function getDataRow($table,$where)

	{

		$dataReturn = $this->db->get_where($table,$where)->row_array();

		return $dataReturn;

	}

	public function getDataRow2($table,$where)

	{

		$dataReturn = $this->db2->get_where($table,$where)->row_array();

		return $dataReturn;

	}

	public function getData($table,$where)

	{

		$dataReturn = $this->db->get_where($table,$where)->result_array();

		return $dataReturn;

	}

	public function getData2($table,$where)

	{

		$dataReturn = $this->db2->get_where($table,$where)->result_array();

		return $dataReturn;

	}

	public function queryManual($query)

	{

		$dataReturn = $this->db->query($query)->result_array();

		return $dataReturn;

	}

	public function queryManualRow($query)

	{

		$dataReturn = $this->db->query($query)->row_array();

		return $dataReturn;

	}

	public function queryManual2($query)

	{

		$dataReturn = $this->db2->query($query)->result_array();

		return $dataReturn;

	}

	public function queryManualRow2($query)

	{

		$dataReturn = $this->db2->query($query)->row_array();

		return $dataReturn;

	}

	public function deleteData($table,$data)

	{

		$this->db->delete($table, $data);

	}

	public function updateData($table,$where,$data)

	{

		$this->db->where($where);

		return $this->db->update($table, $data);

	}

}