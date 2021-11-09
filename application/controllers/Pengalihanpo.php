<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengalihanpo extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->url=BASEURL.'Pengalihanpo/';
		$this->page='newtheme/page/pengalihanpo/';
		$this->layout='newtheme/page/main';
	}

	public function index(){
		$data=[];
		$data['title']='Pengalihan PO';
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM pengalihanpo WHERE hapus=0";
		if(!empty($tanggal1)){
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id desc ";
		$data['prods']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$sql.=" ORDER BY id DESC ";
		foreach ($results as $r) {
			$cmtasal=$this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$r['cmt_asal']));
			$cmttujuan=$this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$r['cmt_tujuan']));
			$sjasal=$this->GlobalModel->GetDataRow('kirimcmt',array('id'=>$r['sj_asal']));
			$sjtujuan=$this->GlobalModel->GetDataRow('kirimcmt',array('id'=>$r['sj_tujuan']));
			$data['prods'][]=array(
				'tanggal'=>date('d F Y',strtotime($r['tanggal'])),
				'sj_asal'=>$sjasal['nosj'],
				'sj_tujuan'=>$sjtujuan['nosj'],
				'cmt_asal'=>$cmtasal['cmt_name'],
				'cmt_tujuan'=>$cmttujuan['cmt_name'],
				'kode_po'=>$r['kode_po'],
				'keterangan'=>$r['keterangan'],
			);
		}
		$data['page']=$this->page.'pengalihanpo';
		$data['tambah']=$this->url.'tambah';
		$this->load->view($this->layout,$data);	
	}

	public function tambah(){
		$data=[];
		$data['title']='Pengalihan PO';
		$data['kirim']=$this->GlobalModel->QueryManual("SELECT kd.*, k.idcmt,k.nosj,k.tanggal as tglsj,k.id as idsj FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) WHERE kd.hapus=0 AND k.hapus=0");
		$data['cmt']=$this->GlobalModel->QueryManual("SELECT mc.*,k.tanggal as tglsj, k.id as idsj,k.nosj FROM master_cmt mc JOIN kirimcmt k ON(k.idcmt=mc.id_cmt) WHERE mc.hapus=0 ORDER BY k.nosj DESC ");
		$data['action']=$this->url.'tambah_save';
		$data['cancel']=$this->url;
		$data['page']=$this->page.'pengalihanpo_tambah';
		$this->load->view($this->layout,$data);	
	}

	public function tambah_save(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['prods'])){
			foreach($data['prods'] as $p){
				$asal=explode('-', $p['kode_po']);
				$tujuan=explode('-', $p['cmt_tujuan']);
				$sj=$this->GlobalModel->GetDataRow('kirimcmt',array('id'=>$asal[1]));
				$sjdetail=$this->GlobalModel->GetDataRow('kirimcmt_detail',array('idkirim'=>$asal[1]));
				$cmttujuan=$this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$tujuan[0]));
				$insert=array(
					'tanggal'=>$p['tanggal'],
					'sj_asal'=>$asal[1],
					'sj_tujuan'=>$tujuan[1],
					'cmt_asal'=>$sj['idcmt'],
					'cmt_tujuan'=>$tujuan[0],
					'kode_po'=>$asal[0],
					'keterangan'=>$p['keterangan'],
					'hapus'=>0,
				);
				$this->db->insert('pengalihanpo',$insert);
				
				$update=array(
					'id_master_cmt'=>$tujuan[0],
					'kode_nota_cmt'=>$tujuan[1],
					'nama_cmt'=>$cmttujuan['cmt_name'],
				);
				$this->db->update('kelolapo_kirim_setor',$update,array('kategori_cmt'=>'JAHIT','kode_po'=>$asal[0]));

				// update sj asal
				$this->db->query("update kirimcmt set totalkirim=totalkirim-'".$sjdetail['jumlah_pcs']."' WHERE id='".$sjdetail['idkirim']."' ");
				// update sj tujuan
				$this->db->query("update kirimcmt set totalkirim=totalkirim+'".$sjdetail['jumlah_pcs']."' WHERE id='".$tujuan[1]."' ");
				// update sj tujuan
				$this->db->query("update kirimcmt_detail set idkirim='".$tujuan[1]."' WHERE id='".$sjdetail['id']."' ");
			}
			//pre($sjdetail);
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}
	}
}