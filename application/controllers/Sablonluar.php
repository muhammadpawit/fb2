<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sablonluar extends CI_Controller {

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
			$cmt=72;
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
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'periode'=>strtolower($result['periode']),
				'nama'=>strtolower($cmt['cmt_name']),
				'total'=>number_format($result['total']),
				'potongan_bangke'=>number_format($result['potongan_bangke']),
				'biaya_transport'=>number_format($result['biaya_transport']),
				'keterangan'=>strtolower($result['keterangan']),
				'detail'=>BASEURL.'Pembayaran/cmtjahitdetail/'.$result['id'],
				'hapus'=>BASEURL.'Pembayaran/cmtjahithapus/'.$result['id'],
			);
		}
		$data['page']=$this->page.'/pembayaran_list';
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT','id_cmt'=>72));
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
			$cmt=72;
		}
		$data['cm']=[];
		$data['cm']=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt,'hapus'=>0,'id_cmt'=>72));
		$data['pendapatan']=[];
		$sql="SELECT ksd.*,ks.idcmt FROM kirimcmtsablon_detail ksd JOIN kirimcmtsablon ks ON(ks.id=ksd.idkirim) WHERE ks.hapus=0";
		//$sql.=" AND DATE(ks.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
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
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'SABLON','id_cmt'=>72));
		$data['kodepo']=$this->GlobalModel->getData('master_po_luar',array('hapus'=>0));
		//$this->load->view($this->page.'main',$data);
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/sablon_excel',$data);
		}else{
			$data['page']=$this->page.'sablon_add';
			$this->load->view($this->layout,$data);
		}
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
			$cmt=72;
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
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="SABLON" AND id_cmt IN(72) ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmtsablon WHERE hapus=0 AND idcmt=72');
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
			);

			if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => $this->url.'kirimcmtsablonedit/'.$result['id'],
				);
			}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalkirim'],
				'namacmt'=>!empty($namacmt)?$namacmt['cmt_name']:null,
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'keterangan'=>$result['keterangan'],
				'action'=>$action,
			);
		}
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
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="SABLON" AND id_cmt IN(72) ORDER BY cmt_name ASC ');
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
			redirect($this->url.'pengirimansablon');
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function kirimcmtsablonview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['kembali']=$this->url.'pengirimansablon';
		$data['cetak']=$this->url.'kirimcmtsabloncetak/'.$id.'/1';
		$data['excel']=$this->url.'kirimcmtsabloncetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmtsablon_detail',array('idkirim'=>$id));
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
		$data['page']='produksi/kirimcmt_view';
		$this->load->view('newtheme/page/main',$data);
	}

}