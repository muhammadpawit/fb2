<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockpo extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/';
		$this->page='newtheme/page/stockpo/';
		$this->link='Stockpo/';
		$this->load->model('ReportModel');
	}

	public function index(){
		$data=array();
		$data['title']='Stok PO CMT';
		$data['n']=1;
		$data['tambah']=$this->link.'add';
		$data['products']=array();
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
			$tanggal2=date('Y-m-d');
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'cmt'=>$cmt,
		);
		//$results=$this->ReportModel->stockpo($filter);
		//pre($results);
		$list=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$no=1;
		$jumlah=0;
		$pcs=0;
		foreach($list as $l){
			$jumlah=$this->ReportModel->stockjumlah($filter,$l['id_cmt']);
			$pcs=$this->ReportModel->stockpcs($filter,$l['id_cmt']);
			$data['products'][]=array(
				'no'=>$no,
				'nama'=>strtolower($l['cmt_name']),
				'jumlah'=>$jumlah,
				'pcs'=>$pcs,
				'rincian'=>BASEURL.$this->link.'detail/'.$l['id_cmt'],
				'excel'=>BASEURL.$this->link.'detail/'.$l['id_cmt'].'/?&excel=1',
			);
			$no++;
		}
		//pre($data['products']);
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['page']=$this->page.'list';
		$this->load->view($this->layout.'main',$data);
	}

	public function add(){
		$data=array();
		$data['title']='Stok CMT';
		$data['n']=1;
		$data['tambah']=$this->link.'save';
		$data['products']=array();
		$this->load->view($this->layout.'main',$data);
	}

	public function detail($idcmt){
		$data=array();
		$get=$this->input->get();
		$data['title']='Laporan PO CMT ';
		$data['n']=1;
		$data['tambah']=$this->link.'save';
		$data['products']=array();
		$data['jenis']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$sql="SELECT kc.*, c.cmt_name FROM kirimcmt kc LEFT JOIN master_cmt c ON(c.id_cmt=kc.idcmt) WHERE kc.idcmt='$idcmt' ";
		$data['products']=$this->GlobalModel->QueryManualRow($sql);
		$jenis=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$no=1;
		//$rpo=array();
		foreach($jenis as $j){
			$po = $this->GlobalModel->getStokPO($idcmt,$j['id_jenis_po']);
			$rpo = $this->GlobalModel->getStokrincianpo($idcmt,$j['id_jenis_po']);
			$data['prods'][]=array(
				'no'=>$no,
				'jmlpo'=>$po['jmlpo']==0?'':$po['jmlpo'],
				'pcspo'=>$po['pcs'],
				'rincian'=>$rpo,
			);

			$pos = $this->GlobalModel->getStokPOs($idcmt,$j['id_jenis_po']);
			$rposetor = $this->GlobalModel->getStokrincianposetor($idcmt,$j['id_jenis_po']);
			$data['setors'][]=array(
				'no'=>$no,
				'jmlpo'=>$pos['jmlpo']==0?'':$pos['jmlpo'],
				'pcspo'=>$pos['pcs'],
				'rincian'=>$rposetor,
			);
			$no++;
		}
		//pre($data['prods']);
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);	
		}else{
			$data['page']=$this->page.'detail';
			$this->load->view($this->layout.'main',$data);
		}
		
	}

	public function save(){
		$data=$this->input->post();
		pre($data);
	}

	public function rekap(){
		$data=array();
		$data['title']='Laporan Rekap Stok CMT';
		$data['n']=1;
		$data['tambah']=$this->link.'save';
		$data['products']=array();
		$get=$this->input->get();
		$results=array();
		$periode=$this->ReportModel->periode();
		if(isset($get['bulan1'])){
			//$bulan1=$get['bulan1'];
			$b=explode(" ", $get['bulan1']);
			$g=date('n',strtotime($b[0]));
			$bln=array(
				'bulan'=>$g,
				'tahun'=>$b[1],
			);
			$bulan1=$bln['bulan'];
			$tahun1=$bln['tahun'];
		}else{
			$bulan1=null;
			$tahun1=null;
		}
		if(isset($get['bulan2'])){
			$b=explode(" ", $get['bulan2']);
			$g=date('n',strtotime($b[0]));
			$bln2=array(
				'bulan'=>$g,
				'tahun'=>$b[1],
			);
			$bulan2=$bln2['bulan'];
			$tahun2=$bln2['tahun'];
		}else{
			$bulan2=null;
			$bulan2=null;
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
			$data['cmts']=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt));
		}else{
			$cmt=null;
			$data['cmts']=array('cmt_name'=>null);
		}

		$data['cmt']=$this->GlobalModel->getdata('master_cmt',array('hapus'=>0,));

		$sql="SELECT * FROM kalender WHERE id>0 ";
		if(!empty($bulan1)){
			$sql.=' AND bulan BETWEEN '.$bulan1.' AND '.$bulan2.' ';
		}
		$sql.=' ORDER BY bulan asc ';
		$results = $this->GlobalModel->QueryManual($sql);
		for ($i = 0; $i < 12; $i++) {
		    $timestamp = mktime(0, 0, 0, $periode['bulan'] + $i, 1,$periode['tahun']); // angka 6 bulan juni, periode awal potongan
		    $bulan[]=$months[date('n', $timestamp)] = date('M Y', $timestamp);
		}
		$kirimjmlpo=null;
		$kirimdz=0;
		$kirimpcs=0;
		$setorjmlpo=null;
		$setordz=0;
		$setorpcs=0;
		if(!empty($cmt)){
			foreach($bulan as $b=>$val){
				$b=explode(" ", $val);
				$g=date('n',strtotime($b[0]));
				$t=explode(" ", $val);
				$timestamp = mktime(0, 0, 0, $g + $i, 1,$t[1]);
				$month=$months[date('n', $timestamp)] = date('n', $timestamp);
			    $y=$t[1];
			    $kirimjmlpo=$this->ReportModel->rekapjml($month,$y,$cmt,NULL,'KIRIM');
			    $kirimpcs=$this->ReportModel->rekappcs($month,$y,$cmt,NULL,'KIRIM');
			    $setorjmlpo=$this->ReportModel->rekapjml($month,$y,$cmt,NULL,'SETOR');
			    $setorpcs=$this->ReportModel->rekappcs($month,$y,$cmt,NULL,'SETOR');
				$data['products'][]=array(
					'bulan'=>$val,
					'bln'=>$month,
					'year'=>$y,
					'kirimpo'=>$kirimjmlpo,
					'kirimdz'=>number_format($kirimpcs/12,2),
					'kirimpcs'=>number_format($kirimpcs,2),
					'setorjmlpo'=>($setorjmlpo),
					'setordz'=>number_format($setorpcs/12,2),
					'setorpcs'=>number_format($setorpcs,2),
				);
				$kp[]=array(
					'tot'=>$kirimpcs==null?0:$kirimpcs/12,
				);
				$sp[]=array(
					'tot'=>$setorpcs==null?0:$setorpcs/12,
				);
			}
			$data['kp']=implode(",", array_column($kp, 'tot'));
			$data['sp']=implode(",", array_column($sp, 'tot'));
		}else{
			$data['kp']=0;
			$data['sp']=0;
		}
		
		$data['bulan1']=$bulan1;
		$data['bulan2']=$bulan2;
		$data['cmtf']=$cmt;
		$data['bulan']=$this->ReportModel->month();
		$bulannya=$this->ReportModel->month();
		$data['bulans']=json_encode($bulannya);
		$data['excel']=BASEURL.'Stockpo/rekap?&excel=1&cmt='.$cmt;
		$data['cetak']=BASEURL.'Stockpo/rekap?&cetak=1&cmt='.$cmt;
		if(isset($get['excel'])){
			$this->load->view($this->page.'rekap_excel',$data);
		}else if(isset($get['cetak'])){
			$this->load->view($this->page.'rekap_cetak',$data);
		}else{
			$data['page']=$this->page.'rekap';
			$this->load->view($this->layout.'main',$data);
		}
	}

}