<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carousel extends CI_Controller {

	public $layout;
	public $page;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;
	public $upload;

	function __construct() {
		parent::__construct();
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login = BASEURL.'login';
		$this->auth = $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index() {
		$data=[];
		$data['title']='Manajemen Carousel Slide';
		$data['products'] = $this->GlobalModel->getData('carousel_slide', ['hapus' => 0]);
		$data['tambah'] = BASEURL.'Carousel/add';
		$data['page'] = $this->page.'carousel/list';
		$this->load->view($this->layout, $data);
	}

	public function add() {
		$data=[];
		$data['title']='Tambah Carousel Slide';
		$data['action'] = BASEURL.'Carousel/save';
		$data['batal'] = BASEURL.'Carousel';
		$data['page'] = $this->page.'carousel/form';
		$this->load->view($this->layout, $data);
	}

	public function save() {
		$data = $this->input->post();
		$config['upload_path']          = './assets/images/carousel/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;
		
		// Create dir if not exists
		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, TRUE);
		}

		$this->load->library('upload', $config);
		$image = '';
		if ($this->upload->do_upload('image')) {
			$upload_data = $this->upload->data();
			$image = $upload_data['file_name'];
		}

		$insert = [
			'alt_text' => $data['alt_text'],
			'status' => $data['status'],
			'urutan' => $data['urutan'],
			'hapus' => 0,
			'created_at' => date('Y-m-d H:i:s')
		];

		if(!empty($image)){
			$insert['image'] = $image;
		}

		$this->db->insert('carousel_slide', $insert);
		$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		redirect(BASEURL.'Carousel');
	}

	public function edit($id) {
		$data=[];
		$data['title']='Edit Carousel Slide';
		$data['p'] = $this->GlobalModel->getDataRow('carousel_slide', ['id' => $id]);
		$data['action'] = BASEURL.'Carousel/update/'.$id;
		$data['batal'] = BASEURL.'Carousel';
		$data['page'] = $this->page.'carousel/form';
		$this->load->view($this->layout, $data);
	}

	public function update($id) {
		$data = $this->input->post();
		$config['upload_path']          = './assets/images/carousel/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 2048;

		if (!is_dir($config['upload_path'])) {
			mkdir($config['upload_path'], 0777, TRUE);
		}

		$this->load->library('upload', $config);
		$update = [
			'alt_text' => $data['alt_text'],
			'status' => $data['status'],
			'urutan' => $data['urutan'],
			'updated_at' => date('Y-m-d H:i:s')
		];

		if ($this->upload->do_upload('image')) {
			$upload_data = $this->upload->data();
			$update['image'] = $upload_data['file_name'];
		}

		$this->db->update('carousel_slide', $update, ['id' => $id]);
		$this->session->set_flashdata('msg', 'Data berhasil diupdate');
		redirect(BASEURL.'Carousel');
	}

	public function hapus($id) {
		$this->db->update('carousel_slide', ['hapus' => 1], ['id' => $id]);
		$this->session->set_flashdata('msg', 'Data berhasil dihapus');
		redirect(BASEURL.'Carousel');
	}
}
