<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpoberedarcmt extends CI_Controller {

	function __construct() {
		parent::__construct();
		////sessionLogin(URLPATH."\\".$this->uri->segment(1));
		////session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporanpoberedarcmt/';
		$this->url=BASEURL.'Laporanpoberedarcmt/';
	}

	function index(){
		$data 			= [];
		$data['title']	= 'Monitoring Stok CMT';
		$get			= $this->input->get();

		if(isset($get['cmt'])){
			$datcmt = $get['cmt'];
		}else{
			$datcmt = 1;
		}

		$results 		= [];
		$data['prods']	= [];
		$cmtin 			= $this->MasterModel->cmt_in($datcmt);
		$jenis 			= $this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$no=1;
		//$rpo=array();
		foreach($jenis as $j){

			foreach($cmtin as $c){
				$po = $this->GlobalModel->getStokPO($c['id_cmt'],$j['id_jenis_po']);
				$rpo = $this->GlobalModel->getStokrincianpo($c['id_cmt'],$j['id_jenis_po']);
				if(!empty($rpo)){
					$data['prods'][$c['cmt_name']][]=array(
						'nama'=>$j['nama_jenis_po'],
						'jmlpo'=>$po['jmlpo']==0?'':$po['jmlpo']*$po['perkalian'],
						'pcspo'=>$po['pcs'],
						'rincian'=>$rpo,
					);
				}
			}

		}

		


		$data['cmt']	= $this->MasterModel->master_cmt('JAHIT');
		$data['all']	= $this->MasterModel->explode_all('JAHIT');
		$data['page']	= $this->page.'list';
		$this->load->view($this->layout,$data);
	}

}