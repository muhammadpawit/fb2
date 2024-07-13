<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Resumegaji extends CI_Controller {





	function __construct() {

		parent::__construct();

		//sessionLogin(URLPATH."\\".$this->uri->segment(1));

		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

		$this->load->model('ResumeGajiModel');

		$this->load->model('GlobalModel');
		$this->load->model('KasbonModel');

		$this->page='newtheme/page/resumegaji/';

		$this->layout='newtheme/page/main';

		$this->url=BASEURL.'Resumegaji/';

		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}

	}

	public function mingguankonveksi(){
		$data = [] ;
		$data['title']='Resume Gaji Mingguan Konveksi';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=periodeproduksi()['tahun'].'-'.periodeproduksi()['bulan'].'-01';
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$rincian = array(
			array(
				'id' 	=> 1,
				'rincian'	=> 'Kasbon Karyawan Konveksi',
			),
			array(
				'id' 	=> 2,
				'rincian'	=> 'Pinjaman Karyawan',
			),
			array(
				'id' 	=> 3,
				'rincian'	=> 'Uang Makan Security',
			),
			array(
				'id' 	=> 4,
				'rincian'	=> 'Insentif Security',
			),
			array(
				'id' 	=> 5,
				'rincian'	=> 'Gaji Karyawan Finishing',
			),
			array(
				'id' 	=> 6,
				'rincian'	=> 'Gaji Karyawan KLO',
			),
			array(
				'id' 	=> 7,
				'rincian'	=> 'Upah Tim Potong',
			),
		);
		foreach($rincian as $r){
			$data['prods'][] = array(
				'id' 	=> $r['id'],
				'rincian'	=> $r['rincian'],
				'jumlah'	=> $this->ResumeGajiModel->get($r['id'],$tanggal1,$tanggal2),
				'ket'		=>null,
			);
		}
		$data['page']=$this->page.'mingguan_konveksi';
		$this->load->view($this->layout,$data);
	}
}