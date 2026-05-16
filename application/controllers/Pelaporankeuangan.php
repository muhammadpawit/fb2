<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelaporankeuangan extends CI_Controller {

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

    public function laba_rugi() {
        $data = [];
        $data['title'] = 'Laporan Laba Rugi';
        $get = $this->input->get();
        $tgl1 = isset($get['tgl1']) ? $get['tgl1'] : date('Y-m-01');
        $tgl2 = isset($get['tgl2']) ? $get['tgl2'] : date('Y-m-t');
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;

        $data['pendapatan'] = $this->db->query("
            SELECT c.nama_akun, SUM(d.kredit - d.debit) as total
            FROM acc_coa c
            JOIN acc_jurnal_detail d ON d.id_akun = c.id
            JOIN acc_jurnal j ON j.id = d.id_jurnal
            WHERE c.tipe = 'PENDAPATAN' AND j.tanggal BETWEEN '$tgl1' AND '$tgl2' AND j.hapus=0
            GROUP BY c.id
        ")->result_array();

        $data['beban'] = $this->db->query("
            SELECT c.nama_akun, SUM(d.debit - d.kredit) as total
            FROM acc_coa c
            JOIN acc_jurnal_detail d ON d.id_akun = c.id
            JOIN acc_jurnal j ON j.id = d.id_jurnal
            WHERE c.tipe = 'BEBAN' AND j.tanggal BETWEEN '$tgl1' AND '$tgl2' AND j.hapus=0
            GROUP BY c.id
        ")->result_array();

        $data['page'] = $this->page.'report_laba_rugi';
        $this->load->view($this->layout, $data);
    }

    public function neraca() {
        $data = [];
        $data['title'] = 'Laporan Neraca';
        $get = $this->input->get();
        $tgl = isset($get['tgl']) ? $get['tgl'] : date('Y-m-d');
        $data['tgl'] = $tgl;

        $data['aset'] = $this->db->query("
            SELECT c.nama_akun, SUM(d.debit - d.kredit) as total
            FROM acc_coa c
            JOIN acc_jurnal_detail d ON d.id_akun = c.id
            JOIN acc_jurnal j ON j.id = d.id_jurnal
            WHERE c.tipe = 'ASET' AND j.tanggal <= '$tgl' AND j.hapus=0
            GROUP BY c.id
        ")->result_array();

        $data['kewajiban'] = $this->db->query("
            SELECT c.nama_akun, SUM(d.kredit - d.debit) as total
            FROM acc_coa c
            JOIN acc_jurnal_detail d ON d.id_akun = c.id
            JOIN acc_jurnal j ON j.id = d.id_jurnal
            WHERE c.tipe = 'KEWAJIBAN' AND j.tanggal <= '$tgl' AND j.hapus=0
            GROUP BY c.id
        ")->result_array();

        $data['ekuitas'] = $this->db->query("
            SELECT c.nama_akun, SUM(d.kredit - d.debit) as total
            FROM acc_coa c
            JOIN acc_jurnal_detail d ON d.id_akun = c.id
            JOIN acc_jurnal j ON j.id = d.id_jurnal
            WHERE c.tipe = 'EKUITAS' AND j.tanggal <= '$tgl' AND j.hapus=0
            GROUP BY c.id
        ")->result_array();

        $data['page'] = $this->page.'report_neraca';
        $this->load->view($this->layout, $data);
    }

    public function aruskas() {
        $data = [];
        $data['title'] = 'Laporan Arus Kas';
        $get = $this->input->get();
        $tgl1 = isset($get['tgl1']) ? $get['tgl1'] : date('Y-m-01');
        $tgl2 = isset($get['tgl2']) ? $get['tgl2'] : date('Y-m-t');
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;

        // Cash Accounts (Usually starting with 11)
        $cash_accounts = $this->db->query("SELECT id FROM acc_coa WHERE (kode_akun LIKE '11%' OR nama_akun LIKE '%Kas%' OR nama_akun LIKE '%Bank%') AND is_header=0")->result_array();
        $cash_ids = array_column($cash_accounts, 'id');
        $cash_ids_str = implode(',', $cash_ids);

        if(empty($cash_ids_str)) {
            $data['operating'] = [];
            $data['investing'] = [];
            $data['financing'] = [];
        } else {
            // Operating Activities (Cash vs Revenue/Expense)
            $data['operating'] = $this->db->query("
                SELECT c.nama_akun, SUM(d.debit - d.kredit) as total
                FROM acc_coa c
                JOIN acc_jurnal_detail d ON d.id_akun = c.id
                JOIN acc_jurnal j ON j.id = d.id_jurnal
                WHERE c.tipe IN ('PENDAPATAN', 'BEBAN') AND j.tanggal BETWEEN '$tgl1' AND '$tgl2' AND j.hapus=0
                AND j.id IN (SELECT id_jurnal FROM acc_jurnal_detail WHERE id_akun IN ($cash_ids_str))
                GROUP BY c.id
            ")->result_array();

            // Investing Activities (Cash vs Non-Cash Aset like Fixed Assets)
            $data['investing'] = $this->db->query("
                SELECT c.nama_akun, SUM(d.debit - d.kredit) as total
                FROM acc_coa c
                JOIN acc_jurnal_detail d ON d.id_akun = c.id
                JOIN acc_jurnal j ON j.id = d.id_jurnal
                WHERE c.tipe = 'ASET' AND c.id NOT IN ($cash_ids_str) AND j.tanggal BETWEEN '$tgl1' AND '$tgl2' AND j.hapus=0
                AND j.id IN (SELECT id_jurnal FROM acc_jurnal_detail WHERE id_akun IN ($cash_ids_str))
                GROUP BY c.id
            ")->result_array();

            // Financing Activities (Cash vs Kewajiban/Ekuitas)
            $data['financing'] = $this->db->query("
                SELECT c.nama_akun, SUM(d.kredit - d.debit) as total
                FROM acc_coa c
                JOIN acc_jurnal_detail d ON d.id_akun = c.id
                JOIN acc_jurnal j ON j.id = d.id_jurnal
                WHERE c.tipe IN ('KEWAJIBAN', 'EKUITAS') AND j.tanggal BETWEEN '$tgl1' AND '$tgl2' AND j.hapus=0
                AND j.id IN (SELECT id_jurnal FROM acc_jurnal_detail WHERE id_akun IN ($cash_ids_str))
                GROUP BY c.id
            ")->result_array();
        }

        $data['page'] = $this->page.'report_arus_kas';
        $this->load->view($this->layout, $data);
    }

    public function neraca_saldo() {
        $data = [];
        $data['title'] = 'Neraca Saldo';
        $data['results'] = $this->db->query("
            SELECT c.kode_akun, c.nama_akun, 
                   SUM(d.debit) as debit, SUM(d.kredit) as kredit
            FROM acc_coa c
            LEFT JOIN acc_jurnal_detail d ON d.id_akun = c.id
            LEFT JOIN acc_jurnal j ON j.id = d.id_jurnal AND j.hapus=0
            WHERE c.hapus = 0
            GROUP BY c.id
            ORDER BY c.kode_akun ASC
        ")->result_array();
        $data['page'] = $this->page.'report_neraca_saldo';
        $this->load->view($this->layout, $data);
    }
}
