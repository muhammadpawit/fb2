<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Gudang extends CI_Controller {

	function __construct() {
		parent::__construct();
		////sessionLogin(URLPATH."\\".$this->uri->segment(1));
		////session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
	}

	public function kartustok($id){
		$data=[];
		$data['kartustok']=[];
		$data['p'] = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('hapus'=>0,'id_persediaan'=>$id));
		$data['kartustok']=$this->GlobalModel->queryManual("SELECT * FROM kartustok_product WHERE hapus=0 AND idproduct='".$id."' ");
		$data['page']='gudang/persediaan/kartustok';
		$this->load->view('newtheme/page/main',$data);
	}

	public function editbahankeluar($id){
		$data=[];
		$data['title']='Edit PO Bahan Keluar';
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['details']=$this->GlobalModel->getDataRow('gudang_bahan_keluar',array('id_item_keluar'=>$id,'hapus'=>0));
		$data['page']=$this->page.'gudang/editbahankeluar';
		$data['action']=BASEURL.'Gudang/editbahankeluarsave';
		$data['batal']=BASEURL.'Gudang/pengeluaranbahan';
		$this->load->view($this->page.'main',$data);
	}

	public function editbahankeluarsave(){
		$data=$this->input->post();
		$update=array(
			'kode_po'=>$data['kode_po'],
		);
		$this->db->update('gudang_bahan_keluar',$update,array('id_item_keluar'=>$data['id']));
		$this->session->set_flashdata('msg','Data berhasil diubah');
		redirect(BASEURL.'Gudang/pengeluaranbahan?&kode_po='.$data['kode_po']);
	}

	public function cekalatkeluar(){
		$get=$this->input->get();
		$cek=$this->GlobalModel->getDataRow('gudang_item_keluar',array('hapus'=>0,'kode_po'=>$get['kode_po']));
		if(!empty($cek)){
			echo "ok";
		}else{
			echo "false";
		}
	}
	public function ajuanmingguan(){
		$data=array();
		$data['title']='Ajuan Kebutuhan Mingguan';
		$data['products']=array();
		$data['n']=1;
		$results=$this->GlobalModel->getData('ajuan_mingguan',array('hapus'=>0));
		foreach($results as $result){
			$data['products'][]=array(
				'tanggal'=>$result['tanggal'],
				'kebutuhan'=>$result['kebutuhan'],
				'jml_ajuan'=>$result['jml_ajuan'],
				'keterangan'=>$result['keterangan'],
				'detail'=>BASEURL.'Gudang/ajuanmingguandetail/'.$result['id'],
				'excel'=>BASEURL.'Gudang/ajuanmingguandetail/'.$result['id'].'?&excel=1',
			);
		}
		$data['tambah']=BASEURL.'Gudang/ajuanmingguantambah';
		$data['page']=$this->page.'gudang/pengajuan/mingguan_list';
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguandetail($id){
		$data=array();
		$data['n']=1;
		$data['title']='Detail Ajuan Mingguan';
		$data['action']=BASEURL.'Gudang/ajuanmingguansave';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan';
		$data['excel']=BASEURL.'Gudang/ajuanmingguandetail/'.$id.'?&excel=1';
		$data['k']=$this->GlobalModel->getDataRow('ajuan_mingguan',array('hapus'=>0,'id'=>$id));
		$data['kd']=$this->GlobalModel->getData('ajuan_mingguan_detail',array('hapus'=>0,'idajuan'=>$id));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$get=$this->input->get();		
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/mingguan_detail_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function ajuanmingguantambah(){
		$data=array();
		$data['title']='Form Ajuan Mingguan';
		$data['action']=BASEURL.'Gudang/ajuanmingguansave';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan';
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['page']=$this->page.'gudang/pengajuan/mingguan_form';
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguansave(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$am=array(
				'tanggal'=>$data['tanggal'],
				'jenis'=>$data['jenis'], // 1 konveksi, 2 bordir, 3 sablon
				'kebutuhan'=>$data['kebutuhan'],
				'ajuan_kebutuhan'=>$data['ajuan_kebutuhan'],
				'stok'=>$data['stok'],
				'jml_ajuan'=>$data['jml_ajuan'],
				'keterangan'=>'kebutuhan '.$data['kebutuhan'],
			);
			$this->db->insert('ajuan_mingguan',$am);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$insert=array(
					'idajuan'=>$id,
					'tanggal'=>$data['tanggal'],
					'tanggal2'=>$data['tanggal'],
					'kode_po'=>$p['kode_po'],
					'jumlah_po'=>$p['jumlah_po'],
					'rincian_po'=>$p['rincian_po'],
					'jml_pcs'=>str_replace(".", "", $p['jml_pcs']),
					'jml_dz'=>str_replace(".", "", $p['jml_dz']),
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('ajuan_mingguan_detail',$insert);
			}
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/ajuanmingguan');
	}

	public function barangkeluar($jenis){
		$data=array();
		if($jenis==1){
			$data['title']="Barang Keluar Harian Bordir";
		}else if($jenis==2){
			$data['title']="Barang Keluar Harian Konveksi";
		}else{
			$data['title']="Bahan Keluar harian";
		}
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
		$sql="SELECT * FROM barangkeluar_harian WHERE hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}

		if(!empty($jenis)){
			$sql.=" AND jenis='".$jenis."' ";
		}

		$sql.=" ORDER BY id DESC";
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['jenis']=$jenis;
		$data['products']=array();
		$details=array();
		$data['tambah']=BASEURL.'Gudang/barangkeluartambah/'.$jenis;
		$products=$this->GlobalModel->queryManual($sql);
		//$products=$this->GlobalModel->getData('barangkeluar_harian',array('hapus'=>0,'jenis'=>$jenis));
		$no=1;
		foreach($products as $p){
			$details=$this->GlobalModel->getData('barangkeluar_harian_detail',array('hapus'=>0,'idbarangkeluar'=>$p['id']));
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$p['id'],
				'tanggal'=>date('d-m-Y',strtotime($p['tanggal'])),
				'kode_po'=>$p['kode_po'],
				'keterangan'=>$p['keterangan'],
				'jenis'=>$p['jenis'],
				'details'=>$details,
				'edit'=>BASEURL.'barangkeluaredit/'.$p['id'],
				'othapus'=>akseshapus(),
			);
		}
		$data['page']=$this->page.'barangkeluar/barangkeluar_list';
		$this->load->view($this->page.'main',$data);
	}

	public function barangkeluartambah($jenis){
		$title=null;
		if($jenis==1){
			$title="Bordir";
		}else if($jenis==2){
			$title="Konveksi";
		}else{
			$title=null;
		}
		$data=array();
		$data['jenis']=$jenis;
		$data['action']=BASEURL.'Gudang/barangkeluarsave/'.$jenis;
		$data['cancel']=BASEURL.'Gudang/barangkeluar/'.$jenis;
		$data['po']=$this->GlobalModel->getData('produksi_po',array());
		$data['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['po'] = $this->GlobalModel->getData('produksi_po',NULL);
		$data['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$data['title']=$title;
		$data['page']=$this->page.'barangkeluar/barangkeluar_form';
		$this->load->view($this->page.'main',$data);
	}

	public function barangkeluarsave(){
		$data=$this->input->post();
		if(isset($data['products'])){
			$insert=array(
				'tanggal'=>$data['tanggal'],
				'kode_po'=>$data['kode_po'],
				'keterangan'=>$data['keterangan'],
				'jenis'=>$data['jenis'],
				'hapus'=>0
			);
			$this->db->insert('barangkeluar_harian',$insert);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$curqty=$this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$p['id_persediaan']));
				if(!empty($curqty)){
					$this->db->query("UPDATE gudang_persediaan_item set ukuran_item=ukuran_item-'".$p['ukuran']."', jumlah_item=jumlah_item-'".$p['jumlah']."' WHERE id_persediaan='".$p['id_persediaan']."' ");
				}
				$curqtyproduct=$this->GlobalModel->getDataRow('product',array('product_id'=>$p['id_persediaan']));
				if(!empty($curqtyproduct)){
					$this->db->query("UPDATE product set ukuran_item=ukuran_item-'".$p['ukuran']."', quantity=quantity-'".$p['jumlah']."' WHERE product_id='".$p['id_persediaan']."' ");
				}
				$detail=array(
					'idbarangkeluar'=>$id,
					'id_persediaan'=>$p['id_persediaan'],
					'nama'=>$p['nama'],
					'warna'=>$p['warna'],
					'ukuran'=>$p['ukuran'],
					'satuan_ukuran'=>$p['satuanUkran'],
					'jumlah'=>$p['jumlah'],
					'satuanJml'=>$p['satuanJml'],
					'harga'=>$p['harga'],
					'hapus'=>0,
				);
				$this->db->insert('barangkeluar_harian_detail',$detail);
			}
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Gudang/barangkeluar/'.$data['jenis']);	
		}
	}

	public function barangkeluarhapus($id,$id2,$jenis){
		
		//$this->db->query("UPDATE barangkeluar_harian SET hapus=1 WHERE id='$id' ");
		$this->db->query("UPDATE barangkeluar_harian_detail SET hapus=1 WHERE id='$id2' ");
		$p=$this->GlobalModel->getDataRow('barangkeluar_harian_detail',array('id'=>$id2));
		$this->db->query("UPDATE gudang_persediaan_item set ukuran_item=ukuran_item+'".$p['ukuran']."', jumlah_item=jumlah_item+'".$p['jumlah']."' WHERE id_persediaan='".$p['id_persediaan']."' ");
		$this->db->query("UPDATE product set ukuran_item=ukuran_item+'".$p['ukuran']."', quantity=quantity+'".$p['jumlah']."' WHERE product_id='".$p['id_persediaan']."' ");
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Gudang/barangkeluar/'.$jenis);	
	}

	public function absensigudang(){
		$data=array();
		$data['title']="Daftar Absensi Karyawan Gudang";
		$data['products']=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'Gudang/absensigudangadd';
		$data['action']=BASEURL.'Gudang/absensigudangsave';
		$data['actionkaryawan']=BASEURL.'Gudang/karyawangudangsave';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
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
		$sql="SELECT * FROM absensi WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '$tanggal1' AND '$tanggal2' ";
		$sql.=" ORDER BY id DESC";
		$results=$this->GlobalModel->queryManual($sql);
		$s=null;
		$date=date('Y-m-d');
		$masuk='#28a745!important';
		foreach($results as $r){
			$s=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$r['nama']));
			if($date==$r['tanggal']){
				$action=BASEURL.'Gudang/absenpulang/'.$r['id'];
			}else{
				$action=null;
			}

			if($r['jam_masuk']<'08:00:01'){
				$masuk='#28a745!important';
			}else if($r['jam_masuk']>'08:00:00' && $r['jam_masuk']<'17:00:00'){
				$masuk='#d85555';
			}else{
				$masuk='#d85555';
			}
			$data['products'][]=array(
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'nama'=>strtolower($s['nama']),
				'jam_masuk'=>$r['jam_masuk'],
				'jam_keluar'=>$r['jam_keluar'],
				'keterangan'=>$r['keterangan'],
				'action'=>$action,
				'bg'=>$masuk,
			);
		}
		$data['divisi'] = $this->GlobalModel->getData('divisi',array('hapus'=>0));
		$data['karyawan'] = $this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$data['page']=$this->page.'absensi/list';
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$this->load->view($this->page.'main',$data);
	}

	public function absensigudangadd(){
		$data=array();
		$data['title']="Form Absensi Karyawan Gudang";
		$data['products']=array();
		$data['n']=1;
		$data['action']=BASEURL.'Gudang/absensigudangsave';
		$data['cancel']=BASEURL.'Gudang/absensigudang';
		$this->load->view($this->page.'main',$data);
	}

	public function absensigudangsave(){
		$date=date_create();
		$tgl= date_format($date,"H:i:s");
		$data=$this->input->post();
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'bagian'=>$data['bagian'],
			'nama'=>$data['nama'],
			'jam_masuk'=>$tgl,
			'jam_keluar'=>null,
			'keterangan'=>$data['keterangan'],
			'hapus'=>0,
			'tglinput'=>date('Y-m-d H:i:s'),
		);
		$cek=$this->GlobalModel->getDataRow('absensi',array('nama'=>$data['nama'],'tanggal'=>$data['tanggal']));
		if(empty($cek)){
			$this->db->insert('absensi',$insert);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
		}else{
			$this->session->set_flashdata('msgt','Data sudah ada');
		}
		redirect(BASEURL.'Gudang/absensigudang');
	}

	public function absenpulang($id){
		$date=date_create();
		$tgl= date_format($date,"H:i:s");
		$data=$this->input->post();
		$insert=array(
			'jam_keluar'=>$tgl,
		);
		$this->db->update('absensi',$insert,array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/absensigudang');
	}

	public function karyawangudangsave(){
		$data=$this->input->post();
		$insert=array(
			'nama'=>$data['nama'],
			'bagian'=>$data['bagian'],
			'tipe'=>$data['tipe'],
			'gaji'=>0,
			'perminggu'=>0,
			'hapus'=>0,
		);
		$this->db->insert('karyawan_harian',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'Gudang/absensigudang');
	}

	public function pengajuan(){
		$data=array();
		$data['products']=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'Gudang/pengajuanadd';
		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$data['setujui']=akses($user['id_user'],3);
		}
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-31 days"));
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
		$sql="SELECT * FROM pengajuan_harian_new WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		if(!empty($cat)){
			$sql.=" AND kategori='".$cat."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$data['harian'] =$this->db->query($sql)->result_array();
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/view_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/pengajuan/view';		
			$this->load->view($this->page.'main',$data);
		}
	}

	public function pengajuanadd()

	{
		$viewData['action']=BASEURL.'Gudang/pengajuansave';
		$viewData['supplier'] = $this->GlobalModel->getData('master_supplier',null);
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['products'] = $this->GlobalModel->getData('product',array('hapus'=>0));

		$viewData['katpeng']=array(1=>'SABLON',2=>'BORDIR',3=>'KONVEKSI');
		$viewData['page']='newtheme/page/gudang/pengajuan/tambah';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function setujuiajuan($id){
		$url='';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$url.='&tanggal1='.$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-31 days"));
		}
		if(isset($get['tanggal2'])){
			$url.='&tanggal2='.$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$this->db->update('pengajuan_harian_new',array('status'=>1),array('id'=>$id));
		$this->db->update('pengajuan_harian_new_detail',array('komentar'=>null),array('idpengajuan'=>$id));
		//kirim_email('dwimaryanti286@gmail.com','Sdr ibu Dwi, Pak '.callSessUser('nama_user').' telah menyetujui pengajuan harian yang telah dibuat, silahkan segera diprint / cetak ');
		$this->session->set_flashdata('msg','Data berhasil disetujui');
		redirect(BASEURL.'Gudang/pengajuan'.$url);
	}

	public function ajuanhapus($id){
		$url='';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$url.='&tanggal1='.$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-31 days"));
		}
		if(isset($get['tanggal2'])){
			$url.='&tanggal2='.$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$this->db->update('pengajuan_harian_new',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Gudang/pengajuan'.$url);
	}



	public function pengajuansave()

	{

		$data = $this->input->post();
		$cash=0;
		$transfer=0;
		if(isset($data['products'])){
			$ip=array(
				'kategori'=>$data['kategoriPengajuan'],
				'cash'=>0,
				'transfer'=>0,
				'status'=>0,
				'hapus'=>0,
				'tanggal'=>$data['tanggal'],
				'keterangan'=>$data['keterangan'],
				'dibuat'=>date('Y-m-d H:i:s'),
			);
			$this->db->insert('pengajuan_harian_new',$ip);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				if($p['pembayaran']==1){
					$cash+=($p['harga']*$p['jumlah']);
				}

				if($p['pembayaran']==2){
					$transfer+=($p['harga']*$p['jumlah']);
				}
				$rip=array(
					'idpengajuan'=>$id,
					'nama_item'=>$p['nama_item'],
					'jumlah'=>$p['jumlah'],
					'satuan'=>$p['satuan'],
					'harga'=>$p['harga'],
					'pembayaran'=>$p['pembayaran'],
					'supplier'=>$p['supplier'],
					'keterangan'=>$p['keterangan'],
					'status'=>0
				);
				$this->db->insert('pengajuan_harian_new_detail',$rip);
			}

			$this->db->update('pengajuan_harian_new',array('cash'=>$cash,'transfer'=>$transfer),array('id'=>$id));
			$peng=null;
			if($data['kategoriPengajuan']==1){
				$peng='SABLON';
			}else if($data['kategoriPengajuan']==2){
				$peng="BORDIR";
			}else{
				$peng='KONVEKSI';
			}
			$notify=array(
				'type'=>'Pengajuan Harian '.$peng,
				'tables'=>'pengajuan_harian_new',
				'tablesid'=>$id,
				'oleh'=>callSessUser('nama_user'),
				'status'=>0,
				'tanggal'=>date('Y-m-d H:i:s'),
				'url'=>'Gudang/pengajuandetail/'.$id,
			);
			$this->db->insert('notifikasi',$notify);
			$msg=callSessUser('nama_user').' telah membuat ajuan harian';
			push($msg);
			kirim_email('muchlasmuchtar25@gmail.com',callSessUser('nama_user').' telah meminta pengajuan harian '.$peng);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Gudang/pengajuan');
		}

	}

	public function pengajuancetak($kode=''){
		$viewData['item'] = $this->GlobalModel->getData('pengajuan_harian_new_detail',array('idpengajuan'=>$kode,'hapus'=>0));

		$viewData['parent'] = $this->GlobalModel->getDataRow('pengajuan_harian_new',array('id'=>$kode));
		$adminkeu=null;
		$adminkeu=$this->GlobalModel->getDataRow('karyawan',array('jabatan'=>24));
		$viewData['adminkeu']=$adminkeu['nama'];
		$viewData['action']=BASEURL.'Gudang/pengajuan';
		$viewData['menyetujui']=0;
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view('newtheme/page/gudang/pengajuan/cetak_excel',$viewData);
		}else{
			$viewData['page']='newtheme/page/gudang/pengajuan/cetak';
			$this->load->view('newtheme/page/main',$viewData);
		}
	}

	public function pengajuanharga($kode=''){
		$viewData['item'] = $this->GlobalModel->getData('pengajuan_harian_new_detail',array('idpengajuan'=>$kode));

		$viewData['parent'] = $this->GlobalModel->getDataRow('pengajuan_harian_new',array('id'=>$kode));
		$adminkeu=null;
		$adminkeu=$this->GlobalModel->getDataRow('karyawan',array('jabatan'=>24));
		$viewData['adminkeu']=$adminkeu['nama'];
		$viewData['menyetujui']=0;
		$viewData['edit']=BASEURL.'Gudang/pengajuanhargasave';
		$viewData['page']='newtheme/page/gudang/pengajuan/harga';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function pengajuanhargasave(){
		$data=$this->input->post();
		$cash=0;
		$transfer=0;
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				if($p['pembayaran']==1){
					$cash+=($p['harga']*$p['jumlah']);
				}

				if($p['pembayaran']==2){
					$transfer+=($p['harga']*$p['jumlah']);
				}

				$update=array(
					'jumlah'=>$p['jumlah'],
					'harga'=>$p['harga'],
					'pembayaran'=>$p['pembayaran'],
				);
				$this->db->update('pengajuan_harian_new_detail',$update,array('id'=>$p['id']));
			}
			$this->db->update('pengajuan_harian_new',array('cash'=>$cash,'transfer'=>$transfer),array('id'=>$data['id']));
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Gudang/pengajuan');
		}
	}
	public function ajuanedit($kode=''){
		$viewData['item'] = $this->GlobalModel->getData('pengajuan_harian_new_detail',array('idpengajuan'=>$kode,'hapus'=>0));

		$viewData['parent'] = $this->GlobalModel->getDataRow('pengajuan_harian_new',array('id'=>$kode));
		$adminkeu=null;
		$adminkeu=$this->GlobalModel->getDataRow('karyawan',array('jabatan'=>24));
		$viewData['adminkeu']=$adminkeu['nama'];
		$viewData['menyetujui']=0;
		$viewData['edit']=BASEURL.'Gudang/pengajuaneditallsave';
		$viewData['page']='newtheme/page/gudang/pengajuan/editall';
		$viewData['products'] = $this->GlobalModel->getData('product',array('hapus'=>0));
		$get=$this->input->get();
		if(isset($get['acc'])){
			$viewData['editacc']=1;
		}
		//pre($get);
		$this->load->view('newtheme/page/main',$viewData);
	}
	public function pengajuaneditallsave(){
		$data=$this->input->post();
		
		$cash=0;
		$transfer=0;
		$status=0;
		if(isset($data['editacc'])){
			$status=1;
		}
		//pre($data);
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				if($p['hapus']==1){

				}else{
					if($p['pembayaran']==1){
						$cash+=($p['harga']*$p['jumlah']);
					}

					if($p['pembayaran']==2){
						$transfer+=($p['harga']*$p['jumlah']);
					}	
				}			

				$update=array(
					'nama_item'=>$p['nama_item'],
					'jumlah'=>$p['jumlah'],
					'satuan'=>$p['satuan'],
					'harga'=>$p['harga'],
					'pembayaran'=>$p['pembayaran'],
					'supplier'=>$p['supplier'],
					'keterangan'=>$p['keterangan'],
					'status'=>$status,
					'hapus'=>isset($p['hapus'])?$p['hapus']:0,
					'idpengajuan'=>$data['id'],
				);
				if(isset($p['id'])){
					$this->db->update('pengajuan_harian_new_detail',$update,array('id'=>$p['id']));	
				}else{
					$this->db->insert('pengajuan_harian_new_detail',$update);
				}
				
			}
			$this->db->update('pengajuan_harian_new',array('tanggal'=>$data['tanggal'],'cash'=>$cash,'transfer'=>$transfer,'status'=>$status),array('id'=>$data['id']));
			$msg=callSessUser('nama_user').' telah merevisi pengajuan harian';
			push($msg);
			kirim_email('muchlasmuchtar25@gmail.com',callSessUser('nama_user').' telah merevisi pengajuan harian dengan nomor '.$data['id'].' ');
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Gudang/pengajuan');
		}
	}
	public function pengajuandetail($kode=''){
		$viewData['item'] = $this->GlobalModel->getData('pengajuan_harian_new_detail',array('idpengajuan'=>$kode));

		$viewData['parent'] = $this->GlobalModel->getDataRow('pengajuan_harian_new',array('id'=>$kode));
		$adminkeu=null;
		$adminkeu=$this->GlobalModel->getDataRow('karyawan',array('jabatan'=>24));
		$viewData['adminkeu']=$adminkeu['nama'];
		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$setujui=akses($user['id_user'],3);
		}
		$viewData['menyetujui']=$setujui;
		$viewData['action']=BASEURL.'Gudang/komentarsave';
		$viewData['page']='newtheme/page/gudang/pengajuan/detail';
		$this->load->view('newtheme/page/main',$viewData);

	}

	public function komentarsave(){
		$data=$this->input->post();
		//pre($data);
		$this->db->update('pengajuan_harian_new',array('status'=>3),array('id'=>$data['idpengajuan']));


		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$update=array(
					'komentar'=>$p['komentar'],
				);
				$this->db->update('pengajuan_harian_new_detail',$update,array('id'=>$p['id']));
			}
			$kategori='';
			if($data['kategori']==1){
				$kategori='Sablon';
			}else if($data['kategori']==2){
				$kategori='Bordir';
			}else{
				$kategori='Konveksi';
			}
			$pesan='Sdr ibu Ulpah, Pak '.callSessUser('nama_user').' telah mengomentari pengajuan harian '.$kategori.' tanggal '.date('d F Y',strtotime($data['tanggal'])).' .silahkan perbaiki segera';
			kirim_email('ulfahcahayaag@gmail.com',$pesan);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Gudang/pengajuan');
		}
	}


	public function detailpengajuan($kode='')

	{

		$viewData['item'] = $this->GlobalModel->getData('pengajuan_harian',array('kode_pengajuan'=>$kode));

		$viewData['parent'] = $this->GlobalModel->getDataRow('pengajuan_harian_parent',array('kode_pengajuan'=>$kode));

		// pre($viewData);

		$this->load->view('global/header');

		$this->load->view('pengajuan/harian/detail',$viewData);

		$this->load->view('global/footer');

	}


	public function penerimaanitem()
	{
		// jenis 1 bahan, 2 alat-alat
		$data=array();
		$data['title']='Penerimaan Item';
		$data['url']=BASEURL.'Gudang/penerimaanitem';
		$data['tambah']=BASEURL.'Gudang/penerimaanitemadd';
		$data['items']=array();
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
		if(isset($get['supplier'])){
			$sups=$get['supplier'];
		}else{
			$sups=null;
		}
		$sql='SELECT * FROM penerimaan_item WHERE hapus=0 ';

		if(!empty($cat)){
			$sql.=" AND jenis='".$cat."' ";
		}

		if(!empty($sups)){
			$sql.=" AND supplier='".$sups."' ";
		}

		if(!empty($cat) OR empty(!$sups)){
			
		}else{
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id DESC";
		$resutls = $this->GlobalModel->queryManual($sql);
		$data['supplier']=$this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$data['n']=1;
		foreach($resutls as $result){
			$action=array();
			$action[]=array(
				'text'=>'Detail',
				'href'=>BASEURL.'Gudang/penerimaanitemdetail/'.$result['id'],
			);
			$supplier=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$result['supplier']));
			$products=$this->GlobalModel->getData('penerimaan_item_detail',array('penerimaan_item_id'=>$result['id']));
			$data['items'][]=array(
				'id'=>$result['id'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'nosj'=>$result['nosj'],
				'keterangan'=>$result['keterangan'],
				'supplier'=>$supplier['nama'],
				'jenis'=>$result['jenis'],
				'action'=>$action,
				'prods'=>$products,
			);
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		$data['suppliers_id']=$sups;
		if(isset($get['excel'])){
			$this->load->view('gudang/penerimaanitem/excel',$data);
		}else{
			$data['page']='gudang/penerimaanitem/list';
			$this->load->view('newtheme/page/main',$data);
		}

	}

	public function penerimaanitemadd()

	{
		$data=array();
		$data['i']=0;
		$data['url']=BASEURL.'Gudang/penerimaanitem';
		$data['action']=BASEURL.'Gudang/penerimaanitemsave';
		$data['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['supplier'] = $this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		// $this->load->view('global/header');
		// $this->load->view('gudang/penerimaanitem/form',$data);
		// $this->load->view('global/footer');
		$data['page']='gudang/penerimaanitem/form';
		$this->load->view('newtheme/page/main',$data);

	}

	public function penerimaanitemsave(){
		$data=$this->input->post();
		
		if(isset($data['products'])){
			if(!empty($data['products'])){
				$it=array(
					'tanggal'=>isset($data['tanggal'])?$data['tanggal']:date('Y-m-d'),
					'supplier'=>$data['supplier'],
					'nosj'=>$data['nosj'],
					'keterangan'=>isset($data['keterangan'])?$data['keterangan']:'-',
					'jenis'=>$data['jenis'],
					'hapus'=>0
				);
				$this->db->insert('penerimaan_item',$it);
				$id=$this->db->insert_id();
				foreach($data['products'] as $p){
					$itd=array(
						'penerimaan_item_id'=>$id,
						'id_persediaan'=>$p['id_persediaan'],
						'nama'=>$p['nama'],
						'ukuran'=>$p['ukuran'],
						'satuanukuran'=>$p['satuanukuran'],
						'jumlah'=>$p['jumlah'],
						'satuanJml'=>$p['satuanJml'],
						'harga'=>$p['harga'],
						'hapus'=>0
					);
					$this->db->insert('penerimaan_item_detail',$itd);
					$kartustok=array(
						'tanggal'=>date('Y-m-d'),
						'idproduct'=>$p['id_persediaan'],
						'nama'=>$p['nama'],
						'saldomasuk_uk'=>$p['ukuran'],
						'saldomasuk_qty'=>$p['jumlah'],
						'harga'=>$p['harga'],
						'keterangan'=>isset($data['keterangan'])?$data['keterangan']:'-',
					);
					kartustok($kartustok,1);
					$this->db->query("UPDATE product set ukuran_item=ukuran_item+".$p['ukuran'].",quantity=quantity+'".$p['jumlah']."', price='".$p['harga']."' WHERE product_id='".$p['id_persediaan']."' ");
					$this->db->query("UPDATE gudang_persediaan_item set ukuran_item=ukuran_item+".$p['ukuran'].", jumlah_item=jumlah_item+'".$p['jumlah']."',harga_item='".$p['harga']."' WHERE id_persediaan='".$p['id_persediaan']."' ");
				}
				$this->session->set_flashdata('msg','Data berhasil disimpan');
				redirect(BASEURL.'gudang/penerimaanitem');
			}
		}
	}

	public function penerimaanitemdetail($id){
		$data=array();
		$results=array();
		$products=array();
		$data['results']=$this->GlobalModel->getDataRow('penerimaan_item',array('id'=>$id));
		$data['products']=$this->GlobalModel->getData('penerimaan_item_detail',array('penerimaan_item_id'=>$id));
		$data['page']='gudang/penerimaanitem/detail';
		$this->load->view('newtheme/page/main',$data);
	}

	public function itemmasuk()
	{
		$viewData['item'] = $this->GlobalModel->queryManual('SELECT DISTINCT kode_transfer,contact_supplier,nama_supplier,created_date FROM gudang_item_masuk');
		
		$this->load->view('global/header');
		$this->load->view('gudang/receiving/receiving-view',$viewData);
		$this->load->view('global/footer');
	}

	public function itemmasuktambah()
	{
		$viewData['satuan']	= $this->GlobalModel->getData('master_satuan_barang',null);
		$this->load->view('global/header');
		$this->load->view('gudang/receiving/receiving-tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function itemmasukOnCreate()
	{
		$post = $this->input->post();
		foreach ($post['nama'] as $key => $nama) {
			$dataInserted = array(
				'nama_item_masuk' 		=>	$nama,
				'warna_item_masuk' 		=>	$post['warna'][$key],
				'ukuran_item_masuk' 	=>	$post['ukuran'][$key],
				'satuan_item_masuk' 	=>	$post['satuanUkran'][$key],
				'jumlah_item_masuk' 	=>	$post['jumlah'][$key],
				'satuan_jumlah_item' 	=>	$post['satuanJml'][$key],
				'created_date' 			=>	date('Y-m-d'),
				'nama_supplier' 		=>	$post['nama_supplier'],
				'kode_transfer' 		=>	$post['kodeTf'],
				'contact_supplier'	=>	$post['contact_supp'],
				'harga_item_masuk'			=> $post['hargaItem'][$key]
			);
			$this->GlobalModel->insertData('gudang_item_masuk',$dataInserted);

			$dataInsertPersediaan = array(
				'nama_item'				=> $nama,
				'warna_item'			=> $post['warna'][$key],
				'ukuran_item'			=> $post['ukuran'][$key],
				'satuan_ukuran_item'	=> $post['satuanUkran'][$key],
				'jumlah_item'			=> $post['jumlah'][$key],
				'satuan_jumlah_item'	=> $post['satuanJml'][$key],
				'created_date'			=> date('Y-m-d'),
				'nama_supplier'			=> $post['nama_supplier'],
				'kode_transfer'			=> $post['kodeTf'],
				'contact_supplier' => $post['contact_supp'],
				'harga_item'			=> $post['hargaItem'][$key]
			);
			$this->GlobalModel->insertData('gudang_persediaan_item',$dataInsertPersediaan);
		}
		
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'gudang/itemmasuk');
	}

	public function itemmasukedit($id)
	{
		$viewData['item'] = $this->GlobalModel->getData('gudang_item_masuk',array('kode_transfer'=>$id));
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		
		$this->load->view('global/header');
		$this->load->view('gudang/receiving/receiving-edit',$viewData);
		$this->load->view('global/footer');
	}

	public function deleteItemPerSatu()
	{
		$postId = $this->input->post('id');
		$data = $this->GlobalModel->getData('gudang_item_masuk',array('id_item_masuk'=>$postId));
		$dataInserted=array(
			'notif_name'		=> 'item keluar di hapus',
			'notif_desc'		=>	json_encode($data),
			'notif_create_date'	=>	date('Y-m-d')
		);
		$this->GlobalModel->insertData('alert_notif',$dataInserted);
		$this->GlobalModel->deleteData('gudang_item_masuk',array('id_item_masuk'=>$postId));
	}

	public function itemmasukeditOnUpdate()
	{
		$post = $this->input->post();

		foreach ($post['nama'] as $key => $nama) {
			$carId = $this->GlobalModel->getDataRow('gudang_item_masuk',array('id_item_masuk'=>$post['id'][$key]));
			if (isset($carId)) {
				
				$dataInserted = array(
				'nama_item_masuk' 		=>	$nama,
				'warna_item_masuk' 		=>	$post['warna'][$key],
				'ukuran_item_masuk' 	=>	$post['ukuran'][$key],
				'satuan_item_masuk' 	=>	$post['satuanUkran'][$key],
				'jumlah_item_masuk' 	=>	$post['jumlah'][$key],
				'satuan_jumlah_item' 	=>	$post['satuanJml'][$key],
				'created_date' 			=>	date('Y-m-d'),
				'nama_supplier' 		=>	$post['nama_supplier'],
				'kode_transfer' 		=>	$post['kodeTf'],
				'contact_supplier'	=>	$post['contact_supp'],
				'harga_item_masuk'			=> $post['hargaItem'][$key]
				);
				$where = array(
					'id_item_masuk' => $post['id'][$key]
				);
				$this->GlobalModel->updateData('gudang_item_masuk',$where,$dataInserted);

			} else {

				$dataInserted = array(
					'nama_item_masuk' 			=>	$nama,
					'warna_item_masuk' 			=>	$post['warna'][$key],
					'ukuran_item_masuk' 		=>	$post['ukuran'][$key],
					'satuan_item_masuk' 		=>	$post['satuanUkran'][$key],
					'jumlah_item_masuk' 		=>	$post['jumlah'][$key],
					'satuan_jumlah_item' 		=>	$post['satuanJml'][$key],
					'created_date' 				=>	date('Y-m-d'),
					'nama_supplier' 			=>	$post['nama_supplier'],
					'kode_transfer' 			=>	$post['kodeTf'],
					'contact_supplier'			=>	$post['contact_supp'],
					'harga_item_masuk'			=> $post['hargaItem'][$key]
				);
				$this->GlobalModel->insertData('gudang_item_masuk',$dataInserted);
				$dataInsertPersediaan = array(
					'nama_item'				=> $nama,
					'warna_item'			=> $post['warna'][$key],
					'ukuran_item'			=> $post['ukuran'][$key],
					'satuan_ukuran_item'	=> $post['satuanUkran'][$key],
					'jumlah_item'			=> $post['jumlah'][$key],
					'satuan_jumlah_item'	=> $post['satuanJml'][$key],
					'created_date'			=> date('Y-m-d'),
					'nama_supplier'			=> $post['nama_supplier'],
					'kode_transfer'			=> $post['kodeTf'],
					'contact_supplier'		=> $post['contact_supp'],
					'harga_item'			=> $post['hargaItem'][$key]
				);
				$this->GlobalModel->insertData('gudang_persediaan_item',$dataInsertPersediaan);

			}
			
		}
		$this->session->set_flashdata('msg','Data berhasil ditambah kode TF "'.$post['kodeTf'].'"');
		redirect(BASEURL.'gudang/itemmasuk');
	}

	public function itemmasukDelete($id='')
	{
		$this->GlobalModel->deleteData('gudang_item_masuk',array('id_item_masuk'=>$id));
		$this->session->set_flashdata('msg','Data berhasil di hapus');
		redirect(BASEURL.'gudang/itemmasuk');
	}

	public function itemmasukupdate()
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$this->load->view('global/header');
		$this->load->view('gudang/receiving/receiving-tambah-update',$viewData);
		$this->load->view('global/footer');
	}

	public function itemmasukupdateMasukOnCreate($value='')
	{
		$post = $this->input->post();

		foreach ($post['nama'] as $key => $nama) {
			$where = array(
				'id_persediaan' => $post['id'][$key]
			);
			$dataId = $this->GlobalModel->getDataRow('gudang_persediaan_item',$where);

			if (empty($dataId['jumlah_item'])) {
				$jumlahItem = $post['jumlah'][$key];
			} else {
				$jumlahItem = $dataId['jumlah_item'] + $post['jumlah'][$key];
			}

			$dataInserted = array(
				'nama_item_masuk' 		=>	$nama,
				'warna_item_masuk' 		=>	$post['warna'][$key],
				'ukuran_item_masuk' 	=>	$post['ukuran'][$key],
				'satuan_item_masuk' 	=>	$post['satuanUkran'][$key],
				'jumlah_item_masuk' 	=>	$jumlahItem,
				'satuan_jumlah_item' 	=>	$post['satuanJml'][$key],
				'created_date' 			=>	date('Y-m-d'),
				'nama_supplier' 		=>	$post['namaSupplier'],
				'kode_transfer' 		=>	$post['kodeTF'],
				'contact_supplier'	=>	$post['contact_supp'],
				'harga_item_masuk'			=> $post['harga'][$key]
			);
			
			$this->GlobalModel->insertData('gudang_item_masuk',$dataInserted);

			$dataUpdate = array(
				'nama_item'				=> $nama,
				'warna_item'			=> $post['warna'][$key],
				'ukuran_item'			=> $post['ukuran'][$key],
				'satuan_ukuran_item'	=> $post['satuanUkran'][$key],
				'jumlah_item'			=> $jumlahItem,
				'satuan_jumlah_item'	=> $post['satuanJml'][$key],
				'created_date'			=> date('Y-m-d'),
				'nama_supplier'			=> $post['namaSupplier'],
				'kode_transfer'			=> $post['kodeTF'],
				'contact_supplier' => $post['contact_supp'],
				'harga_item'			=> $post['harga'][$key]
			);
			$where = array(
					'id_persediaan' => $post['id'][$key]
				);

			$this->GlobalModel->updateData('gudang_persediaan_item',$where,$dataUpdate);
		}

		$this->session->set_flashdata('msg','Data berhasil di tambah kode transfer "'.$post['kodeTF'].'" ');
		redirect(BASEURL.'gudang/itemmasuk');
	}

	public function pengeluaranalat()
	{
		$item=array();
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
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		$viewData['tanggal1']=$tanggal1;
		$viewData['tanggal2']=$tanggal2;
		$viewData['title']='Pengeluaran Alat';
		$sql='SELECT * FROM gudang_item_keluar WHERE hapus=0';
		if(!empty($kode_po)){
			$sql.=" AND kode_po='".$kode_po."' ";
		}else{
			$sql.=" AND date(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$item = $this->GlobalModel->queryManual($sql);
		$viewData['item']=[];
		$user=user();
		$hapus=0;
		if(isset($user['id_user'])){
			$hapus=akses($user['id_user'],2);
		}
		foreach($item as $i){
			$action=array();
			$action[]=array(
				'text'=>'Detail',
				'href'=>BASEURL.'gudang/itemkeluarDetail/'.$i['kode_po'],
			);
			if($hapus==1){
				$action[]=array(
					'text'=>'Hapus',
					'href'=>BASEURL.'gudang/itemkeluarDelete/'.$i['id_item_keluar'],
				);
			}
			$viewData['item'][] =array(
				'created_date'=>$i['created_date'],
				'nama_penerima'=>$i['nama_penerima'],
				'kode_po'=>$i['kode_po'],
				'faktur_no'=>$i['faktur_no'],
				'nama_item_keluar'=>$i['nama_item_keluar'],
				'action'=>$action,
				'edit'=>BASEURL.'Gudang/pengeluaranalatedit/'.$i['kode_po'],
			);
			
		}
		$viewData['tambah']=BASEURL.'gudang/itemkeluartambah';
		$viewData['po'] = $this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$viewData['page']='gudang/outbound/item-keluar-view';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function pengeluaranalatedit($id="")
	{
		$viewData['cmt'] = $this->GlobalModel->getData('master_cmt',array('hapus' => 0));
		$viewData['barang'] = $this->GlobalModel->getData('gudang_item_keluar',array('kode_po' => $id));
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po' => $viewData['barang'][0]['kode_po']));
		$viewData['action']=BASEURL.'Gudang/editcmtoutbarang';
		$viewData['page']='gudang/outbound/editcmt';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function editcmtoutbarang(){
		$data=$this->input->post();
    	$update=array(
    		'nama_penerima'=>$data['nama_penerima'],
    		'tujuan_item'=>$data['tujuan_item'],
    		'kode_po'=>$data['kode_po'],
    	);
    	$this->db->update('gudang_item_keluar',$update,array('kode_po'=>$data['kode_po']));
    	$this->session->set_flashdata('msg','Data berhasil diubah');
		redirect(BASEURL.'gudang/pengeluaranalat');
	}

	public function itemkeluar()
	{
		redirect(BASEURL.'Gudang/pengeluaranalat');
		$viewData['item'] = $this->GlobalModel->queryManual('SELECT DISTINCT faktur_no,created_date,nama_penerima FROM gudang_item_keluar');
		$this->load->view('global/header');
		$this->load->view('newtheme/page/main',$viewData);
		$this->load->view('global/footer');
	}

	public function itemkeluartambah()
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['po'] = $this->GlobalModel->getData('produksi_po',NULL);
		$viewData['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$viewData['page']='gudang/outbound/item_keluar_tambah';
		$viewData['kembali']=BASEURL.'Gudang/Pengeluaranalat';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function itemkeluarSearchId($id='')
	{
		$getId = $this->input->get('id');
		$data = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$getId));
		echo json_encode($data);
	}

	public function cariproduct($id='')
	{
		$getId = $this->input->get('id');
		$data = $this->GlobalModel->getDataRow('product',array('product_id'=>$getId));
		echo json_encode($data);
	}

	public function itemkeluarOnPrint()
	{
		$post = $this->input->post();
		$viewData['post'] = $post;
		$viewData['page']='gudang/outbound/print-out';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function itemkeluarDetail($id="")
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_item_keluar',array('kode_po' => $id));
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po' => $viewData['barang'][0]['kode_po']));
		$viewData['excel']=BASEURL.'Gudang/itemkeluarDetail/'.$id.'?&excel=true';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view('gudang/outbound/item-keluar-detail_excel',$viewData);
		}else{
			$viewData['page']='gudang/outbound/item-keluar-detail';
			$this->load->view('newtheme/page/main',$viewData);	
		}
		
	}

	public function itemkeluarOnCreate()
	{
		$post = $this->input->post();

		$dataInput = $this->GlobalModel->getDataRow('gudang_item_keluar',array('kode_po' => $post['namaPo']));
		//pre($dataInput);
		//if (empty($dataInput)) {

			foreach ($post['nama'] as $key => $nama) {
				$persediaan = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=> $post['id'][$key]));
				
				$dataInsertPersediaan = array(
					'jumlah_item' 	=>	($persediaan['jumlah_item']-$post['jumlah'][$key]),
					'ukuran_item'=>(($persediaan['ukuran_item']-$post['ukuran'][$key])),
				);

				$dataInsertPersediaanP = array(
					'quantity' 	=>	($persediaan['jumlah_item']-$post['jumlah'][$key]),
					'ukuran_item'=>(($persediaan['ukuran_item']-$post['ukuran'][$key])),
				);
					$kartustok=array(
						'tanggal'=>date('Y-m-d'),
						'idproduct'=>$post['id'][$key],
						'nama'=>$nama,
						'saldomasuk_uk'=>$post['ukuran'][$key],
						'saldomasuk_qty'=>$post['jumlah'][$key],
						'harga'=>$post['harga'][$key],
						'keterangan'=>'Pengeluaran alat untuk PO '.$post['namaPo'],
					);
					kartustok($kartustok,2);

					$this->GlobalModel->updateData('gudang_persediaan_item',array('id_persediaan'=>$post['id'][$key]),$dataInsertPersediaan);
					$this->GlobalModel->updateData('product',array('product_id'=>$post['id'][$key]),$dataInsertPersediaanP);

					$dataInserted = array(
						'nama_item_keluar' 		=>	$nama,
						'kode_po'				=>	$post['namaPo'],
						'warna_item_keluar' 	=>	$post['warna'][$key],
						'ukuran_item_keluar' 	=>	$post['ukuran'][$key],
						'satuan_item_keluar' 	=>	$post['satuanUkran'][$key],
						'jumlah_item_keluar' 	=>	$post['jumlah'][$key],
						'satuan_jumlah_keluar' 	=>	$post['satuanJml'][$key],
						'created_date' 			=>	date('Y-m-d'),
						'nama_penerima' 		=>	$post['namaPenerima'],
						'faktur_no' 			=>	$post['noFaktur'].'TRF'.$post['namaPo'],
						'tujuan_item'			=>	$post['tujuanItem'],
						'harga_item'			=> 	$post['harga'][$key],
						'jumlah_item_perlusin'	=>	$post['itemPerlusin'][$key]
					);
					$this->GlobalModel->insertData('gudang_item_keluar',$dataInserted);
					$insert_id = $this->db->insert_id();

			}

			$insertFaktur = array(
				'no_faktur'		=> $post['noFaktur'],
				'nama_penerima' => $post['namaPenerima'],
				'tujuan_item'	=> $post['tujuanItem'],
				'kode_po'		=> $post['namaPo'],
				'create_date'	=> date('Y-m-d')
			);
			$this->GlobalModel->insertData('gudang_out_po',$insertFaktur);

			$this->session->set_flashdata('msg','Data berhasil ditambah');
		
			redirect(BASEURL.'gudang/pengeluaranalat');

		/*}else{

			$this->session->set_flashdata('msgt','Data Gagal Di Simpan.Karena sudah pernah diinput sebelumnya');
			redirect(BASEURL.'gudang/pengeluaranalat');

		}*/

	}

	public function itemkeluarEdit($id='')
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_item_keluar',array('faktur_no'=>$id));
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['po'] = $this->GlobalModel->getData('produksi_po',NULL);
		$viewData['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$this->load->view('global/header');
		$this->load->view('gudang/outbound/item_keluar_edit',$viewData);
		$this->load->view('global/footer');
	}

	public function itemkeluareditOnCreate()
	{
		$post = $this->input->post();
		foreach ($post['nama'] as $key => $nama) {
			$dataInserted = array(
				'nama_item_keluar' 		=>	$nama,
				'warna_item_keluar' 	=>	$post['warna'][$key],
				'ukuran_item_keluar' 	=>	$post['ukuran'][$key],
				'satuan_item_keluar' 	=>	$post['satuanUkran'][$key],
				'jumlah_item_keluar' 	=>	$post['jumlah'][$key],
				'satuan_jumlah_keluar' 	=>	$post['satuanJml'][$key],
				'created_date' 			=>	date('Y-m-d'),
				'nama_penerima' 		=>	$post['namaPenerima'],
				'faktur_no' 			=>	$post['noFaktur'],
				'tujuan_item'			=>	$post['tujuanItem'],
				'harga_item'			=> 	$post['harga'][$key],
				'jumlah_item_perlusin'	=> 	$post['itemPerlusin'][$key]
			);
			$where = array(
				'id_item_keluar' => $post['id'][$key]
			);
			$this->GlobalModel->updateData('gudang_item_keluar',$where,$dataInserted);
		}
		$this->session->set_flashdata('msg','Data berhasil di edit');
		redirect(BASEURL.'gudang/itemkeluar');
	}

	
	

	public function itemkeluarDelete($id='')
	{
		$this->GlobalModel->deleteData('gudang_item_keluar',array('id_item_keluar'=>$id));
		$this->session->set_flashdata('msg','Data berhasil di delete');
		redirect(BASEURL.'gudang/itemkeluar');
	}


	public function persediaanstok()
	{
		$get=$this->input->get();
		if(isset($get['product_id'])){
			$product_id=$get['product_id'];
		}else{
			$product_id=null;
		}
		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
			$viewData['persediaan'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0,'jenis'=>$jenis));
		}else{
			$jenis=null;
			$viewData['persediaan'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		}

		$viewData['title']='Persediaan Stok';
		
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/persediaan-excel',$viewData);
		}else{
			$viewData['page']='gudang/persediaan/persediaan-view';
			$this->load->view('newtheme/page/main',$viewData);
		}
	}


	public function persediaan()
	{
		redirect(BASEURL.'Gudang/persediaanstok');
		$viewData['persediaan'] = $this->GlobalModel->getData('gudang_persediaan_item',null);
		$this->load->view('global/header');
		$this->load->view('gudang/persediaan/persediaan-view',$viewData);
		$this->load->view('global/footer');
	}

	public function persediaanhapus($id){
		$this->db->update('gudang_persediaan_item',array('hapus'=>1),array('id_persediaan'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Gudang/persediaanstok');
	}

	public function persediaanedit($id='')
	{
		$viewData['persediaan'] = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan' => $id));
		$viewData['satuan']	= $this->GlobalModel->getData('master_satuan_barang',null);
		
		$this->load->view('global/header');
		$this->load->view('gudang/persediaan/persediaan-edit',$viewData);
		$this->load->view('global/footer');
	}

	public function persediaanEditOnUpdate()
	{
		$post = $this->input->post();
		foreach ($post['nama'] as $key => $nama) {
			$dataInsertPersediaan = array(
				'nama_item'				=> $nama,
				'warna_item'			=> $post['warna'][$key],
				'ukuran_item'			=> $post['ukuran'][$key],
				'satuan_ukuran_item'	=> $post['satuanUkran'][$key],
				'jumlah_item'			=> $post['jumlah'][$key],
				'satuan_jumlah_item'	=> $post['satuanJml'][$key],
				'created_date'			=> date('Y-m-d'),
				'nama_supplier'			=> $post['nama_supplier'],
				'kode_transfer'			=> $post['kodeTf'],
				'contact_supplier' => $post['contact_supp'],
				'harga_item'			=> $post['hargaItem'][$key]
			);
			$where = array(
					'id_persediaan' => $post['id'][$key]
				);
			$this->GlobalModel->updateData('gudang_persediaan_item',$where,$dataInsertPersediaan);
		}
		
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'gudang/persediaan');
	}


	public function outbahan()
	{
		$item=array();
		$item=$this->GlobalModel->queryManual('SELECT * FROM gudang_bahan_keluar WHERE hapus=0');
		$user=user();
		$hapus=0;
		$viewData['item']=array();
		if(isset($user['id_user'])){
			$hapus=akses($user['id_user'],2);
		}
		foreach($item as $i){
			$action=array();
			$action[]=array(
				'text'=>'Detail',
				'href'=>BASEURL.'gudang/outbahanDetail/'.$i['faktur_no'],
			);
			if($hapus==1){
				$action[]=array(
					'text'=>'Hapus',
					'href'=>BASEURL.'gudang/outbahanHapus/'.$i['id_item_keluar'],
				);
			}
			$viewData['item'][] =array(
				'created_date'=>$i['created_date'],
				'nama_item_keluar'=>$i['nama_item_keluar'],
				'bahan_kategori'=>$i['bahan_kategori'],
				'kode_po'=>$i['kode_po'],
				'faktur_no'=>$i['faktur_no'],
				'id_item_keluar'=>$i['id_item_keluar'],
				'action'=>$action,
			);
			
		}	
		$this->load->view('global/header');
		$this->load->view('gudang/outbahan/item-keluar-view',$viewData);
		$this->load->view('global/footer');
	}

	public function pengeluaranbahan()
	{
		$item=array();
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

		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		$viewData['tanggal1']=$tanggal1;
		$viewData['tanggal2']=$tanggal2;
		$viewData['po'] = $this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$viewData['title']='Pemakaian Bahan';
		$sql='SELECT * FROM gudang_bahan_keluar WHERE hapus=0';
		if(!empty($kode_po)){
			$sql.=" AND kode_po='".$kode_po."'";
		}else{
			$sql.=" AND date(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'  ";
		}
		$sql.=" ORDER BY id_item_keluar DESC ";
		$item=$this->GlobalModel->queryManual($sql);
		$user=user();
		$hapus=0;
		$viewData['item']=array();
		if(isset($user['id_user'])){
			$hapus=akses($user['id_user'],2);
		}
		foreach($item as $i){
			$action=array();
			$action[]=array(
				'text'=>'Detail',
				'href'=>BASEURL.'gudang/outbahanDetail/'.$i['faktur_no'],
			);
			if(aksesedit()==1){
				$action[]=array(
					'text'=>'Edit (Ganti Nama PO)',
					'href'=>BASEURL.'Gudang/editbahankeluar/'.$i['id_item_keluar'],
				);
			}
			
			if($hapus==1){
				$action[]=array(
					'text'=>'Hapus',
					'href'=>BASEURL.'gudang/outbahanHapus/'.$i['id_item_keluar'],
				);
			}
			$viewData['item'][] =array(
				'created_date'=>$i['created_date'],
				'nama_item_keluar'=>$i['nama_item_keluar'],
				'bahan_kategori'=>$i['bahan_kategori'],
				'kode_po'=>$i['kode_po'],
				'faktur_no'=>$i['faktur_no'],
				'id_item_keluar'=>$i['id_item_keluar'],
				'action'=>$action,
			);
			
		}	
		$viewData['tambah']=BASEURL.'gudang/outbahantambah';
		$viewData['page']='gudang/outbahan/item-keluar-view';
		$this->load->view('newtheme/page/main',$viewData);
	}

	
	public function outbahantambah()
	{
		$viewData['title']='Form Pemakaian bahan';
		$viewData['lockdouble']=settings('lockdouble');
		$viewData['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['po'] = $this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$viewData['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$viewData['page']='gudang/outbahan/item_keluar_tambah';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function itemkeluarpo(){
		$data=$this->input->get();
		$cek=$this->GlobalModel->getDataRow('gudang_bahan_keluar',array('kode_po'=>$data['kode_po']));
		if(!empty($cek)){
			echo "False";
		}else{
			echo "OK";
		}
	}

	public function outbahanOnCreate()
	{

		$post = $this->input->post();
		//pre($post);
		$dataInput = $this->GlobalModel->getDataRow('gudang_bahan_keluar',array('kode_po' => $post['namaPo']));

		//if (empty($dataInput)) {

			foreach ($post['nama'] as $key => $nama) {
				$persediaan = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=> $post['id'][$key]));
				
					$dataInsertPersediaan = array(
						'jumlah_item' 	=>	($persediaan['jumlah_item']-$post['jumlah'][$key]),
						'ukuran_item'	=> ($persediaan['ukuran_item']-$post['ukuran'][$key])
					);
					$this->GlobalModel->updateData('gudang_persediaan_item',array('id_persediaan'=>$post['id'][$key]),$dataInsertPersediaan);
					$dataInserted = array(
						'nama_item_keluar' 		=>	$nama,
						'kode_po'				=>	$post['namaPo'],
						'warna_item_keluar' 	=>	$post['warna'][$key],
						'ukuran_item_keluar' 	=>	$post['ukuran'][$key],
						'satuan_item_keluar' 	=>	$post['satuanUkran'][$key],
						'jumlah_item_keluar' 	=>	$post['jumlah'][$key],
						'satuan_jumlah_keluar' 	=>	$post['satuanJml'][$key],
						'created_date' 			=>	date('Y-m-d'),
						'faktur_no' 			=>	$post['noFaktur'].'TRF'.$post['namaPo'],
						'tujuan_item'			=>	$post['tujuanItem'],
						'harga_item'			=> 	$post['harga'][$key],
						'bahan_kategori'		=>  $post['bahanUntuk'][$key]
					);
					$this->GlobalModel->insertData('gudang_bahan_keluar',$dataInserted);
					$insert_id = $this->db->insert_id();
					$kartustok=array(
						'tanggal'=>date('Y-m-d'),
						'idproduct'=>$post['id'][$key],
						'nama'=>$nama,
						'saldomasuk_uk'=>0,
						'saldomasuk_qty'=>$post['jumlah'][$key],
						'harga'=>$post['harga'][$key],
						'keterangan'=>isset($post['keterangan'])?$post['keterangan']:'-',
					);
					kartustok($kartustok,2);
					$this->db->query(" UPDATE product set ukuran_item=ukuran_item-".$post['ukuran'][$key].", quantity=quantity-".$post['jumlah'][$key]." WHERE product_id=".$post['id'][$key]." ");
			}

			$insertFaktur = array(
				'no_faktur'		=> $post['noFaktur'],
				'tujuan_item'	=> $post['tujuanItem'],
				'kode_po'		=> $post['namaPo'],
				'create_date'	=> date('Y-m-d')
			);
			$this->GlobalModel->insertData('gudang_out_po',$insertFaktur);

			$this->session->set_flashdata('msg','Data berhasil ditambah');
			
			redirect(BASEURL.'gudang/pengeluaranbahan');
		/*}else{
			$this->session->set_flashdata('msgt','Data Gagal ditambah. Karena sudah pernah input sebelumnya');
			
			redirect(BASEURL.'gudang/pengeluaranbahan');
		}*/
	}

	public function outbahanHapus($id=null){
		$update=array(
			'hapus'=>1,
		);
		$this->db->update('gudang_bahan_keluar',$update,array('id_item_keluar'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'gudang/pengeluaranbahan');
	}

	public function outbahanOnPrint()
	{
		$post = $this->input->post();
		$viewData['post'] = $post;
		$viewData['page']='gudang/outbahan/print-out';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function outbahanDetail($id="")
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_bahan_keluar',array('faktur_no' => $id,'hapus'=>0));
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po' => $viewData['barang'][0]['kode_po']));
		$viewData['page']='gudang/outbahan/item-keluar-detail';
		$this->load->view('newtheme/page/main',$viewData);
	}

	

	public function outbahanEdit($id='')
	{
		$viewData['barang'] = $this->GlobalModel->getData('gudang_bahan_keluar',array('faktur_no'=>$id));
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['po'] = $this->GlobalModel->getData('produksi_po',NULL);
		$viewData['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$this->load->view('global/header');
		$this->load->view('gudang/outbahan/item_keluar_edit',$viewData);
		$this->load->view('global/footer');
	}

	public function outbahaneditOnCreate()
	{
		$post = $this->input->post();
		foreach ($post['nama'] as $key => $nama) {
			$dataInserted = array(
				'nama_item_keluar' 		=>	$nama,
				'warna_item_keluar' 	=>	$post['warna'][$key],
				'ukuran_item_keluar' 	=>	$post['ukuran'][$key],
				'satuan_item_keluar' 	=>	$post['satuanUkran'][$key],
				'jumlah_item_keluar' 	=>	$post['jumlah'][$key],
				'satuan_jumlah_keluar' 	=>	$post['satuanJml'][$key],
				'created_date' 			=>	date('Y-m-d'),
				'faktur_no' 			=>	$post['noFaktur'],
				'tujuan_item'			=>	$post['tujuanItem'],
				'harga_item'			=> 	$post['harga'][$key]
			);
			$where = array(
				'id_item_keluar' => $post['id'][$key]
			);
			$this->GlobalModel->updateData('gudang_bahan_keluar',$where,$dataInserted);
		}
		$this->session->set_flashdata('msg','Data berhasil di edit');
		redirect(BASEURL.'gudang/outbahah');
	}

	
	public function outbahanDelete($id='')
	{
		$this->GlobalModel->deleteData('gudang_bahan_keluar',array('id_item_keluar'=>$id));
		$this->session->set_flashdata('msg','Data berhasil di delete');
		redirect(BASEURL.'gudang/outbahah');
	}

}