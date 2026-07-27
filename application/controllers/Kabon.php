<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kabon extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function potongan_warteg(){
		$data=[];
		$data['title']='Potongan Warteg';
        $sql = "SELECT p.*, k.nama as nama_karyawan FROM potongan_warteg p LEFT JOIN karyawan k ON p.id_karyawan=k.id WHERE p.hapus=0 ORDER BY p.id DESC";
        $data['potongan'] = $this->GlobalModel->QueryManual($sql);
		
		$data['page']='newtheme/page/kabon/potongan_warteg_list';
		$this->load->view($this->layout,$data);
	}

    public function potongan_warteg_add(){
        $data=[];
		$data['title']='Tambah Potongan Warteg';
        $data['karyawan'] = $this->GlobalModel->GetData('karyawan', array('hapus'=>0));
		$data['action'] = BASEURL.'Kabon/potongan_warteg_save';
		$data['page']='newtheme/page/kabon/potongan_warteg_form';
		$this->load->view($this->layout,$data);
    }

    public function potongan_warteg_edit($id){
        $data=[];
		$data['title']='Edit Potongan Warteg';
        $data['karyawan'] = $this->GlobalModel->GetData('karyawan', array('hapus'=>0));
        $data['potongan'] = $this->GlobalModel->GetDataRow('potongan_warteg', array('id'=>$id));
		$data['action'] = BASEURL.'Kabon/potongan_warteg_save';
		$data['page']='newtheme/page/kabon/potongan_warteg_form';
		$this->load->view($this->layout,$data);
    }

    public function potongan_warteg_save(){
        $post = $this->input->post();
        $insert = array(
            'id_karyawan' => $post['id_karyawan'],
            'tanggal' => $post['tanggal'],
            'nominal' => $post['nominal'],
            'keterangan' => $post['keterangan']
        );
        if(isset($post['id']) && !empty($post['id'])){
            $this->db->where('id', $post['id']);
            $this->db->update('potongan_warteg', $insert);
            $this->session->set_flashdata('msg', 'Data berhasil diubah');
        } else {
            $this->db->insert('potongan_warteg', $insert);
            $this->session->set_flashdata('msg', 'Data berhasil ditambah');
        }
        redirect(BASEURL.'Kabon/potongan_warteg');
    }

    public function potongan_warteg_delete($id){
        $this->db->where('id', $id);
        $this->db->update('potongan_warteg', array('hapus'=>1));
        $this->session->set_flashdata('msg', 'Data berhasil dihapus');
        redirect(BASEURL.'Kabon/potongan_warteg');
    }

}
