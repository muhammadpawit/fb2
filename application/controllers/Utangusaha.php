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
        
        // Generate Auto Invoice
        $today = date('Ymd');
        $last_inv = $this->db->query("SELECT no_invoice FROM acc_pembelian WHERE no_invoice LIKE 'INV-AP-$today-%' ORDER BY id DESC LIMIT 1")->row_array();
        if ($last_inv) {
            $num = (int) substr($last_inv['no_invoice'], -3);
            $next_num = str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $next_num = '001';
        }
        $data['auto_invoice'] = "INV-AP-$today-$next_num";

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
        $id_pembelian = $this->db->insert_id();
        
        // Simpan detail dari pengajuan jika ada yang diceklis
        if (isset($post['id_pengajuan_detail']) && is_array($post['id_pengajuan_detail'])) {
            foreach ($post['id_pengajuan_detail'] as $key => $id_raw) {
                $detail = [
                    'id_pembelian' => $id_pembelian,
                    'nominal' => $post['nominal_pengajuan'][$key]
                ];
                if(strpos($id_raw, 'pengajuan_') !== false) {
                    $detail['id_pengajuan_detail'] = str_replace('pengajuan_', '', $id_raw);
                } else if(strpos($id_raw, 'penerimaan_') !== false) {
                    $detail['id_penerimaan_detail'] = str_replace('penerimaan_', '', $id_raw);
                }
                $this->db->insert('acc_pembelian_detail', $detail);
            }
        }

        $this->session->set_flashdata('msg', 'Tagihan berhasil disimpan');
        redirect(BASEURL.'Utangusaha/invoice');
    }

    public function invoice_edit($id) {
        $data = [];
        $data['title'] = 'Edit Tagihan Pembelian';
        $data['action'] = BASEURL.'Utangusaha/invoice_update';
        $data['batal'] = BASEURL.'Utangusaha/invoice';
        $data['tagihan'] = $this->GlobalModel->getDataRow('acc_pembelian', ['id' => $id]);
        $data['supplier'] = $this->GlobalModel->getData('master_supplier', ['hapus' => 0]);
        $data['page'] = $this->page.'pembelian_form';
        
        // Let's pass the already checked items to the view so they can be re-checked or managed
        $details = $this->GlobalModel->getData('acc_pembelian_detail', ['id_pembelian' => $id]);
        $checked = [];
        foreach($details as $d) {
            if(!empty($d['id_pengajuan_detail'])) {
                $checked[] = 'pengajuan_'.$d['id_pengajuan_detail'];
            }
            if(!empty($d['id_penerimaan_detail'])) {
                $checked[] = 'penerimaan_'.$d['id_penerimaan_detail'];
            }
        }
        $data['checked_details'] = $checked;
        
        $this->load->view($this->layout, $data);
    }

    public function invoice_update() {
        $post = $this->input->post();
        $id_pembelian = $post['id'];
        
        $update = [
            'id_supplier' => $post['id_supplier'],
            'no_invoice' => $post['no_invoice'],
            'tanggal' => $post['tanggal'],
            'jatuh_tempo' => $post['jatuh_tempo'],
            'total' => $post['total'],
            'keterangan' => $post['keterangan']
        ];
        
        $this->GlobalModel->updateData('acc_pembelian', ['id' => $id_pembelian], $update);
        
        // Hapus detail lama, masukkan yang baru jika ada
        $this->db->delete('acc_pembelian_detail', ['id_pembelian' => $id_pembelian]);
        if (isset($post['id_pengajuan_detail']) && is_array($post['id_pengajuan_detail'])) {
            foreach ($post['id_pengajuan_detail'] as $key => $id_raw) {
                $detail = [
                    'id_pembelian' => $id_pembelian,
                    'nominal' => $post['nominal_pengajuan'][$key]
                ];
                if(strpos($id_raw, 'pengajuan_') !== false) {
                    $detail['id_pengajuan_detail'] = str_replace('pengajuan_', '', $id_raw);
                } else if(strpos($id_raw, 'penerimaan_') !== false) {
                    $detail['id_penerimaan_detail'] = str_replace('penerimaan_', '', $id_raw);
                }
                $this->db->insert('acc_pembelian_detail', $detail);
            }
        }
        
        $this->session->set_flashdata('msg', 'Tagihan berhasil diupdate');
        redirect(BASEURL.'Utangusaha/invoice');
    }

    public function invoice_delete($id) {
        $this->GlobalModel->updateData('acc_pembelian', ['id' => $id], ['hapus' => 1]);
        $this->session->set_flashdata('msg', 'Tagihan berhasil dihapus');
        redirect(BASEURL.'Utangusaha/invoice');
    }

    public function get_approved_pengajuan() {
        $id_supplier = $this->input->post('id_supplier');
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $id_pembelian = $this->input->post('id_pembelian');
        
        $supplier = $this->db->query("SELECT nama FROM master_supplier WHERE id = '$id_supplier'")->row_array();
        $nama_supplier = $supplier ? $this->db->escape_str($supplier['nama']) : '';

        $exclude_pengajuan = "AND d.id NOT IN (SELECT id_pengajuan_detail FROM acc_pembelian_detail WHERE id_pengajuan_detail IS NOT NULL";
        if (!empty($id_pembelian)) {
            $exclude_pengajuan .= " AND id_pembelian != '$id_pembelian'";
        }
        $exclude_pengajuan .= ")";

        $exclude_penerimaan = "AND pd.id NOT IN (SELECT id_penerimaan_detail FROM acc_pembelian_detail WHERE id_penerimaan_detail IS NOT NULL";
        if (!empty($id_pembelian)) {
            $exclude_penerimaan .= " AND id_pembelian != '$id_pembelian'";
        }
        $exclude_penerimaan .= ")";

        $query_pengajuan = $this->db->query("
            SELECT CONCAT('pengajuan_', d.id) as id, d.id as original_id, p.tanggal, d.nama_item, d.jumlah, d.satuan, d.pembayaran, d.harga 
            FROM pengajuan_harian_new_detail d 
            JOIN pengajuan_harian_new p ON p.id = d.idpengajuan 
            WHERE (d.supplier = '$id_supplier' OR d.supplier = '$nama_supplier') 
            AND p.status = 1 
            AND d.hapus = 0 
            AND p.hapus = 0
            AND DATE(p.tanggal) BETWEEN '$tgl_awal' AND '$tgl_akhir'
            $exclude_pengajuan
        ")->result_array();

        $query_penerimaan = $this->db->query("
            SELECT CONCAT('penerimaan_', pd.id) as id, pd.id as original_id, pi.tanggal, pd.nama as nama_item, 
            CASE WHEN pi.jenis = 1 THEN pd.ukuran ELSE pd.jumlah END as jumlah, 
            CASE WHEN pi.jenis = 1 THEN pd.satuanukuran ELSE pd.satuanJml END as satuan, 
            CASE 
                WHEN pi.tipepembayaran = 'Cash' THEN 1 
                WHEN pi.tipepembayaran = 'Transfer' THEN 2 
                ELSE 3
            END as pembayaran, 
            pd.harga 
            FROM penerimaan_item_detail pd 
            JOIN penerimaan_item pi ON pi.id = pd.penerimaan_item_id 
            WHERE pi.supplier = '$id_supplier'
            AND pd.hapus = 0 
            AND pi.hapus = 0
            AND DATE(pi.tanggal) BETWEEN '$tgl_awal' AND '$tgl_akhir'
            $exclude_penerimaan
        ")->result_array();

        $merged = array_merge($query_pengajuan, $query_penerimaan);
        
        echo json_encode($merged);
    }

    public function invoice_payment() {
        $data = [];
        $data['title'] = 'Pembayaran Utang';
        $data['results'] = $this->db->query("
            SELECT pu.*, s.nama as nama_supplier 
            FROM acc_pembayaran_utang pu 
            JOIN master_supplier s ON s.id = pu.id_supplier 
            WHERE pu.hapus = 0 
            ORDER BY pu.tanggal DESC
        ")->result_array();
        $data['tambah'] = BASEURL.'Utangusaha/invoice_payment_add';
        $data['page'] = $this->page.'pembayaran_utang_list';
        $this->load->view($this->layout, $data);
    }

    public function invoice_payment_add() {
        $data = [];
        $data['title'] = 'Tambah Pembayaran Utang';
        $data['supplier'] = $this->GlobalModel->getData('master_supplier', ['hapus' => 0]);
        
        // Generate Auto No Bayar
        $today = date('Ymd');
        $last_pay = $this->db->query("SELECT no_bayar FROM acc_pembayaran_utang WHERE no_bayar LIKE 'PAY-AP-$today-%' ORDER BY id DESC LIMIT 1")->row_array();
        if ($last_pay) {
            $num = (int) substr($last_pay['no_bayar'], -3);
            $next_num = str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $next_num = '001';
        }
        $data['auto_bayar'] = "PAY-AP-$today-$next_num";

        $data['kas'] = $this->db->query("SELECT * FROM acc_coa WHERE (kode_akun LIKE '11%' OR nama_akun LIKE '%Kas%' OR nama_akun LIKE '%Bank%') AND hapus=0")->result_array();
        $data['action'] = BASEURL.'Utangusaha/invoice_payment_save';
        $data['batal'] = BASEURL.'Utangusaha/invoice_payment';
        $data['page'] = $this->page.'pembayaran_utang_form';
        $this->load->view($this->layout, $data);
    }

    public function invoice_payment_save() {
        $post = $this->input->post();
        $insert = [
            'tanggal' => $post['tanggal'],
            'no_bayar' => $post['no_bayar'],
            'id_supplier' => $post['id_supplier'],
            'id_akun_kas' => $post['id_akun_kas'],
            'total_bayar' => $post['total_bayar'],
            'keterangan' => $post['keterangan'],
            'hapus' => 0
        ];
        
        $this->db->insert('acc_pembayaran_utang', $insert);
        $id_bayar = $this->db->insert_id();

        if (isset($post['id_pembelian']) && is_array($post['id_pembelian'])) {
            foreach ($post['id_pembelian'] as $key => $id_pembelian) {
                if ($post['nominal'][$key] > 0) {
                    $detail = [
                        'id_bayar' => $id_bayar,
                        'id_pembelian' => $id_pembelian,
                        'nominal' => $post['nominal'][$key]
                    ];
                    $this->db->insert('acc_pembayaran_utang_detail', $detail);

                    // Cek apakah tagihan lunas
                    $tagihan = $this->db->query("SELECT total FROM acc_pembelian WHERE id = '$id_pembelian'")->row_array();
                    $sudah_dibayar = $this->db->query("SELECT SUM(nominal) as terbayar FROM acc_pembayaran_utang_detail d JOIN acc_pembayaran_utang u ON u.id = d.id_bayar WHERE d.id_pembelian = '$id_pembelian' AND u.hapus = 0")->row_array();
                    
                    if ($sudah_dibayar['terbayar'] >= $tagihan['total']) {
                        $this->db->update('acc_pembelian', ['status' => 1], ['id' => $id_pembelian]);
                    }
                }
            }
        }

        // --- AUTOMATIC JOURNAL ENTRY ---
        // 1. Insert to acc_jurnal
        $no_jurnal = 'JU-' . date('YmdHis') . '-' . rand(100, 999);
        $jurnal = [
            'tanggal' => $post['tanggal'],
            'no_jurnal' => $no_jurnal,
            'keterangan' => 'Pembayaran Utang (' . $post['no_bayar'] . '): ' . $post['keterangan'],
            'ref' => $post['no_bayar'],
            'total_debit' => $post['total_bayar'],
            'total_kredit' => $post['total_bayar'],
            'hapus' => 0
        ];
        $this->db->insert('acc_jurnal', $jurnal);
        $id_jurnal = $this->db->insert_id();

        // 2. Insert to acc_jurnal_detail (DEBIT: Utang Usaha - ID 4)
        $this->db->insert('acc_jurnal_detail', [
            'id_jurnal' => $id_jurnal,
            'id_akun' => 4, // ID Akun Utang Usaha
            'debit' => $post['total_bayar'],
            'kredit' => 0,
            'keterangan' => 'Pelunasan Utang: ' . $post['no_bayar']
        ]);

        // 3. Insert to acc_jurnal_detail (KREDIT: Kas / Bank - sesuai pilihan form)
        $this->db->insert('acc_jurnal_detail', [
            'id_jurnal' => $id_jurnal,
            'id_akun' => $post['id_akun_kas'],
            'debit' => 0,
            'kredit' => $post['total_bayar'],
            'keterangan' => 'Pembayaran Utang: ' . $post['no_bayar']
        ]);
        // -------------------------------

        $this->session->set_flashdata('msg', 'Pembayaran berhasil disimpan');
        redirect(BASEURL.'Utangusaha/invoice_payment');
    }

    public function invoice_payment_delete($id) {
        $payment = $this->db->query("SELECT * FROM acc_pembayaran_utang WHERE id = '$id'")->row_array();
        if ($payment) {
            // 1. Soft delete the payment
            $this->db->update('acc_pembayaran_utang', ['hapus' => 1], ['id' => $id]);
            
            // 2. Soft delete the associated journal using its ref (no_bayar)
            $no_bayar = $payment['no_bayar'];
            $this->db->update('acc_jurnal', ['hapus' => 1], ['ref' => $no_bayar]);

            // 3. Reset the status of affected invoices
            $details = $this->db->query("SELECT * FROM acc_pembayaran_utang_detail WHERE id_bayar = '$id'")->result_array();
            foreach ($details as $d) {
                $id_pembelian = $d['id_pembelian'];
                
                // Pengecekan sisa tagihan lagi setelah dihapus
                $tagihan = $this->db->query("SELECT total FROM acc_pembelian WHERE id = '$id_pembelian'")->row_array();
                $sudah_dibayar = $this->db->query("SELECT SUM(nominal) as terbayar FROM acc_pembayaran_utang_detail d JOIN acc_pembayaran_utang u ON u.id = d.id_bayar WHERE d.id_pembelian = '$id_pembelian' AND u.hapus = 0")->row_array();
                $terbayar = $sudah_dibayar['terbayar'] ? $sudah_dibayar['terbayar'] : 0;
                
                if ($terbayar < $tagihan['total']) {
                    $this->db->update('acc_pembelian', ['status' => 0], ['id' => $id_pembelian]);
                }
            }
            
            $this->session->set_flashdata('msg', 'Pembayaran dan Jurnal terkait berhasil dihapus, tagihan telah dikembalikan ke status belum lunas.');
        }
        redirect(BASEURL.'Utangusaha/invoice_payment');
    }

    public function get_open_invoices() {
        $id_supplier = $this->input->post('id_supplier');
        $query = $this->db->query("
            SELECT p.*, s.nama as nama_supplier 
            FROM acc_pembelian p 
            JOIN master_supplier s ON s.id = p.id_supplier 
            WHERE p.hapus = 0 AND p.status = 0 AND p.id_supplier = '$id_supplier'
            ORDER BY p.tanggal ASC
        ")->result_array();

        foreach ($query as &$q) {
            $sudah_dibayar = $this->db->query("SELECT SUM(nominal) as terbayar FROM acc_pembayaran_utang_detail d JOIN acc_pembayaran_utang u ON u.id = d.id_bayar WHERE d.id_pembelian = '".$q['id']."' AND u.hapus = 0")->row_array();
            $terbayar = $sudah_dibayar['terbayar'] ? $sudah_dibayar['terbayar'] : 0;
            $q['sisa'] = $q['total'] - $terbayar;
        }

        echo json_encode($query);
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
        
        $get = $this->input->get();
        if (isset($get['pdf'])) {
            $html = $this->load->view($this->page.'report_utang_pdf', $data, true);
            $this->load->library('pdfgenerator');
            $this->data['title_pdf'] = 'Laporan Buku Tambahan Utang';
            $file_pdf = 'Laporan_Buku_Utang_'.time();
            $paper = 'A4';
            $orientation = "portrait";
            $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
        } else {
            $this->load->view($this->layout, $data);
        }
    }
}
