<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setoransablon extends CI_Controller {

	
	public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
	public $session;
	public $GlobalModel;
	public $input;
	public $db;
	public $ReportModel;
	public $upload;
	public $viewData;
	public $pdfgenerator;
	public $pagination;
	public $uri;
	public $pdf;
	public $data;
	public $bg_warning;
	public $bg_danger;
	public $bg_success;
	public $bg_info;
	public $link;

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/';
		$this->page='newtheme/page/setoransablon/';
		$this->link=BASEURL.'Setoransablon/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=array();
		$data['title']='Setoran Sablon CMT';
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
		//$data['products']=$this->GlobalModel->getData('setorcmt',array('hapus'=>0));
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'SABLON'));
		$results=array();
		$sql="SELECT * FROM setorcmt WHERE hapus=0 AND cmtKat='SABLON' ";
		
		if(!empty($cmt)){
			$sql.=" AND idcmt='".$cmt."' ";
		}else{
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		
		$sql.=" ORDER BY id DESC ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtid']=$cmt;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => $this->link.'kirimcmtview/'.$result['id'],
				'bg'   => bgColor('detail'),
			);


			if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => $this->link.'edit/'.$result['id'],
					'bg'   => bgColor('edit'),
				);
			}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d/m/Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalsetor'],
				'namacmt'=>$namacmt['cmt_name'],
				'status'=>$result['status']==1?'Disetor':'',
				'action'=>$action,
				'keterangan'=>$result['keterangan'],
			);
		}
		$data['page']=$this->page.'list';
		$this->load->view($this->layout.'main',$data);
	}

	public function kirimcmtview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['cetak']=$this->link.'kirimcmtcetak/'.$id.'/1';
		$data['excel']=$this->link.'kirimcmtcetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('setorcmt',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('setorcmt_sablon_detail',array('idsetor'=>$id));
		$job=null;
		$data['kirims']=[];
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$k['kode_po']));
			$data['kirims'][]=array(
				'kode_po'=>$po['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>!empty($job)?$job['nama_job']:'',
				'totalsetor'=>$k['totalsetor'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['setoransablon']=true;
		$data['page']='produksi/setor_detail';
		$this->load->view('newtheme/page/main',$data);
	}

	public function add(){
		$data=array();
		$data['title']='Setoran Sablon ';
		$data['n']=1;
		$data['cancel']=$this->link;
		$data['action']=$this->link.'save';
		$data['products']=array();
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(3) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=$this->GlobalModel->getData('claim_sablon',array('hapus'=>0));
		$data['page']=$this->page.'add';
		$this->load->view($this->layout.'main',$data);
	}

public function save(){
		$post=$this->input->post();
		// pre($post);
		//$po=implode(",", $post['namaPo']);
		//$rowpo=count($post['namaPo']);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		$totalsetor=0;
		$masterpo=[];
		if(isset($post['products'])){
			//$job=explode("-",$post['cmtJob']);
			$cmt=explode('-', $post['cmtName']);
			$insert=array(
				'tanggal'=>$post['tanggal'],
				//'kode_po'=>$po,
				'kode_po'=>'-',
				'totalsetor'=>0,
				'cmtkat'=>$post['cmtKat'],
				'idcmt'=>$cmt[0],
				'cmtkat'=>$post['cmtKat'],
				//'cmtjob'=>$job[0],
				'cmtjob'=>'-',
				'status'=>0,
				'keterangan'=>$post['keterangan'],
				'dibuat'=>date('Y-m-d H:i:s'),
				'hapus'=>0,
			);
			$this->db->insert('setorcmt', $insert);
   			$idsetor = $this->db->insert_id();

   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt[0]));
   			foreach($post['products'] as $p){
   				if(isset($p['pilih'])){
   					// eksekusi di table kirim
   					$this->db->query("UPDATE kirimcmtsablon set totalsetor=totalsetor+'".$p['totalsetor']."' WHERE id='".$p['idkirim']."' ");
   					$this->db->query("UPDATE kirimcmtsablon_detail set totalsetor=totalsetor+'".$p['totalsetor']."' WHERE idkirim='".$p['idkirim']."' AND idpo='".$p['kode_po']."' ");
   					$jobprice=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$p['cmtjob']));
	   				$totalsetor+=($p['totalsetor']);

	   				$totalkirim=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$p['idkirim']));

	   				if($totalkirim['totalkirim']==$totalsetor){
	   					$this->db->update('kirimcmtsablon',array('status'=>1),array('id'=>$p['idkirim']));
	   				}else if($totalkirim['totalkirim']>$totalsetor){
	   					$this->db->update('kirimcmtsablon',array('status'=>1),array('id'=>$p['idkirim']));
	   				}else{

	   				}
	   				$detail=array(
	   					'idsetor'=>$idsetor,
	   					'kode_po'=>$p['kode_po'],
	   					'idkirim'=>$p['idkirim'],
	   					'totalsetor'=>$p['totalsetor'],
	   					'keterangan'=>$p['keterangan'],
	   					'hapus'=>0,
	   				);
	   				$this->db->insert('setorcmt_sablon_detail',$detail);
	   				
	   				// setor
	   				$masterpo=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$p['kode_po']));
	   				$insertkks=array(
	   					'kode_po'=>$masterpo['kode_po'],
	   					'create_date'=>$post['tanggal'],
	   					'kode_nota_cmt'=>$idsetor,
	   					'progress'=>'SETOR',
	   					'kategori_cmt'=>'SABLON',
	   					'id_master_cmt'=>$cmt[0],
	   					'id_master_cmt_job'=>$p['cmtjob'],
	   					'cmt_job_price'=>$jobprice['harga'],
	   					'nama_cmt'=>$namacmt['cmt_name'],
	   					'qty_tot_pcs'=>$p['totalsetor'],
	   					'qty_tot_atas'=>0,
	   					'qty_tot_bawah'=>0,
	   					'keterangan'=>'-',
	   					'status'=>0,
	   					'jml_barang'=>0,
	   					'qty_bangke'=>0,
	   					'qty_reject'=>0,
	   					'qty_hilang'=>0,
	   					'qty_claim'=>0,
	   					'status_keu'=>0,
	   					'tglinput'=>date('Y-m-d'),
	   					'idpo'=>!empty($masterpo)?$masterpo['id_produksi_po']:0,
	   				);
	   				$this->db->insert('kelolapo_kirim_setor',$insertkks);
	   				$iks = $this->db->insert_id();
	   				/*
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
		   			}*/
   				}
   			}
	   		$nosj='STSBFB'.'-'.date('Y-m').'-'.$idsetor;
	   		$this->db->update('setorcmt',array('totalsetor'=>$totalsetor,'nosj'=>$nosj),array('id'=>$idsetor));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->link);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function caripo(){
		$data=$this->input->post();
		if(!isset($data['namacmt'])){
			exit;
		}
		$idcmt=explode("-",$data['namacmt']);
		//$sql="SELECT k.nosj,kd.* FROM kirimcmtsablon k JOIN kirimcmtsablon_detail kd ON(kd.idkirim=k.id) WHERE idcmt='".$idcmt[0]."' AND k.hapus=0 and kd.hapus=0 AND kd.jumlah_pcs<>kd.totalsetor ";
		$sql="SELECT k.idcmt,k.nosj,kd.*,p.kode_po as kodepo FROM kirimcmtsablon k JOIN kirimcmtsablon_detail kd ON(kd.idkirim=k.id) 
		INNER JOIN produksi_po p on p.id_produksi_po=kd.idpo
		WHERE idcmt='".$idcmt[0]."' AND k.hapus=0 and kd.hapus=0 AND kd.idpo NOT IN (SELECT kode_po FROM setorcmt_sablon_detail WHERE hapus=0 AND totalsetor>0 ) ";
		$sj=$this->GlobalModel->queryManual($sql);
		$i=0;
		if(!empty($sj)){
			foreach($sj as $s){
				echo "<tr>";
				echo '<td><input type="checkbox" name="products['.$i.'][pilih]"><input type="hidden" name="products['.$i.'][kode_po] class="form-control" value="'.$s['idpo'].'"><input type="hidden" name="products['.$i.'][idkirim] class="form-control" value="'.$s['idkirim'].'"></td>';
				echo '<td>'.$s['kodepo'].'</td>';
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

	public function edit($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['cetak']=null;
		$data['excel']=null;
		$data['kirims']=array();
		$data['action']=$this->link.'editsave';
		$data['kirim']=$this->GlobalModel->getDataRow('setorcmt',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('setorcmt_sablon_detail',array('idsetor'=>$id));
		
		$job=null;
		$jobPo=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$k['kode_po']));
			$jobPo = $this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('idpo'=>$po['id_produksi_po'],'kategori_cmt'=>'SABLON','progress'=>'KIRIM'));
			$data['kirims'][]=array(
				'id'	=>$k['id'],
				'kode_po'=>$po['kode_po'],
				'idpo'=>$k['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>isset($job['id']) ? $job['id'] : $jobPo['id_master_cmt_job'],
				'jumlah_pcs'=>($k['jumlah_pcs']==0) ? $jobPo['qty_tot_pcs'] : $k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		//pre($data['kirims']);
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['listcmt'] = $this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'SABLON'));
		$data['listjob'] = $this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>2));
		$data['listpo']	 = $this->GlobalModel->QueryManual("SELECT * FROM produksi_po WHERE hapus=0  ORDER BY kode_po ASC ");
		$data['page']=$this->page.'edit';
		$this->load->view('newtheme/page/main',$data);
	}

	public function editsave(){
		$post=$this->input->post();
		// pre($post);
		//pre($data);
		$cmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$post['idcmt']));
		// update di sj
		$this->db->query("UPDATE setorcmt set idcmt='".$post['idcmt']."',tanggal='".$post['tanggal']."' WHERE id='".$post['kode_nota']."' ");
		// update di kelola kirim setor
		$sql="UPDATE kelolapo_kirim_setor set id_master_cmt='".$post['idcmt']."',nama_cmt='".strtolower($cmt['cmt_name'])."',create_date='".$post['tanggal']."' WHERE kode_nota_cmt='".$post['kode_nota']."' AND kategori_cmt='SABLON' AND progress='SETOR' ";	
		$this->db->query($sql);
		$totalsetor=0;

		// fungsi baru
		$id = $post['kode_nota'];
		// pre($id);

					foreach($post['prods'] as $p){
							// hapus di kelolapo kirim setor
							$this->db->delete(
								'kelolapo_kirim_setor', 
									array(
										'idpo' => $p['kode_po_lama'],
										'progress' => 'SETOR',
										'kategori_cmt' => $p['kategori_cmt'],
									)
							);
					}
				foreach($post['prods'] as $p){
					$jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$p['cmtjob']));
					$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$p['kode_po']));
	   				$totalsetor+=($p['jumlah_pcs']);
	   				$detail=array(
	   					'idsetor'=>$id,
	   					'kode_po'=>$po['id_produksi_po'],
	   					'cmtjob'=>$p['cmtjob'],
	   					'rincian_po'=>$p['rincian_po'],
	   					'jumlah_pcs'=>$p['jumlah_pcs'],
	   					'keterangan'=>$p['keterangan'],
	   					'jml_barang'=>$p['jml_barang'],
						'totalsetor'=>$p['jumlah_pcs'],
	   					'hapus'=>0,
	   				);
	   				$this->db->update('setorcmt_sablon_detail',$detail,array('id'=>$p['id']));


	   				$masterpo=$this->GlobalModel->GetdataRow('produksi_po',array('id_produksi_po'=>$p['kode_po']));
	   				$insertkks=array(
	   					'kode_po'=>$masterpo['kode_po'],
	   					'create_date'=>$post['tanggal'],
	   					'kode_nota_cmt'=>$id,
	   					'progress'=>'SETOR',
	   					'kategori_cmt'=>'SABLON',
	   					'id_master_cmt'=>$cmt['id_cmt'],
	   					'id_master_cmt_job'=>$p['cmtjob'],
	   					'cmt_job_price'=>$jobprice['harga'],
	   					'nama_cmt'=>$cmt['cmt_name'],
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
	   					'idpo'=>!empty($masterpo)?$masterpo['id_produksi_po']:0,
	   				);
	   				$this->db->insert('kelolapo_kirim_setor',$insertkks);
			}// end foreach	

		user_activity(callSessUser('id_user'),1,' edit setoran surat jalan sablon id '.$post['kode_nota']);
		$this->db->update('setorcmt',array('totalsetor'=>$totalsetor),array('id'=>$post['kode_nota']));
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect(BASEURL.'Setoransablon');
	}

}