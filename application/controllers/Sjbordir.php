<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sjbordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=array();
		$data['title']='Surat Jalan Pengiriman Bordir';
		$data['products']=array();
		$data['url']=BASEURL.'Sjbordir';
		$data['i']=1;
		$data['tambah']=BASEURL.'Sjbordir/add';
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
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="BORDIR" ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmtbordir WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT * FROM kirimcmtbordir WHERE hapus=0";

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
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL.'Sjbordir/view/'.$result['id'],
			);

			if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => BASEURL.'Sjbordir/edit/'.$result['id'],
				);
			}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalkirim'],
				'namacmt'=>$namacmt['cmt_name'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
			);
		}
		$data['page']='produksi/kirimcmt_list';
		$this->load->view('newtheme/page/main',$data);
	}

	public function add(){
		$data=array();
		$data['title']='Pengiriman Bordir';
		$data['url']=BASEURL.'Sjbordir';
		$data['cancel']=BASEURL.'Sjbordir';
		$data['action']=BASEURL.'Sjbordir/save';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>2));
		$data['page']='produksi/kirimcmtbordir_form';
		//$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		//$data['kodepo'] = $this->GlobalModel->queryManual('SELECT p.kode_po,p.nama_po FROM produksi_po p JOIN kelolapo_pengecekan_potongan kpp ON (kpp.kode_po=p.kode_po) WHERE p.kode_po NOT IN(SELECT kode_po FROM finishing_kirim_gudang) ORDER BY kode_po ASC ');
		$data['kodepo']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po ');
		$this->load->view('newtheme/page/main',$data);
		
	}

	public function save(){
		$post=$this->input->post();
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		if(isset($post['tanggal'])){
			$cmt=explode('-', $post['cmtName']);
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
			$this->db->insert('kirimcmtbordir', $insert);
   			$id = $this->db->insert_id();
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt[0]));
   			foreach($post['products'] as $p){
   				// $jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$p['cmtjob']));
   				$totalkirim+=($p['jumlah_pcs']);
   				$detail=array(
   					'idkirim'=>$id,
   					'kode_po'=>$p['kode_po'],
   					'cmtjob'=>0,
   					'rincian_po'=>$p['rincian_po'],
   					'jumlah_pcs'=>$p['jumlah_pcs'],
   					'keterangan'=>$p['keterangan'],
   					'jml_barang'=>$p['jml_barang'],
   					'hapus'=>0,
   				);
   				$this->db->insert('kirimcmtbordir_detail',$detail);

   				$insertkks=array(
   					'kode_po'=>$p['kode_po'],
   					'create_date'=>$post['tanggal'],
   					'kode_nota_cmt'=>$id,
   					'progress'=>'KIRIM',
   					'kategori_cmt'=>'BORDIR',
   					'id_master_cmt'=>$cmt[0],
   					'id_master_cmt_job'=>0,
   					'cmt_job_price'=>null,
   					'nama_cmt'=>'DALAM',
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
   				);
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
	   		$nosj='SJFB'.'-'.date('Y-m').'-'.$id;
	   		$this->db->update('kirimcmtbordir',array('totalkirim'=>$totalkirim,'nosj'=>$nosj),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Sjbordir');
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function view($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['bordir']=true;
		$data['kembali']=BASEURL.'Sjbordir';
		$data['cetak']=BASEURL.'Sjbordir/cetak/'.$id.'/1';
		$data['excel']=BASEURL.'Sjbordir/cetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtbordir',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmtbordir_detail',array('idkirim'=>$id));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$data['kirims'][]=array(
				'kode_po'=>$k['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['nama_job'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['page']='produksi/kirimcmtbordir_view';
		$this->load->view('newtheme/page/main',$data);
	}

	public function cetak($id='',$type=''){
		$rincian=array();
		$data=array();
		$data['no']=1;
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtbordir',array('id'=>$id));
		$data['kirims']=$this->GlobalModel->getData('kirimcmtbordir_detail',array('idkirim'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		if($type==1){
			$this->load->view('produksi/kirimcmtbordir_cetak',$data);
		}else{
			$this->load->view('produksi/kirimcmtbordir_excel',$data);
		}
		
	}

}