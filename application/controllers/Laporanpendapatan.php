<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpendapatan extends CI_Controller {

	public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;
	public $ReportModel;
	public $uri;

	function __construct() {
		parent::__construct();
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index() {
		$data = [];
		$data['title'] = 'Laporan Pendapatan Finishing (Packing)';
		
		$get = $this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1 = $get['tanggal1'];
		}else{
			$tanggal1 = date('Y-m-d',strtotime("monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2 = $get['tanggal2'];
		}else{
			$tanggal2 = date('Y-m-d',strtotime("saturday this week"));
		}
		
		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		
		$sql = "SELECT 
					COALESCE(pr.nama_po, p.nama_po) as jenis_po, 
					SUM(p.jumlah_dz) as total_dz, 
					SUM(p.jumlah_pendapatan) as total_pendapatan 
				FROM packing p 
				LEFT JOIN produksi_po pr ON pr.kode_po = p.nama_po 
				WHERE p.hapus=0 AND DATE(p.creted_date) BETWEEN '$tanggal1' AND '$tanggal2' 
				GROUP BY COALESCE(pr.nama_po, p.nama_po) 
				ORDER BY total_pendapatan DESC";
		$data['pendapatan'] = $this->GlobalModel->queryManual($sql);
		
		$data['page'] = $this->page . 'laporanpendapatan/index';
		$this->load->view($this->layout, $data);
	}
}
