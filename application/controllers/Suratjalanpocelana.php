<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suratjalanpocelana extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/suratjalanpocelana/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

    public function index(){
		$data=array();
		$data['title']='Surat Jalan Pengiriman PO Celana ';
		$data['products']=array();
		$data['url']=BASEURL.'Suratjalanpocelana';
		$data['i']=1;
		$data['tambah']=BASEURL.'Suratjalanpocelana/kirimcmtadd/';
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
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmt_celana WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT * FROM kirimcmt_celana WHERE hapus=0";

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
				'href' => BASEURL.'Suratjalanpocelana/kirimcmtview/'.$result['id'],
			);

			//if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => BASEURL.'Suratjalanpocelana/kirimcmtedit/'.$result['id'],
				);
			//}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$dets = $this->GlobalModel->GetData('kirimcmt_celana_detail',array('hapus'=>0,'idkirim'=>$result['id']));
			$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$result['kode_po']));
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>isset($po['kode_po']) ? $po['kode_po'] : '',
				'quantity'=>$result['totalkirim'],
				'namacmt'=>$namacmt['cmt_name'],
				'keterangan'=>$result['keterangan'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
				'dets'=>$dets,
			);
		}
		$data['page']='produksi/kirimcmt_celana_list';
		$this->load->view('newtheme/page/main',$data);
		
	}

	public function kirimcmtadd(){
		$data=array();
		$data['title']='Pengiriman Jahit ke cmt';
		$data['url']=BASEURL.'Suratjalanpocelana';
		$data['cancel']=BASEURL.'Suratjalanpocelana';
		$data['action']=BASEURL.'Suratjalanpocelana/kirimcmtsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['page']='produksi/kirimcmt_form';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view('newtheme/page/main',$data);
		
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
			$this->db->insert('kirimcmt_celana', $insert);
   			$id = $this->db->insert_id();
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt[0]));
   			foreach($post['products'] as $p){
   				$jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$p['cmtjob']));

   				$totalkirim+=($p['jumlah_pcs']);
   				$detail=array(
   					'idkirim'=>$id,
   					'kode_po'=>$p['kode_po'],
   					'cmtjob'=>999999,
   					'rincian_po'=>$p['rincian_po'],
   					'jumlah_pcs'=>$p['jumlah_pcs'],
   					'keterangan'=>$p['keterangan'],
   					'jml_barang'=>$p['jml_barang'],
   					'hapus'=>0,
   				);
   				$this->db->insert('kirimcmt_celana_detail',$detail);
   				
   			}
	   		$nosj='SJFB'.'-'.date('Y-m').'-'.$id;
			user_activity(callSessUser('id_user'),1,' input pengiriman surat jalan jahit celana '.$nosj);
	   		$this->db->update('kirimcmt_celana',array('totalkirim'=>$totalkirim,'nosj'=>$nosj),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Suratjalanpocelana');
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
		$data['kembali']=BASEURL.'Suratjalanpocelana';
		$data['cetak']=BASEURL.'Suratjalanpocelana/kirimcmtcetak/'.$id.'/1';
		$data['excel']=BASEURL.'Suratjalanpocelana/kirimcmtcetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt_celana',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmt_celana_detail',array('idkirim'=>$id,'hapus'=>0));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$k['kode_po']));
			$data['kirims'][]=array(
				'kode_po'=>$po['kode_po'].' '.$po['serian'],
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

	public function kirimcmtedit($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['cetak']=BASEURL.'Suratjalanpocelana/kirimcmtcetak/'.$id.'/1';
		$data['excel']=BASEURL.'Suratjalanpocelana/kirimcmtcetak/'.$id.'/2';
		$data['action']=BASEURL.'Suratjalanpocelana/kirimcmteditsave';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt_celana',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmt_celana_detail',array('idkirim'=>$id));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$k['kode_po']));
			$data['kirims'][]=array(
				'id_produksi_po' => $po['id_produksi_po'],
				'kode_po'=>$po['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['id'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['listcmt'] = $this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['listjob'] = $this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['page']='produksi/kirimcmt_edit';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kirimcmteditsave(){
		$post=$this->input->post();
		// pre($post);
		//pre($data);
		$cmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$post['idcmt']));
		// update di sj
		$this->db->query("UPDATE kirimcmt_celana set idcmt='".$post['idcmt']."',tanggal='".$post['tanggal']."' WHERE id='".$post['kode_nota']."' ");
		
		$totalkirim=0;
		foreach($post['prods'] as $p){
			$cek_diklo = $this->GlobalModel->getDataRow('kelolapo_kirim_setor', array('hapus'=>0,'idpo'=>$p['kode_po'],'kategori_cmt'=>'JAHIT','id_master_cmt'=>$post['idcmt']));
			$totalkirim+=($p['jumlah_pcs']);
			$rp=explode('-',$p['job']);

			
			$ud=array(
				'cmtjob'=>$rp[0],
				'jumlah_pcs'=>$p['jumlah_pcs'],
				'rincian_po'=>$p['rincian_po'],
				'jml_barang'=>$p['jml_barang'],
				'keterangan'=>$p['keterangan'],
			);
			$wd=array(
				'kode_po'=>$p['kode_po'],
				'idkirim'=>$post['kode_nota'],
			);
			$this->db->update('kirimcmt_celana_detail',$ud,$wd);
		}
		user_activity(callSessUser('id_user'),1,' edit surat jalan jahit celana '.$post['kode_nota']);
		$this->db->update('kirimcmt_celana',array('totalkirim'=>$totalkirim),array('id'=>$post['kode_nota']));
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect(BASEURL.'Suratjalanpocelana');
	}


	public function kirimcmtcetak($id='',$type=''){
		$rincian=array();
		$data=array();
		$data['nota']='CMT';
		$data['no']=1;
		$data['alat']=null;
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt_celana',array('id'=>$id));
		$data['kirims']=$this->GlobalModel->getData('kirimcmt_celana_detail',array('hapus'=>0,'idkirim'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['alat']= $this->GlobalModel->getData('distribusi_alat_sukabumi',array('hapus'=>0,'nomorsj'=>$data['kirim']['nosj']));
		if($type==2){
			$pdf=false;
		}else{
			$pdf=true;
		}
		
		if($pdf==true){
			//$this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			
			$html =  $this->load->view('produksi/kirimcmt_celana_pdf',$data,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Surat Jalan Kirim Jahit';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Surat_Jalan_Kirim_Jahit_'.time();
	        // setting paper
	        //$paper = 'A4';
	        $paper = array(0,0,800,850);
	        //orientasi paper potrait / landscape
	        $orientation = "landscape";
	        
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

}