<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notakirim extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->link=BASEURL.'Notakirim/';
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/notakirim/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index()
	{
		$data=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}

		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Nota Kirim Gudang Forboys';
		$data['no']=1;
		$data['products']=array();

		$sql='SELECT * FROM finishing_kirim_gudang WHERE id_finishing_kirim_gudang>0 ';
		$sql.=" AND date(tanggal_kirim) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		
		$results = $this->GlobalModel->queryManual($sql);
		/*
		 [id_finishing_kirim_gudang] => 160
            [kode_po] => TEST001
            [artikel_po] => 2020
            [harga_satuan] => 2261
            [keterangan] => tes
            [created_date] => 2021-01-29
            [nofaktur] => 4361216
            [nama_penerima] => Gudang Forboys
            [tujuan] => Tanah Abang
            [jumlah_harga_piece] => 325584
            [jumlah_piece_diterima] => 144
            [tanggal_kirim] => 2021-01-29
		*/
		foreach($results as $r){
			$data['products'][]=array(
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal_kirim'])),
				'nofaktur'=>$r['nofaktur'],
				'nama_penerima'=>strtolower($r['nama_penerima']),
				'keterangan'=>strtolower($r['keterangan']),
				'detail'=>$this->link.'detail/'.$r['nofaktur'],
			);
		}
		$data['tambah']=$this->link.'add';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=[];
		$get=$this->input->get();
		$data['action']=$this->link.'save';
		$data['page']=$this->page.'form';
		$this->load->view($this->layout,$data);
	}

	public function save(){
		$data=$this->input->post();
		pre($data);
	}

	public function detail($noFaktur='')
	{
		$get=$this->input->get();
		$url='';
		if(isset($get['hgs'])){
			$hgs=$get['hgs'];
			$url='&hgs='.$hgs;
		}else{
			$hgs=null;
		}
		// $tahunsebelum = $this->db->query("SELECT tahunpo FROM finishing_kirim_gudang WHERE nofaktur='".$noFaktur."' ")->row();
		$tahunsebelum=[];
		if(!empty($tahunsebelum->tahunpo)){
			$sql="SELECT fkg.id_finishing_kirim_gudang,fkg.nofaktur,pp.kode_artikel as artikel_po,fkg.harga_satuan,fkg.jumlah_harga_piece,fkg.keterangan,fkg.nama_penerima,fkg.tujuan,fkg.kode_po,pp.nama_po,fkg.created_date,fkg.jumlah_piece_diterima,fkg.tanggal_kirim FROM finishing_kirim_gudang fkg ";
			$sql.=" JOIN produksi_po_".getTahunProduksiBefore()." pp ON fkg.idpo=pp.id_produksi_po WHERE fkg.nofaktur='".$noFaktur."' ";
		}else{
			$sql='SELECT fkg.id_finishing_kirim_gudang,fkg.nofaktur,pp.kode_artikel as artikel_po,fkg.harga_satuan,fkg.jumlah_harga_piece,fkg.keterangan,fkg.nama_penerima,fkg.tujuan,fkg.kode_po,pp.nama_po,fkg.created_date,fkg.jumlah_piece_diterima,fkg.tanggal_kirim FROM finishing_kirim_gudang fkg 
			JOIN produksi_po pp ON fkg.idpo=pp.id_produksi_po WHERE fkg.nofaktur="'.$noFaktur.'" ';
		}
		//pre($tahunsebelum->tahunpo);
		
		if(!empty($hgs)){
			$sql.=" AND pp.nama_po lIKE '".$hgs."%'";
		}else{
			$sql.=" AND pp.nama_po <> 'HGS' ";
		}
		//pre($sql);
		$viewData['gudangfb'] = $this->GlobalModel->queryManual($sql);
			$data = array();
		
		foreach ($viewData['gudangfb'] as $key => $idkirim) {
			$data[$idkirim['kode_po']] = $this->GlobalModel->getData('finishing_kirim_gudang_rincian',array('id_finishing_kirim_gudang'=>$idkirim['id_finishing_kirim_gudang']));
		}
		//pre($data);
		$viewData['dataRinci'] = $data;
		$viewData['cancel']=BASEURL.'Finishing/pengirimangudang';
		$viewData['excel']=$this->link.'Detail/'.$noFaktur.'?&excel=1'.$url;
		$viewData['pdf']=$this->link.'Detailpdf/'.$noFaktur.'?'.$url;
		$viewData['no']=1;
		$get=$this->input->get();
		
		$pdf=false;
		if($pdf==true){
			$html =  $this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Laporan Penjualan Toko Kita';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Slip_';
	        // setting paper
	        $paper = 'A4';
	        //orientasi paper potrait / landscape
	        $orientation = "potrait";
	        
			$this->load->view('laporan_pdf',$this->data, true);	    
	        
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			if(!isset($get['excel'])){
	 			$viewData['page']='finishing/nota/nota-kirim-print';
	 			$this->load->view('newtheme/page/main',$viewData);
	 		}else{
	 			$this->load->view('finishing/nota/nota-kirim-excel',$viewData);
	 		}	
		}
 		
        
        /*
        */
		
	}

	public function Detailpdf($noFaktur='')
	{
		$get=$this->input->get();
		$url='';
		if(isset($get['hgs'])){
			$hgs=$get['hgs'];
			$url='&hgs='.$hgs;
		}else{
			$hgs=null;
		}
		$tahunsebelum=[];
		if(!empty($tahunsebelum->tahunpo)){
			$sql="SELECT fkg.id_finishing_kirim_gudang,fkg.nofaktur,pp.kode_artikel as artikel_po,fkg.harga_satuan,fkg.jumlah_harga_piece,fkg.keterangan,fkg.nama_penerima,fkg.tujuan,fkg.kode_po,pp.kode_po as po,pp.nama_po,fkg.created_date,fkg.jumlah_piece_diterima,fkg.tanggal_kirim FROM finishing_kirim_gudang fkg ";
			$sql.=" JOIN produksi_po_".getTahunProduksiBefore()." pp ON fkg.idpo=pp.id_produksi_po WHERE fkg.nofaktur='".$noFaktur."' ";
		}else{
			$sql='SELECT fkg.id_finishing_kirim_gudang,fkg.nofaktur,pp.kode_artikel as artikel_po,fkg.harga_satuan,fkg.jumlah_harga_piece,fkg.keterangan,fkg.nama_penerima,fkg.tujuan,fkg.kode_po,pp.kode_po as po,pp.nama_po,fkg.created_date,fkg.jumlah_piece_diterima,fkg.tanggal_kirim FROM finishing_kirim_gudang fkg 
			JOIN produksi_po pp ON fkg.idpo=pp.id_produksi_po WHERE fkg.nofaktur="'.$noFaktur.'" ';
		}
		if(!empty($hgs)){
			$sql.=" AND pp.nama_po='".$hgs."' ";
		}else{
			$sql.=" AND pp.nama_po <> 'HGS' ";
		}
		//pre($sql);
		$viewData['gudangfb'] = $this->GlobalModel->queryManual($sql);
		$viewData['prods']=[];
		foreach($viewData['gudangfb'] as $f){
			$viewData['prods'][] = array(
				'id_finishing_kirim_gudang' => $f['id_finishing_kirim_gudang'],
				'nofaktur' => $f['nofaktur'],
				'artikel_po' => $f['artikel_po'],
				'harga_satuan' => $f['harga_satuan'],
				'jumlah_harga_piece' => $f['jumlah_harga_piece'],
				'keterangan' => $f['keterangan'],
				'nama_penerima' => $f['nama_penerima'],
				'tujuan' => $f['tujuan'],
				'kode_po' => $f['kode_po'],
				'po' => $f['po'],
				'nama_po' => $f['nama_po'],
				'created_date' => $f['created_date'],
				'jumlah_piece_diterima' => $f['jumlah_piece_diterima'],
				'tanggal_kirim' => $f['tanggal_kirim'],
				'details' => $this->GlobalModel->GetData('finishing_kirim_gudang_rincian',array('id_finishing_kirim_gudang'=>$f['id_finishing_kirim_gudang'])),
			);
		}
		
		$data = array();
		
		foreach ($viewData['gudangfb'] as $key => $idkirim) {
			$data[$idkirim['kode_po']] = $this->GlobalModel->getData('finishing_kirim_gudang_rincian',array('id_finishing_kirim_gudang'=>$idkirim['id_finishing_kirim_gudang']));
		}
		
		$viewData['dataRinci'] = $data;
		// pre($viewData['prods']);
		$groupedData = [];

		foreach ($viewData['dataRinci'] as $items) {
			foreach ($items as $item) {
				$groupedData[] = $item['rincian_size'];
			}
		}
		

		// Hasilnya akan ditampung di $newData
		$uniqueData = array_unique($groupedData);
		$viewData['sizes']=$uniqueData;
		// pre($viewData['sizes']);
		$viewData['cancel']=$this->link;
		$viewData['excel']=$this->link.'Detail/'.$noFaktur.'?&excel=1'.$url;
		$viewData['no']=1;
		$viewData['title']='Surat Jalan Kirim Gudang';
		$get=$this->input->get();
		
		$pdf=true;
		if($pdf==true){
			$html =  $this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			$this->load->library('pdfgenerator');
	        $file_pdf = $viewData['title'];
	        // $paper = 'A4';
			$paper = array(0,0,800,1200);
	        $orientation = "potrait";	        
			$headerContent = $this->load->view('newtheme/page/pdf/header', $viewData, true);
			$footerContent =null;
			$htmlWithHeaderFooter = $headerContent . $html . $footerContent;
			generate_pdf($this, $htmlWithHeaderFooter, $data, $file_pdf, $paper , $orientation);
		}else{
			if(!isset($get['excel'])){
	 			$viewData['page']='finishing/nota/nota-kirim-print';
	 			$this->load->view('newtheme/page/main',$viewData);
	 		}else{
	 			$this->load->view('finishing/nota/nota-kirim-excel',$viewData);
	 		}	
		}
 		
        
        /*
        */
		
	}

	public function edit($noFaktur='')
	{
		$viewData['gudangfb'] = $this->GlobalModel->queryManual('SELECT fkg.id_finishing_kirim_gudang,fkg.nofaktur,fkg.artikel_po,fkg.harga_satuan,fkg.jumlah_harga_piece,fkg.keterangan,fkg.nama_penerima,fkg.tujuan,fkg.kode_po,pp.nama_po,fkg.created_date,fkg.jumlah_piece_diterima,fkg.tanggal_kirim FROM finishing_kirim_gudang fkg JOIN produksi_po pp ON fkg.idpo=pp.id_produksi_po WHERE fkg.nofaktur="'.$noFaktur.'" ');
		//pre($viewData);
		$data = array();
		foreach ($viewData['gudangfb'] as $key => $idkirim) {
			$data[$idkirim['kode_po']] = $this->GlobalModel->getData('finishing_kirim_gudang_rincian',array('id_finishing_kirim_gudang'=>$idkirim['id_finishing_kirim_gudang']));
		}
		$viewData['dataRinci'] = $data;
		$viewData['cancel']=$this->link;
		$viewData['edit']=BASEURL.'Notakirim/editsave';
		$viewData['no']=1;
		$viewData['page']='finishing/nota/edit';
		$get = $this->input->get();
		if(isset($get['keterangan'])){
			$viewData['disabled']='readonly';
		}else{
			$viewData['disabled']='';
		}
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function kirim_next($noFaktur='')
	{
		$viewData['gudangfb'] = $this->GlobalModel->queryManual('SELECT fkg.idpo,fkg.id_finishing_kirim_gudang,fkg.nofaktur,fkg.artikel_po,fkg.harga_satuan,fkg.jumlah_harga_piece,fkg.keterangan,fkg.nama_penerima,fkg.tujuan,fkg.kode_po,pp.nama_po,fkg.created_date,fkg.jumlah_piece_diterima,fkg.tanggal_kirim FROM finishing_kirim_gudang fkg JOIN produksi_po pp ON fkg.idpo=pp.id_produksi_po WHERE fkg.idpo="'.$noFaktur.'" GROUP BY pp.kode_po ');
		//pre($viewData['gudangfb']);
			$data = array();
		foreach ($viewData['gudangfb'] as $key => $idkirim) {
			$data[$idkirim['kode_po']] = $this->GlobalModel->queryManual("SELECT * FROM finishing_kirim_gudang_rincian WHERE id_finishing_kirim_gudang='".$idkirim['id_finishing_kirim_gudang']."' GROUP BY rincian_size");
		}
		//pre($viewData['gudangfb']);
		$viewData['dataRinci'] = $data;
		//pre($data);
		$viewData['cancel']=BASEURL.'Finishing/pengirimangudang';
		$viewData['edit']=BASEURL.'Notakirim/next_save';
		$viewData['no']=1;
		$viewData['page']='finishing/nota/next';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function next_save(){
		$post = $this->input->post();
		//pre($post);
		$dz=0;
		$pcs=0;
		$totalterima=0;
						$idpo=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$post['idpo']));
						//pre($idpo);
						foreach($post['rincian'] as $r){
							$dz+=($r['dz']);
							$pcs+=($r['pcs']);
						}
						$sudahdikirim = $this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_piece_diterima)) as total FROM finishing_kirim_gudang WHERE kode_po='".$idpo['kode_po']."' ");
						
						$dikirim=($dz*12) + $pcs + $sudahdikirim['total'];
						
						$cek_diterima = $this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jml_setor_qty+pcs_setor_qty-bangke_qty-barang_cacad_qty)) as total FROM kelolapo_rincian_setor_cmt WHERE kode_po='".$idpo['kode_po']."' ");
						//pre($dikirim);
						if($dikirim>$cek_diterima['total']){
							
							$this->session->set_flashdata('gagal','Data Gagal Di Simpan. Pengiriman Melebihi Penerimaan ');
							redirect (BASEURL.'Notakirim/kirim_next/'.$post['idpo']);
							
						}

						$dataInsert = array(
							'idpo'				=> $idpo['id_produksi_po'],
							'nofaktur'			=> 	$post['nofaktur'],
							'nama_penerima'		=>  'Gudang Forboys',
							'tujuan'			=>	'Tanah Abang',
							'artikel_po'			=>	$idpo['kode_artikel'], 
							'kode_po'			=> 	$idpo['kode_po'],
							'harga_satuan'		=> 	$idpo['harga_satuan'],
							'jumlah_harga_piece'	=> ($dz*12) + $pcs * $idpo['harga_satuan'],
							'jumlah_piece_diterima'	=>($dz*12) + $pcs,
							'keterangan'		=>'',
							'created_date'		=> date('Y-m-d H:i:s'),
							'tanggal_kirim'		=>	$post['tanggal_kirim'],
							'susulan'			=> 1,

						);
						 $this->GlobalModel->insertData('finishing_kirim_gudang',$dataInsert);
						 $lastId = $this->db->insert_id();

						foreach($post['rincian'] as $r){
							$dataRincian = array(
								'id_finishing_kirim_gudang'		=> $lastId,
								'rincian_size'		=> $r['rincian_size'], 
								'rincian_lusin'		=> $r['dz'], 
								'rincian_piece'		=> $r['pcs'],
								'created_date'		=> date('Y-m-d H:i:s')
							);
							$this->GlobalModel->insertData('finishing_kirim_gudang_rincian',$dataRincian);
						}

		$this->session->set_flashdata('msg','Berhasil Di Simpan');
		redirect(BASEURL.'Finishing/pengirimangudang');				
		//pre($post);
	}

	public function editsave(){
		$data=$this->input->post();
		//pre($data);
		$dz=0;
		$pcs=0;
		$totalterima=0;
		foreach($data['rincian'] as $keys=>$val){
			$k[]=array(
				'idkirim'=>$keys,
				'rincian'=>$val
			);
		}
		
		foreach($k as $s){
			foreach($s['rincian'] as $l){
				$ud=array(
					'rincian_lusin'=>$l['dz'],
					'rincian_piece'=>$l['pcs'],
				);
				// update rinciannya
				$this->db->update('finishing_kirim_gudang_rincian',$ud,array('id_finishing_kirim_gudang_rincian'=>$l['id']));
			}
			
			// update totalanya
			$cek=$this->GlobalModel->queryManualRow("SELECT id_finishing_kirim_gudang, SUM(rincian_lusin*12+rincian_piece) as totalterima FROM finishing_kirim_gudang_rincian WHERE id_finishing_kirim_gudang='".$s['idkirim']."' group by id_finishing_kirim_gudang");
			$po=$this->GlobalModel->getDataRow('finishing_kirim_gudang',array('id_finishing_kirim_gudang'=>$cek['id_finishing_kirim_gudang']));
			$this->db->update('finishing_kirim_gudang',array('jumlah_piece_diterima'=>$cek['totalterima'],'jumlah_harga_piece'=>$po['harga_satuan']*$cek['totalterima'],'nofaktur'=>$data['nofaktur']),array('id_finishing_kirim_gudang'=>$cek['id_finishing_kirim_gudang']));
			$this->db->update('produksi_po',array('jumlah_pcs_po'=>$cek['totalterima']),array('id_po'=>$po['id_produksi_po']));
		}

		foreach($data['gudang'] as $g){
			$this->db->update(
				'finishing_kirim_gudang',
				array(
					'keterangan' => $g['keterangan']
				),
				array(
					'id_finishing_kirim_gudang' => $g['id']
				)
			);
		}

		$this->session->set_flashdata('msg','Berhasil Di Ubah');
		redirect(BASEURL.'Finishing/pengirimangudang');

	}
}