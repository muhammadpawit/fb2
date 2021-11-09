<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GlobalTwoModel extends CI_Model {

	function __construct() {
	
		parent::__construct();
		$this->db2 = $this->load->database('production', TRUE);  

	}

	public function insertData($table,$data)
	{
		return $this->db2->insert($table,$data);
	}

	public function getDataRow($table,$where)
	{
		$dataReturn = $this->db2->get_where($table,$where)->row_array();
		return $dataReturn;
	}
	public function getData($table,$where)
	{
		$dataReturn = $this->db2->get_where($table,$where)->result_array();
		return $dataReturn;
	}
	public function queryManual($query)
	{
		$dataReturn = $this->db2->query($query)->result_array();
		return $dataReturn;
	}
	public function queryManualRow($query)
	{
		$dataReturn = $this->db2->query($query)->row_array();
		return $dataReturn;
	}
	public function deleteData($table,$data)
	{
		$this->db2->delete($table, $data);
	}
	public function updateData($table,$where,$data)
	{
		$this->db2->where($where);
		return $this->db2->update($table, $data);
	}
}