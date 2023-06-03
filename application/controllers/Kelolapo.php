<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelolapo extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/kelolapo/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}


	public function produksipoedit($kode_po){
		$data=[];
		$data['title']='Edit PO ';
		$data['detail']=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$kode_po));
		$data['spek']	= !empty($data['detail']['spesifikasi'])?explode(",", $data['detail']['spesifikasi']):null;
		$data['namapo'] = $this->GlobalModel->getData('master_jenis_po',null);
		$data['jenis']=$this->GlobalModel->getData('master_jenis_kaos',array());
		$data['polama']=$this->GlobalModel->getData2('produksi_po',array('hapus'=>0));
		$data['page']=$this->page.'editpo';
		$data['batal']=BASEURL.'Kelolapo/produksipo';
		$data['editsave']=BASEURL.'Kelolapo/produksipoedit_save';
		$this->load->view($this->layout,$data);
	}

	public function produksipoedit_save(){
		$data=$this->input->post();


		$update=array(
			'kode_artikel'=>$data['kode_artikel'],
			'jenis_po'	=>$data['jenis_po'],
			'nama_hpp' =>$data['nama_hpp'],
			'kode_po'	=>$data['kode_po'],
			'serian'	=>$data['serian'],
			'harga_satuan'=>$data['harga_satuan'],
			'nama_po'=>$data['namaPO'],
			'idpolama'=>$data['idpolama'],
			'validasi'=>$data['validasi'],
			'jenis_uk'=>$data['jenis_uk'],
			'type'=>$data['type'],
			//'spesifikasi'=>$spesifikasi,
		);
		$where=array(
			'id_produksi_po'=>$data['id'],
		);
		$this->db->update('produksi_po',$update,$where);
		user_activity(callSessUser('id_user'),1,' edit kode po '.$data['kode_po']);
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect(BASEURL.'Kelolapo/produksipo?&kode_po='.$data['id'].'-'.$data['kode_po']);
	}

	public function spesifikasi(){
		$data=array();
		$data['n']=1;
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		if(isset($get['jenis_po'])){
			$jenis_po=$get['jenis_po'];
		}else{
			$jenis_po=null;
		}
		$filter=array(
			'kode_po'=>$kode_po,
			'jenis_po'=>$jenis_po,
		);
		$url='';
		if(isset($get['kode_po'])){
			$url.='&kode_po='.$get['kode_po'];
		}
		if(isset($get['jenis_po'])){
			$url.='&jenis_po='.$get['jenis_po'];
		}
		$this->load->database();
		$data['jenis']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$jumlah_data = $this->GlobalModel->jumlah_data_where('produksi_po',$filter);
		$this->load->library('pagination');
		
		$data['po']=array();
		//$results = $this->GlobalModel->datapo('produksi_po',$config['per_page'],$from,$filter);
		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";

		if(!empty($kode_po)){
			$sql.=" AND id_produksi_po='$kode_po' ";
		}

		if(!empty($jenis_po)){
			$sql.=" AND nama_po='$jenis_po' ";
		}

		$sql.=" ORDER BY updated_date DESC LIMIT 20";
		$results = $this->GlobalModel->queryManual($sql);
		foreach($results as $result){
			$action=array();
			//if($result['status']==0){
				$action[] = array(
					'text' => '<i class="fa fa-pencil"></i>&nbsp;Edit',
					'href' =>  BASEURL.'kelolapo/spesifikasiedit/'.$result['id_produksi_po'],
				);	
			//}
			
			// $action[] = array(
			// 	'text' => '<i class="fa fa-eye"></i>&nbsp;Detail',
			// 	'href' =>  BASEURL.'kelolapo/produksipodetail/'.$result['id_produksi_po'],
			// );
			$progress=$this->GlobalModel->getDataRow('proggresion_po',array('id_proggresion_po'=>$result['id_proggresion_po']));
			$data['po'][]=array(
				'id_produksi_po'=>$result['id_produksi_po'],
				'kode_artikel'=>$result['kode_artikel'],
				'kode_po'=>$result['kode_po'],
				'nama_po'=>$result['nama_po'],
				'jenis_po'=>$result['jenis_po'],
				'gambar1' => $result['gambar_po'],
				'gambar2' => $result['gambar_po2'],
				'kategori'=>$result['kategori_po'],
				'tanggal'=>date('d-m-Y',strtotime($result['created_date'])),
				'status'=>$result['status'],
				//'nama_progress'=>$progress['nama_progress'],
				'nama_progress'=>null,
				'action'=>$action,
			);
		}
		$data['gbr']=1;
		$data['page']='newtheme/page/kelolapo/polist';
		$data['title']='Master Kode PO';
		$data['tambah']=BASEURL.'Kelolapo/spesifikasi';
		$data['action']=BASEURL.'Kelolapo/spesifikasi';
		$data['url']=BASEURL.'Kelolapo/spesifikasi';
		$data['namaPO']	= $this->GlobalModel->getData('produksi_po',null);
		$data['progress'] = $this->GlobalModel->getData('proggresion_po',null);
		$data['JenisPo'] = $this->GlobalModel->getData('master_jenis_po',null);
		$data['jenisKaos'] = $this->GlobalModel->getData('master_jenis_kaos',null);
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');
	}

	public function spesifikasiedit($kode_po){
		$data=[];
		$data['title']='Edit PO ';
		$data['design']=1;
		$data['detail']=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$kode_po));
		$data['spek']	= $this->GlobalModel->GetData('spesifikasi_gambar_po',array('idpo'=>$kode_po));
		$data['title'].=$data['detail']['kode_po'];
		$data['namapo'] = $this->GlobalModel->getData('master_jenis_po',null);
		$data['jenis']=$this->GlobalModel->getData('master_jenis_kaos',array());
		$data['page']=$this->page.'editpo';
		$data['batal']=BASEURL.'Kelolapo/spesifikasi';
		$data['editsave']=BASEURL.'Kelolapo/spesifikasi_edit_save';
		$this->load->view($this->layout,$data);
	}

	public function submitImageHppsat()
	{
		$config['upload_path']          = './uploads/hpp/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $post = $this->input->post();
        $po=$this->GlobalModel->GetDataRow('produksi_po',array('kode_po'=>$post['kode_po']));
		$kodepo=$po['id_produksi_po'];

        $this->load->library('upload', $config);
        $this->upload->do_upload('gambarPO1');
        $fileName = 'uploads/hpp/'.$this->upload->data('file_name');
        $this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kode_po']),array('gambar_po'=>$fileName));
		user_activity(callSessUser('id_user'),1,' submit gambar kode po '.$post['kode_po']);
        $this->session->set_flashdata('msg','Data berhasil diupdate');
        redirect(BASEURL.'Kelolapo/spesifikasiedit/'.$kodepo);
	}

	public function submitImageHppdua()
	{
		$config['upload_path']          = './uploads/hpp/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $post = $this->input->post();
        $po=$this->GlobalModel->GetDataRow('produksi_po',array('kode_po'=>$post['kode_po']));
		$kodepo=$po['id_produksi_po'];
        $this->load->library('upload', $config);
        $this->upload->do_upload('gambarPO2');
        $fileName = 'uploads/hpp/'.$this->upload->data('file_name');
        $this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['kode_po']),array('gambar_po2'=>$fileName));
		user_activity(callSessUser('id_user'),1,' submit gambar kode po '.$post['kode_po']);
        $this->session->set_flashdata('msg','Data berhasil diupdate');
        redirect(BASEURL.'Kelolapo/spesifikasiedit/'.$kodepo);
	}

	public function spesifikasi_edit_save(){
		$data=$this->input->post();
		//pre($data);
		/*
		$spesifikasi = '<b>Atasan</b><br>,<br>'.!empty($data['sablon_tangan'])?$data['sablon_tangan']:'...,'.',<br>';
		$spesifikasi .= !empty($data['sablon_bdepan'])?$data['sablon_bdepan']:'...,'.',<br>';
		$spesifikasi .= !empty($data['sablon_bbelakang'])?$data['sablon_bbelakang']:'...,'.',<br>';
		$spesifikasi .= !empty($data['sablon_mangkok'])?$data['sablon_mangkok']:'...,'.',<br>';
		$spesifikasi .= !empty($data['sablon'])?$data['sablon']:'...,'.',<br>';
		$spesifikasi .= !empty($data['bordir_tangan'])?$data['bordir_tangan']:'...,'.',<br>';
		$spesifikasi .= !empty($data['bordir_bdepan'])?$data['bordir_bdepan']:'...,'.',<br>';
		$spesifikasi .= !empty($data['bordir_bbelakang'])?$data['bordir_bbelakang']:'...,'.',<br>';
		$spesifikasi .= !empty($data['bordir_mangkok'])?$data['bordir_mangkok']:'...,'.',<br>';
		$spesifikasi .= '<br><b>Bawahan</b>,<br>'.!empty($data['bawahan_celana'])?$data['bawahan_celana']:'...,'.',<br>';
		$spesifikasi .= !empty($data['bawahan_bordir_celana'])?$data['bawahan_bordir_celana']:'...,'.',<br>';

		$update=array(
			'spesifikasi'=>$spesifikasi,
		);
		$where=array(
			'id_produksi_po'=>$data['id'],
		);
		$this->db->update('produksi_po',$update,$where);*/
		$this->db->delete('spesifikasi_gambar_po',array('idpo'=>$data['id']));
		foreach($data['kolom'] as $k){
			$insert = array(
				'idpo' => $data['id'],
				'kolom' => $k['kolom'],
				'isi'	=> $k['isi'],
				'date_input' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('spesifikasi_gambar_po',$insert);
		}
		$u = array('updated_date'=> date('Y-m-d H:i:s'));
		$this->db->update('produksi_po',$u,array('id_produksi_po'=>$data['id']));
		$this->session->set_flashdata('msg','Data berhasil diupdate');
        redirect(BASEURL.'Kelolapo/spesifikasiedit/'.$data['id']);
	}
	public function produksipodetail($kode_po){
		$data=[];
		$data['title']='Detail PO ';
		$data['detail']=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$kode_po));
		$data['page']='newtheme/page/kelolapo/rincianpo';
		$data['batal']=BASEURL.'Kelolapo/produksipo';
		$this->load->view($this->layout,$data);
	}

	public function kirimsetoredit($kode_po,$idKelola){
		$data=[];
		$data['title']='Kirim Setor Edit';
		$data['poProd']	= $this->GlobalModel->queryManualRow('SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po JOIN konveksi_buku_potongan kbp ON kks.kode_po=kbp.kode_po WHERE kks.kode_po="'.$kode_po.'" AND kks.id_kelolapo_kirim_setor='.$idKelola.'');
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt' => $data['poProd']['id_master_cmt']));
		$data['masterCmt'] = $this->GlobalModel->getDataRow('master_cmt_job',array('id_master_cmt_job' => $data['poProd']['id_master_cmt_job']));
		$data['progress'] = $this->GlobalModel->getData('master_progress',null);
		$data['parent']	= $this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$data['atas'] = $this->GlobalModel->getData('kelolapo_kirim_setor_atas',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$data['bawah'] = $this->GlobalModel->getData('kelolapo_kirim_setor_bawah',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$data['listcmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0));
		$data['listjob']=$this->GlobalModel->getData('master_job',array('hapus'=>0));
		$data['page']='kelolapo/kirimsetorpotongan/edit';
		$data['action']=BASEURL.'kelolapo/kirimsetoreditsave';
		$this->load->view($this->layout,$data);
	}

	public function kirimsetorhapus($kode_po,$idKelola){
		$data=[];
		$data['title']='Kirim Setor Hapus';
		$data['poProd']	= $this->GlobalModel->queryManualRow('SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po WHERE kks.kode_po="'.$kode_po.'" AND kks.id_kelolapo_kirim_setor='.$idKelola.'');
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt' => $data['poProd']['id_master_cmt']));
		$data['masterCmt'] = $this->GlobalModel->getDataRow('master_cmt_job',array('id_master_cmt_job' => $data['poProd']['id_master_cmt_job']));
		$data['progress'] = $this->GlobalModel->getData('master_progress',null);
		$data['parent']	= $this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$data['atas'] = $this->GlobalModel->getData('kelolapo_kirim_setor_atas',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$data['bawah'] = $this->GlobalModel->getData('kelolapo_kirim_setor_bawah',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$data['listcmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0));
		$data['listjob']=$this->GlobalModel->getData('master_job',array('hapus'=>0));
		$data['page']='kelolapo/kirimsetorpotongan/hapus';
		$data['action']=BASEURL.'kelolapo/kirimsetorhapussave';
		$this->load->view($this->layout,$data);
	}

	public function kirimsetorhapussave()
	{
		$post = $this->input->post();
		$proses=$this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('id_kelolapo_kirim_setor'=>$post['kodeSetoran']));
		//pre($proses);
		//$cmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$post['cmt']));
		//$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$post['job']));
		//pre($post);
		$update=array(
			//'create_date'=>$post['create_date'],
			//'nama_cmt'=>$cmt['cmt_name'],
			//'id_master_cmt'=>$post['cmt'],
			'hapus'=>1,
		);
		//pre($update);
		if($proses['kategori_cmt']=='JAHIT'){
			if($proses['progress']=='KIRIM'){
				$this->db->update('kirimcmt_detail',$update,array('kode_po'=>$post['kode_po']));
			}

			if($proses['progress']=='SETOR'){
				//$this->GlobalModel->QueryManual("UPDATE setorcmt SET totalsetor=totalsetor-".$proses['qty_tot_pcs']." WHERE id='".$proses['kode_nota_cmt']."' ");
				$this->db->update('setorcmt_detail',$update,array('kode_po'=>$post['kode_po']));
			}
		}
		$this->db->update('kelolapo_kirim_setor',$update,array('id_kelolapo_kirim_setor'=>$post['kodeSetoran']));
		user_activity(callSessUser('id_user'),1,' hapus KLO '.$post['kode_po']);
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Kelolapo/kirimsetorcmt?&kode_po='.$post['kode_po']);
	}

	public function kirimsetoreditsave()
	{
		$post = $this->input->post();
		$cmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$post['cmt']));
		$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$post['job']));
		//pre($job);
		$update=array(
			'create_date'=>$post['create_date'],
			'nama_cmt'=>$cmt['cmt_name'],
			'id_master_cmt'=>$post['cmt'],
			'id_master_cmt_job'	=>$post['job'],
			'cmt_job_price'	=>$job['harga'],
		);
		//pre($update);
		$this->db->update('kelolapo_kirim_setor',$update,array('id_kelolapo_kirim_setor'=>$post['kodeSetoran']));
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Kelolapo/kirimsetorcmt?&kode_po='.$post['kode_po']);
	}
	public function kirimsetoreditsaveall()
	{
		$post = $this->input->post();
		//pre($post);
		$dataKelola = $this->GlobalModel->getData('kelolapo_kirim_setor',array('kode_po'=>$post['namaPo']));
			$jmlBaw = 0; 
			$jmlAtas = 0;
			$jmlBanke = 0;
			$jmlReject = 0;
			$jmlHilang = 0;
			$jmlClaim = 0;
			$jmlBankeBw = 0;
			$jmlRejectBw = 0;
			$jmlHilangBw = 0;
			$jmlClaimBw = 0;
		if (isset($post['qtyBankeAtas']) && isset($post['qtyRejectAtas'])) {
			foreach ($post['bagianAtas'] as $key => $bagianAtas) {
					$jmlAtas += $post['jmlAtas'][$key];
					$jmlBanke += $post['qtyBankeAtas'][$key];
					$jmlReject += $post['qtyRejectAtas'][$key];
					$jmlHilang += $post['qtyHilangAtas'][$key];
					$jmlClaim += $post['qtyClaimAtas'][$key];
				}
			} else {
			foreach ($post['bagianAtas'] as $key => $bagianAtas) {
				$jmlAtas += $post['jmlAtas'][$key];
			}
		}	
		if (isset($post['bagianBwh'])) {
			if (isset($post['qtyBankeBwh']) && isset($post['qtyRejectBwh'])) {
				foreach ($post['bagianBwh'] as $key => $bagianBwh) {
					$jmlBaw += $post['jmlBwh'][$key];
					$jmlBankeBw += $post['qtyBankeBwh'][$key];
					$jmlRejectBw += $post['qtyRejectBwh'][$key];
					$jmlHilangBw += $post['qtyHilangBwh'][$key];
					$jmlClaimBw += $post['qtyClaimBwh'][$key];
				}
			} else {
				foreach ($post['bagianBwh'] as $key => $bagianBwh) {
					$jmlBaw += $post['jmlBwh'][$key];
				}
			}
		}
		
		$jumlahTOtal = $jmlBaw + $jmlAtas;
		$jumlahGrandTotal = $jumlahTOtal;
		// pre($dataKelola);
		// pre($post);

		if (empty($dataKelola[0]['qty_tot_pcs'])) {
			$statusKeterang = 'AMAN';
		} else {
			if ($dataKelola[0]['qty_tot_pcs'] == $post['jumlahPotPcs']) {
				$statusKeterang = 'AMAN';
			} else {
				$statusKeterang = 'KURANG';
			}
		}

		// pre($jumlahGrandTotal);
		if ($jumlahGrandTotal == $post['jumlahPotPcs']) {
			$explodeCmtName = explode('-',$post['cmtName']);
			$explodeCmtJob = explode('-',$post['cmtJob']);

			$dataInput = $this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po' => $post['namaPo'],'id_master_cmt' => $explodeCmtName[0] ,'progress' => $post['progress']));
			
			$dataInsertParent = array(
				'nama_cmt'		=>	$explodeCmtName[1],
				'id_master_cmt'	=>	$explodeCmtName[0],
				'id_master_cmt_job'=> $explodeCmtJob[0],
				'cmt_job_price'	=>	$explodeCmtJob[1],
				'kategori_cmt'	=>	$post['cmtKat'],
				'kode_po'		=>	$post['namaPo'],
				'qty_tot_pcs'	=>	$jumlahGrandTotal,
				'create_date'	=>	$post['tanggal'],
				'qty_tot_atas'	=>	$jmlAtas,
				'qty_tot_bawah'	=>	$jmlBaw,
				'progress'		=>	$post['progress'],
				'keterangan'	=>	$statusKeterang,
				'qty_bangke'	=>	$jmlBanke + $jmlBankeBw,
				'qty_reject'	=>	$jmlReject + $jmlRejectBw,
				'qty_hilang'	=>	$jmlHilang + $jmlHilangBw,
				'qty_claim'		=>	$jmlClaim + $jmlClaimBw,
				'tglinput'		=>date('Y-m-d'),

			);
			if (empty($dataInput)) {
				if ($post['cmtKat'] == "SABLON") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"SABLON",'updated_date'=>$post['tanggal']));
				} else if ($post['cmtKat'] == "BORDIR") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"BORDIR",'updated_date'=>$post['tanggal']));
				} elseif ($post['cmtKat'] == "JAHIT") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"JAHIT",'updated_date'=>$post['tanggal']));
				}

				$this->GlobalModel->insertData('kelolapo_kirim_setor',$dataInsertParent);
				$lastIdParent = $this->db->insert_id();
			} else {
				
				if (empty($post['kodeSetoran'])) {
					$this->session->set_flashdata('msg','INPUTAN SUDAH ADA, CEK DI VIEW DATA PENGECEKAN <audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/mandrakerja.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
					redirect(BASEURL.'kelolapo/kirimsetortambah/'.$post['namaPo']);
				} else {
					$this->session->set_flashdata('msg','INPUT NYA SANTAI AJA DONG, JANGAN DI SPAM!!!, SUDAH DI INPUT!  <audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/kunti.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
					redirect(BASEURL.'kelolapo/kirimsetorcek'.'/'.$post['namaPo'].'/'.$post['kodeSetoran']);
				}

			}
			

			foreach ($post['bagianAtas'] as $key => $bagianAtas) {
				$dataInserted = array(
					'kode_po'					=>	$post['namaPo'],
					'bagian_potongan_atas'		=>	$bagianAtas,
					'warna_potongan_atas'		=>	$post['warnaAtas'][$key],
					'jumlah_potongan'		=>	$post['jmlAtas'][$key],
					'keterangan_potongan'		=>	$post['keteranganAts'][$key],
					'created_date'		=>	$post['tanggal'],
					'qty_bangke_atas'	=>	(isset($post['qtyBankeAtas'][$key]) ? $post['qtyBankeAtas'][$key]:""),
					'id_kelolapo_kirim_setor'	=>	$lastIdParent,
					'qty_reject_atas'	=> (isset($post['qtyRejectAtas'][$key]) ? $post['qtyRejectAtas'][$key]:""),
					'qty_hilang_atas'	=> (isset($post['qtyHilangAtas'][$key]) ? $post['qtyHilangAtas'][$key]:""),
					'qty_claim_atas'	=> (isset($post['qtyClaimAtas'][$key]) ? $post['qtyClaimAtas'][$key]:"") 
				);
				$this->GlobalModel->insertData('kelolapo_kirim_setor_atas',$dataInserted);
			}

			if(isset($post['bagianBwh'])){
				
				foreach ($post['bagianBwh'] as $key => $bagianBwh) {
					$dataBawah = array(
						'kode_po'				=>	$post['namaPo'],
						'bagian_potongan_bawah'	=>	$bagianBwh,
						'warna_potongan_bawah'	=>	$post['warnaBwh'][$key],
						'jumlah_potongan'	=>	$post['jmlBwh'][$key],
						'keterangan_potongan'	=>	$post['keteranganBwh'][$key],
						'created_date'	=>	$post['tanggal'],
						'qty_bangke_bwh'	=>	(isset($post['qtyBankeBwh'][$key]) ? $post['qtyBankeBwh'][$key]:""),
						'id_kelolapo_kirim_setor'	=>	$lastIdParent,
						'qty_reject_bwh'	=>  (isset($post['qtyRejectBwh'][$key]) ? $post['qtyRejectBwh'][$key]:""),
						'qty_hilang_bwh'	=>  (isset($post['qtyHilangBwh'][$key]) ? $post['qtyHilangBwh'][$key]:""),
						'qty_claim_bwh'	=>  (isset($post['qtyClaimBwh'][$key]) ? $post['qtyClaimBwh'][$key]:"")
					);
					
					$this->GlobalModel->insertData('kelolapo_kirim_setor_bawah',$dataBawah);
				}
			}

		redirect(BASEURL.'kelolapo/kirimsetorcmt');	

		} else {
			$this->session->set_flashdata('msg','PERHATIKAN JUMLAH NYA!, BELAJAR NGITUNG LAGI SANA!!! <audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/apaantuh.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
			if (empty($post['kodeSetoran'])) {
				redirect(BASEURL.'kelolapo/kirimsetortambah/'.$post['namaPo']);
			} else {
				redirect(BASEURL.'kelolapo/kirimsetorcek'.'/'.$post['namaPo'].'/'.$post['kodeSetoran']);
			}

		}
			
		
	}

	public function produksipo(){
		$data=array();
		$data['n']=1;
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		if(isset($get['jenis_po'])){
			$jenis_po=$get['jenis_po'];
		}else{
			$jenis_po=null;
		}
		$filter=array(
			'kode_po'=>$kode_po,
			'jenis_po'=>$jenis_po,
		);
		$url='';
		if(isset($get['kode_po'])){
			$url.='&kode_po='.$get['kode_po'];
		}
		if(isset($get['jenis_po'])){
			$url.='&jenis_po='.$get['jenis_po'];
		}
		$this->load->database();
		$data['jenis']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$jumlah_data = $this->GlobalModel->jumlah_data_where('produksi_po',$filter);
		$this->load->library('pagination');
		$config['base_url'] = BASEURL.'Kelolapo/produksipo?'.$url;
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 20;
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
		 $config['full_tag_close']   = '</ul></nav></div>';
		 $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $config['page_query_string'] = TRUE;
        $config['query_string_segment']='per_page';
		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);		
		
		$data['po']=array();
		//$results = $this->GlobalModel->datapo('produksi_po',$config['per_page'],$from,$filter);
		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";

		if(!empty($kode_po)){
			$sql.=" AND id_produksi_po='$kode_po' ";
		}

		if(!empty($jenis_po)){
			$sql.=" AND nama_po='$jenis_po' ";
		}

		$sql.=" ORDER BY id_produksi_po DESC ";
		$results = $this->GlobalModel->queryManual($sql);
		foreach($results as $result){
			$action=array();
			//if($result['status']==0){
				$action[] = array(
					'text' => '<i class="fa fa-pencil"></i>&nbsp;Edit',
					'href' =>  BASEURL.'kelolapo/produksipoedit/'.$result['id_produksi_po'],
				);	
			//}
			
			$action[] = array(
				'text' => '<i class="fa fa-eye"></i>&nbsp;Detail',
				'href' =>  BASEURL.'kelolapo/produksipodetail/'.$result['id_produksi_po'],
			);
			$progress=$this->GlobalModel->getDataRow('proggresion_po',array('id_proggresion_po'=>$result['id_proggresion_po']));
			$data['po'][]=array(
				'id_produksi_po'=>$result['id_produksi_po'],
				'kode_artikel'=>$result['kode_artikel'],
				'kode_po'=>$result['kode_po'],
				'nama_po'=>$result['nama_po'],
				'jenis_po'=>$result['jenis_po'],
				'kategori'=>$result['kategori_po'],
				'tanggal'=>date('d-m-Y',strtotime($result['created_date'])),
				'status'=>$result['status'],
				//'nama_progress'=>$progress['nama_progress'],
				'nama_progress'=>null,
				'action'=>$action,
			);
		}
		$data['page']='newtheme/page/kelolapo/polist';
		$data['title']='Master Kode PO';
		$data['tambah']=BASEURL.'Kelolapo/addpo';
		$data['action']=BASEURL.'Kelolapo/posave';
		$data['url']=BASEURL.'Kelolapo/produksipo';
		$data['namaPO']	= $this->GlobalModel->getData('produksi_po',null);
		$data['progress'] = $this->GlobalModel->getData('proggresion_po',null);
		$data['JenisPo'] = $this->GlobalModel->getData('master_jenis_po',null);
		$data['jenisKaos'] = $this->GlobalModel->getData('master_jenis_kaos',null);
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');
	}

	public function addpo()
	{
		$data=[];
		$data['title']='Tambah Kode PO Baru';
		$data['namaPO']	= $this->GlobalModel->getData('master_nama_po',null);
		$data['progress'] = $this->GlobalModel->getData('proggresion_po',null);
		$data['JenisPo'] = $this->GlobalModel->getData('master_jenis_po',null);
		$data['jenisKaos'] = $this->GlobalModel->getData('master_jenis_kaos',null);
		$data['page']='newtheme/page/kelolapo/addpo';
		$data['action']=BASEURL.'Kelolapo/posave';
		$data['batal']=BASEURL.'Kelolapo/produksipo';
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');
	}


	public function posave()
	{
		$post  = $this->input->post();
		$po=trim(strtoupper($post['namaPO']).$post['kodePO']);
		$cekpo = $this->GlobalModel->GetData('produksi_po',array('kode_po'=>$po));
		$cekart = $this->GlobalModel->GetData('produksi_po',array('kode_artikel'=>$post['artikel']));

		$people = array("SKF", "simulasi SKF","simulasi");
		if (in_array($post['namaPO'], $people)){
			$cekart=null;
		}
		//pre($cekart);

		if(empty($cekpo) && empty($cekart) ){
			$dataInsert = array(
				'kode_po'	=> str_replace(" ","",$po),
				'nama_hpp'	=> str_replace(" ","",$po),
				//'kode_po'	=> strtoupper($post['kodePO']),
				'kategori_po'	=> $post['kategoriPo'],
				'nama_po'	=> $post['namaPO'],
				'kode_artikel'	=> $post['artikel'],
				//'id_proggresion_po'	=> $post['progress'],
				'id_proggresion_po'	=>1,
				'created_date'	=> $post['tanggalProd'],
				'jenis_po'	=> $post['jenisPo'],
				'status'=>0,
				'tahun'=>date('Y').date('Y',strtotime("+1 year")),
				'serian'=>$post['serian'],
				'jenis_uk'=>$data['jenis_uk'],
				'type'=>$data['type'],
			);
			user_activity(callSessUser('id_user'),1,' input kode po baru '.$po);
			$this->GlobalModel->insertData('produksi_po',$dataInsert);
			$this->session->set_flashdata('msg','Data berhasil ditambah');
			redirect(BASEURL.'Kelolapo/produksipo');
		}else{
			$resp= json_encode($post);
			$this->session->set_flashdata('gagal','Data gagal disimpan'.$resp);
			redirect(BASEURL.'Kelolapo/addpo');
		}
		
	}


	public function editgambar($kodepo){
		$data=[];
		$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$kodepo));
		$kodepo=$po['kode_po'];
		$data['title']='Edit Gambar '.strtoupper($kodepo);
		$data['kode_po']=$kodepo;
		$data['prods']=$this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po'=>$kodepo));
		$data['action']=BASEURL.'kelolapo/editgambarsimpan';
		$data['kembali']=BASEURL.'kelolapo/bukupotongan';
		$data['page']='kelolapo/bukupotongan/editgambar';
		$this->load->view('newtheme/page/main',$data);
	}

	public function editgambarsimpan(){
		$data=$this->input->post();
		$config['upload_path']          = './document/image/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $this->load->library('upload', $config);
		
		if(!empty($_FILES['gbrbahan']['name'])){
	        $this->upload->do_upload('gbrbahan');
	        $imageGambar = 'document/image/'.$this->upload->data('file_name');
	        $up=array(
	        	'sample_bahan_utama_img'=>BASEURL.$imageGambar,
	        );
	        $this->db->update('konveksi_buku_potongan',$up,array('kode_po'=>$data['kode_po']));
		}

		if(!empty($_FILES['gbrbahan2']['name'])){
	        $this->upload->do_upload('gbrbahan2');
	        $imageGambar2 = 'document/image/'.$this->upload->data('file_name');
	        $up=array(
	        	'sample_bahan_utama_img2'=>BASEURL.$imageGambar2,
	        );
	        $this->db->update('konveksi_buku_potongan',$up,array('kode_po'=>$data['kode_po']));
		}

		if(!empty($_FILES['gbrbahanvar1']['name'])){
	        $this->upload->do_upload('gbrbahanvar1');
	        $imageGambar3 = 'document/image/'.$this->upload->data('file_name');
	        $up=array(
	        	'sample_bahan_variasi_img'=>BASEURL.$imageGambar3,
	        );
	        $this->db->update('konveksi_buku_potongan',$up,array('kode_po'=>$data['kode_po']));
		}

		if(!empty($_FILES['gbrbahanvar2']['name'])){
	        $this->upload->do_upload('gbrbahanvar2');
	        $imageGambar4 = 'document/image/'.$this->upload->data('file_name');
	        $up=array(
	        	'sample_bahan_variasi_img2'=>BASEURL.$imageGambar4,
	        );
	        $this->db->update('konveksi_buku_potongan',$up,array('kode_po'=>$data['kode_po']));
		}
		user_activity(callSessUser('id_user'),1,' edit gambar po '.$data['kode_po']);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Kelolapo/editgambar/'.$data['kode_po']);
	}

	public function bukupotongan()
	{
		$results=array();
		$data=array();
		$data['title']='Buku Potongan';
		$data['tambah']='bukupotonganTambah';
		$data['potongan']=array();
		$user=user();
		$edit=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
		}
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
		if(isset($get['kode_po'])){
			$kode_po=$get['kode_po'];
		}else{
			$kode_po=null;
		}
		if(isset($get['refpo'])){
			$refpo=$get['refpo'];
		}else{
			$refpo=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$j=1;
		$sql="SELECT kbp.*,kbp.kode_po as nama_po,kbp.created_date as tanggalProd, kbp.tim_potong_potongan FROM konveksi_buku_potongan kbp WHERE id_potongan > 0";
		if(empty($kode_po)){
			if(!empty($tanggal1)){
				$sql.=" AND date(created_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}else{
			$sql.=" AND kbp.kode_po='".$kode_po."' ";
		}
		if(!empty($refpo)){
			$sql.=" AND refpo='".$refpo."' ";
		}
		$sql.=" GROUP BY kbp.idpo ";
		$sql.=" ORDER BY kbp.waktuinput DESC ";
		$sql.=" LIMIT 20 ";
		$results	= $this->GlobalModel->queryManual($sql);
		$cp=null;
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		foreach($results as $result){
			$cp=$this->GlobalModel->getDataRow('kelolapo_pengecekan_potongan',array('kode_po'=>$result['kode_po']));
			$action=array();
			
			if($edit==1){
				$action[] = array(
					'text' => '&nbsp;Edit',
					'href' => BASEURL.'kelolapo/bukupotonganEdit/'.$result['idpo'],
				);	
			}
			

			$action[] = array(
				'text' => '&nbsp;Detail',
				'href' => BASEURL.'kelolapo/bukupotonganDetail/'.$result['idpo'],
			);

			//if(empty($cp)){
				// $action[] = array(
				// 	'text' => '&nbsp;Pengecekan',
				// 	'href' => BASEURL.'kelolapo/formpengecekanpotonganEdit/'.$result['id_potongan'],
				// );
			//}

			// $action[] = array(
			// 	'text' => 'Kirim Sablon',
			// 	'href' => BASEURL.'kelolapo/kirimsetortambah/'.$result['idpo'].'',
			// );

			$action[] = array(
				'text' => 'Edit Gambar',
				'href' => BASEURL.'kelolapo/editgambar/'.$result['idpo'].'',
			);

			$action[] = array(
				'text' => 'Hapus',
				'href' => BASEURL.'kelolapo/bukupotonganhapus/'.$result['id_potongan'].'',
			);


			if($result['status']==0){
				$status="Belum dicek";
			}else if($result['status']==1){
				$status="Pengecekan";
			}else if($result['status']==2){
				$status="Pengiriman Ke CMT";
			}
			$timpotong=$this->GlobalModel->getDataRow('timpotong',array('id'=>$result['tim_potong_potongan']));
			$data['potongan'][]=array(
				'no'=>$j,
				'kode_po'=>$result['kode_po'],
				'nama_po'=>$result['nama_po'],
				'refpo'=>$result['refpo'],
				'dz'=>number_format($result['hasil_lusinan_potongan'],2),
				'pcs'=>$result['hasil_pieces_potongan'],
				'tim_potong_potongan'=>$timpotong['nama']==null?$result['tim_potong_potongan']:$timpotong['nama'],
				'tanggalProd'=>date('d-m-Y',strtotime($result['tanggalProd'])),
				'status'=>$status,
				'action'=>$action,
			);

			$j++;
		}
		$data['jenispo']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$data['page']='newtheme/page/kelolapo/bukupotongan_list';
		$this->load->view('newtheme/page/main',$data);
	}

	public function bukupotonganTambah()
	{
		$data=array();
		$data['title']='Tambah buku potongan';
		$data['poProd'] = $this->GlobalModel->getData('produksi_po',null);
		$data['timpotong']= $this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$data['mastersize']= $this->GlobalModel->getData('mastersize_potongan',array('hapus'=>0));
		$data['tgl']=Date('Y-m-d');
		$data['action']=BASEURL.'kelolapo/bukupotonganTambahOnCreate';
		$data['page']='newtheme/page/kelolapo/bukupotongan_add';
		$this->load->view('newtheme/page/main',$data);
	}

	public function searchPO(){
		$post = $this->input->post();
		$kode_po=$post['kodepo'];
		$hasil=array();
		$bahans=array();
		//$bahans=$this->GlobalModel->getData("gudang_bahan_keluar",array('kode_po'=>$kodepo,'hapus'=>0,'bahan_kategori'=>'UTAMA','bahan_kategori'=>'VARIASI'));
		//pre($post);
		//$bahans=$this->GlobalModel->QueryManual("SELECT * FROM gudang_bahan_keluar WHERE hapus=0 AND kode_po='$kode_po' AND bahan_kategori LIKE 'UTAMA%' OR bahan_kategori LIKE 'VARIASI%' ");
		$bahans=$this->GlobalModel->QueryManual("SELECT * FROM gudang_bahan_keluar WHERE hapus=0 AND kode_po='$kode_po' AND bahan_kategori LIKE '%UTAMA%' AND nama_item_keluar NOT IN (SELECT kode_bahan_potongan FROM konveksi_buku_potongan_utama WHERE hapus=0 AND kode_po='$kode_po' ) AND warna_item_keluar NOT IN (SELECT warna_potongan FROM konveksi_buku_potongan_utama WHERE hapus=0 AND kode_po='$kode_po' ) ");
		foreach($bahans as $b){
			echo "<tr>";
			echo "<td><input type='hidden' value='-' class='form-control' name='bidangBahan[]'></td>";
			echo "<td><input type='hidden' value='".$b['warna_item_keluar']."' class='form-control' name='warna[]'>".$b['warna_item_keluar']."</td>";
			echo "<td><input type='hidden' value='".$b['nama_item_keluar']."' class='form-control' name='kodeBahan[]'>".$b['nama_item_keluar']."</td>";
			echo "<td><input type='hidden' value='".$b['ukuran_item_keluar']."' class='form-control' name='beratBahan[]'>".$b['ukuran_item_keluar']."</td>";
			echo "<td><input type='number' value='0' class='' name='sisaBahan[]'></td>";
			echo "<td><input type='text' value='0' class='' name='pemakaianBahankg[]'></td>";
			echo "<td><input type='text' value='0' class='' name='banyakLapis[]'></td>";
			echo '<td><i class="fa fa-trash remove"></i></td>';
			echo "</tr>";			
		}
	}
	
	public function searchPObahan(){
		$post = $this->input->post();
		$kode_po=$post['kodepo'];
		$hasil=array();
		$bahans=array();
		//$bahans=$this->GlobalModel->getData("gudang_bahan_keluar",array('kode_po'=>$kodepo,'hapus'=>0,'bahan_kategori'=>'CELANA'));
		$bahans=$this->GlobalModel->QueryManual("SELECT * FROM gudang_bahan_keluar WHERE hapus=0 AND kode_po='$kode_po' AND bahan_kategori LIKE '%CELANA%' AND nama_item_keluar NOT IN (SELECT kode_bahan_potongan FROM konveksi_buku_potongan_variasi WHERE hapus=0 AND kode_po='$kode_po' ) AND warna_item_keluar NOT IN (SELECT warna_potongan FROM konveksi_buku_potongan_variasi WHERE hapus=0 AND kode_po='$kode_po' ) ");
		foreach($bahans as $b){
			echo "<tr>";
			echo "<td><input type='hidden' value='-' class='form-control' name='bidangBahanVar[]'></td>";
			echo "<td><input type='hidden' value='".$b['warna_item_keluar']."' class='form-control' name='warnaVar[]'>".$b['warna_item_keluar']."</td>";
			echo "<td><input type='hidden' value='".$b['nama_item_keluar']."' class='form-control' name='kodeBahanVar[]'>".$b['nama_item_keluar']."</td>";
			echo "<td><input type='hidden' value='".$b['ukuran_item_keluar']."' class='form-control' name='beratBahanVar[]'>".$b['ukuran_item_keluar']."</td>";
			echo "<td><input type='number' value='0' class='' name='sisaBahanVar[]'></td>";
			echo "<td><input type='text' value='0' class='' name='pemakaianBahankgVar[]'></td>";
			echo "<td><input type='text' value='0' class='' name='banyakLapisVar[]'></td>";
			echo '<td><i class="fa fa-trash remove"></i></td>';
			echo "</tr>";			
		}
	}

	public function bukupotonganTambahOnCreate($value='')
	{
		$post = $this->input->post();	
		//pre($post);

		if(isset($post['namaPo'])){
			$explode = explode('-',$post['namaPo']);
			$po2022celana = substr($explode[1], 6);
			if(isset($post['refPO'])){
				if(!empty($post['refPO'])){
					$dataCek = $this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po' =>  $explode[1],'refpo'=>$post['refPO']));
				}else{
					$dataCek = $this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po' =>  $explode[1]));	
				}
			}else{
				$dataCek = $this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po' =>  $explode[1]));
			}
			/*
			if(!empty($dataCek)) {
				$pesan='Data Gagal disimpan, Karena inputan dengan PO '.$explode[1].' data sudah ada';
				$this->session->set_flashdata('msg',$pesan);
				redirect(BASEURL.'kelolapo/bukupotonganTambah');
			}*/
			//if (empty($dataCek)) {
				$config['upload_path']          = './document/image/';
		        $config['allowed_types']        = 'gif|jpg|png|jpeg';
		        $this->load->library('upload', $config);
		        $this->upload->do_upload('sempleBhnImg');
		        $imageGambar = 'document/image/'.$this->upload->data('file_name');
		        //resizeImage($imageGambar);

		        // gbr 2
		        $this->upload->do_upload('sempleBhnImg2');
		        $imageGambar2 = 'document/image/'.$this->upload->data('file_name');
		        //resizeImage($imageGambar2);

		        $this->upload->do_upload('sempleBhnImgVar');
		        $imageGambarVar = 'document/image/'.$this->upload->data('file_name');
		        //resizeImage($imageGambarVar);

		        // gbr var 2 
		        $this->upload->do_upload('sempleBhnImgVardua');
		        $imageGambarVar2 = 'document/image/'.$this->upload->data('file_name');
		        //resizeImage($imageGambarVar2);


				$jumBl=0;
				$jumBls=0;
				//$explode = explode('-',$post['namaPo']);
				updateDataProdPO(1,$explode[1]);

				if(isset($post['bidangBahan'])){
					foreach ($post['bidangBahan'] as $key => $bidangBahan) {
						$jumBl += $post['banyakLapis'][$key];
					}	
				}
						

				$jumlahPiecePot = ($jumBl*$post['jumlahGambar']);
				$idpo=$this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$explode[1]));
				$dataInsert = array(
					'idpo'								=> $idpo['id_produksi_po'],
					'kode_po'							=> $explode[1],
					'sample_bahan_utama_img'			=> BASEURL.$imageGambar,
					'sample_bahan_variasi_img'			=> BASEURL.$imageGambarVar,
					'sample_bahan_utama_img2'			=> BASEURL.$imageGambar2,
					'sample_bahan_variasi_img2'			=> BASEURL.$imageGambarVar2,
					'tim_potong_potongan'				=> $post['timPotong'],
					'created_date'						=> $post['tanggal'],
					'pemakaian_bahan_utama'				=> $post['pemakaianBahan'],
					'jumlah_gambar_utama'				=> $post['jumlahGambar'],
					'jumlah_pemakaian_bahan_utama'		=> $post['pemakaianBahan'],
					'panjang_gelaran_potongan_utama'	=> $post['panjangGelaran'],
					'jumlah_pemakaian_bahan_variasi'	=> $post['pemakaianGelaranVariasi'],
					'panjang_gelaran_variasi'			=> $post['panjangGelaranVariasi'],
					'size_potongan'						=> $post['sizeBahan'],
					'created_date'						=> $post['tanggal'],
					'hasil_lusinan_potongan'			=> (($jumBl*$post['jumlahGambar'])/12),
					'hasil_pieces_potongan'				=> (($jumBl*$post['jumlahGambar'])/12) * 12,
					'status'							=>0,
					'refpo'								=>isset($post['refPO'])?$post['refPO']:'-',
					'waktuinput'						=>date('Y-m-d H:i:s'),
				);
				$this->GlobalModel->insertData('konveksi_buku_potongan',$dataInsert);
				$idbukupotongan=$this->db->insert_id();

				if(isset($post['bidangBahan'])){
					foreach ($post['bidangBahan'] as $key => $bidangBahan) {
						$dataPotonganUtama = array(
							'idbukupotongan'			=> $idbukupotongan,
							'idpo'						=> $idpo['id_produksi_po'],
							'kode_po'					=> $explode[1],
							'bidang_bahan_potongan'		=> $bidangBahan,
							'warna_potongan'			=> $post['warna'][$key],
							'kode_bahan_potongan'		=> $post['kodeBahan'][$key],
							'berat_bahan_potongan'		=> $post['beratBahan'][$key],
							'sisa_bahan_potongan'		=> $post['sisaBahan'][$key],
							'pemakaian_bahan_potongan'	=> $post['pemakaianBahankg'][$key],
							'banyak_lapis_potongan'		=> $post['banyakLapis'][$key],
							'created_date'				=> $post['tanggal']
						);
						$this->GlobalModel->insertData('konveksi_buku_potongan_utama',$dataPotonganUtama);
						//$jumBl += $post['banyakLapis'][$key];
					}	
				}
				
				if(isset($post['bidangBahanVar'])){
					foreach ($post['bidangBahanVar'] as $key => $bidangBahanVar) {
						$dataPotonganVariasi = array(
							'idbukupotongan'				=>  $idbukupotongan,
							'idpo'							=> $idpo['id_produksi_po'],
							'kode_po'						=>	$explode[1],
							'bidang_bahan_potongan'			=>	$bidangBahanVar,
							'warna_potongan'				=>	$post['warnaVar'][$key],
							'kode_bahan_potongan'			=>	$post['kodeBahanVar'][$key],
							'berat_bahan_potongan'			=>	$post['beratBahanVar'][$key],
							'sisa_bahan_potongan'			=>	$post['sisaBahanVar'][$key],
							'pemakaian_bahan_potongan'		=>	$post['pemakaianBahankgVar'][$key],
							'banyak_lapis_potongan'			=>	$post['banyakLapisVar'][$key],
							'created_date'					=>	$post['tanggal']
						);
						$this->GlobalModel->insertData('konveksi_buku_potongan_variasi',$dataPotonganVariasi);
						$jumBls += $post['banyakLapisVar'][$key];
						
					}
				}
			
				/*if($explode[0]=="PFK" OR $explode[0]=="BJK" OR $explode[0]=="BJH" OR $explode[0]=="BJF" OR $explode[0]=="PFJ"){
					$up=array(
						'hasil_lusinan_potongan'			=> (($jumBls*$post['jumlahGambar'])/12),
						'hasil_pieces_potongan'				=> (($jumBls*$post['jumlahGambar'])/12) * 12,
					);
					$where=array(
						'kode_po'	=>$explode[1],
					);
					$this->db->update('konveksi_buku_potongan',$up,$where);
				}*/

				if($explode[0]=="PFK" OR $explode[0]=="BJK" OR $explode[0]=="BJH" OR $explode[0]=="BJF" OR $explode[0]=="PFJ"){
					$up=array(
						'hasil_lusinan_potongan'			=> (($jumBls*$post['jumlahGambar'])/12),
						'hasil_pieces_potongan'				=> (($jumBls*$post['jumlahGambar'])/12) * 12,
					);
					$where=array(
						'kode_po'	=>$explode[1],
					);
					$this->db->update('konveksi_buku_potongan',$up,$where);
				}else{
					if($po2022celana == '_2022' ){
						$up=array(
							'hasil_lusinan_potongan'			=> (($jumBls*$post['jumlahGambar'])/12),
							'hasil_pieces_potongan'				=> (($jumBls*$post['jumlahGambar'])/12) * 12,
						);
						$where=array(
							'kode_po'	=>$explode[1],
						);
						$this->db->update('konveksi_buku_potongan',$up,$where);
					}
				}

				if(isset($post['bidangBahanVar'])){
						if($explode[0]=="FBS"){
							$up=array(
								'jumlah_pemakaian_bahan_variasi'	=>$post['pemakaianGelaranVariasi'],
							);
							$where=array(
								'kode_po'	=>$explode[1],
							);
							$this->db->update('konveksi_buku_potongan',$up,$where);
						}
				}
				user_activity(callSessUser('id_user'),1,' input buku potongan dengan id inputan '.$idbukupotongan);
				$this->session->set_flashdata('msg','Data berhasil ditambah');
				redirect(BASEURL.'kelolapo/bukupotongan');
		}else{
			$this->session->set_flashdata('msg','Data Gagal ditambah');
			redirect(BASEURL.'kelolapo/bukupotongan');
		}


	}


	public function bukupotonganhapus($id){
		$this->db->delete('konveksi_buku_potongan',array('id_potongan'=>$id));
		$utama=$this->GlobalModel->GetdataRow('konveksi_buku_potongan_utama',array('idbukupotongan'=>$id));
		if(!empty($utama)){
			$this->db->delete('konveksi_buku_potongan_utama',array('idbukupotongan'=>$id));
		}

		$var=$this->GlobalModel->GetdataRow('konveksi_buku_potongan_variasi',array('idbukupotongan'=>$id));
		if(!empty($var)){
			$this->db->delete('konveksi_buku_potongan_variasi',array('idbukupotongan'=>$id));
		}


		$this->session->set_flashdata('msg','Data Berhasil di hapus');
		redirect(BASEURL.'kelolapo/bukupotongan');
	}

	public function bukupotonganEdit($id='')
	{
		$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$id));
		$id=$po['kode_po'];
		$viewData['title']='Ubah Buku Potongan '.$id;
		$viewData['action']=BASEURL.'Kelolapo/bukupotonganEditOnUpdate';
		$viewData['tgl']=date('Y-m-d');
		$viewData['poProd'] = $this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$id));		
		$viewData['po']	= $this->GlobalModel->getData('produksi_po',null);
		$viewData['bahan'] = $this->GlobalModel->getData('gudang_bahan_keluar',array('kode_po'=>$id));
		$viewData['potongan']	=	$this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po' => $id));
		$viewData['utama']	=	$this->GlobalModel->getData('konveksi_buku_potongan_utama',array('kode_po' => $id));
		$viewData['variasi']	=	$this->GlobalModel->getData('konveksi_buku_potongan_variasi',array('kode_po' => $id));
		//pre($viewData['variasi']);
		$viewData['timpotong']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$viewData['tim']=$this->GlobalModel->getDataRow('timpotong',array('id'=>$viewData['potongan']['tim_potong_potongan']));
		//pre($viewData);
		//$this->load->view('global/header');
		//$this->load->view('kelolapo/bukupotongan/buku-potongan-edit',$viewData);
		//$this->load->view('global/footer');
		$viewData['page']='kelolapo/bukupotongan/buku-potongan-edit';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function bukupotonganEditOnUpdate($value='')
	{
		$post = $this->input->post();
		$jumBl=0;
		$jumBls=0;
		$explode = explode('-',$post['namaPo']);
		$idpo=$this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$explode[1]));
		$po2022celana = substr($explode[1], 6);
		//pre(substr($explode[1], 6));
		updateDataProdPO(2,$explode[1]);
			if(isset($post['bidangBahan'])){
				$this->GlobalModel->deleteData('konveksi_buku_potongan_utama',array('kode_po'=>$explode[1]));
				foreach ($post['bidangBahan'] as $key => $bidangBahan) {
					$dataPotonganUtama = array(
						'idbukupotongan'			=> $post['idpotongan'],
						'idpo'						=> $idpo['id_produksi_po'],
						'kode_po'					=> $explode[1],
						'bidang_bahan_potongan'		=> $bidangBahan,
						'warna_potongan'			=> $post['warna'][$key],
						'kode_bahan_potongan'		=> $post['kodeBahan'][$key],
						'berat_bahan_potongan'		=> $post['beratBahan'][$key],
						'sisa_bahan_potongan'		=> $post['sisaBahan'][$key],
						'pemakaian_bahan_potongan'	=> $post['pemakaianBahankg'][$key],
						'banyak_lapis_potongan'		=> $post['banyakLapis'][$key],
						'created_date'				=> $post['tanggal']
					);
					$this->GlobalModel->insertData('konveksi_buku_potongan_utama',$dataPotonganUtama);
					$jumBl += $post['banyakLapis'][$key];
				}	
			}
			
			if(isset($post['bidangBahanVar'])){
				$this->GlobalModel->deleteData('konveksi_buku_potongan_variasi',array('kode_po'=>$explode[1]));
				foreach ($post['bidangBahanVar'] as $key => $bidangBahanVar) {
					$dataPotonganVariasi = array(
						'idbukupotongan'				=> $post['idpotongan'],
						'idpo'							=> $idpo['id_produksi_po'],
						'kode_po'						=>	$explode[1],
						'bidang_bahan_potongan'			=>	$bidangBahanVar,
						'warna_potongan'				=>	$post['warnaVar'][$key],
						'kode_bahan_potongan'			=>	$post['kodeBahanVar'][$key],
						'berat_bahan_potongan'			=>	$post['beratBahanVar'][$key],
						'sisa_bahan_potongan'			=>	$post['sisaBahanVar'][$key],
						'pemakaian_bahan_potongan'		=>	$post['pemakaianBahankgVar'][$key],
						'banyak_lapis_potongan'			=>	$post['banyakLapisVar'][$key],
						'created_date'					=>	$post['tanggal']
					);
					$this->GlobalModel->insertData('konveksi_buku_potongan_variasi',$dataPotonganVariasi);
					$jumBls += $post['banyakLapisVar'][$key];
				}
			}
		
				$jumlahPiecePot = ($jumBl*$post['jumlahGambar']);
				//pre($jumlahPiecePot);
			$dataInsert = array(
				'kode_po'							=> $explode[1],
				'tim_potong_potongan'				=> $post['timPotong'],
				'created_date'						=> $post['tanggal'],
				'pemakaian_bahan_utama'				=> $post['pemakaianBahan'],
				'jumlah_gambar_utama'				=> $post['jumlahGambar'],
				'jumlah_pemakaian_bahan_utama'		=> $post['pemakaianBahan'],
				'panjang_gelaran_potongan_utama'	=> $post['panjangGelaran'],
				'jumlah_pemakaian_bahan_variasi'	=> $post['pemakaianGelaranVariasi'],
				'panjang_gelaran_variasi'			=> $post['panjangGelaranVariasi'],
				'size_potongan'						=> $post['sizeBahan'],
				'created_date'						=> $post['tanggal'],
				// 'hasil_lusinan_potongan'			=> (($jumlahPiecePot * $post['jumlahGambar'])/12),
				// 'hasil_pieces_potongan'				=> (($jumlahPiecePot *$post['jumlahGambar'] )/ 12) * 12,
				'hasil_lusinan_potongan'			=> (($jumBl*$post['jumlahGambar'])/12),
				'hasil_pieces_potongan'				=> (($jumBl*$post['jumlahGambar'])/12) * 12,
			);
			$this->GlobalModel->updateData('konveksi_buku_potongan',array('kode_po'=>$explode[1]),$dataInsert);
				if($explode[0]=="PFK" OR $explode[0]=="BJK" OR $explode[0]=="BJH" OR $explode[0]=="BJF" OR $explode[0]=="PFJ"){
					$up=array(
						'hasil_lusinan_potongan'			=> (($jumBls*$post['jumlahGambar'])/12),
						'hasil_pieces_potongan'				=> (($jumBls*$post['jumlahGambar'])/12) * 12,
					);
					$where=array(
						'kode_po'	=>$explode[1],
					);
					$this->db->update('konveksi_buku_potongan',$up,$where);
				}else{
					if($po2022celana == '_2022' ){
						$up=array(
							'hasil_lusinan_potongan'			=> (($jumBls*$post['jumlahGambar'])/12),
							'hasil_pieces_potongan'				=> (($jumBls*$post['jumlahGambar'])/12) * 12,
						);
						$where=array(
							'kode_po'	=>$explode[1],
						);
						$this->db->update('konveksi_buku_potongan',$up,$where);
					}
				}

			$this->session->set_flashdata('msg','Data berhasil diubah');
			redirect(BASEURL.'kelolapo/bukupotongan?&kode_po='.$explode[1]);
	}

	public function bukupotonganDelete($value='')
	{
		# code...
	}

	public function bukupotonganDetail($kode='')
	{
		$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$kode));
		$kode=$po['kode_po'];
		$viewData['kembali']=BASEURL.'kelolapo/bukupotongan';
		$kodePOArr = array(
			'kode_po' => $kode,
		);
		$viewData['potonganHead'] = $this->GlobalModel->queryManualRow('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po = pp.kode_po WHERE pp.kode_po="'.$kode.'"');
		$viewData['tim']=$this->GlobalModel->getDataRow('timpotong',array('id'=>$viewData['potonganHead']['tim_potong_potongan']));
		$viewData['potonganUtama'] = $this->GlobalModel->getData('konveksi_buku_potongan_utama',$kodePOArr);
		$viewData['potonganVariasi'] = $this->GlobalModel->getData('konveksi_buku_potongan_variasi',$kodePOArr);
		$viewData['page']='kelolapo/bukupotongan/buku-potongan-detail';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function detailPotonganToPDF($kode='')
	{
		$kodePOArr = array(
			'kode_po' => $kode
		);
		$namePdf = $this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$kode));
		$viewData['potonganHead'] = $this->GlobalModel->queryManualRow('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po = pp.kode_po');
		$viewData['potonganUtama'] = $this->GlobalModel->getData('konveksi_buku_potongan_utama',$kodePOArr);
		$viewData['potonganVariasi'] = $this->GlobalModel->getData('konveksi_buku_potongan_variasi',$kodePOArr);
		$this->load->library('pdf');
		$this->pdf->load_view('konveksi/bukupotongan/buku-potongan-detailpdf');
		$this->pdf->render();
		$this->pdf->stream($namePdf['nama_po'].$namePdf['kode_po'].".pdf");
	}

	public function pengencekanpotongan()
	{
		redirect(BASEURL.'kelolapo/pengecekanpotongan');
		//$viewData['kelola']	= $this->GlobalModel->queryManual('SELECT pp.nama_po,kbp.kode_po,kbp.hasil_lusinan_potongan,kbp.hasil_pieces_potongan,pp.progress_lokasi,kbp.created_date,kbp.kode_po FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po JOIN proggresion_po ppo ON pp.id_proggresion_po = ppo.id_proggresion_po ');
		/*
 					[nama_po] => FBO
                    [kode_po] => FBO001
                    [hasil_lusinan_potongan] => 21
                    [hasil_pieces_potongan] => 252
                    [progress_lokasi] => PENGECEKAN
                    [created_date] => 2020-11-04
		*/
        $data=array();
        $results=array();
        $data['kelola']=array();
		$results	= $this->GlobalModel->queryManual('SELECT pp.nama_po,kbp.kode_po,kbp.hasil_lusinan_potongan,kbp.hasil_pieces_potongan,pp.progress_lokasi,kbp.created_date,kbp.kode_po FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po JOIN proggresion_po ppo ON pp.id_proggresion_po = ppo.id_proggresion_po ');
		
		foreach($results as $result){
			$action=array();
			/*
			$action[] = array(
				'text' => '<i class="fa fa-pencil"></i>&nbsp;Edit',
				'href' => BASEURL.'kelolapo/formpengecekanpotonganEdit/'.$result['kode_po'],
			);
			*/
			/*
			http://forboysproduction.com/kelolapo/kirimsetortambah/FBO48
			*/
			$action[] = array(
				'text' => '<i class="fa fa-eye"></i>&nbsp;Detail',
				'href' => BASEURL.'kelolapo/pengecekanpotongandetail/'.$result['kode_po'],
			);

			$data['kelola'][]=array(
				'nama_po'=>$result['nama_po'],
				'kode_po'=>$result['kode_po'],
				'hasil_lusinan_potongan'=>$result['hasil_lusinan_potongan'],
				'hasil_pieces_potongan'=>$result['hasil_pieces_potongan'],
				'progress_lokasi'=>$result['progress_lokasi'],
				'created_date'=>date('d-m-Y',strtotime($result['created_date'])),
				'action'=>$action,
			);
		}
		$this->load->view('global/header');
		$this->load->view('kelolapo/pengencekanpotongan/pengecekan-view',$data);
		$this->load->view('global/footer');
	}

	public function pengecekanpotongan()
	{
        $data=array();
        $results=array();
        $data['kelola']=array();
		$results	= $this->GlobalModel->queryManual('SELECT pp.nama_po,kbp.kode_po,kbp.hasil_lusinan_potongan,kbp.hasil_pieces_potongan,pp.progress_lokasi,kbp.created_date,kbp.kode_po FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po JOIN proggresion_po ppo ON pp.id_proggresion_po = ppo.id_proggresion_po LIMIT 20 ');
		
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => '<i class="fa fa-eye"></i>&nbsp;Detail',
				'href' => BASEURL.'kelolapo/pengecekanpotongandetail/'.$result['kode_po'],
			);

			$data['kelola'][]=array(
				'nama_po'=>$result['nama_po'],
				'kode_po'=>$result['kode_po'],
				'hasil_lusinan_potongan'=>$result['hasil_lusinan_potongan'],
				'hasil_pieces_potongan'=>$result['hasil_pieces_potongan'],
				'progress_lokasi'=>$result['progress_lokasi'],
				'created_date'=>date('d-m-Y',strtotime($result['created_date'])),
				'action'=>$action,
			);
		}
		$data['page']='newtheme/page/kelolapo/pengecekanpotongan_list';
		$this->load->view('newtheme/page/main',$data);
	}

	public function pengecekanpotongandetail($kode_po='',$idKelola='')
	{

		$viewData['potongan']	= $this->GlobalModel->queryManualRow('SELECT * FROM konveksi_buku_potongan kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po JOIN konveksi_buku_potongan kbp ON kks.kode_po=kbp.kode_po WHERE kks.kode_po="'.$kode_po.'" ');
		$viewData['timpotong']=$this->GlobalModel->getDataRow('timpotong',array('id'=>$viewData['potongan']['tim_potong_potongan']));
		$viewData['atas'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$kode_po));
		$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$kode_po));
		$viewData['page']='kelolapo/pengencekanpotongan/pengecekan-detail';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function formpengecekanpotongan($kode_po='')
	{
		$viewData['poProd']	= $this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po');

		$viewData['atas'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$kode_po));
		$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$kode_po));
		$this->load->view('global/header');
		$this->load->view('kelolapo/pengencekanpotongan/pengecekan-tambah',$viewData);
		$this->load->view('global/footer');
	}

	public function pengirimansablon(){
		$data=array();
		$data['title']='Surat Jalan Pengiriman Sablon';
		$data['products']=array();
		$data['url']=BASEURL.'Kelolapo/pengirimansablon';
		$data['i']=1;
		$data['tambah']=BASEURL.'Kelolapo/kirimcmtsablonadd/';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of last month"));
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
		if(isset($get['sj'])){
			$sj=$get['sj'];
		}else{
			$sj=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmt']=$cmt;
		$data['sj']=$sj;
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="SABLON" ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmtsablon WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT * FROM kirimcmtsablon WHERE hapus=0";

		if(!empty($cmt)){
			$sql.=" AND idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}

		$sql.=' ORDER BY id DESC ';
		$sql.=" LIMIT 20 ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		$det=[];
		$this->load->model('kirimsetorModel');
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL.'Kelolapo/kirimcmtsablonview/'.$result['id'],
			);

			if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => BASEURL.'Kelolapo/kirimcmtsablonedit/'.$result['id'],
				);
			}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$det = $this->kirimsetorModel->sablon_detail($result['id']);
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalkirim'],
				'namacmt'=>!empty($namacmt)?$namacmt['cmt_name']:null,
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'keterangan'=>($det),
				'action'=>$action,
			);
		}
		$data['page']='produksi/kirimcmt_list';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kirimcmtsablonadd(){
		$data=array();
		$data['title']='Pengiriman Jahit ke Sablon';
		$data['url']=BASEURL.'Kelolapo/pengirimansablon';
		$data['cancel']=BASEURL.'Kelolapo/pengirimansablon';
		$data['action']=BASEURL.'Kelolapo/kirimcmtsablonsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>2));
		$data['page']='produksi/kirimcmtsablon_form';
		//$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		// $data['kodepo'] = $this->GlobalModel->queryManual('SELECT p.kode_po,p.nama_po FROM produksi_po p WHERE p.kode_po NOT IN(SELECT kode_po FROM finishing_kirim_gudang) ORDER BY kode_po ASC ');
		$data['kodepo'] = $this->GlobalModel->queryManual('SELECT p.kode_po,p.nama_po FROM produksi_po p WHERE p.kode_po IN(SELECT kode_po FROM konveksi_buku_potongan ) ORDER BY kode_po ASC ');
		$this->load->view('newtheme/page/main',$data);
		
	}

	public function kirimcmtsablonsave(){
		$post=$this->input->post();
		$cmt=explode('-', $post['cmtName']);
		//pre($cmt[0]);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		$masterpo=[];
		if(isset($post['tanggal'])){
			$insert=array(
				'tanggal'=>$post['tanggal'],
				'kode_po'=>'-',
				'totalkirim'=>0,
				'cmtkat'=>$post['cmtKat'],
				'idcmt'=>$cmt[0],
				'cmtkat'=>$post['cmtKat'],
				'cmtjob'=>'-',
				'status'=>0,
				'keterangan'=>$post['keterangan'],
				'dibuat'=>date('Y-m-d H:i:s'),
				'hapus'=>0,
			);
			$this->db->insert('kirimcmtsablon', $insert);
   			$id = $this->db->insert_id();
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt[0]));
   			foreach($post['products'] as $p){
   				$jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$p['cmtjob']));
   				$totalkirim+=($p['jumlah_pcs']);
   				$detail=array(
   					'idkirim'=>$id,
   					'kode_po'=>$p['kode_po'],
   					'cmtjob'=>$p['cmtjob'],
   					'rincian_po'=>$p['rincian_po'],
   					'jumlah_pcs'=>$p['jumlah_pcs'],
   					'keterangan'=>$p['keterangan'],
   					'jml_barang'=>$p['jml_barang'],
   					'hapus'=>0,
   				);
   				$this->db->insert('kirimcmtsablon_detail',$detail);
   				$masterpo=$this->GlobalModel->GetdataRow('produksi_po',array('kode_po'=>$p['kode_po']));
   				$insertkks=array(
   					'kode_po'=>$p['kode_po'],
   					'create_date'=>$post['tanggal'],
   					'kode_nota_cmt'=>$id,
   					'progress'=>'KIRIM',
   					'kategori_cmt'=>'SABLON',
   					'id_master_cmt'=>$cmt[0],
   					'id_master_cmt_job'=>$p['cmtjob'],
   					'cmt_job_price'=>$jobprice['harga'],
   					'nama_cmt'=>$namacmt['cmt_name'],
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
	   		$nosj='SJFB'.'-'.date('Y-m').'-'.$id;
			user_activity(callSessUser('id_user'),1,' input surat jalan kirim sablon '.$nosj);
	   		$this->db->update('kirimcmtsablon',array('totalkirim'=>$totalkirim,'nosj'=>$nosj),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Kelolapo/pengirimansablon');
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function kirimcmtsablonview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['kembali']=BASEURL.'Kelolapo/pengirimansablon';
		$data['cetak']=BASEURL.'Kelolapo/kirimcmtsabloncetak/'.$id.'/1';
		$data['excel']=BASEURL.'Kelolapo/kirimcmtsabloncetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmtsablon_detail',array('idkirim'=>$id));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$data['kirims'][]=array(
				'kode_po'=>$k['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['nama_job'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['page']='produksi/kirimcmt_view';
		$this->load->view('newtheme/page/main',$data);
	}

	/*public function kirimcmtsabloncetak($id='',$type=''){
		$rincian=array();
		$data=array();
		$data['no']=1;
		$data['nota']='Sablon';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$id));
		$data['kirims']=$this->GlobalModel->getData('kirimcmtsablon_detail',array('idkirim'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		if($type==1){
			$this->load->view('produksi/kirimcmt_cetak',$data);
		}else{
			$this->load->view('produksi/kirimcmt_excel',$data);
		}
		
	}*/

	public function kirimcmtsabloncetak($id='',$type=''){
		$rincian=array();
		$data=array();
		$data['no']=1;
		$data['nota']='Sablon';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$id));
		$data['kirims']=$this->GlobalModel->getData('kirimcmtsablon_detail',array('idkirim'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		if($type==2){
			$pdf=false;
		}else{
			$pdf=true;
		}
		
		if($pdf==true){
			//$this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			
			$html =  $this->load->view('produksi/kirimcmt_pdf',$data,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Surat Jalan Kirim Jahit';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Surat_Jalan_Kirim_Jahit_'.time();
	        // setting paper
	        //$paper = 'A4';
	        $paper = array(0,0,800,850);
	        //orientasi paper potrait / landscape
	        $orientation = "landscape";
	        
			$this->load->view('laporan_pdf',$this->data, true);	    
	        
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			if($type==1){
				//$this->load->view('produksi/kirimcmt_cetak',$data);
				$this->load->view('produksi/kirimcmt_pdf',$data);
			}else{
				$this->load->view('produksi/kirimcmt_excel',$data);
			}	
		}
		
		
	}

	public function kirimcmtsablonedit($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['cetak']=null;
		$data['excel']=null;
		$data['action']=BASEURL.'Kelolapo/kirimcmtsabloneditsave';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmtsablon',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmtsablon_detail',array('idkirim'=>$id));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$data['kirims'][]=array(
				'kode_po'=>$k['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['id'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['listcmt'] = $this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'SABLON'));
		$data['listjob'] = $this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>2));
		$data['listpo']	 = $this->GlobalModel->QueryManual("SELECT * FROM produksi_po WHERE hapus=0 AND kode_po NOT IN (SELECT kode_po FROM kelolapo_kirim_setor WHERE progress='KIRIM' AND kategori_cmt='SABLON' AND id_master_cmt <> '".$data['kirim']['idcmt']."' ) AND kode_po NOT IN (SELECT kode_po FROM kirimcmtsablon_detail WHERE idkirim <> '".$id."' ) ORDER BY kode_po ASC ");
		$data['page']='produksi/kirimcmtsablon_edit';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kirimcmtsabloneditsave(){
		$post=$this->input->post();
		//pre($post);
		//pre($data);
		$cmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$post['idcmt']));
		// update di sj
		$this->db->query("UPDATE kirimcmtsablon set idcmt='".$post['idcmt']."',tanggal='".$post['tanggal']."' WHERE id='".$post['kode_nota']."' ");
		// update di kelola kirim setor
		$sql="UPDATE kelolapo_kirim_setor set id_master_cmt='".$post['idcmt']."',nama_cmt='".strtolower($cmt['cmt_name'])."',create_date='".$post['tanggal']."' WHERE kode_nota_cmt='".$post['kode_nota']."' AND kategori_cmt='SABLON' ";
		$this->db->query($sql);
		$totalkirim=0;

		// fungsi baru
		$id = $post['kode_nota'];
					//hapus di surat jalan
					$this->db->delete(
						'kirimcmtsablon_detail', 
							array(
								'idkirim' => $post['kode_nota'],
								//'kode_po' => $post['kode_po'],
							)
					);

					foreach($post['prods'] as $p){
							// hapus di kelolapo kirim setor
							$this->db->delete(
								'kelolapo_kirim_setor', 
									array(
										'kode_po' => $p['kode_po_lama'],
										'progress' => 'KIRIM',
										'kategori_cmt' => $p['kategori_cmt'],
									)
							);
					}
		foreach($post['prods'] as $p){
			
					


					$jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$p['cmtjob']));
	   				$totalkirim+=($p['jumlah_pcs']);
	   				$detail=array(
	   					'idkirim'=>$id,
	   					'kode_po'=>$p['kode_po'],
	   					'cmtjob'=>$p['cmtjob'],
	   					'rincian_po'=>$p['rincian_po'],
	   					'jumlah_pcs'=>$p['jumlah_pcs'],
	   					'keterangan'=>$p['keterangan'],
	   					'jml_barang'=>$p['jml_barang'],
	   					'hapus'=>0,
	   				);
	   				$this->db->insert('kirimcmtsablon_detail',$detail);


	   				$masterpo=$this->GlobalModel->GetdataRow('produksi_po',array('kode_po'=>$p['kode_po']));
	   				$insertkks=array(
	   					'kode_po'=>$p['kode_po'],
	   					'create_date'=>$post['tanggal'],
	   					'kode_nota_cmt'=>$id,
	   					'progress'=>'KIRIM',
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
			
		}// end foreach

		// end
   			/*
		foreach($post['prods'] as $p){

			$totalkirim+=($p['jumlah_pcs']);
			$rp=explode('-',$p['job']);
			$update=array(
				'id_master_cmt_job'=>$rp[0],
				'cmt_job_price'	=>$rp[1],
				'qty_tot_pcs'=>$p['jumlah_pcs'],
				'jml_barang'=>$p['jml_barang'],
			);
			$where=array(
				'kode_po'=>$p['kode_po'],
				'kategori_cmt'	=>$p['kategori_cmt'],
				'kode_nota_cmt'=>$post['kode_nota'],
				'progress'=>'KIRIM',
			);
			$this->db->update('kelolapo_kirim_setor',$update,$where);
			$ud=array(
				'cmtjob'=>$rp[0],
				'jumlah_pcs'=>$p['jumlah_pcs'],
				'rincian_po'=>$p['rincian_po'],
				'jml_barang'=>$p['jml_barang'],
				'keterangan'=>$p['keterangan'],
			);
			$wd=array(
				'kode_po'=>$p['kode_po'],
				'idkirim'=>$post['kode_nota'],
			);
			$this->db->update('kirimcmtsablon_detail',$ud,$wd);
		}
		*/
		//pre($totalkirim);
		user_activity(callSessUser('id_user'),1,' edit surat jalan sablon id '.$post['kode_nota']);
		$this->db->update('kirimcmtsablon',array('totalkirim'=>$totalkirim),array('id'=>$post['kode_nota']));
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect(BASEURL.'Kelolapo/pengirimansablon');
	}



	public function pengirimanbordir(){
		redirect(BASEURL.'Kelolapo/kirimsetorcmt');
	}

	public function pengirimancmt(){
		$data=array();
		$data['title']='Surat Jalan Pengiriman Jahit';
		$data['products']=array();
		$data['url']=BASEURL.'Kelolapo/pengirimancmt';
		$data['i']=1;
		$data['tambah']=BASEURL.'Kelolapo/kirimcmtadd/';
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
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
		if(isset($get['sj'])){
			$sj=$get['sj'];
		}else{
			$sj=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmt']=$cmt;
		$data['sj']=$sj;
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="JAHIT" ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmt WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT * FROM kirimcmt WHERE hapus=0";

		if(!empty($cmt)){
			$sql.=" AND idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}

		$sql.=' ORDER BY id DESC ';
		$sql.=" LIMIT 20 ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL.'Kelolapo/kirimcmtview/'.$result['id'],
			);

			if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => BASEURL.'Kelolapo/kirimcmtedit/'.$result['id'],
				);
			}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalkirim'],
				'namacmt'=>$namacmt['cmt_name'],
				'keterangan'=>$result['keterangan'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
			);
		}
		$data['page']='produksi/kirimcmt_list';
		$this->load->view('newtheme/page/main',$data);
		
	}

	public function kirimcmtadd(){
		$data=array();
		$data['title']='Pengiriman Jahit ke cmt';
		$data['url']=BASEURL.'Kelolapo/pengirimancmt';
		$data['cancel']=BASEURL.'Kelolapo/pengirimancmt';
		$data['action']=BASEURL.'Kelolapo/kirimcmtsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['page']='produksi/kirimcmt_form';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view('newtheme/page/main',$data);
		
	}

	public function kirimcmtsave(){
		$post=$this->input->post();
		//pre($post);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		$jobprice=0;
		$masterpo=[];
		if(isset($post['tanggal'])){
			$cmt=explode('-', $post['cmtName']);
			$insert=array(
				'tanggal'=>$post['tanggal'],
				'kode_po'=>'-',
				'totalkirim'=>0,
				'cmtkat'=>$post['cmtKat'],
				'idcmt'=>$cmt[0],
				'cmtkat'=>$post['cmtKat'],
				'cmtjob'=>'-',
				'status'=>0,
				'keterangan'=>$post['keterangan'],
				'dibuat'=>date('Y-m-d H:i:s'),
				'hapus'=>0,
			);
			$this->db->insert('kirimcmt', $insert);
   			$id = $this->db->insert_id();
   			$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt[0]));
   			foreach($post['products'] as $p){
   				$jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$p['cmtjob']));

   				$totalkirim+=($p['jumlah_pcs']);
   				$detail=array(
   					'idkirim'=>$id,
   					'kode_po'=>$p['kode_po'],
   					'cmtjob'=>$p['cmtjob'],
   					'rincian_po'=>$p['rincian_po'],
   					'jumlah_pcs'=>$p['jumlah_pcs'],
   					'keterangan'=>$p['keterangan'],
   					'jml_barang'=>$p['jml_barang'],
   					'hapus'=>0,
   				);
   				$this->db->insert('kirimcmt_detail',$detail);
   				$masterpo=$this->GlobalModel->GetdataRow('produksi_po',array('kode_po'=>$p['kode_po']));
   				$insertkks=array(
   					'kode_po'=>$p['kode_po'],
   					'create_date'=>$post['tanggal'],
   					'kode_nota_cmt'=>$id,
   					'progress'=>'KIRIM',
   					'kategori_cmt'=>'JAHIT',
   					'id_master_cmt'=>$cmt[0],
   					//'id_master_cmt_job'=>$job[0],
   					'id_master_cmt_job'=>$p['cmtjob'],
   					'cmt_job_price'=>$jobprice['harga'],
   					'nama_cmt'=>$namacmt['cmt_name'],
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
	   		$nosj='SJFB'.'-'.date('Y-m').'-'.$id;
			user_activity(callSessUser('id_user'),1,' input pengiriman surat jalan jahit '.$nosj);
	   		$this->db->update('kirimcmt',array('totalkirim'=>$totalkirim,'nosj'=>$nosj),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Kelolapo/pengirimancmt');
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function kirimcmtview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['kembali']=BASEURL.'Kelolapo/pengirimancmt';
		$data['cetak']=BASEURL.'Kelolapo/kirimcmtcetak/'.$id.'/1';
		$data['excel']=BASEURL.'Kelolapo/kirimcmtcetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmt_detail',array('idkirim'=>$id,'hapus'=>0));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po=$this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$k['kode_po']));
			$data['kirims'][]=array(
				'kode_po'=>$k['kode_po'].' '.$po['serian'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['nama_job'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['page']='produksi/kirimcmt_view';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kirimcmtedit($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['cetak']=BASEURL.'Kelolapo/kirimcmtcetak/'.$id.'/1';
		$data['excel']=BASEURL.'Kelolapo/kirimcmtcetak/'.$id.'/2';
		$data['action']=BASEURL.'Kelolapo/kirimcmteditsave';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmt_detail',array('idkirim'=>$id));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$data['kirims'][]=array(
				'kode_po'=>$k['kode_po'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['id'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['listcmt'] = $this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['listjob'] = $this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['page']='produksi/kirimcmt_edit';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kirimcmteditsave(){
		$post=$this->input->post();
		//pre($post);
		//pre($data);
		$cmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$post['idcmt']));
		// update di sj
		$this->db->query("UPDATE kirimcmt set idcmt='".$post['idcmt']."',tanggal='".$post['tanggal']."' WHERE id='".$post['kode_nota']."' ");
		// update di kelola kirim setor
		$sql="UPDATE kelolapo_kirim_setor set id_master_cmt='".$post['idcmt']."',nama_cmt='".strtolower($cmt['cmt_name'])."',create_date='".$post['tanggal']."' WHERE kode_nota_cmt='".$post['kode_nota']."' AND kategori_cmt='JAHIT' ";
		$this->db->query($sql);
		$totalkirim=0;
		foreach($post['prods'] as $p){
			$cek_diklo = $this->GlobalModel->getDataRow('kelolapo_kirim_setor', array('hapus'=>0,'kode_po'=>$p['kode_po'],'progress'=>'KIRIM','kategori_cmt'=>'JAHIT','id_master_cmt'=>$post['idcmt']));
			$totalkirim+=($p['jumlah_pcs']);
			$rp=explode('-',$p['job']);
			if(empty($cek_diklo)){
				// insert to kelola kirim setor
				$masterpo=$this->GlobalModel->getDataRow('produksi_po',array('kode_po'=>$p['kode_po']));
				$namacmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$post['idcmt']));
   				$insertkks=array(
   					'kode_po'=>$p['kode_po'],
   					'create_date'=>$post['tanggal'],
   					'kode_nota_cmt'=>$post['kode_nota'],
   					'progress'=>'KIRIM',
   					'kategori_cmt'=>'JAHIT',
   					'id_master_cmt'=>$post['idcmt'],
   					//'id_master_cmt_job'=>$job[0],
   					'id_master_cmt_job'=>$rp[0],
   					'cmt_job_price'=>$rp[1],
   					'nama_cmt'=>$namacmt['cmt_name'],
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
			}else{
				$update=array(
					'id_master_cmt_job'=>$rp[0],
					'cmt_job_price'	=>$rp[1],
					'qty_tot_pcs'=>$p['jumlah_pcs'],
					'jml_barang'=>$p['jml_barang'],
				);
				$where=array(
					'kode_po'=>$p['kode_po'],
					'kategori_cmt'	=>$p['kategori_cmt'],
					'kode_nota_cmt'=>$post['kode_nota'],
					'progress'=>'KIRIM',
				);
				$this->db->update('kelolapo_kirim_setor',$update,$where);
			}
			
			$ud=array(
				'cmtjob'=>$rp[0],
				'jumlah_pcs'=>$p['jumlah_pcs'],
				'rincian_po'=>$p['rincian_po'],
				'jml_barang'=>$p['jml_barang'],
				'keterangan'=>$p['keterangan'],
			);
			$wd=array(
				'kode_po'=>$p['kode_po'],
				'idkirim'=>$post['kode_nota'],
			);
			$this->db->update('kirimcmt_detail',$ud,$wd);
		}
		user_activity(callSessUser('id_user'),1,' edit surat jalan jahit '.$post['kode_nota']);
		$this->db->update('kirimcmt',array('totalkirim'=>$totalkirim),array('id'=>$post['kode_nota']));
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect(BASEURL.'Kelolapo/pengirimancmt');
	}


	public function kirimcmtcetak($id='',$type=''){
		$rincian=array();
		$data=array();
		$data['nota']='CMT';
		$data['no']=1;
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
		$data['kirims']=$this->GlobalModel->getData('kirimcmt_detail',array('idkirim'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		if($type==2){
			$pdf=false;
		}else{
			$pdf=true;
		}
		
		if($pdf==true){
			//$this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			
			$html =  $this->load->view('produksi/kirimcmt_pdf',$data,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Surat Jalan Kirim Jahit';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Surat_Jalan_Kirim_Jahit_'.time();
	        // setting paper
	        //$paper = 'A4';
	        $paper = array(0,0,800,850);
	        //orientasi paper potrait / landscape
	        $orientation = "landscape";
	        
			$this->load->view('laporan_pdf',$this->data, true);	    
	        
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			if($type==1){
				//$this->load->view('produksi/kirimcmt_cetak',$data);
				$this->load->view('produksi/kirimcmt_pdf',$data);
			}else{
				$this->load->view('produksi/kirimcmt_excel',$data);
			}	
		}
		
		
	}

	public function seaechDataId($value='')
	{
		$post = $this->input->post();
		$data = $this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po'=>$post['idData']));
		echo json_encode($data);
	}

	public function searchjumlahpotongan($value='')
	{
		$post = $this->input->post();
		$dataAtas = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$post['idData']));
		$dataBwh = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$post['idData']));
		$jumlahTotal = 0;
		foreach ($dataAtas as $key => $valAt) {
			$jumlahTotal += $valAt['jumlah_potongan'];
		}
		foreach ($dataBwh as $key => $valBwh) {
			$jumlahTotal += $valBwh['jumlah_potongan'];
		}
		if ($post['idData']) {
			$dataArra['totalPcs'] = $jumlahTotal;
		} else {
			$dataArra= '';
		}
		

		echo json_encode($dataArra);
	}

	public function searchbagianpotonganAtas($value='')
	{
		$post = $this->input->post();
		$dataAtas = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$post['idData']));
		$html = '';
		foreach ($dataAtas as $key => $valAt) {
			$html .= $valAt['bagian_potongan_atas'].', ';
		}
		
		echo $html;
		
	}

	public function searchbagianpotonganBwh($value='')
	{
		$post = $this->input->post();
		$dataBwh = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$post['idData']));
		$html = '';
		
		foreach ($dataBwh as $key => $valBwh) {
			$html .= $valBwh['bagian_potongan_bawah'].', ';
		}
		if ($post['idData']) {
			echo $html;
		} else {
			echo '';
		}
		
	}

	public function searchCmt()
	{
		$post = $this->input->post();
		//$data = $this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>$post['jobCmt']));
		$data = $this->GlobalModel->QueryManual("
			SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='".$post['jobCmt']."' AND lokasi NOT IN(3)
		");
		echo "<option value=''>Pilih CMT</option>";
		foreach ($data as $key => $cmt) {
			echo '<option value='.$cmt['id_cmt'].'-'.url_title($cmt['cmt_name'],'underscore').'>'.$cmt['cmt_name'].'</option>';
		}
	}

	public function searchCmtJob($value='')
	{
		$post = $this->input->post();
		$explode = explode('-', $post['jobCmt']);
		$data = $this->GlobalModel->getData('master_cmt_job',array('cmt_job_parent'=>$explode[0]));
		echo "<option value=''>Pilih Pengerjaan</option>";
		foreach ($data as $key => $cmt) {
			echo '<option value='.$cmt['id_master_cmt_job'].'-'.$cmt['cmt_job_price'].'>'.$cmt['cmt_job_jenis'].'</option>';
		}
	}

	public function searchCmtJobSablon($value='')
	{
		$post = $this->input->post();
		$data = $this->GlobalModel->getData('master_job',array('jenis'=>2,'hapus'=>0));
		echo "<option value=''>Pilih Pengerjaan</option>";
		foreach ($data as $key => $cmt) {
			echo '<option value='.$cmt['id'].'-'.$cmt['harga'].'>'.$cmt['nama_job'].'</option>';
		}
	}

	public function searchCmtJobJahit($value='')
	{
		$post = $this->input->post();
		$data = $this->GlobalModel->getData('master_job',array('jenis'=>1,'hapus'=>0));
		echo "<option value=''>Pilih Pengerjaan</option>";
		foreach ($data as $key => $cmt) {
			echo '<option value='.$cmt['id'].'-'.$cmt['harga'].'>'.$cmt['nama_job'].'</option>';
		}
	}

	public function formpengecekanpotonganOnAct($value='')
	{
		$post = $this->input->post();
		$sql="UPDATE konveksi_buku_potongan SET hasil_lusinan_potongan='".$post['jumlahPotDz']."',hasil_pieces_potongan='".($post['jumlahPotDz']*12)."' WHERE kode_po='".$post['namaPo']."' ";
		//echo "<pre>";print_r($sql);exit;
		$this->db->query($sql);
		$this->db->delete('kelolapo_pengecekan_potongan_atas',array('kode_po' => $post['namaPo']));
		$this->db->delete('kelolapo_pengecekan_potongan_bawah',array('kode_po' => $post['namaPo']));
		$dataInputatas = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po' => $post['namaPo']));
		$dataInputBawah = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po' => $post['namaPo']));
		$jumlahTOtalAts = 0;
		$jumlahTOtalBwh = 0;

		if (empty($dataInputatas) && empty($dataInputBawah)) {
			foreach ($post['bagianAtas'] as $key => $bagianAtas) {
				$jumlahTOtalAts += $post['jmlAtas'][$key];
			}
			if (isset($post['bagianBwh'])) {
				foreach ($post['bagianBwh'] as $key => $bagianBwh) {
					$jumlahTOtalBwh += $post['jmlBwh'][$key];
				}
			}

			$jumlahTOtal = $jumlahTOtalAts + $jumlahTOtalBwh;
			$jumlahGrandTotal = $jumlahTOtal;
			// pre($jumlahGrandTotal);
			if ($jumlahGrandTotal == $post['jumlahPotPcs']) {
				$dataParent = array(
					'kode_po'	=>	$post['namaPo'],
					'jumlah_total_potongan' => $post['jumlahPotPcs'],
					'jumlah_warna'	=> $post['jmlWarna'],
					'created_date' => $post['tanggal']
				);
				$this->GlobalModel->insertData('kelolapo_pengecekan_potongan',$dataParent);

	            if(isset($post['bagianAtas'])){
					foreach ($post['bagianAtas'] as $key => $bagianAtas) {
						$dataInserted = array(
							'kode_po'					=>	$post['namaPo'],
							'bagian_potongan_atas'		=>	$bagianAtas,
							'warna_potongan_atas'		=>	$post['warnaAtas'][$key],
							'jumlah_potongan'		=>	$post['jmlAtas'][$key],
							'keterangan_potongan'		=>	$post['keteranganAts'][$key],
							'created_date'		=>	$post['tanggal']
						);
						$this->GlobalModel->insertData('kelolapo_pengecekan_potongan_atas',$dataInserted);

					}
					
				}
                
                if(isset($post['bagianBwh'])){
    				foreach ($post['bagianBwh'] as $key => $bagianBwh) {
    					$dataBawah = array(
    						'kode_po'				=>	$post['namaPo'],
    						'bagian_potongan_bawah'	=>	$bagianBwh,
    						'warna_potongan_bawah'	=>	$post['warnaBwh'][$key],
    						'jumlah_potongan'	=>	$post['jmlBwh'][$key],
    						'keterangan_potongan'	=>	$post['keteranganBwh'][$key],
    						'created_date'	=>	$post['tanggal']
    					);
    					$this->GlobalModel->insertData('kelolapo_pengecekan_potongan_bawah',$dataBawah);
    				}
                }

				$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=> 13,'progress_lokasi'=>"PENGECEKAN",'updated_date'=>$post['tanggal']));
				$this->GlobalModel->updateData('konveksi_buku_potongan',array('kode_po'=>$post['namaPo']),array('status'=>1));
				$this->session->set_flashdata('msg','Data Berhasil Disimpan');
				redirect(BASEURL.'kelolapo/pengecekanpotongan');

			} else {
				$this->session->set_flashdata('msg','Total Bagian dan total piece tidak sama!!');

				redirect(BASEURL.'kelolapo/formpengecekanpotonganEdit/'.$post['namaPo']);
			}
			
		} else {

			$this->session->set_flashdata('msg','DENGAN KODE PO INI SUDAH TERIMPUT HUBUNGI SPV!! ');
				redirect(BASEURL.'kelolapo/formpengecekanpotonganEdit/'.$post['namaPo']);

		}
		

	}

	public function formpengecekanpotonganEdit($kode_po='')
	{
		$viewData['poProd']	= $this->GlobalModel->queryManualRow('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE kbp.kode_po="'.$kode_po.'" ');
		$viewData['bahan'] = $this->GlobalModel->getData('gudang_bahan_keluar',array('kode_po'=>$kode_po,'hapus'=>0));
		
		$viewData['potonganUtama'] = $this->GlobalModel->getData('konveksi_buku_potongan_utama',array('kode_po'=>$kode_po));
		//pre($viewData['potonganUtama']);
		$viewData['parent'] = $this->GlobalModel->getDataRow('kelolapo_pengecekan_potongan',array('kode_po'=>$kode_po));
		$viewData['atas'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$kode_po));
		$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$kode_po));
		// $this->load->view('global/header');
		// $this->load->view('kelolapo/pengencekanpotongan/pengecekan-edit',$viewData);
		// $this->load->view('global/footer');
		$viewData['page']='kelolapo/pengencekanpotongan/pengecekan-edit';
		$this->load->view('newtheme/page/main',$viewData);
	}

	public function formpengecekandetail($kode_po='',$idKelola='')
	{

		$viewData['potongan']	= $this->GlobalModel->queryManualRow('SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po JOIN konveksi_buku_potongan kbp ON kks.kode_po=kbp.kode_po WHERE kks.kode_po="'.$kode_po.'" AND kks.id_kelolapo_kirim_setor="'.$idKelola.'"');

		$viewData['atas'] = $this->GlobalModel->getData('kelolapo_kirim_setor_atas',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_kirim_setor_bawah',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		// pre($viewData);
		//$this->load->view('global/header');
		//$this->load->view('kelolapo/kirimsetorpotongan/kirim-setor-detail',$viewData);
		//$this->load->view('global/footer');
		$viewData['page']='kelolapo/kirimsetorpotongan/kirim-setor-detail';
		$this->load->view($this->layout,$viewData);
	}




	public function kirimsetorcmt($value='')
	{
		$viewData['title']='Kirim setor CMT';
		$viewData['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
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
		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
		$sql='SELECT * FROM kelolapo_kirim_setor kks LEFT JOIN produksi_po pp ON kks.kode_po=pp.kode_po';
		$sql.=" WHERE kks.hapus=0 ";

		if(!empty($cmt)){
			$sql.=" AND kks.id_master_cmt='".$cmt."' ";
		}

		if(!empty($kode_po)){
			$sql.=" AND kks.kode_po='".$kode_po."' ";
		}else{
			if(!empty($cmt)){

			}else{
				$sql.=" AND date(kks.create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}
		$sql.=" ORDER BY id_kelolapo_kirim_setor DESC ";
		if(!empty($tanggal1) || !empty($cmt)){

		}else{
			$sql.=" LIMIT 20 ";
		}
		$viewData['kelola']=[];
		$resullts= $this->GlobalModel->queryManual($sql);
		foreach($resullts as $r){
			$pekerjaan=$this->GlobalModel->GetDataRow('master_job',array('hapus'=>0,'id'=>$r['id_master_cmt_job']));
			$kategori='JAHIT';
			if($r['kategori_cmt']=='SABLON'){
				$kategori='SABLON';
			}
			$viewData['kelola'][]=array(
				'id_kelolapo_kirim_setor'=>$r['id_kelolapo_kirim_setor'],
				'nama_po'=>$r['nama_po'],
				'kode_po'=>$r['kode_po'],
				'nama_cmt'=>$r['nama_cmt'],
				'kategori_cmt'	=>$r['kategori_cmt'],
				'progress'=>$r['progress'],
				'kode_nota_cmt'=>$r['kode_nota_cmt'],
				'qty_tot_pcs'=>$r['qty_tot_pcs'],
				'create_date'	=>	$r['create_date'],
				'pekerjaan'=>!empty($pekerjaan)?$pekerjaan['nama_job']:'',
				'editsetor'=>BASEURL.'Kelolapo/editsetor/'.$r['id_kelolapo_kirim_setor'].'/'.$r['idpo'].'/'.$kategori,
			);
		}
		$viewData['tanggal1']=$tanggal1;
		$viewData['tanggal2']=$tanggal2;
		$viewData['cmt']=$cmt;
		$viewData['listcmt']=$this->GlobalModel->GetData('master_cmt',array('hapus'=>0));
		$viewData['page']='kelolapo/kirimsetorpotongan/kirim-setor-view';
		$this->load->view('newtheme/page/main',$viewData);
		
	}

	function editsetor($idklo,$idpo,$kategori){
		$viewData['kategori']=$kategori;
		$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$idpo));
		$viewData['po']=$po;
		$viewData['title']='Edit Setoran '.$po['kode_po'];
		$viewData['klo']=$this->GlobalModel->GetDataRow('kelolapo_kirim_setor',array('id_kelolapo_kirim_setor'=>$idklo));
		$viewData['bangke']=$this->GlobalModel->GetDataRow('kelolapo_rincian_setor_cmt',array('kode_po'=>$po['kode_po']));
		$viewData['page']='kelolapo/kirimsetorpotongan/kirim-setor-edit-setor';
		$viewData['action']=BASEURL.'Kelolapo/editsetor_save';
		$viewData['batal']=BASEURL.'Kelolapo/kirimsetorcmt?&kode_po='.$po['kode_po'];
		$this->load->view('newtheme/page/main',$viewData);
	}

	function editsetor_save(){
		$post = $this->input->post();
		// $pesan='mengubah quantity setoran PO '.$post['kode_po'].'. Dari'.$post['setoran'].' pcs, Menjadi '.$post['pcs'].' pcs';
		$update = array(
			'qty_tot_pcs'=>$post['pcs'],
		);

		$where = array(
			'idpo'			=>$post['idpo'],
			'progress'		=>$post['progress'],
			'kategori_cmt'	=>$post['kategori'],
		);
		$this->db->update('kelolapo_kirim_setor',$update,$where);

		if(isset($post['bangke'])){
			$ub = array(
				'bangke_qty' => $post['bangke']
			);
			$this->db->update('kelolapo_rincian_setor_cmt',$ub, array('kode_po'=>$post['kode_po']));
		}

		if($post['progress']=='SETOR' && $post['kategori']=='JAHIT'){
			$where2 = array(
				'idpo'		=>$post['idpo'],
				'progress'	=>'FINISHING',
			);
			$this->db->update('kelolapo_kirim_setor',$update,$where2);

			if(!empty($post['notasetor'])){
				$this->db->query("UPDATE setorcmt SET totalsetor=totalsetor-".$post['setoran']." WHERE id=".$post['notasetor']." ");
				$this->db->query("UPDATE setorcmt SET totalsetor=totalsetor+".$post['pcs']." WHERE id=".$post['notasetor']." ");
			}
			
			$this->db->update('setorcmt_detail',array('totalsetor'=>$post['pcs']),array('hapus'=>0,'kode_po'=>$post['kode_po']));
			
		}else{

			if(!empty($post['notasetor'])){
				$this->db->query("UPDATE setorcmt SET totalsetor=totalsetor-".$post['setoran']." WHERE id=".$post['notasetor']." ");
				$this->db->query("UPDATE setorcmt SET totalsetor=totalsetor+".$post['pcs']." WHERE id=".$post['notasetor']." ");
			}
			
			$this->db->update('setorcmt_sablon_detail',array('totalsetor'=>$post['pcs']),array('hapus'=>0,'kode_po'=>$post['kode_po']));
		}

		$this->session->set_flashdata('msg','Data Berhasil Diubah');
		$pesan=' Mengubah jumlah setoran '.$post['kategori'].' PO '.$post['kode_po'].'. Dari '.$post['setoran'].' Pcs, Menjadi '.$post['pcs'].' Pcs, diubah karena alasan : '.$post['alasan'];
		user_activity(callSessUser('id_user'),1,$pesan);
		redirect(BASEURL.'Kelolapo/kirimsetorcmt?kode_po='.$post['kode_po']);

	}

	public function kirimsetortambah($kode_po='')
	{
		$viewData['poProd']	= $this->GlobalModel->queryManualRow('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE kbp.kode_po="'.$kode_po.'" ');
		//pre($viewData['poProd']);
		$viewData['progress'] = $this->GlobalModel->getData('master_progress',null);
		$viewData['parent'] = $this->GlobalModel->getDataRow('kelolapo_pengecekan_potongan',array('kode_po'=>$kode_po));
		$viewData['atas'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$kode_po));
		$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$kode_po));
		//$this->load->view('global/header');
		$viewData['page']='kelolapo/kirimsetorpotongan/kirim-setor-tambah';
		$this->load->view('newtheme/page/main',$viewData);
		//$this->load->view('global/footer');
	}

	public function kirimsetortambahAction()
	{
		$post = $this->input->post();
		$dataKelola = $this->GlobalModel->getData('kelolapo_kirim_setor',array('kode_po'=>$post['namaPo']));
			$jmlBaw = 0; 
			$jmlAtas = 0;
			$jmlBanke = 0;
			$jmlReject = 0;
			$jmlHilang = 0;
			$jmlClaim = 0;
			$jmlBankeBw = 0;
			$jmlRejectBw = 0;
			$jmlHilangBw = 0;
			$jmlClaimBw = 0;
		if (isset($post['qtyBankeAtas']) && isset($post['qtyRejectAtas'])) {
			foreach ($post['bagianAtas'] as $key => $bagianAtas) {
					$jmlAtas += $post['jmlAtas'][$key];
					$jmlBanke += $post['qtyBankeAtas'][$key];
					$jmlReject += $post['qtyRejectAtas'][$key];
					$jmlHilang += $post['qtyHilangAtas'][$key];
					$jmlClaim += $post['qtyClaimAtas'][$key];
				}
			} else {
			if(isset($post['bagianAtas'])){
				foreach ($post['bagianAtas'] as $key => $bagianAtas) {
					$jmlAtas += $post['jmlAtas'][$key];
				}	
			}
			
		}	
		if (isset($post['bagianBwh'])) {
			if (isset($post['qtyBankeBwh']) && isset($post['qtyRejectBwh'])) {
				foreach ($post['bagianBwh'] as $key => $bagianBwh) {
					$jmlBaw += $post['jmlBwh'][$key];
					$jmlBankeBw += $post['qtyBankeBwh'][$key];
					$jmlRejectBw += $post['qtyRejectBwh'][$key];
					$jmlHilangBw += $post['qtyHilangBwh'][$key];
					$jmlClaimBw += $post['qtyClaimBwh'][$key];
				}
			} else {
				if(isset($post['bagianBwh'])){
					foreach ($post['bagianBwh'] as $key => $bagianBwh) {
						$jmlBaw += $post['jmlBwh'][$key];
					}
				}
			}
		}
		
		$jumlahTOtal = $jmlBaw + $jmlAtas;
		$jumlahGrandTotal = $jumlahTOtal;
		// pre($dataKelola);
		// pre($post);

		if (empty($dataKelola[0]['qty_tot_pcs'])) {
			$statusKeterang = 'AMAN';
		} else {
			if ($dataKelola[0]['qty_tot_pcs'] == $post['jumlahPotPcs']) {
				$statusKeterang = 'AMAN';
			} else {
				$statusKeterang = 'KURANG';
			}
		}

		// pre($jumlahGrandTotal);
		if ($jumlahGrandTotal == $post['jumlahPotPcs']) {
			$explodeCmtName = explode('-',$post['cmtName']);
			$explodeCmtJob = explode('-',$post['cmtJob']);

			$dataInput = $this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po' => $post['namaPo'],'id_master_cmt' => $explodeCmtName[0] ,'progress' => $post['progress'],'hapus'=>0));
			
			$dataInsertParent = array(
				'nama_cmt'		=>	$explodeCmtName[1],
				'id_master_cmt'	=>	$explodeCmtName[0],
				'id_master_cmt_job'=> $explodeCmtJob[0],
				'cmt_job_price'	=>	$explodeCmtJob[1],
				'kategori_cmt'	=>	$post['cmtKat'],
				'kode_po'		=>	$post['namaPo'],
				'qty_tot_pcs'	=>	$jumlahGrandTotal,
				'create_date'	=>	$post['tanggal'],
				'qty_tot_atas'	=>	$jmlAtas,
				'qty_tot_bawah'	=>	$jmlBaw,
				'progress'		=>	$post['progress'],
				'keterangan'	=>	$statusKeterang,
				'qty_bangke'	=>	$jmlBanke + $jmlBankeBw,
				'qty_reject'	=>	$jmlReject + $jmlRejectBw,
				'qty_hilang'	=>	$jmlHilang + $jmlHilangBw,
				'qty_claim'		=>	$jmlClaim + $jmlClaimBw,
				'tglinput'		=>date('Y-m-d'),

			);
			
			if (empty($dataInput)) {
				if ($post['cmtKat'] == "SABLON") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"SABLON",'updated_date'=>$post['tanggal']));
				} else if ($post['cmtKat'] == "BORDIR") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"BORDIR",'updated_date'=>$post['tanggal']));
				} elseif ($post['cmtKat'] == "JAHIT") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"JAHIT",'updated_date'=>$post['tanggal']));
				}

				$this->GlobalModel->insertData('kelolapo_kirim_setor',$dataInsertParent);
				$lastIdParent = $this->db->insert_id();
			} else {
				$this->session->set_flashdata('msg','INPUTAN SUDAH ADA, CEK DI VIEW DATA PENGECEKAN <audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/mandrakerja.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
					redirect(BASEURL.'kelolapo/kirimsetortambah/'.$post['namaPo']);
			}
			/*
			if (empty($dataInput)) {
				if ($post['cmtKat'] == "SABLON") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"SABLON",'updated_date'=>$post['tanggal']));
				} else if ($post['cmtKat'] == "BORDIR") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"BORDIR",'updated_date'=>$post['tanggal']));
				} elseif ($post['cmtKat'] == "JAHIT") {
					$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$post['namaPo']),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"JAHIT",'updated_date'=>$post['tanggal']));
				}

				$this->GlobalModel->insertData('kelolapo_kirim_setor',$dataInsertParent);
				$lastIdParent = $this->db->insert_id();
			} else {
				
				if (empty($post['kodeSetoran'])) {
					$this->session->set_flashdata('msg','INPUTAN SUDAH ADA, CEK DI VIEW DATA PENGECEKAN <audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/mandrakerja.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
					redirect(BASEURL.'kelolapo/kirimsetortambah/'.$post['namaPo']);
				} else {
					$this->session->set_flashdata('msg','INPUT NYA SANTAI AJA DONG, JANGAN DI SPAM!!!, SUDAH DI INPUT!  <audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/kunti.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
					redirect(BASEURL.'kelolapo/kirimsetorcek'.'/'.$post['namaPo'].'/'.$post['kodeSetoran']);
				}

			}
			*/

			foreach ($post['bagianAtas'] as $key => $bagianAtas) {
				$dataInserted = array(
					'kode_po'					=>	$post['namaPo'],
					'bagian_potongan_atas'		=>	$bagianAtas,
					'warna_potongan_atas'		=>	$post['warnaAtas'][$key],
					'jumlah_potongan'		=>	$post['jmlAtas'][$key],
					'keterangan_potongan'		=>	$post['keteranganAts'][$key],
					'created_date'		=>	$post['tanggal'],
					'qty_bangke_atas'	=>	(isset($post['qtyBankeAtas'][$key]) ? $post['qtyBankeAtas'][$key]:""),
					'id_kelolapo_kirim_setor'	=>	$lastIdParent,
					'qty_reject_atas'	=> (isset($post['qtyRejectAtas'][$key]) ? $post['qtyRejectAtas'][$key]:""),
					'qty_hilang_atas'	=> (isset($post['qtyHilangAtas'][$key]) ? $post['qtyHilangAtas'][$key]:""),
					'qty_claim_atas'	=> (isset($post['qtyClaimAtas'][$key]) ? $post['qtyClaimAtas'][$key]:"") 
				);
				$this->GlobalModel->insertData('kelolapo_kirim_setor_atas',$dataInserted);
			}

			if(isset($post['bagianBwh'])){
				
				foreach ($post['bagianBwh'] as $key => $bagianBwh) {
					$dataBawah = array(
						'kode_po'				=>	$post['namaPo'],
						'bagian_potongan_bawah'	=>	$bagianBwh,
						'warna_potongan_bawah'	=>	$post['warnaBwh'][$key],
						'jumlah_potongan'	=>	$post['jmlBwh'][$key],
						'keterangan_potongan'	=>	$post['keteranganBwh'][$key],
						'created_date'	=>	$post['tanggal'],
						'qty_bangke_bwh'	=>	(isset($post['qtyBankeBwh'][$key]) ? $post['qtyBankeBwh'][$key]:""),
						'id_kelolapo_kirim_setor'	=>	$lastIdParent,
						'qty_reject_bwh'	=>  (isset($post['qtyRejectBwh'][$key]) ? $post['qtyRejectBwh'][$key]:""),
						'qty_hilang_bwh'	=>  (isset($post['qtyHilangBwh'][$key]) ? $post['qtyHilangBwh'][$key]:""),
						'qty_claim_bwh'	=>  (isset($post['qtyClaimBwh'][$key]) ? $post['qtyClaimBwh'][$key]:"")
					);
					
					$this->GlobalModel->insertData('kelolapo_kirim_setor_bawah',$dataBawah);
				}
			}

		redirect(BASEURL.'kelolapo/kirimsetorcmt');	

		} else {
			$this->session->set_flashdata('msg','PERHATIKAN JUMLAH NYA!, BELAJAR NGITUNG LAGI SANA!!! <audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/apaantuh.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
			if (empty($post['kodeSetoran'])) {
				redirect(BASEURL.'kelolapo/kirimsetortambah/'.$post['namaPo']);
			} else {
				redirect(BASEURL.'kelolapo/kirimsetorcek'.'/'.$post['namaPo'].'/'.$post['kodeSetoran']);
			}

		}
			
		
	}

	public function kirimsetorcek($kode_po='',$idKelola='')
	{
		$viewData['poProd']	= $this->GlobalModel->queryManualRow('SELECT * FROM kelolapo_kirim_setor kks JOIN produksi_po pp ON kks.kode_po=pp.kode_po JOIN konveksi_buku_potongan kbp ON kks.kode_po=kbp.kode_po WHERE kks.kode_po="'.$kode_po.'" AND kks.id_kelolapo_kirim_setor='.$idKelola.'');
		$viewData['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt' => $viewData['poProd']['id_master_cmt']));
		$viewData['masterCmt'] = $this->GlobalModel->getDataRow('master_cmt_job',array('id_master_cmt_job' => $viewData['poProd']['id_master_cmt_job']));
		$viewData['progress'] = $this->GlobalModel->getData('master_progress',null);
		$viewData['parent']	= $this->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$viewData['atas'] = $this->GlobalModel->getData('kelolapo_kirim_setor_atas',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$viewData['bawah'] = $this->GlobalModel->getData('kelolapo_kirim_setor_bawah',array('kode_po'=>$kode_po,'id_kelolapo_kirim_setor'=>$idKelola));
		$viewData['page']='kelolapo/kirimsetorpotongan/kirim-setor-tambah-section';
		$this->load->view('newtheme/page/main',$viewData);

	}

	public function kirimmasalkecmtview($value='')
	{
		$viewData['nota'] = $this->GlobalModel->getData('kelola_po_nota_kirim_cmt',null);

		$this->load->view('global/header');
		$this->load->view('kelolapo/kirimsetorpotongan/kirim-setor-masal-view',$viewData);
		$this->load->view('global/footer');
	}

	public function kirimmasalkecmt($value='')
	{
		$viewData['poProd']	= $this->GlobalModel->getData('produksi_po',null);
		// pre($viewData);
		$viewData['cmt'] = $this->GlobalModel->getDataRow('master_cmt',null);
		$viewData['masterCmt'] = $this->GlobalModel->getDataRow('master_cmt_job',null);

		$viewData['progress'] = $this->GlobalModel->getData('master_progress',null);

		$this->load->view('global/header');
		$this->load->view('kelolapo/kirimsetorpotongan/kirim-setor-kirim-masal',$viewData);
		$this->load->view('global/footer');
	}

	public function kirimsetorPoMassalAct($value='')
	{
		$post = $this->input->post();
		pre($post);
		$cmtNExplode = explode('-', $post['cmtName']);

		$dataNota = array(
			'kode_nota_cmt'	=> $post['kodenota'].'TRF'.date('Ymd'),
			'created_date'	=> $post['tanggal'],
			'id_master_cmt'	=> $cmtNExplode[0]
		);
		$this->GlobalModel->insertData('kelola_po_nota_kirim_cmt',$dataNota);


		foreach ($post['kode_po'] as $key => $kodepo) {
		
		$dataInput = $this->GlobalModel->getData('kelolapo_kirim_setor',array('kode_po' => $kodepo,'kategori_cmt'=>$post['cmtKat'],'progress'=>$post['progress']));
		if (empty($dataInput)) {

			$cmtJExplode = explode('-', $post['cmtJob'][$key]);
			$dataSetor = array(
				'kode_nota_cmt'	=> $post['kodenota'],
				'id_master_cmt'	=> $cmtNExplode[0],
				'nama_cmt'	=> $cmtNExplode[1],
				'kategori_cmt'	=> $post['cmtKatTabl'][$key],
				'id_master_cmt_job'	=> $cmtJExplode[0],
				'cmt_job_price'	=> $cmtJExplode[1],
				'kode_po'	=> $kodepo,
				'qty_tot_pcs'	=> $post['jmlpo'][$key],
				'qty_tot_atas'	=> $post['jmlpo'][$key],
				'qty_tot_bawah'	=> $post['jmlpo'][$key],
				'progress'	=> $post['progress'],
				'create_date'	=> $post['tanggal'],
				'keterangan'	=> '-',
				'status'	=> 1
			);

			$this->GlobalModel->insertData('kelolapo_kirim_setor',$dataSetor);
			$lastId = $this->db->insert_id();

			if ($post['cmtKatTabl'][$key] == "SABLON") {
				$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$kodepo),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"SABLON"));
			} else if ($post['cmtKatTabl'][$key] == "BORDIR") {
				$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$kodepo),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"BORDIR"));
			} elseif ($post['cmtKatTabl'][$key] == "JAHIT") {
				$this->GlobalModel->updateData('produksi_po',array('kode_po'=>$kodepo),array('id_proggresion_po'=>$post['progress'],'progress_lokasi'=>"JAHIT"));
			}

			$explodeBgAtas = explode(', ', $post['rincianAtas'][$key]);
			
			foreach ($explodeBgAtas as $bgAtas) {
				if (!empty($bgAtas)) {
					$dataBagianAtas = array(
						'id_kelolapo_kirim_setor'	=> $lastId,						
						'kode_po'	=> $kodepo,
						'bagian_potongan_atas'	=> $bgAtas,
						'warna_potongan_atas'	=> '-',
						'jumlah_potongan'	=> $post['jmlpo'][$key],
						'keterangan_potongan'	=> '-',
						'created_date'	=> $post['tanggal'],
						'qty_bangke_atas'	=> 0,
						'qty_reject_atas'	=> 0,
						'qty_hilang_atas'	=> 0,
						'qty_claim_atas'	=> 0
					);
					$this->GlobalModel->insertData('kelolapo_kirim_setor_atas',$dataBagianAtas);
				}

			}

			$explodeBgBawah = explode(', ', $post['rincianBwh'][$key]);
			foreach ($explodeBgBawah as $bgBawah) {
				if (!empty($bgBawah)) {
					$dataBagianBawah = array(
						'id_kelolapo_kirim_setor'	=> $lastId,
						'kode_po'	=> $kodepo,
						'bagian_potongan_bawah'	=> $bgBawah,
						'warna_potongan_bawah'	=> '-',
						'jumlah_potongan'	=> $post['jmlpo'][$key],
						'keterangan_potongan'	=> '-',
						'created_date'	=> $post['tanggal'],
						'qty_bangke_bwh'	=> 0,
						'qty_reject_bwh'	=> 0,
						'qty_hilang_bwh'	=> 0,
						'qty_claim_bwh'		=> 0
					);
					$this->GlobalModel->insertData('kelolapo_kirim_setor_bawah',$dataBagianBawah);
				}
			}

		redirect(BASEURL.'kelolapo/kirimsetorcmt');

		} else {
			$this->session->set_flashdata('msg','UDAH DI INPUT, DI INPUT LAGI!!!<audio controls autoplay loop style="display:none;">
  <source src="'.BASEURL.'assets/mp3/apaantuh.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>');
			redirect(BASEURL.'kelolapo/kirimmasalkecmt');
		}

		}

	}

	public function kirimnotmassalprint($idkode='')
	{
		$viewData['nota'] = $this->GlobalModel->queryManualRow('SELECT * FROM kelola_po_nota_kirim_cmt kln JOIN master_cmt mc ON kln.id_master_cmt=mc.id_cmt WHERE kode_nota_cmt = "'.$idkode.'" ');
		$viewData['pokirim'] = $this->GlobalModel->queryManual('SELECT * FROM kelolapo_kirim_setor kks RIGHT JOIN produksi_po pp ON kks.kode_po=pp.kode_po WHERE kode_nota_cmt="'.$idkode.'"');

		foreach ($viewData['pokirim'] as $key => $poKirim) {
			$viewData['bagiankirimAts'][$key] = $this->GlobalModel->getData('kelolapo_kirim_setor_atas',array('id_kelolapo_kirim_setor' => $poKirim['id_kelolapo_kirim_setor']));
			$viewData['bagiankirimbBwh'][$key] = $this->GlobalModel->getData('kelolapo_kirim_setor_bawah',array('id_kelolapo_kirim_setor' => $poKirim['id_kelolapo_kirim_setor']));
		}
		// pre($viewData);
		$this->load->view('global/header');
		$this->load->view('kelolapo/kirimsetorpotongan/kirim-setor-masal-print',$viewData);
		$this->load->view('global/footer');
	}

	public function hapusdetailutama($id,$kode_po){
		$this->db->delete('konveksi_buku_potongan_utama',array('id_potongan_utama'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'kelolapo/bukupotonganDetail/'.$kode_po);
	}

	public function hapusdetailvariasi($id,$kode_po){
		$this->db->delete('konveksi_buku_potongan_variasi',array('id_potongan_utama'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'kelolapo/bukupotonganDetail/'.$kode_po);
	}
		
}