<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gajisukabumi extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/gajisukabumi/';
		$this->link=BASEURL.'Gajisukabumi/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Rincian Gaji Karyawan Sukabumi';
		$get=$this->input->get();
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
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

		$data['n']=1;
		$data['tambah']=$this->link.'add';
		$data['products']=array();
		$results=array();
		$sql='SELECT * FROM gajisukabumi WHERE hapus=0 ';
		if(!empty($tanggal1)){
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}		
		$sql.=" ORDER BY id DESC ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => $this->link.'detail/'.$result['id'],
			);

			if(akseshapus()==1){
				$action[] = array(
					'text' => 'Hapus',
					'href' => $this->link.'hapus/'.$result['id'],
				);
			}
			
			$data['products'][]=array(
				'no'=>$no++,
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'total'=>$result['total'],
				'keterangan'=>$result['keterangan'],
				'action'=>$action,
			);
		}
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

	public function add(){
		$data=[];
		$data['title']='Tambah Rincian Gaji Karyawan Sukabumi';
		$data['batal']=$this->link;
		$data['action']=$this->link.'save';
		$data['page']=$this->page.'add';
		$data['karyawan']=$this->GlobalModel->queryManual("SELECT nama FROM karyawan WHERE cabang=2 and hapus=0 union SELECT nama from karyawan_skb WHERE hapus=0;");
		$this->load->view($this->layout,$data);
	}

	public function itemkeluarSearchId($id='')
	{
		$getId = $this->input->get('id');
		$data = $this->GlobalModel->queryManualRow("SELECT karyawan.nama, gajipokok as nominal, jabatan.nama as bagian FROM karyawan LEFT JOIN jabatan ON jabatan.id=karyawan.jabatan WHERE cabang=2 AND karyawan.nama='".$getId."' and karyawan.hapus=0 union SELECT karyawan_skb.nama, upah as nominal, bagian as bagian from karyawan_skb WHERE karyawan_skb.hapus=0 AND karyawan_skb.nama='".$getId."'  ");
		echo json_encode($data);
	}

	public function save(){
		$data=$this->input->post();
		$insert=array(
			'tanggal'=>isset($data['tanggal'])?$data['tanggal']:date('Y-m-d'),
			'total'=>0,
			'keterangan'=>$data['keterangan'],
			'hapus'=>0,
		);
		$this->db->insert('gajisukabumi',$insert);
		$id = $this->db->insert_id();		
		$total=0;
		$perkalian=1;
		foreach($data['prods'] as $p){
			if(strtolower($p['keterangan'])==2){
				$perkalian=1;
			}else{
				$perkalian=$p['jml_hari_kerja'];
			}
			$total+=($perkalian*$p['upah']);
			
			$insert_details=array(
				'idgaji'=>$id,
				'nama'=>strtolower($p['nama']),
				'bagian'=>strtolower($p['bagian']),
				'jml_hari_kerja'=>$p['jml_hari_kerja'],
				'upah'=>$p['upah'],
				'total'=>($perkalian*$p['upah']),
				'keterangan'=>$p['keterangan']==1?'UPAH HARIAN':'KASBON',
				'hapus'=>0,
			);
			$this->db->insert('gajisukabumi_detail',$insert_details);
		}
		$this->db->update('gajisukabumi',array('total'=>$total),array('id'=>$id));

		// anggaran operasional
		if(isset($data['anggaran'])){
			$inserta=array(
				'id'=>$id,
				'tanggal'=>isset($data['tanggal'])?$data['tanggal']:date('Y-m-d'),
				'total'=>0,
				'keterangan'=>$data['keterangan'],
				'hapus'=>0,
			);
			$this->db->insert('anggaran_operasional_sukabumi',$inserta);
			foreach($data['anggaran'] as $p){
				$totala+=($p['harga']*$p['jml']);
				$insert_detailsa=array(
					'idanggaran'=>$id,
					'keperluan'=>strtolower($p['keperluan']),
					'jml'=>strtolower($p['jml']),
					'harga'=>$p['harga'],
					'total'=>($p['harga']*$p['jml']),
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('anggaran_operasional_sukabumi_detail',$insert_detailsa);
				$this->db->update('anggaran_operasional_sukabumi',array('total'=>$totala),array('id'=>$id));
			}
		}

		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect($this->link);
	}

	public function hapus($id){
		$this->db->update('gajisukabumi',array('hapus'=>1),array('id'=>$id));
		$this->db->update('gajisukabumi_detail',array('hapus'=>1),array('idgaji'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect($this->link);
	}

	public function detail($id){
		$data=[];
		$get=$this->input->get();
		$data['title']='Rincian Gaji Karyawan Sukabumi';
		$data['batal']=$this->link;
		$data['p']=$this->GlobalModel->GetDataRow('gajisukabumi',array('hapus'=>0,'id'=>$id));
		$data['detail']=$this->GlobalModel->GetData('gajisukabumi_detail',array('hapus'=>0,'idgaji'=>$id));
		$data['harian']=$this->GlobalModel->queryManual("SELECT COALESCE(SUM(total),0) as total, keterangan FROM gajisukabumi_detail WHERE hapus=0 and idgaji='".$id."' AND lower(keterangan) <> 'kasbon' ");
		$data['a']=$this->GlobalModel->GetDataRow('anggaran_operasional_sukabumi',array('hapus'=>0,'id'=>$id));
		$data['sd']=$this->GlobalModel->GetData('anggaran_operasional_sukabumi_detail',array('hapus'=>0,'idanggaran'=>$id));
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'detail';
			$this->load->view($this->layout,$data);
		}
		
	}

}