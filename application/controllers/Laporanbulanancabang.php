<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanbulanancabang extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/laporanbulanancabang/';
		$this->link='Laporanbulanancabang/';
		$this->load->model('ReportModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

    function index(){
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
		$kirimpo=0;
        $cmtnya = $this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='JAHIT' AND lokasi=3 order by cmt_name ");
		if(!empty($cmt)){
			foreach($cmtnya as $val){
				$month=null;
			    $y=null;
			    $kirimjmlpo=$this->ReportModel->rekapjml($month,$y,$val['id_cmt'],NULL,'KIRIM');
			    $kirimpcs=$this->ReportModel->rekappcs($month,$y,$val['id_cmt'],NULL,'KIRIM');
			    $setorjmlpo=$this->ReportModel->rekapjml($month,$y,$val['id_cmt'],NULL,'SETOR');
			    $setorpcs=$this->ReportModel->rekappcs($month,$y,$val['id_cmt'],NULL,'SETOR');
				$data['products'][]=array(
					'bulan'=>strtoupper($val['cmt_name']),
					'bln'=>$month,
					'year'=>$y,
					'kirimpo'=>$kirimjmlpo,
					'kirimdz'=>number_format($kirimpcs/12,2),
					'kirimpcs'=>number_format($kirimpcs,2),
					'setorjmlpo'=>($setorjmlpo),
					'setordz'=>number_format($setorpcs/12,2),
					'setorpcs'=>number_format($setorpcs,2),
				);
				$kirimpo    +=$kirimjmlpo;
                $kirimdz    +=($kirimpcs);
                $kirimpcs   +=($kirimpcs);
                $setorjmlpo +=($setorjmlpo);
                $setordz    +=($setorpcs);
                $setorpcs   +=($setorpcs);
				$kp[]=array(
					'tot'=>$kirimpcs==null?0:$kirimpcs/12,
				);
				$sp[]=array(
					'tot'=>$setorpcs==null?0:$setorpcs/12,
				);
                $nama[]=$val['cmt_name'];
			}
			$data['kp']=implode(",", array_column($kp, 'tot'));
			$data['sp']=implode(",", array_column($sp, 'tot'));
		}else{
			$data['kp']=0;
			$data['sp']=0;
		}

		$data['kirimpo']    =$kirimpo;
        $data['kirimdz']    =$kirimdz;
        $data['kirimpcs']   =$kirimpcs;

        $data['setorjmlpo'] =$setorjmlpo;
        $data['setordz']    =$setordz;
        $data['setorpcs']   =$setorpcs;
		
		$data['bulan1']=$bulan1;
		$data['bulan2']=$bulan2;
		$data['cmtf']=$cmt;
		$data['bulan']=$this->ReportModel->month();
		$bulannya=$this->ReportModel->month();
		$data['bulans']=json_encode($nama);
		$data['excel']=BASEURL.'Stockpo/rekap?&excel=1&cmt='.$cmt;
		$data['cetak']=BASEURL.'Stockpo/rekap?&cetak=1&cmt='.$cmt;
		if(isset($get['excel'])){
			$this->load->view($this->page.'rekap_excel',$data);
		}else if(isset($get['cetak'])){
			$this->load->view($this->page.'rekap_cetak',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
    }
}