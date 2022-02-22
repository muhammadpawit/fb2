<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kirimbordir extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/';
		$this->page='newtheme/page/kirimbordir/';
		$this->link=BASEURL.'Kirimbordir/';
	}

	public function index(){
		$data=array();
		$data['title']='Kirim Setor Bordir ';
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
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		$sql='SELECT * FROM kelolapo_kirim_setor kks LEFT JOIN produksi_po pp ON kks.kode_po=pp.kode_po';
		$sql.=" WHERE kks.hapus=0 AND kategori_cmt='BORDIR' ";
		if(!empty($kode_po)){
			$sql.=" AND kks.kode_po='".$kode_po."' ";
		}else{
			$sql.=" AND date(kks.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id_kelolapo_kirim_setor DESC ";
		$sql.=" LIMIT 20 ";
		$data['kelola']	= $this->GlobalModel->queryManual($sql);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['page']=$this->page.'list';
		$data['tambah']=$this->link.'add';
		$this->load->view($this->layout.'main',$data);
	}

	public function add(){
		$data=array();
		$data['title']='Kirim Setor Bordir';
		$data['n']=1;
		$data['cancel']=$this->link;
		$data['action']=$this->link.'save';
		$data['products']=array();
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1,3) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=$this->GlobalModel->getData('claim_sablon',array('hapus'=>0));
		$data['page']=$this->page.'add';
		$this->load->view($this->layout.'main',$data);
	}

	public function save(){
		$post=$this->input->post();
		//pre($post);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		if(isset($post['tanggal'])){
			$cmt=explode('-', $post['cmtName']);
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt[0]));
   			foreach($post['products'] as $p){
   				$insertkks=array(
   					'kode_po'=>$p['kode_po'],
   					'create_date'=>$post['tanggal'],
   					'kode_nota_cmt'=>0,
   					'progress'=>$post['progress'],
   					'kategori_cmt'=>'BORDIR',
   					'id_master_cmt'=>$cmt[0],
   					//'id_master_cmt_job'=>$job[0],
   					'id_master_cmt_job'=>126,
   					'cmt_job_price'=>0,
   					'nama_cmt'=>'DALAM',
   					'qty_tot_pcs'=>$p['jumlah_pcs'],
   					'qty_tot_atas'=>0,
   					'qty_tot_bawah'=>0,
   					'keterangan'=>'-',
   					'status'=>0,
   					'jml_barang'=>$p['jml_barang'],
   					'qty_bangke'=>0,
   					'qty_reject'=>0,
   					'qty_hilang'=>0,
   					'qty_claim'=>0,
   					'status_keu'=>0,
   					'tglinput'=>date('Y-m-d'),
   				);
   				$this->db->insert('kelolapo_kirim_setor',$insertkks);
   				$iks = $this->db->insert_id();
   				$atas = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$p['kode_po']));
   				if(!empty($atas)){
	   				foreach($atas as $a){
	   					$ia=array(
	   						'id_kelolapo_kirim_setor'=>$iks,
	   						'kode_po'=>$a['kode_po'],
	   						'bagian_potongan_atas'=>$a['bagian_potongan_atas'],
	   						'warna_potongan_atas'=>$a['warna_potongan_atas'],
	   						'jumlah_potongan'=>$a['jumlah_potongan'],
	   						'keterangan_potongan'=>$a['keterangan_potongan'],
	   						'created_date'=>$post['tanggal'],
	   						'qty_bangke_atas'=>0,
	   						'qty_reject_atas'=>0,
	   						'qty_hilang_atas'=>0,
	   						'qty_claim_atas'=>0,
	   					);
	   					$this->db->insert('kelolapo_kirim_setor_atas',$ia);
	   				}
	   			}
	   			$bawah = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$p['kode_po']));
	   			if(!empty($bawah)){
	   				foreach($bawah as $b){
	   					$ib=array(
	   						'id_kelolapo_kirim_setor'=>$iks,
	   						'kode_po'=>$b['kode_po'],
	   						'bagian_potongan_atas'=>$b['bagian_potongan_bawah'],
	   						'warna_potongan_atas'=>$b['warna_potongan_bawah'],
	   						'jumlah_potongan'=>$b['jumlah_potongan'],
	   						'keterangan_potongan'=>$a['keterangan_potongan'],
	   						'created_date'=>$post['tanggal'],
	   						'qty_bangke_atas'=>0,
	   						'qty_reject_atas'=>0,
	   						'qty_hilang_atas'=>0,
	   						'qty_claim_atas'=>0,
	   					);
	   					$this->db->insert('kelolapo_kirim_setor_bawah',$ib);
	   				}
	   			}
   			}
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->link);
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function caripo(){
		$data=$this->input->post();
		$idcmt=explode("-",$data['namacmt']);
		$sql="SELECT k.nosj,kd.* FROM kirimcmt k JOIN kirimcmt_detail kd ON(kd.idkirim=k.id) WHERE idcmt='".$idcmt[0]."' AND k.hapus=0 and kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
		$sj=$this->GlobalModel->queryManual($sql);
		$i=0;
		if(!empty($sj)){
			foreach($sj as $s){
				echo "<tr>";
				echo '<td><input type="checkbox" name="products['.$i.'][pilih]"><input type="hidden" name="products['.$i.'][kode_po] class="form-control" value="'.$s['kode_po'].'"><input type="hidden" name="products['.$i.'][idkirim] class="form-control" value="'.$s['idkirim'].'"></td>';
				echo '<td>'.$s['kode_po'].'</td>';
				echo '<td>'.$s['nosj'].'</td>';
				echo '<td>'.$s['jumlah_pcs'].'</td>';
				echo '<td><input type="text" name="products['.$i.'][totalsetor] class="form-control" value="'.($s['jumlah_pcs']-$s['totalsetor']).'"><input type="hidden" name="products['.$i.'][cmtjob] class="form-control" value="'.$s['cmtjob'].'"></td>';
				echo '<td><input type="text" name="products['.$i.'][keterangan] class="form-control" value="'.$s['keterangan'].'"></td>';
				echo "</tr>";
				$i++;
			}
		}else{
			echo "<tr><td colspan='5'>Data tidak ditemukan</td></tr>";
		}
	}

}