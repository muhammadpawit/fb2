<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemenkasbank extends CI_Controller {

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

    public function masuk_keluar() {
        $data = [];
        $data['title'] = 'Kas Masuk & Kas Keluar';
        $data['results'] = $this->db->query("
            SELECT t.*, c.nama_akun as nama_kas
            FROM acc_kas_transaksi t
            JOIN acc_coa c ON c.id = t.id_akun_kas
            WHERE t.hapus = 0
            ORDER BY t.tanggal DESC
        ")->result_array();
        $data['tambah'] = BASEURL.'Manajemenkasbank/masuk_keluar_add';
        $data['page'] = $this->page.'kas_transaksi_list';
        $this->load->view($this->layout, $data);
    }

    public function masuk_keluar_add() {
        $data = [];
        $data['title'] = 'Tambah Transaksi Kas';
        $data['kas'] = $this->db->query("SELECT * FROM acc_coa WHERE (kode_akun LIKE '11%' OR nama_akun LIKE '%Kas%' OR nama_akun LIKE '%Bank%') AND is_header=0 AND hapus=0")->result_array();
        $data['action'] = BASEURL.'Manajemenkasbank/masuk_keluar_save';
        $data['batal'] = BASEURL.'Manajemenkasbank/masuk_keluar';
        $data['page'] = $this->page.'kas_transaksi_form';
        $this->load->view($this->layout, $data);
    }

    public function masuk_keluar_save() {
        $post = $this->input->post();
        $insert = [
            'tanggal' => $post['tanggal'],
            'no_transaksi' => $post['no_transaksi'],
            'id_akun_kas' => $post['id_akun_kas'],
            'tipe' => $post['tipe'],
            'total' => $post['total'],
            'keterangan' => $post['keterangan'],
            'hapus' => 0
        ];
        $this->GlobalModel->insertData('acc_kas_transaksi', $insert);
        $this->session->set_flashdata('msg', 'Transaksi berhasil disimpan');
        redirect(BASEURL.'Manajemenkasbank/masuk_keluar');
    }

    public function petty_cash() {
        $data = [];
        $data['title'] = 'Kas Kecil (Petty Cash)';
        $data['results'] = $this->db->query("
            SELECT t.*, c.nama_akun as nama_kas
            FROM acc_kas_transaksi t
            JOIN acc_coa c ON c.id = t.id_akun_kas
            WHERE t.hapus = 0 AND c.nama_akun LIKE '%Kas Kecil%'
            ORDER BY t.tanggal DESC
        ")->result_array();
        $data['tambah'] = BASEURL.'Manajemenkasbank/masuk_keluar_add';
        $data['page'] = $this->page.'kas_transaksi_list';
        $this->load->view($this->layout, $data);
    }

    public function masuk_keluar_delete($id) {
        $this->GlobalModel->updateData('acc_kas_transaksi', ['id' => $id], ['hapus' => 1]);
        $this->session->set_flashdata('msg', 'Transaksi berhasil dihapus');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function rekonsiliasi_bank() {
        $data = [];
        $data['title'] = 'Rekonsiliasi Bank';
        $data['page'] = $this->page.'rekonsiliasi_list';
        $this->load->view($this->layout, $data);
    }
}
