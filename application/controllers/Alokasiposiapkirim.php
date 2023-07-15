<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alokasiposiapkirim extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->link=BASEURL.'Alokasiposiapkirim';
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/alokasiposiapkirim/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index()
	{
		$data=[];
		$data['title']='Alokasi PO Siap Kirim';
		$data['no']=1;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['tambah']=BASEURL.'Alokasiposiapkirim/add';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}

		if(isset($get['cmt'])){
			$idcmt=$get['cmt'];
		}else{
			$idcmt=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['idcmt']=$idcmt;
		$sql="SELECT * FROM alokasi_po WHERE hapus=0 ";
		if(!empty($idcmt)){
			$sql.=" AND idcmt='$idcmt' ";
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}else{
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		$cmt=null;
		$ket=[];
		$no=1;
		$s=1;
		$hitungpo=null;
		foreach($results as $r){
			$cmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$r['idcmt']));
			$ket=$this->GlobalModel->querymanual("SElECT a.*, b.nama,b.color FROM alokasi_po_detail a 
			LEFT JOIN keterangan_alokasipo b ON b.id=a.keterangan
			WHERE idalokasi='".$r['id']."' ");
			foreach($ket as $k){
				$kp=$k['keterangan']=="-"?'':'('.$k['keterangan'].')';
				$kt[]=$k['kode_po'].' '.$kp.'';
			}

			$data['products'][]=array(
				'no'=>$no,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'nama'=>strtolower($cmt['cmt_name']),
				//'keterangan'=>implode(" , ", $kt),
				'keterangan'=>$ket,
				//'jumlah'=>count($kt),
				'hitung'=>json_encode($hitungpo),
				'jumlah'=>count($ket),
				'oblongpdk'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(5),$r['id']),
				'oblongpdkraglan'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(9),$r['id']),
				'oblongpjg'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(8),$r['id']),
				'reglangpjg'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(30),$r['id']),
				'hugo'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(6),$r['id']),
				'stkd'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(2),$r['id']),
				'stwangky'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(3,12),$r['id']),
				'wangky'=>$this->ReportModel->hitungALokasiPo($r['idcmt'],array(11),$r['id']),
				'edit'=>BASEURL.'Alokasiposiapkirim/edit/'.$r['id'],
				'hapus'=>BASEURL.'Alokasiposiapkirim/hapus/'.$r['id'],
			);
			$no++;

			$sket=$this->GlobalModel->querymanual("SElECT * FROM alokasi_po_detail WHERE kode_po NOT IN(SELECT kode_po FROM kelolapo_kirim_setor WHERE
			progress='SETOR' AND kategori_cmt='JAHIT' and hapus=0 ) ");
			foreach($sket as $k){
				$kps=$k['keterangan']=="-"?'':'('.$k['keterangan'].')';
				$kts[]=$k['kode_po'].' '.$kp.'';
			}
			
			$data['stok'][]=array(
				'no'=>$s,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'nama'=>strtolower($cmt['cmt_name']),
				//'keterangan'=>implode(" , ", $kt),
				'keterangan'=>$sket,
				//'jumlah'=>count($kt),
				'hitung'=>json_encode($hitungpo),
				'jumlah'=>count($ket),
				'oblongpdk'=>$this->ReportModel->hitungAlokasiPoKLO($r['idcmt'],array(2,5),$r['id']),
				'oblongpdkraglan'=>$this->ReportModel->hitungAlokasiPoKLO($r['idcmt'],array(9),$r['id']),
				'oblongpjg'=>$this->ReportModel->hitungAlokasiPoKLO($r['idcmt'],array(8),$r['id']),
				'hugo'=>$this->ReportModel->hitungAlokasiPoKLO($r['idcmt'],array(6),$r['id']),
				'stkd'=>0,
				'stwangky'=>$this->ReportModel->hitungAlokasiPoKLO($r['idcmt'],array(3,12),$r['id']),
				'wangky'=>$this->ReportModel->hitungAlokasiPoKLO($r['idcmt'],array(11),$r['id']),
				'edit'=>BASEURL.'Alokasiposiapkirim/edit/'.$r['id'],
				'hapus'=>BASEURL.'Alokasiposiapkirim/hapus/'.$r['id'],
			);
			$s++;
		}
		$data['ket']	= $this->GlobalModel->getData('keterangan_alokasipo',array());
		//pre($data['products']);

		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

	public function add(){
		$data=[];
		$data['title']='Alokasi PO Siap Kirim';
		$data['no']=1;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['kodepo']=$this->GlobalModel->QueryManual("SELECT * FROM produksi_po WHERE hapus=0 and kode_po NOT IN (SELECT kode_po FROM alokasi_po_detail WHERE hapus=0)");
		$data['page']=$this->page.'form';
		$data['action']=BASEURL.'Alokasiposiapkirim/save';
		$data['cancel']=BASEURL.'Alokasiposiapkirim';
		$data['ket']	= $this->GlobalModel->getData('keterangan_alokasipo',array());
		$this->load->view($this->layout,$data);
	}

	public function edit($id){
		$data=[];
		$data['title']='Edit Alokasi PO';
		$data['page']=$this->page.'edit';
		$data['prods']=$this->GlobalModel->getDataRow('alokasi_po',array('id'=>$id));
		$data['details']=$this->GlobalModel->getData('alokasi_po_detail',array('idalokasi'=>$id));
		$cmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['prods']['idcmt']));
		$data['cmt']=strtoupper($cmt['cmt_name']);
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['action']=BASEURL.'Alokasiposiapkirim/editsave';
		$data['cancel']=BASEURL.'Alokasiposiapkirim';
		$data['ket']	= $this->GlobalModel->getData('keterangan_alokasipo',array());
		$this->load->view($this->layout,$data);
	}

	public function editsave(){
		$data=$this->input->post();
		$this->GlobalModel->deleteData('alokasi_po_detail',array('idalokasi'=>$data['id']));
		foreach($data['products'] as $p){
			$detail=array(
				'idalokasi'=>$data['id'],
				'kode_po'=>$p['kode_po'],
				'keterangan'=>$p['keterangan'],
				'hapus'=>0
			);
			$this->db->insert('alokasi_po_detail',$detail);
		}
		$this->session->set_flashdata('msg','Data Alokasi Berhasil Di Ubah');
		redirect(BASEURL.'alokasiposiapkirim');
	}

	public function hapus($id){
		
			$detail=array(
				'hapus'=>1
			);
			$this->db->update('alokasi_po',$detail,array('id'=>$id));
			$this->db->update('alokasi_po_detail',$detail,array('idalokasi'=>$id));
		$this->session->set_flashdata('msg','Data Alokasi Berhasil Di Hapus');
		redirect(BASEURL.'alokasiposiapkirim');
	}

	public function save(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$insert=array(
				'tanggal'=>$data['tanggal'],
				'idcmt'=>$data['cmt'],
				'keterangan'=>'-',
				//'tanggal2'=>$data['tanggal2'],
				'hapus'=>0,
			);
			$this->db->insert('alokasi_po',$insert);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$detail=array(
					'idalokasi'=>$id,
					'kode_po'=>$p['kode_po'],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0
				);
				$this->db->insert('alokasi_po_detail',$detail);
			}
			$this->session->set_flashdata('msg','Data Alokasi Berhasil Di Simpan');
			redirect(BASEURL.'alokasiposiapkirim');
		}else{
			$this->session->set_flashdata('msgt','Data Alokasi Gagal Di Simpan. Rincian PO belum dipilih');
			redirect(BASEURL.'Alokasiposiapkirim/add');
		}
	}
}
