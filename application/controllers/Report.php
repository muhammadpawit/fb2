<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('KirimsetorModel');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
	}

	public function kirimgudang(){
		$data=[];
		$data['title']='Laporan Kirim Gudang';
		$get=$this->input->get();
		$data['products']=[];
		$results=array();
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

		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=date('n');
		}
		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=date('Y');
		}

		$filter=array(
			'bulan'=>$bulan,
			'tahun'=>$tahun,
		);

		$results=$this->KirimsetorModel->kirimgudang($filter);
		$no=0;
		$prev=null;
		$h=null;
		foreach($results as $row){
			$hari=hari(date('l',strtotime($row['tanggal'])));
			$data['products'][]=array(
				'no'=>$no,
				'hari'=>$hari,
				'tanggal'=>date('d-m-Y',strtotime($row['tanggal'])),
				'jml'=>$row['jml'],
				'nama'=>$row['nama'],
				'nilai'=>$row['nilai']
			);
			$no++;
		}
		$url='';
		if(!empty($bulan)){
			$url.="&bulan=".$bulan;
		}
		if(!empty($tahun)){
			$url.="&tahun=".$tahun;
		}
		$data['excel']=BASEURL.'Report/kirimgudang?&excel=true'.$url;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['bulan']=$bulan;
		$data['tahun'] =$tahun;
		if(isset($get['excel'])){
			$this->load->view($this->page.'report/kirimgudang_excel',$data);	
		}else{
			$data['page']=$this->page.'report/kirimgudang';
			$this->load->view($this->layout,$data);	
		}
	}
	public function transferkasoperasional(){
		$data=[];
		$data['title']='Laporan Kas Operasional dan Transferan';
		$get=$this->input->get();
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
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

		$data=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'cat'=>$cat,
		);
		$data['products']=array();
		$konveksi=array();
		$sql="SELECT tanggal FROM transferan WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		if(!empty($cat)){
			$sql.=" AND bagian='$cat' ";
		}
		$sql.=" GROUP BY tanggal ORDER BY tanggal ASC ";
		$products=$this->GlobalModel->QueryManual($sql);
		//pre($products);
		foreach($products as $p){
			$konveksi=$this->ReportModel->transferkas($p['tanggal'],$cat);
			$data['products'][]=array(
				'tanggal'=>$p['tanggal'],
				'kasmasuk'=>$this->ReportModel->sumkas('saldomasuk',$p['tanggal'],$cat),
				'masukkonveksi'=>$cat==1?$this->ReportModel->sumkas('saldomasuk',$p['tanggal'],1):0,
				'keluarkonveksi'=>$cat==1?$kmasuk=$this->ReportModel->sumkas('saldokeluar',$p['tanggal'],1):0,
				'masukbordir'=>$cat==2?$kmasuk=$this->ReportModel->sumkas('saldomasuk',$p['tanggal'],2):0,
				'keluarbordir'=>$cat==2?$kmasuk=$this->ReportModel->sumkas('saldokeluar',$p['tanggal'],2):0,
				'masuksablon'=>$cat==3?$kmasuk=$this->ReportModel->sumkas('saldomasuk',$p['tanggal'],3):0,
				'keluarsablon'=>$cat==3?$kmasuk=$this->ReportModel->sumkas('saldokeluar',$p['tanggal'],3):0,
				'konveksi'=>$konveksi,
			);
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		if(isset($get['excel'])){
			$this->load->view($this->page.'keuangan/report_gabungantransferkas_excel',$data);
		}else{
			$data['page']=$this->page.'keuangan/report_gabungantransferkas';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function operasionalkas(){
		$data=array();
		$data['title']='Laporan Transferan dan Kas Masuk Keseluruhan';
		$get=$this->input->get();
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}

		if(isset($get['tim'])){
			$tim=$get['tim'];
		}else{
			$tim=null;
		}

		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'tim'=>$tim,
		);
		$data['products']=array();
		$konveksi=array();
		$products=$this->ReportModel->Grouptransferkas($filter,'aruskas');
		$kmasuk=0;
		$kkeluar=0;
		$ksisa=0;
		$bmasuk=0;
		$bkeluar=0;
		$bsisa=0;
		$smasuk=0;
		$skeluar=0;
		$ssisa=0;
		$konveksi=array();
		foreach($products as $p){
			$konveksi=$this->ReportModel->oprkas($p['tanggal'],1);
			$data['products'][]=array(
				'tanggal'=>$p['tanggal'],
				'kasmasuk'=>$kmasuk=$this->ReportModel->sumkasall('saldomasuk',$p['tanggal']),
				'masukkonveksi'=>$kmasuk=$this->ReportModel->sumkas('saldomasuk',$p['tanggal'],1),
				'keluarkonveksi'=>$kmasuk=$this->ReportModel->sumkas('saldokeluar',$p['tanggal'],1),
				'masukbordir'=>$kmasuk=$this->ReportModel->sumkas('saldomasuk',$p['tanggal'],2),
				'keluarbordir'=>$kmasuk=$this->ReportModel->sumkas('saldokeluar',$p['tanggal'],2),
				'masuksablon'=>$kmasuk=$this->ReportModel->sumkas('saldomasuk',$p['tanggal'],3),
				'keluarsablon'=>$kmasuk=$this->ReportModel->sumkas('saldokeluar',$p['tanggal'],3),
				'konveksi'=>$konveksi,
			);
		}
		//pre($products);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		if(isset($get['excel'])){
			$this->load->view($this->page.'keuangan/report_operasional_excel',$data);
		}else{
			$data['page']=$this->page.'keuangan/report_operasional';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function transferkas(){
		$data=array();
		$data['title']='Laporan Transferan dan Kas Masuk Keseluruhan';
		$get=$this->input->get();
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}

		if(isset($get['tim'])){
			$tim=$get['tim'];
		}else{
			$tim=null;
		}

		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'tim'=>$tim,
		);
		$data['products']=array();
		$konveksi=array();
		$products=$this->ReportModel->Grouptransferkas($filter,'transferan');
		foreach($products as $p){
			$konveksi=$this->ReportModel->transferkas($p['tanggal'],1);
			$data['products'][]=array(
				'tanggal'=>$p['tanggal'],
				'konveksi'=>$konveksi,
			);
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		if(isset($get['excel'])){
			$this->load->view($this->page.'keuangan/report_transferkas_excel',$data);
		}else{
			$data['page']=$this->page.'keuangan/report_transferkas';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function potongan(){
		$this->load->model('ReportModel');
		$data=array();
		$data['title']='Laporan Potongan Produksi Forboys';
		$get=$this->input->get();
		$results=array();
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

		if(isset($get['tim'])){
			$tim=$get['tim'];
		}else{
			$tim=null;
		}

		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=null;
		}

		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'tim'=>$tim,
			'jenis'=>$jenis,
		);
		$data['products']=array();
		$results=$this->ReportModel->potongan($filter);
		$data['n']=1;
		$timpotong=null;
		$totaldz=0;
		$totalpcs=0;
		$roll=0;
		$rolv=0;
		foreach($results as $r){
			$timpotong=$this->GlobalModel->getDataRow('timpotong',array('id'=>$r['tim_potong_potongan']));
			$roll=$this->ReportModel->getsumroll($r['kode_po'],'UTAMA');
			$rolv=$this->ReportModel->getsumroll($r['kode_po'],'CELANA');
			$totaldz+=($r['hasil_lusinan_potongan']);
			$totalpcs+=($r['hasil_pieces_potongan']);
			$data['products'][]=array(
				'tanggal'=>date('d-m-Y',strtotime($r['created_date'])),
				'kode_po'=>$r['kode_po'],
				'timpotong'=>$timpotong==null?$r['tim_potong_potongan']:$timpotong['nama'],
				'panjang_gelaran_potongan_utama'=>$r['panjang_gelaran_potongan_utama'],
				'panjang_gelaran_variasi'=>$r['panjang_gelaran_variasi']>0?'+'.$r['panjang_gelaran_variasi']:'',
				'pemakaian_bahan_utama'=>$r['pemakaian_bahan_utama'],
				'jumlah_pemakaian_bahan_variasi'=>$r['jumlah_pemakaian_bahan_variasi'],
				'size_potongan'=>$r['size_potongan'],
				'lusin'=>$r['hasil_lusinan_potongan'],
				'pcs'=>$r['hasil_pieces_potongan'],
				'roll_utama'=>$roll->roll,
				'roll_variasi'=>$rolv->roll,
			);
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tim']=$tim;
		$data['jeniss']=$jenis;
		$data['totaldz']=$totaldz;
		$data['totalpcs']=$totalpcs;
		$data['timpotong']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$data['jenis']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		if(isset($get['cetak'])){
			$this->load->view('newtheme/page/report/potongan_cetak',$data);
		}else{
			$data['page']=$this->page.'report/potongan';
			$this->load->view($this->page.'main',$data);
		}		
	}
	public function gambarpotongbahan()
	{
		$get = $this->input->get();
		
		$potongan = array();
		

		if (!empty($get)) {
			$bukuPot = $this->GlobalModel->queryManual('SELECT * FROM produksi_po pp JOIN konveksi_buku_potongan kbp ON pp.kode_po=kbp.kode_po WHERE kbp.created_date >="'.$get['startDate'].'" AND kbp.created_date <="'.$get['endDate'].'"');

			foreach ($bukuPot as $key => $bkPot) {
				$rollan = 0;
				$bahan = $this->GlobalModel->queryManual('SELECT * FROM gudang_bahan_keluar WHERE kode_po="'.$bkPot['kode_po'].'" AND bahan_kategori="UTAMA" ');
				$potongan['potongan'][$key]['tanggal'] = $bkPot['created_date'];
				$potongan['potongan'][$key]['kode_po'] = $bkPot['kode_po'];
				$potongan['potongan'][$key]['gelaranUtama']	=	$bkPot['panjang_gelaran_potongan_utama'];
				$potongan['potongan'][$key]['gelaranvariasi']	=	$bkPot['panjang_gelaran_variasi'];
				$potongan['potongan'][$key]['bahanUtama']	=	$bkPot['jumlah_pemakaian_bahan_utama'];
				$potongan['potongan'][$key]['bahanVariasi']	=	$bkPot['jumlah_pemakaian_bahan_variasi'];
				$potongan['potongan'][$key]['size']	= $bkPot['size_potongan'];
				$potongan['potongan'][$key]['lusin']	=	$bkPot['hasil_lusinan_potongan'];
				foreach ($bahan as $keyBh => $bh) {
					$rollan += $bh['jumlah_item_keluar'];
				}
				$potongan['potongan'][$key]['rollbahan'] = $rollan;
			}
			$viewData = $potongan;
		} else {
			$bukuPot	= $this->GlobalModel->queryManual('SELECT * FROM produksi_po pp JOIN konveksi_buku_potongan kbp ON pp.kode_po=kbp.kode_po');
			foreach ($bukuPot as $key => $bkPot) {
				$rollan = 0;
				$bahan = $this->GlobalModel->queryManual('SELECT * FROM gudang_bahan_keluar WHERE kode_po="'.$bkPot['kode_po'].'" AND bahan_kategori="UTAMA" ');
				$potongan['potongan'][$key]['tanggal'] = $bkPot['created_date'];
				$potongan['potongan'][$key]['kode_po'] = $bkPot['kode_po'];
				$potongan['potongan'][$key]['gelaranUtama']	=	$bkPot['panjang_gelaran_potongan_utama'];
				$potongan['potongan'][$key]['gelaranvariasi']	=	$bkPot['panjang_gelaran_variasi'];
				$potongan['potongan'][$key]['bahanUtama']	=	$bkPot['jumlah_pemakaian_bahan_utama'];
				$potongan['potongan'][$key]['bahanVariasi']	=	$bkPot['jumlah_pemakaian_bahan_variasi'];
				$potongan['potongan'][$key]['size']	= $bkPot['size_potongan'];
				$potongan['potongan'][$key]['lusin']	=	$bkPot['hasil_lusinan_potongan'];
				foreach ($bahan as $keyBh => $bh) {
					$rollan += $bh['jumlah_item_keluar'];
				}
				$potongan['potongan'][$key]['rollbahan'] = $rollan;
			}
				// pre($potongan);
			$viewData = $potongan;
		}
		$this->load->view('global/header');
		$this->load->view('report/report-gambarpobahan-view',$viewData);
		$this->load->view('global/footer');
	}

	public function bordir($mesin='',$karyawan='')
	{
		$get = $this->input->get();
		$sql = '';
		// pre($get);
		if (!empty($get)) {
			if (!empty($get['mesin'])) {
				$sql .= 'WHERE kmb.mesin_bordir ="'.$get['mesin'].'" AND kmb.nama_operator="'.$get['operator'].'"';
			} 
			if (!empty($get['tanggalMulai'])) {
				$sql .= 'WHERE kmb.created_date >="'.$get['tanggalMulai'].'" AND kmb.created_date <="'.$get['tanggalEnd'].'"';
			}
		} else {
			$sql = '';
		}
		//pre('SELECT * FROM kelola_mesin_bordir kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po '.$sql.' ');
		$viewData['bordir'] = $this->GlobalModel->queryManual('SELECT * FROM kelola_mesin_bordir kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po '.$sql.' ');
		
		$viewData['mesin'] = $this->GlobalModel->getData('master_mesin',null);
		$viewData['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',null);

		$this->load->view('global/header');
		$this->load->view('report/report-bordir',$viewData);
		$this->load->view('global/footer');
	}

	public function buangbenang($karyawan='')
	{
		$get = $this->input->get();
		if (!empty($get)) {
			$sql = 'WHERE kmb.nama_pekerja ="'.$get['karyawan'].'" AND kmb.created_date >="'.$get['tanggalMulai'].'" AND kmb.created_date <="'.$get['tanggalMulai'].'"';
		} else {
			$sql = '';
		}

		$viewData['benang'] = $this->GlobalModel->queryManual('SELECT * FROM kelolapo_buang_benang kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po '.$sql.' ');
		$viewData['karyawan'] = $this->GlobalTwoModel->getData('master_karyawan_benang',null);
		$this->load->view('global/header');
		$this->load->view('report/report-buang-benang',$viewData);
		$this->load->view('global/footer');
	}

	public function kirimsetorcmt($value='')
	{
		$get = $this->input->get();
		$sql = '';
		if (!empty($get)) {
			if (empty($get['jenisPo'])) {
				$sql .= 'AND pp.nama_po ="'.$get['jenisPo'].'"'; 
			}
			$viewData['kirim'] = $this->GlobalModel->queryManual('SELECT kmb.create_date, kmb.id_master_cmt, kmb.kode_po, kmb.kategori_cmt, kmb.nama_cmt, kmb.qty_tot_pcs, kmb.progress, kmb.kode_po, kmb.id_master_cmt, kmb.kategori_cmt, kmb.keterangan FROM kelolapo_kirim_setor kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po WHERE '.$sql.' kmb.create_date >="'.$get['tanggalMulai'].'" AND kmb.create_date <="'.$get['tanggalAkhir'].'" AND kmb.progress="KIRIM" ');
		} else {
			$viewData['kirim'] = $this->GlobalModel->queryManual('SELECT kmb.create_date, kmb.id_master_cmt, kmb.kode_po, kmb.kategori_cmt, kmb.nama_cmt, kmb.qty_tot_pcs, kmb.progress, kmb.kode_po, kmb.id_master_cmt, kmb.kategori_cmt, kmb.keterangan FROM kelolapo_kirim_setor kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po WHERE kmb.progress="KIRIM" ');
		}
		$viewData['jenisPo'] = $this->GlobalModel->getData('master_jenis_po',null);

		$this->load->view('global/header');
		$this->load->view('report/report-setor-kirim',$viewData);
		$this->load->view('global/footer');
	}

	public function laporanproduksikaos($value='')
	{
		$get = $this->input->get();
		$sql = '';
		$viewData['kirim'] = array();
			$viewData['setor'] = array();
			$viewData['proses'] = array();
			$viewData['cmt']	= array();
		if (!empty($get)) {
			$viewData['tanggal'] = $get;
			if (!empty($get['cmtKat'])) {
				$sql .= 'kks.kategori_cmt="'.$get['cmtKat'].'"'; 
			}

			//$viewData['kirim'] = $this->GlobalModel->queryManual("SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po WHERE ".$sql." AND kks.create_date >='".$get['tanggalMulai']."' AND kks.create_date <='".$get['tanggalAkhir']."' AND kks.progress='KIRIM' ");
			$viewData['kirim'] = $this->GlobalModel->queryManual("SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po WHERE ".$sql." AND kks.progress='KIRIM' AND kks.kode_po NOT IN(SELECT kode_po FROM kelolapo_kirim_setor WHERE progress='PROSES' AND kategori_cmt LIKE '".$get['cmtKat']."') ");
			$viewData['setor'] = $this->GlobalModel->queryManual("SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po WHERE ".$sql." AND kks.create_date >='".$get['tanggalMulai']."' AND kks.create_date <='".$get['tanggalAkhir']."' AND kks.progress='SETOR' ");
			//$viewData['proses'] = $this->GlobalModel->queryManual("SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po WHERE ".$sql." AND kks.create_date >='".$get['tanggalMulai']."' AND kks.create_date <='".$get['tanggalAkhir']."' AND kks.progress='PROSES' ");
			$viewData['proses'] = $this->GlobalModel->queryManual("SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po WHERE ".$sql." AND kks.create_date >='".$get['tanggalMulai']."' AND kks.create_date <='".$get['tanggalAkhir']."' AND kks.kode_po NOT IN(SELECT kode_po FROM kelolapo_kirim_setor WHERE progress='SETOR' AND kategori_cmt LIKE '".$get['cmtKat']."') ");
			$viewData['cmt']	= $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>$get['cmtKat']));
			// pre($viewData);

			//$viewData['stock'] = $this->GlobalModel->queryManual("SELECT *  FROM `produksi_po` WHERE `updated_date` <= '".$get['tanggalAkhir']."' AND `updated_date` <= '".$get['tanggalAkhir']."' AND `id_proggresion_po` = 'PROSES' AND `progress_lokasi` LIKE '".$get['cmtKat']."'");
			$viewData['stock'] = $this->GlobalModel->queryManual("SELECT *  FROM `produksi_po` WHERE `updated_date` <= '".$get['tanggalAkhir']."' AND `updated_date` <= '".$get['tanggalAkhir']."' AND kode_po NOT IN(SELECT kode_po FROM kelolapo_kirim_setor WHERE progress='SETOR' AND kategori_cmt LIKE '".$get['cmtKat']."') AND `progress_lokasi` LIKE '".$get['cmtKat']."'");
			// pre($viewData['stock']);

		} else {
			

			$viewData['stock'] = $this->GlobalModel->queryManual("SELECT *  FROM `produksi_po` WHERE kode_po NOT IN (SELECT kode_po from kelolapo_kirim_setor WHERE progress='SETOR' and kategori_cmt='JAHIT') AND `progress_lokasi` LIKE 'JAHIT'");
		}
		// pre($viewData['stock']);
		$viewData['jenisPo'] = $this->GlobalModel->queryManual('SELECT * FROM `master_jenis_po` WHERE status=1 ORDER BY `nama_jenis_po` ASC');

		$this->load->view('global/header');
		$this->load->view('report/report-stok-cmt',$viewData);
		$this->load->view('global/footer');
	}

	

	public function reportproduksikaos($value='')
	{
		$get = $this->input->get();
		if (empty($get)) {
			$viewData['produk'] = $this->GlobalModel->queryManual('SELECT * FROM `produksi_po` pp JOIN kelolapo_rincian_setor_cmt_finish kpp ON pp.kode_po=kpp.kode_po');
				$viewData['jenisKaos'] = $this->GlobalModel->getData('master_jenis_kaos',null);
		} else {
			$viewData['produk'] = $this->GlobalModel->queryManual('SELECT * FROM `produksi_po` pp JOIN kelolapo_rincian_setor_cmt_finish kpp ON pp.kode_po=kpp.kode_po WHERE '.$sql.' AND kpp.created_date >="'.$get['tanggalMulai'].'" AND kpp.created_date <="'.$get['tanggalAkhir'].'" ');
				$viewData['jenisKaos'] = $this->GlobalModel->getData('master_jenis_kaos',null);
		}
            $nol=0;$satutiga=0;$empatenam=0;$tujuhsembilan=0;$sepuluhduabelas=0;$tigabelaslimabelas=0;$enambelasdelapanbelas=0;$totalPiecePo=0;$atasanCount=0;$atasanCount2=0;
		foreach ($viewData['jenisKaos'] as $key => $jenis){
                    foreach ($viewData['produk'] as $key => $prod){
                        if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']){
                            if ($prod['rincian_size'] == "0"){
                                
                                $nol += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece']; 
                                $atasanCount2 += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                               
                                $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                            }
                        }
                    }
               
                    $atasanCount += $atasanCount2;   $nol;
                	
                foreach ($viewData['produk'] as $key => $prod){
                        if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']){
                            if ($prod['rincian_size'] == "1/3"){
                                @$satutiga += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                                $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                            }
                        }
                    }
               
                     $satutiga;
                
                 foreach ($viewData['produk'] as $key => $prod){
                        if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']){
                            if ($prod['rincian_size'] == "4/6"){
                                @$empatenam += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                                $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                            }
                        }
                    }
               
                     $empatenam;
                
                foreach ($viewData['produk'] as $key => $prod){
                        if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']){
                            if ($prod['rincian_size'] == "7/9"){
                                @$tujuhsembilan += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                                $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                            }
                        }
                    }
               
                     $tujuhsembilan;
                

                foreach ($viewData['produk'] as $key => $prod){
                        if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']){
                            if ($prod['rincian_size'] == "10/12"){
                                @$sepuluhduabelas += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                                $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                            }
                        }
                    }
               
                     $sepuluhduabelas;
                

                foreach ($viewData['produk'] as $key => $prod){
                        if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']){
                            if ($prod['rincian_size'] == "13/15"){
                                @$tigabelaslimabelas += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                                $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                            }
                        }
                    }
               
                     $tigabelaslimabelas;
                
                foreach ($viewData['produk'] as $key => $prod){
                    if ($prod['jenis_po'] == $jenis['nama_jenis_kaos']){
                        if ($prod['rincian_size'] == "16/18"){
                            $enambelasdelapanbelas += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                            $totalPiecePo += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
                        }
                    }
                }
               		
                $enambelasdelapanbelas;
                
                $viewData['piece'][$jenis['nama_jenis_kaos']] = $totalPiecePo;
            
        }
		$this->load->view('global/header');
		$this->load->view('report/report-produksi-kaos',$viewData);
		$this->load->view('global/footer');
	}

	/*
	public function laporanalokasicmt($value='')
	{
		$get = $this->input->get();
		$sql = '';
		if (!empty($get)) {
			$viewData['tanggal'] = $get;
			if (!empty($get['cmtKat'])) {
				$sql .= 'AND progress_lokasi="'.$get['cmtKat'].'"'; 
			}
			$viewData['kirim'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='7' ".$sql." ");
			$viewData['proses'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='8' ".$sql." ");
			$viewData['setor'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='9' ".$sql." ");
			$viewData['cmt']	= $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>$get['cmtKat']));

		} else {
			$viewData['kirim'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="7" AND progress_lokasi="JAHT" ');
			$viewData['proses'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="8" AND progress_lokasi="JAHT" ');
			$viewData['setor'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="9" AND progress_lokasi="JAHT" ');
			$viewData['cmt']	= $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'JAHIT'));
		}
		$viewData['jenisPo'] = $this->GlobalModel->queryManual('SELECT * FROM `master_jenis_po` ORDER BY `nama_jenis_po` ASC');
		$viewData['cpo']=count($viewData['jenisPo'])+1;
		 //pre($viewData['jenisPo']);
		$this->load->view('global/header');
		//$this->load->view('report/report-alokasi',$viewData);
		$this->load->view('report/monitoring_po',$viewData);
		$this->load->view('global/footer');
	}*/

	public function laporanalokasicmt($value='')
	{
		$get = $this->input->get();
		$sql = '';
		if (!empty($get)) {
			/*
			$viewData['tanggal'] = $get;
			if (!empty($get['cmtKat'])) {
				$sql .= 'AND progress_lokasi="'.$get['cmtKat'].'"'; 
			}
			$viewData['kirim'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='7' ".$sql." ");
			$viewData['proses'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='8' ".$sql." ");
			$viewData['setor'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='9' ".$sql." ");
			$viewData['cmt']	= $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>$get['cmtKat']));
			*/
		} else {
			$viewData['kirim'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="7" AND progress_lokasi="JAHT" ');
			$viewData['proses'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="8" AND progress_lokasi="JAHT" ');
			$viewData['setor'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="9" AND progress_lokasi="JAHT" ');
			//$viewData['cmt']	= $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'JAHIT'));
		}
		if(isset($get['cmtKat'])){
			$cmt=$get['cmtKat'];
		}else{
			$cmt='JAHIT';
		}
		$po = $this->GlobalModel->queryManual('SELECT * FROM `master_jenis_po` ORDER BY `nama_jenis_po` ASC');
		$cmt = $this->GlobalModel->queryManual("SELECT * FROM master_cmt WHERE cmt_job_desk='$cmt' ORDER BY cmt_name ASC ");
		foreach($po as $p){
			$viewData['jenisPo'][]=array(
				'nama_jenis_po'=>$p['nama_jenis_po'],
			);
		}
		$lpo=array();
		foreach($cmt as $c){
			$kirimpo=$this->GlobalModel->queryManual("SELECT kcpo.* FROM kirimcmt_po kcpo LEFT JOIN kirimcmt kc ON(kc.id=kcpo.idkirim) WHERE kc.idcmt='".$c['id_cmt']."' ");
			$viewData['cmt'][]=array(
				'idcmt'=>$c['id_cmt'],
				'cmt_name'=>$c['cmt_name'],
				'kpo'=>$kirimpo,
			);
		}
		$viewData['cpo']=count($viewData['jenisPo'])+1;
		//pre($viewData['cmt']);
		$this->load->view('global/header');
		$this->load->view('report/monitoring_po',$viewData);
		$this->load->view('global/footer');
	}

	public function monitoringpo($value='')
	{
		$get = $this->input->get();
		$sql = '';
		if (!empty($get)) {
			/*
			$viewData['tanggal'] = $get;
			if (!empty($get['cmtKat'])) {
				$sql .= 'AND progress_lokasi="'.$get['cmtKat'].'"'; 
			}
			$viewData['kirim'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='7' ".$sql." ");
			$viewData['proses'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='8' ".$sql." ");
			$viewData['setor'] = $this->GlobalModel->queryManual("SELECT * FROM produksi_po WHERE updated_date <='".$get['tanggalMulai']."' AND updated_date <='".$get['tanggalAkhir']."' AND id_proggresion_po='9' ".$sql." ");
			$viewData['cmt']	= $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>$get['cmtKat']));
			*/
		} else {
			$viewData['kirim'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="7" AND progress_lokasi="JAHT" ');
			$viewData['proses'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="8" AND progress_lokasi="JAHT" ');
			$viewData['setor'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po WHERE progress_lokasi="JAHIT" AND id_proggresion_po="9" AND progress_lokasi="JAHT" ');
			//$viewData['cmt']	= $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'JAHIT'));
		}
		if(isset($get['cmtKat'])){
			$cmt=$get['cmtKat'];
		}else{
			$cmt='JAHIT';
		}
		$po = $this->GlobalModel->queryManual('SELECT * FROM `master_jenis_po` ORDER BY `nama_jenis_po` ASC');
		$cmt = $this->GlobalModel->queryManual("SELECT * FROM master_cmt WHERE cmt_job_desk='$cmt' ORDER BY cmt_name ASC ");
		foreach($po as $p){
			$viewData['jenisPo'][]=array(
				'nama_jenis_po'=>$p['nama_jenis_po'],
			);
		}
		$lpo=array();
		foreach($cmt as $c){
			$kirimpo=$this->GlobalModel->queryManual("SELECT kcpo.* FROM kirimcmt_po kcpo LEFT JOIN kirimcmt kc ON(kc.id=kcpo.idkirim) WHERE kc.idcmt='".$c['id_cmt']."' ");
			$viewData['cmt'][]=array(
				'idcmt'=>$c['id_cmt'],
				'cmt_name'=>$c['cmt_name'],
				'kpo'=>$kirimpo,
			);
		}
		$viewData['cpo']=count($viewData['jenisPo'])+1;
		//pre($viewData['cmt']);
		$this->load->view('global/header');
		$this->load->view('report/monitoring_po',$viewData);
		$this->load->view('global/footer');
	}

}