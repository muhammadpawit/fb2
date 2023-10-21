<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->table='customer';
	}

	public function getDataCustomer(){
		return $this->db->query("SELECT * FROM ".$this->table." WHERE hapus=0 ")->result_array();
	}

	public function insertCustomer($input){
		$nama = strtolower($input['nama']);
		$insert = array(
			'nama' 		=> ucfirst($nama),
			'no_hp'		=> $input['no_hp'],
			'email'		=> $input['email'],
			'alamat'	=> $input['alamat'],
			'hapus'		=> 0,
		);
		$save = $this->db->insert($this->table,$insert);
		if($save==TRUE){
			return $hasil = array(
				'success' 		=> true,
				'message'		=> 'success',
			);
		}else{
			return $hasil = array(
				'success' 		=> false,
				'message'		=> 'failed',
			);
		}
	}

	public function UpdateCustomer($input){
		$nama = strtolower($input['nama']);
		$insert = array(
			'nama' 		=> ucfirst($nama),
			'no_hp'		=> $input['no_hp'],
			'email'		=> $input['email'],
			'alamat'	=> $input['alamat']
		);
		$save = $this->db->update($this->table,$insert,array('id'=>$input['id']));
		if($save==TRUE){
			return $hasil = array(
				'success' 		=> true,
				'message'		=> 'success',
			);
		}else{
			return $hasil = array(
				'success' 		=> false,
				'message'		=> 'failed',
			);
		}
	}

	public function DeleteCustomer($input){
		$nama = strtolower($input['nama']);
		$insert = array(
			'hapus'=>1
		);
		$save = $this->db->update($this->table,$insert,array('id'=>$input['id']));
		if($save==TRUE){
			return $hasil = array(
				'success' 		=> true,
				'message'		=> 'success',
			);
		}else{
			return $hasil = array(
				'success' 		=> false,
				'message'		=> 'failed',
			);
		}
	}


}