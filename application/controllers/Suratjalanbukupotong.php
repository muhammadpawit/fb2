<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratjalanbukupotong extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/suratjalanbukupotong/';
		$this->login 		= BASEURL.'login';
		$this->url 			= BASEURL.'Suratjalanbukupotong/';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	function index(){
		$data    = [];
		$data['title'] = 'Surat Jalan Buku Potongan ';
		$data['products']=array();
		$data['url']=$this->url;
		$data['i']=1;
		$data['tambah']=$this->url.'kirimcmtadd';
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
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimbupot WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT * FROM kirimbupot WHERE hapus=0";

		if(!empty($cmt)){
			$sql.=" AND idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}

		$sql.=' ORDER BY id DESC ';
		$sql.=" LIMIT 20 ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		$dets=[];
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => $this->url.'kirimcmtview/'.$result['id'],
			);

			//if(aksesedit()==1){
				// $action[] = array(
				// 	'text' => 'Hapus',
				// 	'href' => $this->url.'hapus/'.$result['id'],
				// );
			//}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$dets = $this->GlobalModel->GetData('kirimbupot_detail',array('hapus'=>0,'idkirim'=>$result['id']));
			$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$result['kode_po']));
			$data['products'][]=array(
				'no'=>$no++,
				'idsj' => $result['id'],
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>isset($po['kode_po']) ? $po['kode_po'] : '',
				'quantity'=>$result['totalkirim'],
				'namacmt'=>$result['idcmt'],
				'keterangan'=>$result['keterangan'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
				'dets'=>$dets,
			);
		}
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function kirimcmtadd(){
		$data=array();
		$data['title']='Pengiriman Buku Potong';
		$data['url']=$this->url;
		$data['cancel']=$this->url;
		$data['action']=$this->url.'kirimcmtsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['page']=$this->page.'kirimcmt_form';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view($this->layout,$data);
		
	}

	public function kirimcmtsave(){
		$post=$this->input->post();
		// pre($post);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		$masterpo=[];
		if(isset($post['tanggal'])){
			$insert=array(
				'tanggal'=>$post['tanggal'],
				'kode_po'=>'-',
				'totalkirim'=>0,
				'cmtkat'=>null,
				'idcmt'=>$post['idcmt'],
				'cmtkat'=>null,
				'cmtjob'=>'-',
				'status'=>0,
				'keterangan'=>$post['keterangan'],
				'dibuat'=>date('Y-m-d H:i:s'),
				'hapus'=>0,
			);
			$this->db->insert('kirimbupot', $insert);
   			$id = $this->db->insert_id();
   			
   			foreach($post['products'] as $p){
   				

   				$totalkirim+=($p['jumlah_pcs']);
   				$detail=array(
   					'idkirim'=>$id,
   					'kode_po'=>$p['kode_po'],
   					'cmtjob'=>null,
   					'rincian_po'=>$p['rincian_po'],
   					'jumlah_pcs'=>$p['jumlah_pcs'],
   					'keterangan'=>$p['keterangan'],
   					'jml_barang'=>$p['jml_barang'],
   					'hapus'=>0,
   				);
   				$this->db->insert('kirimbupot_detail',$detail);
   				
   				
   			}
			
			$num = $id;
			$num_padded = sprintf("%04d", $num);
	   		$nosj='SJFBUPOT'.'-'.date('Y-m').'-'.$num_padded;
			user_activity(callSessUser('id_user'),1,' input pengiriman surat jalan buku potongan '.$nosj);
			$this->db->update('kirimbupot',array('totalkirim'=>$totalkirim,'nosj'=>$nosj),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function kirimcmtview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['kembali']=$this->url.'';
		$data['cetak']=$this->url.'kirimcmtcetak/'.$id.'/1';
		// $data['excel']=$this->url.'kirimcmtcetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimbupot',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimbupot_detail',array('idkirim'=>$id,'hapus'=>0));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$k['kode_po']));
			$data['kirims'][]=array(
				'kode_po'=>$po['kode_po'].' '.$po['serian'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>null,
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['page']=$this->page.'kirimcmt_view';
		$this->load->view($this->layout,$data);
	}

	public function kirimcmtcetak($id='',$type=''){
		$rincian=array();
		$data=array();
		$data['nota']='CMT';
		$data['no']=1;
		$data['alat']=null;
		$data['kirim']=$this->GlobalModel->getDataRow('kirimbupot',array('id'=>$id));
		// pre($data['kirim']);
		$data['kirims']=$this->GlobalModel->getData('kirimbupot_detail',array('hapus'=>0,'idkirim'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['alat']= $this->GlobalModel->getData('distribusi_alat_sukabumi',array('hapus'=>0,'nomorsj'=>$data['kirim']['nosj']));
		if($type==2){
			$pdf=false;
		}else{
			$pdf=true;
		}
		
		if($pdf==true){
			//$this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			
			$html =  $this->load->view($this->page.'/kirimcmt_pdf',$data,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Surat Jalan Kirim Jahit';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Surat_Jalan_Kirim_Jahit_'.time();
	        // setting paper
	        //$paper = 'A4';
	        $paper = array(0,0,800,800);
	        //orientasi paper potrait / landscape
	        $orientation = "potrait";
	        
			$this->load->view('laporan_pdf',$this->data, true);	    
	        
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			if($type==1){
				//$this->load->view('produksi/kirimcmt_cetak',$data);
				$this->load->view('produksi/kirimcmt_pdf',$data);
			}else{
				$this->load->view('produksi/kirimcmt_excel',$data);
			}	
		}
		
		
	}	

	public function hapus($id,$pcs,$idsj)
	{
		// $this->GlobalModel->deleteData('user',array('id_user'=>$id));
		$this->db->update('kirimbupot_detail',array('hapus'=>1),array('id'=>$id));
		$this->db->query("UPDATE kirimbupot SET totalkirim=totalkirim-$pcs WHERE id=$idsj ");
		user_activity(callSessUser('id_user'),1,' menghapus Surat Jalan Buku Potongan dengan id id '.$id);
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect($this->url);
		
	}

	function validasi_list(){
		$data    = [];
		$data['title'] = 'Validasi Surat Jalan Buku Potongan ';
		$data['products']=array();
		$data['url']=$this->url;
		$data['i']=1;
		$data['tambah']=null;
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
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimbupot WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT * FROM kirimbupot WHERE hapus=0";

		if(!empty($cmt)){
			$sql.=" AND idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}

		$sql.=' ORDER BY id DESC ';
		$sql.=" LIMIT 20 ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		$dets=[];
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => $this->url.'kirimcmtview/'.$result['id'],
			);

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$dets = $this->GlobalModel->GetData('kirimbupot_detail',array('hapus'=>0,'idkirim'=>$result['id']));
			$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$result['kode_po']));
			$data['products'][]=array(
				'no'=>$no++,
				'idsj' => $result['id'],
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>isset($po['kode_po']) ? $po['kode_po'] : '',
				'quantity'=>$result['totalkirim'],
				'namacmt'=>$result['idcmt'],
				'keterangan'=>$result['keterangan'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
				'dets'=>$dets,
				'stat_validasi' => $result['validasi'],
				'validasi'=>$this->url.'validasi/'.$result['id'],
			);
		}
		$data['page']=$this->page.'validasi';
		$this->load->view($this->layout,$data);
	}

	public function validasi($id)
	{

		$this->db->query("UPDATE kirimbupot_detail SET validasi=1 WHERE id=$id ");
		user_activity(callSessUser('id_user'),1,' validasi Surat Jalan Buku Potongan dengan id id '.$id);
		$this->session->set_flashdata('msg','Data Berhasil Di Divalidasi');
		redirect($this->url.'validasi_list');
		
	}
		
}