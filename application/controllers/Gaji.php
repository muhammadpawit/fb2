<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller {

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
		$this->page='newtheme/page/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
		$this->load->model('PembayaranModel');
	}

	public function Gudang(){
		$data=[];
		$data['title']='Gaji Karyawan Gudang Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('Monday last week'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 AND bagian LIKE 'GUDANG%' ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'bagian'=>'Gudang',
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Gaji/gudangdetail/'.$r['id'],
				'hapus'=>BASEURL.'Gaji/gudang_hapus/'.$r['id'],
				'excel'=>BASEURL.'Gaji/gudangdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/gudang_add';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/list';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function gudangdetail($id){
		$data=[];
		$data['id']=$id;
		$data['title']='Gaji Karyawan Gudang Forboys';
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>round($gaji['gaji']/12*$d['senin']),
					'selasa'=>round($gaji['gaji']/12*$d['selasa']),
					'rabu'=>round($gaji['gaji']/12*$d['rabu']),
					'kamis'=>round($gaji['gaji']/12*$d['kamis']),
					'jumat'=>round($gaji['gaji']/12*$d['jumat']),
					'sabtu'=>round($gaji['gaji']/12*$d['sabtu']),
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
					'claim'=>$d['claim'],
					'pinjaman'=>$d['pinjaman'],
				);
			}
		}
		$data['kembali']=BASEURL.'Gaji/gudang';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/gudang_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function gudang_add(){
		$data=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Tambah Gaji Karyawan Gudang ';
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		//$data['harian']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0,'tipe'=>1));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE hapus=0 and tipe=1 AND lower(bagian) LIKE '%gudang%' ");
		foreach($results as $r){
			$lembur=$this->GlobalModel->QueryManualRow("SELECT SUM(jml_jam*upah) as total FROM lembur_harian WHERE hapus=0 AND idkaryawan='".$r['id']."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
			$data['harian'][]=array(
				'id'=>$r['id'],
				'nama'=>$r['nama'],
				'gaji'=>$r['gaji'],
				'bagian'=>$r['bagian'],
				'lembur'=>!empty($lembur)?$lembur['total']:0,
			);
		}
		$data['action']=BASEURL.'Gaji/gudang_save';
		$data['page']=$this->page.'gudang/gaji_gudang';
		$this->load->view($this->page.'main',$data);
	}

	public function gudang_save(){
		$data=$this->input->post();
		//pre($data);
		$cek=$this->GlobalModel->getDataRow('gaji_finishing',array('tanggal1'=>$data['tanggal1'],'bagian'=>'GUDANG','hapus'=>0));
		//pre($data);
		if(!empty($cek)){
			$this->session->set_flashdata('msgt','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Gaji/gudang');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'bagian'=>'GUDANG',
			'hapus'=>0,
		);
		$this->db->insert('gaji_finishing',$insert);
		$id=$this->db->insert_id();
		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){
				$detail=array(
					'idgaji'=>$id,
					'idkaryawan'=>$p['idkaryawan'],
					'nama'=>$p['nama'],
					'senin'=>isset($p['senin'])?$p['seninjamkerja']:0,
					'selasa'=>isset($p['selasa'])?$p['selasajamkerja']:0,
					'rabu'=>isset($p['rabu'])?$p['rabujamkerja']:0,
					'kamis'=>isset($p['kamis'])?$p['kamisjamkerja']:0,
					'jumat'=>isset($p['jumat'])?$p['jumatjamkerja']:0,
					'sabtu'=>isset($p['sabtu'])?$p['sabtujamkerja']:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lemburs'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
					'claim'=>isset($p['claim'])?$p['claim']:0,
					'pinjaman'=>isset($p['pinjaman'])?$p['pinjaman']:0,
					'kasbon'=>isset($p['jumlah_kasbon'])?$p['jumlah_kasbon']:0,
					'warteg'=>isset($p['warteg'])?$p['warteg']:0,
					'saving'=>isset($p['saving'])?$p['saving']:0,
					'keluarkansaving'=>isset($p['jumlah_keluar_saving'])?$p['jumlah_keluar_saving']:0,
				);
				$this->db->insert('gaji_finishing_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Gaji/gudang');
	}

	public function gudang_hapus($id){
		$update=array(
			'hapus'=>1
		);
		$where=array(
			'id'=>$id
		);
		$this->db->update('gaji_finishing',$update,$where);
		$this->session->set_flashdata('msg',' Berhasil Di Hapus');
		redirect(BASEURL.'Gaji/gudang');
	}

	public function pressqc(){
		$data=[];
		$data['title']='Gaji Press & QC Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('first day of last month'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND bagian='PRESSQC' ";
		$sql.=" ORDER BY id DESC";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'bagian'=>'Harian '.$r['bagian'],
				'detail'=>BASEURL.'Gaji/pressqcdetail/'.$r['id'],
				'hapus'=>BASEURL.'Gaji/pressqchapus/'.$r['id'],
				'excel'=>BASEURL.'Gaji/pressqcdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/pressqcadd';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/pressqc';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function pressqcadd(){
		$data=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Tambah Gaji Press dan QC Finishing';
		$lembur=0;
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE hapus=0 and tipe=1 AND lower(bagian) IN ('qc','qc po','press') ");
		foreach($results as $r){
			$lembur=$this->GlobalModel->QueryManualRow("SELECT SUM(jml_jam*upah) as total FROM lembur_harian WHERE hapus=0 AND idkaryawan='".$r['id']."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
			$data['harian'][]=array(
				'id'=>$r['id'],
				'nama'=>$r['nama'],
				'gaji'=>$r['gaji'],
				'bagian'=>$r['bagian'],
				'lembur'=>!empty($lembur)?$lembur['total']:0,
			);
		}
		//pre($data['harian']);
		$data['action']=BASEURL.'Gaji/pressqcsave';
		$data['page']=$this->page.'finishing/gaji_finishing';
		$this->load->view($this->page.'main',$data);
	}

	public function pressqcsave(){
		$data=$this->input->post();
		$cek=$this->GlobalModel->getDataRow('gaji_finishing',array('tanggal1'=>$data['tanggal1'],'hapus'=>0,'bagian'=>'PRESSQC'));
		//pre($data);
		if(!empty($cek)){
			$this->session->set_flashdata('msgt','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Gaji/pressqcadd');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'bagian'=>'PRESSQC',
			'hapus'=>0,
		);
		$this->db->insert('gaji_finishing',$insert);
		$id=$this->db->insert_id();
		// 24 September 2022, Perhitungan gaji dihitung dari jam kerjanya GH/12*Jam Kerja
		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){
				$detail=array(
					'idgaji'=>$id,
					'idkaryawan'=>$p['idkaryawan'],
					'nama'=>$p['nama'],
					'senin'=>isset($p['senin'])?$p['seninjamkerja']:0,
					'selasa'=>isset($p['selasa'])?$p['selasajamkerja']:0,
					'rabu'=>isset($p['rabu'])?$p['rabujamkerja']:0,
					'kamis'=>isset($p['kamis'])?$p['kamisjamkerja']:0,
					'jumat'=>isset($p['jumat'])?$p['jumatjamkerja']:0,
					'sabtu'=>isset($p['sabtu'])?$p['sabtujamkerja']:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lemburs'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
					'claim'=>isset($p['claim'])?$p['claim']:0,
					'pinjaman'=>isset($p['pinjaman'])?$p['pinjaman']:0,
					'kasbon'=>isset($p['jumlah_kasbon'])?$p['jumlah_kasbon']:0,
					'warteg'=>isset($p['warteg'])?$p['warteg']:0,
					'saving'=>isset($p['saving'])?$p['saving']:0,
					'keluarkansaving'=>isset($p['jumlah_keluar_saving'])?$p['jumlah_keluar_saving']:0,
				);
				$this->db->insert('gaji_finishing_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Gaji/pressqc');
	}

	public function pressqchapus($id){
		$update=array(
			'hapus'=>1
		);
		$where=array(
			'id'=>$id
		);
		$this->db->update('gaji_finishing',$update,$where);
		$this->session->set_flashdata('msg',' Berhasil Di Hapus');
		redirect(BASEURL.'Gaji/pressqc');
	}

	public function pressqcdetail($id){
		$id = (int)$id;
		$data=[];
		$data['id']=$id;
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['title']='Resume Gaji Karyawan Finishing Forboys';
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		// 24 September 2022, Perhitungan gaji dihitung dari jam kerjanya GH/12*Jam Kerja
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>round($gaji['gaji']/12*$d['senin']),
					'selasa'=>round($gaji['gaji']/12*$d['selasa']),
					'rabu'=>round($gaji['gaji']/12*$d['rabu']),
					'kamis'=>round($gaji['gaji']/12*$d['kamis']),
					'jumat'=>round($gaji['gaji']/12*$d['jumat']),
					'sabtu'=>round($gaji['gaji']/12*$d['sabtu']),
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
					'claim'=>$d['claim'],
					'pinjaman'=>$d['pinjaman'],
					'saving'=>isset($d['saving'])?$d['saving']:0,
					'keluarkansaving'=>isset($d['keluarkansaving'])?$d['keluarkansaving']:0,
				);
			}
		}
		$data['kembali']=BASEURL.'Gaji/pressqc';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}elseif(isset($get['pdf']) || isset($_GET['pdf'])){
			$this->load->library('pdfgenerator');
	        $this->data['title_pdf'] = 'Resume Gaji Karyawan Finishing Forboys';
	        $file_pdf = 'Resume_Gaji_Karyawan_Finishing_Forboys_'.time();
	        $paper = 'A4';
	        $orientation = 'landscape';
	        $html = $this->load->view($this->page.'gaji/finishing_pdf',$data, true);
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			$data['page']=$this->page.'gaji/finishing_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function slip($id){
		$data=[];
		$get = $this->input->get();
		$data['title']='Slip Gaji Karyawan';
		$data['slip']=$this->GlobalModel->getDataRow('gaji_bulanan',array('id'=>$id));
		$nama=$this->GlobalModel->getDataRow('karyawan',array('id'=>$data['slip']['idkaryawan']));
		$data['nama']=$nama['nama'];
		$data['nik']=$nama['nik'];
		$bagian=$this->GlobalModel->getDataRow('jabatan',array('id'=>$nama['jabatan']));
		$data['bagian']=$bagian['nama'];
		$divisi=$this->GlobalModel->getDataRow('divisi',array('id'=>$nama['divisi']));
		$data['divisi']=$divisi['nama'];
		$data['batal']=BASEURL.'Gaji/bulanan';
		$data['cetak']=BASEURL.'Gaji/slip/'.$id.'?&pdf=true';
		if(isset($get['pdf'])){
			//$this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			
			$html =  $this->load->view($this->page.'gaji/slip_pdf',$data,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Slip Gaji ';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'SLIP_Gaji_'.time();
	        // setting paper
	        //$paper = 'A4';
	        $paper = array(0,0,550,700);
	        //orientasi paper potrait / landscape
	        $orientation = "potrait";
	        
			$this->load->view('laporan_pdf',$this->data, true);	    
	        
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			$data['page']=$this->page.'gaji/slip';
		$this->load->view($this->page.'main',$data);
		}
		
	}

	public function bulanan(){
		$data=[];
		$data['title']='Gaji Bulanan Karyawan ';
		$data['gaji']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of last month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;

		$sql="SELECT * FROM gaji_bulanan WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$karyawan=$this->GlobalModel->getDataRow('karyawan',array('id'=>$r['idkaryawan']));
			$tanggala = date('Y-m-d',strtotime($karyawan['tglmasuk']));
			$tanggal = new DateTime($tanggala); 
			if($karyawan['status_resign']==1){
				$sekarang = new DateTime();
				$perbedaan = $tanggal->diff($sekarang);
			}else{
				$sekarang = new DateTime($karyawan['tglkeluar']);
				$perbedaan = $tanggal->diff($sekarang);
			}
			$jabatan=$this->GlobalModel->getDataRow('jabatan',array('id'=>$karyawan['jabatan']));
			$divisi=$this->GlobalModel->getDataRow('divisi',array('id'=>$karyawan['divisi']));
			$data['gaji'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tanggal'=>date('d F Y',strtotime($r['tanggal'])),
				'periode'=>strtolower($r['periode']),
				'nama'=>strtoupper($karyawan['nama']),
				'divisi'=>!empty($divisi) ? strtolower($divisi['nama']) : '',
				'jabatan'=>!empty($jabatan) ? strtolower($jabatan['nama']) : '',
				'tglmasuk'=>date('d-m-Y',strtotime($tanggala)),
				'masakerja'=>$perbedaan->y,
				'gajikotor'=>$r['gajipokok'],
				'gantungan_gaji'=>$r['gantungan_gaji'],
				'gaji_bersih'=>($r['gajipokok']-$r['gantungan_gaji']),
				'total_kasbon'=>$r['potongan_kasbon'],
				'pinjaman'=>0,
				'pot_pinjamanperbulan'=>0,
				'pot1'=>0,
				'pot2'=>0,
				'sisa_pinjaman'=>0,
				'status'=>'',
				'potongan_absensi'=>$r['potongan_absensi'],
				'potongan_keterlambatan'=>$r['potongan_terlambat'],
				'potongan_claim'=>$r['potongan_claim'],
				'gaji_yangditerima'=>($r['gajipokok']-$r['gantungan_gaji']-$r['potongan_absensi']-$r['potongan_terlambat']-$r['potongan_claim']),
				'keterangan'=>$r['keterangan'],
				'total'=>($r['total']),
				'slip'=>BASEURL.'Gaji/Slip/'.$r['id'],
				'gantungan_gaji' => $r['gantungan_gaji'],
			);
			$no++;
		}
		$data['akseshapus']=akseshapus();
		$data['hapus']=BASEURL.'Gaji/hapusgaji/';
		$data['tambah']=BASEURL.'Gaji/bulananadd';
		
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/bulanan_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/bulanan';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function bulananadd(){
		$data=[];
		$data['title']='Input Slip Gaji';
		$get=$this->input->get();
		
		if(isset($get['bulan'])){
			$bulan_ini = sprintf("%02d", $get['bulan']);
		}else{
			$bulan_ini = date('m');
		}
		
		if(isset($get['tahun'])){
			$tahun_ini = $get['tahun'];
		}else{
			$tahun_ini = date('Y');
		}
		
		$data['bulan_ini'] = $bulan_ini;
		$data['tahun_ini'] = $tahun_ini;
		
		$karyawans_raw = karyawan();
		$karyawan_list = [];
		
		foreach($karyawans_raw as $k) {
			$idkaryawan = $k['id'];
			
			// Get sum of kasbon
			$sql_kasbon = "SELECT COALESCE(SUM(nominal_request), 0) as total_kasbon FROM kasbon WHERE hapus=0 AND idkaryawan='".$idkaryawan."' AND MONTH(tanggal) ='".$bulan_ini."' AND YEAR(tanggal)='".$tahun_ini."'";
			$res_kasbon = $this->GlobalModel->queryManualRow($sql_kasbon);
			$total_kasbon = !empty($res_kasbon['total_kasbon']) ? $res_kasbon['total_kasbon'] : 0;
			
			// Get active pinjaman
			$sql_pinjaman = "SELECT * FROM pinjaman_karyawan WHERE idkaryawan='".$idkaryawan."' AND hapus=0 ORDER BY id ASC";
			$res_pinjaman = $this->GlobalModel->queryManual($sql_pinjaman);
			
			$idpinjaman = 0;
			$sisa_pinjaman = 0;
			if(!empty($res_pinjaman)){
				foreach($res_pinjaman as $pinj) {
					$sisa = $pinj['totalpinjaman'] - $pinj['totalpotongan'];
					if($sisa > 0) {
						$idpinjaman = $pinj['id'];
						$sisa_pinjaman = $sisa;
						break; // Get the first active one
					}
				}
			}
			
			$karyawan_list[] = [
				'id' => $idkaryawan,
				'nama' => $k['nama'],
				'gajipokok' => $k['gajipokok'],
				'potongan_kasbon' => $total_kasbon,
				'idpinjaman' => $idpinjaman,
				'sisa_pinjaman' => $sisa_pinjaman
			];
		}

		$data['karyawans'] = $karyawan_list;
		$data['page']=$this->page.'gaji/slipform_all';
		$data['action']=BASEURL.'Gaji/slipsave_all';
		$data['batal']=BASEURL.'Gaji/bulanan';
		$this->load->view($this->page.'main',$data);
	}

	public function slipsave(){
		$data=$this->input->post();
		// pre($data);
		if(isset($data['idpinjaman'])){
			$cek=$this->GlobalModel->getDataRow('pinjaman_karyawan',array('id'=>$data['idpinjaman']));
			if($cek['totalpinjaman']==$cek['totalpotongan']){
				$status=3;
			}else{
				$insertpotongan=array(
					'tanggal'=>isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d'),
					'idkaryawan'=>$data['idkaryawan'],
					'idpinjaman'=>$data['idpinjaman'],
					'totalpotongan'=>$data['potongan_pinjaman'],
					'keterangan'=>'Potongan pinjaman tanggal '.$data['tanggal'],
					'hapus'=>0,
				);
				$this->db->insert('potongan_pinjaman_karyawan',$insertpotongan);
				$this->db->query("UPDATE pinjaman_karyawan set totalpotongan=totalpotongan+'".$data['potongan_pinjaman']."' WHERE id='".$data['idpinjaman']."' ");
				$cek2=$this->GlobalModel->getDataRow('pinjaman_karyawan',array('id'=>$data['idpinjaman']));
				if($cek2['totalpinjaman']==$cek2['totalpotongan']){
					$status=3;
				}else{
					$status=2;
				}
				$this->db->query("UPDATE pinjaman_karyawan set status='".$status."' WHERE id='".$data['idpinjaman']."' ");
			}
		}
		//pre($data);
		$subtotal = (isset($data['gajipokok']) ? $data['gajipokok'] : 0) + (isset($data['bonus']) ? $data['bonus'] : 0) + (isset($data['thr']) ? $data['thr'] : 0);
		$total_potongan = (isset($data['potongan_kasbon']) ? $data['potongan_kasbon'] : 0) + (isset($data['potongan_pinjaman']) ? $data['potongan_pinjaman'] : 0) + (isset($data['potongan_claim']) ? $data['potongan_claim'] : 0) + (isset($data['potongan_absensi']) ? $data['potongan_absensi'] : 0) + (isset($data['potongan_terlambat']) ? $data['potongan_terlambat'] : 0) + (isset($data['gantungan_gaji']) ? $data['gantungan_gaji'] : 0);
		$total = $subtotal - $total_potongan;
		
		$insert=array(
			'tanggal'=>isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d'),
			'periode'=>date('Y-m-d',strtotime("first day of last month")).''.date('Y-m-d',strtotime("last day of this month")),
			'idkaryawan'=>$data['idkaryawan'],
			'gajipokok'=>$data['gajipokok'],
			'potongan_kasbon'=>$data['potongan_kasbon'],
			'potongan_pinjaman'=>$data['potongan_pinjaman'],
			'potongan_claim'=>$data['potongan_claim'],
			'potongan_absensi'=>$data['potongan_absensi'],
			'potongan_terlambat'=>$data['potongan_terlambat'],
			'gantungan_gaji'=>$data['gantungan_gaji'],
			'bonus'=>$data['bonus'],
			'thr'=>$data['thr'],
			'subtotal'=>$subtotal,
			'total'=>$total,
			'keterangan'=>'Gaji Periode '.date('Y-m-d',strtotime("first day of last month")).''.date('Y-m-d',strtotime("last day of this month")),
			'hapus'=>0,
			'metode' => $data['metode'],
		);
		$this->db->insert('gaji_bulanan',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gaji/bulanan');
	}

	public function slipsave_all(){
		$post = $this->input->post();
		$bulan_post = isset($post['bulan']) ? sprintf('%02d', $post['bulan']) : date('m');
		$tahun_post = isset($post['tahun']) ? $post['tahun'] : date('Y');
		$tanggal = $tahun_post . '-' . $bulan_post . '-' . date('d');
		
		$first_day = $tahun_post . '-' . $bulan_post . '-01';
		$last_day = date('Y-m-t', strtotime($first_day));
		$periode = $first_day . $last_day;
		
		if(isset($post['karyawan']) && is_array($post['karyawan'])){
			foreach($post['karyawan'] as $idk => $data){
				if(isset($data['checked']) && $data['checked'] == 1){
					
					if(!empty($data['idpinjaman']) && !empty($data['potongan_pinjaman']) && $data['potongan_pinjaman'] > 0){
						$cek=$this->GlobalModel->getDataRow('pinjaman_karyawan',array('id'=>$data['idpinjaman']));
						if($cek['totalpinjaman']==$cek['totalpotongan']){
							$status=3;
						}else{
							$insertpotongan=array(
								'tanggal'=>$tanggal,
								'idkaryawan'=>$idk,
								'idpinjaman'=>$data['idpinjaman'],
								'totalpotongan'=>$data['potongan_pinjaman'],
								'keterangan'=>'Potongan pinjaman tanggal '.$tanggal,
								'hapus'=>0,
							);
							$this->db->insert('potongan_pinjaman_karyawan',$insertpotongan);
							$this->db->query("UPDATE pinjaman_karyawan set totalpotongan=totalpotongan+'".$data['potongan_pinjaman']."' WHERE id='".$data['idpinjaman']."' ");
							$cek2=$this->GlobalModel->getDataRow('pinjaman_karyawan',array('id'=>$data['idpinjaman']));
							if($cek2['totalpinjaman']==$cek2['totalpotongan']){
								$status=3;
							}else{
								$status=2;
							}
							$this->db->query("UPDATE pinjaman_karyawan set status='".$status."' WHERE id='".$data['idpinjaman']."' ");
						}
					}
					
					$subtotal_server = (isset($data['gajipokok']) ? $data['gajipokok'] : 0) + (isset($data['bonus']) ? $data['bonus'] : 0) + (isset($data['thr']) ? $data['thr'] : 0);
					$total_potongan_server = (isset($data['potongan_kasbon']) ? $data['potongan_kasbon'] : 0) + (isset($data['potongan_pinjaman']) ? $data['potongan_pinjaman'] : 0) + (isset($data['potongan_claim']) ? $data['potongan_claim'] : 0) + (isset($data['potongan_absensi']) ? $data['potongan_absensi'] : 0) + (isset($data['potongan_terlambat']) ? $data['potongan_terlambat'] : 0) + (isset($data['gantungan_gaji']) ? $data['gantungan_gaji'] : 0);
					$total_server = $subtotal_server - $total_potongan_server;
					
					$insert=array(
						'tanggal'=>$tanggal,
						'periode'=>$periode,
						'idkaryawan'=>$idk,
						'gajipokok'=>isset($data['gajipokok']) ? $data['gajipokok'] : 0,
						'potongan_kasbon'=>isset($data['potongan_kasbon']) ? $data['potongan_kasbon'] : 0,
						'potongan_pinjaman'=>isset($data['potongan_pinjaman']) ? $data['potongan_pinjaman'] : 0,
						'potongan_claim'=>isset($data['potongan_claim']) ? $data['potongan_claim'] : 0,
						'potongan_absensi'=>isset($data['potongan_absensi']) ? $data['potongan_absensi'] : 0,
						'potongan_terlambat'=>isset($data['potongan_terlambat']) ? $data['potongan_terlambat'] : 0,
						'gantungan_gaji'=>isset($data['gantungan_gaji']) ? $data['gantungan_gaji'] : 0,
						'bonus'=>isset($data['bonus']) ? $data['bonus'] : 0,
						'thr'=>isset($data['thr']) ? $data['thr'] : 0,
						'subtotal'=>$subtotal_server,
						'total'=>$total_server,
						'keterangan'=>'Gaji Periode '.$periode,
						'hapus'=>0,
						'metode' => isset($data['metode']) ? $data['metode'] : 1,
					);
					$this->db->insert('gaji_bulanan',$insert);
				}
			}
		}
		
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gaji/bulanan');
	}

	public function hapusgaji($id){
		$this->db->update('gaji_bulanan',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Gaji/bulanan');
	}

	public function getkasbon(){
		$get=$this->input->get();
		if(isset($get['tahun'])){
			$year = $get['tahun'];
		} else {
			$year = date('Y');
		}
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of last month"));
		}
		if(isset($get['bulan'])){
			$tanggal2=$get['bulan'];
		}else{
			$tanggal2=date('m',strtotime("last day of this month"));
		}
		$sql="SELECT * FROM kasbon WHERE hapus=0 AND idkaryawan='".$get['idkaryawan']."'   ";
		//$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" AND MONTH(tanggal) ='".$tanggal2."' ";
		$sql.=" AND YEAR(tanggal) ='".$year."' ";
		$sql.=" ORDER BY id ASC ";
		$kasbon=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$total=0;
		if(!empty($kasbon)){
			foreach($kasbon as $k){
				echo "<tr>";
				echo "<td>".$no++."</td>";
				echo "<td>".date('d F Y',strtotime($k['tanggal']))."</td>";
				echo "<td>Rp.".number_format($k['nominal_request'])."</td>";
				echo "</tr>";
				$total+=($k['nominal_request']);
			}
			echo "<tr>";
			echo '<td></td>';
			echo '<td>Total</td>';
			echo '<td>Rp.'.number_format($total).'</td>';
			echo "</tr>";
		}else{
			echo "<tr>";
			echo '<td colspan="3">Tidak ada rincian kasbon</td>';
			echo "</tr>";
		}
	}

	public function getsumkasbon(){
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of last month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		$sql="SELECT * FROM kasbon WHERE hapus=0 and idkaryawan='".$get['idkaryawan']."'  ";
		//$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" AND MONTH(tanggal) ='".date('m',strtotime($tanggal2))."' ";
		$sql.=" ORDER BY id ASC ";
		$kasbon=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$total=0;
		foreach($kasbon as $k){
			$total+=($k['nominal_request']);
		}
		echo $total;
	}

	public function getpinjaman(){
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of last month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		//$sql="SELECT * FROM potongan_pinjaman_karyawan WHERE idkaryawan='".$get['idkaryawan']."' and hapus=0 ";
		//$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql="SELECT * FROM pinjaman_karyawan WHERE idkaryawan='".$get['idkaryawan']."' and hapus=0 ";
		$sql.=" ORDER BY id ASC ";
		$pinj=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$pinjaman=null;
		$sisa=0;
		if(!empty($pinj)){
			foreach($pinj as $k){
				$sisa=($k['totalpinjaman']-$k['totalpotongan']);
				if($sisa>0){
					echo "<tr>";
					echo "<td>".$no++." <input type='hidden' name='idpinjaman' value='".$k['id']."'/></td>";
					echo "<td>".date('d F Y',strtotime($k['tanggal']))."</td>";
					echo "<td>Rp.".number_format($k['totalpinjaman'])."</td>";
					echo "<td>Rp.".number_format($k['totalpinjaman']-$k['totalpotongan'])."</td>";
					echo "<td>".strtolower($k['keterangan'])."</td>";
					echo "</tr>";
				}else{
					echo "<tr>";
					echo "<td colspan='5'>Tidak ada rincian pinjaman</td>";
					echo "</tr>";
				}
			}
		}else{
			echo "<tr>";
			echo "<td colspan='5'>Tidak ada rincian pinjaman</td>";
			echo "</tr>";
		}
	}

	public function getkaryawan(){
		$get=$this->input->get();
		$gaji=$this->GlobalModel->getDataRow('karyawan',array('id'=>$get['idkaryawan']));
		echo $gaji['gajipokok'];
	}

	public function operatorbordir(){
		$data=[];
		$data['title']='Resume Gaji Karyawan operator Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('Monday last week'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM gaji_operator WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tempat'=>$r['tempat']==1?'Rumah':'Cipadu',
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Gaji/operatorbordirdetail/'.$r['id'],
				'excel'=>BASEURL.'Bordir/operatorbordirdetail/'.$r['id'].'?&excel=1',
				'hapus'=>BASEURL.'Bordir/hapusgajioperator/'.$r['id'],
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/operatorbordir';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/operatorbordir_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/bordirlist';
			$this->load->view($this->page.'main',$data);
		}	
		
	}

	public function operatorbordirdetail($id){
		$data=[];
		$data['karyawans']=[];
		$details=[];
		$data['title']='Resume Gaji Karyawan Bordir Forboys';
		$data['karyawans']=[];
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_operator',array('hapus'=>0,'id'=>$id));
		$bonussiang=0;
		$bonusmalam=0;
		$umsiang=0;
		$ummalam=0;
		if(!empty($data['gaji'])){
			
			$results=$this->GlobalModel->getData('gaji_operator_new',array('hapus'=>0,'idgajiopt'=>$id));
			foreach($results as $r){
				$data['karyawans'][]=array(
					'tgl1'=>$data['gaji']['tanggal1'],
					'tgl2'=>$data['gaji']['tanggal2'],
					'idkaryawan' =>$r['idkaryawan'],
					'nama'=>$r['nama'],
					'shift'=>isset($r['shift']) ? ($r['shift']==1?'PAGI':'MALAM') : '-',
					'totalgaji'=>$r['totalgaji'],
					'totalbonus'=>$r['totalbonus'],
					'totalum'=>$r['totalum'],
					'grandtotal'=>$r['grandtotal'],
					'details'=>$this->GlobalModel->getData('gaji_operator_detail_new',array('hapus'=>0,'idgaji'=>$r['id'])),
				);
			}
			//pre($data['karyawans']);
			$bonussiang=$this->ReportModel->SumBonusOptBordir($id,1);
			$bonusmalam=$this->ReportModel->SumBonusOptBordir($id,2);
			$umsiang=$this->ReportModel->SumUmOptBordir($id,1);
			$ummalam=$this->ReportModel->SumUmOptBordir($id,2);
			$data['bonussiang']=$bonussiang;
			$data['bonusmalam']=!empty($bonusmalam)?$bonusmalam:0;
			//$data['umsiang']=$umsiang;
			$data['umsiang']=0;
			$data['ummalam']=!empty($ummalam)?21000:0;
		}
		$data['kembali']=BASEURL.'Bordir/gajioperator';
		$data['excel']=BASEURL.'Bordir/operatorbordirdetail/'.$id.'?&excel=1';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/operatorbordir_excel_new',$data);
		}else{
			$data['page']=$this->page.'gaji/operatorbordir_detail_new';
			$this->load->view($this->page.'main',$data);
		}
		
	}

	public function finishing(){
		$data=[];
		$data['title']='Resume Gaji Karyawan Finishing Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('Monday last week'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 AND bagian LIKE '%Finishing%' ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Gaji/finishingdetail/'.$r['id'],
				'excel'=>BASEURL.'Gaji/finishingdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/finishing';
			$this->load->view($this->page.'main',$data);
		}
		
	}

	public function finishingdetail($id){
		$id = (int)$id;
		$data=[];
		$data['id']=$id;
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['title']='Resume Gaji Karyawan Finishing Forboys';
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>round($gaji['gaji']/12*$d['senin']),
					'selasa'=>round($gaji['gaji']/12*$d['selasa']),
					'rabu'=>round($gaji['gaji']/12*$d['rabu']),
					'kamis'=>round($gaji['gaji']/12*$d['kamis']),
					'jumat'=>round($gaji['gaji']/12*$d['jumat']),
					'sabtu'=>round($gaji['gaji']/12*$d['sabtu']),
					'minggu'=>round($gaji['gaji']/12*$d['minggu']),
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
					'claim'=>$d['claim'],
					'pinjaman'=>$d['pinjaman'],
					'saving'=>isset($d['saving'])?$d['saving']:0,
					'keluarkansaving'=>isset($d['keluarkansaving'])?$d['keluarkansaving']:0,
				);
			}
		}
		$data['kembali']=BASEURL.'Gaji/finishing';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}elseif(isset($get['pdf']) || isset($_GET['pdf'])){
			$this->load->library('pdfgenerator');
	        $this->data['title_pdf'] = 'Resume Gaji Karyawan Finishing Forboys';
	        $file_pdf = 'Resume_Gaji_Karyawan_Finishing_Forboys_'.time();
	        $paper = 'A4';
	        $orientation = 'landscape';
	        $html = $this->load->view($this->page.'gaji/finishing_pdf',$data, true);
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			$data['page']=$this->page.'gaji/finishing_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function gajiklo(){
		$data=[];
		$data['title']='Gaji KLO Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('first day of last month'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND bagian='KLO' ";
		$sql.=" ORDER BY id DESC";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'bagian'=>'Harian '.$r['bagian'],
				'detail'=>BASEURL.'Gaji/gajiklodetail/'.$r['id'],
				'edit'=>BASEURL.'Gaji/gajikloedit/'.$r['id'],
				'hapus'=>BASEURL.'Gaji/gajiklohapus/'.$r['id'],
				'excel'=>BASEURL.'Gaji/gajiklodetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/gajikloadd';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/pressqc';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function gajikloadd(){
		$data=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Tambah KLO ';
		$lembur=0;
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE hapus=0 and tipe=1 AND bagian='KLO' ");
		foreach($results as $r){
			$lembur=$this->GlobalModel->QueryManualRow("SELECT SUM(jml_jam*upah) as total FROM lembur_harian WHERE hapus=0 AND idkaryawan='".$r['id']."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
			$data['harian'][]=array(
				'id'=>$r['id'],
				'nama'=>$r['nama'],
				'gaji'=>$r['gaji'],
				'bagian'=>$r['bagian'],
				'lembur'=>!empty($lembur)?$lembur['total']:0,
				'saving'	=> $this->PembayaranModel->saving($r['id'],$tanggal1,$tanggal2),
			);
		}
		//pre($data['harian']);
		$data['action']=BASEURL.'Gaji/gajiklosave';
		$data['page']=$this->page.'finishing/gaji_finishing';
		$this->load->view($this->page.'main',$data);
	}

	

	public function gajiklosave(){
		$data=$this->input->post();
		$cek=$this->GlobalModel->getDataRow('gaji_finishing',array('tanggal1'=>$data['tanggal1'],'hapus'=>0,'bagian'=>'KLO'));
		// pre($data);
		if(!empty($cek)){
			$this->session->set_flashdata('gagal','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Gaji/gajikloadd');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'bagian'=>'KLO',
			'hapus'=>0,
		);
		$this->db->insert('gaji_finishing',$insert);
		$id=$this->db->insert_id();
		// 24 September 2022, Perhitungan gaji dihitung dari jam kerjanya GH/12*Jam Kerja
		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){

				$gajiperminggu = $this->GlobalModel->GetDataRow('karyawan_harian',array('id'=>$p['idkaryawan']));
				if($p['jumlah_kasbon']>0){
					$saving = !empty($gajiperminggu['perminggu']) ? ($gajiperminggu['perminggu']-$p['jumlah_kasbon']):0;
				}else{
					$saving = 0;
				}
				

				$detail=array(
					'idgaji'=>$id,
					'idkaryawan'=>$p['idkaryawan'],
					'nama'=>$p['nama'],
					'senin'=>isset($p['senin'])?$p['seninjamkerja']:0,
					'selasa'=>isset($p['selasa'])?$p['selasajamkerja']:0,
					'rabu'=>isset($p['rabu'])?$p['rabujamkerja']:0,
					'kamis'=>isset($p['kamis'])?$p['kamisjamkerja']:0,
					'jumat'=>isset($p['jumat'])?$p['jumatjamkerja']:0,
					'sabtu'=>isset($p['sabtu'])?$p['sabtujamkerja']:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lemburs'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
					'claim'=>$p['claim'],
					'pinjaman'=>$p['pinjaman'],
					'warteg'=>isset($p['warteg'])?$p['warteg']:0,
					'saving'=>isset($p['saving'])? $p['saving']:0,
					// 'saving'=>$saving,
					'keluarkansaving'=>isset($p['jumlah_keluar_saving'])? $p['jumlah_keluar_saving']:0,
					'tanggal_saving' => date('Y-m-d'),
				);
				$this->db->insert('gaji_finishing_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Gaji/gajiklo');
	}

	public function gajikloedit($id){
		$data=array();
		$data['id']=$id;
		$data['title']='Edit Gaji KLO';
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('id'=>$id));
		$results=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id,'hapus'=>0));
		foreach($results as $r){
			$k=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$r['idkaryawan']));
			$data['harian'][]=array(
				'iddetail'=>$r['id'],
				'id'=>$r['idkaryawan'],
				'nama'=>$r['nama'],
				'gaji'=>!empty($k)?$k['gaji']:0,
				'bagian'=>!empty($k)?$k['bagian']:'KLO',
				'senin'=>$r['senin'],
				'selasa'=>$r['selasa'],
				'rabu'=>$r['rabu'],
				'kamis'=>$r['kamis'],
				'jumat'=>$r['jumat'],
				'sabtu'=>$r['sabtu'],
				'minggu'=>$r['minggu'],
				'lembur'=>$r['lembur'],
				'insentif'=>$r['insentif'],
				'claim'=>$r['claim'],
				'pinjaman'=>$r['pinjaman'],
				'warteg'=>$r['warteg'],
				'saving'=>$r['saving'],
				'keluarkansaving'=>$r['keluarkansaving'],
			);
		}
		$data['tanggal1']=$data['gaji']['tanggal1'];
		$data['tanggal2']=$data['gaji']['tanggal2'];
		$data['action']=BASEURL.'Gaji/gajikloupdate';
		$data['page']=$this->page.'finishing/gaji_finishing_edit';
		$this->load->view($this->page.'main',$data);
	}

	public function gajikloupdate(){
		$data=$this->input->post();
		$id = $data['id'];
		$update=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
		);
		$this->db->update('gaji_finishing',$update,array('id'=>$id));
		
		foreach($data['products'] as $p){
			if(isset($p['iddetail'])){
				$detail=array(
					'senin'=>isset($p['senin'])?$p['seninjamkerja']:0,
					'selasa'=>isset($p['selasa'])?$p['selasajamkerja']:0,
					'rabu'=>isset($p['rabu'])?$p['rabujamkerja']:0,
					'kamis'=>isset($p['kamis'])?$p['kamisjamkerja']:0,
					'jumat'=>isset($p['jumat'])?$p['jumatjamkerja']:0,
					'sabtu'=>isset($p['sabtu'])?$p['sabtujamkerja']:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lemburs'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
					'claim'=>$p['claim'],
					'pinjaman'=>$p['pinjaman'],
					'warteg'=>isset($p['warteg'])?$p['warteg']:0,
					'saving'=>isset($p['saving'])? $p['saving']:0,
					'keluarkansaving'=>isset($p['jumlah_keluar_saving'])? $p['jumlah_keluar_saving']:0,
				);
				$this->db->update('gaji_finishing_detail',$detail,array('id'=>$p['iddetail']));
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Berhasil Di Update');
		redirect(BASEURL.'Gaji/gajiklo');
	}

	public function gajiklohapus($id){
		$update=array(
			'hapus'=>1
		);
		$where=array(
			'id'=>$id
		);
		$this->db->update('gaji_finishing',$update,$where);
		$this->db->update('gaji_finishing_detail',$update,array('idgaji'=>$id));
		$this->session->set_flashdata('msg',' Berhasil Di Hapus');
		redirect(BASEURL.'Gaji/gajiklo');
	}

	public function gajiklodetail($id){
		$id = (int)$id;
		$data=[];
		$data['id']=$id;
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['title']='Resume Gaji KLO Forboys';
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		// 24 September 2022, Perhitungan gaji dihitung dari jam kerjanya GH/12*Jam Kerja
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>round($gaji['gaji']/12*$d['senin']),
					'selasa'=>round($gaji['gaji']/12*$d['selasa']),
					'rabu'=>round($gaji['gaji']/12*$d['rabu']),
					'kamis'=>round($gaji['gaji']/12*$d['kamis']),
					'jumat'=>round($gaji['gaji']/12*$d['jumat']),
					'sabtu'=>round($gaji['gaji']/12*$d['sabtu']),
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
					'claim'=>$d['claim'],
					'pinjaman'=>$d['pinjaman'],
					'warteg'=>$d['warteg'],
					'saving'=>$d['saving'],
					'keluarkansaving'=>$d['keluarkansaving'],
				);
			}
		}
		$data['kembali']=BASEURL.'Gaji/gajiklo';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}elseif(isset($get['pdf']) || isset($_GET['pdf'])){
			$this->load->library('pdfgenerator');
	        $this->data['title_pdf'] = 'Resume Gaji KLO Forboys';
	        $file_pdf = 'Resume_Gaji_KLO_Forboys_'.time();
	        $paper = 'A4';
	        $orientation = 'landscape';
	        $html = $this->load->view($this->page.'gaji/finishing_pdf',$data, true);
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			$data['page']=$this->page.'gaji/finishing_detail';
			$this->load->view($this->page.'main',$data);
		}
	}
}