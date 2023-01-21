<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}


	function master_cmt($jobdesk){
		$query = $this->db->query("SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='".$jobdesk."' ");
		return $query->result_array();
	}

	function cmt_in($in){
		$sql ="SELECT * FROM master_cmt WHERE hapus=0 ";
		if(!empty($in)){
			$sql .=" AND id_cmt IN (".$in.") ";
		}
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function explode_all($job){
		$data = $this->master_cmt($job);
		foreach($data as $d){
			$has[]=$d['id_cmt'];
		}
		$hasil = implode(",", $has);
		return $hasil;
	}

}