<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Gudang extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->url=BASEURL.'Gudang/penerimaanitem';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function kartustok($id){
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
			$tanggal2=date('Y-m-d');
		}
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['kartustok']=[];
		$data['p'] = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('hapus'=>0,'id_persediaan'=>$id));
		$sql="SELECT * FROM kartustok_product WHERE hapus=0 AND idproduct='".$id."' ";
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		}
		$sql.=" ORDER BY tanggal ASC ";
		$data['kartustok']=$this->GlobalModel->queryManual($sql);

		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/kartustok_excel',$data);
		}else{
			$data['page']='gudang/persediaan/kartustok';
		$this->load->view('newtheme/page/main',$data);
		}
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
		$po=$this->GlobalModel->getDataRow('produksi_po',array('hapus'=>0,'id_produksi_po'=>$data['kode_po']));
		$update=array(
			'idpo'=>$po['id_produksi_po'],
			'kode_po'=>$po['kode_po'],
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

	function ajuanmingguan_kemeja(){
		$data=array();
		$data['title']='Ajuan Alat-alat Kirim PO Kemeja ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
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

		if(isset($get['spv'])){
			$cek=$this->GlobalModel->QueryManualRow("SELECT * FROM ajuan_mingguan_kemeja WHERE hapus=0 ORDER BY id DESC LIMIT 1 ");
			$tanggal1 =date('Y-m-d',strtotime($cek['tanggal']));
			$tanggal2 =date('Y-m-d',strtotime($cek['tanggal']));
			if(isset($get['tanggal1'])){
				$tanggal1=$get['tanggal1'];
			}else{
				//$tanggal1=date('Y-m-d',strtotime("Monday of this week"));
			}
			if(isset($get['tanggal2'])){
				$tanggal2=$get['tanggal2'];
			}else{
				//$tanggal2=date('Y-m-d');
			}
		}
		$data['accAjuan']=BASEURL.'Gudang/ajuanmingguanacckemeja';
		//pre($data['acc_ajuan_mingguan']);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		$data['products']=array();
		$data['n']=1;
		$sql="SELECT * FROM ajuan_mingguan_kemeja WHERE hapus=0";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		if(!empty($cat)){
			$sql.=" AND jenis='".$cat."' ";
		}
		$sql.=" ORDER BY jml_acc ASC ";
		
		$results=$this->GlobalModel->queryManual($sql);
		foreach($results as $result){
			$satuan = $this->GlobalModel->GetDataRow('product',array('hapus'=>0,'nama'=>$result['kebutuhan']));
			$data['products'][]=array(
				'id'=>$result['id'],
				'tanggal'=>$result['tanggal'],
				'kebutuhan'=>''.$result['kebutuhan'],
				'satuan' => !empty($satuan) ? $satuan['satuan'] : '',
				'jml_ajuan'=>$result['jml_ajuan'],
				'jml_acc'=>$result['jml_acc'],
				'keterangan'=>$result['keterangan'],
				'keterangan2'=>$result['keterangan2'],
				'edit'=>BASEURL.'Gudang/ajuanmingguaneditkemeja/'.$result['id'],
				'detail'=>BASEURL.'Gudang/ajuanmingguandetailkemeja/'.$result['id'],
				'batal'=>BASEURL.'Gudang/ajuanmingguandetailbatalkemeja/'.$result['id'],
				'bataladmin'=>BASEURL.'Gudang/ajuanmingguandetailbatalkemejaadmin/'.$result['id'],
				'excel'=>BASEURL.'Gudang/ajuanmingguandetailkemeja/'.$result['id'].'?&excel=1',
				'stok'=>$result['stok'],
				'acc_satuan'=> $result['acc_satuan'],
			);
		}
		$data['urlexcel']=BASEURL.'Gudang/ajuanmingguankemeja_excel_all';
		$data['tambah']=BASEURL.'Gudang/ajuanmingguantambahkemeja';
		if(isset($get['spv'])){
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_spv_kemeja';
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list';
		}
		//pre($data['products']);
		$data['acc_ajuan_mingguan']=$this->GlobalModel->QueryManualRow("SELECT tanggal FROM acc_ajuan_mingguan WHERE DATE(tanggal)='".$tanggal1."' ORDER BY tanggal DESC LIMIT 1");
		$data['tgl_diacc']	= !empty($data['acc_ajuan_mingguan']) ? $data['acc_ajuan_mingguan']['tanggal']:null;
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguan(){
		$data=array();
		$data['title']='Ajuan Alat-alat Kirim PO Kaos ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-14 days"));
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

		if(isset($get['spv'])){
			$cek=$this->GlobalModel->QueryManualRow("SELECT * FROM ajuan_mingguan WHERE hapus=0 AND typeajuan != 'celana'  AND jml_acc=0 ORDER BY id DESC LIMIT 1 ");
			$tanggal1 =date('Y-m-d',strtotime($cek['tanggal']));
			$tanggal2 =date('Y-m-d',strtotime($cek['tanggal']));
			if(isset($get['tanggal1'])){
				$tanggal1=$get['tanggal1'];
			}else{
				//$tanggal1=date('Y-m-d',strtotime("Monday of this week"));
			}
			if(isset($get['tanggal2'])){
				$tanggal2=$get['tanggal2'];
			}else{
				//$tanggal2=date('Y-m-d');
			}
		}
		$data['accAjuan']=BASEURL.'Gudang/ajuanmingguanacc';
		//pre($data['acc_ajuan_mingguan']);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		$data['products']=array();
		$data['n']=1;
		$sql="SELECT * FROM ajuan_mingguan WHERE hapus=0 AND typeajuan != 'celana' ";
		if(isset($get['spv'])){
			$sql.=" AND jml_acc=0 AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}else{
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		}
		
		if(!empty($cat)){
			$sql.=" AND jenis='".$cat."' ";
		}
		$sql.=" ORDER BY id DESC ";
		
		$results=$this->GlobalModel->queryManual($sql);
		foreach($results as $result){
			$satuan = $this->GlobalModel->GetDataRow('product',array('hapus'=>0,'nama'=>$result['kebutuhan']));
			$data['products'][]=array(
				'id'=>$result['id'],
				'tanggal'=>$result['tanggal'],
				'kebutuhan'=>''.$result['kebutuhan'],
				'satuan' => !empty($satuan) ? $satuan['satuan'] : '',
				'jml_ajuan'=>$result['jml_ajuan'],
				'jml_acc'=>$result['jml_acc'],
				'keterangan'=>$result['keterangan'],
				'keterangan2'=>$result['keterangan2'],
				'edit'=>BASEURL.'Gudang/ajuanmingguanedit/'.$result['id'],
				'detail'=>BASEURL.'Gudang/ajuanmingguandetail/'.$result['id'],
				'batal'=>BASEURL.'Gudang/ajuanmingguandetailbatal/'.$result['id'],
				'bataladmin'=>BASEURL.'Gudang/ajuanmingguandetailbataladmin/'.$result['id'],
				'excel'=>BASEURL.'Gudang/ajuanmingguandetail/'.$result['id'].'?&excel=1',
				'stok'=>$result['stok'],
				'acc_satuan' => $result['acc_satuan'],
				'accsatuan'	 => $satuan['accsatuan'],
				'metodebayar'	=> $result['metodebayar'],
			);
		}
		$data['tambah']=BASEURL.'Gudang/ajuanmingguantambah';
		if(isset($get['spv'])){
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_spv';
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list';
		}
		//pre($data['products']);
		$data['urlexcel']=BASEURL.'Gudang/ajuanmingguan_excel_all';
		$data['acc_ajuan_mingguan']=$this->GlobalModel->QueryManualRow("SELECT tanggal FROM acc_ajuan_mingguan WHERE DATE(tanggal)='".$tanggal1."' ORDER BY tanggal DESC LIMIT 1");
		$data['tgl_diacc']	= !empty($data['acc_ajuan_mingguan']) ? $data['acc_ajuan_mingguan']['tanggal']:null;
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguankemeja(){
		$data=array();
		$data['title']='Ajuan Alat-alat Kirim PO Kemeja ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
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

		if(isset($get['spv'])){
			$cek=$this->GlobalModel->QueryManualRow("SELECT * FROM ajuan_mingguan_kemeja WHERE hapus=0 ORDER BY id DESC LIMIT 1 ");
			$tanggal1 =date('Y-m-d',strtotime($cek['tanggal']));
			$tanggal2 =date('Y-m-d',strtotime($cek['tanggal']));
			if(isset($get['tanggal1'])){
				$tanggal1=$get['tanggal1'];
			}else{
				//$tanggal1=date('Y-m-d',strtotime("Monday of this week"));
			}
			if(isset($get['tanggal2'])){
				$tanggal2=$get['tanggal2'];
			}else{
				//$tanggal2=date('Y-m-d');
			}
		}
		$data['accAjuan']=BASEURL.'Gudang/ajuanmingguanacckemeja';
		//pre($data['acc_ajuan_mingguan']);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		$data['products']=array();
		$data['n']=1;
		$sql="SELECT * FROM ajuan_mingguan_kemejakemeja WHERE hapus=0";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		if(!empty($cat)){
			$sql.=" AND jenis='".$cat."' ";
		}
		$sql.=" ORDER BY id DESC ";
		
		$results=$this->GlobalModel->queryManual($sql);
		foreach($results as $result){
			$satuan = $this->GlobalModel->GetDataRow('product',array('hapus'=>0,'nama'=>$result['kebutuhan']));
			$data['products'][]=array(
				'id'=>$result['id'],
				'tanggal'=>$result['tanggal'],
				'kebutuhan'=>''.$result['kebutuhan'],
				'satuan' => !empty($satuan) ? $satuan['satuan'] : '',
				'jml_ajuan'=>$result['jml_ajuan'],
				'jml_acc'=>$result['jml_acc'],
				'keterangan'=>$result['keterangan'],
				'keterangan2'=>$result['keterangan2'],
				'edit'=>BASEURL.'Gudang/ajuanmingguaneditkemeja/'.$result['id'],
				'detail'=>BASEURL.'Gudang/ajuanmingguandetailkemeja/'.$result['id'],
				'batal'=>BASEURL.'Gudang/ajuanmingguandetailbatalkemeja/'.$result['id'],
				'bataladmin'=>BASEURL.'Gudang/ajuanmingguandetailbatalkemejaadmin/'.$result['id'],
				'excel'=>BASEURL.'Gudang/ajuanmingguandetailkemeja/'.$result['id'].'?&excel=1',
				'stok'=>$result['stok'],
			);
		}
		$data['tambah']=BASEURL.'Gudang/ajuanmingguantambah';
		if(isset($get['spv'])){
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_spv_kemeja';
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list';
		}
		//pre($data['products']);
		$data['acc_ajuan_mingguan']=$this->GlobalModel->QueryManualRow("SELECT tanggal FROM acc_ajuan_mingguan WHERE DATE(tanggal)='".$tanggal1."' ORDER BY tanggal DESC LIMIT 1");
		$data['tgl_diacc']	= !empty($data['acc_ajuan_mingguan']) ? $data['acc_ajuan_mingguan']['tanggal']:null;
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguankemeja_excel_all(){
		$data=array();
		$data['title']='Ajuan Alat-alat Kirim PO Kemeja';
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;

		$data['products']=array();
		$data['prods']=[];
		$data['n']=1;
		$date=looping_tanggal($tanggal1,$tanggal2);
		$ajuan=[];
		foreach($date as $d){
			//$ajuan=$this->GlobalModel->Getdata('ajuan_mingguan',array('hapus'=>0,'tanggal'=>$d['tanggal']));
			$sql="SELECT * FROM ajuan_mingguan_kemeja WHERE hapus=0 AND DATE(tanggal)='".$d['tanggal']."' ";
			if(!empty($cat)){
				$sql.=" AND jenis='".$cat."' ";
			}
			$ajuan=$this->GlobalModel->queryManual($sql);
			
			$data['prods'][]=array(
				'tanggal'=>$d['tanggal'],
				'ajuan'=>$ajuan,
			);
		}		
		//pre($data['prods']);
		$data['acc_ajuan_mingguan']=$this->GlobalModel->QueryManualRow("SELECT tanggal FROM acc_ajuan_mingguan ORDER BY tanggal DESC LIMIT 1");
		$data['tgl_diacc']	= !empty($data['acc_ajuan_mingguan']) ? $data['acc_ajuan_mingguan']['tanggal']:null;
		$data['tambah']=BASEURL.'Gudang/ajuanmingguantambah';
		$this->load->view($this->page.'gudang/pengajuan/mingguan_excel_all_kemeja',$data);
	}

	public function ajuanmingguan_excel_all(){
		$data=array();
		$data['title']='Ajuan Alat-alat Kirim PO';
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;

		$data['products']=array();
		$data['prods']=[];
		$data['n']=1;
		$date=looping_tanggal($tanggal1,$tanggal2);
		$ajuan=[];
		foreach($date as $d){
			//$ajuan=$this->GlobalModel->Getdata('ajuan_mingguan',array('hapus'=>0,'tanggal'=>$d['tanggal']));
			$sql="SELECT * FROM ajuan_mingguan WHERE hapus=0 AND DATE(tanggal)='".$d['tanggal']."' ";
			if(!empty($cat)){
				$sql.=" AND jenis='".$cat."' ";
			}
			$ajuan=$this->GlobalModel->queryManual($sql);
			
			$data['prods'][]=array(
				'tanggal'=>$d['tanggal'],
				'ajuan'=>$ajuan,
			);
		}		
		//pre($data['prods']);
		$data['acc_ajuan_mingguan']=$this->GlobalModel->QueryManualRow("SELECT tanggal FROM acc_ajuan_mingguan ORDER BY tanggal DESC LIMIT 1");
		$data['tgl_diacc']	= !empty($data['acc_ajuan_mingguan']) ? $data['acc_ajuan_mingguan']['tanggal']:null;
		$data['tambah']=BASEURL.'Gudang/ajuanmingguantambah';
		$this->load->view($this->page.'gudang/pengajuan/mingguan_excel_all',$data);
	}

	public function ajuanmingguandetailkemeja($id){
		$data=array();
		$data['n']=1;
		$data['title']='Detail Ajuan Alat-alat Kirim Kemeja';
		$get=$this->input->get();
		$url='';
		if(isset($get['spv'])){
			$url='?&spv=true';
		}
		$data['action']=BASEURL.'Gudang/ajuanmingguansavekemeja';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan_kemeja'.$url;
		$data['excel']=BASEURL.'Gudang/ajuanmingguandetailkemeja/'.$id.'?&excel=1';
		$data['k']=$this->GlobalModel->getDataRow('ajuan_mingguan_kemeja',array('hapus'=>0,'id'=>$id));
		$data['kd']=$this->GlobalModel->getData('ajuan_mingguan_detail_kemeja',array('hapus'=>0,'idajuan'=>$id));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['acc']=BASEURL.'Gudang/ajuanmingguanacckemeja';
		$get=$this->input->get();		
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/mingguan_detail_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function ajuanmingguandetail($id){
		$data=array();
		$data['n']=1;
		$data['title']='Detail Ajuan Alat-alat Kirim PO';
		$get=$this->input->get();
		$url='';
		if(isset($get['spv'])){
			$url='?&spv=true';
		}
		$data['action']=BASEURL.'Gudang/ajuanmingguansave';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan'.$url;
		$data['excel']=BASEURL.'Gudang/ajuanmingguandetail/'.$id.'?&excel=1';
		$data['k']=$this->GlobalModel->getDataRow('ajuan_mingguan',array('hapus'=>0,'id'=>$id));
		$data['kd']=$this->GlobalModel->getData('ajuan_mingguan_detail',array('hapus'=>0,'idajuan'=>$id));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['acc']=BASEURL.'Gudang/ajuanmingguanacc';
		$get=$this->input->get();		
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/mingguan_detail_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function ajuanmingguanedit($id){
		$data=array();
		$data['n']=1;
		$data['title']='Edit Ajuan Alat-alat Kirim PO';
		$data['action']=BASEURL.'Gudang/ajuanmingguansave_edit';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan';
		$data['excel']=BASEURL.'Gudang/ajuanmingguandetail/'.$id.'?&excel=1';
		$data['k']=$this->GlobalModel->getDataRow('ajuan_mingguan',array('hapus'=>0,'id'=>$id));
		$data['kd']=$this->GlobalModel->getData('ajuan_mingguan_detail',array('hapus'=>0,'idajuan'=>$id));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['acc']=BASEURL.'Gudang/ajuanmingguanacc';
		$get=$this->input->get();		
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/mingguan_detail_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_edit';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function ajuanmingguaneditkemeja($id){
		$data=array();
		$data['n']=1;
		$data['title']='Edit Ajuan Alat-alat Kirim Kemeja';
		$data['action']=BASEURL.'Gudang/ajuanmingguansave_editkemeja';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan_kemeja';
		$data['excel']=BASEURL.'Gudang/ajuanmingguandetailkemeja/'.$id.'?&excel=1';
		$data['k']=$this->GlobalModel->getDataRow('ajuan_mingguan_kemeja',array('hapus'=>0,'id'=>$id));
		$data['kd']=$this->GlobalModel->getData('ajuan_mingguan_detail_kemeja',array('hapus'=>0,'idajuan'=>$id));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['acc']=BASEURL.'Gudang/ajuanmingguanacc_kemeja';
		$get=$this->input->get();		
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/mingguan_detail_excel',$data);
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_edit';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function ajuanmingguantambah(){
		$data=array();
		$data['title']='Form Ajuan Alat-alat Kirim PO';
		$data['typeajuan']	='alat-alat';
		$data['action']=BASEURL.'Gudang/ajuanmingguansave';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan';
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$data['page']=$this->page.'gudang/pengajuan/mingguan_form';
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguantambahkemeja(){
		$data=array();
		$data['title']='Form Ajuan Alat-alat Kirim PO Kemeja';
		$data['action']=BASEURL.'Gudang/ajuanmingguansavekemeja';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan_kemeja';
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$data['page']=$this->page.'gudang/pengajuan/mingguan_form_kemeja';
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguansavekemeja(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$item = $this->GlobalModel->GetDataRow('product',array('product_id'=>$data['kebutuhan']));
			$am=array(
				'tanggal'=>$data['tanggal'],
				'jenis'=>$data['jenis'], // 1 konveksi, 2 bordir, 3 sablon
				'kebutuhan'=>$item['nama'],
				'product_id' => $item['product_id'],
				// 'ajuan_kebutuhan'=>$data['ajuan_kebutuhan'],
				'ajuan_kebutuhan'=>0,
				'stok'=>$data['stok_skb'],
				//'jml_ajuan'=>$data['jml_ajuan'],
				'jml_ajuan'=>0,
				'keterangan'=>'kebutuhan '.$data['kebutuhan'],
				'keterangan2'=>$data['keterangan2'],
				'supplier_id'=>$data['supplier_id'],
				//'keterangan'=>$data['keterangan'],
			);
			$this->db->insert('ajuan_mingguan_kemeja',$am);
			$id=$this->db->insert_id();
			$totalajuan=0;
			foreach($data['products'] as $p){
				$totalajuan+=($p['jumlah_po']*$p['jml_pcs']);
				$insert=array(
					'idajuan'=>$id,
					'tanggal'=>$data['tanggal'],
					'tanggal2'=>$data['tanggal'],
					'kode_po'=>$p['kode_po'],
					'jumlah_po'=>$p['jumlah_po'],
					'rincian_po'=>$p['rincian_po'],
					// 'jml_pcs'=>str_replace(",", ".", $p['jml_pcs']),
					// 'jml_dz'=>str_replace(",", ".", $p['jml_dz']),
					'jml_pcs'=>$p['jml_pcs'],
					'jml_dz'=>$p['jml_dz'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('ajuan_mingguan_detail_kemeja',$insert);
			}
			$this->db->update('ajuan_mingguan_kemeja',array('ajuan_kebutuhan'=>$totalajuan,'jml_ajuan'=>$totalajuan-$data['stok_skb']),array('id'=>$id));
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/ajuanmingguan_kemeja');
	}

	public function ajuanmingguansave(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$item = $this->GlobalModel->GetDataRow('product',array('product_id'=>$data['kebutuhan']));
			$am=array(
				'tanggal'=>$data['tanggal'],
				'jenis'=>$data['jenis'], // 1 konveksi, 2 bordir, 3 sablon
				'kebutuhan'=>$item['nama'],
				'product_id' => $item['product_id'],
				// 'ajuan_kebutuhan'=>$data['ajuan_kebutuhan'],
				'ajuan_kebutuhan'=>0,
				'stok'=>$data['stok'],
				//'jml_ajuan'=>$data['jml_ajuan'],
				'jml_ajuan'=>0,
				'keterangan'=>'kebutuhan '.$data['kebutuhan'],
				'keterangan2'=>$data['keterangan2'],
				'supplier_id'=>$data['supplier_id'],
				'metodebayar'=>isset($data['metodebayar']) ? $data['metodebayar'] : null,
				//'keterangan'=>$data['keterangan'],
			);
			$this->db->insert('ajuan_mingguan',$am);
			$id=$this->db->insert_id();
			$totalajuan=0;
			foreach($data['products'] as $p){
				$totalajuan+=($p['jumlah_po']*$p['jml_pcs']);
				$insert=array(
					'idajuan'=>$id,
					'tanggal'=>$data['tanggal'],
					'tanggal2'=>$data['tanggal'],
					'kode_po'=>$p['kode_po'],
					'jumlah_po'=>$p['jumlah_po'],
					'rincian_po'=>$p['rincian_po'],
					// 'jml_pcs'=>str_replace(",", ".", $p['jml_pcs']),
					// 'jml_dz'=>str_replace(",", ".", $p['jml_dz']),
					'jml_pcs'=>$p['jml_pcs'],
					'jml_dz'=>$p['jml_dz'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('ajuan_mingguan_detail',$insert);
			}
			$this->db->update('ajuan_mingguan',array('ajuan_kebutuhan'=>$totalajuan,'jml_ajuan'=>$totalajuan-$data['stok']),array('id'=>$id));
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/ajuanmingguan');
	}

	function ajuanmingguandetailbatal($id){
		$this->db->update('ajuan_mingguan',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dibatalkan');
		redirect(BASEURL.'Gudang/ajuanmingguan?&spv=true');
	}

	function ajuanmingguandetailbataladmin($id){
		$this->db->update('ajuan_mingguan',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dibatalkan');
		redirect(BASEURL.'Gudang/ajuanmingguan');
	}

	function ajuanmingguandetailbatalkemeja($id){
		$this->db->update('ajuan_mingguan_kemeja',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dibatalkan');
		redirect(BASEURL.'Gudang/ajuanmingguankemeja?&spv=true');
	}

	function ajuanmingguandetailbatalkemejaadmin($id){
		$this->db->update('ajuan_mingguan_kemeja',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dibatalkan');
		redirect(BASEURL.'Gudang/Ajuanmingguan_kemeja');
	}

	public function ajuanmingguansave_edit(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			/*
			$am=array(
				'tanggal'=>$data['tanggal'],
				'jenis'=>$data['jenis'], // 1 konveksi, 2 bordir, 3 sablon
				//'kebutuhan'=>$data['kebutuhan'],
				'ajuan_kebutuhan'=>0,
				'stok'=>$data['stok'],
				'jml_ajuan'=>0,
				//'keterangan'=>'kebutuhan '.$data['kebutuhan'],
			);
			$this->db->update('ajuan_mingguan',$am,array('id'=>$data['id']));
			$totalajuan=0;
			foreach($data['products'] as $p){
				$totalajuan+=($p['jumlah_po']*$p['jml_pcs']);
				$insert=array(
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
				$this->db->update('ajuan_mingguan_detail',$insert,array('id'=>$p['id']));
			}
			$this->db->update('ajuan_mingguan',array('ajuan_kebutuhan'=>$totalajuan,'jml_ajuan'=>$totalajuan-$data['stok']),array('id'=>$data['id']));
			*/
			$this->db->update('ajuan_mingguan_detail',array('hapus'=>1),array('idajuan'=>$data['id']));
			$totalajuan=0;
			foreach($data['products'] as $p){
				$totalajuan+=($p['jumlah_po']*$p['jml_pcs']);
				$insert=array(
					'idajuan'=>$data['id'],
					'tanggal'=>$data['tanggal'],
					'tanggal2'=>$data['tanggal'],
					'kode_po'=>$p['kode_po'],
					'jumlah_po'=>$p['jumlah_po'],
					'rincian_po'=>$p['rincian_po'],
					// 'jml_pcs'=>str_replace(",", ".", $p['jml_pcs']),
					// 'jml_dz'=>str_replace(",", ".", $p['jml_dz']),
					'jml_pcs'=>$p['jml_pcs'],
					'jml_dz'=>$p['jml_dz'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('ajuan_mingguan_detail',$insert);
			}
			$this->db->update('ajuan_mingguan',array('keterangan2'=>$data['keterangan'],'ajuan_kebutuhan'=>$totalajuan,'stok'=>$data['stok'],'jml_ajuan'=>$totalajuan-$data['stok']),array('id'=>$data['id']));
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/ajuanmingguan');
	}

	public function ajuanmingguansave_editkemeja(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			
			$this->db->update('ajuan_mingguan_detail_kemeja',array('hapus'=>1),array('idajuan'=>$data['id']));
			$totalajuan=0;
			foreach($data['products'] as $p){
				$totalajuan+=($p['jumlah_po']*$p['jml_pcs']);
				$insert=array(
					'idajuan'=>$data['id'],
					'tanggal'=>$data['tanggal'],
					'tanggal2'=>$data['tanggal'],
					'kode_po'=>$p['kode_po'],
					'jumlah_po'=>$p['jumlah_po'],
					'rincian_po'=>$p['rincian_po'],
					// 'jml_pcs'=>str_replace(",", ".", $p['jml_pcs']),
					// 'jml_dz'=>str_replace(",", ".", $p['jml_dz']),
					'jml_pcs'=>$p['jml_pcs'],
					'jml_dz'=>$p['jml_dz'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('ajuan_mingguan_detail_kemeja',$insert);
			}
			$this->db->update('ajuan_mingguan_kemeja',array('keterangan2'=>$data['keterangan'],'ajuan_kebutuhan'=>$totalajuan,'stok'=>$data['stok_skb'],'jml_ajuan'=>$totalajuan-$data['stok_skb']),array('id'=>$data['id']));
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/ajuanmingguan_kemeja');
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
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}

		if(isset($get['id_bahan'])){
			$id_bahan=$get['id_bahan'];
		}else{
			$id_bahan=null;
		}

		$data['persediaan']= $this->GlobalModel->Getdata('product',array('hapus'=>0));
		$sql="SELECT * FROM barangkeluar_harian  ";
		if(!empty($id_bahan)){
			$sql .=" LEFT JOIN barangkeluar_harian_detail ON barangkeluar_harian_detail.idbarangkeluar=barangkeluar_harian.id ";
			$sql .=" WHERE barangkeluar_harian.hapus=0 AND barangkeluar_harian_detail.id_persediaan='".$id_bahan."' ";
		}else{
			$sql .=" WHERE hapus=0 ";
		}
		
		if(!empty($id_bahan)){

		}else{
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}

		if(!empty($kode_po)){
			$sql.=" AND kode_po='".$kode_po."' ";
		}

		if(!empty($jenis)){
			$sql.=" AND barangkeluar_harian.jenis='".$jenis."' ";
		}

		$sql.=" ORDER BY barangkeluar_harian.id DESC";
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['kode_po']=$kode_po;
		$data['jenis']=$jenis;
		$data['products']=array();
		$details=array();
		$data['tambah']=BASEURL.'Gudang/barangkeluartambah/'.$jenis;
		$products=$this->GlobalModel->queryManual($sql);
		//$products=$this->GlobalModel->getData('barangkeluar_harian',array('hapus'=>0,'jenis'=>$jenis));
		$no=1;
		$bagian=null;
		foreach($products as $p){
			$bagian=$this->GlobalModel->GetDataRow('bagian_pengambilan',array('id'=>$p['bagian']));
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
				'bagian'=>!empty($bagian['nama'])?$bagian['nama']:'-',
				'pengambil'=>$p['pengambil'],
				'gudang'=>$p['gudang'],
				'othapus'=>akseshapus(),
			);
		}
		
		if(isset($get['excel'])){
			$this->load->view($this->page.'barangkeluar/barangkeluar_excel',$data);
		}else{

			$data['page']=$this->page.'barangkeluar/barangkeluar_list';
			$this->load->view($this->page.'main',$data);
		
		}
	}

	public function barangkeluartambah($jenis){
		$title='sadasd';
		$data=array();
		if($jenis==1){
			$title="Bordir";
			$data['fromajuanbordir']=true;
		}else if($jenis==2){
			$title="Konveksi";
			$data['fromajuanbordir']=true;
		}else{
			$title='Bahan Keluar Harian';
		}
		$data['jenis']=$jenis;
		$data['title']=$title;
		$data['forms']=[];
		//pre($data);
		$data['action']=BASEURL.'Gudang/barangkeluarsave/'.$jenis;
		$data['cancel']=BASEURL.'Gudang/barangkeluar/'.$jenis;
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		//$data['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		$data['barang'] = $this->GlobalModel->QueryManual("SELECT * FROM gudang_persediaan_item WHERE hapus=0 ORDER BY nama_item ASC ");
		$data['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$data['po'] = $this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$data['bagian']=$this->GlobalModel->getData('bagian_pengambilan',array());
		$data['forms'] = $this->GlobalModel->getData('formpengambilanalat',array('hapus'=>0,'status'=>2));
		$data['page']=$this->page.'barangkeluar/barangkeluar_form';
		$this->load->view($this->page.'main',$data);
	}

	public function barangkeluarsave(){
		$data=$this->input->post();
		// pre($data);
		if(isset($data['products'])){
			$insert=array(
				'tanggal'=>$data['tanggal'],
				'kode_po'=>$data['kode_po'],
				'keterangan'=>$data['keterangan'],
				'jenis'=>$data['jenis'],
				'bagian'=>$data['bagian'],
				'pengambil'=>$data['pengambil'],
				'gudang'=>$data['gudang'],
				'hapus'=>0
			);
			$this->db->insert('barangkeluar_harian',$insert);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$curqty=$this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$p['id_persediaan']));
				$kartustok=array(
						'tanggal'=>date('Y-m-d'),
						'idproduct'=>$p['id_persediaan'],
						'nama'=>$p['nama'],
						'saldomasuk_uk'=>$p['ukuran'],
						'saldomasuk_qty'=>$p['jumlah'],
						'harga'=>$p['harga'],
						'keterangan'=>isset($data['keterangan'])?$data['keterangan']:'-',
					);
				kartustok($kartustok,2);
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
					'tanggal'=>$data['tanggal'],
					'jenis'=>$data['jenis'],
				);
				$this->db->insert('barangkeluar_harian_detail',$detail);
			}
			user_activity(callSessUser('id_user'),1,' Input barang / bahan keluar harian dengan id '.$id);

			if(isset($data['id_form'])){
				$this->db->update('formpengambilanalat',array('status'=>1),array('id'=>$data['id_form']));
				user_activity(callSessUser('id_user'),1,' memvalidasi ajuan formpengambilanalat dengan  id '.$data['id_form']);
			}
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Gudang/barangkeluar/'.$data['jenis']);	
		}
	}

	public function barangkeluarhapus($id,$id2,$jenis){
		
		//$this->db->query("UPDATE barangkeluar_harian SET hapus=1 WHERE id='$id' ");
		$this->db->query("UPDATE barangkeluar_harian_detail SET hapus=1 WHERE id='$id2' ");
		$p=$this->GlobalModel->getDataRow('barangkeluar_harian_detail',array('id'=>$id2));
		$kartustok=array(
			'tanggal'=>date('Y-m-d'),
			'idproduct'=>$p['id_persediaan'],
			'nama'=>$p['nama'],
			'saldomasuk_uk'=>$p['ukuran'],
			'saldomasuk_qty'=>$p['jumlah'],
			'harga'=>$p['harga'],
			'keterangan'=>'Pembatalan barang keluar harian oleh '.callSessUser('nama_user'),
		);
		kartustok($kartustok,1);
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
		
		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$data['setujui']=akses($user['id_user'],3);
		}
		$data['id_user']=$user['id_user'];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
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
		$last=$this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE hapus=0 ORDER BY tanggal DESC limit 1 ");
		$sql="SELECT * FROM pengajuan_harian_new WHERE hapus=0 ";
		$tgl2= empty($tanggal2)?date('Y-m-d'):$tanggal2;
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tgl2."' ";
		}else{
			$sql.=" AND date(tanggal)='".$last['tanggal']."' ";
		}
		if(!empty($cat)){
			$sql.=" AND kategori='".$cat."' ";
		}else{
			if(isset($get['list_skb'])){
				$sql.=" AND kategori IN (4) ";
			}else{
				
			}
		}
		$sql.=" ORDER BY id DESC ";
		if( isset($get['tanggal1']) OR isset($get['cat']) ){

		}else{
			$sql.="LIMIT 10";
		}
		$data['harian'] =$this->db->query($sql)->result_array();
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/view_excel',$data);
		}else{
			if(!isset($get['list_skb'])){
				$data['title']='Pengajuan';
				$data['tambah']=BASEURL.'Gudang/pengajuanadd';
				$data['page']=$this->page.'gudang/pengajuan/view';		
				$this->load->view($this->page.'main',$data);
			}else{
				$data['title']='Pengajuan Sukabumi (Non-pembelian)';
				$data['page']=$this->page.'gudang/pengajuan/list_ajuan_skb';
				$data['tambah']=BASEURL.'Gudang/pengajuanadd?&sukabumi=true';
				$this->load->view($this->page.'main',$data);
			}
			
		}
	}

	public function pengajuanmanajer(){
		$data=array();
		
		$data['products']=array();
		$data['n']=1;
		
		$user=user();
		$setujui=0;
		if(isset($user['id_user'])){
			$data['setujui']=akses($user['id_user'],3);
		}
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
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
		$last=$this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE hapus=0 ORDER BY tanggal DESC limit 1 ");
		$sql="SELECT * FROM pengajuan_harian_new WHERE hapus=0 ";
		$tgl2= empty($tanggal2)?date('Y-m-d'):$tanggal2;
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tgl2."' ";
		}else{
			$sql.=" AND date(tanggal)='".$last['tanggal']."' ";
		}
		if(!empty($cat)){
			$sql.=" AND kategori='".$cat."' ";
		}else{
			if(isset($get['list_skb'])){
				$sql.=" AND kategori IN (4) ";
			}else{
				
			}
		}
		$sql.=" ORDER BY id DESC ";
		if( isset($get['tanggal1']) OR isset($get['cat']) ){

		}else{
			$sql.="LIMIT 10";
		}
		$data['harian'] =$this->db->query($sql)->result_array();
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		if(isset($get['excel'])){
			$this->load->view($this->page.'gudang/pengajuan/view_excel',$data);
		}else{
			if(!isset($get['list_skb'])){
				$data['title']='Pengajuan';
				$data['tambah']=BASEURL.'Gudang/pengajuanadd';
				$data['page']=$this->page.'gudang/pengajuan/manajer';		
				$this->load->view($this->page.'main',$data);
			}else{
				$data['title']='Pengajuan Sukabumi (Non-pembelian)';
				$data['page']=$this->page.'gudang/pengajuan/list_ajuan_skb';
				$data['tambah']=BASEURL.'Gudang/pengajuanadd?&sukabumi=true';
				$this->load->view($this->page.'main',$data);
			}
			
		}
	}

	public function pengajuanadd()
	{
		$get = $this->input->get();
		if(isset($get['sukabumi'])){
			$data['sukabumi']='ya';
		}else{
			$data['sukabumi']='tidak';
		}
		$viewData['title']='Form Ajuan Belanja ';
		$viewData['action']=BASEURL.'Gudang/pengajuansave';
		$viewData['batal']=BASEURL.'Gudang/pengajuan';
		$viewData['supplier'] = $this->GlobalModel->getData('master_supplier',null);
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['products'] = $this->GlobalModel->getData('product',array('hapus'=>0));

		$viewData['katpeng']=array(1=>'SABLON',2=>'BORDIR',3=>'KONVEKSI',4=>'SUKABUMI');
		if(isset($get['sukabumi'])){
			$viewData['batal']=BASEURL.'Gudang/pengajuan?&list_skb';
			if(isset($get['list'])){
				$page='newtheme/page/gudang/pengajuan/list_ajuan_skb';
			}else{
				$page='newtheme/page/gudang/pengajuan/list_ajuan_skb_form';
			}
			
		}else{
			$page='newtheme/page/gudang/pengajuan/tambah';
		}
		$viewData['page']=$page;
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
		user_activity(callSessUser('id_user'),1,' menyetujui pengajuan dengan id ajuan '.$id);
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
		user_activity(callSessUser('id_user'),1,' menghapus pengajuan dengan id ajuan '.$id);
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
			user_activity(callSessUser('id_user'),1,' Input pengajuan harian dengan id '.$id);
			$this->db->insert('notifikasi',$notify);
			$msg=callSessUser('nama_user').' telah membuat ajuan harian';
			push($msg);
			
			$this->session->set_flashdata('msg','Data berhasil disimpan');

			if($data['kategoriPengajuan']==4){
				redirect(BASEURL.'Gudang/pengajuan?&list_skb=4&cat=4');
			}else{
				redirect(BASEURL.'Gudang/pengajuan');
			}
			
		}

	}

	public function pengajuancetak($kode=''){
		$viewData['item'] = $this->GlobalModel->getData('pengajuan_harian_new_detail',array('pembayaran'=>1,'idpengajuan'=>$kode,'hapus'=>0));
		$viewData['item_cash'] = $this->GlobalModel->getData('pengajuan_harian_new_detail',array('pembayaran'=>1,'idpengajuan'=>$kode,'hapus'=>0));
		$viewData['item_tf'] = $this->GlobalModel->getData('pengajuan_harian_new_detail',array('pembayaran'=>2,'idpengajuan'=>$kode,'hapus'=>0));

		$viewData['parent'] = $this->GlobalModel->getDataRow('pengajuan_harian_new',array('id'=>$kode));
		$viewData['mingguan'] = !empty($viewData['parent']['from_mingguan']) ? 'MINGGUAN':'HARIAN';
		$adminkeu=null;
		$adminkeu=$this->GlobalModel->getDataRow('karyawan',array('jabatan'=>24));
		$viewData['adminkeu']=$adminkeu['nama'];
		$adminskb =$this->GlobalModel->getDataRow('user',array('location'=>'Sukabumi','status_user'=>1));
		$viewData['adminskb']=!empty($adminskb) ? strtolower($adminskb['nama_user']):'';
		$viewData['action']=BASEURL.'Gudang/pengajuan';
		$viewData['menyetujui']=0;
		$get=$this->input->get();
		if(isset($get['excel'])){
			if(isset($get['sukabumiforjkt'])){
				$this->load->view('newtheme/page/gudang/pengajuan/cetak_exceljktskb',$viewData);
			}else{
				$this->load->view('newtheme/page/gudang/pengajuan/cetak_excel',$viewData);
			}
			
		}else{
			if(isset($get['sukabumiforjkt'])){
				$viewData['page']='newtheme/page/gudang/pengajuan/cetakskbjkt';
			}else{
				$viewData['page']='newtheme/page/gudang/pengajuan/cetak';
			}
			
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
		$pengajuan = $this->GlobalModel->GetDataRow('pengajuan_harian_new',array('id'=>$data['id']));
		$cash=0;
		$transfer=0;
		$status=($pengajuan['kategori']==4)?1:0; // 0 diajukan, 1 disetujui
		if(isset($data['editacc'])){
			// $status=1; // request jika edit maka perlu acc ulang, 24 Oktober 2022
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
					'status'=>$data['statusajuan'],
					'hapus'=>isset($p['hapus'])?$p['hapus']:0,
					'idpengajuan'=>$data['id'],
				);
				if(isset($p['id'])){
					$this->db->update('pengajuan_harian_new_detail',$update,array('id'=>$p['id']));	
				}else{
					$this->db->insert('pengajuan_harian_new_detail',$update);
				}
				
			}
			$this->db->update('pengajuan_harian_new',array('tanggal'=>$data['tanggal'],'cash'=>$cash,'transfer'=>$transfer,'status'=>$data['statusajuan']),array('id'=>$data['id']));
			$msg=callSessUser('nama_user').' telah merevisi pengajuan harian';
			push($msg);
			// kirim_email('muchlasmuchtar25@gmail.com',callSessUser('nama_user').' telah merevisi pengajuan harian dengan nomor '.$data['id'].' ');
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
			// kirim_email('ulfahcahayaag@gmail.com',$pesan);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			if($data['kategori']==4){
				redirect(BASEURL.'Gudang/pengajuan?&list_skb&cat=4');
			}else{
				redirect(BASEURL.'Gudang/pengajuan');
			}
			
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
		$setujui=0;
		if(isset($user['id_user'])){
			$data['setujui']=akses($user['id_user'],3);
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
		if(isset($get['supplier'])){
			$sups=$get['supplier'];
		}else{
			$sups=null;
		}
		$sql='SELECT * FROM penerimaan_item WHERE hapus=0 ';

		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
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

			$action[]=array(
				'text'=>'Ajukan Perubahan harga',
				'href'=>BASEURL.'Gudang/penerimaanitemdetail_ubahharga/'.$result['id'],
			);


			$supplier=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$result['supplier']));
			$products=$this->GlobalModel->getData('penerimaan_item_detail',array('hapus'=>0,'penerimaan_item_id'=>$result['id']));
			$data['items'][]=array(
				'id'=>$result['id'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'nosj'=>$result['nosj'],
				'keterangan'=>$result['keterangan'],
				'supplier'=>empty($supplier)?'':$supplier['nama'],
				'jenis'=>$result['jenis'],
				'tipepembayaran'=>$result['tipepembayaran'],
				'total'	=> $this->total($result['id']),
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

	function total($id){
		$hasil =0;


		return $hasil;
	}

	function validasi($id){
				$update = array(
					'validasi' =>1,
				);
				$where = array(
					'id' => $id,
				);
				$this->db->update('penerimaan_item_detail',$update,$where);
				$this->session->set_flashdata('msg','Data berhasil disimpan');
				user_activity(callSessUser('id_user'),1,' validasi penerimaan item detail dengan id '.$id);
				redirect(BASEURL.'gudang/penerimaanitem');
	}

	public function penerimaanitemadd()

	{
		$data=array();
		$data['title']='Form Penerimaan Item Masuk';
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
		// pre($_FILES['lampiran']['name']);
		if(isset($data['products'])){
			if(!empty($data['products'])){
				$it=array(
					'tanggal'=>isset($data['tanggal'])?$data['tanggal']:date('Y-m-d'),
					'supplier'=>$data['supplier'],
					'nosj'=>$data['nosj'],
					'keterangan'=>isset($data['keterangan'])?$data['keterangan']:'-',
					'jenis'=>$data['jenis'],
					'tipepembayaran'=>$data['tipepembayaran'],
					'hapus'=>0
				);
				$this->db->insert('penerimaan_item',$it);
				$id=$this->db->insert_id();

				if(isset($_FILES['lampiran']['name'])){
					// Konfigurasi upload
					$config['upload_path'] = './uploads/lampiran/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';

					// Inisialisasi upload library
					$this->load->library('upload', $config);

					// Memeriksa apakah folder uploads/lampiran/ sudah ada
					$folderPath = $config['upload_path'];
					if (!file_exists($folderPath)) {
						// Membuat folder jika belum ada
						if (!mkdir($folderPath, 0777, true)) {
							die('Gagal membuat folder...');
						}
					}

					// Melakukan upload file
					$this->upload->do_upload('lampiran');

					// Mendapatkan nama file yang diunggah
					$fileName = $config['upload_path'].$this->upload->data('file_name');

					// Mendapatkan tipe file yang diunggah
					$fileType = $this->upload->data('file_type');

					// Mengkompres gambar jika tipe file adalah gambar
					if ($fileType == 'image/jpeg' || $fileType == 'image/jpg') {
						$compressedFileName = $fileName . '_compressed.jpg';
						$quality = 75; // Kualitas kompresi, rentang 0-100 (semakin tinggi semakin baik kualitasnya)
						$source = imagecreatefromjpeg($fileName);
						imagejpeg($source, $compressedFileName, $quality);
						imagedestroy($source);
					} elseif ($fileType == 'image/png') {
						$compressedFileName = $fileName . '_compressed.png';
						$quality = 6; // Kualitas kompresi, rentang 0-9 (semakin tinggi semakin baik kualitasnya)
						$source = imagecreatefrompng($fileName);
						imagepng($source, $compressedFileName, $quality);
						imagedestroy($source);
					} elseif ($fileType == 'image/gif') {
						$compressedFileName = $fileName . '_compressed.gif';
						// Tidak ada opsi kompresi untuk format GIF
					} else {
						$compressedFileName = $fileName;
					}

					$this->db->update('penerimaan_item',array('lampiran'=>$compressedFileName),array('id'=>$id));
					// Menghapus file asli
					unlink($fileName);
				}

				

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
						'keterangan'=>$p['keterangan'],
						'tanggal'=>isset($data['tanggal'])?$data['tanggal']:date('Y-m-d'),
						'jenis'=>$data['jenis'],
						'hapus'=>0
					);
					$this->db->insert('penerimaan_item_detail',$itd);					
					if($data['jenis']==5){
						$kartustok=array(
							'tanggal'=>isset($data['tanggal'])?$data['tanggal']:date('Y-m-d'),
							'idproduct'=>$p['id_persediaan'],
							'nama'=>$p['nama'],
							'saldomasuk_uk'=>$p['jumlah'],
							'saldomasuk_qty'=>0,
							'harga'=>$p['harga'],
							'sisa_qty'=>$p['jumlah'],
							'keterangan'=>isset($data['keterangan'])?$data['keterangan']:'-',
						);
						
						$this->db->insert('kartustok_product',$kartustok);
					}else{
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
						$this->db->query("UPDATE product set ukuran_item=ukuran_item+".$p['ukuran'].",quantity=quantity+'".$p['jumlah']."', harga_beli='".$p['harga']."' WHERE product_id='".$p['id_persediaan']."' ");
						$this->db->query("UPDATE gudang_persediaan_item set ukuran_item=ukuran_item+".$p['ukuran'].", jumlah_item=jumlah_item+'".$p['jumlah']."' WHERE id_persediaan='".$p['id_persediaan']."' ");
					}
					
				}
				$this->session->set_flashdata('msg','Data berhasil disimpan');
				user_activity(callSessUser('id_user'),1,' penerimaan item dengan id '.$id);
				redirect(BASEURL.'gudang/penerimaanitem');
			}
		}
	}

	public function penerimaanitemsave_image(){
		$data=$this->input->post();
		$post=$this->input->post();
		// pre($_FILES['lampiran']['name']);
		if(isset($_FILES['lampiran']['name'])){
			// Konfigurasi upload
			$config['upload_path'] = './uploads/lampiran/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';

			// Inisialisasi upload library
			$this->load->library('upload', $config);

			// Memeriksa apakah folder uploads/lampiran/ sudah ada
			$folderPath = $config['upload_path'];
			if (!file_exists($folderPath)) {
				// Membuat folder jika belum ada
				if (!mkdir($folderPath, 0777, true)) {
					die('Gagal membuat folder...');
				}
			}

			// Melakukan upload file
			$this->upload->do_upload('lampiran');

			// Mendapatkan nama file yang diunggah
			$fileName = $config['upload_path'].$this->upload->data('file_name');

			// Mendapatkan tipe file yang diunggah
			$fileType = $this->upload->data('file_type');

			// Mengkompres gambar jika tipe file adalah gambar
			if ($fileType == 'image/jpeg' || $fileType == 'image/jpg') {
				$compressedFileName = $fileName . '_compressed.jpg';
				$quality = 75; // Kualitas kompresi, rentang 0-100 (semakin tinggi semakin baik kualitasnya)
				$source = imagecreatefromjpeg($fileName);
				imagejpeg($source, $compressedFileName, $quality);
				imagedestroy($source);
			} elseif ($fileType == 'image/png') {
				$compressedFileName = $fileName . '_compressed.png';
				$quality = 6; // Kualitas kompresi, rentang 0-9 (semakin tinggi semakin baik kualitasnya)
				$source = imagecreatefrompng($fileName);
				imagepng($source, $compressedFileName, $quality);
				imagedestroy($source);
			} elseif ($fileType == 'image/gif') {
				$compressedFileName = $fileName . '_compressed.gif';
				// Tidak ada opsi kompresi untuk format GIF
			} else {
				$compressedFileName = $fileName;
			}

			$this->db->update('penerimaan_item',array('lampiran'=>$compressedFileName),array('id'=>$post['id']));
			// Menghapus file asli
			unlink($fileName);

			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'gudang/penerimaanitemdetail/'.$post['id']);
		}else{
			$this->session->set_flashdata('gagal','Data Gagal disimpan');
			redirect(BASEURL.'gudang/penerimaanitemdetail/'.$post['id']);
		}
	}

	public function penerimaanitemdetail($id){
		$data=array();
		$results=array();
		$products=array();
		$data['results']=$this->GlobalModel->getDataRow('penerimaan_item',array('id'=>$id));
		$data['products']=$this->GlobalModel->getData('penerimaan_item_detail',array('penerimaan_item_id'=>$id));
		$data['action']=BASEURL.'Gudang/penerimaanitemsave_image';
		$data['page']='gudang/penerimaanitem/detail';
		$this->load->view('newtheme/page/main',$data);
	}

	public function penerimaanitemdetail_ubahharga($id){
		$data=array();
		$data['title'] ='Ubah Harga Penerimaan ';
		$data['ubahharga'] =1;
		$results=array();
		$products=array();
		$data['cek']=$this->GlobalModel->getDataRow('request_harga',array('id_penerimaan'=>$id));
		$data['results']=$this->GlobalModel->getDataRow('penerimaan_item',array('id'=>$id));
		$data['products']=$this->GlobalModel->getData('penerimaan_item_detail',array('penerimaan_item_id'=>$id));
		$data['request_harga'] = !empty($data['cek'])?BASEURL.'Gudang/acc_harga':BASEURL.'Gudang/request_harga';
		$data['page']='gudang/penerimaanitem/detail';
		$this->load->view('newtheme/page/main',$data);
	}

	public function request_harga(){
		$post 	= $this->input->post();
		$insert = array(
			'id_penerimaan' => $post['id'],
			'alesan'		=> $post['alesan'],
			'tgl'			=> date('Y-m-d H:i:s'),
			'oleh'			=> callSessUser('nama_user'),
			'status'		=> 0,
		);
		$this->db->insert('request_harga',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'gudang/penerimaanitemdetail_ubahharga/'.$post['id']);
	}

	public function acc_harga(){
		$post 	= $this->input->post();
		//pre($post);
		foreach($post['prods'] as $p ){
			$update = array(
				'harga' => $p['harga'],
			);
			$where = array(
				'id' => $p['id'],
			);
			$this->db->update('penerimaan_item_detail',$update,$where);
		}

		$this->db->update('request_harga',array('status'=>1),array('id'=>$post['idrequest']));
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'gudang/penerimaanitemdetail_ubahharga/'.$post['id']);
	}

	public function penerimaanitem_hapus($id){
		$p=$this->GlobalModel->GetDataRow('penerimaan_item_detail',array('hapus'=>0,'id'=>$id));
		// pre($p);
		$kartustok=array(
				'tanggal'=>date('Y-m-d H:i:s'),
				'idproduct'=>$p['id_persediaan'],
				'nama'=>$p['nama'],
				'saldomasuk_uk'=>$p['ukuran'],
				'saldomasuk_qty'=>$p['jumlah'],
				'harga'=>0,
				'keterangan'=>'Pembatalan Penerimaan item masuk oleh '.callSessUser('nama_user'),
			);
			kartustok($kartustok,2);
		$this->db->query("UPDATE product set ukuran_item =ukuran_item-'".$p['ukuran']."', quantity = quantity-'".$p['jumlah']."' WHERE product_id='".$p['id_persediaan']."' ");
			$this->db->query("UPDATE gudang_persediaan_item set ukuran_item =ukuran_item-'".$p['ukuran']."', jumlah_item = jumlah_item-'".$p['jumlah']."' WHERE id_persediaan='".$p['id_persediaan']."' ");
		$this->db->update('penerimaan_item_detail',array('hapus'=>1),array('id'=>$id));
		user_activity(callSessUser('id_user'),1,' menghapus penerimaan dengan id '.$id);
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect($this->url);
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
		$sql='SELECT gudang_item_keluar.*, p.kode_po as kodepo FROM gudang_item_keluar
		 INNER JOIN produksi_po p ON p.id_produksi_po=gudang_item_keluar.idpo
		 WHERE p.hapus=0 AND gudang_item_keluar.hapus=0 ';
		if(!empty($kode_po)){
			$sql.=" AND idpo='".$kode_po."' ";
		}else{
			$sql.=" AND date(gudang_item_keluar.created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}

		$sql.=" LIMIT 30 ";
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
				'text'=>'Detail / Edit ',
				'href'=>BASEURL.'gudang/itemkeluarDetail/'.$i['idpo'],
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
				'kode_po'=>$i['kodepo'],
				'faktur_no'=>$i['faktur_no'],
				'nama_item_keluar'=>$i['nama_item_keluar'],
				'action'=>$action,
				'edit'=>BASEURL.'Gudang/pengeluaranalatedit/'.$i['idpo'],
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
		$viewData['barang'] = $this->GlobalModel->getData('gudang_item_keluar',array('idpo' => $id));
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po' => $viewData['barang'][0]['idpo']));
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
    	$this->db->update('gudang_item_keluar',$update,array('idpo'=>$data['kode_po']));
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
		$viewData['title']='Pengeluaran alat-alat';
		$viewData['barang'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		$viewData['satuan'] = $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['proggres'] = $this->GlobalModel->getData('proggresion_po',NULL);
		$viewData['page']='gudang/outbound/item_keluar_tambah';
		$viewData['kembali']=BASEURL.'Gudang/Pengeluaranalat';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function itemkeluarSearchId($id='')
	{
		$getId = $this->input->get('id');
		// $data = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$getId));
		$data = $this->GlobalModel->queryManualRow("SELECT product_id as id_persediaan,warna_item,ukuran_item,satuan_ukuran_item,satuan as satuan_jumlah_item,price as harga_item, quantity FROM product where product_id='".$getId."' ");
		echo json_encode($data);
	}

	public function itemSearchPenerimaan($id='')
	{
		$getId = $this->input->get('id');
		// $data = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$getId));
		$data = $this->GlobalModel->queryManualRow("SELECT product_id as id_persediaan,warna_item,ukuran_item,satuan_ukuran_item,satuan as satuan_jumlah_item,harga_beli as harga_item, quantity FROM product where product_id='".$getId."' ");
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
		$viewData['title']='Surat Jalan Alat Keluar';
		$viewData['update']=BASEURL.'Gudang/editalat_save';
		$viewData['lampiran']=BASEURL.'Gudang/lampiran_save';
		$viewData['l']=[];
		$viewData['l'] = $this->GlobalModel->getDataRow('lampiran_alat',array('kode_po' => $id));
		// $viewData['barang'] = $this->GlobalModel->getData('gudang_item_keluar',array('hapus'=>0,'idpo' => $id));
		$viewData['barang'] = $this->GlobalModel->QueryManual(
			"
			SELECT a.*, p.harga_skb FROM gudang_item_keluar a LEFT JOIN product p on p.product_id=a.id_persediaan

			WHERE a.idpo='".$id."' AND a.hapus=0
			"
		);
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po' => $id));
		$viewData['excel']=BASEURL.'Gudang/itemkeluarDetail/'.$id.'?&excel=true';
		// $viewData['cetak']=BASEURL.'Gudang/itemkeluarDetail/'.$id.'?&cetak=true&pdf=true';
		$viewData['cetak']=BASEURL.'Gudang/itemkeluarDetail/'.$id.'?&pdf=true';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view('gudang/outbound/item-keluar-detail_excel',$viewData);
		}else if(isset($get['cetak'])){
			$viewData['page']='gudang/outbound/item-keluar-detail-cetak';
			$this->load->view('newtheme/page/main',$viewData);	
		}else if(isset($get['pdf'])){
			
			$html =  $this->load->view('gudang/outbound/item-keluar-detail-cetak-pdf',$viewData,true);
			$this->load->library('pdfgenerator');
	        $file_pdf = isset($data['title']) ? $data['title'] : $viewData['title'];
	        $paper = 'A4';
	        $orientation = "potrait";	        
			$headerContent = $this->load->view('newtheme/page/pdf/header', isset($data) ? $data : $viewData, true);
			$footerContent =null;
			$htmlWithHeaderFooter = $headerContent . $html . $footerContent;
			generate_pdf($this, $htmlWithHeaderFooter, isset($data) ? $data : $viewData, $file_pdf, $paper , $orientation);
		}else{
			$viewData['page']='gudang/outbound/item-keluar-detail';
			$this->load->view('newtheme/page/main',$viewData);	
		}
	}

	public function lampiran_save(){
		$data=$this->input->post();
		$config['upload_path']          = './assets/lampiran/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $this->load->library('upload', $config);
		
		if(!empty($_FILES['lampiran']['name'])){
	        $this->upload->do_upload('lampiran');
	        $imageGambar = $this->upload->data('file_name');
	        $up=array(
	        	'tglkirim'=>$data['tglkirim'],
	        	'kode_po'=>$data['kode_po'],
	        	'foto'=>$imageGambar,
	        );
	        $this->db->insert('lampiran_alat',$up);
		}

		$this->session->set_flashdata('msg','Data berhasil di edit');
		redirect(BASEURL.'Gudang/itemkeluarDetail/'.$data['kode_po']);
	}

	public function editalat_save(){
		$data=$this->input->post();
		//pre($data);
		foreach($data['prods'] as $p){
			$update=array(
				'created_date'=>$data['tanggal'],
				'jumlah_item_keluar'=>$p['jumlah_item_keluar'],
				'harga_item' => $p['harga_item'],
				'jumlah_item_perlusin'=>$p['jumlah_item_perlusin'],
			);
			$where=array(
				'id_item_keluar' => $p['id_item_keluar'],
			);
			$this->db->update('gudang_item_keluar',$update,$where);
		}
		$this->session->set_flashdata('msg','Data berhasil di edit');
		redirect(BASEURL.'Gudang/pengeluaranalat');
	}

	public function itemkeluarOnCreate()
	{
		$post = $this->input->post();
		// pre($post);
		$ex = explode("-",$post['namaPo']);
		$dataInput = $this->GlobalModel->getDataRow('gudang_item_keluar',array('idpo' => $ex[0]));
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
						'id_persediaan'			=>  $post['id_persediaan'][$key],
						'nama_item_keluar' 		=>	$nama,
						'kode_po'				=>	null,
						'idpo'					=>  $ex[0],
						'warna_item_keluar' 	=>	$post['warna'][$key],
						'ukuran_item_keluar' 	=>	$post['ukuran'][$key],
						'satuan_item_keluar' 	=>	$post['satuanUkran'][$key],
						'jumlah_item_keluar' 	=>	$post['jumlah'][$key],
						'satuan_jumlah_keluar' 	=>	$post['satuanJml'][$key],
						'created_date' 			=>	isset($post['tanggal'])?$post['tanggal']:date('Y-m-d'),
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
				'kode_po'		=> $ex[0],
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
		//$this->GlobalModel->deleteData('gudang_item_keluar',array('id_item_keluar'=>$id));
		$data = $this->GlobalModel->getDataRow('gudang_item_keluar',array('id_item_keluar'=>$id));
		$kartustok=array(
			'tanggal'=>date('Y-m-d'),
			'idproduct'=>$data['id_persediaan'],
			'nama'=>$data['nama'],
			'saldomasuk_uk'=>0,
			'saldomasuk_qty'=>$data['jumlah_item_keluar'],
			'harga'=>$data['harga'],
			'keterangan'=>'Pembatalan alat keluar PO '.$data['kode_po'],
		);
		kartustok($kartustok,1);
		//pre($data);
		$update = array(
			'hapus' =>1
		);
		$where = array(
			'id_item_keluar' => $id
		);
		$this->db->update('gudang_item_keluar',$update,$where);
		$this->db->query("UPDATE gudang_persediaan_item SET jumlah_item=jumlah_item+'".$data['jumlah_item_keluar']."' WHERE id_persediaan='".$data['id_persediaan']."' ");
		$this->db->query("UPDATE product SET quantity=quantity+'".$data['jumlah_item_keluar']."' WHERE product_id='".$data['id_persediaan']."' ");
		$this->session->set_flashdata('msg','Data berhasil di delete');
		redirect(BASEURL.'gudang/itemkeluar');
	}


	public function persediaanstok()
	{
		$url='';
		$get=$this->input->get();
		if(isset($get['product_id'])){
			$product_id=$get['product_id'];
			$url.="&product_id=".$product_id;
		}else{
			$product_id=null;			
		}
		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
			$url.="&jenis=".$jenis;
			//$viewData['persediaan'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0,'jenis'=>$jenis));
		}else{
			$jenis=null;
			//$viewData['persediaan'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
			$url.="&kategori=".$kategori;
			//$viewData['persediaan'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0,'jenis'=>$jenis));
		}else{
			$kategori=null;
			//$viewData['persediaan'] = $this->GlobalModel->getData('gudang_persediaan_item',array('hapus'=>0));
		}

		$viewData['title']='Persediaan Stok';
		$sql="SELECT gpi.* FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) WHERE gpi.hapus=0 ";
		if(!empty($jenis)){
			$sql.=" AND p.jenis='".$jenis."'";
		}
		if(!empty($kategori)){
			$sql.=" AND p.kategori='".$kategori."'";
		}
		$viewData['persediaan']=$this->GlobalModel->queryManual($sql);
		$viewData['excel']=BASEURL.'Gudang/persediaanstok?&excel=true'.$url;
		if(isset($get['excel'])){
			$this->load->view('gudang/persediaan/persediaan-excel',$viewData);
		}else{
			$viewData['page']='gudang/persediaan/persediaan-view';
			$this->load->view('newtheme/page/main',$viewData);
		}
	}

	function nolin($id){
		$update = array(
			'ukuran_item' =>0,
			'quantity'    =>0,
		);
		$post = $this->GlobalModel->getDataRow('product',array('product_id'=>$id));
		$kartustok=array(
			'tanggal'=>date('Y-m-d'),
			'idproduct'=>$id,
			'nama'=>$post['nama'],
			'saldomasuk_uk'=>0,
			'saldomasuk_qty'=>0,
			'harga'=>0,
			'keterangan'=>'Nolin Produk oleh '.callSessUser('nama_user'),
		);
		kartustok($kartustok,2);
		$this->db->update('product',$update,array('product_id'=>$id));
		$this->db->update('gudang_persediaan_item',array('ukuran_item'=>0,'jumlah_item'=>0),array('id_persediaan'=>$id));
		redirect(BASEURL.'/Gudang/persediaanstok');
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
			$sql.=" AND idpo='".$kode_po."'";
		}else{
			$sql.=" AND date(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."'  ";
		}
		$sql.=" ORDER BY id_item_keluar DESC ";
		$sql.=" LIMIT 30 ";
		$item=$this->GlobalModel->queryManual($sql);
		$user=user();
		$hapus=0;
		$viewData['item']=array();
		if(isset($user['id_user'])){
			$hapus=akses($user['id_user'],2);
		}
		foreach($item as $i){
			$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$i['idpo']));
			$action=array();
			$action[]=array(
				'text'=>'Detail / Edit',
				'href'=>BASEURL.'gudang/outbahanDetail/'.$i['idpo'],
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
				'kode_po'=>$po['kode_po'],
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
					//$this->GlobalModel->updateData('gudang_persediaan_item',array('id_persediaan'=>$post['id'][$key]),$dataInsertPersediaan);
					$idpo=$this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$post['namaPo']));
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
						'bahan_kategori'		=>  $post['bahanUntuk'][$key],
						'idpo'					=> $idpo['id_produksi_po'],
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
					//kartustok($kartustok,2);
					//$this->db->query(" UPDATE product set ukuran_item=ukuran_item-".$post['ukuran'][$key].", quantity=quantity-".$post['jumlah'][$key]." WHERE product_id=".$post['id'][$key]." ");
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
		$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$id));
		$eid=$this->GlobalModel->getDataRow('gudang_bahan_keluar',array('idpo' => $po['id_produksi_po'],'hapus'=>0));
		$id=$eid['faktur_no'];
		$viewData['barang'] = $this->GlobalModel->getData('gudang_bahan_keluar',array('idpo' => $po['id_produksi_po'],'hapus'=>0));
		$viewData['project'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po' => $viewData['barang'][0]['kode_po']));
		$viewData['title']='Detail ';
		$viewData['page']='gudang/outbahan/item-keluar-detail';
		$viewData['update']=BASEURL.'Gudang/simpaneditbahankeluar';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function simpaneditbahankeluar(){
		$data=$this->input->post();
		//pre($data);
		foreach($data['prods'] as $p){
			$update=array(
				'harga_item' => $p['harga_item'],
				'bahan_kategori' => $p['bahan_kategori'],
				'jumlah_item_keluar'=>$p['jumlah_item_keluar'],
			);
			$where=array(
				'id_item_keluar' => $p['id_item_keluar'],
			);
			$this->db->update('gudang_bahan_keluar',$update,$where);
		}
		$this->session->set_flashdata('msg','Data berhasil di edit');
		redirect(BASEURL.'Gudang/pengeluaranbahan?&kode_po='.$data['kode_po']);
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

	function ajuanmingguanacc(){
		$post = $this->input->post();
		//pre($post);
		$update =array(
				'jml_acc'=>$post['jml_acc']
		);
		$where = array('id'=>$post['id']);
		$this->db->update('ajuan_mingguan',$update,$where);
		$this->session->set_flashdata('msg','Data berhasil di acc');
		redirect(BASEURL.'Gudang/ajuanmingguan?&spv=true');
	}

	function ajuanmingguanacckemeja(){
		$post = $this->input->post();
		//pre($post);
		$update =array(
				'jml_acc'=>$post['jml_acc']
		);
		$where = array('id'=>$post['id']);
		$this->db->update('ajuan_mingguan_kemeja',$update,$where);
		$this->session->set_flashdata('msg','Data berhasil di acc');
		redirect(BASEURL.'Gudang/ajuanmingguankemeja?&spv=true');
	}

	function getjsonajuanmingguan(){
		$post = $this->input->post('data_id');
		$data = $this->GlobalModel->getDataRow('ajuan_mingguan',array('id'=>$post));
		$html='';

		$html.='<form method="POST" action="'.BASEURL.'Gudang/ajuanmingguanacc">';
		$html.='<input type="hidden" name="id" value="'.$post.'">';
		$html.='<p>Nama Ajuan : '.$data['kebutuhan'].'</p>';
		$html.='<p>Jumlah Ajuan : '.$data['jml_ajuan'].'</p>';
		$html.='<p>Acc Ajuan : <input type="text" name="jml_acc" class="form-control" value="'.$data['jml_acc'].'"></p>';
		$html.='<br>';
		$html.='<button class="btn btn-success btn-sm full">Acc</button>';
		$html.='</form>';
		echo $html;
	}

	function getjsonajuanmingguankemeja(){
		$post = $this->input->post('data_id');
		$data = $this->GlobalModel->getDataRow('ajuan_mingguan',array('id'=>$post));
		$html='';

		$html.='<form method="POST" action="'.BASEURL.'Gudang/ajuanmingguanacckemeja">';
		$html.='<input type="hidden" name="id" value="'.$post.'">';
		$html.='<p>Nama Ajuan : '.$data['kebutuhan'].'</p>';
		$html.='<p>Jumlah Ajuan : '.$data['jml_ajuan'].'</p>';
		$html.='<p>Acc Ajuan : <input type="text" name="jml_acc" class="form-control" value="'.$data['jml_acc'].'"></p>';
		$html.='<br>';
		$html.='<button class="btn btn-success btn-sm full">Acc</button>';
		$html.='</form>';
		echo $html;
	}

	function acc_ajuan_mingguan(){
		$post = $this->input->post();
		//pre($post);
		$update = array(
			'jml_acc' => $post['jml_acc'],
		);
		$where = array(
			'id' => $post['id'],
		);
		$this->db->update('ajuan_mingguan',$update,$where);
		$cat=3; // kategori untuk ajuan harian bagian konveksi
		$cekajuan_harian = $this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE kategori='".$cat."' AND from_alat IS NOT NULL AND DATE(tanggal)='".$post['tanggal']."' AND hapus=0 ");
		//pre($cekajuan_harian);
		//pre();
		if(empty($cekajuan_harian)){
			$ip=array(
				'kategori'=>$cat,
				'cash'=>0,
				'transfer'=>0,
				'status'=>1,
				'hapus'=>0,
				'tanggal'=>date('Y-m-d'),
				'keterangan'=>'',
				'dibuat'=>date('Y-m-d H:i:s'),
				'from_alat' => TRUE
			);
			$this->db->insert('pengajuan_harian_new',$ip);
			$id=$this->db->insert_id();
			$transfer=0;
			$p=$this->GlobalModel->GetDataRow('ajuan_mingguan',array('id'=>$post['id']));
			$item=$this->GlobalModel->GetDataRow('product',array('product_id'=>$p['product_id']));
			$supplier=$this->GlobalModel->GetDataRow('master_supplier',array('id'=>$p['supplier_id']));
			$transfer=($item['harga_beli']*$p['jml_acc']);
			$rip=array(
					'idpengajuan'=>$id,
					'nama_item'=>$item['nama'],
					'jumlah'=>$p['jml_acc'],
					'satuan'=>$item['satuan'],
					'harga'=>$item['harga_beli'],
					'pembayaran'=>2, // transfer
					'supplier'=>$supplier['nama'],
					'keterangan'=>$p['keterangan'],
					'status'=>1,
					'from_alat' => $p['id']
			);
			$this->db->insert('pengajuan_harian_new_detail',$rip);
			$this->db->update('pengajuan_harian_new',array('cash'=>0,'transfer'=>$transfer),array('id'=>$id));
		}else{
			$id=$cekajuan_harian['id'];
			
			$transfer=0;
			$p=$this->GlobalModel->GetDataRow('ajuan_mingguan',array('id'=>$post['id']));
			$item=$this->GlobalModel->GetDataRow('product',array('product_id'=>$p['product_id']));
			$supplier=$this->GlobalModel->GetDataRow('master_supplier',array('id'=>$p['supplier_id']));
			$transfer=($item['harga_beli']*$p['jml_acc']);
			$rip=array(
					'idpengajuan'=>$id,
					'nama_item'=>$item['nama'],
					'jumlah'=>$p['jml_acc'],
					'satuan'=>$item['satuan'],
					'harga'=>$item['harga_beli'],
					'pembayaran'=>2, // transfer
					'supplier'=>$supplier['nama'],
					'keterangan'=>$p['keterangan'],
					'status'=>1,
					'from_alat' => $p['id']
			);
			$this->db->insert('pengajuan_harian_new_detail',$rip);
			
			$this->db->query("UPDATE pengajuan_harian_new SET transfer=transfer+'".$transfer."' WHERE id='".$id."' ");
		}
		$this->session->set_flashdata('msg','Data berhasil di acc');
		redirect(BASEURL.'Gudang/ajuanmingguan?&spv=true');
	}

	function acc_ajuan_mingguan_all(){
		$post = $this->input->post();
		// pre($post);
		foreach($post['prods'] as $pr){
			$update = array(
				'jml_acc' => $pr['jml_acc'],
				'acc_satuan'=> $pr['acc_satuan'],
			);
			$where = array(
				'id' => $pr['id'],
			);
			$this->db->update('ajuan_mingguan',$update,$where);
		}
		$cat=3; // kategori untuk ajuan harian bagian konveksi
		// $cekajuan_harian = $this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE kategori='".$cat."' AND from_alat IS NOT NULL AND DATE(tanggal)='".$post['tanggal']."' AND hapus=0 ");
		$cekajuan_harian = null;
		//pre($cekajuan_harian);
		//pre();
		if(empty($cekajuan_harian)){
			$ip=array(
				'kategori'=>$cat,
				'cash'=>0,
				'transfer'=>0,
				'status'=>1,
				'hapus'=>0,
				'tanggal'=>date('Y-m-d'),
				'keterangan'=>'',
				'dibuat'=>date('Y-m-d H:i:s'),
				'from_alat' => TRUE
			);
			$this->db->insert('pengajuan_harian_new',$ip);
			$id=$this->db->insert_id();
			$transfer=0;
			$cash=0;
			foreach($post['prods'] as $pr){
				$p=$this->GlobalModel->GetDataRow('ajuan_mingguan',array('id'=>$pr['id']));
				$item=$this->GlobalModel->GetDataRow('product',array('product_id'=>$p['product_id']));
				$supplier=$this->GlobalModel->GetDataRow('master_supplier',array('id'=>$p['supplier_id']));
				if(isset($pr['metodebayar'])){

					if($pr['metodebayar']=='Transfer'){
						$transfer+=($item['harga_beli']*$pr['jml_acc']);
						// $cash=0;
					}else{
						// $transfer=0;
						$cash+=($item['harga_beli']*$pr['jml_acc']);
					}
				}
				$rip=array(
						'idpengajuan'=>$id,
						'nama_item'=>$item['nama'],
						'jumlah'=>$pr['jml_acc'],
						'satuan'=>$item['satuan'],
						'harga'=>$item['harga_beli'],
						'pembayaran'=> ($pr['metodebayar']=='Cash') ? 1 : 2, // 1 Cash, 2 Transfer
						'supplier'=>$supplier['nama'],
						'keterangan'=>$p['keterangan2'],
						'status'=>1,
						'from_alat' => $p['id']
				);
				$this->db->insert('pengajuan_harian_new_detail',$rip);
			}
			$this->db->update('pengajuan_harian_new',array('cash'=>$cash,'transfer'=>$transfer),array('id'=>$id));
			$image_data = $this->input->post('image_data');
			// pre($post);
			// Mengonversi data base64 menjadi file gambar
			$image_data = base64_decode($image_data);
			$file_name = uniqid() . '.png';
			$file_path = FCPATH . 'uploads/signatures/' . $file_name;

			if (file_put_contents($file_path, $image_data)) {
				$update = array(
					'paraf' => $file_name,
					'tanggal_setujui' => date('Y-m-d H:i:s'),
				);
				$where = array(
					'id' => $id,
				);
				$this->db->update('pengajuan_harian_new',$update,$where);
				
			} else {
				echo 'Failed to save signature.';
			}
		}else{
			// $id=$cekajuan_harian['id'];
			
			// $transfer=0;
			// foreach($post['prods'] as $pr){
			// 	$p=$this->GlobalModel->GetDataRow('ajuan_mingguan',array('id'=>$pr['id']));
			// 	$item=$this->GlobalModel->GetDataRow('product',array('product_id'=>$p['product_id']));
			// 	$supplier=$this->GlobalModel->GetDataRow('master_supplier',array('id'=>$p['supplier_id']));
			// 	$transfer=($item['harga_beli']*$p['jml_acc']);
			// 	$rip=array(
			// 			'nama_item'=>$item['nama'],
			// 			'jumlah'=>$p['jml_acc'],
			// 			'satuan'=>$item['satuan'],
			// 			'harga'=>$item['harga_beli'],
			// 			'pembayaran'=>2, // transfer
			// 			'supplier'=>$supplier['nama'],
			// 			'keterangan'=>$p['keterangan'],
			// 			'status'=>1,
			// 			'from_alat' => $p['id']
			// 	);
			// 	$wu = array(
			// 		'from_alat' => $p['id']
			// 	);
			// 	$this->db->update('pengajuan_harian_new_detail',$rip, $wu);
			// }

			// //pre($id);
			
			
			// $this->db->query("UPDATE pengajuan_harian_new SET transfer=transfer+'".$transfer."' WHERE id='".$id."' ");

			$this->session->set_flashdata('gagal','Data gagal di tersimpan ke ajuan harian.');
			redirect(BASEURL.'Gudang/ajuanmingguan?&spv=true');
		}
		// $this->session->set_flashdata('msg','Data berhasil di acc');
		// redirect(BASEURL.'Gudang/ajuanmingguan?&spv=true');
		// redirect(BASEURL.'Gudang/pengajuancetak/'.$id);
		echo $id;
	}

	function acc_ajuan_mingguan_allkemeja(){
		$post = $this->input->post();
		//pre($post);
		foreach($post['prods'] as $pr){
			$update = array(
				'jml_acc' => $pr['jml_acc'],
				'acc_satuan'=> $pr['acc_satuan'],
			);
			$where = array(
				'id' => $pr['id'],
			);
			$this->db->update('ajuan_mingguan_kemeja',$update,$where);
		}
		$cat=3; // kategori untuk ajuan harian bagian konveksi
		$cekajuan_harian = $this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE kategori='".$cat."' AND from_alat IS NOT NULL AND DATE(tanggal)='".$post['tanggal']."' AND hapus=0 ");
		//pre($cekajuan_harian);
		//pre();
		if(empty($cekajuan_harian)){
			$ip=array(
				'kategori'=>$cat,
				'cash'=>0,
				'transfer'=>0,
				'status'=>1,
				'hapus'=>0,
				'tanggal'=>date('Y-m-d'),
				'keterangan'=>'',
				'dibuat'=>date('Y-m-d H:i:s'),
				'from_alat' => TRUE
			);
			$this->db->insert('pengajuan_harian_new',$ip);
			$id=$this->db->insert_id();
			$transfer=0;
			foreach($post['prods'] as $pr){
				$p=$this->GlobalModel->GetDataRow('ajuan_mingguan_kemeja',array('id'=>$pr['id']));
				$item=$this->GlobalModel->GetDataRow('product',array('product_id'=>$p['product_id']));
				$supplier=$this->GlobalModel->GetDataRow('master_supplier',array('id'=>$p['supplier_id']));
				$transfer+=($item['harga_beli']*$pr['jml_acc']);
				$rip=array(
						'idpengajuan'=>$id,
						'nama_item'=>$item['nama'],
						'jumlah'=>$pr['jml_acc'],
						'satuan'=>$item['satuan'],
						'harga'=>$item['harga_beli'],
						'pembayaran'=>2, // transfer
						'supplier'=>$supplier['nama'],
						'keterangan'=>$p['keterangan'],
						'status'=>1,
						'from_alat' => $p['id']
				);
				$this->db->insert('pengajuan_harian_new_detail',$rip);
			}
			$this->db->update('pengajuan_harian_new',array('cash'=>0,'transfer'=>$transfer),array('id'=>$id));
		}else{
			$id=$cekajuan_harian['id'];
			
			$transfer=0;
			foreach($post['prods'] as $pr){
				$p=$this->GlobalModel->GetDataRow('ajuan_mingguan_kemeja',array('id'=>$pr['id']));
				$item=$this->GlobalModel->GetDataRow('product',array('product_id'=>$p['product_id']));
				$supplier=$this->GlobalModel->GetDataRow('master_supplier',array('id'=>$p['supplier_id']));
				$transfer=($item['harga_beli']*$p['jml_acc']);
				$rip=array(
						'nama_item'=>$item['nama'],
						'jumlah'=>$p['jml_acc'],
						'satuan'=>$item['satuan'],
						'harga'=>$item['harga_beli'],
						'pembayaran'=>2, // transfer
						'supplier'=>$supplier['nama'],
						'keterangan'=>$p['keterangan'],
						'status'=>1,
						'from_alat' => $p['id']
				);
				$wu = array(
					'from_alat' => $p['id']
				);
				$this->db->update('pengajuan_harian_new_detail',$rip, $wu);
			}

			//pre($id);
			
			
			$this->db->query("UPDATE pengajuan_harian_new SET transfer=transfer+'".$transfer."' WHERE id='".$id."' ");
		}
		$this->session->set_flashdata('msg','Data berhasil di acc');
		redirect(BASEURL.'Gudang/ajuanmingguan_kemeja?&spv=true');
	}

	function acc_ajuan_mingguan_batal(){
		$post = $this->input->post();
		//pre($post);
		$insert = array(
			'tanggal'	=> $post['tanggal']
		);
		$this->db->delete('acc_ajuan_mingguan',$insert);
		$this->session->set_flashdata('msg','Data berhasil di acc');
		redirect(BASEURL.'Gudang/ajuanmingguan?&spv=true');
	}

	public function ajuanmingguan_celana(){
		$data=array();
		$data['title']='Ajuan Alat-alat Kirim PO Kaos ';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
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

		if(isset($get['spv'])){
			$cek=$this->GlobalModel->QueryManualRow("SELECT * FROM ajuan_mingguan WHERE hapus=0 AND typeajuan='celana' ORDER BY id DESC LIMIT 1 ");
			$tanggal1 =date('Y-m-d',strtotime($cek['tanggal']));
			$tanggal2 =date('Y-m-d',strtotime($cek['tanggal']));
			if(isset($get['tanggal1'])){
				$tanggal1=$get['tanggal1'];
			}else{
				//$tanggal1=date('Y-m-d',strtotime("Monday of this week"));
			}
			if(isset($get['tanggal2'])){
				$tanggal2=$get['tanggal2'];
			}else{
				//$tanggal2=date('Y-m-d');
			}
		}
		$data['accAjuan']=BASEURL.'Gudang/ajuanmingguanacc';
		//pre($data['acc_ajuan_mingguan']);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		$data['products']=array();
		$data['n']=1;
		$sql="SELECT * FROM ajuan_mingguan WHERE hapus=0 AND typeajuan='celana' ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		if(!empty($cat)){
			$sql.=" AND jenis='".$cat."' ";
		}
		$sql.=" ORDER BY id DESC ";
		
		$results=$this->GlobalModel->queryManual($sql);
		foreach($results as $result){
			$satuan = $this->GlobalModel->GetDataRow('product',array('hapus'=>0,'nama'=>$result['kebutuhan']));
			$data['products'][]=array(
				'id'=>$result['id'],
				'tanggal'=>$result['tanggal'],
				'kebutuhan'=>''.$result['kebutuhan'],
				'satuan' => !empty($satuan) ? $satuan['satuan'] : '',
				'jml_ajuan'=>$result['jml_ajuan'],
				'jml_acc'=>$result['jml_acc'],
				'keterangan'=>$result['keterangan'],
				'keterangan2'=>$result['keterangan2'],
				'edit'=>BASEURL.'Gudang/ajuanmingguanedit/'.$result['id'],
				'detail'=>BASEURL.'Gudang/ajuanmingguandetail/'.$result['id'],
				'batal'=>BASEURL.'Gudang/ajuanmingguandetailbatal/'.$result['id'],
				'bataladmin'=>BASEURL.'Gudang/ajuanmingguandetailbataladmin/'.$result['id'],
				'excel'=>BASEURL.'Gudang/ajuanmingguandetail/'.$result['id'].'?&excel=1',
				'stok'=>$result['stok'],
				'acc_satuan' => $result['acc_satuan'],
				'accsatuan'	 => $satuan['accsatuan'],
				'metodebayar'	=> $result['metodebayar'],
			);
		}
		$data['tambah']=BASEURL.'Gudang/ajuanmingguantambah_celana';
		if(isset($get['spv'])){
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_spv';
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list';
		}
		//pre($data['products']);
		$data['urlexcel']=BASEURL.'Gudang/ajuanmingguan_excel_all';
		$data['acc_ajuan_mingguan']=$this->GlobalModel->QueryManualRow("SELECT tanggal FROM acc_ajuan_mingguan WHERE DATE(tanggal)='".$tanggal1."' ORDER BY tanggal DESC LIMIT 1");
		$data['tgl_diacc']	= !empty($data['acc_ajuan_mingguan']) ? $data['acc_ajuan_mingguan']['tanggal']:null;
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguantambah_celana(){
		$data=array();
		$data['title']='Form Ajuan Alat-alat Kirim PO Celana';
		$data['typeajuan']	='alat-alat';
		$data['action']=BASEURL.'Gudang/ajuanmingguansave_celana';
		$data['cancel']=BASEURL.'Gudang/ajuanmingguan_celana';
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['supplier'] = $this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$data['page']=$this->page.'gudang/pengajuan/mingguan_form';
		$this->load->view($this->page.'main',$data);
	}

	public function ajuanmingguansave_celana(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$item = $this->GlobalModel->GetDataRow('product',array('product_id'=>$data['kebutuhan']));
			$am=array(
				'tanggal'=>$data['tanggal'],
				'jenis'=>$data['jenis'], // 1 konveksi, 2 bordir, 3 sablon
				'kebutuhan'=>$item['nama'],
				'product_id' => $item['product_id'],
				// 'ajuan_kebutuhan'=>$data['ajuan_kebutuhan'],
				'ajuan_kebutuhan'=>0,
				'stok'=>$data['stok'],
				//'jml_ajuan'=>$data['jml_ajuan'],
				'jml_ajuan'=>0,
				'keterangan'=>'kebutuhan '.$data['kebutuhan'],
				'keterangan2'=>$data['keterangan2'],
				'supplier_id'=>$data['supplier_id'],
				'metodebayar'=>isset($data['metodebayar']) ? $data['metodebayar'] : null,
				'typeajuan' => 'celana',
				//'keterangan'=>$data['keterangan'],
			);
			$this->db->insert('ajuan_mingguan',$am);
			$id=$this->db->insert_id();
			$totalajuan=0;
			foreach($data['products'] as $p){
				$totalajuan+=($p['jumlah_po']*$p['jml_pcs']);
				$insert=array(
					'idajuan'=>$id,
					'tanggal'=>$data['tanggal'],
					'tanggal2'=>$data['tanggal'],
					'kode_po'=>$p['kode_po'],
					'jumlah_po'=>$p['jumlah_po'],
					'rincian_po'=>$p['rincian_po'],
					// 'jml_pcs'=>str_replace(",", ".", $p['jml_pcs']),
					// 'jml_dz'=>str_replace(",", ".", $p['jml_dz']),
					'jml_pcs'=>$p['jml_pcs'],
					'jml_dz'=>$p['jml_dz'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('ajuan_mingguan_detail',$insert);
			}
			$this->db->update('ajuan_mingguan',array('ajuan_kebutuhan'=>$totalajuan,'jml_ajuan'=>$totalajuan-$data['stok']),array('id'=>$id));
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/ajuanmingguan_celana');
	}

	function getRealisasiDetail(){
		$id = $this->input->get('id');
		$ajuan = $this->GlobalModel->GetDataRow('pengajuan_harian_new',array('hapus'=>0,'id'=>$id));
		echo '
			<div class="row">

			<div class="col-lg-6 col-xs-6">
				<div class="small-box bg-aqua">
				<div class="inner">
				<h3>Rp. '.number_format($ajuan['cash']).'</h3>
				<p>Cash</p>
				</div>
				<div class="icon">
				<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>


			<div class="col-lg-6 col-xs-6">
				<div class="small-box bg-yellow">
				<div class="inner">
				<h3>Rp. '.number_format($ajuan['transfer']).'</h3>
				<p>Transfer</p>
				</div>
				<div class="icon">
				<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			
			
			</div>
		';
		echo '<hr>';
		echo '<form method="POST" action="'.BASEURL.'Gudang/realisasi_save">';
		echo '<div claass="card-header">
			<h2>
				Detail Realisasi Penerimaan 
			</h2>
		</div>';
		echo '<input type="hidden" name="id" value="'.$id.'">	';
		echo '<div class="row">';
		echo '<div class="col-md-4">';
		echo 'Cash : <br>';
		echo '<input type="number" class="form-control" name="diterima_cash" value="'.$ajuan['diterima_cash'].'" readonly>';
		echo '</div>';
		echo '<div class="col-md-4">';
		echo 'Transfer : <br>';
		echo '<input type="number" class="form-control" name="diterima_tf" value="'.$ajuan['diterima_tf'].'"  required>';
		echo '</div>';
		echo '<div class="col-md-4">';
		echo 'Sisa Cash : <br>';
		echo '<input type="number" class="form-control" name="sisa_cash" value="'.$ajuan['sisa_cash'].'"  required>';
		echo '</div><br><br>';
		// echo '
		// 		<div class="row">
		// 			<div class="col-md-12">
		// 				<div class="signatuers"></div>
		// 			</div>
		// 			<div class="col-md-12">
		// 				<button type="button" id="clear_signature">Clear</button>
		// 				<button type="button id="save_signature">Save Signature</button>
		// 			</div>
		// 		</div>
		// ';
		echo '<div class="row">
		<div class="col-md-4">		
		<div class="col-md-4"><br><br>
				<div class="form-group"><button class="btn btn-success btn-lg" type="submit">Simpan</button></div>
				</div>
		</div>';
		echo '</div>';
		echo '</form>';
	}

	function getRealisasiDetailmanajer(){
		$id = $this->input->get('id');
		$ajuan = $this->GlobalModel->GetDataRow('pengajuan_harian_new',array('hapus'=>0,'id'=>$id));
		echo '
			<div class="row">

			<div class="col-lg-6 col-xs-6">
				<div class="small-box bg-aqua">
				<div class="inner">
				<h3>Rp. '.number_format($ajuan['cash']).'</h3>
				<p>Cash</p>
				</div>
				<div class="icon">
				<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>


			<div class="col-lg-6 col-xs-6">
				<div class="small-box bg-yellow">
				<div class="inner">
				<h3>Rp. '.number_format($ajuan['transfer']).'</h3>
				<p>Transfer</p>
				</div>
				<div class="icon">
				<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			
			
			</div>
		';
		echo '<hr>';
		echo '<form method="POST" action="'.BASEURL.'Gudang/realisasi_save">';
		echo '<div claass="card-header">
			<h2>
				Detail Realisasi Penerimaan 
			</h2>
		</div>';
		echo '<input type="hidden" name="id" value="'.$id.'">	';
		echo '<div class="row">';
		echo '<div class="col-md-4">';
		echo 'Cash : <br>';
		echo '<input type="number" class="form-control" name="diterima_cash" value="'.$ajuan['diterima_cash'].'" required>';
		echo '</div>';
		echo '<div class="col-md-4">';
		echo 'Transfer : <br>';
		echo '<input type="number" class="form-control" name="diterima_tf" value="'.$ajuan['diterima_tf'].'"  readonly>';
		echo '</div>';
		echo '<div class="col-md-4">';
		echo 'Sisa Cash : <br>';
		echo '<input type="number" class="form-control" name="sisa_cash" value="'.$ajuan['sisa_cash'].'"  readonly>';
		echo '</div><br><br>';
		// echo '
		// 		<div class="row">
		// 			<div class="col-md-12">
		// 				<div class="signatuers"></div>
		// 			</div>
		// 			<div class="col-md-12">
		// 				<button type="button" id="clear_signature">Clear</button>
		// 				<button type="button id="save_signature">Save Signature</button>
		// 			</div>
		// 		</div>
		// ';
		echo '<div class="row">
		<div class="col-md-4">		
		<div class="col-md-4"><br><br>
				<div class="form-group"><button class="btn btn-success btn-lg" type="submit">Simpan</button></div>
				</div>
		</div>';
		echo '</div>';
		echo '</form>';
	}

	function realisasi_save(){
		$post = $this->input->post();
		$update = array(
			'diterima_cash' => $post['diterima_cash'],
			'diterima_tf' => $post['diterima_tf'],
			'sisa_cash' => $post['sisa_cash'],
		);
		$where = array(
			'id'=> $post['id']
		);
		$this->db->update('pengajuan_harian_new',$update,$where);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gudang/pengajuan');
	}


	function getRealisasiDetailTtd(){
		$id = $this->input->get('id');
		$ajuan = $this->GlobalModel->GetDataRow('pengajuan_harian_new',array('hapus'=>0,'id'=>$id));
		echo '
			<div class="row">

			<div class="col-lg-6 col-xs-6">
				<div class="small-box bg-aqua">
				<div class="inner">
				<h3>Rp. '.number_format($ajuan['cash']).'</h3>
				<p>Cash</p>
				</div>
				<div class="icon">
				<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>


			<div class="col-lg-6 col-xs-6">
				<div class="small-box bg-yellow">
				<div class="inner">
				<h3>Rp. '.number_format($ajuan['transfer']).'</h3>
				<p>Transfer</p>
				</div>
				<div class="icon">
				<i class="ion ion-bag"></i>
				</div>
				<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			
			
			</div>
		';
		echo '<hr>';
		// echo '<form method="POST" action="'.BASEURL.'Gudang/realisasi_save">';
		echo '<input type="hidden" name="idajuan" id="idajuan" value="'.$ajuan['id'].'">';
		echo '<div claass="card-header">
			 <div id="signature"></div>
		</div>';
		
		echo '</div><br><br>';
		// echo '<div class="row">
		// <div class="col-md-4">		
		// <div class="col-md-4"><br><br>
		// 		<div class="form-group"><button class="btn btn-success btn-lg" type="submit">Simpan</button></div>
		// 		</div>
		// </div>';
		// echo '</div>';
		// echo '</form>';
	}

	function ttdsaveBuhj(){
		$post = $this->input->post();
        $image_data = $this->input->post('image_data');
		// pre($post);
        // Mengonversi data base64 menjadi file gambar
        $image_data = base64_decode($image_data);
        $file_name = uniqid() . '.png';
        $file_path = FCPATH . 'uploads/signatures/' . $file_name;

        if (file_put_contents($file_path, $image_data)) {
			$update = array(
				'ttdBuHj' => $file_name,
			);
			$where = array(
				'id' => $post['id'],
			);
			$this->db->update('pengajuan_harian_new',$update,$where);
            echo 'Signature saved successfully!';
        } else {
            echo 'Failed to save signature.';
        }
	}

	public function ttdsave() {
		$post = $this->input->post();
        $image_data = $this->input->post('image_data');
		// pre($post);
        // Mengonversi data base64 menjadi file gambar
        $image_data = base64_decode($image_data);
        $file_name = uniqid() . '.png';
        $file_path = FCPATH . 'uploads/signatures/' . $file_name;

        if (file_put_contents($file_path, $image_data)) {
			$update = array(
				'paraf' => $file_name,
				'status' => 1,
				'tanggal_setujui' => date('Y-m-d H:i:s'),
			);
			$where = array(
				'id' => $post['id'],
			);
			$this->db->update('pengajuan_harian_new',$update,$where);
            echo 'Signature saved successfully!';
        } else {
            echo 'Failed to save signature.';
        }
    }

	function getiD(){
		$id = $this->input->get('id');
		$ajuan = $this->GlobalModel->GetDataRow('pengajuan_harian_new',array('hapus'=>0,'id'=>$id));
		echo $ajuan['id'];
		// echo '<input type="hidden" name="idajuan" id="idajuan" value="'.$ajuan['id'].'">';
		
	}

	function uploadnota(){
		$data=$this->input->post();
		$config['upload_path']          = './uploads/nota/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
		// pre($data);
		if(!empty($_FILES['nota']['name'])){
			$this->load->library('upload', $config);
	        $this->upload->do_upload('nota');
	        $imageGambar = $this->upload->data('file_name');
	        $up=array(
	        	'dokumenNota'=>$imageGambar,
	        );
	        $this->db->update('pengajuan_harian_new',$up,array('id'=>$data['idnota']));
			user_activity(callSessUser('id_user'),1,' upload nota belanja ajuan dengan id '.$data['idnota']);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Gudang/pengajuan');
		}else{
			
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect(BASEURL.'Gudang/pengajuan');
		}
		
	}

}