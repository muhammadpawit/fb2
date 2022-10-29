<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operational extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
	}

	public function index()
	{
		$viewData['oper'] = $this->GlobalModel->getDataRow('operational',array('id_operational'=>1));
		$this->load->view('global/header');
		$this->load->view('operation/operation-update',$viewData);
		$this->load->view('global/footer');
	}

	public function updateAct()
	{
		$post = $this->input->post();

		$dataInsert = array(
			'val_operational' => $post['valueOper']
		);
		$this->GlobalModel->updateData('operational',array('id_operational'=>1),$dataInsert);
		redirect(BASEURL.'operational');
	}
}