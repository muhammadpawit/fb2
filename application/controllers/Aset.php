<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aset extends CI_Controller {

    public $layout;
    public $page;
    public $auth;
    public $login;

    function __construct() {
        parent::__construct();
        $this->page = 'newtheme/page/accounting/';
        $this->layout = 'newtheme/page/main';
        $this->login = BASEURL.'login';
        $this->auth = $this->session->userdata('id_user');
        if(empty($this->auth)) { redirect($this->login); }
        $this->load->model('GlobalModel');
    }

    public function daftar_aset() {
        $data = [];
        $data['title'] = 'Daftar Aset Tetap';
        $data['results'] = $this->GlobalModel->getData('acc_aset_tetap', ['hapus' => 0]);
        $data['tambah'] = BASEURL.'Aset/daftar_aset_add';
        $data['page'] = $this->page.'aset_tetap_list';
        $this->load->view($this->layout, $data);
    }

    public function daftar_aset_add() {
        $data = [];
        $data['title'] = 'Tambah Aset Tetap';
        $data['akun_aset'] = $this->db->query("SELECT * FROM acc_coa WHERE kode_akun LIKE '14%' AND is_header=0 AND hapus=0")->result_array();
        $data['akun_beban'] = $this->db->query("SELECT * FROM acc_coa WHERE kode_akun LIKE '5%' AND is_header=0 AND hapus=0")->result_array();
        $data['action'] = BASEURL.'Aset/daftar_aset_save';
        $data['batal'] = BASEURL.'Aset/daftar_aset';
        $data['page'] = $this->page.'aset_tetap_form';
        $this->load->view($this->layout, $data);
    }

    public function daftar_aset_save() {
        $post = $this->input->post();
        $insert = [
            'nama_aset' => $post['nama_aset'],
            'kode_aset' => $post['kode_aset'],
            'tgl_perolehan' => $post['tgl_perolehan'],
            'harga_perolehan' => $post['harga_perolehan'],
            'masa_manfaat' => $post['masa_manfaat'],
            'residu' => $post['residu'],
            'id_akun_aset' => $post['id_akun_aset'],
            'id_akun_akum_susut' => $post['id_akun_akum_susut'],
            'id_akun_beban_susut' => $post['id_akun_beban_susut'],
            'metode' => $post['metode'],
            'status' => 'AKTIF',
            'hapus' => 0
        ];
        $this->GlobalModel->insertData('acc_aset_tetap', $insert);
        $this->session->set_flashdata('msg', 'Aset berhasil disimpan');
        redirect(BASEURL.'Aset/daftar_aset');
    }

    public function penyusutan_aset() {
        $data = [];
        $data['title'] = 'Penyusutan Aset';
        $data['page'] = $this->page.'aset_penyusutan';
        $this->load->view($this->layout, $data);
    }

    public function disposal() {
        $data = [];
        $data['title'] = 'Pelepasan / Penjualan Aset';
        $data['results'] = $this->GlobalModel->getData('acc_aset_tetap', ['status <>' => 'AKTIF', 'hapus' => 0]);
        $data['page'] = $this->page.'aset_disposal';
        $this->load->view($this->layout, $data);
    }

    public function disposal_add($id) {
        $data = [];
        $data['title'] = 'Proses Pelepasan Aset';
        $data['aset'] = $this->GlobalModel->getDataRow('acc_aset_tetap', ['id' => $id]);
        $data['action'] = BASEURL.'Aset/disposal_save';
        $data['batal'] = BASEURL.'Aset/daftar_aset';
        $data['page'] = $this->page.'aset_disposal_form';
        $this->load->view($this->layout, $data);
    }

    public function disposal_save() {
        $post = $this->input->post();
        $id = $post['id'];
        $status = $post['status']; // DIJUAL or DIHAPUS

        $update = [
            'status' => $status
        ];

        $this->GlobalModel->updateData('acc_aset_tetap', ['id' => $id], $update);

        // Optional: create journal entry for disposal if price > 0
        // For now, just update status

        $this->session->set_flashdata('msg', 'Aset berhasil dilepas');
        redirect(BASEURL.'Aset/disposal');
    }
}
