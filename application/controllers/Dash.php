<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dash extends CI_Controller {


	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->load->model('ReportModel');
		$this->load->model('GlobalModel');
		$this->page='newtheme/page/';
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
    	$data['allpo']=[];
    	$data['allpos']=[];
		$allpo=[];
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
		$this->load->view($this->page.'main',$data);
	}


}