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

        // Pendapatan Kirim Gudang H. Sholeh
        $kirim_gudang_haji_sholeh = $this->db->query("
            SELECT COALESCE(SUM(kg.jumlah_harga_piece), 0) as total
            FROM finishing_kirim_gudang kg
            JOIN produksi_po p ON p.id_produksi_po = kg.idpo
            WHERE p.hapus = 0 
            AND kg.tanggal_kirim BETWEEN '$tgl1' AND '$tgl2'
            AND (LOWER(kg.tujuan) LIKE '%soleh%' OR LOWER(kg.nama_penerima) LIKE '%soleh%' OR LOWER(kg.tujuan) LIKE '%sholeh%' OR LOWER(kg.nama_penerima) LIKE '%sholeh%')
        ")->row_array();
        $data['pendapatan_haji_sholeh'] = (float)($kirim_gudang_haji_sholeh['total'] ?? 0);

        // Pendapatan Kirim Gudang Lainnya (Selain H. Sholeh)
        $kirim_gudang_lainnya = $this->db->query("
            SELECT COALESCE(SUM(kg.jumlah_harga_piece), 0) as total
            FROM finishing_kirim_gudang kg
            JOIN produksi_po p ON p.id_produksi_po = kg.idpo
            WHERE p.hapus = 0 
            AND kg.tanggal_kirim BETWEEN '$tgl1' AND '$tgl2'
            AND (LOWER(kg.tujuan) NOT LIKE '%soleh%' AND LOWER(kg.nama_penerima) NOT LIKE '%soleh%' AND LOWER(kg.tujuan) NOT LIKE '%sholeh%' AND LOWER(kg.nama_penerima) NOT LIKE '%sholeh%')
        ")->row_array();
        $data['pendapatan_gudang_lainnya'] = (float)($kirim_gudang_lainnya['total'] ?? 0);

        // Pendapatan Penjualan Sisa Bahan
        $penjualan_sisa_bahan = $this->db->query("
            SELECT COALESCE(SUM(total_penjualan), 0) as total
            FROM penjualan_sisa_bahan
            WHERE hapus = 0 
            AND tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['pendapatan_sisa_bahan'] = (float)($penjualan_sisa_bahan['total'] ?? 0);

        // ================================================================
        // PENGELUARAN DIVISI KONVEKSI
        // ================================================================

        // a. Ajuan Harian Konveksi (kategori=3), kecuali supplier Sinar Hadi
        $ajuan_konveksi = $this->db->query("
            SELECT COALESCE(SUM(d.harga * d.jumlah), 0) as total
            FROM pengajuan_harian_new p
            JOIN pengajuan_harian_new_detail d ON d.idpengajuan = p.id
            WHERE p.hapus = 0
              AND p.status = 1
              AND p.kategori = 3
              AND d.hapus = 0
              AND REPLACE(REPLACE(LOWER(TRIM(d.supplier)), ' ', ''), '\t', '') NOT LIKE '%sinarhadi%'
              AND REPLACE(REPLACE(LOWER(TRIM(d.supplier)), ' ', ''), '\t', '') NOT LIKE '%sinarhad%'
              AND DATE(p.tanggal) BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['konveksi_ajuan_harian'] = (float)($ajuan_konveksi['total'] ?? 0);

        // b. Kasbon Konveksi (divisi id 2 & 15)
        $kasbon_konveksi = $this->db->query("
            SELECT COALESCE(SUM(nominal_acc), 0) as total
            FROM kasbon
            WHERE hapus = 0
              AND status = 1
              AND bagian IN (2, 15)
              AND tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['konveksi_kasbon'] = (float)($kasbon_konveksi['total'] ?? 0);

        // b. Gaji Bulanan Konveksi (karyawan dengan divisi 2 atau 15)
        $gaji_bulanan_konveksi = $this->db->query("
            SELECT COALESCE(SUM(gb.total), 0) as total
            FROM gaji_bulanan gb
            JOIN karyawan k ON k.id = gb.idkaryawan
            WHERE gb.hapus = 0
              AND k.divisi IN (2, 15)
              AND k.hapus = 0
              AND gb.tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['konveksi_gaji_bulanan'] = (float)($gaji_bulanan_konveksi['total'] ?? 0);

        // c. Gaji Gudang, KLO, Gaji Finishing
        $gaji_finishing = $this->db->query("
            SELECT COALESCE(SUM(
                kh.gaji/12 * (
                    COALESCE(gfd.senin,0) + COALESCE(gfd.selasa,0) + COALESCE(gfd.rabu,0) +
                    COALESCE(gfd.kamis,0) + COALESCE(gfd.jumat,0) + COALESCE(gfd.sabtu,0)
                ) +
                CASE WHEN gfd.minggu = 1 THEN kh.gaji ELSE 0 END +
                CASE WHEN gfd.insentif = 1 THEN kh.gaji ELSE 0 END +
                COALESCE(gfd.lembur, 0) -
                COALESCE(gfd.claim, 0) -
                COALESCE(gfd.pinjaman, 0) -
                COALESCE(gfd.kasbon, 0) -
                COALESCE(gfd.warteg, 0)
            ), 0) as total
            FROM gaji_finishing gf
            JOIN gaji_finishing_detail gfd ON gfd.idgaji = gf.id
            JOIN karyawan_harian kh ON kh.id = gfd.idkaryawan
            WHERE gf.hapus = 0
              AND gfd.hapus = 0
              AND gf.bagian IN ('GUDANG', 'KLO', 'FINISHING')
              AND gf.tanggal1 BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['konveksi_gaji_finishing'] = (float)($gaji_finishing['total'] ?? 0);

        // d. Uang Makan Security
        $uang_makan_security = $this->db->query("
            SELECT COALESCE(SUM(usd.nominal), 0) as total
            FROM um_security us
            JOIN um_security_detail usd ON usd.idum = us.id
            WHERE us.hapus = 0
              AND usd.hapus = 0
              AND us.tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['konveksi_uang_makan_security'] = (float)($uang_makan_security['total'] ?? 0);

        // d. Insentif Security
        $insentif_security = $this->db->query("
            SELECT COALESCE(SUM(nominal_insentif - COALESCE(totalpotongan, 0)), 0) as total
            FROM insentifsecurity
            WHERE hapus = 0
              AND tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['konveksi_insentif_security'] = (float)($insentif_security['total'] ?? 0);

        // e. Gaji Karyawan Sukabumi (gajisukabumi + anggaran_operasional_sukabumi)
        $gaji_sukabumi = $this->db->query("
            SELECT COALESCE(SUM(total), 0) as total
            FROM gajisukabumi
            WHERE hapus = 0
              AND tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $anggaran_sukabumi = $this->db->query("
            SELECT COALESCE(SUM(total), 0) as total
            FROM anggaran_operasional_sukabumi
            WHERE hapus = 0
              AND tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['konveksi_gaji_sukabumi'] = (float)($gaji_sukabumi['total'] ?? 0) + (float)($anggaran_sukabumi['total'] ?? 0);

        // ================================================================
        // PENGELUARAN DIVISI LAIN (BORDIR, SABLON, SUKABUMI)
        // ================================================================

        // Kasbon Bordir (divisi id 1 & 16)
        $kasbon_bordir = $this->db->query("
            SELECT COALESCE(SUM(nominal_acc), 0) as total
            FROM kasbon
            WHERE hapus = 0
              AND status = 1
              AND bagian IN (1, 16)
              AND tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['bordir_kasbon'] = (float)($kasbon_bordir['total'] ?? 0);

        // Gaji Bulanan Bordir (karyawan dengan divisi 1 atau 16)
        $gaji_bulanan_bordir = $this->db->query("
            SELECT COALESCE(SUM(gb.total), 0) as total
            FROM gaji_bulanan gb
            JOIN karyawan k ON k.id = gb.idkaryawan
            WHERE gb.hapus = 0
              AND k.divisi IN (1, 16)
              AND k.hapus = 0
              AND gb.tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['bordir_gaji_bulanan'] = (float)($gaji_bulanan_bordir['total'] ?? 0);

        // Ajuan Harian Bordir (kategori=2)
        $ajuan_bordir = $this->db->query("
            SELECT COALESCE(SUM(d.harga * d.jumlah), 0) as total
            FROM pengajuan_harian_new p
            JOIN pengajuan_harian_new_detail d ON d.idpengajuan = p.id
            WHERE p.hapus = 0
              AND p.status = 1
              AND p.kategori = 2
              AND p.tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['bordir_ajuan_harian'] = (float)($ajuan_bordir['total'] ?? 0);

        // Kasbon Sablon (divisi id 3 & 17)
        $kasbon_sablon = $this->db->query("
            SELECT COALESCE(SUM(nominal_acc), 0) as total
            FROM kasbon
            WHERE hapus = 0
              AND status = 1
              AND bagian IN (3, 17)
              AND tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['sablon_kasbon'] = (float)($kasbon_sablon['total'] ?? 0);

        // Gaji Bulanan Sablon (karyawan dengan divisi 3 atau 17)
        $gaji_bulanan_sablon = $this->db->query("
            SELECT COALESCE(SUM(gb.total), 0) as total
            FROM gaji_bulanan gb
            JOIN karyawan k ON k.id = gb.idkaryawan
            WHERE gb.hapus = 0
              AND k.divisi IN (3, 17)
              AND k.hapus = 0
              AND gb.tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['sablon_gaji_bulanan'] = (float)($gaji_bulanan_sablon['total'] ?? 0);

        // Ajuan Harian Sablon (kategori=1)
        $ajuan_sablon = $this->db->query("
            SELECT COALESCE(SUM(d.harga * d.jumlah), 0) as total
            FROM pengajuan_harian_new p
            JOIN pengajuan_harian_new_detail d ON d.idpengajuan = p.id
            WHERE p.hapus = 0
              AND p.status = 1
              AND p.kategori = 1
              AND p.tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['sablon_ajuan_harian'] = (float)($ajuan_sablon['total'] ?? 0);

        // Ajuan Harian Sukabumi (kategori=4)
        $ajuan_sukabumi = $this->db->query("
            SELECT COALESCE(SUM(d.harga * d.jumlah), 0) as total
            FROM pengajuan_harian_new p
            JOIN pengajuan_harian_new_detail d ON d.idpengajuan = p.id
            WHERE p.hapus = 0
              AND p.status = 1
              AND p.kategori = 4
              AND p.tanggal BETWEEN '$tgl1' AND '$tgl2'
        ")->row_array();
        $data['sukabumi_ajuan_harian'] = (float)($ajuan_sukabumi['total'] ?? 0);

        // TOTAL PENGELUARAN KONVEKSI & LAIN-LAIN
        $data['total_pengeluaran_konveksi'] = $data['konveksi_ajuan_harian']
                                            + $data['konveksi_kasbon']
                                            + $data['konveksi_gaji_bulanan']
                                            + $data['konveksi_gaji_finishing']
                                            + $data['konveksi_uang_makan_security']
                                            + $data['konveksi_insentif_security']
                                            + $data['konveksi_gaji_sukabumi']
                                            + $data['bordir_kasbon']
                                            + $data['bordir_gaji_bulanan']
                                            + $data['bordir_ajuan_harian']
                                            + $data['sablon_kasbon']
                                            + $data['sablon_gaji_bulanan']
                                            + $data['sablon_ajuan_harian']
                                            + $data['sukabumi_ajuan_harian'];

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
