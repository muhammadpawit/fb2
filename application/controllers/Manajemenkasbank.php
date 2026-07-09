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
            SELECT t.*, c.nama_akun as nama_kas, c2.nama_akun as nama_lawan
            FROM acc_kas_transaksi t
            JOIN acc_coa c ON c.id = t.id_akun_kas
            LEFT JOIN acc_coa c2 ON c2.id = t.id_akun_lawan
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
        $data['akun_lawan'] = $this->db->query("SELECT * FROM acc_coa WHERE is_header=0 AND hapus=0 ORDER BY kode_akun ASC")->result_array();
        $data['action'] = BASEURL.'Manajemenkasbank/masuk_keluar_save';
        $data['batal'] = BASEURL.'Manajemenkasbank/masuk_keluar';
        $data['page'] = $this->page.'kas_transaksi_form';
        $this->load->view($this->layout, $data);
    }

    public function masuk_keluar_save() {
        $post = $this->input->post();
        
        $this->db->trans_start();

        $insert = [
            'tanggal' => $post['tanggal'],
            'no_transaksi' => $post['no_transaksi'],
            'id_akun_kas' => $post['id_akun_kas'],
            'id_akun_lawan' => $post['id_akun_lawan'],
            'tipe' => $post['tipe'],
            'total' => $post['total'],
            'keterangan' => $post['keterangan'],
            'hapus' => 0
        ];
        $this->db->insert('acc_kas_transaksi', $insert);

        // Auto Journal
        $jurnal = [
            'tanggal' => $post['tanggal'],
            'no_jurnal' => 'JU-'.$post['no_transaksi'],
            'keterangan' => 'Kas '.$post['tipe'].' - '.$post['keterangan'],
            'ref' => $post['no_transaksi'],
            'total_debit' => $post['total'],
            'total_kredit' => $post['total'],
            'hapus' => 0
        ];
        $this->db->insert('acc_jurnal', $jurnal);
        $id_jurnal = $this->db->insert_id();

        if ($post['tipe'] == 'MASUK') {
            // Kas Debit, Lawan Kredit
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_kas'], 'debit' => $post['total'], 'kredit' => 0, 'keterangan' => $post['keterangan']]);
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_lawan'], 'debit' => 0, 'kredit' => $post['total'], 'keterangan' => $post['keterangan']]);
        } else {
            // Lawan Debit, Kas Kredit
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_lawan'], 'debit' => $post['total'], 'kredit' => 0, 'keterangan' => $post['keterangan']]);
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_kas'], 'debit' => 0, 'kredit' => $post['total'], 'keterangan' => $post['keterangan']]);
        }

        $this->db->trans_complete();
        $this->session->set_flashdata('msg', 'Transaksi berhasil disimpan');
        redirect(BASEURL.'Manajemenkasbank/masuk_keluar');
    }

    public function masuk_keluar_edit($id) {
        $data = [];
        $data['title'] = 'Edit Transaksi Kas';
        $data['trx'] = $this->GlobalModel->getDataRow('acc_kas_transaksi', ['id' => $id]);
        $data['kas'] = $this->db->query("SELECT * FROM acc_coa WHERE (kode_akun LIKE '11%' OR nama_akun LIKE '%Kas%' OR nama_akun LIKE '%Bank%') AND is_header=0 AND hapus=0")->result_array();
        $data['akun_lawan'] = $this->db->query("SELECT * FROM acc_coa WHERE is_header=0 AND hapus=0 ORDER BY kode_akun ASC")->result_array();
        $data['action'] = BASEURL.'Manajemenkasbank/masuk_keluar_update';
        $data['batal'] = BASEURL.'Manajemenkasbank/masuk_keluar';
        $data['page'] = $this->page.'kas_transaksi_form';
        $this->load->view($this->layout, $data);
    }

    public function masuk_keluar_update() {
        $post = $this->input->post();
        
        $this->db->trans_start();

        $update = [
            'tanggal' => $post['tanggal'],
            'no_transaksi' => $post['no_transaksi'],
            'id_akun_kas' => $post['id_akun_kas'],
            'id_akun_lawan' => $post['id_akun_lawan'],
            'tipe' => $post['tipe'],
            'total' => $post['total'],
            'keterangan' => $post['keterangan']
        ];
        $this->db->update('acc_kas_transaksi', $update, ['id' => $post['id']]);

        // Hapus jurnal lama lalu buat lagi
        $this->db->update('acc_jurnal', ['hapus' => 1], ['ref' => $post['no_transaksi']]);

        $jurnal = [
            'tanggal' => $post['tanggal'],
            'no_jurnal' => 'JU-'.$post['no_transaksi'],
            'keterangan' => 'Kas '.$post['tipe'].' - '.$post['keterangan'],
            'ref' => $post['no_transaksi'],
            'total_debit' => $post['total'],
            'total_kredit' => $post['total'],
            'hapus' => 0
        ];
        $this->db->insert('acc_jurnal', $jurnal);
        $id_jurnal = $this->db->insert_id();

        if ($post['tipe'] == 'MASUK') {
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_kas'], 'debit' => $post['total'], 'kredit' => 0, 'keterangan' => $post['keterangan']]);
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_lawan'], 'debit' => 0, 'kredit' => $post['total'], 'keterangan' => $post['keterangan']]);
        } else {
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_lawan'], 'debit' => $post['total'], 'kredit' => 0, 'keterangan' => $post['keterangan']]);
            $this->db->insert('acc_jurnal_detail', ['id_jurnal' => $id_jurnal, 'id_akun' => $post['id_akun_kas'], 'debit' => 0, 'kredit' => $post['total'], 'keterangan' => $post['keterangan']]);
        }

        $this->db->trans_complete();
        $this->session->set_flashdata('msg', 'Transaksi berhasil diupdate');
        redirect(BASEURL.'Manajemenkasbank/masuk_keluar');
    }

    public function petty_cash() {
        $data = [];
        $data['title'] = 'Kas Kecil (Petty Cash)';
        $data['results'] = $this->db->query("
            SELECT t.*, c.nama_akun as nama_kas, c2.nama_akun as nama_lawan
            FROM acc_kas_transaksi t
            JOIN acc_coa c ON c.id = t.id_akun_kas
            LEFT JOIN acc_coa c2 ON c2.id = t.id_akun_lawan
            WHERE t.hapus = 0 AND c.nama_akun LIKE '%Kas Kecil%'
            ORDER BY t.tanggal DESC
        ")->result_array();
        $data['tambah'] = BASEURL.'Manajemenkasbank/masuk_keluar_add';
        $data['page'] = $this->page.'kas_transaksi_list';
        $this->load->view($this->layout, $data);
    }

    public function masuk_keluar_delete($id) {
        $trx = $this->db->query("SELECT * FROM acc_kas_transaksi WHERE id = '$id'")->row_array();
        if ($trx) {
            $this->db->update('acc_kas_transaksi', ['hapus' => 1], ['id' => $id]);
            $this->db->update('acc_jurnal', ['hapus' => 1], ['ref' => $trx['no_transaksi']]);
            $this->session->set_flashdata('msg', 'Transaksi & Jurnal berhasil dihapus');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function rekonsiliasi_bank() {
        $data = [];
        $data['title'] = 'Rekonsiliasi Bank';
        $data['results'] = $this->db->query("
            SELECT r.*, c.nama_akun as nama_kas
            FROM acc_rekonsiliasi_bank r
            JOIN acc_coa c ON c.id = r.id_akun_kas
            WHERE r.hapus = 0
            ORDER BY r.tanggal DESC
        ")->result_array();
        $data['tambah'] = BASEURL.'Manajemenkasbank/rekonsiliasi_add';
        $data['page'] = $this->page.'rekonsiliasi_list';
        $this->load->view($this->layout, $data);
    }

    public function rekonsiliasi_add() {
        $data = [];
        $data['title'] = 'Buat Rekonsiliasi Bank';
        $data['kas'] = $this->db->query("SELECT * FROM acc_coa WHERE (kode_akun LIKE '11%' OR nama_akun LIKE '%Kas%' OR nama_akun LIKE '%Bank%') AND is_header=0 AND hapus=0")->result_array();
        $data['action'] = BASEURL.'Manajemenkasbank/rekonsiliasi_save';
        $data['batal'] = BASEURL.'Manajemenkasbank/rekonsiliasi_bank';
        $data['page'] = $this->page.'rekonsiliasi_form';
        $this->load->view($this->layout, $data);
    }

    public function rekonsiliasi_save() {
        $post = $this->input->post();
        $id_akun = $post['id_akun_kas'];
        $tanggal = $post['tanggal'];
        $saldo_bank = str_replace(',', '', $post['saldo_bank']);

        // Hitung Saldo Sistem (Saldo Awal + Total Debit - Total Kredit) s/d tanggal tsb
        $saldo_awal = $this->db->query("SELECT SUM(debit - kredit) as awal FROM acc_saldo_awal WHERE id_akun = '$id_akun' AND hapus = 0")->row_array();
        
        $mutasi = $this->db->query("
            SELECT SUM(d.debit - d.kredit) as mutasi 
            FROM acc_jurnal_detail d
            JOIN acc_jurnal j ON j.id = d.id_jurnal
            WHERE d.id_akun = '$id_akun' AND j.hapus = 0 AND j.tanggal <= '$tanggal'
        ")->row_array();

        $saldo_sistem = ($saldo_awal['awal'] ? $saldo_awal['awal'] : 0) + ($mutasi['mutasi'] ? $mutasi['mutasi'] : 0);
        $selisih = $saldo_bank - $saldo_sistem;

        $insert = [
            'tanggal' => $tanggal,
            'id_akun_kas' => $id_akun,
            'saldo_bank' => $saldo_bank,
            'saldo_sistem' => $saldo_sistem,
            'selisih' => $selisih,
            'keterangan' => $post['keterangan'],
            'hapus' => 0
        ];
        
        $this->db->insert('acc_rekonsiliasi_bank', $insert);
        $this->session->set_flashdata('msg', 'Rekonsiliasi berhasil disimpan. Selisih: '.number_format($selisih, 2));
        redirect(BASEURL.'Manajemenkasbank/rekonsiliasi_bank');
    }

    public function rekonsiliasi_delete($id) {
        $this->db->update('acc_rekonsiliasi_bank', ['hapus' => 1], ['id' => $id]);
        $this->session->set_flashdata('msg', 'Data Rekonsiliasi berhasil dihapus');
        redirect(BASEURL.'Manajemenkasbank/rekonsiliasi_bank');
    }
}
