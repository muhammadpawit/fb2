<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piutangusaha extends CI_Controller {

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

    public function data_pelanggan() {
        $data = [];
        $data['title'] = 'Data Pelanggan';
        $data['results'] = $this->GlobalModel->getData('customer', ['hapus' => 0]);
        $data['tambah'] = BASEURL.'Datacustomer/tambah'; // Reuse existing
        $data['page'] = $this->page.'customer_list';
        $this->load->view($this->layout, $data);
    }

    public function sales_invoice() {
        $data = [];
        $data['title'] = 'Faktur Penjualan (Accounts Receivable)';
        $data['results'] = $this->db->query("
            SELECT p.*, c.nama as nama_customer
            FROM acc_penjualan p
            JOIN customer c ON c.id = p.id_customer
            WHERE p.hapus = 0
            ORDER BY p.tanggal DESC
        ")->result_array();
        $data['tambah'] = BASEURL.'Piutangusaha/sales_invoice_add';
        $data['page'] = $this->page.'penjualan_list';
        $this->load->view($this->layout, $data);
    }

    public function sales_invoice_add() {
        $data = [];
        $data['title'] = 'Tambah Faktur Penjualan';
        $data['customer'] = $this->GlobalModel->getData('customer', ['hapus' => 0]);
        $data['action'] = BASEURL.'Piutangusaha/sales_invoice_save';
        $data['batal'] = BASEURL.'Piutangusaha/sales_invoice';
        $data['page'] = $this->page.'penjualan_form';
        $this->load->view($this->layout, $data);
    }

    public function sales_invoice_save() {
        $post = $this->input->post();
        $insert = [
            'id_customer' => $post['id_customer'],
            'no_faktur' => $post['no_faktur'],
            'tanggal' => $post['tanggal'],
            'jatuh_tempo' => $post['jatuh_tempo'],
            'total' => $post['total'],
            'keterangan' => $post['keterangan'],
            'status' => 0,
            'hapus' => 0
        ];
        $this->GlobalModel->insertData('acc_penjualan', $insert);
        $this->session->set_flashdata('msg', 'Faktur berhasil disimpan');
        redirect(BASEURL.'Piutangusaha/sales_invoice');
    }

    public function sales_receipt() {
        $data = [];
        $data['title'] = 'Penerimaan Pembayaran';
        $data['results'] = $this->GlobalModel->getData('acc_penerimaan_piutang', ['hapus' => 0]);
        $data['page'] = $this->page.'penerimaan_piutang_list';
        $this->load->view($this->layout, $data);
    }

    public function aging_report() {
        $data = [];
        $data['title'] = 'Buku Tambahan Piutang (Aging)';
        $data['results'] = $this->db->query("
            SELECT c.nama as nama_customer, SUM(p.total) as total_piutang,
                   (SELECT SUM(nominal) FROM acc_penerimaan_piutang_detail pd JOIN acc_penerimaan_piutang pu ON pu.id=pd.id_terima WHERE pu.id_customer=c.id AND pu.hapus=0) as total_terima
            FROM customer c
            JOIN acc_penjualan p ON p.id_customer = c.id
            WHERE p.hapus = 0
            GROUP BY c.id
        ")->result_array();
        $data['page'] = $this->page.'report_piutang';
        $this->load->view($this->layout, $data);
    }
}
