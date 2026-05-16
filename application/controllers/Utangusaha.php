<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utangusaha extends CI_Controller {

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

    public function vendor() {
        $data = [];
        $data['title'] = 'Data Vendor / Pemasok';
        $data['results'] = $this->GlobalModel->getData('master_supplier', ['hapus' => 0]);
        $data['tambah'] = BASEURL.'Masterdata/supplier_add'; // Reuse existing
        $data['page'] = $this->page.'vendor_list';
        $this->load->view($this->layout, $data);
    }

    public function invoice() {
        $data = [];
        $data['title'] = 'Tagihan Pembelian (Accounts Payable)';
        $data['results'] = $this->db->query("
            SELECT p.*, s.nama as nama_supplier
            FROM acc_pembelian p
            JOIN master_supplier s ON s.id = p.id_supplier
            WHERE p.hapus = 0
            ORDER BY p.tanggal DESC
        ")->result_array();
        $data['tambah'] = BASEURL.'Utangusaha/invoice_add';
        $data['page'] = $this->page.'pembelian_list';
        $this->load->view($this->layout, $data);
    }

    public function invoice_add() {
        $data = [];
        $data['title'] = 'Tambah Tagihan Pembelian';
        $data['supplier'] = $this->GlobalModel->getData('master_supplier', ['hapus' => 0]);
        $data['action'] = BASEURL.'Utangusaha/invoice_save';
        $data['batal'] = BASEURL.'Utangusaha/invoice';
        $data['page'] = $this->page.'pembelian_form';
        $this->load->view($this->layout, $data);
    }

    public function invoice_save() {
        $post = $this->input->post();
        $insert = [
            'id_supplier' => $post['id_supplier'],
            'no_invoice' => $post['no_invoice'],
            'tanggal' => $post['tanggal'],
            'jatuh_tempo' => $post['jatuh_tempo'],
            'total' => $post['total'],
            'keterangan' => $post['keterangan'],
            'status' => 0,
            'hapus' => 0
        ];
        $this->GlobalModel->insertData('acc_pembelian', $insert);
        $this->session->set_flashdata('msg', 'Tagihan berhasil disimpan');
        redirect(BASEURL.'Utangusaha/invoice');
    }

    public function invoice_payment() {
        $data = [];
        $data['title'] = 'Pembayaran Utang';
        $data['results'] = $this->GlobalModel->getData('acc_pembayaran_utang', ['hapus' => 0]);
        $data['page'] = $this->page.'pembayaran_utang_list';
        $this->load->view($this->layout, $data);
    }

    public function report_invoice() {
        $data = [];
        $data['title'] = 'Buku Tambahan Utang';
        $data['results'] = $this->db->query("
            SELECT s.nama as nama_supplier, SUM(p.total) as total_hutang, 
                   (SELECT SUM(nominal) FROM acc_pembayaran_utang_detail pd JOIN acc_pembayaran_utang pu ON pu.id=pd.id_bayar WHERE pu.id_supplier=s.id AND pu.hapus=0) as total_bayar
            FROM master_supplier s
            JOIN acc_pembelian p ON p.id_supplier = s.id
            WHERE p.hapus = 0
            GROUP BY s.id
        ")->result_array();
        $data['page'] = $this->page.'report_utang';
        $this->load->view($this->layout, $data);
    }
}
