<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukubesar extends CI_Controller {

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

    public function coa() {
        $data = [];
        $data['title'] = 'Chart of Accounts (Bagan Akun)';
        $data['results'] = $this->GlobalModel->getDataOrderBy('acc_coa', ['hapus' => 0], 'kode_akun', 'ASC');
        $data['tambah'] = BASEURL.'Bukubesar/coa_add';
        $data['page'] = $this->page.'coa_list';
        $this->load->view($this->layout, $data);
    }

    public function coa_add() {
        $data = [];
        $data['title'] = 'Tambah Akun';
        $data['akun_induk'] = $this->GlobalModel->getData('acc_coa', ['hapus' => 0, 'is_header' => 1]);
        $data['action'] = BASEURL.'Bukubesar/coa_save';
        $data['batal'] = BASEURL.'Bukubesar/coa';
        $data['page'] = $this->page.'coa_form';
        $this->load->view($this->layout, $data);
    }

    public function coa_save() {
        $post = $this->input->post();
        $insert = [
            'kode_akun' => $post['kode_akun'],
            'nama_akun' => $post['nama_akun'],
            'id_induk' => $post['id_induk'],
            'tipe' => $post['tipe'],
            'saldo_normal' => $post['saldo_normal'],
            'is_header' => isset($post['is_header']) ? 1 : 0,
            'hapus' => 0
        ];
        $this->GlobalModel->insertData('acc_coa', $insert);
        $this->session->set_flashdata('msg', 'Akun berhasil ditambahkan');
        redirect(BASEURL.'Bukubesar/coa');
    }

    public function coa_edit($id) {
        $data = [];
        $data['title'] = 'Edit Akun';
        $data['akun'] = $this->GlobalModel->getDataRow('acc_coa', ['id' => $id]);
        $data['akun_induk'] = $this->GlobalModel->getData('acc_coa', ['hapus' => 0, 'is_header' => 1]);
        $data['action'] = BASEURL.'Bukubesar/coa_update';
        $data['batal'] = BASEURL.'Bukubesar/coa';
        $data['page'] = $this->page.'coa_form';
        $this->load->view($this->layout, $data);
    }

    public function coa_update() {
        $post = $this->input->post();
        $update = [
            'kode_akun' => $post['kode_akun'],
            'nama_akun' => $post['nama_akun'],
            'id_induk' => $post['id_induk'],
            'tipe' => $post['tipe'],
            'saldo_normal' => $post['saldo_normal'],
            'is_header' => isset($post['is_header']) ? 1 : 0
        ];
        $this->GlobalModel->updateData('acc_coa', ['id' => $post['id']], $update);
        $this->session->set_flashdata('msg', 'Akun berhasil diperbarui');
        redirect(BASEURL.'Bukubesar/coa');
    }

    public function coa_delete($id) {
        $this->GlobalModel->updateData('acc_coa', ['id' => $id], ['hapus' => 1]);
        $this->session->set_flashdata('msg', 'Akun berhasil dihapus');
        redirect(BASEURL.'Bukubesar/coa');
    }

    public function jurnalumum() {
        $data = [];
        $data['title'] = 'Jurnal Umum';
        $get = $this->input->get();
        $tgl1 = isset($get['tgl1']) ? $get['tgl1'] : date('Y-m-01');
        $tgl2 = isset($get['tgl2']) ? $get['tgl2'] : date('Y-m-t');
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
        
        $sql = "SELECT * FROM acc_jurnal WHERE hapus=0 AND tanggal BETWEEN '$tgl1' AND '$tgl2' ORDER BY tanggal DESC, id DESC";
        $data['results'] = $this->GlobalModel->queryManual($sql);
        $data['tambah'] = BASEURL.'Bukubesar/jurnalumum_add';
        $data['page'] = $this->page.'jurnal_list';
        $this->load->view($this->layout, $data);
    }

    public function jurnalumum_add() {
        $data = [];
        $data['title'] = 'Buat Jurnal Umum';
        $data['akun'] = $this->GlobalModel->getDataOrderBy('acc_coa', ['hapus' => 0, 'is_header' => 0], 'kode_akun', 'ASC');
        $data['action'] = BASEURL.'Bukubesar/jurnalumum_save';
        $data['batal'] = BASEURL.'Bukubesar/jurnalumum';
        $data['page'] = $this->page.'jurnal_form';
        $this->load->view($this->layout, $data);
    }

    public function jurnalumum_save() {
        $post = $this->input->post();
        $this->db->trans_start();
        $header = [
            'tanggal' => $post['tanggal'],
            'no_jurnal' => $post['no_jurnal'],
            'keterangan' => $post['keterangan_header'],
            'total_debit' => $post['total_debit'],
            'total_kredit' => $post['total_kredit'],
            'hapus' => 0
        ];
        $this->db->insert('acc_jurnal', $header);
        $id_jurnal = $this->db->insert_id();
        foreach($post['details'] as $det) {
            if($det['id_akun'] > 0) {
                $detail = [
                    'id_jurnal' => $id_jurnal,
                    'id_akun' => $det['id_akun'],
                    'debit' => $det['debit'],
                    'kredit' => $det['kredit'],
                    'keterangan' => $det['keterangan']
                ];
                $this->db->insert('acc_jurnal_detail', $detail);
            }
        }
        $this->db->trans_complete();
        $this->session->set_flashdata('msg', 'Jurnal berhasil disimpan');
        redirect(BASEURL.'Bukubesar/jurnalumum');
    }

    public function jurnalumum_delete($id) {
        $this->GlobalModel->updateData('acc_jurnal', ['id' => $id], ['hapus' => 1]);
        $this->session->set_flashdata('msg', 'Jurnal berhasil dihapus');
        redirect(BASEURL.'Bukubesar/jurnalumum');
    }

    public function jurnalumum_detail($id) {
        $data = [];
        $data['title'] = 'Detail Jurnal Umum';
        $data['jurnal'] = $this->GlobalModel->getDataRow('acc_jurnal', ['id' => $id]);
        $data['details'] = $this->db->query("
            SELECT d.*, c.kode_akun, c.nama_akun 
            FROM acc_jurnal_detail d 
            JOIN acc_coa c ON c.id = d.id_akun 
            WHERE d.id_jurnal = '$id'
        ")->result_array();
        $data['page'] = $this->page.'jurnal_detail';
        $this->load->view($this->layout, $data);
    }
    public function saldoawal() {
        $data = [];
        $data['title'] = 'Saldo Awal Akun';
        $data['results'] = $this->db->query("
            SELECT c.*, s.debit, s.kredit, s.periode, s.id as id_saldo
            FROM acc_coa c
            LEFT JOIN acc_saldo_awal s ON s.id_akun = c.id AND s.hapus = 0
            WHERE c.hapus = 0 AND c.is_header = 0
            ORDER BY c.kode_akun ASC
        ")->result_array();
        $data['action'] = BASEURL.'Bukubesar/saldoawal_save';
        $data['page'] = $this->page.'saldo_awal';
        $this->load->view($this->layout, $data);
    }

    public function saldoawal_save() {
        $post = $this->input->post();
        foreach($post['saldo'] as $id_akun => $val) {
            $cek = $this->GlobalModel->getDataRow('acc_saldo_awal', ['id_akun' => $id_akun, 'periode' => $post['periode'], 'hapus' => 0]);
            $data = [
                'id_akun' => $id_akun,
                'debit' => $val['debit'],
                'kredit' => $val['kredit'],
                'periode' => $post['periode'],
                'hapus' => 0
            ];
            if($cek) {
                $this->GlobalModel->updateData('acc_saldo_awal', ['id' => $cek['id']], $data);
            } else {
                $this->GlobalModel->insertData('acc_saldo_awal', $data);
            }
        }
        $this->session->set_flashdata('msg', 'Saldo awal berhasil disimpan');
        redirect(BASEURL.'Bukubesar/saldoawal');
    }
}
