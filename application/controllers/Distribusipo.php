<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusipo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->url     = BASEURL . 'Distribusipo/';
		$this->page    = 'newtheme/page/distribusipo/';
		$this->layout  = 'newtheme/page/main';
		$this->login   = BASEURL . 'login';
		$this->auth    = $this->session->userdata('id_user');

		if (empty($this->auth)) {
			redirect($this->login);
		}
	}

	public function index() {
		$data           = array();
		$data['title']  = 'Surat Jalan Distribusi PO Sukabumi';
		$data['url']    = $this->url;
		$data['tambah'] = $this->url . 'tambah';

		$get      = $this->input->get();
		$tanggal1 = isset($get['tanggal1']) ? $get['tanggal1'] : null;
		$tanggal2 = isset($get['tanggal2']) ? $get['tanggal2'] : null;
		$cmt      = isset($get['cmt']) ? $get['cmt'] : null;
		$sj       = isset($get['sj']) ? $get['sj'] : null;

		$data['tanggal1'] = $tanggal1;
		$data['tanggal2'] = $tanggal2;
		$data['cmt']      = $cmt;
		$data['sj']       = $sj;

		$data['listcmt'] = $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="JAHIT" AND lokasi=3 AND id_cmt NOT IN(85) ORDER BY cmt_name ASC');
		$data['nosj']    = $this->GlobalModel->queryManual('SELECT * FROM kirimcmt WHERE hapus=0 ORDER BY id DESC');

		$sql  = "SELECT kc.*, mc.cmt_name FROM kirimcmt kc ";
		$sql .= " LEFT JOIN master_cmt mc ON mc.id_cmt=kc.idcmt ";
		$sql .= " WHERE kc.hapus=0 AND kc.cmtkat='JAHIT' ";

		if (!empty($cmt) && $cmt != '*') {
			$sql .= " AND kc.idcmt='$cmt' ";
		}

		if (!empty($sj) && $sj != '*') {
			$sql .= " AND kc.id='$sj' ";
		}

		if ((empty($cmt) || $cmt == '*') && (empty($sj) || $sj == '*')) {
			if (!empty($tanggal1) && !empty($tanggal2)) {
				$sql .= " AND DATE(kc.tanggal) BETWEEN '" . $tanggal1 . "' AND '" . $tanggal2 . "' ";
			}
		}

		$sql .= ' ORDER BY kc.id DESC LIMIT 50 ';
		$results = $this->GlobalModel->queryManual($sql);

		$data['products'] = array();
		$no = 1;
		foreach ($results as $result) {
			$action   = array();
			$action[] = array(
				'text' => 'Detail',
				'href' => $this->url . 'view/' . $result['id'],
			);

			if (function_exists('aksesedit') ? aksesedit() : 1) {
				$action[] = array(
					'text' => 'Edit',
					'href' => $this->url . 'edit/' . $result['id'],
				);
			}

			if (function_exists('akseshapus') ? akseshapus() : 1) {
				$action[] = array(
					'text' => 'Hapus',
					'href' => $this->url . 'hapus/' . $result['id'],
				);
			}

			$action[] = array(
				'text' => 'Cetak',
				'href' => $this->url . 'cetak/' . $result['id'] . '/1',
			);

			$namacmt = $this->GlobalModel->getDataRow('master_cmt', array('id_cmt' => $result['idcmt']));

			$data['products'][] = array(
				'no'         => $no++,
				'id'         => $result['id'],
				'nosj'       => $result['nosj'],
				'tanggal'    => date('d-m-Y', strtotime($result['tanggal'])),
				'quantity'   => $result['totalkirim'],
				'namacmt'    => !empty($namacmt['cmt_name']) ? $namacmt['cmt_name'] : '-',
				'keterangan' => $result['keterangan'],
				'supir'      => isset($result['supir']) ? $result['supir'] : '-',
				'pendamping' => isset($result['pendamping']) ? $result['pendamping'] : '',
				'status'     => $result['status'] == 1 ? 'Disetor' : 'Dikirim',
				'action'     => $action,
			);
		}

		$data['page'] = $this->page . 'list';
		$this->load->view($this->layout, $data);
	}

	public function tambah() {
		$data          = array();
		$data['title'] = 'Tambah Surat Jalan Distribusi PO';
		$data['url']   = $this->url;
		$data['cancel'] = $this->url;
		$data['action'] = $this->url . 'tambah_save';

		$data['kirim']     = $this->GlobalModel->queryManual("SELECT kd.*, k.idcmt, k.nosj, k.tanggal as tglsj, k.id as idsj, p.kode_po as nama_po, p.serian FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) LEFT JOIN produksi_po p ON (p.id_produksi_po=kd.kode_po OR p.kode_po=kd.kode_po) WHERE k.idcmt=85 AND kd.hapus=0 AND k.hapus=0 AND kd.kode_po NOT IN (SELECT kd2.kode_po FROM kirimcmt_detail kd2 JOIN kirimcmt k2 ON(k2.id=kd2.idkirim) WHERE k2.nosj LIKE 'SJDIS%' AND kd2.hapus=0 AND k2.hapus=0) GROUP BY kd.kode_po ORDER BY kd.id DESC");
		$data['cmt']       = $this->GlobalModel->queryManual("SELECT * FROM master_cmt WHERE lokasi=3 AND hapus=0 AND id_cmt NOT IN(85) ORDER BY cmt_name ASC");
		$data['pekerjaan'] = $this->GlobalModel->getData('master_job', array('hapus' => 0, 'jenis' => 1));

		$data['page'] = $this->page . 'add';
		$this->load->view($this->layout, $data);
	}

	public function carip() {
		$get = $this->input->get();
		$po  = isset($get['po']) ? $get['po'] : '';

		$sql = "SELECT kd.*, k.idcmt, k.nosj, k.tanggal as tglsj, k.id as idsj, p.kode_po as nama_po 
		        FROM kirimcmt_detail kd 
		        JOIN kirimcmt k ON(k.id=kd.idkirim) 
		        LEFT JOIN produksi_po p ON (p.id_produksi_po=kd.kode_po OR p.kode_po=kd.kode_po)
		        WHERE k.idcmt=85 AND kd.hapus=0 AND k.hapus=0 ";
		if (!empty($po)) {
			$sql .= " AND (kd.kode_po = '" . $this->db->escape_str($po) . "' OR p.kode_po LIKE '%" . $this->db->escape_like_str($po) . "%') ";
		}
		$sql .= " GROUP BY kd.kode_po LIMIT 1 ";
		$data = $this->GlobalModel->queryManualRow($sql);

		echo json_encode($data);
	}

	public function search_po_sukabumi() {
		$get       = $this->input->get();
		$search    = isset($get['q']) ? $get['q'] : (isset($get['term']) ? $get['term'] : '');
		$except_id = isset($get['except_id']) ? (int)$get['except_id'] : 0;

		$sql = "SELECT kd.kode_po as id_po, kd.jumlah_pcs, kd.rincian_po, kd.cmtjob, kd.jml_barang, kd.keterangan, p.kode_po as nama_po, p.serian 
		        FROM kirimcmt_detail kd 
		        JOIN kirimcmt k ON(k.id=kd.idkirim) 
		        LEFT JOIN produksi_po p ON (p.id_produksi_po=kd.kode_po OR p.kode_po=kd.kode_po)
		        WHERE k.idcmt=85 AND kd.hapus=0 AND k.hapus=0 
		        AND kd.kode_po NOT IN (
		            SELECT kd2.kode_po 
		            FROM kirimcmt_detail kd2 
		            JOIN kirimcmt k2 ON (k2.id = kd2.idkirim) 
		            WHERE k2.nosj LIKE 'SJDIS%' AND kd2.hapus=0 AND k2.hapus=0 " . ($except_id > 0 ? "AND k2.id != $except_id" : "") . "
		        ) ";

		if (!empty($search)) {
			$search_clean = $this->db->escape_like_str(strtolower($search));
			$sql .= " AND (LOWER(p.kode_po) LIKE '%" . $search_clean . "%' OR LOWER(kd.kode_po) LIKE '%" . $search_clean . "%') ";
		}

		$sql .= " GROUP BY kd.kode_po ORDER BY kd.id DESC LIMIT 50 ";
		$results = $this->GlobalModel->queryManual($sql);

		$hasil = array();
		foreach ($results as $row) {
			$po_text = !empty($row['nama_po']) ? $row['nama_po'] . (!empty($row['serian']) && $row['serian'] != '0' ? ' ' . $row['serian'] : '') : $row['id_po'];
			$hasil[] = array(
				'id'          => $row['id_po'],
				'text'        => strtoupper($po_text) . ' (' . $row['jumlah_pcs'] . ' pcs)',
				'nama_po'     => strtoupper($po_text),
				'jumlah_pcs'  => $row['jumlah_pcs'],
				'rincian_po'  => $row['rincian_po'],
				'cmtjob'      => $row['cmtjob'],
				'jml_barang'  => $row['jml_barang'],
				'keterangan'  => $row['keterangan'],
			);
		}

		echo json_encode($hasil);
	}

	public function tambah_save() {
		$post = $this->input->post();

		if (!empty($post['tanggal']) && !empty($post['id_cmt']) && !empty($post['products'])) {
			$cmt = $this->GlobalModel->getDataRow('master_cmt', array('id_cmt' => $post['id_cmt']));

			$insert = array(
				'tanggal'    => $post['tanggal'],
				'kode_po'    => '-',
				'totalkirim' => 0,
				'cmtkat'     => 'JAHIT',
				'idcmt'      => $post['id_cmt'],
				'cmtjob'     => '-',
				'status'     => 0,
				'keterangan' => isset($post['keterangan']) ? $post['keterangan'] : '',
				'dibuat'     => date('Y-m-d H:i:s'),
				'supir'      => isset($post['supir']) ? ucfirst($post['supir']) : '',
				'pendamping' => isset($post['pendamping']) ? ucfirst($post['pendamping']) : '',
				'hapus'      => 0,
			);

			$this->db->insert('kirimcmt', $insert);
			$id = $this->db->insert_id();

			$totalkirim = 0;
			$inserted_count = 0;

			foreach ($post['products'] as $p) {
				if (empty($p['kode_po'])) {
					continue;
				}

				// Check duplicate: prevent double distribution of the same PO
				$already = $this->GlobalModel->queryManualRow("
					SELECT kd2.id 
					FROM kirimcmt_detail kd2 
					JOIN kirimcmt k2 ON (k2.id = kd2.idkirim) 
					WHERE k2.nosj LIKE 'SJDIS%' 
					  AND kd2.kode_po = '" . $this->db->escape_str($p['kode_po']) . "' 
					  AND kd2.hapus = 0 
					  AND k2.hapus = 0 
					LIMIT 1
				");

				if (!empty($already)) {
					continue;
				}

				$inserted_count++;
				$jumlah_pcs  = isset($p['jumlah_pcs']) ? (int)$p['jumlah_pcs'] : 0;
				$totalkirim += $jumlah_pcs;

				$detail = array(
					'idkirim'    => $id,
					'kode_po'    => $p['kode_po'],
					'cmtjob'     => isset($p['cmtjob']) ? $p['cmtjob'] : 0,
					'rincian_po' => isset($p['rincian_po']) ? $p['rincian_po'] : '',
					'jumlah_pcs' => $jumlah_pcs,
					'keterangan' => isset($p['keterangan']) ? $p['keterangan'] : '',
					'jml_barang' => isset($p['jml_barang']) ? $p['jml_barang'] : '1 plastik',
					'hapus'      => 0,
				);
				$this->db->insert('kirimcmt_detail', $detail);

				// Update status in origin kirimcmt_detail for CMT Sukabumi (85)
				$this->db->query("UPDATE kirimcmt_detail kd JOIN kirimcmt k ON k.id=kd.idkirim SET kd.status=1 WHERE k.idcmt=85 AND kd.kode_po='" . $this->db->escape_str($p['kode_po']) . "' AND kd.hapus=0");

				$masterpo = $this->GlobalModel->getDataRow('produksi_po', array('kode_po' => $p['kode_po']));
				if (empty($masterpo)) {
					$masterpo = $this->GlobalModel->getDataRow('produksi_po', array('id_produksi_po' => $p['kode_po']));
				}

				$jobprice = $this->GlobalModel->getDataRow('master_job', array('id' => isset($p['cmtjob']) ? $p['cmtjob'] : 0));

				$insertkks = array(
					'kode_po'            => !empty($masterpo) ? $masterpo['kode_po'] : $p['kode_po'],
					'create_date'        => $post['tanggal'],
					'kode_nota_cmt'      => $id,
					'progress'           => 'KIRIM',
					'kategori_cmt'       => 'JAHIT',
					'id_master_cmt'      => $post['id_cmt'],
					'id_master_cmt_job'  => isset($p['cmtjob']) ? $p['cmtjob'] : 0,
					'cmt_job_price'      => !empty($jobprice) ? $jobprice['harga'] : 0,
					'nama_cmt'           => !empty($cmt) ? $cmt['cmt_name'] : '',
					'qty_tot_pcs'        => $jumlah_pcs,
					'qty_tot_atas'       => 0,
					'qty_tot_bawah'      => 0,
					'keterangan'         => isset($p['keterangan']) ? $p['keterangan'] : '-',
					'status'             => 0,
					'jml_barang'         => isset($p['jml_barang']) ? $p['jml_barang'] : '1 plastik',
					'qty_bangke'         => 0,
					'qty_reject'         => 0,
					'qty_hilang'         => 0,
					'qty_claim'          => 0,
					'status_keu'         => 0,
					'tglinput'           => date('Y-m-d'),
					'idpo'               => !empty($masterpo) ? $masterpo['id_produksi_po'] : 0,
				);
				$this->db->insert('kelolapo_kirim_setor', $insertkks);
			}

			if ($inserted_count == 0) {
				$this->db->delete('kirimcmt', array('id' => $id));
				$this->session->set_flashdata('msg', 'Gagal menyimpan. PO yang Anda pilih sudah pernah didistribusikan sebelumnya.');
				redirect($this->url . 'tambah');
				return;
			}

			$nosj = 'SJDIS-' . date('Y-m') . '-' . $id;
			$this->db->update('kirimcmt', array('totalkirim' => $totalkirim, 'nosj' => $nosj), array('id' => $id));

			user_activity(callSessUser('id_user'), 1, ' input pengiriman surat jalan distribusi ' . $nosj);
			$this->session->set_flashdata('msg', 'Data Surat Jalan Distribusi PO berhasil disimpan');
			redirect($this->url);
		} else {
			$this->session->set_flashdata('msg', 'Gagal menyimpan. Tanggal, CMT tujuan, dan barang PO harus terisi.');
			redirect($this->url . 'tambah');
		}
	}

	public function edit($id = '') {
		$data          = array();
		$data['title'] = 'Edit Surat Jalan Distribusi PO';
		$data['url']   = $this->url;
		$data['cancel'] = $this->url;
		$data['action'] = $this->url . 'edit_save';

		$data['kirim']  = $this->GlobalModel->getDataRow('kirimcmt', array('id' => $id));
		$data['kirims'] = $this->GlobalModel->getData('kirimcmt_detail', array('idkirim' => $id, 'hapus' => 0));

		$data['kirim_po']  = $this->GlobalModel->queryManual("SELECT kd.*, k.idcmt, k.nosj, k.tanggal as tglsj, k.id as idsj, p.kode_po as nama_po, p.serian FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) LEFT JOIN produksi_po p ON (p.id_produksi_po=kd.kode_po OR p.kode_po=kd.kode_po) WHERE k.idcmt=85 AND kd.hapus=0 AND k.hapus=0 AND kd.kode_po NOT IN (SELECT kd2.kode_po FROM kirimcmt_detail kd2 JOIN kirimcmt k2 ON(k2.id=kd2.idkirim) WHERE k2.nosj LIKE 'SJDIS%' AND kd2.hapus=0 AND k2.hapus=0 AND k2.id != " . (int)$id . ") GROUP BY kd.kode_po ORDER BY kd.id DESC");
		$data['cmt']       = $this->GlobalModel->queryManual("SELECT * FROM master_cmt WHERE lokasi=3 AND hapus=0 AND id_cmt NOT IN(85) ORDER BY cmt_name ASC");
		$data['pekerjaan'] = $this->GlobalModel->getData('master_job', array('hapus' => 0, 'jenis' => 1));

		$data['page'] = $this->page . 'edit';
		$this->load->view($this->layout, $data);
	}

	public function edit_save() {
		$post = $this->input->post();
		$id   = isset($post['id']) ? $post['id'] : 0;

		if (!empty($id) && !empty($post['tanggal']) && !empty($post['id_cmt'])) {
			$cmt = $this->GlobalModel->getDataRow('master_cmt', array('id_cmt' => $post['id_cmt']));

			$update_header = array(
				'tanggal'    => $post['tanggal'],
				'idcmt'      => $post['id_cmt'],
				'supir'      => isset($post['supir']) ? ucfirst($post['supir']) : '',
				'pendamping' => isset($post['pendamping']) ? ucfirst($post['pendamping']) : '',
				'keterangan' => isset($post['keterangan']) ? $post['keterangan'] : '',
			);
			$this->db->update('kirimcmt', $update_header, array('id' => $id));

			$totalkirim = 0;
			if (!empty($post['products'])) {
				foreach ($post['products'] as $p) {
					$iddetail   = isset($p['iddetail']) ? (int)$p['iddetail'] : 0;
					$jumlah_pcs = isset($p['jumlah_pcs']) ? (int)$p['jumlah_pcs'] : 0;
					$totalkirim += $jumlah_pcs;

					if ($iddetail > 0) {
						$update_detail = array(
							'cmtjob'     => isset($p['cmtjob']) ? $p['cmtjob'] : 0,
							'rincian_po' => isset($p['rincian_po']) ? $p['rincian_po'] : '',
							'jumlah_pcs' => $jumlah_pcs,
							'keterangan' => isset($p['keterangan']) ? $p['keterangan'] : '',
							'jml_barang' => isset($p['jml_barang']) ? $p['jml_barang'] : '1 plastik',
						);
						$this->db->update('kirimcmt_detail', $update_detail, array('id' => $iddetail));
					} else if (!empty($p['kode_po'])) {
						$insert_detail = array(
							'idkirim'    => $id,
							'kode_po'    => $p['kode_po'],
							'cmtjob'     => isset($p['cmtjob']) ? $p['cmtjob'] : 0,
							'rincian_po' => isset($p['rincian_po']) ? $p['rincian_po'] : '',
							'jumlah_pcs' => $jumlah_pcs,
							'keterangan' => isset($p['keterangan']) ? $p['keterangan'] : '',
							'jml_barang' => isset($p['jml_barang']) ? $p['jml_barang'] : '1 plastik',
							'hapus'      => 0,
						);
						$this->db->insert('kirimcmt_detail', $insert_detail);
					}

					// Update kelolapo_kirim_setor
					$jobprice = $this->GlobalModel->getDataRow('master_job', array('id' => isset($p['cmtjob']) ? $p['cmtjob'] : 0));
					$this->db->update('kelolapo_kirim_setor', array(
						'id_master_cmt'     => $post['id_cmt'],
						'id_master_cmt_job' => isset($p['cmtjob']) ? $p['cmtjob'] : 0,
						'cmt_job_price'     => !empty($jobprice) ? $jobprice['harga'] : 0,
						'nama_cmt'          => !empty($cmt) ? $cmt['cmt_name'] : '',
						'qty_tot_pcs'       => $jumlah_pcs,
						'create_date'       => $post['tanggal'],
					), array(
						'kode_nota_cmt' => $id,
						'kode_po'       => $p['kode_po'],
					));
				}
			}

			$this->db->update('kirimcmt', array('totalkirim' => $totalkirim), array('id' => $id));

			user_activity(callSessUser('id_user'), 1, ' edit pengiriman surat jalan distribusi ' . $id);
			$this->session->set_flashdata('msg', 'Data Surat Jalan Distribusi PO berhasil diperbarui');
			redirect($this->url);
		} else {
			$this->session->set_flashdata('msg', 'Gagal memperbarui data.');
			redirect($this->url . 'edit/' . $id);
		}
	}

	public function view($id = '') {
		$data           = array();
		$data['title']  = 'Detail Surat Jalan Distribusi PO';
		$data['kembali'] = $this->url;
		$data['cetak']  = $this->url . 'cetak/' . $id . '/1';
		$data['excel']  = $this->url . 'cetak/' . $id . '/2';

		$data['kirim']  = $this->GlobalModel->getDataRow('kirimcmt', array('id' => $id));
		$kirims         = $this->GlobalModel->getData('kirimcmt_detail', array('idkirim' => $id, 'hapus' => 0));

		$data['kirims'] = array();
		foreach ($kirims as $k) {
			$job = $this->GlobalModel->getDataRow('master_job', array('id' => $k['cmtjob']));
			$po  = $this->GlobalModel->getDataRow('produksi_po', array('kode_po' => $k['kode_po']));
			if (empty($po)) {
				$po = $this->GlobalModel->getDataRow('produksi_po', array('id_produksi_po' => $k['kode_po']));
			}

			$data['kirims'][] = array(
				'kode_po'    => !empty($po) ? $po['kode_po'] . ' ' . (($po['serian'] != 0) ? $po['serian'] : '') : $k['kode_po'],
				'rincian_po' => $k['rincian_po'],
				'job'        => !empty($job) ? $job['nama_job'] : '-',
				'jumlah_pcs' => $k['jumlah_pcs'],
				'keterangan' => $k['keterangan'],
				'jml_barang' => $k['jml_barang'],
			);
		}

		$data['cmt']  = $this->GlobalModel->getDataRow('master_cmt', array('id_cmt' => $data['kirim']['idcmt']));
		$data['page'] = $this->page . 'view';
		$this->load->view($this->layout, $data);
	}

	public function hapus($id = '') {
		if (!empty($id)) {
			$this->db->update('kirimcmt', array('hapus' => 1), array('id' => $id));
			$this->db->update('kirimcmt_detail', array('hapus' => 1), array('idkirim' => $id));
			$this->db->update('kelolapo_kirim_setor', array('hapus' => 1), array('kode_nota_cmt' => $id));

			user_activity(callSessUser('id_user'), 1, ' hapus pengiriman surat jalan distribusi ' . $id);
			$this->session->set_flashdata('msg', 'Surat Jalan Distribusi PO berhasil dihapus');
		}
		redirect($this->url);
	}

	public function detailhapus($id = '', $idkirim = '') {
		if (!empty($id)) {
			$detail = $this->GlobalModel->getDataRow('kirimcmt_detail', array('id' => $id));
			if (!empty($detail)) {
				$this->db->update('kirimcmt_detail', array('hapus' => 1), array('id' => $id));
				$this->db->update('kelolapo_kirim_setor', array('hapus' => 1), array('kode_nota_cmt' => $detail['idkirim'], 'kode_po' => $detail['kode_po']));

				$total = $this->GlobalModel->queryManualRow("SELECT COALESCE(SUM(jumlah_pcs),0) as total FROM kirimcmt_detail WHERE idkirim='" . $detail['idkirim'] . "' AND hapus=0");
				$this->db->update('kirimcmt', array('totalkirim' => $total['total']), array('id' => $detail['idkirim']));
			}
			$this->session->set_flashdata('msg', 'Item detail berhasil dihapus');
		}
		redirect($this->url . 'edit/' . $idkirim);
	}

	public function cetak($id = '', $type = '1') {
		$data['kirim']  = $this->GlobalModel->getDataRow('kirimcmt', array('id' => $id));
		$kirims         = $this->GlobalModel->getData('kirimcmt_detail', array('idkirim' => $id, 'hapus' => 0));

		$data['kirims'] = array();
		foreach ($kirims as $k) {
			$job = $this->GlobalModel->getDataRow('master_job', array('id' => $k['cmtjob']));
			$po  = $this->GlobalModel->getDataRow('produksi_po', array('kode_po' => $k['kode_po']));
			if (empty($po)) {
				$po = $this->GlobalModel->getDataRow('produksi_po', array('id_produksi_po' => $k['kode_po']));
			}

			$data['kirims'][] = array(
				'kode_po'    => !empty($po) ? $po['kode_po'] . ' ' . (($po['serian'] != 0) ? $po['serian'] : '') : $k['kode_po'],
				'rincian_po' => $k['rincian_po'],
				'job'        => !empty($job) ? $job['nama_job'] : '-',
				'jumlah_pcs' => $k['jumlah_pcs'],
				'keterangan' => $k['keterangan'],
				'jml_barang' => $k['jml_barang'],
			);
		}

		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt', array('id_cmt' => $data['kirim']['idcmt']));

		if ($type == '2') {
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=Surat_Jalan_Distribusi_" . $data['kirim']['nosj'] . ".xls");
			$this->load->view($this->page . 'pdf', $data);
		} else {
			$html     = $this->load->view($this->page . 'pdf', $data, true);
			$filename = 'Surat_Jalan_Distribusi_' . time();
			
			if (file_exists(APPPATH . 'third_party/dompdf/autoload.inc.php')) {
				require_once APPPATH . 'third_party/dompdf/autoload.inc.php';
				$dompdf = new Dompdf\Dompdf();
				$dompdf->loadHtml($html);
				$dompdf->setPaper('A4', 'portrait');
				$dompdf->render();
				$dompdf->stream($filename . ".pdf", array("Attachment" => 0));
			} else {
				$this->load->view($this->page . 'pdf', $data);
			}
		}
	}
}
