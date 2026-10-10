<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporansebaranpo extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporansebaranpo/';
		$this->url=BASEURL.'Laporansebaranpo/';
		$this->login = BASEURL.'login';
		$this->auth = $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	function index(){
		$data = [];
		$data['title'] = 'Sebaran PO di CMT';

		// Data PO yang masih di CMT: sumber sama dengan Dash/poCmtJson
		$this->load->model('Report');
		$poList = $this->Report->poCMT('data');

		// Alamat CMT dari master_cmt (dicocokkan lewat nama)
		$alamat = [];
		$cmtRows = $this->db->query("SELECT cmt_name, alamat FROM master_cmt WHERE hapus=0")->result_array();
		foreach($cmtRows as $c){
			$alamat[strtolower(trim($c['cmt_name']))] = trim((string)$c['alamat']);
		}

		$group = [];
		foreach($poList as $p){
			$key = strtolower(trim($p['nama_cmt']));
			if(!isset($group[$key])){
				$group[$key] = array(
					'nama'   => ucwords($key),
					'alamat' => isset($alamat[$key]) ? $alamat[$key] : '',
					'jml_po' => 0,
					'po'     => [],
				);
			}
			$group[$key]['jml_po']++;
			$group[$key]['po'][] = $p['nama_po'];
		}
		ksort($group);

		$markers = array_values($group);
		$totalpo = count($poList);

		$data['markers']  = $markers;
		$data['total_po'] = $totalpo;
		$data['total_cmt'] = count($markers);
		$data['page'] = $this->page.'index';
		$this->load->view($this->layout,$data);
	}

}
