<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finishing extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->load->model('KirimsetorModel');
	}

	public function resumegaji(){
		$data=[];
		$data['title']='Laporan Resume Gaji Karyawan Finishing';
		$data['boronganmesin']=[];
		$data['bb']=[];
		$data['pk']=[];
		$data['fharian']=[];
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
		$data['products']=[];

		// harian finishing
		$g=0;
		$g=$this->GlobalModel->queryManualRow("SELECT * FROM gaji_finishing WHERE hapus=0 AND DATE(tanggal1) >='".$tanggal1."' AND DATE(tanggal2) <='".$tanggal2."' AND bagian='FINISHING' ");
		if(!empty($g)){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$g['id']));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan'],'status_gaji'=>1));
				$data['fharian'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>$d['senin']==1?$gaji['gaji']:0,
					'selasa'=>$d['selasa']==1?$gaji['gaji']:0,
					'rabu'=>$d['rabu']==1?$gaji['gaji']:0,
					'kamis'=>$d['kamis']==1?$gaji['gaji']:0,
					'jumat'=>$d['jumat']==1?$gaji['gaji']:0,
					'sabtu'=>$d['sabtu']==1?$gaji['gaji']:0,
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
				);
			}
		}
		
		// borongan mesin
		$prods=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE id IN(SELECT idkaryawanharian FROM boronganmesin WHERE kategori LIKE 'KANCING%' OR kategori LIKE 'TRESS' OR kategori LIKE 'PASANG KANCING%' AND DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) AND status_gaji=1 ");
		$gajim=0;
		
		foreach($prods as $p){
			$gajimesin=$this->ReportModel->getGajiBorongan($p['id'],$tanggal1,$tanggal2);
			//$po=$this->ReportModel->getGajiBorongan_po($p['id'],$tanggal1,$tanggal2);
			$data['boronganmesin'][]=array(
				'nama'=>$p['nama'],
				'total'=>($gajimesin),
				'keterangan'=>null,
			);
			$gajim+=($gajimesin);
		}
		$data['bm']=count($data['boronganmesin']);
		//pre($data['boronganmesin']);
		$data['gajim']=$gajim;

		// cucian
		$c=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE status_gaji=1 AND id IN(SELECT idkaryawan FROM cucian WHERE hapus=0  AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
		$data['cucian']=[];
		$cucians=0;
		foreach($c as $p){
			$gajimesin=$this->ReportModel->GetGajiCucian($p['id'],$tanggal1,$tanggal2);
			$data['cucian'][]=array(
				'nama'=>$p['nama'],
				'total'=>($gajimesin),
				'keterangan'=>null,
			);
			$cucians+=($gajimesin);
		}

		//pre($data['cucian']);

		$data['cucians']=$cucians;

		// buang benang
		$bb=[];
		$bb=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE status_gaji=1 AND id IN(SELECT idkaryawan FROM buang_benang_finishing WHERE hapus=0 ) ");
		$bbs=0;
		if(!empty($bb)){
			foreach($bb as $p){
				$gajimesin=$this->ReportModel->GetGajibb($p['id'],$tanggal1,$tanggal2);
				$data['bb'][]=array(
					'nama'=>$p['nama'],
					'total'=>($gajimesin),
					'keterangan'=>null,
				);
				$bbs+=($gajimesin);
			}
		}

		//pre($bb);

		$data['bbs']=$bbs;

		// Packing
		$pk=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE status_gaji=1 AND id IN(SELECT idkaryawanharian FROM packing WHERE hapus=0 AND DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."') ");
		$pkg=0;
		foreach($pk as $p){
			$gajimesin=$this->ReportModel->GetGajipacking($p['id'],$tanggal1,$tanggal2);
			$data['pk'][]=array(
				'nama'=>$p['nama'],
				'total'=>($gajimesin),
				'keterangan'=>null,
			);
			$pkg+=($gajimesin);
		}

		$data['pkg']=$pkg;

		$data['gtotal']=$gajim+$cucians+$bbs+$pkg;

		// details

		$borongan=$this->GlobalModel->queryManual("SELECT * FROM karyawan_harian WHERE  status_gaji=1 AND id IN(SELECT idkaryawanharian FROM boronganmesin WHERE kategori LIKE 'KANCING%' OR kategori LIKE 'TRESS' OR kategori LIKE 'PASANG KANCING%' AND DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
		$data['no']=1;
		$data['no2']=1;
		$data['no3']=1;
		$data['kancing']=[];
		foreach($borongan as $p){
			$lobangkancing=$this->GlobalModel->QueryManual("SELECT * FROM boronganmesin WHERE  hapus=0 and kategori LIKE 'LOBANG KANCING' AND DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND idkaryawanharian='".$p['id']."' and hapus=0");
			$pasangkancing=$this->GlobalModel->QueryManual("SELECT * FROM boronganmesin WHERE hapus=0 and  kategori LIKE 'PASANG KANCING' AND DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND idkaryawanharian='".$p['id']."' and hapus=0");
			$tress=$this->GlobalModel->QueryManual("SELECT * FROM boronganmesin WHERE hapus=0 and  kategori LIKE 'TRESS' AND DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND idkaryawanharian='".$p['id']."' and hapus=0");
			$data['kancing'][]=array(
				'nama'=>$p['nama'],
				'lobangkancing'=>$lobangkancing,
				'pasangkancing'=>$pasangkancing,
				'tress'=>$tress,
			);
		}

		$cuci=$this->GlobalModel->queryManual("SELECT * FROM karyawan_harian WHERE  status_gaji=1 AND id IN(SELECT idkaryawan FROM cucian WHERE DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
		$data['cu']=[];
		foreach($cuci as $p){
			$tress=$this->GlobalModel->QueryManual("SELECT * FROM cucian WHERE DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND idkaryawan='".$p['id']."' and hapus=0 ");
			$data['cu'][]=array(
				'nama'=>$p['nama'],
				'details'=>$tress,
			);
		}

		// buang benang 
		$buangb=$this->GlobalModel->queryManual("SELECT * FROM karyawan_harian WHERE  status_gaji=1 AND id IN(SELECT idkaryawan FROM buang_benang_finishing WHERE DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
		$data['buangb']=[];
		foreach($buangb as $p){
			$tress=$this->GlobalModel->QueryManual("SELECT * FROM buang_benang_finishing WHERE DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND idkaryawan='".$p['id']."' and hapus=0 ");
			$data['buangb'][]=array(
				'nama'=>$p['nama'],
				'details'=>$tress,
			);
		}

		// packing
		$pck=$this->GlobalModel->queryManual("SELECT * FROM karyawan_harian WHERE  status_gaji=1 AND id IN(SELECT idkaryawanharian FROM packing WHERE DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ) ");
		$data['pck']=[];
		foreach($pck as $p){
			$tress=$this->GlobalModel->QueryManual("SELECT * FROM packing WHERE DATE(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND idkaryawanharian='".$p['id']."' and hapus=0 ");
			$data['pck'][]=array(
				'nama'=>$p['nama'],
				'details'=>$tress,
			);
		}

		if(isset($get['excel'])){
			$this->load->view($this->page.'finishing/resumegaji_excel',$data);
		}else{
			$data['page']=$this->page.'finishing/resumegaji';
			$this->load->view($this->page.'main',$data);
		}
		
	}
	
	public function kirimsetor(){
		$data=[];
		$data['title']='Laporan Kirim Setor CMT';
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
		$data['products']=[];
		$results=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$no=1;
		$stokawalkaosjml=0;
		$stokawalkaosdz=0;
		$stokawalkemejajml=0;
		$stokawalkemejadz=0;
		$setorkaosjml=0;
		$setorkaosdz=0;
		$setorkemejajml=0;
		$setorkemejadz=0;
		$kirimkaosjml=0;
		$kirimkaosdz=0;
		$stokakhirkaosjml=0;
		$stokakhirkaosdz=0;
		$stokakhirkemejajml=0;
		$stokakhirkemejadz=0;
		$kjahit='JAHIT';
		foreach($results as $c){

			$stokawalkaosjml=$this->KirimsetorModel->awaljumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$stokawalkaosdz=$this->KirimsetorModel->awaldz(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$stokawalkemejajml=$this->KirimsetorModel->awaljumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$stokawalkemejadz=$this->KirimsetorModel->awaldz(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$setorkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'SETOR',$kjahit);
			$kirimkaosjml=$this->KirimsetorModel->jumlah(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkaosdz=$this->KirimsetorModel->dz(2,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejajml=$this->KirimsetorModel->jumlah(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$kirimkemejadz=$this->KirimsetorModel->dz(1,$tanggal1,$tanggal2,$c['id_cmt'],'KIRIM',$kjahit);
			$data['products'][]=array(
				'no'=>$no++,
				'nama'=>strtolower($c['cmt_name']),
				'stokawalkaosjml'=>$stokawalkaosjml,
				'stokawalkaosdz'=>$stokawalkaosdz,
				'stokawalkemejajml'=>$stokawalkemejajml,
				'stokawalkemejadz'=>$stokawalkemejadz,
				'setorkaosjml'=>$setorkaosjml,
				'setorkaosdz'=>$setorkaosdz,
				'setorkemejajml'=>$setorkemejajml,
				'setorkemejadz'=>$setorkemejadz,
				'kirimkaosjml'=>$kirimkaosjml,
				'kirimkaosdz'=>$kirimkaosdz,
				'kirimkemejajml'=>$kirimkemejajml,
				'kirimkemejadz'=>$kirimkemejadz,
				'stokakhirkaosjml'=>($stokawalkaosjml-$setorkaosjml+$kirimkaosjml),
				'stokakhirkaosdz'=>($stokawalkaosdz-$setorkaosdz+$kirimkaosdz),
				'stokakhirkemejajml'=>($stokawalkemejajml-$setorkemejajml+$kirimkemejajml),
				'stokakhirkemejadz'=>($stokawalkemejadz-$setorkemejadz+$kirimkemejadz),
			);
		}
		if(isset($get['excel'])){
			$this->load->view($this->page.'finishing/kirimsetor_excel',$data);
		}else{
			$data['page']=$this->page.'finishing/kirimsetor';
			$this->load->view($this->page.'main',$data);	
		}
		
	}

	public function gajifinishing(){
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
		$data['title']='Gaji Finishing';
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		//$data['harian']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0,'tipe'=>1));
		$data['harian']=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE hapus=0 and tipe=1 AND bagian LIKE '%FINISHING%' ");
		$data['action']=BASEURL.'Finishing/gajifinishingsave';
		$data['page']=$this->page.'finishing/gaji_finishing';
		$this->load->view($this->page.'main',$data);
	}

	public function gajifinishingsave(){
		$data=$this->input->post();
		$cek=$this->GlobalModel->getDataRow('gaji_finishing',array('tanggal1'=>$data['tanggal1'],'bagian'=>'FINISHING'));
		//pre($cek);
		if(!empty($cek)){
			$this->session->set_flashdata('msgt','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Finishing/gajifinishing');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'bagian'	=>'FINISHING',
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
					'senin'=>isset($p['senin'])?1:0,
					'selasa'=>isset($p['selasa'])?1:0,
					'rabu'=>isset($p['rabu'])?1:0,
					'kamis'=>isset($p['kamis'])?1:0,
					'jumat'=>isset($p['jumat'])?1:0,
					'sabtu'=>isset($p['sabtu'])?1:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lembur'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
				);
				$this->db->insert('gaji_finishing_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Finishing/gajifinishing');
	}

	public function pengirimangudang(){
		$data=array();
		$data['title']='Pengiriman Gudang';
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

		$sql='SELECT * FROM finishing_kirim_gudang WHERE id_finishing_kirim_gudang>0 ';
		if(isset($tanggal1)){
			$sql.=" AND date(tanggal_kirim) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}

		$data['notarincian'] = $this->GlobalModel->queryManual($sql);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['page']='finishing/nota/nota-kirim-view';
		$this->load->view($this->page.'main',$data);
	}

	public function hapuskgudang($id){
		$this->db->delete('finishing_kirim_gudang',array('id_finishing_kirim_gudang'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di hapus');
		redirect(BASEURL.'Finishing/pengirimangudang');
	}
	public function cucian(){
		$data=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'Finishing/cuciantambah';
		$data['title']="Cucian / Laundry";
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$results=array();
		$data['products']=array();
		$sql="SELECT * FROM cucian WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->queryManual($sql);
		$nama=null;
		$no=1;
		foreach($results as $r){
			$nama=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$r['idkaryawan']));
			$data['products'][]=array(
				'no'=>$no++,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'idkaryawan'=>strtolower($nama['nama']),
				'nama_po'=>strtoupper($r['kode_po']),
				'jumlah_pcs'=>$r['jumlah_pcs'],
				'harga'=>number_format($r['harga']),
				'total'=>number_format($r['total']),
				'keterangan'=>strtolower($r['keterangan']),
				'hapus'=>BASEURL.'Finishing/cuciandel/'.$r['id'],
			);
		}
		$data['page']=$this->page.'finishing/cucian_list';
		$this->load->view($this->page.'main',$data);
	}

	function cuciandel($id){
		$update=array(
			'hapus'=>1,
		);
		$this->db->update('cucian',$update,array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect(BASEURL.'Finishing/cucian');
	}

	public function cuciantambah(){
		$data=array();
		$data['n']=1;
		$data['action']=BASEURL.'Finishing/cuciansave';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$data['title']="Form Cucian / Laundry";
		$data['page']=$this->page.'finishing/cucian_form';
		$this->load->view($this->page.'main',$data);
	}

	public function cuciansave(){
		$data=$this->input->post();
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>isset($data['creted_date'])?$data['creted_date']:date('Y-m-d'),
					'idkaryawan'=>$data['idkaryawanharian'],
					'kode_po'=>$p['kode_po'],
					'jumlah_pcs'=>$p['jumlah_pcs'],
					'harga'=>$p['harga'],
					'total'=>$p['harga']*$p['jumlah_pcs'],
					'keterangan'=>$p['keterangan'],
					'jenis'=>$data['jenis'],
					'hapus'=>0
				);
				$this->db->insert('cucian',$insert);
			}
			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
			redirect(BASEURL.'Finishing/cucian');
		}else{
			$this->session->set_flashdata('msg','Form harus diisi lengkap');
			redirect(BASEURL.'Finishing/cuciantambah');
		}
	}

	public function buangbenang(){
		$data=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'Finishing/buangbenangtambah';
		$data['title']="Buang Benang Finishing";
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$results=array();
		$data['products']=array();
		$sql="SELECT * FROM buang_benang_finishing WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY tanggal DESC ";
		$results=$this->GlobalModel->queryManual($sql);
		$nama=null;
		foreach($results as $r){
			$nama=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$r['idkaryawan']));
			$data['products'][]=array(
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'idkaryawan'=>strtolower($nama['nama']),
				'nama_po'=>strtoupper($r['kode_po']),
				'jumlah_pcs'=>$r['jumlah_pcs'],
				'harga'=>number_format($r['harga']),
				'total'=>number_format($r['total']),
				'keterangan'=>strtolower($r['keterangan']),
				'hapus'=>BASEURL.'Finishing/hapusbb/'.$r['id'],
			);
		}
		$data['page']=$this->page.'finishing/buangbenang_list';
		$this->load->view($this->page.'main',$data);
	}

	public function hapusbb($id){
		
		$update=array(
			'hapus'=>1
		);
		$this->db->update('buang_benang_finishing',$update,array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect(BASEURL.'Finishing/buangbenang');
	}

	public function buangbenangtambah(){
		$data=array();
		$data['n']=1;
		$data['action']=BASEURL.'Finishing/buangbenangsave';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$data['title']="Form Buang Benang Finishing";
		$data['page']=$this->page.'finishing/buangbenang_form';
		$this->load->view($this->page.'main',$data);
	}

	public function buangbenangsave(){
		$data=$this->input->post();
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>$data['creted_date'],
					'idkaryawan'=>$data['idkaryawanharian'],
					'kode_po'=>$p['kode_po'],
					'jumlah_pcs'=>$p['jumlah_pcs'],
					'harga'=>$p['harga'],
					'total'=>$p['harga']*$p['jumlah_pcs'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0
				);
				$this->db->insert('buang_benang_finishing',$insert);
			}
			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
			redirect(BASEURL.'Finishing/buangbenang');
		}else{
			$this->session->set_flashdata('msg','Form harus diisi lengkap');
			redirect(BASEURL.'Finishing/buangbenangtambah');
		}
	}

	public function packing(){
		$data=array();
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM packing WHERE hapus=0 ";
		$sql.=" AND date(creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY creted_date DESC ";
		$data['products']=$this->GlobalModel->queryManual($sql);
		$data['no']=1;
		$data['title']='Borongan Packing';
		$data['tambah']=BASEURL.'Finishing/packing_add';
		$data['page']=$this->page.'finishing/packing_list';
		//$data['products']=$this->GlobalModel->getData('packing',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	public function packing_add(){
		$data=array();
		$data['title']='Borongan Packing';
		$data['action']=BASEURL.'Finishing/packing_save';
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['page']=$this->page.'finishing/packing_form';
		$this->load->view($this->page.'main',$data);
	}

	function packingdel($id){
		$update=array(
			'hapus'=>1,
		);
		$this->db->update('packing',$update,array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect(BASEURL.'Finishing/packing');
	}

	public function packing_save(){
		$post=$this->input->post();
		foreach ($post['kodepo'] as $key => $kodepo) {
			$insertData = array(
				'nama_po'		=>	$kodepo,
				'jumlah_dz'	=>	$post['jumlahpcs'][$key],
				// 'jumlah_titik'	=>	$post['jumlahtitik'][$key],
				'harga_dz'	=>	$post['pricePerTitik'][$key],
				//'jumlah_pendapatan'	=>	$post['jumlahRp'][$key],
				'jumlah_pendapatan'=>$post['jumlahpcs'][$key]*$post['pricePerTitik'][$key],
				'keterangan'	=>	$post['keterangan'][$key],
				'kategori'	=>	$post['kategoriBorongan'],
				'creted_date'=>isset($data['creted_date'])?$data['creted_date']:date('Y-m-d'),
				'idkaryawanharian'=>$post['idkaryawanharian'],
			);
			$this->GlobalModel->insertData('packing',$insertData);
		}
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Finishing/packing');
	}

	function borongandel($id,$jenis){
		$update=array(
			'hapus'=>1,
		);
		$this->db->update('boronganmesin',$update,array('id_boronganmesin'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect(BASEURL.'Finishing/borongan/'.$jenis);
	}


	public function borongan($jenis){
		$data=array();
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['jen']=$jenis;
		if($jenis==1){
			$title="Lobang Kancing";
			$kategori="LOBANG KANCING";
		}else if($jenis==2){
			$title="Pasang Kancing";
			$kategori="PASANG KANCING";
		}else if($jenis==3){
			$title="Tress";
			$kategori="TRESS";
		}
		$data['title']=$title;
		$data['tambah']=BASEURL.'Finishing/borongantambah/'.$jenis;
		$data['page']=$this->page.'finishing/borongan_list';
		$sql="SELECT boronganmesin.*,ki.nama as karyawan FROM boronganmesin JOIN karyawan_harian ki ON(ki.id=boronganmesin.idkaryawanharian) WHERE boronganmesin.hapus=0 and boronganmesin.kategori='$kategori' ";
		$sql.=" AND date(boronganmesin.creted_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY boronganmesin.creted_date DESC ";
		//$data['products']=$this->GlobalModel->getData('boronganmesin',array('kategori'=>$kategori,'hapus'=>0));
		$data['products']=$this->GlobalModel->queryManual($sql);
		$this->load->view($this->page.'main',$data);
	}

	public function borongantambah($jenis){
		$data=array();
		$ket=null;
		if($jenis==1){
			$title="Lobang Kancing";
			$kategori="LOBANG KANCING";
			$ket="SKF jumlah titik diisi dengan 4<br>
				  KFB jumlah titik diisi dengan 5<br>
				  KKF jumlah titik diisi dengan 8";
		}else if($jenis==2){
			$title="Pasang Kancing";
			$kategori="PASANG KANCING";
			$ket="SKF jumlah titik diisi dengan 4<br>
				  KFB jumlah titik diisi dengan 5<br>
				  KKF jumlah titik diisi dengan 8";
		}else if($jenis==3){
			$title="Tress";
			$kategori="TRESS";
		}
		$data['ket']=$ket;
		$data['title']=$title;
		$data['kategori']=$kategori;
		$data['jenis']=$jenis;
		$data['action']=BASEURL.'Finishing/borongantambahsave/'.$jenis;
		$data['batal']=BASEURL.'Finishing/borongan/'.$jenis;
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['page']=$this->page.'finishing/borongan_form';
		$this->load->view($this->page.'main',$data);
	}

	public function borongantambahsave($jenis){
		$post=$this->input->post();
		//pre($post); exit();
		if($jenis==1){
			$title="Lobang Kancing";
			$kategori="LOBANG KANCING";
		}else if($jenis==2){
			$title="Pasang Kancing";
			$kategori="PASANG KANCING";
		}else if($jenis==3){
			$title="Tress";
			$kategori="TRESS";
		}

		foreach ($post['kodepo'] as $key => $kodepo) {
			$insertData = array(
				'nama_po'		=>	$kodepo,
				'jumlah_pcs'	=>	$post['jumlahpcs'][$key],
				'jumlah_titik'	=>	$post['jumlahtitik'][$key],
				'harga_titik'	=>	$post['pricePerTitik'][$key],
				//'jumlah_pendapatan'	=>	$post['jumlahRp'][$key],
				'jumlah_pendapatan'=>$post['jumlahpcs'][$key]*$post['jumlahtitik'][$key]*$post['pricePerTitik'][$key],
				'keterangan'	=>	$post['keterangan'][$key],
				'kategori'	=>	$post['kategoriBorongan'],
				'creted_date'	=>	isset($post['creted_date'])?$post['creted_date']:date('Y-m-d'),
				'idkaryawanharian'=>$post['idkaryawanharian'],
				'perkalian'=>isset($post['perkalian'][$key])?$post['perkalian'][$key]:1,
			);
			$this->GlobalModel->insertData('boronganmesin',$insertData);
		}
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Finishing/borongan/'.$jenis);

	}

	
	public function karyawan(){
		$data=array();
		$data['n']=1;
		$data['action']=BASEURL.'Finishing/karyawansave';
		$data['update']=BASEURL.'Finishing/karyawaneditsave';
		$data['products']=array();
		$user=user();
		$edit=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
		}
		$data['edit']=$edit;
		$data['ubah']=BASEURL.'Finishing/karyawanubah/';
		$data['hapus']=BASEURL.'Finishing/karyawanhapus/';
		$products=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$borongan=array();
		foreach($products as $p){
			$borongan=$this->GlobalModel->getData('gajiborongan',array('idkaryawanharian'=>$p['id']));
			$data['products'][]=array(
				'id'=>$p['id'],
				'nama'=>$p['nama'],
				'bagian'=>$p['bagian'],
				'tipe'=>$p['tipe'],
				'gaji'=>$p['gaji'],
				'perminggu'=>$p['perminggu'],
				'borongan'=>$borongan,
			);
		}
		$data['page']=$this->page.'finishing/karyawan_list';
		$this->load->view($this->page.'main',$data);
	}

	public function karyawanhapus($id){
		$insert=array(
			'hapus'=>1,
		);
		$this->db->update('karyawan_harian',$insert,array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect(BASEURL.'finishing/karyawan');
	}

	public function karyawansave(){
		$data=$this->input->post();
		$insert=array(
			'nama'=>$data['nama'],
			'bagian'=>$data['bagian'],
			'tipe'=>$data['tipe'],
			'gaji'=>0,
			'perminggu'=>0,
			'status_gaji'=>isset($data['status_gaji'])?$data['status_gaji']:1,
			'hapus'=>0,
		);
		$this->db->insert('karyawan_harian',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Finishing/karyawan');
	}

	public function karyawanubah($id){
		$data=array();
		$data['n']=1;
		$data['action']=BASEURL.'Finishing/karyawaneditsave';
		$data['update']=BASEURL.'Finishing/karyawaneditsave';
		$data['products']=array();
		$user=user();
		$edit=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
		}
		$data['edit']=$edit;
		$data['ubah']=BASEURL.'Finishing/karyawanubah/';
		$data['hapus']=BASEURL.'Finishing/karyawanhapus/';
		$data['products']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0,'id'=>$id));
		$data['borongan']=$this->GlobalModel->getDataRow('gajiborongan',array('idkaryawanharian'=>$id));
		$data['page']=$this->page.'finishing/karyawan_edit';
		$this->load->view($this->page.'main',$data);
	}

	public function karyawaneditsave(){
		$data=$this->input->post();
		$insert=array(
			'nama'=>$data['nama'],
			'bagian'=>$data['bagian'],
			'gaji'=>($data['perminggu']/6),
			'perminggu'=>$data['perminggu'],
			'tipe'=>$data['tipe'],
		);
		$this->db->update('karyawan_harian',$insert,array('id'=>$data['id']));
		if(isset($data['gajiborongan'])){
			$this->db->query("DELETE FROM gajiborongan WHERE idkaryawanharian='".$data['id']."' ");
			if($data['tipe']==2){
				$gb=array(
					'idkaryawanharian'=>$data['id'],
					'tress'=>$data['gajiborongan']['tress'],
					'lobangkancing'=>$data['gajiborongan']['lobangkancing'],
					'pasangkancing'=>$data['gajiborongan']['pasangkancing'],
					'keterangan'=>$data['gajiborongan']['keterangan'],
				);
				$this->db->insert('gajiborongan',$gb);
			}
		}
		$this->session->set_flashdata('msg','Data Berhasil Di Diubah');
		redirect(BASEURL.'finishing/karyawan');
	}

	
	public function rinciansetorkaoscmt($idkode='')
	{
		$tanggal1=date('Y-m-d',strtotime("-1 month"));
		$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		$rincian = $this->GlobalModel->queryManual('SELECT * FROM produksi_po pp JOIN kelolapo_kirim_setor kks ON pp.kode_po=kks.kode_po WHERE kks.progress="'.'SELESAI'.'" OR kks.progress="'.'FINISHING'.'" ');
		//$rincian = $this->GlobalModel->queryManual('SELECT * FROM produksi_po pp JOIN kelolapo_kirim_setor kks ON pp.kode_po=kks.kode_po WHERE kks.progress="SETOR" AND kks.kategori_cmt="JAHIT"  AND DATE(create_date) BETWEEN "'.$tanggal1.'" AND "'.$tanggal2.'"  AND pp.kode_po NOT IN(SELECT kode_po FROM kelolapo_rincian_setor_cmt) ORDER BY kks.create_date DESC ');
		foreach ($rincian as $key => $rinci) {
			$viewData['rincian'][$key]['kode_po'] = $rinci['kode_po'];
			$viewData['rincian'][$key]['nama_cmt'] =$rinci['nama_cmt'];
			$viewData['rincian'][$key]['kategori_cmt'] =$rinci['kategori_cmt'];
			$viewData['rincian'][$key]['progress']=$rinci['progress'];
			$viewData['rincian'][$key]['qty_tot_pcs']=$rinci['qty_tot_pcs'];
			$viewData['rincian'][$key]['created_date']=$rinci['created_date'];
			$viewData['rincian'][$key]['rincianSetor']=$this->GlobalModel->getDataRow('kelolapo_rincian_setor_cmt',array('kode_po'=>$rinci['kode_po']));
		}
		// pre($viewData);
		//$this->load->view('global/header');
		$viewData['page']='kelolapo/rinciansetor/rincian-setor-view';
		$this->load->view($this->page.'main',$viewData);
		//$this->load->view('global/footer');
	}

	public function produksikaoscmt($kodepo='')
	{
		$viewData['poProd']	= $this->GlobalModel->queryManualRow('SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po JOIN konveksi_buku_potongan kbp ON kks.kode_po=kbp.kode_po WHERE (kks.progress="'.'FINISHING'.'" OR  kks.progress="'.'SELESAI'.'") AND kks.kode_po="'.$kodepo.'"');
		$viewData['progress'] = $this->GlobalModel->getData('proggresion_po',null);
		$viewData['atas'] =[];
		$viewData['bawah'] =[];
		if(!empty($viewData['poProd'])){
			$viewData['atas'] = $this->GlobalModel->getData('kelolapo_kirim_setor_atas',array('kode_po'=>$kodepo,'id_kelolapo_kirim_setor'=>$viewData['poProd']['id_kelolapo_kirim_setor']));	
			$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_kirim_setor_bawah',array('kode_po'=>$kodepo,'id_kelolapo_kirim_setor'=>$viewData['poProd']['id_kelolapo_kirim_setor']));
		}
		
		
		// pre($viewData);
		$viewData['size'] = $this->GlobalModel->getData('master_size',null);
		$viewData['setorcmtjahit'] = $this->GlobalModel->getDataRow('kelolapo_rincian_setor_cmt',array('kode_po'=>$kodepo));
		//pre($viewData['setorcmtjahit']);
		$viewData['setorcmtjahititem']=[];
		if(!empty($viewData['setorcmtjahit'])){
			$viewData['setorcmtjahititem'] = $this->GlobalModel->getData('kelolapo_rincian_setor_cmt_finish',array('id_kelolapo_rincian_setor_cmt'=>$viewData['setorcmtjahit']['id_kelolapo_rincian_setor_cmt']));
		}
		
		// pre($viewData);
		//$this->load->view('global/header');
		$viewData['page']='kelolapo/rinciansetor/rincian-setor-tambah';
		$this->load->view($this->page.'main',$viewData);
		//$this->load->view('global/footer');
	}

	public function produksikaoscmtAct($value='')
	{
		$post = $this->input->post();
		$pcs = 0;
		$jml = 0;
		$bangke = 0;
		$barangccd = 0;$barangHilang=0;$barangClaim=0;
		foreach ($post['rinciansize'] as $key => $rinciansize) {
			$pcs += $post['rincianpiece'][$key];
			$jml += $post['rincianlusin'][$key]*12;
			$bangke += $post['banke'][$key];
			$barangccd += $post['barangCacad'][$key];
			$barangHilang += $post['hilangBarang'][$key];
			$barangClaim += $post['claimBarang'][$key];
		}
		// pre($post);

		$jmlYangDisetor = ((($jml + $pcs) + $bangke) + $barangHilang + $barangccd);
		
		if ($jmlYangDisetor == $post['jumlahditerima']) {

			$dataInput = $this->GlobalModel->getDataRow('kelolapo_rincian_setor_cmt',array('kode_po' => $post['kode_po'],));

			$insertData = array(
				'kode_po'			=>	$post['kode_po'],
				'pcs_setor_qty'		=>	$pcs,
				'jml_setor_qty'		=>	$jmlYangDisetor,
				'bangke_qty'		=>	$bangke,
				'barang_cacad_qty'	=>	$barangccd,
				'nama_cmt'			=>	$post['nama_cmt'],
				'barang_claim_qty'	=>	$barangClaim,
				'barang_hilang_qty'	=>	$barangHilang,
				'created_date'		=>	date('Y-m-d'),
				'jumlah_piece_diterima'	=> $post['jumlahditerima']
			);

			if (empty($dataInput)) {
				$this->GlobalModel->insertData('kelolapo_rincian_setor_cmt',$insertData);
				$lastId = $this->db->insert_id();
			} else {
				$this->session->set_flashdata('msg','INPUT NYA SANTAI AJA DONG, KODE PO INI SUDAH DI INPUT!!! <audio controls autoplay loop style="display:none;"><source src="'.BASEURL.'assets/mp3/kunti.mp3" type="audio/mpeg"></audio>');
				redirect(BASEURL.'finishing/produksikaoscmt/'.$post['kode_po']);
			}
			

			foreach ($post['rinciansize'] as $key => $rin) {
				$insertRincinan = array(
					'id_kelolapo_rincian_setor_cmt'	=>	$lastId,
					'kode_po'	=> $post['kode_po'],
					'rincian_size'	=> $rin,
					'rincian_lusin'	=> $post['rincianlusin'][$key],
					'rincian_piece'	=> $post['rincianpiece'][$key],
					'rincian_keterangan'	=> $post['keterangan'][$key],
					'rincian_bangke' 	=>	$post['banke'][$key],
					'rincian_reject' 	=>	$post['barangCacad'][$key],
					'rincian_claim' 	=>	$post['claimBarang'][$key],
					'rincian_hilang'	=>	$post['hilangBarang'][$key],
					'created_date'	=> date('Y-m-d')
				);
				$this->GlobalModel->insertData('kelolapo_rincian_setor_cmt_finish',$insertRincinan);
			}
			$this->GlobalModel->updateData('kelolapo_kirim_setor',array('progress'=>'SELESAI','kode_po'=>$post['kode_po']),array('progress'=>'FINISHING'));
			$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kode_po']),array('jumlah_pcs_po'=>($jmlYangDisetor - $bangke),'id_proggresion_po' => $post['progresName']));
		} else {
			$this->session->set_flashdata('msg','Perhatikan jumlah yang diterima!!! <audio controls autoplay loop style="display:none;"><source src="'.BASEURL.'assets/mp3/mandrakerja.mp3" type="audio/mpeg"></audio>');
			redirect(BASEURL.'finishing/produksikaoscmt/'.$post['kode_po']);
		}

		redirect(BASEURL.'finishing/rinciansetorkaoscmt');
	}

	public function editsetoran($kodepo='')
	{
		$viewData['poProd']	= $this->GlobalModel->queryManualRow('SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po JOIN konveksi_buku_potongan kbp ON kks.kode_po=kbp.kode_po WHERE (kks.progress="'.'FINISHING'.'" OR  kks.progress="'.'SELESAI'.'") AND kks.kode_po="'.$kodepo.'"');
		$viewData['progress'] = $this->GlobalModel->getData('proggresion_po',null);
		$viewData['atas'] = $this->GlobalModel->getData('kelolapo_kirim_setor_atas',array('kode_po'=>$kodepo,'id_kelolapo_kirim_setor'=>$viewData['poProd']['id_kelolapo_kirim_setor']));
		$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_kirim_setor_bawah',array('kode_po'=>$kodepo,'id_kelolapo_kirim_setor'=>$viewData['poProd']['id_kelolapo_kirim_setor']));
		// pre($viewData);
		$viewData['size'] = $this->GlobalModel->getData('master_size',null);
		$viewData['setorcmtjahit'] = $this->GlobalModel->getDataRow('kelolapo_rincian_setor_cmt',array('kode_po'=>$kodepo));
		$viewData['setorcmtjahititem'] = $this->GlobalModel->getData('kelolapo_rincian_setor_cmt_finish',array('id_kelolapo_rincian_setor_cmt'=>$viewData['setorcmtjahit']['id_kelolapo_rincian_setor_cmt']));
		// pre($viewData);
		//$this->load->view('global/header');
		$viewData['page']='kelolapo/rinciansetor/rincian-setor-edit';
		$viewData['editaction']=BASEURL.'Finishing/editsave';
		$this->load->view($this->page.'main',$viewData);
		//$this->load->view('global/footer');
	}

	public function editsave(){
		$post = $this->input->post();
		$pcs = 0;
		$jml = 0;
		$bangke = 0;
		$barangccd = 0;$barangHilang=0;$barangClaim=0;
		foreach ($post['rinciansize'] as $key => $rinciansize) {
			$pcs += $post['rincianpiece'][$key];
			$jml += $post['rincianlusin'][$key]*12;
			$bangke += $post['banke'][$key];
			$barangccd += $post['barangCacad'][$key];
			$barangHilang += $post['hilangBarang'][$key];
			$barangClaim += $post['claimBarang'][$key];
		}
		// pre($post);

		$jmlYangDisetor = ((($jml + $pcs) + $bangke) + $barangHilang + $barangccd);
		if ($jmlYangDisetor == $post['jumlahditerima']) {
			$dataInput = $this->GlobalModel->getDataRow('kelolapo_rincian_setor_cmt',array('kode_po' => $post['kode_po'],));
			$insertData = array(
				'kode_po'			=>	$post['kode_po'],
				'pcs_setor_qty'		=>	$pcs,
				'jml_setor_qty'		=>	$jmlYangDisetor,
				'bangke_qty'		=>	$bangke,
				'barang_cacad_qty'	=>	$barangccd,
				'nama_cmt'			=>	$post['nama_cmt'],
				'barang_claim_qty'	=>	$barangClaim,
				'barang_hilang_qty'	=>	$barangHilang,
				'created_date'		=>	date('Y-m-d'),
				'jumlah_piece_diterima'	=> $post['jumlahditerima']
			);

			$this->db->update('kelolapo_rincian_setor_cmt',$insertData,array('id_kelolapo_rincian_setor_cmt'=>$dataInput['id_kelolapo_rincian_setor_cmt']));
			

			foreach ($post['rinciansize'] as $key => $rin) {
				$insertRincinan = array(
					'id_kelolapo_rincian_setor_cmt_finish'=>$post['idr'][$key],
					'id_kelolapo_rincian_setor_cmt'	=>$dataInput['id_kelolapo_rincian_setor_cmt'],
					'kode_po'	=> $post['kode_po'],
					'rincian_size'	=> $rin,
					'rincian_lusin'	=> $post['rincianlusin'][$key],
					'rincian_piece'	=> $post['rincianpiece'][$key],
					'rincian_keterangan'	=> $post['keterangan'][$key],
					'rincian_bangke' 	=>	$post['banke'][$key],
					'rincian_reject' 	=>	$post['barangCacad'][$key],
					'rincian_claim' 	=>	$post['claimBarang'][$key],
					'rincian_hilang'	=>	$post['hilangBarang'][$key],
					'created_date'	=> date('Y-m-d')
				);
				
				$this->db->update('kelolapo_rincian_setor_cmt_finish',$insertRincinan,array('id_kelolapo_rincian_setor_cmt_finish'=>$post['idr'][$key]));
			}
			$this->GlobalModel->updateData('kelolapo_kirim_setor',array('progress'=>'SELESAI','kode_po'=>$post['kode_po']),array('progress'=>'FINISHING'));
			$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kode_po']),array('jumlah_pcs_po'=>($jmlYangDisetor - $bangke),'id_proggresion_po' => $post['progresName']));
		} else {
			$this->session->set_flashdata('msg','Perhatikan jumlah yang diterima!!! <audio controls autoplay loop style="display:none;"><source src="'.BASEURL.'assets/mp3/mandrakerja.mp3" type="audio/mpeg"></audio>');
			redirect(BASEURL.'finishing/editsetoran/'.$post['kode_po']);
		}

		redirect(BASEURL.'finishing/rinciansetorkaoscmt');
	}

	public function hppproduksi()
	{
		$viewData['title']='HPP Produksi';
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		$viewData['kode_po']=$kode_po;
		$sql='SELECT * FROM produksi_po pp JOIN konveksi_buku_potongan kbp ON pp.kode_po = kbp.kode_po JOIN kelolapo_rincian_setor_cmt krsc ON pp.kode_po = krsc.kode_po WHERE id_produksi_po >0 ';
		if(!empty($kode_po)){
			$sql.=" AND pp.kode_po LIKE '$kode_po%' ";
		}
		$sql.=" ORDER BY pp.id_produksi_po DESC LIMIT 50";
		$viewData['produk'] = $this->GlobalModel->queryManual($sql);		
 		// $this->load->view('global/header');
		// $this->load->view('finishing/hpp/hpp-view',$viewData);
		// $this->load->view('global/footer');
		$viewData['page']='finishing/hpp/hpp-view';
		$this->load->view('newtheme/page/main',$viewData);

	}

	public function hppproduksidetail($kodepo='')
	{
		$viewData['produk'] = $this->GlobalModel->queryManualRow('SELECT * FROM produksi_po pp JOIN konveksi_buku_potongan kbp ON pp.kode_po = kbp.kode_po JOIN kelolapo_rincian_setor_cmt krsc ON pp.kode_po = krsc.kode_po WHERE pp.kode_po="'.$kodepo.'"');
		$viewData['variasi']=null;
		$viewData['variasi']=$this->GlobalModel->getDataRow('gudang_bahan_keluar',array('bahan_kategori'=>'VARIASI','hapus'=>0));
		//pre($viewData['produk']);
		//pre($viewData['produk']['kode_po']);
		$timpotong=$this->GlobalModel->getDataRow("konveksi_buku_potongan",array('kode_po'=>$kodepo));
		$namatim=$this->GlobalModel->getDataRow("timpotong",array('id'=>$viewData['produk']['tim_potong_potongan']));
		if(!empty($namatim)){
			$viewData['timpotong']=$namatim['nama'];
		}else{
			$viewData['timpotong']=$viewData['produk']['tim_potong_potongan'];
		}

		$namapo=$viewData['produk']['nama_po'];
		$jenis=$this->GlobalModel->getDataRow('master_jenis_po',array('nama_jenis_po'=>$namapo));
		if($jenis['idjenis']==1){
			$viewData['jenis'] ='KEMEJA';
		}else if($jenis['idjenis']==2){
			$viewData['jenis'] ='KAOS';
		}else{
			$viewData['jenis'] ='CELANA';
		}
		$viewData['jenispo']=$jenis;
		$viewData['cucianhpp']=$this->GlobalModel->getDataRow('master_jenis_po',array('nama_jenis_po'=>$namapo));
		$viewData['perincian'] = $this->GlobalModel->getData('gudang_item_keluar',array('kode_po'=>$viewData['produk']['kode_po'],'hapus'=>0));

		$viewData['cmt'] =	$this->GlobalModel->getData('kelolapo_kirim_setor',array('kode_po'=>$viewData['produk']['kode_po'],'progress'=>'KIRIM','hapus'=>0));
		// pre($viewData['cmt']);
		$viewData['master_harga_potongan'] = $this->GlobalTwoModel->getDataRow('master_harga_potongan',array('hapus'=>0,'nama_jenis_po'=>$viewData['produk']['nama_po']));

		$bi	= $this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po' => $kodepo));
		$b2	= $this->GlobalModel->QueryManualRow("SELECT jumlah_pemakaian_bahan_variasi FROM konveksi_buku_potongan WHERE refpo='".$kodepo."' ");
		if(!empty($b2)){
			$bp=array_merge($bi,$b2);
		}else{
			$bp=$bi;
		}

		//pre($bp);
		$viewData['bukupotongan']=$bp;
		

		$viewData['operation']	= $this->GlobalModel->getDataRow('operational',array('id_operational'=>1));

		$viewData['bordirer'] = $this->GlobalModel->queryManual('SELECT * FROM kelola_mesin_bordir WHERE kode_po = "'.$kodepo.'" AND hapus=0 ');
		if(callSessUser('nama_user')=="Pawitx"){
			pre($viewData['bukupotongan']);
		}

		$b3	= $this->GlobalModel->QueryManualRow("SELECT kode_po FROM konveksi_buku_potongan WHERE refpo='".$kodepo."' ");
		
		if(!empty($b3)){
			$viewData['bahan'] = $this->GlobalModel->queryManual('SELECT DISTINCT bahan_kategori,harga_item,resiko_bahan FROM gudang_bahan_keluar WHERE hapus=0 AND kode_po="'.$kodepo.'" OR kode_po="'.$b3['kode_po'].'" GROUP BY bahan_kategori ORDER BY harga_item ASC ');
		}else{
			$viewData['bahan'] = $this->GlobalModel->queryManual('SELECT DISTINCT bahan_kategori,harga_item,resiko_bahan FROM gudang_bahan_keluar WHERE hapus=0 AND kode_po="'.$kodepo.'" ');	
		}

		$viewData['bahanKantong'] = $this->GlobalModel->queryManualRow("SELECT * FROM gudang_bahan_keluar WHERE kode_po='".$kodepo."' AND bahan_kategori LIKE '%KAINKANTONG%' AND hapus=0");
		
		$viewData['boronganmesin']= $this->GlobalModel->getData('boronganmesin',array('nama_po'=>$kodepo,'hapus'=>0));
		
		$viewData['buangbenang']=[];
		$viewData['buangbenang']= $this->GlobalModel->getData('buang_benang_finishing',array('kode_po'=>$kodepo,'hapus'=>0));
		$viewData['packing']=[];
		$namapo=$viewData['produk']['nama_po'];
		if(strtolower($namapo)=="kfb" OR strtolower($namapo)=="kkf"){
			$viewData['packing']=array(
				array(
					'harga_dz'=>12000,
					'keterangan'=>'Packing',
				),
			);
		}else if(strtolower($namapo)=="skf"){
			$viewData['packing']=array(
				array(
					'harga_dz'=>24000,
					'keterangan'=>'Packing',
				),
			);
		}else{
			$viewData['packing']= $this->GlobalModel->getData('packing',array('nama_po'=>$kodepo,'hapus'=>0));
		}
		
		$viewData['cucian']=[];
		$viewData['cucian']= $this->GlobalModel->getData('cucian',array('kode_po'=>$kodepo,'hapus'=>0));

		$bawahansablon=0;
		$bs=$this->GlobalModel->QueryManualRow("SELECT SUM(price) as total FROM sablonbawahan WHERE hapus=0 AND kode_po='".$kodepo."' ");
		if(!empty($bs)){
			$bawahansablon=$bs['total'];
		}
		//pre($bs);
		$cmt=$this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kategori_cmt'=>'JAHIT','progress'=>'SETOR','kode_po'=>$kodepo));
		//pre($cmt);
		$biayalain=null;
		$biayalain=$this->GlobalModel->getData('biaya_hpp',array('hapus'=>0,'namapo'=>$namapo,'idcmt'=>$cmt['id_master_cmt']));
		$viewData['biayalain']=$biayalain;
		$viewData['bawahansablon']=$bawahansablon;
		$viewData['page']='finishing/hpp/hpp-detail';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function hppproduksidetailAct()
	{
		$post = $this->input->post();
		//pre($post);
		$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kodepo']),array('harga_satuan'=>$post['hargasatuan']));
		redirect(BASEURL.'finishing/hppproduksidetail/'.$post['kodepo']);
	}

	public function submitImageHppsat()
	{
		$config['upload_path']          = './uploads/hpp/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $post = $this->input->post();
        $this->load->library('upload', $config);
        $this->upload->do_upload('gambarPO1');
        $fileName = 'uploads/hpp/'.$this->upload->data('file_name');
        $this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kode_po']),array('gambar_po'=>$fileName));
        redirect(BASEURL.'finishing/hppproduksidetail/'.$post['kode_po']);
	}

	public function submitImageHppdua()
	{
		$config['upload_path']          = './uploads/hpp/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $post = $this->input->post();

        $this->load->library('upload', $config);
        $this->upload->do_upload('gambarPO2');
        $fileName = 'uploads/hpp/'.$this->upload->data('file_name');
        $this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kode_po']),array('gambar_po2'=>$fileName));
        redirect(BASEURL.'finishing/hppproduksidetail/'.$post['kode_po']);
	}


	public function submitOperational()

	{

		$post = $this->input->post();

		//if ($post['button'] == "SUBMIT") {

			$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kode_po']),array('operaitonal_price'=>$post['valOperation']));

        	redirect(BASEURL.'finishing/hppproduksidetail/'.$post['kode_po']);

		/*} else {

			$this->GlobalModel->updateData('operational',array('id_operational'=>1),array('val_operational'=>$post['valOperation']));

        	redirect(BASEURL.'finishing/hppproduksidetail/'.$post['kode_po']);

		}*/

		

	}


	public function kirimgudang($kodepo='')
	{
		$viewData['po'] = $this->GlobalModel->getData('produksi_po',NULL);
		$viewData['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$viewData['poproduksi'] = $this->GlobalModel->getData('produksi_po',null);
		$viewData['rincian'] = $this->GlobalModel->queryManual('SELECT * FROM produksi_po pp JOIN kelolapo_kirim_setor kks ON pp.kode_po=kks.kode_po WHERE kks.progress="'.'SELESAI'.'" OR kks.progress="'.'FINISHING'.'" ');
		// pre($viewData);
		//$this->load->view('global/header');
		$viewData['page']='finishing/kirimgudang/kirim-gudang-tambah';
		$this->load->view($this->page.'main',$viewData);
		//$this->load->view('global/footer');
	}

	public function kirimgudangsendRincinan()
	{
		$post = $this->input->get();
		$data = $this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$post['kodepo']));
		echo json_encode($data);
	}

	public function setorcmtjahit()
	{
		$post = $this->input->get();
		$data = $this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po'=>$post['kodepo'],'kategori_cmt'=>'JAHIT','progress'=>'SETOR'));
		echo json_encode($data);
	}

	public function kirimgudangforProd()
	{
		$post = $this->input->post();
		// pre($post);
		foreach ($post['kodepo'] as $key => $kodepo) {

		$dataInput = $this->GlobalModel->getDataRow('finishing_kirim_gudang',array('kode_po' => $kodepo));

			if (empty($dataInput)) {

			$dataKirim = array(
				'finishing_kirim_gudang_faktur'	=>	$post['noFaktur'],
				'tanggal_kirim'	=> $post['tanggalKirim']
			);
			$this->GlobalModel->insertData('finishing_kirim_gudang_faktur',$dataKirim);

			$setorFinishRinci = $this->GlobalModel->getData('kelolapo_rincian_setor_cmt_finish',array('kode_po'=>$kodepo));
				$dataInsert = array(
					'nofaktur'			=> 	$post['noFaktur'],
					'nama_penerima'		=>  $post['namaPenerima'],
					'tujuan'			=>	$post['tujuanItem'],
					'artikel_po'			=>	$post['artikel'][$key], 
					'kode_po'			=> 	$post['kodepo'][$key],
					'harga_satuan'		=> 	$post['hargasatuan'][$key],
					'jumlah_harga_piece'	=> 	$post['jumlahRinci'][$key] * $post['hargasatuan'][$key],
					'jumlah_piece_diterima'	=> $post['jumlahRinci'][$key],
					'keterangan'		=>	$post['keterangan'][$key],
					'created_date'		=> date('Y-m-d'),
					'tanggal_kirim'		=>	$post['tanggalKirim'],
					'susulan'			=> $post['susulan'],

				);
				$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$kodepo),array('id_proggresion_po'=>$post['proggress'],'progress_lokasi'=>'KIRIM GUDANG'));
				$this->GlobalModel->insertData('finishing_kirim_gudang',$dataInsert);
				$lastId = $this->db->insert_id();

				foreach ($setorFinishRinci as $key => $rincian) {
					$dataRincian = array(
						'id_finishing_kirim_gudang'		=> $lastId,
						'rincian_size'		=> $rincian['rincian_size'], 
						'rincian_lusin'		=> $rincian['rincian_lusin'], 
						'rincian_piece'		=> $rincian['rincian_piece'],
						'created_date'		=> date('Y-m-d')
					);
					$this->GlobalModel->insertData('finishing_kirim_gudang_rincian',$dataRincian);
				}

			} else {

				$this->session->set_flashdata('msg','Kode PO "'.$kodepo.'", Sudah di input, Jadi coba cek lagi!!! <audio controls autoplay loop style="display:none;"><source src="'.BASEURL.'assets/mp3/mandrakerja.mp3" type="audio/mpeg"></audio>');

				redirect(BASEURL.'finishing/kirimgudang');

			}


		}

			redirect(BASEURL.'finishing/notakirimgudangprint/'.$post['noFaktur']);


	}

	public function notakirimgudangview()
	{
		$viewData['notarincian'] = $this->GlobalModel->queryManual('SELECT DISTINCT nofaktur,created_date,nama_penerima FROM finishing_kirim_gudang');
		$this->load->view('global/header');
		$this->load->view('finishing/nota/nota-kirim-view',$viewData);
		$this->load->view('global/footer');
	}

	public function notakirimgudangprint($noFaktur='')
	{
		$viewData['gudangfb'] = $this->GlobalModel->queryManual('SELECT fkg.id_finishing_kirim_gudang,fkg.nofaktur,fkg.artikel_po,fkg.harga_satuan,fkg.jumlah_harga_piece,fkg.keterangan,fkg.nama_penerima,fkg.tujuan,fkg.kode_po,pp.nama_po,fkg.created_date,fkg.jumlah_piece_diterima,fkg.tanggal_kirim FROM finishing_kirim_gudang fkg JOIN produksi_po pp ON fkg.kode_po=pp.kode_po WHERE fkg.nofaktur="'.$noFaktur.'" ');
			$data = array();
			// pre($viewData);
		foreach ($viewData['gudangfb'] as $key => $idkirim) {
			$data[$idkirim['kode_po']] = $this->GlobalModel->getData('finishing_kirim_gudang_rincian',array('id_finishing_kirim_gudang'=>$idkirim['id_finishing_kirim_gudang']));
		}
		$viewData['dataRinci'] = $data; 
		$viewData['no']=1;
		$viewData['cancel']=BASEURL.'Finishing/pengirimangudang';
		//$this->load->view('global/header');
		$viewData['page']='finishing/nota/nota-kirim-print';
		$this->load->view('newtheme/page/main',$viewData);
		//$this->load->view('global/footer');
	}


	public function viewpokirimgudang($value='')
	{
		$sql = '';
		$get = $this->input->get();
		if (isset($get['tanggalMulai'])) {
			$sql .= " WHERE created_date >='".$get['tanggalMulai']."' AND created_date <='".$get['tanggalAkhir']."'";
			//pre('SELECT * FROM finishing_kirim_gudang'.$sql.'');
			$viewData['kirim'] = $this->GlobalModel->queryManual('SELECT * FROM `finishing_kirim_gudang` '.$sql.' ');
		} else {
			$viewData['kirim'] = $this->GlobalModel->getData('finishing_kirim_gudang',null);
		}
		$this->load->view('global/header');
		$this->load->view('finishing/kirimgudang/po-kirim-gudang',$viewData);
		$this->load->view('global/footer');
	}
	public function boronganmesin($value='')
	{
		$viewData['kodepo'] = $this->GlobalModel->getData('produksi_po',null);

		$this->load->view('global/header');
		$this->load->view('finishing/borongan/boronganmesin',$viewData);
		$this->load->view('global/footer');
	}

	public function boronganmesinInsert($value='')
	{
		$post = $this->input->post();
		foreach ($post['kodepo'] as $key => $kodepo) {
			$insertData = array(
				'nama_po'		=>	$kodepo,
				'jumlah_pcs'	=>	$post['jumlahpcs'][$key],
				'jumlah_titik'	=>	$post['jumlahtitik'][$key],
				'harga_titik'	=>	$post['pricePerTitik'][$key],
				'jumlah_pendapatan'	=>	$post['jumlahRp'][$key],
				'keterangan'	=>	$post['keterangan'][$key],
				'kategori'	=>	$post['kategoriBorongan'],
				'creted_date'	=>	$post['tanggalMulai']
			);
			$this->GlobalModel->insertData('boronganmesin',$insertData);
		}
		redirect(BASEURL.'finishing/viewboronganmesin');
	}

	public function viewboronganmesin($value='')
	{
		$get = $this->input->get();

		if (isset($get['tanggalMulai'])) {
			$viewData['data'] = $this->GlobalModel->queryManual('SELECT * FROM boronganmesin WHERE creted_date >="'.$get['tanggalMulai'].'" AND creted_date <="'.$get['tanggalAkhir'].'"');
		} else {
			$viewData['data'] = $this->GlobalModel->getData('boronganmesin',null);
		}

		$this->load->view('global/header');
		$this->load->view('finishing/borongan/boronganmesin-view',$viewData);
		$this->load->view('global/footer');
	}
}
