<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
	}

	public function index()
	{
		$viewData['menu'] = $this->GlobalModel->getData('master_menu',null);
		$this->load->view('global/header');
		$this->load->view('master/menu/view',$viewData);
		$this->load->view('global/footer');
	}

	public function tambah()
	{
		$viewData['menuChild'] = $this->GlobalModel->getData('master_menu',null);

		$this->load->view('global/header');
		$this->load->view('master/menu/tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function tambahAct($value='')
	{
		$post = $this->input->post();
		if (isset($post['child'])) {
			$childMenu = implode(",", $post['child']);
		} else {
			$childMenu = 0;
		}
		$dataInsert = array(
			'nama_menu'	=> $post['namaMenu'], 
			'icon_menu'	=> $post['icon'], 
			'url_menu'	=> $post['namaUrl'], 
			'child_menu'	=> $childMenu,
		);

		$this->GlobalModel->insertData('master_menu',$dataInsert);
		redirect(BASEURL.'menu');
	}

	public function edit($id)
	{
		$viewData['menuChild'] = $this->GlobalModel->getData('master_menu',null);
		$viewData['menu'] = $this->GlobalModel->getDataRow('master_menu',array('id_master_menu' => $id));
		// pre($viewData['menu']);

		$this->load->view('global/header');
		$this->load->view('master/menu/edit',$viewData);
		$this->load->view('global/footer');
	}

	public function editAct($id='')
	{
		$post = $this->input->post();
		$childMenu = implode(",", $post['child']);
		$parentInsert = array(
			'nama_menu'	=> $post['namaMenu'], 
			'icon_menu'	=> $post['icon'], 
			'url_menu'	=> $post['namaUrl'], 
			'child_menu'	=> $childMenu,
		);
		$this->GlobalModel->updateData('master_menu',array('id_master_menu' => $id),$parentInsert);
		foreach ($post['child'] as $key => $child) {
			$childInsert = array(
				'parent_menu'	=> $id,
			);
			$this->GlobalModel->updateData('master_menu',array('id_master_menu'=>$child),$childInsert);
		}

		redirect(BASEURL.'menu');
	}

	public function delete($id='')
	{
		$this->GlobalModel->deleteData('master_menu',array('id_master_menu' => $id));
		redirect(BASEURL.'menu');
	}

	
}