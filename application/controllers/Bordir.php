<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->load->model('ReportModel');
		$this->load->model('M_potonganoperator');
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function gajibuangbenang(){
		$data=[];
		$data['title']='Gaji Buang Benang Bordir';
		$data['products']=array();
		$no=1;
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM kelolapo_buang_benang WHERE hapus=0";
		$sql.=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$buangbenang=$this->GlobalModel->QueryManual($sql);
		foreach($buangbenang as $result){
			$pekerja=$this->GlobalModel->getDataRow('master_karyawan_benang',array('id_master_karyawan_benang'=>$result['nama_pekerja']));
			$data['products'][]=array(
				'no'=>$no++,
				'id_kelolapo_buang_benang'=>$result['id_kelolapo_buang_benang'],
				'kode_po'=>$result['kode_po'],
				'bagian'=>$result['bagian_buang_benang'],
				'size'=>$result['size_buang_benang'],
				'qty'=>$result['qty_buang_benang'],
				'harga'=>$result['harga_buang_benan'],
				'total'=>($result['qty_buang_benang']*$result['harga_buang_benan']),
				'keterangan'=>$result['keterangan_buang_benang'],
				'pekerja'=>$pekerja['nama_karyawan_benang'],
				'nama_pekerja'=>$result['nama_pekerja'],
				'tanggal'=>date('d/m/Y',strtotime($result['created_date'])),
			);
		}
		//$data['page']='newtheme/page/bordir/buangbenang_list';
		if(isset($get['excel'])){
			$dpekerja=[];
			$pekerja=$this->GlobalModel->QueryManual("SELECT * FROM master_karyawan_benang WHERE id_master_karyawan_benang IN(SELECT nama_pekerja FROM kelolapo_buang_benang WHERE hapus=0 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
			$ps=[];
			$tot=[];
			foreach($pekerja as $p){
				$ps=$this->GlobalModel->QueryManual("SELECT * FROM kelolapo_buang_benang kbb WHERE hapus=0 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and nama_pekerja='".$p['id_master_karyawan_benang']."' ");
				$tot=$this->GlobalModel->QueryManualRow("SELECT SUM(qty_buang_benang*harga_buang_benan) as total FROM kelolapo_buang_benang kbb WHERE hapus=0 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and nama_pekerja='".$p['id_master_karyawan_benang']."' ");
				$rek2=$this->GlobalModel->QueryManual("SELECT SUM(qty_buang_benang) AS total, kode_po,bagian_buang_benang,nama_pekerja FROM kelolapo_buang_benang WHERE hapus=0 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and nama_pekerja='".$p['id_master_karyawan_benang']."' GROUP BY kode_po,bagian_buang_benang ");
				$data['pekerja'][]=array(
					'pekerja'=>$p['nama_karyawan_benang'],
					'products'=>$ps,
					'rek2'=>$rek2,
					'total'=>$tot['total'],
				);
			}
			$rekap=$this->GlobalModel->QueryManual("SELECT * FROM master_karyawan_benang WHERE id_master_karyawan_benang IN(SELECT nama_pekerja FROM kelolapo_buang_benang WHERE hapus=0 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
			$tr=0;
			foreach($rekap as $r){
				$tr=$this->GlobalModel->QueryManualRow("SELECT SUM(qty_buang_benang*harga_buang_benan) as total FROM kelolapo_buang_benang WHERE  hapus=0 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and nama_pekerja='".$r['id_master_karyawan_benang']."' ");
				$data['rekap'][]=array(
					'nama_karyawan_benang'=>$r['nama_karyawan_benang'],
					'total'=>$tr['total'],
					'totalpembulatan'=>pembulatangaji($tr['total']),
				);
			}
			$this->load->view($this->page.'bordir/buangbenangexcel',$data);	
		}else{
			$data['page']=$this->page.'bordir/gajibuangbenangbordir';
			$this->load->view($this->page.'main',$data);	
		}
		
	}

	public function targetmesin(){
		$data=[];
		$data['title']='Table Target Mesin';
		$data['products']=[];
		$results=[];
		$type=array(array('type'=>'1','no'=>'1,2,5,6,7,8,9,10'),array('type'=>'2','no'=>'3,4'));
		$data['products']=array(
			'mesin1'=>$this->GlobalModel->queryManual("SELECT * FROM `target_mesin` WHERE no_mesin IN(1,2,5,6,7,8,9,10)"),
			'mesin2'=>$this->GlobalModel->queryManual("SELECT * FROM `target_mesin` WHERE no_mesin IN(3,4)"),
		);
		$data['page']=$this->page.'bordir/targetmesin_table';
		$this->load->view($this->page.'main',$data);
	}

	public function gajioperator(){
		$data=[];
		$data['title']='Resume Gaji Karyawan operator Forboys';
		$data['products']=[];
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
		$sql="SELECT * FROM gaji_operator WHERE hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tempat'=>$r['tempat']==1?'Rumah':'Cipadu',
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Bordir/operatorbordirdetail/'.$r['id'],
				'excel'=>BASEURL.'Bordir/operatorbordirdetail/'.$r['id'].'?&excel=1',
				'hapus'=>BASEURL.'Bordir/hapusgajioperator/'.$r['id'],
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Bordir/gajioperatoradd';
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
			
			//$results=$this->GlobalModel->getData('gaji_operator_new',array('hapus'=>0,'idgajiopt'=>$id));
			$results=$this->GlobalModel->QueryManual("SELECT * FROM gaji_operator_new WHERE hapus=0 AND idgajiopt='".$id."' ORDER BY shift asc");
			foreach($results as $r){
				$data['karyawans'][]=array(
					'tgl1'=>$data['gaji']['tanggal1'],
					'tgl2'=>$data['gaji']['tanggal2'],
					'idkaryawan' =>$r['idkaryawan'],
					'nama'=>$r['nama'],
					'shift'=>$r['shift']==1?'PAGI':'MALAM',
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
			//$data['ummalam']=!empty($ummalam)?21000:0;
			//pre(count($this->ReportModel->getMandor($id,2)));
			$man=$this->ReportModel->getMandor_c($id,2);
			$data['ummalam']=(21000*$man);
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

	public function gajioperatoradd(){
		$data=[];
		$data['title']='Gaji Operator Bordir';
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

		if(isset($get['tempat'])){
			$tempat=$get['tempat'];
		}else{
			$tempat=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tempat']=$tempat;
		$data['prods']=[];
		$karyawan=[];
		if(!empty($tempat)){
			if($tempat==1){
				$mesin='1,2,3,4,5,6';
			}else{
				$mesin='7,8,9,10';
			}
			$karyawan=$this->GlobalModel->QueryManual("SELECT * FROM master_karyawan_bordir WHERE gaji=1 AND hapus=0 AND id_master_karyawan_bordir IN(SELECT nama_operator FROM kelola_mesin_bordir WHERE hapus=0 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND mesin_bordir IN (".$mesin.") ) ");
			$data['harian']=[];
			foreach($karyawan as $k){
				$data['prods'][]=array(
					'id'=>$k['id_master_karyawan_bordir'],
					'nama'=>$k['nama_karyawan_bordir'],
					'hari'=>$this->ReportModel->gaji_opt($k['id_master_karyawan_bordir'],$tanggal1,$tanggal2,$tempat),
				);
			}
		}
		//pre($data['prods']);
		$data['action']=BASEURL.'Bordir/gajioperatorsave';
		$data['batal']=BASEURL.'Bordir/gajioperator';
		$data['page']=$this->page.'bordir/gaji_operator_new';
		$this->load->view($this->page.'main',$data);
	}

	public function gajioperatoradd_old(){
		$data=[];
		$data['title']='Gaji Operator Bordir';
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

		if(isset($get['tempat'])){
			$tempat=$get['tempat'];
		}else{
			$tempat=null;
		}


		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tempat']=$tempat;
		$data['karyawan']=$this->GlobalModel->getData('master_karyawan_bordir',array('hapus'=>0));
		$data['harian']=[];
		//$results=$this->GlobalModel->getData('master_karyawan_bordir',array('hapus'=>0));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM master_karyawan_bordir WHERE hapus=0 and id_master_karyawan_bordir IN(SELECT abd.idkaryawan FROM absensi_bordir_detail abd JOIN absensi_bordir ab ON (ab.id=abd.idabsensi) WHERE date(abd.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND abd.hapus=0 and ab.tempat='".$tempat."' )");
		$bonus=0;
		$um=0;
		$det=[];
		$backup=1;
		$mes=null;
		if(isset($get['kalkulasi'])){
			foreach($results as $r){
				$bonus=$this->ReportModel->bonusoperatorbordir($r['id_master_karyawan_bordir'],$tanggal1,$tanggal2,$tempat);
				$um=$this->ReportModel->getumbordir($r['id_master_karyawan_bordir'],$tanggal1,$tanggal2,$tempat);
				$det=$this->GlobalModel->QueryManual("SELECT abd.*,ab.shift FROM absensi_bordir_detail abd JOIN absensi_bordir ab ON (ab.id=abd.idabsensi) where abd.hapus=0 and ab.tempat='".$tempat."' and abd.idkaryawan='".$r['id_master_karyawan_bordir']."' AND DATE(abd.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' Group BY tanggal order By abd.tanggal, abd.bonus DESC");
				//$b=$this->GlobalModel->QueryManualRow("SELECT count(*) as total FROM absensi_bordir_detail WHERE hapus=0 AND idkaryawan='".$r['id_master_karyawan_bordir']."' AND DATE(tanggal) ='".$tanggal1."' ");
				if(!empty($b)){
					$backup=$b['total'];
					$mes=$b['mesin'];
				}
				$data['harian'][]=array(
					'id_master_karyawan_bordir'=>$r['id_master_karyawan_bordir'],
					'nama_karyawan_bordir'=>$r['nama_karyawan_bordir'],
					'backup'=>$backup,
					'mess'=>$mes,
					'karyawan_gaji_weekday'=>$r['karyawan_gaji_weekday'],
					'bonus'=>$bonus==null?0:$bonus,
					'details'=>$det,
					'um'=>$um,
					'sql'=>'SELECT * FROM absensi_bordir_detail where idkaryawan='.$r['id_master_karyawan_bordir'].' AND DATE(tanggal) BETWEEN '.$tanggal1.' AND '.$tanggal2.' order By tanggal ',
				);
			}
		}
		//pre($data['harian']);
		
		$data['action']=BASEURL.'Bordir/gajioperatorsave';
		$data['batal']=BASEURL.'Bordir/gajioperator';
		$data['page']=$this->page.'bordir/gaji_operator';
		$this->load->view($this->page.'main',$data);
	}


	public function gajioperatorsave(){
		$data=$this->input->post();
		//pre($data);
		$cek=$this->GlobalModel->getDataRow('gaji_operator',array('tanggal1'=>$data['tanggal1'],'hapus'=>0,'tempat'=>$data['tempat']));
		
		if(!empty($cek)){
			$this->session->set_flashdata('msgt','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Bordir/gajioperator');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'tempat'=>$data['tempat'],
			'hapus'=>0,
		);
		$this->db->insert('gaji_operator',$insert);
		$id=$this->db->insert_id();
		$totalgaji=0;
		$totalum=0;
		$totalbonus=0;
		$potclaim=0;
		$potpinjaman=0;
		$grandtotal=0;
		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){
				$sabtu=isset($p['gajisabtu'])?$p['gajisabtu']:0;
				$minggu=isset($p['gajiminggu'])?$p['gajiminggu']:0;
				$senin=isset($p['gajisenin'])?$p['gajisenin']:0;
				$selasa=isset($p['gajiselasa'])?$p['gajiselasa']:0;
				$rabu=isset($p['gajirabu'])?$p['gajirabu']:0;
				$kamis=isset($p['gajikamis'])?$p['gajikamis']:0;
				$jumat=isset($p['gajijumat'])?$p['gajijumat']:0;
				//$totalgaji=($minggu+$senin+$selasa+$rabu+$kamis+$jumat+$sabtu);

				$umsabtu=isset($p['umsabtu'])?$p['umsabtu']:0;
				$umminggu=isset($p['umminggu'])?$p['umminggu']:0;
				$umsenin=isset($p['umsenin'])?$p['umsenin']:0;
				$umselasa=isset($p['umselasa'])?$p['umselasa']:0;
				$umrabu=isset($p['umrabu'])?$p['umrabu']:0;
				$umkamis=isset($p['umkamis'])?$p['umkamis']:0;
				$umjumat=isset($p['umjumat'])?$p['umjumat']:0;
				//$totalum=($umsabtu+$umminggu+$umsenin+$umselasa+$umrabu+$umkamis+$umjumat);

				$bonussabtu=isset($p['bonussabtu'])?$p['bonussabtu']:0;
				$bonusminggu=isset($p['bonusminggu'])?$p['bonusminggu']:0;
				$bonussenin=isset($p['bonussenin'])?$p['bonussenin']:0;
				$bonusselasa=isset($p['bonusselasa'])?$p['bonusselasa']:0;
				$bonusrabu=isset($p['bonusrabu'])?$p['bonusrabu']:0;
				$bonuskamis=isset($p['bonuskamis'])?$p['bonuskamis']:0;
				$bonusjumat=isset($p['bonusjumat'])?$p['bonusjumat']:0;
				//$totalbonus=($bonussabtu+$bonusminggu+$bonussenin+$bonusselasa+$bonusrabu+$bonuskamis+$bonusjumat);

				$ig=array(
					'idgajiopt'=>$id,
					'tanggal1'=>$data['tanggal1'],
					'tanggal2'=>$data['tanggal2'],
					'tempat'=>$data['tempat'],
					'idkaryawan'	=>$p['idkaryawan'],
					'nama'=>$p['nama_karyawan_bordir'],
					'shift'=>isset($p['shift'])?$p['shift']:'',
					'totalgaji'	=>$totalgaji,
					'totalum'	     =>$totalum,
					'totalbonus'	=>$totalbonus,
					'potclaim'=>0,
					'potpinjaman'	=>0,
					'grandtotal'	=>($totalgaji + $totalum+$totalbonus),
					'hapus'=>0,
				);
				$this->db->insert('gaji_operator_new',$ig);
				$idig=$this->db->insert_id();
				foreach($p['det'] as $d){
					/**/
					$totalgaji+=($d['gaji']);
					$totalum+=($d['um']);
					$totalbonus+=($d['bonus']);
					$ig_detail=array(
						'idgaji'=>$idig,
						'idkaryawan'=>$p['idkaryawan'],
						'hari'=>$d['hari'],
						'gaji'=>$d['gaji'],
						'bonus'=>$d['bonus'],
						'um'=>$d['um'],
						'pot_absensi'=>isset($d['pot'])?$d['pot']:0,
						'pot_pinjaman'=>isset($d['pinjaman'])?$d['pinjaman']:0,
						'keterangan'=>$d['keterangan'],
						'shift'=>isset($p['shift'])?$p['shift']:'',
						'mandor'=>$d['mandor'],
						'hapus'=>0,
					);
					$this->db->insert('gaji_operator_detail_new',$ig_detail);
					$up=array(
						'totalgaji'	=>$totalgaji,
						'totalum'	     =>$totalum,
						'totalbonus'	=>$totalbonus,
					);
					//$this->db->update('gaji_operator_new',$up,array('idkaryawan'=>$p['idkaryawan']));
				}
				
			}
		}

		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){
				$detail=array(
					'idgaji'=>$id,
					'idkaryawan'=>$p['idkaryawan'],
					'nama'=>$p['nama_karyawan_bordir'],
					'senin'=>isset($p['senin'])?1:0,
					'selasa'=>isset($p['selasa'])?1:0,
					'rabu'=>isset($p['rabu'])?1:0,
					'kamis'=>isset($p['kamis'])?1:0,
					'jumat'=>isset($p['jumat'])?1:0,
					'sabtu'=>isset($p['sabtu'])?1:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'bonus'=>isset($p['lemburs'])?$p['lemburs']:0,
					'um'=>isset($p['um'])?$p['um']:0,
					'ksenin'=>isset($p['ksenin'])?$p['ksenin']:'-',
					'kselasa'=>isset($p['kselasa'])?$p['kselasa']:'-',
					'krabu'=>isset($p['krabu'])?$p['krabu']:'-',
					'kkamis'=>isset($p['kkamis'])?$p['kkamis']:'-',
					'kjumat'=>isset($p['kjumat'])?$p['kjumat']:'-',
					'ksabtu'=>isset($p['ksabtu'])?$p['ksabtu']:'-',
					'kminggu'=>isset($p['kminggu'])?$p['kminggu']:'-',
					'gajisenin'=>isset($p['gajisenin'])?$p['gajisenin']:'0',
					'gajiselasa'=>isset($p['gajiselasa'])?$p['gajiselasa']:'0',
					'gajirabu'=>isset($p['gajirabu'])?$p['gajirabu']:'0',
					'gajikamis'=>isset($p['gajikamis'])?$p['gajikamis']:'0',
					'gajijumat'=>isset($p['gajijumat'])?$p['gajijumat']:'0',
					'gajisabtu'=>isset($p['gajisabtu'])?$p['gajisabtu']:'0',
					'gajiminggu'=>isset($p['gajiminggu'])?$p['gajiminggu']:'0',
					'kbonus'=>isset($p['kbonus'])?$p['kbonus']:'-',
					'kum'=>isset($p['kum'])?$p['kum']:'-',
				);
				$this->db->insert('gaji_operator_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/gajioperator');
	}

	public function hapusgajioperator($id){
		$this->db->update('gaji_operator',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di hapus');
		redirect(BASEURL.'Bordir/gajioperator');
	}

	public function absensikaryawan(){
		$data=[];
		$data['title']='Absen karyawan bordir';
		$no=1;
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM absensi_bordir WHERE hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '$tanggal1' AND '$tanggal2' ";
		}
		$sql.=" ORDER BY id DESC";
		$results=$this->GlobalModel->queryManual($sql);
		$no=1;
		foreach($results as $result){
			$data['products'][]=array(
				'no'=>$no,
				'hari'=>strtolower($result['hari']),
				'tempat'=>$result['tempat']==1?'Rumah':'Cipadu',
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'shift'=>strtolower($result['shift']),
				'mandor'=>strtolower($result['mandor']),
				'detail'=>BASEURL.'Bordir/absensikaryawandetail/'.$result['id'],
				'rincian'=>$this->GlobalModel->getData('absensi_bordir_detail',array('idabsensi'=>$result['id'],'hapus'=>0)),
			);
			$no++;
		}
		$data['page']=$this->page.'absensi/bordirlist';
		$data['tambah']=BASEURL.'Bordir/absensiadd';
		$this->load->view($this->page.'main',$data);
	}

	public function absensikaryawanhapus($id){
		$this->db->update('absensi_bordir_detail',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di hapus');
		redirect(BASEURL.'Bordir/absensikaryawan');
	}


	public function absensikaryawandetail($id){
		$data=[];
		$data['title']='Laporan Absensi Karyawan Bordir';
		$data['products']=$this->GlobalModel->getDataRow('absensi_bordir',array('id'=>$id));
		$data['details']=$this->GlobalModel->getData('absensi_bordir_detail',array('idabsensi'=>$id,'hapus'=>0));
		$data['page']=$this->page.'absensi/bordirdetail';
		$this->load->view($this->page.'main',$data);
	}

	public function absensiadd(){
		$data=[];
		$data['title']='Form Absensi karyawan bordir';
		$no=1;
		$data['products']=[];
		$data['karyawan']=$this->GlobalModel->getData('master_karyawan_bordir',array('hapus'=>0));
		$data['page']=$this->page.'absensi/bordirform';
		$data['action']=BASEURL.'Bordir/absensisave';
		$this->load->view($this->page.'main',$data);
	}

	public function bonus(){
		$data=$this->input->get();
		$mesin='1,2,5,6,7,8,9,10';
		if($data['mesin']==3 OR $data['mesin']==4){
			$mesin='3,4';
		}
		$sql="SELECT bonus FROM target_mesin WHERE hapus=0 ";
		$sql.=" AND no_mesin ='".$mesin."' AND target<='".$data['stich']."'";
		$sql.=" ORDER BY bonus DESC LIMIT 1 ";
		$r=$this->GlobalModel->queryManualRow($sql);
		//pre($sql);
		if(!empty($r)){
			echo $r['bonus'];
		}else{
			echo 0;
		}
	}

	public function absensisave(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$insert=array(
				'hari'=>strtolower($data['hari']),
				'tanggal'=>$data['tanggal'],
				'shift'=>$data['shift'],
				'mandor'=>$data['mandor'],
				'tempat'=>$data['tempat'],
				'hapus'=>0,
			);
			$this->db->insert('absensi_bordir',$insert);
			$id=$this->db->insert_id();
			$c=null;
			foreach($data['products'] as $p){
				$c=$this->GlobalModel->GetDataRow('absensi_bordir_detail',array('tanggal'=>$data['tanggal'],'idkaryawan'=>$p['idkaryawan'],'mesin'=>$p['mesin'],'hapus'=>0));
				if(empty($c)){
					$detail=array(
						'idabsensi'=>$id,
						'idkaryawan'=>$p['idkaryawan'],
						'absen'=>1,
						'target'=>$p['bonus']>0?1:2,
						'keterangan'=>$p['keterangan'],
						'stich'=>$p['stich'],
						'bonus'=>$p['bonus'],
						'tanggal'=>$data['tanggal'],
						'mesin'=>$p['mesin'],
						'jamkerja'=>$p['jamkerja'],
					);
					$this->db->insert('absensi_bordir_detail',$detail);
				}
			}
			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
			redirect(BASEURL.'Bordir/absensikaryawan');
		}
	}

	public function pendapatanbordir(){
		$data=array();
		$data['n']=1;
		$data['action']=null;
		$data['title']='Laporan Pendapatan Mesin Bordir';
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
		$sm="SELECT * FROM mesin_bordir WHERE id>0 AND nomor NOT IN(11) ";
		
		if(!empty($nomesin)){
			$sm.=" AND nomor='$nomesin' ";
		}
		$mesin=$this->GlobalModel->QueryManual($sm);
		$data['luar']=[];
		$data['luar']=$this->GlobalModel->QueryManual("
		SELECT a.mesin_bordir, a.laporan_perkalian_tarif as perkalian, c.id as idpemilik, c.nama FROM kelola_mesin_bordir a
		LEFT JOIN master_po_luar b ON b.id=a.kode_po
		LEFT JOIN pemilik_poluar c ON c.id=b.idpemilik
		WHERE a.hapus=0 AND jenis=2 AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'  
		AND laporan_perkalian_tarif IS NOT NULL 
		GROUP BY a.laporan_perkalian_tarif, b.idpemilik order by laporan_perkalian_tarif DESC
		");
		
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
				'tanggal1'=>$tanggal1,
				'tanggal2'=>$tanggal2,
				'nomesin'=>$mes['nomor'],
				'shift'=>$mes['shift'],
				'stich'=>($totalstich),
				'0.18'=>!empty($total018)?($total018):0,
				'0.2'=>($total02),
				'0.18yn'=>0,
				'0.15'=>($total015),
				'pendapatan'=>($total018+$total02),
				'jumlah'=>($jumlah),
				'i'=>$i++,
				'keterangan'=>null,
				'dets'=>[],
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
		if(isset($get['cetak'])){
			$this->load->view($this->page.'bordir/pendapatan_cetak',$data);
		}else{
			$data['page']=$this->page.'bordir/pendapatan_list';
			$this->load->view($this->page.'main',$data);
		}
	}
	public function pemilikpoluar(){
		$data=array();
		$data['n']=1;
		$data['action']=BASEURL.'Bordir/pemilikpoluarsave';
		$data['products']=array();
		$data['products']=$this->GlobalModel->getData('pemilik_poluar',array('hapus'=>0));
		$data['page']=$this->page.'bordir/pemilikpoluar';
		$this->load->view($this->page.'main',$data);
	}

	public function pemilikpoluarsave(){
		$data=$this->input->post();
		$insert=array(
			'nama'=>$data['nama'],
			'hapus'=>0,
		);
		$this->db->insert('pemilik_poluar',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/pemilikpoluar');
	}

	public function poluar(){
		$data=array();
		$data['n']=1;
		$data['action']=BASEURL.'Bordir/poluarsave';
		$data['products']=array();
		$data['pemilik']=$this->GlobalModel->getData('pemilik_poluar',array('hapus'=>0));
		$products=$this->GlobalModel->getData('master_po_luar',array('hapus'=>0));
		$pemilik=0;
		foreach($products as $p){
			$pemilik=$this->GlobalModel->getDataRow('pemilik_poluar',array('id'=>$p['idpemilik']));
			$data['products'][]=array(
				'id'=>$p['id'],
				'nama'=>strtolower($p['nama']),
				'pemilik'=>strtolower($pemilik['nama']),
				'edit'=>BASEURL.'Bordir/poluardetail/'.$p['id'],
			);
		}
		$data['page']=$this->page.'bordir/poluar_list';
		$this->load->view($this->page.'main',$data);
	}

	public function poluardetail($id){
		$data=array();
		$data['n']=1;
		$data['action']=BASEURL.'Bordir/poluardetail_save';
		$data['batal']=BASEURL.'Bordir/poluar';
		$data['products']=array();
		$data['pemilik']=$this->GlobalModel->getData('pemilik_poluar',array('hapus'=>0));
		$data['prods']=$this->GlobalModel->getDataRow('master_po_luar',array('hapus'=>0,'id'=>$id));
		$data['page']=$this->page.'bordir/poluar_edit';
		$this->load->view($this->page.'main',$data);
	}

	public function poluardetail_save(){
		$data=$this->input->post();
		$insert=array(
			'nama'=>$data['nama'],
			'idpemilik'=>$data['pemilik'],
			'hapus'=>0,
		);
		$this->db->update('master_po_luar',$insert,array('id'=>$data['id']));
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/poluar');
	}

	public function poluarsave(){
		$data=$this->input->post();
		$cek=$this->GlobalModel->getDataRow('master_po_luar',array('nama'=>$data['nama'],'hapus'=>0));
		if(empty($cek)){
			$insert=array(
				'nama'=>$data['nama'],
				'idpemilik'=>$data['pemilik'],
				'hapus'=>0,
			);
			$this->db->insert('master_po_luar',$insert);
			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
			redirect(BASEURL.'Bordir/poluar');
		}else{
			$this->session->set_flashdata('gagal','Data Gagal Di Simpan. PO '.$data['nama'].' Sudah ada');
			redirect(BASEURL.'Bordir/poluar');
		}
	}

	public function tagihanpoluar(){
		$data=array();
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
		
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;

		$data['n']=1;
		$data['url']=BASEURL.'Bordir/tagihanpoluar?';
		$data['action']=BASEURL.'Bordir/tagihanpoluarsave';
		$data['products']=array();
		$data['pemilik']=array();
		$data['po']=array();
		$data['pemilik']=$this->GlobalModel->getData('pemilik_poluar',array('hapus'=>0));
		$data['po']=$this->GlobalModel->getData('master_po_luar',array('hapus'=>0));
		//$products=$this->GlobalModel->getData('tagihan_poluar',array('hapus'=>0));
		$sql="SELECT * FROM tagihan_poluar WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		$sql.=" ORDER BY tanggal DESC ";
		$products=$this->GlobalModel->QueryManual($sql);
		$pemilik=0;
		$po=0;
		foreach($products as $p){
			$pemilik=$this->GlobalModel->getDataRow('pemilik_poluar',array('id'=>$p['idpemilik']));
			$po=$this->GlobalModel->getDataRow('master_po_luar',array('id'=>$p['idpoluar']));
			$data['products'][]=array(
				'pemilik'=>$pemilik['nama'],
				'tanggal'=>date('d-m-Y',strtotime($p['tanggal'])),
				'po'=>strtolower($po['nama']),
				'keterangan'=>strtolower($p['keterangan']),
				'size'=>strtolower($p['size']),
				'sticth'=>number_format($p['sticth']),
				'qty'=>$p['qty'],
				'totalsticth'=>number_format($p['totalsticth']),
				'harga'=>number_format($p['harga']),
				'total'=>number_format($p['total']),
				'ket'=>!empty($p['ket'])?$p['ket']:'-',
			);
		}
		$data['page']=$this->page.'bordir/tagihanpoluar';
		$this->load->view($this->page.'main',$data);
	}

	public function tagihanpoluarsave(){
		$data=$this->input->post();
		$po=$this->GlobalModel->getDataRow('master_po_luar',array('id'=>$data['idpoluar']));
		$kali=$this->GlobalModel->getDataRow('kelola_mesin_bordir',array('kode_po'=>$data['idpoluar']));
		$harga=($data['sticth']*$kali['laporan_perkalian_tarif']);
		//pre($kali);
		$insert=array(
			'idpemilik'=>$po['idpemilik'],
			'tanggal'=>$data['tanggal'],
			'idpoluar'=>$data['idpoluar'],
			'keterangan'=>$data['keterangan'],
			'size'=>$data['size'],
			'sticth'=>$data['sticth'],
			'qty'=>$data['qty'],
			'totalsticth'=>$data['sticth']*$data['qty'],
			'harga'=>$harga,
			'total'=>($harga*$data['qty']),
		);
		$this->db->insert('tagihan_poluar',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/tagihanpoluar');
	}

	public function inputharianmesinpodalam(){
		$data=array();	
		$data['title']="Input Harian Mesin PO Dalam";
		$data['tambah']=BASEURL.'bordir/addharianmesin/1';	
		$data['url']=BASEURL.'Bordir/inputharianmesinpodalam?';
		$data['po'] = $this->GlobalModel->getData('produksi_po',null);		
		$data['opt'] = $this->GlobalModel->getData('master_karyawan_bordir',array('hapus'=>0));		
		$user=user();
		$hapus=0;
		if(isset($user['id_user'])){
			$hapus=akses($user['id_user'],2);
		}
		$get=$this->input->get();		
			if(!empty($get['tanggalMulai'])) {			
				if(isset($get['namaPo'])){				
					$po=$get['namaPo'];				
					$data['tanggalMulai']=null;				
					$data['tanggalEnd']=null;			
				}else{
					$data['tanggalMulai']=$get['tanggalMulai'];
					$data['tanggalEnd']=$get['tanggalEnd'];
				}		
			}else{			
			
			if(isset($get['namaPo'])){
				$po=$get['namaPo'];
				$data['tanggalMulai']=null;
				$data['tanggalEnd']=null;
				}else{
					$data['tanggalMulai']=date('Y-m-d',strtotime("first day of this month"));
					$data['tanggalEnd']=date('Y-m-d',strtotime("last day of this month"));
					}
				}
				$sql='SELECT kmb.*, mkb.nama_karyawan_bordir as nama_operator FROM kelola_mesin_bordir kmb LEFT JOIN master_karyawan_bordir mkb ON(mkb.id_master_karyawan_bordir=kmb.nama_operator)  ';
				if (!empty($get)) {
					if (!empty($get['mesin'])) {
						$sql .= 'WHERE kmb.jenis=1 AND kmb.hapus=0 and kmb.mesin_bordir ="'.$get['mesin'].'" AND kmb.nama_operator="'.$get['operator'].'"';
					}
				if (!empty($get['tanggalMulai'])) {
					if(isset($get['namaPo'])){
						$sql .= "WHERE kmb.jenis=1 AND kmb.hapus=0  AND kmb.idpo='".$po."' ";
						}else{
							$sql .= 'WHERE kmb.jenis=1 AND kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$get['tanggalMulai'].'" AND "'.$get['tanggalEnd'].'"';
						}
				}else{
					if(isset($get['namaPo'])){
						$sql .= "WHERE kmb.jenis=1 AND kmb.hapus=0 and kmb.idpo='".$po."' ";
						}else{
							$sql .= 'WHERE kmb.jenis=1 AND kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$data['tanggalMulai'].'" AND "'.$data['tanggalMulai'].'"';
						}
				}		
				}else {
					$sql .= 'WHERE kmb.jenis=1 AND kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$data['tanggalMulai'].'" AND "'.$data['tanggalEnd'].'"';
				}

				if(isset($get['oper'])){
					$sql.=" AND nama_operator='".$get['oper']."' ";
				}
				$sql.=' ORDER BY kmb.created_date DESC ';
				if(!empty($get['tanggalMulai'])){
					$sql .=" LIMIT 200 ";
				}else{
					$sql.=" LIMIT 50 ";
				}
				$bordir=array();
				
				$bordirs = $this->GlobalModel->queryManual($sql);
				foreach($bordirs as $b){
					$action=array();
					$action[]= array(
						'text' => 'Detail',
						'href' => BASEURL.'bordir/mesinbordirdetail/'.$b['idpo'],
					);
					
					if(aksesedit()==1){
						$action[]=array(
							'text'=>'Edit',
							'href'=>BASEURL.'Bordir/mesinharian_edit/'.$b['idpo'],
						);
					}

					if(akseshapus()==1){
						$action[]=array(
							'text'=>'Hapus',
							'href'=>BASEURL.'Bordir/mesinharianhapus/'.$b['id_kelola_mesin_bordir'],
						);
					}
					
					$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$b['idpo']));
					$data['bordir'][]=array(
						'kode_po'=>$po['kode_po'],
						'operator'=>$b['nama_operator'],
						'mandor'=>$b['mandor'],
						'nama_po'=>$po['kode_po'],
						'mesin'=>$b['mesin_bordir'],
						'created_date'=>date('d F Y',strtotime($b['created_date'])),
						'bagian_bordir'=>$b['bagian_bordir'],
						'size'=>$b['size'],
						'stich'=>$b['stich'],
						'jumlah_naik_mesin'=>$b['jumlah_naik_mesin'],
						'perkalian_tarif'=>$b['perkalian_tarif'],
						'hitung'=>round($b['total_stich']*$b['perkalian_tarif'])-$b['total_tarif'],
						'total_stich'=>number_format($b['total_stich']),
						'total_tarif'=>number_format($b['total_tarif']),
						'action'=>$action,			
						'persen'=>$b['persen'],
						'gaji'=>$b['gaji'],
						'kepala'=>$b['kepala'],
					);
				}						
				$data['mesin'] = $this->GlobalModel->getData('master_mesin',null);
				$data['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',null);
				if(isset($get['excel'])){
					$this->load->view('bordir/list_excel',$data);
				}else{
					$data['page']='bordir/list';
					$this->load->view('newtheme/page/main',$data);
				}
	}

	public function mesinharian_edit($id){
		$data=[];
		$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$id));
		$id=$po['id_produksi_po'];
		$data['title']='Edit Inputan Mesin Bordir '.$id;
		$data['kode_po']=$id;
		$data['d']=$this->GlobalModel->GetData('kelola_mesin_bordir',array('hapus'=>0,'idpo'=>$id));
		$data['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',array('hapus'=>0));
		$data['action']=BASEURL.'Bordir/mesinharian_save';
		$data['batal']=BASEURL.'Bordir/inputharianmesinpodalam/';
		$data['page']='newtheme/page/bordir/edit_bordir';
		$this->load->view($this->layout,$data);
	}

	public function mesinharian_edit_luar($id){
		$data=[];
		$po=$this->GlobalModel->GetDataRow('master_po_luar',array('id'=>$id));
		//pre($po);
		$id=$po['id'];
		$data['title']='Edit Inputan Mesin Bordir '.$id;
		$data['kode_po']=$id;
		$data['d']=$this->GlobalModel->GetData('kelola_mesin_bordir',array('hapus'=>0,'kode_po'=>$id));
		$data['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',array('hapus'=>0));
		$data['action']=BASEURL.'Bordir/mesinharian_save_luar';
		$data['batal']=BASEURL.'Bordir/inputharianmesinpoluar/';
		$data['page']='newtheme/page/bordir/edit_bordir';
		$this->load->view($this->layout,$data);
	}

	public function mesinharian_save(){
		$data=$this->input->post();
		$mesin=[];
		foreach($data['prods'] as $p){
			$mesin=$this->GlobalModel->getDataRow('master_mesin',array('jenis'=>1,'nomer_mesin'=>$p['mesin_bordir']));
			$update=array(
				'created_date'=>$p['created_date'],
				'nama_operator'=>$p['nama_operator'],
				'mesin_bordir'=>$p['mesin_bordir'],
				'jumlah_naik_mesin'=>$p['jumlah_naik_mesin'],
				'perkalian_tarif'=>$p['perkalian_tarif'],
				'stich'		=> $p['stich'],
				'total_stich'=>round($p['jumlah_naik_mesin']*$p['stich']),
				'total_tarif'=>round(($p['jumlah_naik_mesin']*$p['stich'])*$p['perkalian_tarif']),
				'gaji'  => round(($p['jumlah_naik_mesin']*$p['stich'])*0.15*$mesin['persenan']),
			);
			$where=array(
				'id_kelola_mesin_bordir' => $p['id'],
			);
			$this->db->update('kelola_mesin_bordir',$update,$where);
		}
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/inputharianmesinpodalam?&namaPo='.$data['kode_po']);
	}

	public function mesinharian_save_luar(){
		$data=$this->input->post();
		//pre($data);
		$mesin=[];
		foreach($data['prods'] as $p){
			$mesin=$this->GlobalModel->getDataRow('master_mesin',array('jenis'=>1,'nomer_mesin'=>$p['mesin_bordir']));
			$update=array(
				'created_date'=>$p['created_date'],
				'nama_operator'=>$p['nama_operator'],
				'mesin_bordir'=>$p['mesin_bordir'],
				'jumlah_naik_mesin'=>$p['jumlah_naik_mesin'],
				'perkalian_tarif'=>$p['perkalian_tarif'],
				'stich'		=> $p['stich'],
				'total_stich'=>round($p['jumlah_naik_mesin']*$p['stich']),
				'total_tarif'=>round(($p['jumlah_naik_mesin']*$p['stich'])*$p['perkalian_tarif']),
				'gaji'  => round(($p['jumlah_naik_mesin']*$p['stich'])*0.18*$mesin['persenan']),
			);
			$where=array(
				'id_kelola_mesin_bordir' => $p['id'],
			);
			$this->db->update('kelola_mesin_bordir',$update,$where);
		}
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/inputharianmesinpoluar?&namaPo='.$data['kode_po']);
	}

	public function inputharianmesinpoluar(){
		$data=array();		
		$data['title']='Input Bordir Mesin PO Luar';
		$data['url']=BASEURL.'Bordir/inputharianmesinpoluar?';
		$data['tambah']=BASEURL.'bordir/addharianmesin/2';		
		$po= $this->GlobalModel->getData('master_po_luar',array('hapus'=>0));		
		foreach($po as $p){
			$data['po'][]=array(
				'id'=>$p['id'],
				'nama'=>$p['nama'],
			);
		}
		$user=user();
		$hapus=0;
		if(isset($user['id_user'])){
			$hapus=akses($user['id_user'],2);
		}
		$get=$this->input->get();		
			if(!empty($get['tanggalMulai'])) {			
				if(isset($get['namaPo'])){				
					$po=$get['namaPo'];				
					$data['tanggalMulai']=null;				
					$data['tanggalEnd']=null;			
				}else{
					$data['tanggalMulai']=$get['tanggalMulai'];
					$data['tanggalEnd']=$get['tanggalEnd'];
				}		
			}else{			
			
			if(isset($get['namaPo'])){
				$po=$get['namaPo'];
				$data['tanggalMulai']=null;
				$data['tanggalEnd']=null;
				}else{
					$data['tanggalMulai']=date('Y-m-d',strtotime("first day of this month"));
					$data['tanggalEnd']=date('Y-m-d',strtotime("last day of this month"));
					}
				}
				$sql='SELECT kmb.*, mkb.nama_karyawan_bordir as nama_operator,mpl.nama FROM kelola_mesin_bordir kmb LEFT JOIN master_karyawan_bordir mkb ON(mkb.id_master_karyawan_bordir=kmb.nama_operator) LEFT JOIN master_po_luar mpl ON(mpl.id=kmb.kode_po) ';
				if (!empty($get)) {
					if (!empty($get['mesin'])) {
						$sql .= 'WHERE kmb.jenis=2 AND kmb.hapus=0 and kmb.mesin_bordir ="'.$get['mesin'].'" AND kmb.nama_operator="'.$get['operator'].'"';
					}
				if (!empty($get['tanggalMulai'])) {
					if(isset($get['namaPo'])){
						$sql .= "WHERE kmb.jenis=2 AND kmb.hapus=0  AND kmb.kode_po='".$po."' ";
						}else{
							$sql .= 'WHERE kmb.jenis=2 AND kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$get['tanggalMulai'].'" AND "'.$get['tanggalEnd'].'"';
						}
				}else{
					if(isset($get['namaPo'])){
						$sql .= "WHERE kmb.jenis=2 AND kmb.hapus=0 and kmb.kode_po='".$po."' ";
						}else{
							$sql .= 'WHERE kmb.jenis=2 AND kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$data['tanggalMulai'].'" AND "'.$data['tanggalMulai'].'"';
						}
				}		
				}else {
					$sql .= 'WHERE kmb.jenis=2 AND kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$data['tanggalMulai'].'" AND "'.$data['tanggalEnd'].'"';
				}		

				if(isset($get['oper'])){
					$sql.=" AND nama_operator='".$get['oper']."' ";
				}

				if(isset($get['pemilik'])){
					$sql .=" AND idpemilik='".$get['pemilik']."' ";
				}

				$sql.=' ORDER BY kmb.created_date ASC ';
				$bordir=array();
				//pre($sql);
				$bordirs = $this->GlobalModel->queryManual($sql);
				foreach($bordirs as $b){
					$action=array();
					$action[]= array(
						'text' => 'Detail',
						'href' => BASEURL.'bordir/mesinbordirdetailluar/'.$b['kode_po'],
					);
					if($hapus==1){
						$action[]=array(
							'text'=>'Hapus',
							'href'=>BASEURL.'Bordir/mesinharianhapus/'.$b['id_kelola_mesin_bordir'],
						);
					}

					if(aksesedit()==1){
						$action[]=array(
							'text'=>'Edit',
							'href'=>BASEURL.'Bordir/mesinharian_edit_luar/'.$b['kode_po'],
						);
					}


					$data['bordir'][]=array(
					'kode_po'=>$b['kode_po'],
					'operator'=>$b['nama_operator'],
					'mesin'=>$b['mesin_bordir'],
					'mandor'=>$b['mandor'],
					'nama_po'=>$b['nama'],
					'created_date'=>date('d F Y',strtotime($b['created_date'])),
					'bagian_bordir'=>$b['bagian_bordir'],
					'size'=>$b['size'],
					'stich'=>$b['stich'],
					'jumlah_naik_mesin'=>$b['jumlah_naik_mesin'],
					'perkalian_tarif'=>$b['perkalian_tarif'],
					'hitung'=>round($b['total_stich']*$b['perkalian_tarif'])-$b['total_tarif'],
					'total_stich'=>number_format($b['total_stich']),
					'total_tarif'=>number_format($b['total_tarif']),
					'action'=>$action,			
					'persen'=>$b['persen'],
					'gaji'=>$b['gaji'],
					'kepala'=>$b['kepala'],
					);
				}	
				
				//pre($sql);
				$data['mesin'] = $this->GlobalModel->getData('master_mesin',null);
				$data['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',null);
				$data['pemilik']=$this->GlobalModel->getData('pemilik_poluar',array('hapus'=>0));
				$data['opt'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',array('hapus'=>0));
				$data['milik'] = isset($get['pemilik']) ? $get['pemilik'] : '';
				if(isset($get['excel'])){
					$this->load->view('bordir/list_excel',$data);
				}else{
					$data['page']='bordir/list_luar';
					$this->load->view('newtheme/page/main',$data);
				}
	}

	public function mesin(){		
		$data=array();		
		$data['tambah']=BASEURL.'bordir/addharianmesin';		
		$data['po'] = $this->GlobalModel->getData('produksi_po',null);		
		$user=user();
		$hapus=0;
		if(isset($user['id_user'])){
			$hapus=akses($user['id_user'],2);
		}
		$get=$this->input->get();		
			if(!empty($get['tanggalMulai'])) {			
				if(isset($get['namaPo'])){				
					$po=$get['namaPo'];				
					$data['tanggalMulai']=null;				
					$data['tanggalEnd']=null;			
				}else{
					$data['tanggalMulai']=$get['tanggalMulai'];
					$data['tanggalEnd']=$get['tanggalEnd'];
				}		
			}else{			
			
			if(isset($get['namaPo'])){
				$po=$get['namaPo'];
				$data['tanggalMulai']=null;
				$data['tanggalEnd']=null;
				}else{
					$data['tanggalMulai']=date('Y-m-d',strtotime("first day of this month"));
					$data['tanggalEnd']=date('Y-m-d',strtotime("last day of this month"));
					}
				}
				$sql='SELECT kmb.*, mkb.nama_karyawan_bordir as nama_operator FROM kelola_mesin_bordir kmb LEFT JOIN master_karyawan_bordir mkb ON(mkb.id_master_karyawan_bordir=kmb.nama_operator)  ';
				if (!empty($get)) {
					if (!empty($get['mesin'])) {
						$sql .= 'WHERE kmb.hapus=0 and kmb.mesin_bordir ="'.$get['mesin'].'" AND kmb.nama_operator="'.$get['operator'].'"';
					}
				if (!empty($get['tanggalMulai'])) {
					if(isset($get['namaPo'])){
						$sql .= "WHERE kmb.hapus=0  AND kmb.kode_po='".$po."' ";
						}else{
							$sql .= 'WHERE kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$get['tanggalMulai'].'" AND "'.$get['tanggalEnd'].'"';
						}
				}else{
					if(isset($get['namaPo'])){
						$sql .= "WHERE kmb.hapus=0 and kmb.kode_po='".$po."' ";
						}else{
							$sql .= 'WHERE kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$data['tanggalMulai'].'" AND "'.$data['tanggalMulai'].'"';
						}
				}		
				}else {
					$sql .= 'WHERE kmb.hapus=0 and DATE(kmb.created_date) BETWEEN "'.$data['tanggalMulai'].'" AND "'.$data['tanggalEnd'].'"';
				}		$sql.=' ORDER BY kmb.created_date ASC ';
				$bordir=array();
				
				$bordirs = $this->GlobalModel->queryManual($sql);
				foreach($bordirs as $b){
					$action=array();
					$action[]= array(
						'text' => 'Detail',
						'href' => BASEURL.'bordir/mesinbordirdetail/'.$b['kode_po'],
					);
					if($hapus==1){
						$action[]=array(
							'text'=>'Hapus',
							'href'=>BASEURL.'Bordir/mesinharianhapus/'.$b['id_kelola_mesin_bordir'],
						);
					}
					$data['bordir'][]=array(
					'kode_po'=>$b['kode_po'],
					'operator'=>$b['nama_operator'],
					'mandor'=>$b['mandor'],
					'nama_po'=>$b['kode_po'],
					'created_date'=>date('d F Y',strtotime($b['created_date'])),
					'bagian_bordir'=>$b['bagian_bordir'],
					'size'=>$b['size'],
					'stich'=>$b['stich'],
					'jumlah_naik_mesin'=>$b['jumlah_naik_mesin'],
					'total_stich'=>number_format($b['total_stich']),
					'total_tarif'=>number_format($b['total_tarif']),
					'action'=>$action,			);
				}						
				$data['mesin'] = $this->GlobalModel->getData('master_mesin',null);
				$data['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',null);
				$this->load->view('global/header');
				$this->load->view('bordir/list',$data);
				$this->load->view('global/footer');
	}		
	
	
	public function mesinharianhapus($id=''){
		$this->db->query("UPDATE kelola_mesin_bordir set hapus=1 where id_kelola_mesin_bordir='$id' ");
		redirect(BASEURL.'bordir/inputharianmesinpodalam');	
	}
	public function addharianmesin($jenis){
		$data=array();
		$data['title']='Tambah Bordir';
		//pre($jenis);
		$data['jenis']=$jenis;
		if($jenis==1){
		    $data['kembali']=BASEURL.'Bordir/inputharianmesinpodalam';
		}else{
		    $data['kembali']=BASEURL.'Bordir/inputharianmesinpoluar';
		}
		//pre($data['kembali']);
		if($jenis==1){
			$po=$this->GlobalModel->getData('produksi_po',null);
			$data['page']='bordir/harianmesinbordirnaik-form';
		}else{
			$data['page']='bordir/harianmesinbordirluarnaik-form';
			$po=$this->GlobalModel->getData('master_po_luar',null);
		}
		$data['po'] = $po;
		//$data['kembali']=$link;
		$data['mesin'] = $this->GlobalModel->getData('master_mesin',array('input'=>1));
		$data['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',array('hapus'=>0));
		$this->load->view('newtheme/page/main',$data);
				
	}		
	public function addharianmesinsave()
	{		
		$post = $this->input->post();
		//pre($post);exit;
		$dataKode = array(
			'jumlah_bagian_bordir'=>$post['jumlahbagian'],
			'jumlah_size'=>$post['jumlah_size']
		);
		if($post['jenis']==1){
			$this->GlobalModel->updateData('produksi_po',array('kode_po' => $post['namaPo']),$dataKode);
			//$namapo= $post['namaPo'];
			$laporan_perkalian_tarif='0.18';
			$idpo=GetDetailPo($post['namaPo'])['id_produksi_po'];
		}else{
			//$po=$this->GlobalModel->getDataRow('master_po_luar',array('id'=>$post['namaPo']));
			//$namapo=$po['nama'];
			$laporan_perkalian_tarif=$post['perkalianTarif'];
			$idpo=$post['namaPo'];
		}

		$mesin=$this->GlobalModel->getDataRow('master_mesin',array('jenis'=>$post['jenis'],'nomer_mesin'=>$post['mesin']));
		if($post['jenis']==2){ // po luar
			$pemilik= $this->GlobalModel->GetDataRow('master_po_luar',array('id'=>$post['namaPo']));
			if($pemilik['pemilik']==3){
				$perkalian_mesin=0.15;
			}else{
				$perkalian_mesin=0.18;
			}
		}else{
			$perkalian_mesin=0.15; // po dalam
		}
		$dataInsert = array(
		'shift'	=> $post['shift'],
		'kode_po' =>$post['namaPo'],
		'mandor'=>isset($post['mandor'])?$post['mandor']:null,
		'nama_operator'  => $post['namaOperator'],
		'mesin_bordir'  => $post['mesin'],
		'created_date'  => $post['tanggal'],
		'jumlah_naik_mesin'  => $post['jmlNaik'],
		'jumlah_turun_mesin'  => $post['jmlTurun'],
		'size'  => $post['size'],
		'stich'  => $post['stich'],
		'total_stich'  => $post['totalStich'],
		'perkalian_tarif'  => $post['perkalianTarif'],
		'spon'  => $post['spon'],
		'apl'  => $post['apl'],
		'bagian_bordir'  => $post['yangdibordir'],
		'total_tarif'  => round($post['totalStich']*$post['perkalianTarif']),
		//'total_tarif'  => round(($post['stich']+$post['apl'])*$mesin['kepala']*($post['jmlTurun']/$mesin['kepala'])*0.18),
		'gaji'  => round(($post['totalStich']+$post['apl'])*$perkalian_mesin*$mesin['persenan']),
		'kehadiran_operator'=>$post['kehadiran'],
		'jam_kerja'	=> $post['jamkehadiran'],
		'jenis'=>$post['jenis'],
		'kepala'  =>$mesin['kepala'],
		'persen' =>$mesin['persenan'],
		'laporan_perkalian_tarif'=>$laporan_perkalian_tarif,
		'idpo'=>$idpo,
		//'gaji'  => round(($post['stich']+$post['apl'])*$mesin['kepala']*($post['jmlTurun']/$mesin['kepala'])*0.15*$mesin['persenan']),
		);		
		//pre($dataInsert);
		$this->GlobalModel->updateData('kelolapo_kirim_setor',array('kode_po'=>$post['namaPo']),array('status'=>1));
		$this->GlobalModel->insertData('kelola_mesin_bordir',$dataInsert);
		if($post['jenis']==1){
			redirect(BASEURL.'bordir/inputharianmesinpodalam');	
		}else{
			redirect(BASEURL.'bordir/inputharianmesinpoluar');	
		}
	}
	
	public function harianmesinbordirnaik($kodePo='')
	{
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$kodePo));
		$viewData['mesin'] = $this->GlobalModel->getData('master_mesin',null);
		$viewData['operator'] = $this->GlobalTwoModel->getData('master_karyawan_bordir',null);
		// pre($viewData);
		$this->load->view('global/header');
		$this->load->view('bordir/harianmesinbordirnaik-tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function mesinbordirinputAct()
	{
		$post = $this->input->post();

		$dataKode = array(
			'jumlah_bagian_bordir'=>$post['jumlahbagian'],
			'jumlah_size'=>$post['jumlah_size']
		);
		$this->GlobalModel->updateData('produksi_po',array('kode_po' => $post['namaPo']),$dataKode);

		$dataInsert = array(
			'shift'	=> $post['shift'],
			 'kode_po' => $post['namaPo'],
			 'nama_operator'  => $post['namaOperator'],
			 'mesin_bordir'  => $post['mesin'],
			 'created_date'  => $post['tanggal'],
			 'jumlah_naik_mesin'  => $post['jmlNaik'],
			 'jumlah_turun_mesin'  => $post['jmlTurun'],
			 'size'  => $post['size'],
			 'stich'  => $post['stich'],
			 'total_stich'  => $post['totalStich'],
			 'perkalian_tarif'  => $post['perkalianTarif'],
			 'spon'  => $post['spon'],
			 'apl'  => $post['apl'],
			 'bagian_bordir'  => $post['yangdibordir'],
			 'total_tarif'  => $post['tarif'],
			 'kehadiran_operator'=>$post['kehadiran'],
			 'jam_kerja'	=> $post['jamkehadiran']
		);
		$this->GlobalModel->updateData('kelolapo_kirim_setor',array('kode_po'=>$post['namaPo']),array('status'=>1));
		$this->GlobalModel->insertData('kelola_mesin_bordir',$dataInsert);
		redirect(BASEURL.'kelolapo/kirimsetorcmt');
	}

	public function mesinbordirdetail($kodePo='')
	{
		$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$kodePo));
		$kodePo=$po['id_produksi_po'];
		//$viewData['detail'] = $this->GlobalModel->queryManual('SELECT * FROM kelola_mesin_bordir kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po WHERE kmb.kode_po="'.$kodePo.'" ');
		$viewData['title']="Detail Bordir";
		//$viewData['detail'] = $this->GlobalModel->queryManual('SELECT * FROM kelola_mesin_bordir kmb WHERE kmb.kode_po="'.$kodePo.'" ');
		$viewData['detail'] = $this->GlobalModel->queryManual('SELECT kmb.*, mkb.nama_karyawan_bordir as nama_operator FROM kelola_mesin_bordir kmb LEFT JOIN master_karyawan_bordir mkb ON(mkb.id_master_karyawan_bordir=kmb.nama_operator) WHERE kmb.idpo="'.$kodePo.'" AND kmb.hapus=0 ORDER by mkb.nama_karyawan_bordir ASC ');
		//pre($viewData['detail']);
		//$this->load->view('global/header');
		$viewData['page']='bordir/harianmesinbordirnaik-detail';
		$this->load->view('newtheme/page/main',$viewData);
		//$this->load->view('global/footer');
	}

	public function mesinbordirdetailluar($kodePo='')
	{
		$po=$this->GlobalModel->GetDataRow('master_po_luar',array('id'=>$kodePo));
		$kodePo=$po['id'];
		//$viewData['detail'] = $this->GlobalModel->queryManual('SELECT * FROM kelola_mesin_bordir kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po WHERE kmb.kode_po="'.$kodePo.'" ');
		$viewData['title']="Detail Bordir";
		//$viewData['detail'] = $this->GlobalModel->queryManual('SELECT * FROM kelola_mesin_bordir kmb WHERE kmb.kode_po="'.$kodePo.'" ');
		$viewData['detail'] = $this->GlobalModel->queryManual('SELECT kmb.*, mkb.nama_karyawan_bordir as nama_operator FROM kelola_mesin_bordir kmb LEFT JOIN master_karyawan_bordir mkb ON(mkb.id_master_karyawan_bordir=kmb.nama_operator) WHERE kmb.kode_po="'.$kodePo.'" AND kmb.hapus=0 ORDER by mkb.nama_karyawan_bordir ASC ');
		//pre($viewData['detail']);
		//$this->load->view('global/header');
		$viewData['page']='bordir/harianmesinbordirnaik-detail';
		$this->load->view('newtheme/page/main',$viewData);
		//$this->load->view('global/footer');
	}

	public function buangbenang(){
		$data=array();
		$data['n']=1;
		$data['title']='Buang Benang Bordir';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-1 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM kelolapo_buang_benang WHERE hapus=0";
		if(!empty($tanggal1)){
			$sql .=" AND DATE(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		}
		$sql.=" ORDER BY id_kelolapo_buang_benang DESC ";
		$buangbenang=$this->GlobalModel->QueryManual($sql);
		$data['products']=array();
		foreach($buangbenang as $result){
			$pekerja=$this->GlobalModel->getDataRow('master_karyawan_benang',array('id_master_karyawan_benang'=>$result['nama_pekerja']));
			$data['products'][]=array(
				'id_kelolapo_buang_benang'=>$result['id_kelolapo_buang_benang'],
				'kode_po'=>$result['kode_po'],
				'bagian'=>$result['bagian_buang_benang'],
				'size'=>$result['size_buang_benang'],
				'qty'=>$result['qty_buang_benang'],
				'harga'=>$result['harga_buang_benan'],
				'keterangan'=>$result['keterangan_buang_benang'],
				'pekerja'=>$pekerja['nama_karyawan_benang'],
				'tanggal'=>date('d/m/Y',strtotime($result['created_date'])),
				'hapus'=>BASEURL.'Bordir/buangbenanghapus/'.$result['id_kelolapo_buang_benang'],
			);
		}
		$data['page']='newtheme/page/bordir/buangbenang_list';
		$data['tambah']=BASEURL.'Bordir/buangbenangadd';
		$this->load->view('newtheme/page/main',$data);
	}

	public function buangbenanghapus($id){
		$this->db->update('kelolapo_buang_benang',array('hapus'=>1),array('id_kelolapo_buang_benang'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect(BASEURL.'Bordir/buangbenang');
	}

	public function buangbenangadd(){
		$kodePo=0;
		$viewData['title']='Tambah Buang Benang Bordir';
		$viewData['cancel']=BASEURL.'Bordir/buangbenang';
		$po=[];
		$pot=[];
		$po_one=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		foreach($po_one as $p){
			$po[]=array(
				'kode_po'=>$p['kode_po'],
			);
		}
		$po_two=$this->GlobalModel->getData('master_po_luar',array('hapus'=>0));
		foreach($po_two as $p){
			$pot[]=array(
				'kode_po'=>$p['nama'],
			);
		}
		$prods=array_merge($po,$pot);
		//pre($prods);
		//$viewData['po']	= $this->GlobalModel->getData('produksi_po',array());
		$viewData['po']	= $prods;
		$viewData['bagianAtas']	= $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po' => $kodePo));
		$viewData['bagianBawah']	= $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po' => $kodePo));
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po' => $kodePo));
		$viewData['karyawan'] = $this->GlobalTwoModel->getData('master_karyawan_benang',array('hapus'=>0));
		$viewData['kelolapo']	= $this->GlobalModel->queryManual('SELECT * FROM `kelolapo_buang_benang` kbb JOIN master_karyawan_benang mbk ON kbb.nama_pekerja=mbk.id_master_karyawan_benang WHERE kbb.kode_po="'.$kodePo.'"');
		$viewData['page']='bordir/buang-benang-tambah';
		$viewData['savepekerja']=BASEURL.'Bordir/savepekerja';
		$this->load->view('newtheme/page/main',$viewData);
	}

	function savepekerja(){
		$data=$this->input->post();
		$insert=array(
			'nama_karyawan_benang'=>strtoupper($data['nama']),
		);
		$this->db->insert('master_karyawan_benang',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/buangbenangadd');
	}

	public function harianbuangbenang($kodePo='')
	{
		$viewData['bagianAtas']	= $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po' => $kodePo));
		$viewData['bagianBawah']	= $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po' => $kodePo));
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po' => $kodePo));
		$viewData['karyawan'] = $this->GlobalTwoModel->getData('master_karyawan_benang',null);
		$viewData['kelolapo']	= $this->GlobalModel->queryManual('SELECT * FROM `kelolapo_buang_benang` kbb JOIN master_karyawan_benang mbk ON kbb.nama_pekerja=mbk.id_master_karyawan_benang WHERE kbb.kode_po="'.$kodePo.'"');
		$this->load->view('global/header');
		$this->load->view('bordir/buang-benang-tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function harianbuangbenangdetail($kodePo='')
	{
		$viewData['detail'] = $this->GlobalModel->queryManual('SELECT * FROM kelolapo_buang_benang kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po');
		$this->load->view('global/header');
		$this->load->view('bordir/buang-benang-detail',$viewData);
		$this->load->view('global/footer');
	}

	public function harianbuangbenangAct()
	{
		$post = $this->input->post();
		//pre($post);
		//$kodePO = $this->GlobalModel->getDataRow('kelolapo_buang_benang',array('kode_po' => $post['kode_po']));
		foreach ($post['bagianBuang'] as $key => $bagianBuang) {
			$dataInsert = array(
				'nama_pekerja'	=> $post['namaPekerja'],
				//'kode_po'	=>	$post['kode_po'], 
				'kode_po'	=>	$post['namaPO'][$key], 
				//'bagian_buang_benang'	=>	$bagianBuang, 
				'bagian_buang_benang'	=>	$post['bagianBuang'][$key],
				'size_buang_benang'	=>	$post['size'][$key], 
				'qty_buang_benang'	=>	$post['qty'][$key], 
				'harga_buang_benan'	=>	$post['harga'][$key], 
				'keterangan_buang_benang'	=>	$post['keterangan'][$key], 
				//'created_date'	=>	$post['tanggal'][$key],
				'created_date'	=>	$post['tgl'], 
			);
			$this->GlobalModel->insertData('kelolapo_buang_benang',$dataInsert);
			//$this->GlobalModel->updateData('kelolapo_kirim_setor',array('kode_po'=>$post['namaPo'][$key]),array('status'=>2));
		}
		
		// $this->GlobalModel->updateData('kelolapo_kirim_setor',array('kode_po'=>$post['kode_po']),array('status'=>2));
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/buangbenang');
		
		
	}

	public function pengeluaran(){
		$data=[];
		$data['title']='Pengeluaran Bordir Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			//$tanggal1=date('Y-m-d',strtotime('first day of this month'));
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			//$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
			$tanggal2=null;
		}
		$sql="SELECT * FROM pengeluaran_bordir_detail WHERE hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id desc ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tanggal'=> date('d F Y',strtotime($r['tanggal'])),
				'total'=>$r['total'],
				'keterangan'=>$r['keterangan'],
				'detail'=>BASEURL.'Bordir/pengeluarandetail/'.$r['id'],
				'excel'=>BASEURL.'Bordir/pengeluarandetail/'.$r['id'].'?&excel=1',
				'hapus'=>BASEURL.'Bordir/pengeluaranhapus/'.$r['id'],
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Bordir/pengeluaranadd';
		if(isset($get['excel'])){
			$this->load->view($this->page.'bordir/pengeluaran_excel',$data);
		}else{
			$data['page']=$this->page.'bordir/pengeluaran_list';
			$this->load->view($this->page.'main',$data);
		}
		
	}

	
	public function pengeluarandetail($id){
		$data=[];
		$data['title']='Pengeluaran Bordir Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('first day of this month'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM pengeluaran_bordir WHERE hapus=0 and id='$id' ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id desc ";
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($sql);
		$no=1;
		foreach($results as $r){
			$details=$this->GlobalModel->Getdata('pengeluaran_bordir_detail',array('idpengeluaran'=>$r['idpengeluaran']));
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tanggal'=> date('d F Y',strtotime($r['tanggal'])),
				'total'=>$r['total'],
				'keterangan'=>$r['keterangan'],
				'detais'=>$details,
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Bordir/pengeluaranadd';
		if(isset($get['excel'])){
			$this->load->view($this->page.'bordir/pengeluaran_excel',$data);
		}else{
			$data['page']=$this->page.'bordir/pengeluaran_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function pengeluaranadd(){
		$data=[];
		$data['title']='Pengeluaran Bordir Forboys';
		$data['products']=[];
		$data['action']=BASEURL.'Bordir/pengeluaran_save';
		$data['cancel']=BASEURL.'Bordir/pengeluaran';
		$data['page']=$this->page.'bordir/pengeluaran_add';
		$this->load->view($this->page.'main',$data);
	}

	public function pengeluaran_save(){
		$data=$this->input->post();
		//pre($data);
		$total=0;
		$insert=array(
			'tanggal'	=>$data['tanggal'],
			'keterangan'=>'Pengeluaran Bordir '.date('d F Y',strtotime($data['tanggal'])),
			'total'=>0,
			'hapus'=>0,
			'created'=>date('Y-m-d'),
		);
		$this->db->insert('pengeluaran_bordir',$insert);
		$id=$this->db->insert_id();
		foreach($data['products'] as $p){
			$total+=($p['total']);
			$details=array(
				'idpengeluaran'=>$id,
				'tanggal'=>$data['tanggal'],
				'total'=>$p['total'],
				'keterangan'=>$p['keterangan'],
				'hapus'=>0,
				'created'=>date('Y-m-d'),
			);
			$this->db->insert('pengeluaran_bordir_detail',$details);
		}
		$this->db->update('pengeluaran_bordir',array('total'=>$total),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/pengeluaran');
	}

	public function pengeluaranhapus($id){
		$this->db->update('pengeluaran_bordir_detail',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di hapus');
		redirect(BASEURL.'Bordir/pengeluaran');
	}

	public function suratjalanpoluar()
	{
		$data=[];
		$data['title']='Surat Jalan Bordir PO Luar';
		$data['products']=$this->GlobalModel->QueryManual("SELECT * FROM sj_bordir_luar WHERE hapus=0 ORDER BY id DESC");
		$data['tambah']=BASEURL.'Bordir/suratjalanpoluar_add';
		$data['cancel']=BASEURL.'Bordir/pengeluaran';
		$data['page']=$this->page.'bordir/sj_poluar_list';
		$this->load->view($this->page.'main',$data);
	}

	public function suratjalanpoluar_detail($id)
	{
		$data=[];
		$data['title']='Surat Jalan Bordir PO Luar';
		$data['kirim']=$this->GlobalModel->GetDataRow('sj_bordir_luar',array('hapus'=>0,'id'=>$id));
		$data['kirims']=$this->GlobalModel->GetData('sj_bordir_luar_detail',array('hapus'=>0,'idsj'=>$id));
		// pre($data['kirims']);
		$data['cetak']=BASEURL.'Bordir/suratjalanpoluar_detail/'.$id.'?cetakpdf=true';
		$data['cancel']=BASEURL.'Bordir/suratjalanpoluar';
		$get = $this->input->get();
		$pdf=false;
		if(isset($get['cetakpdf'])){
			$pdf=true;
		}
		
		if($pdf==true){
			//$this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			
			$html =  $this->load->view('newtheme/page/bordir/sj_poluar_detail_pdf',$data,true);

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
			$data['page']=$this->page.'bordir/sj_poluar_detail';
			$this->load->view($this->page.'main',$data);
		}

		
	}

	public function suratjalanpoluar_add()
	{
		$data=[];
		$data['title']='Surat Jalan Bordir PO Luar';
		$data['products']=[];
		$data['action']=BASEURL.'Bordir/suratjalanpoluar_save';
		$data['cancel']=BASEURL.'Bordir/suratjalanpoluar';
		$data['page']=$this->page.'bordir/sj_poluar_form';
		$data['pos']	= $this->GlobalModel->GetData('master_po_luar',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	public function suratjalanpoluar_save()
	{
		$data=$this->input->post();
		$total=0;
		$insert=array(
			'tanggal'	=>$data['tanggal'],
			'kepada'	=>$data['kepada'],
			'keterangan'=>$data['keterangan'],
			'hapus'=>0,
		);
		$this->db->insert('sj_bordir_luar',$insert);
		$id=$this->db->insert_id();
		
		foreach($data['products'] as $p){
			$total+=($p['total']);
			$details=array(
				'idsj'=>$id,
				'tanggal'=>$data['tanggal'],
				'idpo'=>$p['idpo'],
				'gambar'=>$p['gambar'],
				'posisi'=>$p['posisi'],
				'stich'=>$p['stich'],
				'qty'=>$p['qty'],
				'keterangan'=>$p['keterangan'],
				'hapus'=>0,
			);
			$this->db->insert('sj_bordir_luar_detail',$details);
		}
		$nosj ="SJ-BL-".date('m').'-'.str_pad($id,3,'0',STR_PAD_LEFT);
		$this->db->update('sj_bordir_luar',array('nosj'=>$nosj),array('id'=>$id));
		
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Bordir/suratjalanpoluar');
	}

	public function caripoluar(){
		$get = $this->input->get();
		$sql="SELECT a.* FROM master_po_luar a JOIN kelola_mesin_bordir b ON b.kode_po=a.id ";
		if(isset($get['po'])){
			$sql.=" AND a.nama LIKE '%".$get['po']."%'";
		}
		$sql.=" GROUP BY a.nama ";
		$results=$this->GlobalModel->QueryManual($sql);
		$json=[];
		foreach($results as $r){
			$json[] = array(
				'id' => round($r['id']),
				'text' =>$r['nama'],
			);
		}
		echo json_encode($json);
	}

	public function detailinputanharian()
	{
		$post = $this->input->get();
		$sql ="SELECT a.id_kelola_mesin_bordir as id, a.idpo,a.bagian_bordir,a.stich, COALESCE(SUM(jumlah_naik_mesin)) as jumlah_naik_mesin ,b.nama as namapo FROM kelola_mesin_bordir a JOIN master_po_luar b ON 
			a.idpo=b.id		
		 WHERE a.kode_po='".$post['kodepo']."'  
		  GROUP BY a.bagian_bordir
		 ";
		
		$data = $this->GlobalModel->QueryManual($sql);
		header('Content-Type: application/json');
		echo json_encode($data);
	}
}