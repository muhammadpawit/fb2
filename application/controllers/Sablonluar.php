<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sablonluar extends CI_Controller {

	public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $GlobalTwoModel;
	public $input;
	public $db;
	public $ReportModel;
	public $upload;
	public $viewData;
	public $pdfgenerator;
	public $pagination;
	public $uri;
	public $pdf;
	public $data;
	public $db2;
	public $KirimsetorModel;
	public $PembayaranModel;
	public $BiayaHppPerpoModel;

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/sablonluar/';
		$this->url=BASEURL.'Sablonluar/';
		$this->load->model('AdjustModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=array();
		$data['title']='Pembayaran CMT Sablon Luar';
		$data['tambah']=$this->url.'sablon_add';
		$data['products']=array();
		$user=user();
		$menghapus=0;
		if(isset($user['id_user'])){
			$menghapus=akses($user['id_user'],2);
		}
		$data['menghapus']=akseshapus();
		$get=$this->input->get();
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=87;
		}
		$sql="SELECT * FROM pembayaran_sablon WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		if(!empty($cmt)){
			$sql.=" AND idcmt='".$cmt."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=array();
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $result){
			$cmt=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$result['id'],
				'tanggal'=>formatTanggalIndo($result['tanggal']),
				'periode'=>strtolower($result['periode']),
				'nama'=>strtolower($cmt['cmt_name']),
				'total'=>number_format(isset($result['total_diterima']) ? $result['total_diterima'] : (isset($result['total']) ? $result['total'] : 0)),
				'potongan_bangke'=>number_format(isset($result['total_pendapatan']) ? $result['total_pendapatan'] : 0),
				'biaya_transport'=>number_format(isset($result['total_pengeluaran']) ? $result['total_pengeluaran'] : 0),
				'potongan_claim'=>number_format(isset($result['potongan_claim']) ? $result['potongan_claim'] : (isset($result['total_klaim']) ? $result['total_klaim'] : 0)),
				'keterangan'=>strtolower($result['keterangan']),
				'detail'=>BASEURL.'Sablonluar/sablon_detail/'.$result['id'],
				'hapus'=>BASEURL.'Sablonluar/sablon_hapus/'.$result['id'],
			);
		}
		$data['page']=$this->page.'/pembayaran_list';
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT','id_cmt'=>87));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view($this->layout,$data);
	}

	public function sablon_add(){
		$data=array();
		$data['title']='Pembayaran CMT Sablon Luar';
		$data['action']=$this->url.'sablon_save';
		$data['products']=array();
		$data['pekerjaan']=array();
		$user=user();
		$menghapus=0;
		if(isset($user['id_user'])){
			$menghapus=akses($user['id_user'],2);
		}
		$data['menghapus']=akseshapus();
		$get=$this->input->get();
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=87;
		}
		$pot=null;
		$pot=$this->GlobalModel->getDataRow('claim_sablon',array('hapus'=>0,'idcmt'=>$cmt,'tanggal'=>$tanggal2));
		$data['pot']= !empty($pot) ? $pot['harga'] : 0;
		$data['pot_ket']= !empty($pot) ? $pot['keterangan'] : '';
		//pre($data['pot']);
		$data['cm']=[];
		$data['cm']=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt,'hapus'=>0,'id_cmt'=>87));
		$data['pendapatan']=[];
		$sql="SELECT ksd.*,ks.idcmt, mpo.nama as kode_po FROM kirimcmtsablon_detail ksd JOIN kirimcmtsablon ks ON(ks.id=ksd.idkirim) JOIN master_po_luar mpo ON mpo.id=ksd.kode_po  WHERE ks.hapus=0 and ksd.hapus=0";
		$sql.=" ";
		$sql.=" AND DATE(ks.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" AND ks.idcmt='".$cmt."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($results);
		$no=1;
		foreach($results as $r){
			$job=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$r['cmtjob']));
			$data['pendapatan'][]=array(
				'no'=>$no++,
				'namapo'=>	$r['kode_po'],
				'dz'=>	($r['jumlah_pcs']/12),
				'pcs'=>	$r['jumlah_pcs'],
				'harga'=>($r['rincian_po']),
				'total'=>(round(($r['jumlah_pcs']/12)*$r['rincian_po'])),
				'pekerjaan'=>$r['cmtjob'],
				'ket'=>!empty($job)?$job['nama_job']:null,
			);
			
		}
		
		// pengeluaran
		$data['pengeluaran']=[];
		$sqlp="SELECT * FROM pengeluaran_sablon WHERE hapus=0 ";
		$sqlp.=" AND idcmt='".$cmt."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and hapus=0";
		$res=$this->GlobalModel->querymanual($sqlp);
		$p=1;
		foreach($res as $r){
			$data['pengeluaran'][]=array(
				'no'=>$p++,
				'belanjacat'=>($r['belanjacat']),
				'upahtukang_harian'=>($r['upahtukang_harian']),
				'upahtukang_borongan'=>($r['upahtukang_borongan']),
				'biayalain'=>($r['biayalain']),
				'tokenlistrik'=>($r['tokenlistrik']),
				'total'=>($r['total']),
			);
		}
		$sewa=0;
		$sqlsewa="SELECT keluar FROM sablon_sewarumah_detail swd JOIN sablon_sewarumah sw ON(sw.id=swd.idsewa) WHERE DATE(swd.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and swd.hapus=0";
		$ds=$this->GlobalModel->QueryManualRow($sqlsewa);
		if(!empty($ds)){
			$sewa=$ds['keluar'];
		}
		$data['sewa']=$sewa;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'SABLON','id_cmt'=>87));
		$data['kodepo']=$this->GlobalModel->getData('master_po_luar',array('hapus'=>0));
		$data['pinjaman']=$this->GlobalModel->QueryManual("SELECT * FROM pinjaman_cmt WHERE idcmt='".$data['cmtf']."' AND hapus=0 AND status IN (1,2) ");
		//$this->load->view($this->page.'main',$data);
		if(isset($get['excel'])){
			$this->load->view('newtheme/page/pembayaran/sablon_excel_luar',$data);
		}else{
			$data['page']=$this->page.'sablon_add';
			$this->load->view($this->layout,$data);
		}
	}

	public function sablon_save(){
		$post=$this->input->post();
		if(!empty($post)){
			// Cek duplikasi
			$cek = $this->GlobalModel->getdataRow('pembayaran_sablon', array(
				'idcmt' => $post['idcmt'],
				'tanggal1' => $post['tanggal1'],
				'tanggal2' => $post['tanggal2'],
				'hapus' => 0
			));

			if($cek){
				$this->session->set_flashdata('msg', 'Gagal! Pembayaran untuk CMT dan periode tersebut sudah pernah disimpan.');
				redirect(BASEURL.'Sablonluar');
			}

			$potongan_pinjaman_arr = isset($post['potongan_pinjaman']) ? $post['potongan_pinjaman'] : array();
			$potongan_pinjaman = 0;
			if(is_array($potongan_pinjaman_arr)){
				foreach($potongan_pinjaman_arr as $val){
					$potongan_pinjaman += (int)$val;
				}
			} else {
				$potongan_pinjaman = (int)$potongan_pinjaman_arr;
			}
			$total_diterima = $post['total_diterima'] - $potongan_pinjaman;

			$insert = array(
				'tanggal1' => $post['tanggal1'],
				'tanggal2' => $post['tanggal2'],
				'tanggal' => $post['tanggal1'],
				'tanggal_bayar' => $post['tanggal1'],
				'periode' => $post['tanggal1'] . ' s/d ' . $post['tanggal2'],
				'idcmt' => $post['idcmt'],
				'total_pendapatan' => isset($post['total_pendapatan']) ? $post['total_pendapatan'] : 0,
				'total_pengeluaran' => isset($post['total_pengeluaran']) ? $post['total_pengeluaran'] : 0,
				'total_sewa' => isset($post['sewa']) ? $post['sewa'] : 0,
				'total_klaim' => isset($post['potongan_claim']) ? $post['potongan_claim'] : (isset($post['total_klaim']) ? $post['total_klaim'] : 0),
				'potongan_claim' => isset($post['potongan_claim']) ? $post['potongan_claim'] : (isset($post['total_klaim']) ? $post['total_klaim'] : 0),
				'total_komisi' => isset($post['total_komisi']) ? $post['total_komisi'] : 0,
				'total_upah_tukang' => isset($post['total_upah_tukang']) ? $post['total_upah_tukang'] : 0,
				'potongan_pinjaman' => $potongan_pinjaman,
				'total' => $post['total_diterima'],
				'total_diterima' => $total_diterima,
				'keterangan' => 'Pembayaran Sablon Luar periode ' . $post['tanggal1'] . ' s/d ' . $post['tanggal2'],
				'hapus' => 0,
				'create_date' => date('Y-m-d H:i:s')
			);
			$this->db->insert('pembayaran_sablon', $insert);
			$idpembayaran = $this->db->insert_id();

			if(is_array($potongan_pinjaman_arr) && !empty($potongan_pinjaman_arr)){
				foreach($potongan_pinjaman_arr as $id_pinjaman => $nominal_potong){
					if($nominal_potong > 0){
						$cek = $this->GlobalModel->getDataRow('pinjaman_cmt', array('id' => $id_pinjaman));
						if(!empty($cek)){
							$insert_pot_pinjaman=array(
								'idcmt'=>$post['idcmt'],
								'idpinjaman'=>$cek['id'],
								'tanggal'=>$post['tanggal1'],
								'totalpotongan'=>$nominal_potong,
								'sisa'=>($cek['totalpinjaman']-$cek['totalpotongan']-$nominal_potong),
								'keterangan'=>'Potongan Pinjaman tanggal '.$post['tanggal1']. ' s/d '.$post['tanggal2'],
								'hapus'=>0,
								'idpembayaran'=>$idpembayaran,
							);
							$this->db->insert('potongan_pinjaman_cmt',$insert_pot_pinjaman);

							$cek2=$this->GlobalModel->QueryManualRow("SELECT SUM(totalpotongan) as totalpotongan FROM potongan_pinjaman_cmt WHERE idcmt='".$post['idcmt']."' AND hapus=0 AND idpinjaman='".$cek['id']."' ");

							if(!empty($cek2)){
								if($cek2['totalpotongan']==$cek['totalpinjaman']){
									$this->db->update('pinjaman_cmt',array('status'=>3,'totalpotongan'=>$cek2['totalpotongan']),array('id'=>$cek['id']));
								}else{
									$this->db->update('pinjaman_cmt',array('status'=>2,'totalpotongan'=>$cek2['totalpotongan']),array('id'=>$cek['id']));
								}
							}
						}
					}
				}
			}

			if(isset($post['pendapatan'])){
				foreach($post['pendapatan'] as $p){
					$det_po = array(
						'idpembayaran' => $idpembayaran,
						'id_kelolapo_kirim_setor' => isset($p['id_kelolapo_kirim_setor']) ? $p['id_kelolapo_kirim_setor'] : 0,
						'kode_po' => $p['namapo'],
						'dz' => $p['dz'],
						'pcs' => $p['pcs'],
						'harga' => $p['harga'],
						'total' => $p['total'],
						'pekerjaan' => $p['pekerjaan']
					);
					$this->db->insert('pembayaran_sablon_detail_po', $det_po);
				}
			}

			if(isset($post['pengeluaran'])){
				foreach($post['pengeluaran'] as $p){
					$det_p = array(
						'idpembayaran' => $idpembayaran,
						'id_pengeluaran_sablon' => isset($p['id']) ? $p['id'] : 0,
						'total' => $p['total']
					);
					$this->db->insert('pembayaran_sablon_detail_pengeluaran', $det_p);
				}
			}

			if(isset($post['klaim'])){
				foreach($post['klaim'] as $k){
					$det_klaim = array(
						'idpembayaran' => $idpembayaran,
						'idclaim_sablon' => $k['idclaim_sablon'],
						'nominal_potong' => $k['nominal_potong']
					);
					$this->db->insert('pembayaran_sablon_detail_klaim', $det_klaim);

					// Tambahkan detail potongan klaim agar saldo klaim berkurang
					$insert_det_klaim = array(
						'tanggal' => date('Y-m-d'),
						'idclaim' => $k['idclaim_sablon'],
						'nominal' => $k['nominal_potong'],
						'hapus' => 0
					);
					$this->db->insert('claim_potongan_sablon_detail', $insert_det_klaim);
				}
			}

			$this->session->set_flashdata('msg', 'Data pembayaran berhasil disimpan');
			redirect(BASEURL.'Sablonluar');
		}
	}

	public function sablon_detail($id){
		$data=array();
		$data['title']='Detail Pembayaran Sablon Luar';
		$data['detail']=$this->GlobalModel->getdataRow('pembayaran_sablon',array('id'=>$id));
		$data['cm']=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$data['detail']['idcmt']));
		$data['pendapatan']=$this->GlobalModel->getdata('pembayaran_sablon_detail_po',array('idpembayaran'=>$id));
		$data['pengeluaran']=$this->GlobalModel->getdata('pembayaran_sablon_detail_pengeluaran',array('idpembayaran'=>$id));
		$data['claim']=$this->GlobalModel->getdata('pembayaran_sablon_detail_klaim',array('idpembayaran'=>$id));
		
		// Map for the existing view templates
		$data['tanggal1'] = $data['detail']['tanggal1'];
		$data['tanggal2'] = $data['detail']['tanggal2'];
		$data['totalclaim'] = $data['detail']['total_klaim'];
		$data['total_tukang_borongan'] = $data['detail']['total_upah_tukang'];
		$data['tjml'] = $data['detail']['total_komisi'];
		
		// Extra info for display
		$data['total_pendapatan'] = $data['detail']['total_pendapatan'];
		$data['total_pengeluaran'] = $data['detail']['total_pengeluaran'];
		$data['sewa'] = $data['detail']['total_sewa'];
		
		// Extra info from pendapatan
		foreach($data['pendapatan'] as &$p){
			$p['namapo'] = $p['kode_po'];
		}

		// Extra info from pengeluaran table
		foreach($data['pengeluaran'] as &$p){
			$ref = $this->GlobalModel->getdataRow('pengeluaran_sablon', array('id'=>$p['id_pengeluaran_sablon']));
			if($ref){
				$p['no'] = 1; // dummy for template
				$p['belanjacat'] = $ref['belanjacat'];
				$p['upahtukang_harian'] = $ref['upahtukang_harian'];
				$p['upahtukang_borongan'] = $ref['upahtukang_borongan'];
				$p['biayalain'] = $ref['biayalain'];
				$p['tokenlistrik'] = $ref['tokenlistrik'];
			} else {
				$p['no'] = 1;
				$p['belanjacat'] = 0;
				$p['upahtukang_harian'] = 0;
				$p['upahtukang_borongan'] = 0;
				$p['biayalain'] = 0;
				$p['tokenlistrik'] = 0;
			}
		}

		// Extra info from claim table
		foreach($data['claim'] as &$c){
			$ref = $this->GlobalModel->getdataRow('claim_sablon', array('id'=>$c['idclaim_sablon']));
			if($ref){
				$c['tanggal'] = $ref['tanggal']; // raw date for view to format
				$c['type'] = $ref['type'];
				$c['keterangan'] = $ref['keterangan'];
				$c['nominal'] = $ref['harga'];
				$c['sisa'] = $c['nominal_potong']; // In detail, we show what was deducted
			} else {
				$c['tanggal'] = '';
				$c['type'] = '';
				$c['keterangan'] = '';
				$c['nominal'] = 0;
				$c['sisa'] = $c['nominal_potong'];
			}
		}

		$data['kembali'] = BASEURL.'Sablonluar';

		$get = $this->input->get();
		if(isset($get['pdf'])){
			$this->load->library('pdfgenerator');
			$html = $this->load->view('newtheme/page/pembayaran/sablon_pdf', $data, true);
			$this->pdfgenerator->generate($html, "Laporan_Pembayaran_Sablon_Luar_".$id, 'A4', 'portrait');
		} else if(isset($get['excel'])){
			$this->load->view('newtheme/page/pembayaran/sablon_excel', $data);
		} else {
			$data['page']='newtheme/page/pembayaran/sablon_detail';
			$this->load->view($this->layout,$data);
		}
	}

	public function sablon_hapus($id){
		// 1. Kembalikan saldo & status potongan pinjaman CMT
		$potongans = $this->GlobalModel->getData('potongan_pinjaman_cmt', array('idpembayaran' => $id, 'hapus' => 0));
		if(!empty($potongans)){
			foreach($potongans as $potonganPinjaman){
				// Hapus history potongan pinjaman ini
				$this->db->update('potongan_pinjaman_cmt', array('hapus' => 1), array('id' => $potonganPinjaman['id']));
				
				// Hitung ulang total potongan tersisa untuk pinjaman ini
				$cek2 = $this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(totalpotongan),0) as totalpotongan FROM potongan_pinjaman_cmt WHERE idpinjaman='".$potonganPinjaman['idpinjaman']."' AND hapus=0");
				$tot_pot = !empty($cek2) ? $cek2['totalpotongan'] : 0;
				
				// Ambil data pinjaman utama untuk atur status yang tepat
				$pj_main = $this->GlobalModel->getDataRow('pinjaman_cmt', array('id' => $potonganPinjaman['idpinjaman']));
				$status = 1;
				if(!empty($pj_main)){
					if($tot_pot >= $pj_main['totalpinjaman']){
						$status = 3; // Lunas
					} else if($tot_pot > 0){
						$status = 2; // Sedang dipotong
					} else {
						$status = 1; // Belum dipotong
					}
				}
				$this->db->update('pinjaman_cmt', array('status' => $status, 'totalpotongan' => $tot_pot), array('id' => $potonganPinjaman['idpinjaman']));
			}
		}

		// 2. Kembalikan saldo potongan klaim CMT
		$claims = $this->GlobalModel->getData('pembayaran_sablon_detail_klaim', array('idpembayaran' => $id));
		if(!empty($claims)){
			foreach($claims as $c){
				// Kembalikan sisa klaim dengan menghapus detail potongan klaim (set hapus = 1)
				$this->db->update('claim_potongan_sablon_detail', array('hapus' => 1), array('idclaim' => $c['idclaim_sablon'], 'nominal' => $c['nominal_potong'], 'hapus' => 0));
			}
		}

		// 3. Soft-delete header pembayaran sablon
		$this->db->update('pembayaran_sablon', array('hapus' => 1), array('id' => $id));
		$this->session->set_flashdata('msg', 'Data berhasil dihapus');
		redirect(BASEURL.'Sablonluar');
	}

	public function kirimsetor(){
		$data=array();
		$data['title']='Surat Jalan Pengiriman Sablon PO Luar';
		$data['products']=array();
		$data['url']=$this->url.'kirimsetor';
		$data['i']=1;
		$data['tambah']=$this->url.'kirimcmtsablonadd';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of last month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=87;
		}
		if(isset($get['sj'])){
			$sj=$get['sj'];
		}else{
			$sj=null;
		}
		$data['sablonluar']=true;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmt']=$cmt;
		$data['sj']=$sj;
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="SABLON" AND id_cmt IN(87) ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmtsablon WHERE hapus=0 AND idcmt=87');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT * FROM kirimcmtsablon WHERE hapus=0";

		if(!empty($cmt)){
			$sql.=" AND idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}

		$sql.=' ORDER BY id DESC ';
		$sql.=" LIMIT 20 ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => $this->url.'kirimcmtsablonview/'.$result['id'],
				'bg'   => '',
			);

			if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => $this->url.'kirimcmtsablonedit/'.$result['id'],
					'bg'   => '#f39c12',
				);
			}

			if(akseshapus()==1){
				$action[] = array(
					'text' => 'Hapus',
					'href' => $this->url.'kirimcmtsablonhapus/'.$result['id'],
					'bg'   => '#dd4b39',
				);
			}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$dets = $this->GlobalModel->GetData('kirimcmtsablon_detail',array('hapus'=>0,'idkirim'=>$result['id']));
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>formatTanggalIndo($result['tanggal']),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalkirim'],
				'namacmt'=>!empty($namacmt)?$namacmt['cmt_name']:null,
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'keterangan'=>$result['keterangan'],
				'dets' => $dets,
				'action'=>$action,
			);
		}
		// pre($data['products']);
		$data['page']='produksi/kirimcmt_list';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kirimcmtsablonadd(){
		$data=array();
		$data['title']='Pengiriman Jahit ke Sablon PO Luar';
		$data['url']=$this->url.'kirimsetor';
		$data['cancel']=$this->url.'kirimsetor';
		$data['action']=$this->url.'kirimcmtsablonsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1,3) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM master_po_luar WHERE hapus=0 ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>2));
		$data['page']=$this->page.'kirimcmtsablonluar_form';
		//$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['kodepo'] = $this->GlobalModel->queryManual('SELECT * FROM master_po_luar WHERE hapus=0 ');
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="SABLON" AND id_cmt IN(87) ORDER BY cmt_name ASC ');
		$this->load->view('newtheme/page/main',$data);
		
	}

	public function kirimcmtsablonsave(){
		$post=$this->input->post();
		$cmt=explode('-', $post['cmtName']);
		//pre($cmt[0]);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		if(isset($post['tanggal'])){
			$insert=array(
				'tanggal'=>$post['tanggal'],
				'kode_po'=>'-',
				'totalkirim'=>0,
				'cmtkat'=>$post['cmtKat'],
				'idcmt'=>$cmt[0],
				'cmtkat'=>$post['cmtKat'],
				'cmtjob'=>'-',
				'status'=>0,
				'keterangan'=>$post['keterangan'],
				'dibuat'=>date('Y-m-d H:i:s'),
				'hapus'=>0,
			);
			$this->db->insert('kirimcmtsablon', $insert);
   			$id = $this->db->insert_id();
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt[0]));
   			foreach($post['products'] as $p){
   				$jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$p['cmtjob']));
   				$totalkirim+=($p['jumlah_pcs']);
   				$detail=array(
   					'idkirim'=>$id,
   					'kode_po'=>$p['kode_po'],
   					'cmtjob'=>$p['cmtjob'],
   					'rincian_po'=>$p['rincian_po'],
   					'jumlah_pcs'=>$p['jumlah_pcs'],
   					'keterangan'=>$p['keterangan'],
   					'jml_barang'=>$p['jml_barang'],
   					'hapus'=>0,
   				);
   				$this->db->insert('kirimcmtsablon_detail',$detail);	   			
   			}
	   		$nosj='SJFB'.'-'.date('Y-m').'-'.$id;
	   		$this->db->update('kirimcmtsablon',array('totalkirim'=>$totalkirim,'nosj'=>$nosj),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url.'kirimsetor');
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	function kirimcmtsablonhapus($id=''){
		$this->db->update('kirimcmtsablon',array('hapus'=>1),array('id'=>$id));
		$this->db->update('kirimcmtsablon_detail',array('hapus'=>1),array('idkirim'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect($this->url.'kirimsetor');
	}

	public function kirimcmtsablonview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['kembali']=$this->url.'kirimsetor';
		$data['cetak']=$this->url.'kirimcmtsabloncetak/'.$id.'/1';
		$data['excel']=$this->url.'kirimcmtsabloncetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmtsablon_detail',array('idkirim'=>$id));
		$job=null;
		foreach($kirims as $k){
			$po = $this->GlobalModel->QueryManualRow("SELECT nama as kode_po FROM master_po_luar WHERE id='".$k['kode_po']."' ");
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$data['kirims'][]=array(
				'kode_po'=>$po['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['nama_job'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['page']='produksi/kirimcmt_view';
		$this->load->view('newtheme/page/main',$data);
	}

}