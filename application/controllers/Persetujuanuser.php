<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persetujuanuser extends CI_Controller {

	public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;

	function __construct() {
		parent::__construct();
		$this->layout = 'newtheme/page/main';
		$this->page = 'newtheme/page/persetujuan/';
		$this->url = BASEURL . 'Persetujuanuser/';
		$this->login = BASEURL . 'login';
		$this->auth = $this->session->userdata('id_user');
		if(empty($this->auth)) { redirect($this->login); }
	}

	public function index() {
		$data = [];
		$data['title'] = 'Pengaturan User Penerima Notifikasi Persetujuan';
		$data['tambah'] = $this->url . 'add';
		$sql = "SELECT pu.*, u.nama_user, u.email_user, j.nama as nama_jabatan 
				FROM persetujuan_user pu 
				JOIN user u ON pu.id_user = u.id_user 
				LEFT JOIN jabatan j ON u.jabatan_user = j.id 
				ORDER BY pu.id DESC";
		$data['users'] = $this->GlobalModel->queryManual($sql);
		$data['page'] = $this->page . 'list';
		$this->load->view($this->layout, $data);
	}

	public function add() {
		$data = [];
		$data['title'] = 'Tambah User Penerima Notifikasi Persetujuan';
		$data['action'] = $this->url . 'save';
		$data['cancel'] = $this->url;
		$data['users'] = $this->GlobalModel->queryManual("SELECT u.id_user, u.nama_user, j.nama as nama_jabatan 
			FROM user u 
			LEFT JOIN jabatan j ON u.jabatan_user = j.id 
			WHERE u.hapus = 0 
			ORDER BY u.nama_user ASC");
		$data['page'] = $this->page . 'form';
		$this->load->view($this->layout, $data);
	}

	public function save() {
		$post = $this->input->post();
		if (!empty($post['id_user'])) {
			$tipe = !empty($post['tipe']) ? $post['tipe'] : 'kirimgudang';
			// Cek duplikasi
			$exists = $this->GlobalModel->getDataRow('persetujuan_user', array('id_user' => $post['id_user'], 'tipe' => $tipe));
			if (!empty($exists)) {
				$this->session->set_flashdata('gagal', 'User tersebut sudah terdaftar untuk persetujuan tipe ini!');
			} else {
				$insert = array(
					'id_user'    => $post['id_user'],
					'tipe'       => $tipe,
					'aktif'      => isset($post['aktif']) ? $post['aktif'] : 1,
					'created_at' => date('Y-m-d H:i:s')
				);
				$this->GlobalModel->insertData('persetujuan_user', $insert);
				$this->session->set_flashdata('msg', 'User berhasil ditambahkan ke daftar persetujuan!');
			}
		}
		redirect($this->url);
	}

	public function edit($id) {
		$data = [];
		$data['title'] = 'Edit User Penerima Notifikasi Persetujuan';
		$data['action'] = $this->url . 'update/' . $id;
		$data['cancel'] = $this->url;
		$data['p'] = $this->GlobalModel->getDataRow('persetujuan_user', array('id' => $id));
		$data['users'] = $this->GlobalModel->queryManual("SELECT u.id_user, u.nama_user, j.nama as nama_jabatan 
			FROM user u 
			LEFT JOIN jabatan j ON u.jabatan_user = j.id 
			WHERE u.hapus = 0 
			ORDER BY u.nama_user ASC");
		$data['page'] = $this->page . 'form';
		$this->load->view($this->layout, $data);
	}

	public function update($id) {
		$post = $this->input->post();
		if (!empty($post['id_user'])) {
			$tipe = !empty($post['tipe']) ? $post['tipe'] : 'kirimgudang';
			$update = array(
				'id_user' => $post['id_user'],
				'tipe'    => $tipe,
				'aktif'   => isset($post['aktif']) ? $post['aktif'] : 1
			);
			$this->GlobalModel->updateData('persetujuan_user', array('id' => $id), $update);
			$this->session->set_flashdata('msg', 'Data persetujuan berhasil diperbarui!');
		}
		redirect($this->url);
	}

	public function delete($id) {
		$this->GlobalModel->deleteData('persetujuan_user', array('id' => $id));
		$this->session->set_flashdata('msg', 'Data persetujuan user berhasil dihapus!');
		redirect($this->url);
	}

	public function toggle($id) {
		$row = $this->GlobalModel->getDataRow('persetujuan_user', array('id' => $id));
		if (!empty($row)) {
			$new_status = ($row['aktif'] == 1) ? 0 : 1;
			$this->GlobalModel->updateData('persetujuan_user', array('id' => $id), array('aktif' => $new_status));
			$this->session->set_flashdata('msg', 'Status aktif berhasil diubah!');
		}
		redirect($this->url);
	}

	public function kirimgudang() {
		$data = [];
		$data['title'] = 'Daftar Persetujuan Surat Jalan Kirim Gudang';
		$id_user_login = callSessUser('id_user');
		$cek_approver = $this->GlobalModel->queryManualRow("SELECT id FROM persetujuan_user WHERE id_user = '".$id_user_login."' AND tipe = 'kirimgudang' AND aktif = 1");
		$data['is_approver'] = !empty($cek_approver) ? true : false;

		$get = $this->input->get();
		$nofaktur = isset($get['nofaktur']) ? trim($get['nofaktur']) : '';
		$data['nofaktur'] = $nofaktur;

		// Ambil semua faktur yang berstatus 'dibuat' (belum disetujui)
		$sql_faktur = "SELECT nofaktur, tanggal_kirim, nama_penerima, tujuan 
			FROM finishing_kirim_gudang 
			WHERE status = 'dibuat' ";
		if (!empty($nofaktur)) {
			$sql_faktur .= " AND nofaktur LIKE '%" . $this->db->escape_like_str($nofaktur) . "%' ";
		}
		$sql_faktur .= " GROUP BY nofaktur ORDER BY tanggal_kirim DESC, id_finishing_kirim_gudang DESC";

		$fakturs = $this->GlobalModel->queryManual($sql_faktur);

		$list = [];
		foreach ($fakturs as $f) {
			$items = $this->GlobalModel->queryManual("SELECT fkg.*, pp.nama_po, pp.kode_po as po_kode, pp.kode_artikel 
				FROM finishing_kirim_gudang fkg 
				LEFT JOIN produksi_po pp ON fkg.idpo = pp.id_produksi_po 
				WHERE fkg.nofaktur = '".$f['nofaktur']."'");

			$items_detail = [];
			$total_pcs = 0;
			$total_potongan = 0;
			$total_setor = 0;

			foreach ($items as $item) {
				$idpo = $item['idpo'];
				$kodepo = $item['kode_po'];

				// Potongan
				$pot = $this->GlobalModel->queryManualRow("SELECT hasil_pieces_potongan, hasil_lusinan_potongan, created_date 
					FROM konveksi_buku_potongan 
					WHERE idpo = '".$idpo."' OR kode_po = '".$kodepo."' OR kode_po = '".$idpo."' LIMIT 1");
				$potongan_pcs = !empty($pot['hasil_pieces_potongan']) ? (float)$pot['hasil_pieces_potongan'] : 0;
				$total_potongan += $potongan_pcs;

				// Setoran Kaos (Reguler)
				$setor1 = $this->GlobalModel->queryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima - COALESCE(bangke_qty,0)), 0) as setor 
					FROM kelolapo_rincian_setor_cmt 
					WHERE idpo = '".$idpo."'");

				// Setoran Celana
				$setor2 = $this->GlobalModel->queryManualRow("SELECT COALESCE(SUM(jml_setor_qty - COALESCE(bangke_qty,0)), 0) as setor 
					FROM kelolapo_rincian_setor_cmt_celana 
					WHERE idpo = '".$idpo."'");

				$setoran_pcs = 0;
				if (!empty($setor1['setor']) && $setor1['setor'] > 0) {
					$setoran_pcs = (float)$setor1['setor'];
				} elseif (!empty($setor2['setor']) && $setor2['setor'] > 0) {
					$setoran_pcs = (float)$setor2['setor'];
				}
				$total_setor += $setoran_pcs;

				// CMT Jahit Info
				$cmt = $this->GlobalModel->queryManualRow("SELECT nama_cmt, qty_tot_pcs, kode_nota_cmt 
					FROM kelolapo_kirim_setor 
					WHERE (idpo = '".$idpo."' OR kode_po = '".$kodepo."') AND kategori_cmt = 'JAHIT' 
					ORDER BY id_kelolapo_kirim_setor DESC LIMIT 1");

				// Rincian Size Kirim Gudang
				$rincian_size = $this->GlobalModel->getData('finishing_kirim_gudang_rincian', array('id_finishing_kirim_gudang' => $item['id_finishing_kirim_gudang']));

				$total_pcs += (float)$item['jumlah_piece_diterima'];

				$items_detail[] = array(
					'item'         => $item,
					'potongan'     => $potongan_pcs,
					'potongan_row' => $pot,
					'setoran'      => $setoran_pcs,
					'cmt'          => $cmt,
					'rincian_size' => $rincian_size
				);
			}

			$list[] = array(
				'faktur'         => $f,
				'items'          => $items_detail,
				'total_pcs'      => $total_pcs,
				'total_potongan' => $total_potongan,
				'total_setor'    => $total_setor
			);
		}

		$data['list'] = $list;
		$data['page'] = $this->page . 'kirimgudang';
		$this->load->view($this->layout, $data);
	}

	public function approve_action($nofaktur, $status) {
		$id_user_login = callSessUser('id_user');
		$cek_approver = $this->GlobalModel->queryManualRow("SELECT id FROM persetujuan_user WHERE id_user = '".$id_user_login."' AND tipe = 'kirimgudang' AND aktif = 1");
		if (empty($cek_approver)) {
			$this->session->set_flashdata('gagal', 'Anda tidak memiliki hak akses untuk menyetujui dokumen ini!');
			redirect($this->url . 'kirimgudang');
		}

		$status = strtolower($status);
		if (in_array($status, array('disetujui', 'ditolak', 'dibuat'))) {
			$this->db->update('finishing_kirim_gudang', array('status' => $status), array('nofaktur' => $nofaktur));
			$pesan = ($status == 'disetujui') ? "Surat Jalan nomor faktur $nofaktur berhasil DISETUJUI!" : "Surat Jalan nomor faktur $nofaktur berhasil diubah menjadi: " . strtoupper($status);
			$this->session->set_flashdata('msg', $pesan);
		}
		redirect($this->url . 'kirimgudang');
	}
}
