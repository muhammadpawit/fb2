<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {


	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('GlobalModel');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
	}

	public function index(){
		$data=array();
		$data['allpo']=[];
		$allpo=[];
		$data['notifikasi']=array();
		$data['title']='Dashboard';
		$data['page']='newtheme/page/dashboard';
		//$data['notifikasi']=$this->GlobalModel->getData('notifikasi',array('status'=>0));
		$get=$this->input->get();
		$tanggal1='2021-05-25';
		$tanggal2=date('Y-m-d');
		$data['tanggal1']=date('d F Y',strtotime($tanggal1));
		$data['tanggal2']=date('d F Y',strtotime($tanggal2));

		$tanggals1=date('Y-m-d',strtotime("Monday previous week"));
		$tanggals2=date('Y-m-d',strtotime("Saturday previous week"));
		$data['tanggals1']=date('d F Y',strtotime($tanggals1));
		$data['tanggals2']=date('d F Y',strtotime($tanggals2));
		$tanggalm1=date('Y-m-d',strtotime("Monday previous week"));
		$tanggalm2=date('Y-m-d');


		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$setujui=akses($user['id_user'],3);
		}
		$data['setujui']=$setujui;
		$bulan=$this->ReportModel->month();
		$data['bulan']=json_encode($bulan);
		$po=$this->ReportModel->getPO(array());
		$kirimgudang=$this->ReportModel->getPOKirimGudang(array());
		$data['po']=($po);
		$data['getPOKirimGudang']=$kirimgudang;
		$data['rekap']=[];
		$arpo=array(
			array('type'=>'Kemeja','id'=>1,'color'=>'#32a852'),
			array('type'=>'Kaos','id'=>2,'color'=>'#3269a8'),
			array('type'=>'Celana','id'=>3,'color'=>'#cfc930'),
		);

		// potongan
		$npm=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter($arp['id'],$tanggalm1,$tanggalm2);
			$jmlpo=$this->ReportModel->ppcsjml_filter($arp['id'],$tanggalm1,$tanggalm2);
			$data['rekappotm'][]=array(
				'no'=>$npm,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'dz'=>$pdz/12,
				'pcs'=>$pdz,
				'po'=>round($jmlpo),
			);
			$npm++;
		}


		$np=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter($arp['id'],$tanggal1,$tanggal2);
			$jmlpo=$this->ReportModel->ppcsjml_filter($arp['id'],$tanggal1,$tanggal2);
			$data['rekappot'][]=array(
				'no'=>$np,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'dz'=>$pdz/12,
				'pcs'=>$pdz,
				'po'=>round($jmlpo),
			);
			$np++;
		}

		// end potongan

		// global finishing_kirim_gudang

		$ikg=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$data['rekapkg'][]=array(
				'no'=>$ikg,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'po'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggal1,$tanggal2),
				'total'=>$this->ReportModel->pcs_monitoring_kirimgudang_harga($arp['id'],$tanggal1,$tanggal2),
			);
			$ikg++;
		}

		
		$data['tanggalm1']=date('d F Y',strtotime($tanggalm1));
		$data['tanggalm2']=date('d F Y',strtotime($tanggalm2));
		$ikgm=1;
		foreach($arpo as $arp){
			$data['rekapkgmingguan'][]=array(
				'no'=>$ikgm,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'po'=>$this->ReportModel->count_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2),
				'dz'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2)/12,
				'pcs'=>$this->ReportModel->pcs_monitoring_kirimgudang($arp['id'],$tanggalm1,$tanggalm2),
				'total'=>$this->ReportModel->pcs_monitoring_kirimgudang_harga($arp['id'],$tanggalm1,$tanggalm2),
			);
			$ikgm++;
		}

		//end kirim gudang

		// global potongan
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs_filter_global($arp['id'],$tanggal1,$tanggal2);
			$data['pdzes'][]=array(
				'id'=>$arp['id'],
				'color'=>$arp['color'],
				'namapo'=>$arp['type'],
				'dz'=>$pdz/12,
				'ppcs'=>$pdz,
			);
		}
		$pdze=$this->ReportModel->getPotonganP();
		$data['pdze']=$pdze;
		if(myself()['nama_user']=="Pawits"){
			pre($data['pdzes']);
		}

		$u=$this->GlobalModel->queryManualRow("SELECT * FROM `konveksi_buku_potongan` ORDER BY created_date desc LIMIT 1");
		$data['updated']=$u['created_date'];
		
		$i=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$qty=$this->ReportModel->rpdashkirim($arp['id'],null,null);
			$qtysetor=$this->ReportModel->rpdashsetor($arp['id'],null,null);
			$ckirim=$this->ReportModel->countdashkirim($arp['id'],null,null);
			$csetor=$this->ReportModel->countdashsetor($arp['id'],null,null);
			$data['rekap'][]=array(
				'no'=>$i,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'countkirim'=>$ckirim,
				'qtykirimdz'=>($qty/12),
				'qtykirimpcs'=>($qty),
				'countsetor'=>$csetor,
				'qtysetordz'=>($qtysetor/12),
				'qtysetorpcs'=>($qtysetor),
				'keterangan'=>'PO Beredar : '.($ckirim-$csetor),
			);
			$i++;
		}

		$rm=1;
		foreach($arpo as $arp){
			$qty=$this->ReportModel->rpdashkirim($arp['id'],$tanggals1,$tanggals2);
			$qtysetor=$this->ReportModel->rpdashsetor($arp['id'],$tanggals1,$tanggals2);
			$ckirim=$this->ReportModel->countdashkirim($arp['id'],$tanggals1,$tanggals2);
			$csetor=$this->ReportModel->countdashsetor($arp['id'],$tanggals1,$tanggals2);
			$data['rekapmingguan'][]=array(
				'no'=>$rm,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'countkirim'=>$ckirim,
				'qtykirimdz'=>($qty/12),
				'qtykirimpcs'=>($qty),
				'countsetor'=>$csetor,
				'qtysetordz'=>($qtysetor/12),
				'qtysetorpcs'=>($qtysetor),
				'keterangan'=>'PO Beredar : '.($ckirim-$csetor),
			);
			$rm++;
		}

		$j=1;
		$pdz=0;
		$ppcs=0;
		$jmlpo=0;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcs($arp['id']);
			$jmlpo=$this->ReportModel->ppcsjml($arp['id']);
			$data['rekappotongan'][]=array(
				'no'=>$j,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'pdz'=>$pdz/12,
				'ppcs'=>$pdz,
				'jmlpo'=>$jmlpo,
			);
			$j++;
		}

		$k=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcsmingguan($arp['id'],$tanggal1,$tanggal2);
			$jmlpo=$this->ReportModel->ppcsjmlmingguan($arp['id'],$tanggal1,$tanggal2);
			$data['potmingguan'][]=array(
				'no'=>$k,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'pdz'=>$pdz/12,
				'ppcs'=>$pdz,
				'jmlpo'=>$jmlpo,
			);
			$k++;
		}
		
		if(callSessUser('nama_user')=='xPawit'){
			pre($data['potmingguan']);
		}

		$nomor=1;
		$sql="SELECT * FROM produksi_po WHERE hapus=0 and kode_po IN (SELECT kode_po FROM finishing_kirim_gudang ) ORDER BY kode_po ASC";
		$allpo=$this->GlobalModel->QueryManual($sql);
		//$allpo=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		foreach($allpo as $p){
			$data['allpo'][]=array(
				'no'=>$nomor,
				'namapo'=>strtoupper($p['kode_po']),
				'potong'=>$this->ReportModel->dashpotongpcs($p['kode_po']),
				'kirimgudang'=>$this->ReportModel->dashkirimgdgpcs($p['kode_po']),
			);
			$nomor++;
		}


		$njo=1;
		$data['request']=[];
		$sql="SELECT * FROM user_request WHERE hapus=0 and status=0 ";
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->queryManual($sql);
		$oto=null;
		foreach($results as $r){
			$data['request'][]=array(
				'no'=>$njo++,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'nama'=>strtolower($r['nama']),
				'keterangan'=>strtolower($r['keterangan']),
				'setujui'=>BASEURL.'User/accreq/'.$r['aksestable'].'/'.$r['userid'].'/'.$r['id'],
				'status'=>$r['status']==1?'sudah diproses':'belum diproses',
			);
		}

		$data['log']=[];
		$log=$this->GlobalModel->getData('log_user',array('hapus'=>0,'tanggal'=>date('Y-m-d')));
		
		foreach($log as $l){
			$oto=$this->GlobalModel->getData('user_request',array('userid'=>$l['userid'],'tanggal'=>date('Y-m-d')));
			$data['log'][]=array(
				'oto'=>count($oto),
				'nama'=>$l['nama'],
				'login'=>$l['login'],
				'logout'=>$l['logout'],
			);
		}

		$data['bulanberjalan']=date('F Y');
		$kbul=1;
		foreach($arpo as $arp){
			$pdz=$this->ReportModel->ppcsmingguan($arp['id'],date('Y-m-d',strtotime("first day of this month")),date('Y-m-d',strtotime("last day of this month")));
			$jmlpo=$this->ReportModel->ppcsjmlmingguan($arp['id'],date('Y-m-d',strtotime("first day of this month")),date('Y-m-d',strtotime("last day of this month")));
			$data['potbulanan'][]=array(
				'no'=>$kbul,
				'id'=>$arp['id'],
				'type'=>$arp['type'],
				'pdz'=>$pdz/12,
				'ppcs'=>$pdz,
				'jmlpo'=>$jmlpo,
			);
			$kbul++;
		}
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');
	}

	public function setujui($table,$id,$idnot){
		$this->db->update($table,array('status'=>1),array('id'=>$id));
		$this->db->update('notifikasi',array('status'=>1),array('id'=>$idnot));
		$this->session->set_flashdata('msgb','Pengajuan telah disetujui');
			redirect(BASEURL.'dash');
	}

	public function tolak($table,$id,$idnot){
		$this->db->update($table,array('status'=>2),array('id'=>$id));
		$this->db->update('notifikasi',array('status'=>1),array('id'=>$idnot));
		$this->session->set_flashdata('msgt','Pengajuan ditolak');
			redirect(BASEURL.'dash');
	}

	public function kasbonkaryawan(){
		$data=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'Keuangan/kasbonadd';
		$data['page']='newtheme/page/keuangan/kasbonacc';
		$data['products']=array();
		//pre(aksesedit());
		$results=$this->GlobalModel->getData('kasbon_acc',array('hapus'=>0));
		foreach($results as $result){
			$data['products'][]=array(
				'id'=>$result['id'],
				'tanggal'=>date('d/m/Y',strtotime($result['tanggal'])),
				'nama'=>$result['dibuat'],
				'status'=>$result['status'],
			);
		}
		
		$this->load->view('newtheme/page/main',$data);
	}

	public function kasbonview($id){
		$data=array();
		$data['n']=1;
		$data['i']=0;
		$data['kembali']=BASEURL.'Dash/kasbonkaryawan';
		$data['action']=BASEURL.'Dash/acckasbon';
		$data['page']='newtheme/page/keuangan/kasbondetail_setujui';
		$data['detail']=array();
		$data['acc']=$this->GlobalModel->getDataRow('kasbon_acc',array('id'=>$id,'hapus'=>0));
		$results=$this->GlobalModel->getData('kasbon',array('idacc'=>$id,'hapus'=>0));
		foreach($results as $result){
			$karyawan=$this->GlobalModel->getDataRow('karyawan',array('id'=>$result['idkaryawan']));
			$bagian=$this->GlobalModel->getDataRow('divisi',array('id'=>$result['bagian']));
			$data['detail'][]=array(
				'id'=>$result['id'],
				'tanggal'=>date('d/m/Y',strtotime($result['tanggal'])),
				'nama'=>$karyawan['nama'],
				'divisi'=>$bagian['nama'],
				'nominal'=>$result['nominal_request'],
				'nominal_acc'=>$result['nominal_acc'],
				'status'=>$result['status'],
			);
		}

		$this->load->view('newtheme/page/main',$data);
	}

	public function acckasbon(){
		$data=$this->input->post();
		foreach($data['products'] as $p){
			$update=array(
				'nominal_acc'=>$p['nominal_acc'],
				'status'=>1,
			);
			$this->db->update('kasbon',$update,array('id'=>$p['id']));
		}
		$this->db->update('kasbon_acc',array('status'=>1),array('id'=>$data['id']));
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'dash/kasbonkaryawan');
	}

	public function send(){
          
          kirim_email('muchlasmuchtar25@gmail.com','ini merupakan pengiriman email dari Sistem Forboys');

     }

    function wa(){
    	// Update the path below to your autoload.php, 
		// see https://getcomposer.org/doc/01-basic-usage.md 
		/*
		require_once '/path/to/vendor/autoload.php';  
		use Twilio\Rest\Client; 
		 
		$sid    = "AC934beb422aa9b180a5dbe5def6a0432d"; 
		$token  = "[AuthToken]"; 
		$twilio = new Client($sid, $token); 
 
				$message = $twilio->messages->create("whatsapp:+6281297386043", // to 
                           array( 
                               "from" => "whatsapp:+14155238886",       
                               "body" => "Hello! This is an editable text message. You are free to change it and write whatever you like." 
                           ) 
                  ); */
    }

    public function monitoring_progress(){
    	$data=[];
    	$nomors=1;
    	$get=$this->input->get();
    	if(isset($get['jenispo'])){
    		$data['jenispo']=$get['jenispo'];
    	}else{
    		$data['jenispo']=null;
    	}
    	$data['title']='Laporan Monitoring Proses Produksi Berjalan ';
    	$data['allpo']=[];
    	$data['allpos']=[];
		$allpo=[];
		$data['jenis']=$this->GlobalModel->GetData('master_jenis_po',array('tampil'=>1));
		$data['page']=$this->page.'report/all';
		$this->load->view('newtheme/page/main',$data);
    }

    	public function send_notify(){

	$title = "Ajuan Harian";
	$message = "Ini adalah Pemberitahuan";
	$icon = "https://forboysproduction.com/assets/images/0001.jpg";
	$url = "https://forboysproduction.com/";
	
	$apiKey = "3ec4684cd99956cffbc40780cc69bf33";

	$curlUrl = "https://api.pushalert.co/rest/v1/send";

	//POST variables
	$post_vars = array(
		"icon" => $icon,
		"title" => $title,
		"message" => $message,
		"url" => $url
	);

	$headers = Array();
	$headers[] = "Authorization: api_key=".$apiKey;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $curlUrl);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_vars));
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);

	$output = json_decode($result, true);
	if($output["success"]) {
		echo $output["id"]; //Sent Notification ID
	}
	else {
		//Others like bad request
	}

	}

	public function upload(){
				$id=$this->session->userdata('id_user');
				$size=$_FILES['gambar']['size'];
				$allowed = array('png', 'jpg','jpeg');
				$filename = $_FILES['gambar']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				if($size>2055000){
					$this->session->set_flashdata('gagal', 'Gagal Upload file. maksimal file size 2mb.');
					redirect(base_url() . "dash");
				}else{
					if (!in_array($ext, $allowed)) {
						$this->session->set_flashdata('gagal', 'Gagal Upload file. Silahkan pilih file berekstensi png/jpg');
						redirect(base_url() . "dash");
					}else{
						$folder='./assets/images/';
						$gambarstruktur=myself()['nama_user'].$_FILES['gambar']['name'];
						$tmp=$_FILES['gambar']['tmp_name'];
						move_uploaded_file($tmp,$folder.$gambarstruktur);
						$this->db->query("UPDATE user set foto='".$gambarstruktur."' WHERE id_user='".$id."' ");
						$this->session->set_flashdata('msg', 'Terimakasih telah mengupload file gambar anda.');
						redirect(base_url() . "dash");
					}
				}
				
	}
	
	public function notfound(){
		$data=[];
		$data['title']='Halaman tidak ditemukan';
		$this->load->view($this->page.'main',$data);		
	}


	public function alurproduksi(){
		$data=[];
		$data['title']='Alur Produksi';
		$data['page']=$this->page.'alur';
		$this->load->view($this->page.'main',$data);		
	}

	public function welcome(){
		$data['title']='welcome';
		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$setujui=akses($user['id_user'],3);
		}
		$data['setujui']=$setujui;
		$njo=1;
		$data['request']=[];
		$sql="SELECT * FROM user_request WHERE hapus=0 and status=0 ";
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->queryManual($sql);
		$oto=null;
		foreach($results as $r){
			$data['request'][]=array(
				'no'=>$njo++,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'nama'=>strtolower($r['nama']),
				'keterangan'=>strtolower($r['keterangan']),
				'setujui'=>BASEURL.'User/accreq/'.$r['aksestable'].'/'.$r['userid'].'/'.$r['id'],
				'status'=>$r['status']==1?'sudah diproses':'belum diproses',
			);
		}
		$data['page']=$this->page.'/dash/welcome';
		$this->load->view($this->page.'main',$data);
	}

	public function produksi2122(){
		redirect('https://2122.forboysproduction.com');
	}

	/** Bordir **/

	public function bordirharian(){
		$data=array();
		$data['n']=1;
		$data['action']=null;
		$data['title']=null;
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-1 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("-1 days"));
		}
		if(isset($get['nomesin'])){
			$nomesin=$get['nomesin'];
		}else{
			$nomesin=null;
		}
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'nomesin'=>$nomesin,
		);
		$products=$this->ReportModel->pendapatanbordirall($filter);
		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		$totalstich=0;
		$total018=0;
		$total02=0;
		$total015=0;
		$prev=null;
		$luar=0;
		$poluar=[];
		$globalstich=0;
		$g018=0;
		$g02=0;
		$g015=0;
		$gpendapatan=0;
		$total015=0;
		if(isset($get['cetak'])){
			$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11)";
		}else{
			$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11)";
		}
		
		if(!empty($nomesin)){
			$sm.=" AND nomor='$nomesin' ";
		}
		$mesin=$this->GlobalModel->QueryManual($sm);
		$data['luar']=[];
		$data['luar']=$this->GlobalModel->QueryManual("SELECT laporan_perkalian_tarif as perkalian FROM kelola_mesin_bordir WHERE jenis=2 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'  AND laporan_perkalian_tarif IS NOT NULL GROUP BY laporan_perkalian_tarif");
		
		foreach($mesin as $mes){
			$totalstich=$this->ReportModel->totalStich($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total018=$this->ReportModel->total018($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total02=$this->ReportModel->total02($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total015=$this->ReportModel->total015($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$jumlah=$this->ReportModel->jumlahpendapatanbordir($mes['nomor'],$tanggal1,$tanggal2);
			$globalstich+=($totalstich);
			$g018+=($total018);
			$g02+=($total02);
			$g015+=($total015);
			$gpendapatan+=($total018+$total02);
			$data['products'][]=array(
				'tanggal'=>null,
				'nomesin'=>$mes['nomor'],
				'shift'=>$mes['shift'],
				'stich'=>round($totalstich),
				'0.18'=>round($total018),
				'0.2'=>($total02),
				'0.18yn'=>0,
				'0.15'=>round($total015),
				'pendapatan'=>round($total018+$total02),
				'jumlah'=>round($jumlah),
				'i'=>$i++,
				'keterangan'=>null,
				'dets'=>$this->ReportModel->total02_array($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2),
			);
		}
		//pre($data['products']);
		$data['t']=$globalstich;
		$data['g018']=$g018;
		$data['g02']=$g02;
		$data['g015']=$g015;
		$data['gpendapatan']=$gpendapatan;

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['nomesin']=$nomesin;
		// rincian pendapatan dan pengeluaran

		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		foreach($products as $p){
			$totalpendapatan+=(((($p['total_stich']*0.18))+(0)));
		}
		$data['totalpendapatan']=($totalpendapatan);
				$totalpoluar=0;
		$totalpoluar=$this->ReportModel->getSumPendapatanpoluar($filter,2);
		$p15=0;
		$pe15=[];
		$pe15=$this->ReportModel->pendapatanbordirdalam15($filter,1);
		if(!empty($pe15)){
			foreach($pe15 as $p){
				$p15+=(((($p['total_stich']*0.15))+(0)));
			}
		}
		$data['p15']=($p15);
		$data['totalpoluar']=round($totalpoluar);
		$data['totalpen']=round($totalpendapatan+$totalpoluar+$p15);
		// end

		// pengeluaran bordir
		$sql="SELECT SUM(total) as total, keterangan FROM pengeluaran_bordir_detail WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" GROUP BY keterangan ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$nom=1;
		$data['pengeluarans']=[];
		$details=[];
		$totalpengeluaran=0;
		foreach($results as $r){
			//$details=$this->GlobalModel->Getdata('pengeluaran_bordir_detail',array('hapus'=>0,'idpengeluaran'=>$r['id']));
			$data['pengeluarans'][]=array(
				'no'=>$nom++,
				// 'id'=>$r['id'],
				// 'tanggal'=> date('d F Y',strtotime($r['tanggal'])),
				'total'=>$r['total'],
				'keterangan'=>$r['keterangan'],
				//'detail'=>$details,
			);
			$totalpengeluaran+=($r['total']);
		}

		$data['lababersih']=round(($totalpendapatan+$totalpoluar)-$totalpengeluaran);
		$data['page']=$this->page.'dash/bordirharian';
		$data['periode']='Hari '.hari(date('l',strtotime($tanggal1))) .', Tgl '. date('d F Y',strtotime($tanggal2));
		$data['judullap']='Laporan Pendapatan Harian Bordir ';
		$this->load->view($this->page.'main',$data);
	}

	public function bordirmingguan(){
		$data=array();
		$data['title']=null;
		$data['n']=1;
		$data['action']=null;
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("-1 days"));
		}
		if(isset($get['nomesin'])){
			$nomesin=$get['nomesin'];
		}else{
			$nomesin=null;
		}
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'nomesin'=>$nomesin,
		);
		$data['judullap']='Laporan Pendapatan Bordir Mingguan ';
		$data['periode']='Periode '.date('d',strtotime($tanggal1)) .'-'. date('d F Y',strtotime($tanggal2));
		$products=$this->ReportModel->pendapatanbordirall($filter);
		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		$totalstich=0;
		$total018=0;
		$total02=0;
		$total015=0;
		$prev=null;
		$luar=0;
		$poluar=[];
		$globalstich=0;
		$g018=0;
		$g02=0;
		$g015=0;
		$gpendapatan=0;
		$total015=0;
		if(isset($get['cetak'])){
			$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11)";
		}else{
			$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11) ";
		}
		
		if(!empty($nomesin)){
			$sm.=" AND nomor='$nomesin' ";
		}
		$mesin=$this->GlobalModel->QueryManual($sm);
		$data['luar']=[];
		$data['luar']=$this->GlobalModel->QueryManual("SELECT laporan_perkalian_tarif as perkalian FROM kelola_mesin_bordir WHERE jenis=2 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'  AND laporan_perkalian_tarif IS NOT NULL GROUP BY laporan_perkalian_tarif");
		
		foreach($mesin as $mes){
			$totalstich=$this->ReportModel->totalStich($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total018=$this->ReportModel->total018($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total02=$this->ReportModel->total02($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total015=$this->ReportModel->total015($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$jumlah=$this->ReportModel->jumlahpendapatanbordir($mes['nomor'],$tanggal1,$tanggal2);
			$globalstich+=($totalstich);
			$g018+=($total018);
			$g02+=($total02);
			$g015+=($total015);
			$gpendapatan+=($total018+$total02);
			$data['products'][]=array(
				'tanggal'=>null,
				'nomesin'=>$mes['nomor'],
				'shift'=>$mes['shift'],
				'stich'=>round($totalstich),
				'0.18'=>round($total018),
				'0.2'=>($total02),
				'0.18yn'=>0,
				'0.15'=>round($total015),
				'pendapatan'=>round($total018+$total02),
				'jumlah'=>round($jumlah),
				'i'=>$i++,
				'keterangan'=>null,
				'dets'=>$this->ReportModel->total02_array($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2),
			);
		}
		//pre($data['products']);
		$data['t']=$globalstich;
		$data['g018']=$g018;
		$data['g02']=$g02;
		$data['g015']=$g015;
		$data['gpendapatan']=$gpendapatan;

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['nomesin']=$nomesin;
		// rincian pendapatan dan pengeluaran

		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		foreach($products as $p){
			$totalpendapatan+=(((($p['total_stich']*0.18))+(0)));
		}
		$data['totalpendapatan']=($totalpendapatan);
				$totalpoluar=0;
		$totalpoluar=$this->ReportModel->getSumPendapatanpoluar($filter,2);
		$p15=0;
		$pe15=[];
		$pe15=$this->ReportModel->pendapatanbordirdalam15($filter,1);
		if(!empty($pe15)){
			foreach($pe15 as $p){
				$p15+=(((($p['total_stich']*0.15))+(0)));
			}
		}
		$data['p15']=($p15);
		$data['totalpoluar']=round($totalpoluar);
		$data['totalpen']=round($totalpendapatan+$totalpoluar+$p15);
		// end

		// pengeluaran bordir
		$sql="SELECT SUM(total) as total, keterangan FROM pengeluaran_bordir_detail WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" GROUP BY keterangan ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$nom=1;
		$data['pengeluarans']=[];
		$details=[];
		$totalpengeluaran=0;
		foreach($results as $r){
			//$details=$this->GlobalModel->Getdata('pengeluaran_bordir_detail',array('hapus'=>0,'idpengeluaran'=>$r['id']));
			$data['pengeluarans'][]=array(
				'no'=>$nom++,
				// 'id'=>$r['id'],
				// 'tanggal'=> date('d F Y',strtotime($r['tanggal'])),
				'total'=>$r['total'],
				'keterangan'=>$r['keterangan'],
				//'detail'=>$details,
			);
			$totalpengeluaran+=($r['total']);
		}

		$data['lababersih']=round(($totalpendapatan+$totalpoluar)-$totalpengeluaran);
		$data['page']=$this->page.'dash/bordirharian';
		$this->load->view($this->page.'main',$data);
	}

	public function bordirbulanan(){
		$data=array();
		$data['title']=null;
		$data['n']=1;
		$data['action']=null;
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of previous month"));
		}
		if(isset($get['nomesin'])){
			$nomesin=$get['nomesin'];
		}else{
			$nomesin=null;
		}
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'nomesin'=>$nomesin,
		);
		$data['judullap']='Laporan Pendapatan Bordir Bulanan ';
		$data['periode']='Periode '.date('d',strtotime($tanggal1)) .'-'. date('d F Y',strtotime($tanggal2));
		$products=$this->ReportModel->pendapatanbordirall($filter);
		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		$totalstich=0;
		$total018=0;
		$total02=0;
		$total015=0;
		$prev=null;
		$luar=0;
		$poluar=[];
		$globalstich=0;
		$g018=0;
		$g02=0;
		$g015=0;
		$gpendapatan=0;
		$total015=0;
		if(isset($get['cetak'])){
			$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11)";
		}else{
			$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11) ";
		}
		
		if(!empty($nomesin)){
			$sm.=" AND nomor='$nomesin' ";
		}
		$mesin=$this->GlobalModel->QueryManual($sm);
		$data['luar']=[];
		$data['luar']=$this->GlobalModel->QueryManual("SELECT laporan_perkalian_tarif as perkalian FROM kelola_mesin_bordir WHERE jenis=2 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'  AND laporan_perkalian_tarif IS NOT NULL GROUP BY laporan_perkalian_tarif");
		
		foreach($mesin as $mes){
			$totalstich=$this->ReportModel->totalStich($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total018=$this->ReportModel->total018($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total02=$this->ReportModel->total02($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$total015=$this->ReportModel->total015($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2);
			$jumlah=$this->ReportModel->jumlahpendapatanbordir($mes['nomor'],$tanggal1,$tanggal2);
			$globalstich+=($totalstich);
			$g018+=($total018);
			$g02+=($total02);
			$g015+=($total015);
			$gpendapatan+=($total018+$total02);
			$data['products'][]=array(
				'tanggal'=>null,
				'nomesin'=>$mes['nomor'],
				'shift'=>$mes['shift'],
				'stich'=>round($totalstich),
				'0.18'=>round($total018),
				'0.2'=>($total02),
				'0.18yn'=>0,
				'0.15'=>round($total015),
				'pendapatan'=>round($total018+$total02),
				'jumlah'=>round($jumlah),
				'i'=>$i++,
				'keterangan'=>null,
				'dets'=>$this->ReportModel->total02_array($mes['nomor'],$mes['shift'],$tanggal1,$tanggal2),
			);
		}
		//pre($data['products']);
		$data['t']=$globalstich;
		$data['g018']=$g018;
		$data['g02']=$g02;
		$data['g015']=$g015;
		$data['gpendapatan']=$gpendapatan;

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['nomesin']=$nomesin;
		// rincian pendapatan dan pengeluaran

		$jumlah=0;
		$i=0;
		$j=array();
		$totalpendapatan=0;
		foreach($products as $p){
			$totalpendapatan+=(((($p['total_stich']*0.18))+(0)));
		}
		$data['totalpendapatan']=($totalpendapatan);
				$totalpoluar=0;
		$totalpoluar=$this->ReportModel->getSumPendapatanpoluar($filter,2);
		$p15=0;
		$pe15=[];
		$pe15=$this->ReportModel->pendapatanbordirdalam15($filter,1);
		if(!empty($pe15)){
			foreach($pe15 as $p){
				$p15+=(((($p['total_stich']*0.15))+(0)));
			}
		}
		$data['p15']=($p15);
		$data['totalpoluar']=round($totalpoluar);
		$data['totalpen']=round($totalpendapatan+$totalpoluar+$p15);
		// end

		// pengeluaran bordir
		$sql="SELECT SUM(total) as total, keterangan FROM pengeluaran_bordir_detail WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" GROUP BY keterangan ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$nom=1;
		$data['pengeluarans']=[];
		$details=[];
		$totalpengeluaran=0;
		foreach($results as $r){
			//$details=$this->GlobalModel->Getdata('pengeluaran_bordir_detail',array('hapus'=>0,'idpengeluaran'=>$r['id']));
			$data['pengeluarans'][]=array(
				'no'=>$nom++,
				// 'id'=>$r['id'],
				// 'tanggal'=> date('d F Y',strtotime($r['tanggal'])),
				'total'=>$r['total'],
				'keterangan'=>$r['keterangan'],
				//'detail'=>$details,
			);
			$totalpengeluaran+=($r['total']);
		}

		$data['lababersih']=round(($totalpendapatan+$totalpoluar)-$totalpengeluaran);

		$data['page']=$this->page.'dash/bordirharian';
		$this->load->view($this->page.'main',$data);
	}

	public function bordirbulanan_(){
		$data=[];
		$data['title']='Grafik Pendapatan Mesin Bordir Bulanan';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 day"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$po=$this->ReportModel->getPO(array());
		$kirimgudang=$this->ReportModel->getPOKirimGudang(array());
		$data['po']=($po);
		$bulan=$this->ReportModel->month();
		$data['bulan']=json_encode($bulan);
		$data['jml']=$this->ReportModel->grafikpendapatanbordirbulanan(array());
		$data['jmls']=$this->ReportModel->bordirbulanan(array());
		// pre($data['jml']);
		$data['pr']=[];
		foreach($data['jmls'] as $s){
			$monthNum  = $s['bulan'];
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			if($s['total']>0){
				$data['pr'][]=array(
					'bulan'=>$dateObj->format('F'),
					'tahun'=>$s['tahun'],
					'nominal'=>$s['total'],
				);
			}
		}
		//pre($data['pr']);
		$data['page']=$this->page.'dash/bordirbulanan';
		$this->load->view($this->page.'main',$data);
	}





	/** end bordir **/

	public function Laporanharianbahan(){
		$data=[];
		$data['title']='Laporan Harian Bahan';
		$pi=$this->GlobalModel->QueryManualRow("SELECT * FROM penerimaan_item WHERE hapus=0 AND lower(keterangan)='bahan masuk' ORDER BY tanggal DESC LIMIT 1 ");
		$bk=$this->GlobalModel->QueryManualRow("SELECT * FROM barangkeluar_harian WHERE hapus=0 AND jenis=3 ORDER BY tanggal DESC LIMIT 1 ");

		$pidate = strtotime($pi['tanggal']);
		$bkdate = strtotime($bk['tanggal']);
		if($pidate>$bkdate){
			$update=$pi['tanggal'];
		}else{
			$update=$bk['tanggal'];
		}
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=$update;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=$update;
		}

		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=4;
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
		}else{
			$kategori=null;
		}

		if(isset($get['supplier'])){
			$supplier=$get['supplier'];
		}else{
			$supplier=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['kategori']=$kategori;
		$data['update']=$update;
		//pre($pidate. '  bk ' .$bkdate);
		$sql="SELECT gpi.* , p.kategori FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) WHERE gpi.hapus=0 ";
		if(!empty($jenis)){
			$sql.=" AND p.jenis='".$jenis."'";
		}
		if(!empty($kategori)){
			$sql.=" AND p.kategori='".$kategori."'";
		}
		if(!empty($supplier)){
			$sql.=" AND gpi.supplier='".$supplier."'";
		}
		//$sql.=" GROUP BY p.nama ASC ,p.product_id ,p.kategori ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($results);
		$no=1;
		$no2=1;
		$no3=1;
		$stokawal=[];
		$stokmasuk=[];
		$stokkeluar=[];
		$stokakhirroll=0;
		$stokakhiryard=0;
		$stokakhirharga=0;
		$warna=null;
		$data['prods']=[];
		foreach($results as $row){
			$stokawal=$this->ReportModel->stokawal($row['id_persediaan'],$tanggal1);
			$stokmasuk=$this->ReportModel->stokmasuk($row['id_persediaan'],$tanggal1,$tanggal2);
			$stokkeluar=$this->ReportModel->stokkeluar($row['id_persediaan'],$tanggal1,$tanggal2);
			//if($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll']) > 0){
				
				if($row['kategori']==15){
					$data['kaos'][]=array(
						'no'=>$no++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);
				}
				
				if($row['kategori']==16){
					$data['celana'][]=array(
						'no'=>$no2++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);
				}

				if($row['kategori']==17){
					$data['kemeja'][]=array(
						'no'=>$no3++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);	
				}
				
			//}
		}
		
		//pre($data['kemeja']);
		$data['supplier']=$this->GlobalModel->GetData('master_supplier',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanbulananbahan_excel',$data);	
		}else{
			$data['page']=$this->page.'dash/laporanbulananbahan';
			$this->load->view($this->layout,$data);	
		}
		
	}

	public function laporanmingguanbahan(){
		$data=[];
		$data['title']='Laporan Mingguan Bahan';
		$pi=$this->GlobalModel->QueryManualRow("SELECT * FROM penerimaan_item WHERE hapus=0 AND lower(keterangan)='bahan masuk' ORDER BY tanggal DESC LIMIT 1 ");
		$bk=$this->GlobalModel->QueryManualRow("SELECT * FROM barangkeluar_harian WHERE hapus=0 AND jenis=3 ORDER BY tanggal DESC LIMIT 1 ");

		$pidate = strtotime($pi['tanggal']);
		$bkdate = strtotime($bk['tanggal']);
		if($pidate>$bkdate){
			$update=$pi['tanggal'];
		}else{
			$update=$bk['tanggal'];
		}
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('monday this week'));;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}

		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=4;
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
		}else{
			$kategori=null;
		}

		if(isset($get['supplier'])){
			$supplier=$get['supplier'];
		}else{
			$supplier=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['kategori']=$kategori;
		$data['update']=$update;
		//pre($pidate. '  bk ' .$bkdate);
		$sql="SELECT gpi.* , p.kategori FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) WHERE gpi.hapus=0 ";
		if(!empty($jenis)){
			$sql.=" AND p.jenis='".$jenis."'";
		}
		if(!empty($kategori)){
			$sql.=" AND p.kategori='".$kategori."'";
		}
		if(!empty($supplier)){
			$sql.=" AND gpi.supplier='".$supplier."'";
		}
		//$sql.=" GROUP BY p.nama ASC ,p.product_id ,p.kategori ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($results);
		$no=1;
		$no2=1;
		$no3=1;
		$stokawal=[];
		$stokmasuk=[];
		$stokkeluar=[];
		$stokakhirroll=0;
		$stokakhiryard=0;
		$stokakhirharga=0;
		$warna=null;
		$data['prods']=[];
		foreach($results as $row){
			$stokawal=$this->ReportModel->stokawal($row['id_persediaan'],$tanggal1);
			$stokmasuk=$this->ReportModel->stokmasuk($row['id_persediaan'],$tanggal1,$tanggal2);
			$stokkeluar=$this->ReportModel->stokkeluar($row['id_persediaan'],$tanggal1,$tanggal2);
			//if($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll']) > 0){
				
				if($row['kategori']==15){
					$data['kaos'][]=array(
						'no'=>$no++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);
				}
				
				if($row['kategori']==16){
					$data['celana'][]=array(
						'no'=>$no2++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);
				}

				if($row['kategori']==17){
					$data['kemeja'][]=array(
						'no'=>$no3++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);	
				}
				
			//}
		}
		
		//pre($data['kemeja']);
		$data['supplier']=$this->GlobalModel->GetData('master_supplier',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanbulananbahan_excel',$data);	
		}else{
			$data['page']=$this->page.'dash/laporanbulananbahan';
			$this->load->view($this->layout,$data);	
		}
		
	}

	public function Laporanbulananbahan(){
		$data=[];
		$data['title']='Laporan Bulanan Stok Bahan';
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

		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=4;
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
		}else{
			$kategori=null;
		}

		if(isset($get['supplier'])){
			$supplier=$get['supplier'];
		}else{
			$supplier=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['kategori']=$kategori;
		$data['trans']=[];
		$pi=$this->GlobalModel->QueryManualRow("SELECT * FROM penerimaan_item WHERE hapus=0 AND lower(keterangan)='bahan masuk' ORDER BY tanggal DESC LIMIT 1 ");
		$bk=$this->GlobalModel->QueryManualRow("SELECT * FROM barangkeluar_harian WHERE hapus=0 AND jenis=3 ORDER BY tanggal DESC LIMIT 1 ");
		
		$pidate = strtotime($pi['tanggal']);
		$bkdate = strtotime($bk['tanggal']);
		if($pidate>$bkdate){
			$update=$pi['tanggal'];
				$data['trans']=array(
					'keterangan'=>$pi['keterangan'],
				);
		}else{
			$update=$bk['tanggal'];
				$data['trans']=array(
					'keterangan'=>'Keluar Bahan untuk po '.$bk['keterangan'].' pengambil '.$bk['pengambil'].' tanggal '.date('d F Y',strtotime($bk['tanggal'])),
				);
		}
		//pre($bk);
		$data['update']=$update;
		//pre($pidate. '  bk ' .$bkdate);
		$sql="SELECT gpi.* , p.kategori FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) WHERE gpi.hapus=0 ";
		if(!empty($jenis)){
			$sql.=" AND p.jenis='".$jenis."'";
		}
		if(!empty($kategori)){
			$sql.=" AND p.kategori='".$kategori."'";
		}
		if(!empty($supplier)){
			$sql.=" AND gpi.supplier='".$supplier."'";
		}
		$sql.=" GROUP BY p.nama ASC ,p.kategori ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$no=1;
		$no2=1;
		$no3=1;
		$stokawal=[];
		$stokmasuk=[];
		$stokkeluar=[];
		$stokakhirroll=0;
		$stokakhiryard=0;
		$stokakhirharga=0;
		$warna=null;
		$data['prods']=[];
		foreach($results as $row){
			$stokawal=$this->ReportModel->stokawal($row['id_persediaan'],$tanggal1);
			$stokmasuk=$this->ReportModel->stokmasuk($row['id_persediaan'],$tanggal1,$tanggal2);
			$stokkeluar=$this->ReportModel->stokkeluar($row['id_persediaan'],$tanggal1,$tanggal2);
			if($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll']) > 0){
				
				if($row['kategori']==15){
					$data['kaos'][]=array(
						'no'=>$no++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);
				}
				
				if($row['kategori']==16){
					$data['celana'][]=array(
						'no'=>$no2++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);
				}

				if($row['kategori']==17){
					$data['kemeja'][]=array(
						'no'=>$no3++,
						'nama'	=>strtolower($row['nama_item']),
						'warna'	=>strtolower($row['warna_item']),
						'kode'=>null,
						//'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalroll'=>empty($stokawal['roll'])?0:$stokawal['roll'],
						'stokawalyard'=>empty($stokawal['yard'])?0:$stokawal['yard'],
						'stokawalharga'=>$row['harga_item'],
						'stokmasukroll'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
						'stokmasukyard'=>empty($stokmasuk['yard'])?0:$stokmasuk['yard'],
						'stokmasukharga'=>$row['harga_item'],
						'stokkeluarroll'=>empty($stokkeluar['roll'])?0:$stokkeluar['roll'],
						'stokkeluaryard'=>empty($stokkeluar['yard'])?0:$stokkeluar['yard'],
						'stokkeluarharga'=>$row['harga_item'],
						'stokakhirroll'=>($stokawal['roll']+($stokmasuk['roll']-$stokkeluar['roll'])),
						'stokakhiryard'=>($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard'])),
						'stokakhirharga'=>$row['harga_item'],
						'total'=>round($row['harga_item']*($stokawal['yard']+($stokmasuk['yard']-$stokkeluar['yard']))),
						'ket'=>null,
					);	
				}
				
			}
		}
		
		$data['supplier']=$this->GlobalModel->GetData('master_supplier',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'laporanbulananbahan_excel',$data);	
		}else{
			$data['page']=$this->page.'dash/laporanbulananbahan';
			$this->load->view($this->layout,$data);	
		}
		
	}


	public function klolaporanbulananpotongan(){
		$data=[];
		$data['title']='Laporan Potongan Bulanan';
		$get=$this->input->get();
		$data['jenis']=[];
		$results=array();
		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=date('n',strtotime("-1 month"));
		}
		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=date('Y');
		}
		$data['bulan']=$bulan;
		$data['tahun']=$tahun;

		$jenis=$this->GlobalModel->QueryManual("SELECT * FROM master_jenis_po WHERE nama_jenis_po IN (SELECT SUBSTR(kode_po,1, 3) AS po FROM konveksi_buku_potongan ) ");
		$tim=$this->GlobalModel->QueryManual("SELECT * FROM timpotong WHERE id IN (SELECT tim_potong_potongan FROM konveksi_buku_potongan WHERE hapus=0 AND MONTH(created_date)='".$bulan."' AND YEAR(created_date)='".$tahun."' ) ");
		$prods=[];
		$jml=[];
		$no=1;

		$noh=1;
		$data['bupot']=[];
		$timptg=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$detbupot=[];
		foreach($tim as $t){
			$detbupot=$this->ReportModel->bukupotongan_bulanan($t['id'],$bulan,$tahun);
			$data['bupot'][]=array(
				
				'nama'=>$t['nama'],
				'dets'=>$detbupot
			);
		}
		
		$data['page']='newtheme/page/laporantimpotong/bulanan';
		$this->load->view($this->layout,$data);
	}

}