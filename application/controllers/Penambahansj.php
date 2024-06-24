<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penambahansj extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/kelolapo/';
		$this->url=BASEURL.'Penambahansj/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}


	public function index(){
		$data=[];
		$data['title']='Penambahan Surat Jalan';
		$data['products']=array();
		$data['url']=BASEURL.'Kelolapo/pengirimancmt';
		$data['i']=1;
		$data['tambah']=$this->url.'add';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=null;
		}
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
		if(isset($get['sj'])){
			$sj=$get['sj'];
		}else{
			$sj=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmt']=$cmt;
		$data['sj']=$sj;
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="JAHIT" ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmt WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT k.*,kd.kode_po,kd.jumlah_pcs FROM kirimcmt k JOIN kirimcmt_detail kd ON(kd.idkirim=k.id) WHERE kd.hapus=0 ";

		if(!empty($cmt)){
			$sql.=" AND k.idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND k.id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			if(!empty($tanggal1)){
				$sql.=" AND date(k.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}

		$sql.=' ORDER BY k.id DESC ';
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		foreach($results as $result){
			$action=array();

			$action[] = array(
				'text' => 'Hapus',
				'href' => $this->url.'hapus/'.$result['id'],
			);

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['jumlah_pcs'],
				'namacmt'=>$namacmt['cmt_name'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
			);
		}
		$data['page']=$this->page.'penambahansj';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=array();
		$data['title']='Tambah Penambahan Surat Jalan';
		$data['url']=$this->url;
		$data['cancel']=$this->url;
		$data['action']=$this->url.'save';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE kbp.kode_po NOT IN(SELECT kode_po from finishing_kirim_gudang)');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['page']=$this->page.'penambahansj_form';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view('newtheme/page/main',$data);
	}


	public function save(){
		$post=$this->input->post();
		//pre($post);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		$masterpo=[];
		$id=$post['sj'];
		if(isset($post['sj'])){
			$cmt=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt['idcmt']));
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
   				$this->db->insert('kirimcmt_detail',$detail);
   				$masterpo=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$p['kode_po']));
   				$insertkks=array(
   					'kode_po'=>$p['kode_po'],
   					'create_date'=>$cmt['tanggal'],
   					'kode_nota_cmt'=>$id,
   					'progress'=>'KIRIM',
   					'kategori_cmt'=>'JAHIT',
   					'id_master_cmt'=>$cmt['idcmt'],
   					//'id_master_cmt_job'=>$job[0],
   					'id_master_cmt_job'=>$p['cmtjob'],
   					'cmt_job_price'=>$jobprice['harga'],
   					'nama_cmt'=>$namacmt['cmt_name'],
   					'qty_tot_pcs'=>$p['jumlah_pcs'],
   					'qty_tot_atas'=>0,
   					'qty_tot_bawah'=>0,
   					'keterangan'=>'-',
   					'status'=>0,
   					'jml_barang'=>$p['jml_barang'],
   					'qty_bangke'=>0,
   					'qty_reject'=>0,
   					'qty_hilang'=>0,
   					'qty_claim'=>0,
   					'status_keu'=>0,
   					'tglinput'=>date('Y-m-d'),
   					'idpo'=>!empty($masterpo)?$masterpo['id_produksi_po']:0,
   				);
   				//pre($totalkirim);
   				$this->db->insert('kelolapo_kirim_setor',$insertkks);
   				// $iks = $this->db->insert_id();
   				// $atas = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$p['kode_po']));
   				// if(!empty($atas)){
	   			// 	foreach($atas as $a){
	   			// 		$ia=array(
	   			// 			'id_kelolapo_kirim_setor'=>$iks,
	   			// 			'kode_po'=>$a['kode_po'],
	   			// 			'bagian_potongan_atas'=>$a['bagian_potongan_atas'],
	   			// 			'warna_potongan_atas'=>$a['warna_potongan_atas'],
	   			// 			'jumlah_potongan'=>$a['jumlah_potongan'],
	   			// 			'keterangan_potongan'=>$a['keterangan_potongan'],
	   			// 			'created_date'=>$post['tanggal'],
	   			// 			'qty_bangke_atas'=>0,
	   			// 			'qty_reject_atas'=>0,
	   			// 			'qty_hilang_atas'=>0,
	   			// 			'qty_claim_atas'=>0,
	   			// 		);
	   			// 		$this->db->insert('kelolapo_kirim_setor_atas',$ia);
	   			// 	}
	   			// }
	   			// $bawah = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$p['kode_po']));
	   			// if(!empty($bawah)){
	   			// 	foreach($bawah as $b){
	   			// 		$ib=array(
	   			// 			'id_kelolapo_kirim_setor'=>$iks,
	   			// 			'kode_po'=>$b['kode_po'],
	   			// 			'bagian_potongan_atas'=>$b['bagian_potongan_bawah'],
	   			// 			'warna_potongan_atas'=>$b['warna_potongan_bawah'],
	   			// 			'jumlah_potongan'=>$b['jumlah_potongan'],
	   			// 			'keterangan_potongan'=>$a['keterangan_potongan'],
	   			// 			'created_date'=>$post['tanggal'],
	   			// 			'qty_bangke_atas'=>0,
	   			// 			'qty_reject_atas'=>0,
	   			// 			'qty_hilang_atas'=>0,
	   			// 			'qty_claim_atas'=>0,
	   			// 		);
	   			// 		$this->db->insert('kelolapo_kirim_setor_bawah',$ib);
	   			// 	}
	   			// }
   			}
	   		//$this->db->update('kirimcmt',array('totalkirim'=>$totalkirim),array('id'=>$id));
	   		$this->db->query("UPDATE kirimcmt SET totalkirim=totalkirim+'".$totalkirim."' WHERE id='".$id."' ");
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function sablon(){
		$data=[];
		$data['title']='Penambahan Surat Jalan Sablon';
		$data['products']=array();
		$data['url']=BASEURL.'Penambahansj/sablon';
		$data['i']=1;
		$data['tambah']=$this->url.'sablon_add';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=null;
		}
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
		if(isset($get['sj'])){
			$sj=$get['sj'];
		}else{
			$sj=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmt']=$cmt;
		$data['sj']=$sj;
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="SABLON" ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmt WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT k.*,kd.kode_po,kd.jumlah_pcs FROM kirimcmtsablon k JOIN kirimcmtsablon_detail kd ON(kd.idkirim=k.id) WHERE kd.hapus=0 ";

		if(!empty($cmt)){
			$sql.=" AND k.idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND k.id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			if(!empty($tanggal1)){
				$sql.=" AND date(k.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}

		$sql.=' ORDER BY k.id DESC ';
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		foreach($results as $result){
			$action=array();

			$action[] = array(
				'text' => 'Hapus',
				'href' => $this->url.'hapus_sablon/'.$result['kode_po'].'/'.$result['id'],
			);

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['jumlah_pcs'],
				'namacmt'=>$namacmt['cmt_name'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
			);
		}
		$data['page']=$this->page.'penambahansj';
		$this->load->view($this->layout,$data);
	}

	public function sablon_add(){
		$data=array();
		$data['title']='Tambah Penambahan Surat Jalan';
		$data['url']=$this->url;
		$data['cancel']=$this->url.'sablon';
		$data['action']=$this->url.'sablon_save';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE kbp.kode_po NOT IN(SELECT kode_po from finishing_kirim_gudang)');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>2));
		$data['page']=$this->page.'penambahansjsablon_form';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view('newtheme/page/main',$data);
	}


	public function sablon_save(){
		$post=$this->input->post();
		//pre($post);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		$masterpo=[];
		$id=$post['sj'];
		if(isset($post['sj'])){
			$cmt=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$id));
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt['idcmt']));
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
   				$masterpo=$this->GlobalModel->GetDataRow('produksi_po',array('kode_po'=>$p['kode_po']));
   				$insertkks=array(
   					'kode_po'=>$p['kode_po'],
   					'create_date'=>$cmt['tanggal'],
   					'kode_nota_cmt'=>$id,
   					'progress'=>'KIRIM',
   					'kategori_cmt'=>'SABLON',
   					'id_master_cmt'=>$cmt['idcmt'],
   					//'id_master_cmt_job'=>$job[0],
   					'id_master_cmt_job'=>$p['cmtjob'],
   					'cmt_job_price'=>$jobprice['harga'],
   					'nama_cmt'=>$namacmt['cmt_name'],
   					'qty_tot_pcs'=>$p['jumlah_pcs'],
   					'qty_tot_atas'=>0,
   					'qty_tot_bawah'=>0,
   					'keterangan'=>'-',
   					'status'=>0,
   					'jml_barang'=>$p['jml_barang'],
   					'qty_bangke'=>0,
   					'qty_reject'=>0,
   					'qty_hilang'=>0,
   					'qty_claim'=>0,
   					'status_keu'=>0,
   					'tglinput'=>date('Y-m-d'),
   					'idpo'=>!empty($masterpo)?$masterpo['id_produksi_po']:0,
   				);
   				//pre($totalkirim);
   				$this->db->insert('kelolapo_kirim_setor',$insertkks);
   				$iks = $this->db->insert_id();
   				$atas = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$p['kode_po']));
   				if(!empty($atas)){
	   				foreach($atas as $a){
	   					$ia=array(
	   						'id_kelolapo_kirim_setor'=>$iks,
	   						'kode_po'=>$a['kode_po'],
	   						'bagian_potongan_atas'=>$a['bagian_potongan_atas'],
	   						'warna_potongan_atas'=>$a['warna_potongan_atas'],
	   						'jumlah_potongan'=>$a['jumlah_potongan'],
	   						'keterangan_potongan'=>$a['keterangan_potongan'],
	   						'created_date'=>$post['tanggal'],
	   						'qty_bangke_atas'=>0,
	   						'qty_reject_atas'=>0,
	   						'qty_hilang_atas'=>0,
	   						'qty_claim_atas'=>0,
	   					);
	   					$this->db->insert('kelolapo_kirim_setor_atas',$ia);
	   				}
	   			}
	   			$bawah = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$p['kode_po']));
	   			if(!empty($bawah)){
	   				foreach($bawah as $b){
	   					$ib=array(
	   						'id_kelolapo_kirim_setor'=>$iks,
	   						'kode_po'=>$b['kode_po'],
	   						'bagian_potongan_atas'=>$b['bagian_potongan_bawah'],
	   						'warna_potongan_atas'=>$b['warna_potongan_bawah'],
	   						'jumlah_potongan'=>$b['jumlah_potongan'],
	   						'keterangan_potongan'=>$a['keterangan_potongan'],
	   						'created_date'=>$post['tanggal'],
	   						'qty_bangke_atas'=>0,
	   						'qty_reject_atas'=>0,
	   						'qty_hilang_atas'=>0,
	   						'qty_claim_atas'=>0,
	   					);
	   					$this->db->insert('kelolapo_kirim_setor_bawah',$ib);
	   				}
	   			}
   			}
	   		//$this->db->update('kirimcmt',array('totalkirim'=>$totalkirim),array('id'=>$id));
	   		$this->db->query("UPDATE kirimcmt SET totalkirim=totalkirim+'".$totalkirim."' WHERE id='".$id."' ");
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url.'sablon');
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	function hapus_sablon($kodepo, $nota){
		$update = array(
			'hapus' => 1
		);
		$where = array(
			'idkirim' => $nota,
			'kode_po' => $kodepo
		);
		$this->db->upadte('kirimcmtdetail_sablon',$update,$where);
		$this->db->update('kelolapo_kirim_setor',array('hapus'=>1),array('kode_nota_cmt'=>$nota,'kode_po'=>$kodepo,'kategori_cmt'=>'SABLON'));
		$this->session->set_flashdata('msg','Data berhasil dihapu');
		redirect($this->url.'sablon');
	}
}
