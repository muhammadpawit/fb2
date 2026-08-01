<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualansisabahan extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->page   = 'newtheme/page/penjualansisabahan/';
        $this->layout = 'newtheme/page/main';
        $this->login  = BASEURL.'login';
        $this->auth   = $this->session->userdata('id_user');
        if(empty($this->auth)) { redirect($this->login); }
    }

    public function index() {
        $data['title'] = 'Penjualan Sisa Bahan';
        
        $get = $this->input->get();
        if(isset($get['tanggal1'])){
            $tgl1 = $get['tanggal1'];
        }else{
            $tgl1 = date('Y-m-d',strtotime("-1 month"));
        }
        if(isset($get['tanggal2'])){
            $tgl2 = $get['tanggal2'];
        }else{
            $tgl2 = date('Y-m-d');
        }

        $data['tanggal1'] = $tgl1;
        $data['tanggal2'] = $tgl2;

        $data['results'] = $this->db->query("SELECT * FROM penjualan_sisa_bahan WHERE hapus=0 AND tanggal BETWEEN '$tgl1' AND '$tgl2' ORDER BY tanggal DESC")->result_array();
        
        $data['tambah'] = BASEURL.'Penjualansisabahan/tambah';
        
        $data['page'] = $this->page.'list';
        $this->load->view($this->layout, $data);
    }

    public function tambah() {
        $data['title'] = 'Tambah Penjualan Sisa Bahan';
        $data['action'] = BASEURL.'Penjualansisabahan/tambah_action';
        $data['batal'] = BASEURL.'Penjualansisabahan';
        $data['products_list'] = $this->db->get_where('product', array('hapus' => 0))->result_array();
        $data['page'] = $this->page.'tambah';
        $this->load->view($this->layout, $data);
    }

    public function tambah_action() {
        $post = $this->input->post();
        
        if (!empty($post['products'])) {
            $insert_master = array(
                'tanggal' => $post['tanggal'],
                'keterangan' => $post['keterangan'],
                'total_penjualan' => 0, // will calculate later
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('penjualan_sisa_bahan', $insert_master);
            $id_penjualan = $this->db->insert_id();

            $total_penjualan = 0;
            foreach ($post['products'] as $item) {
                if (!empty($item['nama_barang']) && $item['qty'] > 0) {
                    $total = $item['qty'] * $item['harga'];
                    $insert_detail = array(
                        'id_penjualan' => $id_penjualan,
                        'nama_barang' => $item['nama_barang'],
                        'qty' => $item['qty'],
                        'harga' => $item['harga'],
                        'total' => $total
                    );
                    $this->db->insert('penjualan_sisa_bahan_detail', $insert_detail);
                    $total_penjualan += $total;
                }
            }

            // Update master total
            $this->db->update('penjualan_sisa_bahan', array('total_penjualan' => $total_penjualan), array('id' => $id_penjualan));
            $this->session->set_flashdata('msg', 'Data berhasil disimpan');
        } else {
            $this->session->set_flashdata('gagal', 'Data gagal disimpan, item kosong');
        }
        
        redirect(BASEURL.'Penjualansisabahan');
    }

    public function edit($id) {
        $data['title'] = 'Edit Penjualan Sisa Bahan';
        $data['action'] = BASEURL.'Penjualansisabahan/edit_action';
        $data['batal'] = BASEURL.'Penjualansisabahan';
        $data['master'] = $this->db->get_where('penjualan_sisa_bahan', array('id' => $id, 'hapus' => 0))->row_array();
        
        if (empty($data['master'])) {
            redirect(BASEURL.'Penjualansisabahan');
        }

        $data['details'] = $this->db->get_where('penjualan_sisa_bahan_detail', array('id_penjualan' => $id))->result_array();
        $data['products_list'] = $this->db->get_where('product', array('hapus' => 0))->result_array();
        
        $data['page'] = $this->page.'edit';
        $this->load->view($this->layout, $data);
    }

    public function edit_action() {
        $post = $this->input->post();
        $id = $post['id'];

        if (!empty($post['products'])) {
            $update_master = array(
                'tanggal' => $post['tanggal'],
                'keterangan' => $post['keterangan'],
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->update('penjualan_sisa_bahan', $update_master, array('id' => $id));

            // Clear old details
            $this->db->delete('penjualan_sisa_bahan_detail', array('id_penjualan' => $id));

            $total_penjualan = 0;
            foreach ($post['products'] as $item) {
                if (!empty($item['nama_barang']) && $item['qty'] > 0) {
                    $total = $item['qty'] * $item['harga'];
                    $insert_detail = array(
                        'id_penjualan' => $id,
                        'nama_barang' => $item['nama_barang'],
                        'qty' => $item['qty'],
                        'harga' => $item['harga'],
                        'total' => $total
                    );
                    $this->db->insert('penjualan_sisa_bahan_detail', $insert_detail);
                    $total_penjualan += $total;
                }
            }

            // Update master total
            $this->db->update('penjualan_sisa_bahan', array('total_penjualan' => $total_penjualan), array('id' => $id));
            $this->session->set_flashdata('msg', 'Data berhasil diupdate');
        } else {
            $this->session->set_flashdata('gagal', 'Data gagal diupdate, item kosong');
        }

        redirect(BASEURL.'Penjualansisabahan');
    }

    public function hapus($id) {
        $this->db->update('penjualan_sisa_bahan', array('hapus' => 1), array('id' => $id));
        $this->session->set_flashdata('msg', 'Data berhasil dihapus');
        redirect(BASEURL.'Penjualansisabahan');
    }

    public function detail($id) {
        $data['title'] = 'Detail Penjualan Sisa Bahan';
        $data['master'] = $this->db->get_where('penjualan_sisa_bahan', array('id' => $id))->row_array();
        
        if (empty($data['master'])) {
            redirect(BASEURL.'Penjualansisabahan');
        }

        $data['details'] = $this->db->get_where('penjualan_sisa_bahan_detail', array('id_penjualan' => $id))->result_array();
        
        $data['kembali'] = BASEURL.'Penjualansisabahan';
        $data['page'] = $this->page.'detail';
        $this->load->view($this->layout, $data);
    }
}
