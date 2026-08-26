<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajuankemejabaru extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->page='newtheme/page/';
		$this->url=BASEURL.'Ajuankemejabaru/';
        // Memuat model
        $this->load->model('AjuanKemejaModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
    }

    // Fungsi untuk menampilkan semua data
    public function index() {
        $data = [];
        $data['title']='Ajuan Alat-alat Kirim PO Kemeja ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}

		if (isset($get['spv'])) {
			$periode = $this->GlobalModel->QueryManualRow("SELECT bulan, tahun FROM periodeproduksi LIMIT 1");
			$tanggal1 = !empty($periode) ? $periode['tahun'] . '-' . str_pad($periode['bulan'], 2, '0', STR_PAD_LEFT) . '-01' : date('Y-m-01');
			$tanggal2 = date('Y-m-d');
			if (isset($get['tanggal1'])) {
				$tanggal1 = $get['tanggal1'];
			}
			if (isset($get['tanggal2'])) {
				$tanggal2 = $get['tanggal2'];
			}
		}

        $data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
        $data['tambah']=BASEURL.'Ajuankemejabaru/tambah';
		$data['accAjuan'] = BASEURL . 'Ajuankemejabaru/acc_ajuan_mingguan_allkemeja';

		$data['products'] = array();
		$data['n'] = 1;
		$sql = "SELECT * FROM ajuan_mingguan_kemeja WHERE hapus=0";
		if (isset($get['spv'])) {
			$sql .= " AND jml_acc=0 AND DATE(tanggal) BETWEEN '" . $tanggal1 . "' AND '" . $tanggal2 . "' ";
		} else {
			$sql .= " AND DATE(tanggal) BETWEEN '" . $tanggal1 . "' AND '" . $tanggal2 . "'";
		}
		if (!empty($cat)) {
			$sql .= " AND jenis='" . $cat . "' ";
		}
		$sql .= " ORDER BY jml_acc ASC ";

		$results = $this->GlobalModel->queryManual($sql);
		foreach ($results as $result) {
			$satuan = $this->GlobalModel->GetDataRow('product', array('hapus' => 0, 'nama' => $result['kebutuhan']));
			$data['products'][] = array(
				'id' => $result['id'],
				'tanggal' => $result['tanggal'],
				'kebutuhan' => '' . $result['kebutuhan'],
				'ajuan_kebutuhan' => isset($result['ajuan_kebutuhan']) ? $result['ajuan_kebutuhan'] : 0,
				'satuan' => !empty($satuan) ? $satuan['satuan'] : '',
				'jml_ajuan' => $result['jml_ajuan'],
				'jml_acc' => $result['jml_acc'],
				'keterangan' => $result['keterangan'],
				'keterangan2' => $result['keterangan2'],
				'edit' => BASEURL . 'Ajuankemejabaru/edit/' . $result['id'],
				'detail' => BASEURL . 'Ajuankemejabaru/detail/' . $result['id'],
				'batal' => BASEURL . 'Ajuankemejabaru/batal/' . $result['id'],
				'bataladmin' => BASEURL . 'Ajuankemejabaru/bataladmin/' . $result['id'],
				'excel' => BASEURL . 'Ajuankemejabaru/detail/' . $result['id'] . '?&excel=1',
				'stok' => $result['stok'],
				'acc_satuan' => $result['acc_satuan'],
			);
		}

        $data['acc_ajuan_mingguan'] = $this->GlobalModel->QueryManualRow("SELECT tanggal FROM acc_ajuan_mingguan WHERE DATE(tanggal)='" . $tanggal1 . "' ORDER BY tanggal DESC LIMIT 1");
		$data['tgl_diacc']	= !empty($data['acc_ajuan_mingguan']) ? $data['acc_ajuan_mingguan']['tanggal'] : null;

        if(isset($get['spv'])){
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_baru_spv';
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_baru';
		}
        $this->load->view($this->page.'main',$data);
    }

    public function tambah() {
        $data = array();
		$data['title'] = 'Form Ajuan Alat-alat Kirim PO Kemeja';
		$data['action'] = BASEURL . 'Ajuankemejabaru/store';
		$data['cancel'] = BASEURL . 'Ajuankemejabaru';
		$data['po'] = $this->GlobalModel->getData('produksi_po', array('hapus' => 0));
		$data['products'] = $this->GlobalModel->getData('product', array('hapus' => 0));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
		$data['page'] = $this->page . 'gudang/pengajuan/mingguan_form_kemeja';
		$this->load->view($this->page . 'main', $data);
    }

    public function store() {
		$data = $this->input->post();
		if (isset($data['products'])) {
			$item = $this->GlobalModel->GetDataRow('product', array('product_id' => $data['kebutuhan']));
			$am = array(
				'tanggal' => $data['tanggal'],
				'jenis' => $data['jenis'], // 1 konveksi, 2 bordir, 3 sablon
				'kebutuhan' => $item['nama'],
				'product_id' => $item['product_id'],
				'ajuan_kebutuhan' => 0,
				'stok' => $data['stok_skb'],
				'jml_ajuan' => 0,
				'keterangan' => 'kebutuhan ' . $data['kebutuhan'],
				'keterangan2' => $data['keterangan2'],
				'supplier_id' => $data['supplier_id'],
			);
			$this->db->insert('ajuan_mingguan_kemeja', $am);
			$id = $this->db->insert_id();
			$totalajuan = 0;
			foreach ($data['products'] as $p) {
				$totalajuan += ($p['jumlah_po'] * $p['jml_pcs']);
				$insert = array(
					'idajuan' => $id,
					'tanggal' => $data['tanggal'],
					'tanggal2' => $data['tanggal'],
					'kode_po' => $p['kode_po'],
					'jumlah_po' => $p['jumlah_po'],
					'rincian_po' => $p['rincian_po'],
					'jml_pcs' => $p['jml_pcs'],
					'jml_dz' => $p['jml_dz'],
					'keterangan' => $p['keterangan'],
					'hapus' => 0,
				);
				$this->db->insert('ajuan_mingguan_detail_kemeja', $insert);
			}
			$this->db->update('ajuan_mingguan_kemeja', array('ajuan_kebutuhan' => $totalajuan, 'jml_ajuan' => $totalajuan - $data['stok_skb']), array('id' => $id));
		}
		$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		redirect($this->url);
    }

    public function edit($id) {
        $data = array();
		$data['n'] = 1;
		$data['title'] = 'Edit Ajuan Alat-alat Kirim Kemeja';
		$data['action'] = BASEURL . 'Ajuankemejabaru/update';
		$data['cancel'] = BASEURL . 'Ajuankemejabaru';
		$data['excel'] = BASEURL . 'Ajuankemejabaru/detail/' . $id . '?&excel=1';
		$data['k'] = $this->GlobalModel->getDataRow('ajuan_mingguan_kemeja', array('hapus' => 0, 'id' => $id));
		$data['kd'] = $this->GlobalModel->getData('ajuan_mingguan_detail_kemeja', array('hapus' => 0, 'idajuan' => $id));
		$data['products'] = $this->GlobalModel->getData('product', array('hapus' => 0));
		$data['acc'] = BASEURL . 'Ajuankemejabaru/approve';
		$get = $this->input->get();
		if (isset($get['excel'])) {
			$this->load->view($this->page . 'gudang/pengajuan/mingguan_detail_excel', $data);
		} else {
			$data['page'] = $this->page . 'gudang/pengajuan/mingguan_edit';
			$this->load->view($this->page . 'main', $data);
		}
    }

    public function update() {
        $data = $this->input->post();
		if (isset($data['products'])) {
			$this->db->update('ajuan_mingguan_detail_kemeja', array('hapus' => 1), array('idajuan' => $data['id']));
			$totalajuan = 0;
			foreach ($data['products'] as $p) {
				$totalajuan += ($p['jumlah_po'] * $p['jml_pcs']);
				$insert = array(
					'idajuan' => $data['id'],
					'tanggal' => $data['tanggal'],
					'tanggal2' => $data['tanggal'],
					'kode_po' => $p['kode_po'],
					'jumlah_po' => $p['jumlah_po'],
					'rincian_po' => $p['rincian_po'],
					'jml_pcs' => $p['jml_pcs'],
					'jml_dz' => $p['jml_dz'],
					'keterangan' => $p['keterangan'],
					'hapus' => 0,
				);
				$this->db->insert('ajuan_mingguan_detail_kemeja', $insert);
			}
			$this->db->update('ajuan_mingguan_kemeja', array('keterangan2' => $data['keterangan'], 'ajuan_kebutuhan' => $totalajuan, 'stok' => $data['stok'], 'jml_ajuan' => $totalajuan - $data['stok']), array('id' => $data['id']));
		}
		$this->session->set_flashdata('msg', 'Data berhasil disimpan');
		redirect($this->url);
    }

    public function detail($id) {
        $data = array();
		$data['n'] = 1;
		$data['title'] = 'Detail Ajuan Alat-alat Kirim Kemeja';
		$get = $this->input->get();
		$url = '';
		if (isset($get['spv'])) {
			$url = '?&spv=true';
		}
		$data['action'] = BASEURL . 'Ajuankemejabaru/store';
		$data['cancel'] = BASEURL . 'Ajuankemejabaru' . $url;
		$data['excel'] = BASEURL . 'Ajuankemejabaru/detail/' . $id . '?&excel=1';
		$data['k'] = $this->GlobalModel->getDataRow('ajuan_mingguan_kemeja', array('hapus' => 0, 'id' => $id));
		$data['kd'] = $this->GlobalModel->getData('ajuan_mingguan_detail_kemeja', array('hapus' => 0, 'idajuan' => $id));
		$data['products'] = $this->GlobalModel->getData('product', array('hapus' => 0));
		$data['acc'] = BASEURL . 'Ajuankemejabaru/approve';
		$get = $this->input->get();
		if (isset($get['excel'])) {
			$this->load->view($this->page . 'gudang/pengajuan/mingguan_detail_excel', $data);
		} else {
			$data['page'] = $this->page . 'gudang/pengajuan/mingguan_detail';
			$this->load->view($this->page . 'main', $data);
		}
    }

    public function approve() {
        $post = $this->input->post();
		$update = array(
			'jml_acc' => $post['jml_acc']
		);
		$where = array('id' => $post['id']);
		$this->db->update('ajuan_mingguan_kemeja', $update, $where);
		$this->session->set_flashdata('msg', 'Data berhasil di acc');
		redirect($this->url . '?&spv=true');
    }

    public function batal($id) {
        $this->db->update('ajuan_mingguan_kemeja', array('hapus' => 1), array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dibatalkan');
		redirect($this->url . '?&spv=true');
    }

    public function bataladmin($id) {
        $this->db->update('ajuan_mingguan_kemeja', array('hapus' => 1), array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dibatalkan');
		redirect($this->url);
    }

    public function setujui() {
        $post = $this->input->post();
		foreach ($post['prods'] as $pr) {
			$update = array(
				'jml_acc' => $pr['jml_acc'],
				'acc_satuan' => $pr['acc_satuan'],
			);
			$where = array(
				'id' => $pr['id'],
			);
			$this->db->update('ajuan_mingguan_kemeja', $update, $where);
		}
		$cat = 3; // kategori untuk ajuan harian bagian konveksi
		$cekajuan_harian = $this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE kategori='" . $cat . "' AND from_alat IS NOT NULL AND DATE(tanggal)='" . $post['tanggal'] . "' AND hapus=0 ");
		if (empty($cekajuan_harian)) {
			$ip = array(
				'kategori' => $cat,
				'cash' => 0,
				'transfer' => 0,
				'status' => 1,
				'hapus' => 0,
				'tanggal' => date('Y-m-d'),
				'keterangan' => '',
				'dibuat' => date('Y-m-d H:i:s'),
				'from_alat' => TRUE
			);
			$this->db->insert('pengajuan_harian_new', $ip);
			$id = $this->db->insert_id();
			$transfer = 0;
			foreach ($post['prods'] as $pr) {
				$p = $this->GlobalModel->GetDataRow('ajuan_mingguan_kemeja', array('id' => $pr['id']));
				$item = $this->GlobalModel->GetDataRow('product', array('product_id' => $p['product_id']));
				$supplier = $this->GlobalModel->GetDataRow('master_supplier', array('id' => $p['supplier_id']));
				$transfer += ($item['harga_beli'] * $pr['jml_acc']);
				$rip = array(
					'idpengajuan' => $id,
					'nama_item' => $item['nama'],
					'jumlah' => $pr['jml_acc'],
					'satuan' => $item['satuan'],
					'harga' => $item['harga_beli'],
					'pembayaran' => 2, // transfer
					'supplier_id' => isset($p['supplier_id']) ? $p['supplier_id'] : null,
					'supplier' => isset($supplier['nama']) ? $supplier['nama'] : '-',
					'product_id' => isset($item['product_id']) ? $item['product_id'] : (isset($p['product_id']) ? $p['product_id'] : null),
					'keterangan' => $p['keterangan'],
					'status' => 1,
					'from_alat' => $p['id']
				);
				$this->db->insert('pengajuan_harian_new_detail', $rip);
			}
			$this->db->update('pengajuan_harian_new', array('cash' => 0, 'transfer' => $transfer), array('id' => $id));
			
			$image_data = $this->input->post('image_data');
			if (!empty($image_data)) {
				$update = array(
					'paraf' => $image_data,
				);
				$where = array(
					'id' => $id,
				);
				$this->db->update('pengajuan_harian_new',$update,$where);
			}
		} else {
			$id = $cekajuan_harian['id'];
			$transfer = 0;
			foreach ($post['prods'] as $pr) {
				$p = $this->GlobalModel->GetDataRow('ajuan_mingguan_kemeja', array('id' => $pr['id']));
				$item = $this->GlobalModel->GetDataRow('product', array('product_id' => $p['product_id']));
				$supplier = $this->GlobalModel->GetDataRow('master_supplier', array('id' => $p['supplier_id']));
				$transfer = ($item['harga_beli'] * $p['jml_acc']);
				$rip = array(
					'nama_item' => $item['nama'],
					'jumlah' => $p['jml_acc'],
					'satuan' => $item['satuan'],
					'harga' => $item['harga_beli'],
					'pembayaran' => 2, // transfer
					'supplier_id' => isset($p['supplier_id']) ? $p['supplier_id'] : null,
					'supplier' => isset($supplier['nama']) ? $supplier['nama'] : '-',
					'product_id' => isset($item['product_id']) ? $item['product_id'] : (isset($p['product_id']) ? $p['product_id'] : null),
					'keterangan' => $p['keterangan'],
					'status' => 1,
					'from_alat' => $p['id']
				);
				$wu = array(
					'from_alat' => $p['id']
				);
				$this->db->update('pengajuan_harian_new_detail', $rip, $wu);
			}
		}
		echo $id;
    }

	public function excel_all()
	{
		$data = array();
		$data['title'] = 'Ajuan Alat-alat Kirim PO Kemeja';
		$get = $this->input->get();
		if (isset($get['tanggal1'])) {
			$tanggal1 = $get['tanggal1'];
		} else {
			$tanggal1 = date('Y-m-d', strtotime("first day of this month"));
		}
		if (isset($get['tanggal2'])) {
			$tanggal2 = $get['tanggal2'];
		} else {
			$tanggal2 = date('Y-m-d');
		}
		if (isset($get['cat'])) {
			$cat = $get['cat'];
		} else {
			$cat = null;
		}

		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		$data['products'] = array();
		$data['n'] = 1;
		$sql = "SELECT * FROM ajuan_mingguan_kemeja WHERE hapus=0";
		$sql .= " AND DATE(tanggal) BETWEEN '" . $tanggal1 . "' AND '" . $tanggal2 . "'";
		if (!empty($cat)) {
			$sql .= " AND jenis='" . $cat . "' ";
		}
		$sql .= " ORDER BY id DESC ";

		$results = $this->GlobalModel->queryManual($sql);
		foreach ($results as $result) {
			$satuan = $this->GlobalModel->GetDataRow('product', array('hapus' => 0, 'nama' => $result['kebutuhan']));
			$data['products'][] = array(
				'id' => $result['id'],
				'tanggal' => $result['tanggal'],
				'kebutuhan' => '' . $result['kebutuhan'],
				'ajuan_kebutuhan' => isset($result['ajuan_kebutuhan']) ? $result['ajuan_kebutuhan'] : 0,
				'satuan' => !empty($satuan) ? $satuan['satuan'] : '',
				'jml_ajuan' => $result['jml_ajuan'],
				'jml_acc' => $result['jml_acc'],
				'keterangan' => $result['keterangan'],
				'keterangan2' => $result['keterangan2'],
				'stok' => $result['stok'],
			);
		}
		$this->load->view($this->page . 'gudang/pengajuan/mingguan_excel_all', $data);
	}
}
