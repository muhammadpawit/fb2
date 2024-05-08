<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Masterdata extends CI_Controller {



	function __construct() {

		parent::__construct();

		//sessionLogin(URLPATH."\\".$this->uri->segment(1));

		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}

	}

	public function cucianhpp(){
		$data=[];
		$data['title']='Master Harga Cucian HPP';
		$jenis=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$no=0;
		foreach($jenis as $j){
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$j['id_jenis_po'],
				'nama'=>$j['nama_jenis_po'],
				'harga'=>$j['cucianhpp']
			);
		}
		$data['page']=$this->page.'masterdata/hargacucianhpp';
		$data['update']=BASEURL.'Masterdata/updatecucianhpp';
		$this->load->view($this->layout,$data);
	}

	public function updatecucianhpp(){
		$data=$this->input->post();
		//pre($data);
		foreach($data['products'] as $p){
			$cek=$this->GlobalModel->getDataRow('master_jenis_po',array('id_jenis_po'=>$p['id']));
			if($cek['cucianhpp']==$p['harga']){

			}else{
				$history=array(
					'tanggal'=>date('Y-m-d'),
					'id_jenis_po'=>$p['id'],
					'harga'=>$p['harga'],
				);
				$this->db->insert('cucianhpp_history',$history);
			}

			$update=array(
				'cucianhpp'=>$p['harga'],
			);
			$where=array(
				'id_jenis_po'=>$p['id'],
			);
			$this->db->update('master_jenis_po',$update,$where);
		}

		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Masterdata/cucianhpp');
	}

	public function hargapacking(){
		$data=[];
		$data['title']='Master harga packing';
		$jenis=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$no=0;
		$data['products']=[];
		foreach($jenis as $j){
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$j['id_jenis_po'],
				'nama'=>$j['nama_jenis_po'],
				'harga'=>$j['harga_packing']
			);
		}
		$data['page']=$this->page.'masterdata/hargapacking';
		$data['update']=BASEURL.'Masterdata/updatepacking';
		$this->load->view($this->layout,$data);
	}

	public function biayafinishing($page){
		$data=[];
		$data['title']='Master harga '.$page;
		$data['halaman']	=$page;
		if(strtolower($page)=='lobangkancing' || strtolower($page)=='pasangkancing' || strtolower($page)=='tress' || strtolower($page)=='buangbenang' 
		|| strtolower($page)=='cucian_finishing' || strtolower($page)=='pasang_kancing' ){
			$where =' AND idjenis IN(1) ';
		}else{
			$where='';
		}
		$jenis=$this->GlobalModel->QueryManual("SELECT id_jenis_po, nama_jenis_po, $page as harga FROM master_jenis_po WHERE status=1 $where ");
		// if( strtolower($page) =='cucian_finishing' ){
		// 	$jenis=$this->GlobalModel->QueryManual("SELECT id_jenis_po, nama_jenis_po, cucian_finishing as harga FROM master_jenis_po WHERE status=1 ");
		// }elseif( strtolower($page) =='buangbenang' ){

		// }elseif( strtolower($page) =='lobangkancing' ){

		// }elseif( strtolower($page) =='cucian_finishing' ){

		// }else{

		// }
		if(strtolower($page)=='lobangkancing' || strtolower($page)=='pasangkancing' || strtolower($page)=='tress' ){
			$hargaper='/ titik.';
		}else{
			$hargaper='/ pcs.';
		}

		$no=0;
		foreach($jenis as $j){
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$j['id_jenis_po'],
				'nama'=>$j['nama_jenis_po'],
				'harga'=>!empty($j['harga'])?$j['harga']:0,
				'sat'=>$hargaper,
			);
		}
		$data['page']=$this->page.'masterdata/hargapacking';
		$data['update']=BASEURL.'Masterdata/updatehargafinishing';
		$this->load->view($this->layout,$data);
	}

	public function updatehargafinishing(){
		$data=$this->input->post();
		//pre($data);
		foreach($data['products'] as $p){
			$update=array(
				$data['page']=>$p['harga'],
			);
			$where=array(
				'id_jenis_po'=>$p['id'],
			);
			$this->db->update('master_jenis_po',$update,$where);
		}
		//pre($update);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Masterdata/biayafinishing/'.$data['page']);
	}

	public function updatepacking(){
		$data=$this->input->post();
		//pre($data);
		foreach($data['products'] as $p){
			$update=array(
				'harga_packing'=>$p['harga'],
			);
			$where=array(
				'id_jenis_po'=>$p['id'],
			);
			$this->db->update('master_jenis_po',$update,$where);
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Masterdata/hargapacking');
	}

	public function price_packing_json()
	{
		$post = $this->input->get();
		$po = $this->GlobalModel->GetDataRow('produksi_po',array('kode_po'=>$post['kodepo']));
		//$jenis=substr($post['kodepo'],0,3);
		$jenis=!empty($po) ? $po['nama_po'] : '';
		$data = $this->GlobalModel->getDataRow('master_jenis_po',array('nama_jenis_po'=>$jenis));
		echo json_encode($data);
	}

	public function menugetsub(){
		$data=$this->input->get();
		$results=$this->GlobalModel->getData('menu',array('hapus'=>0,'parent_id'=>$data['parent_id']));
		
		echo "<option value='1'>Sub menu baru</option>";
		foreach($results as $r){
			echo "<option value='".$r['id']."'>".$r['nama']."</option>";
		}
	}

	public function menu(){
		$data=[];
		$data['title']='Daftar Menu';
		$results=$this->GlobalModel->getData('menu',array('hapus'=>0));
		//pre($results);
		foreach($results as $result){
			$data['menus'][]=array(
				'id'=>$result['id'],
				'nama'=>$result['nama'],
				'url'=>$result['url'],
				'edit'=>BASEURL.'Masterdata/editmenu/'.$result['id'],
				'delete'=>BASEURL.'Masterdata/hapusmenu/'.$result['id'],
			);
		}
		$data['page']=$this->page.'masterdata/menulist';
		$data['tambah']=BASEURL.'masterdata/menuadd';
		$this->load->view($this->page.'main',$data);
	}

	public function menuadd(){
		$data=[];
		$data['title']='Form Tambah Menu';
		$data['parent']=$this->GlobalModel->getData('menu',array('hapus'=>0,'parent'=>1));
		$data['sub1']=$this->GlobalModel->getData('menu',array('hapus'=>0,'sub1'=>1));
		$data['sub2']=$this->GlobalModel->getData('menu',array('hapus'=>0,'sub2'=>1));
		$data['sub3']=$this->GlobalModel->getData('menu',array('hapus'=>0,'sub3'=>1));
		$data['kembali']=BASEURL.'masterdata/menu';
		$data['action']=BASEURL.'masterdata/menusave';
		$data['page']=$this->page.'masterdata/menuadd';
		$this->load->view($this->page.'main',$data);
	}

	public function menusave(){
		$data=$this->input->post();
		//pre($data);
		if($data['parent_id']==0){
			$parent_id=0;
			$insert=array(
				'nama'=>$data['nama'],
				'url'=>$data['url'],
				'parent'=>1,
				'parent_id'=>0,
				'sub1'=>0,
				'sub2'=>0,
				'sub3'=>0,
				'icon'=>$data['icon'],
				'hapus'=>0
			);
		}else{
			$pid=$data['parent_id'];
			$s1=$data['sub1'];
			$s2=$data['sub2'];
			if($data['sub1']>1 && $data['sub2']>1 ){
				$pid=$data['sub2'];
				$s1=0;
				$s2=0;
			}else if($data['sub1']>0){
				$pid=$data['sub1'];
			}else{
				$pid=$data['parent_id'];
			}


			$insert=array(
				'nama'=>$data['nama'],
				'url'=>$data['url'],
				'parent'=>$data['parent_id']==0?1:0,
				'parent_id'=>$pid,
				'sub1'=>$s1,
				'sub2'=>$s2,
				'sub3'=>$data['sub3'],
				'icon'=>$data['icon'],
				'hapus'=>0
			);
		}
		
		//pre($insert);
		
		$this->db->insert('menu',$insert);
		$menuid=$this->db->insert_id();
		$ia=array(
			'userid'=>11,
			'menuid'=>$menuid
		);
		$this->db->insert('usermenu',$ia);
		$this->session->set_flashdata('msg','Data menu '.$data['nama'].' Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/menu');
	}

	public function hapusmenu($id){
		$this->db->query("UPDATE menu set hapus=1 WHERE id='$id' ");
		$this->session->set_flashdata('msg','Menu Berhasil Dihapus');
		redirect(BASEURL.'Masterdata/menu');
	}

	public function editmenu($id){
		$data=[];
		$data['title']='Edit Menu';
		$data['m']=$this->GlobalModel->GetDataRow('menu',array('id'=>$id));
		$data['parent']=$this->GlobalModel->getData('menu',array('hapus'=>0,'parent'=>1));
		$data['sub1']=$this->GlobalModel->getData('menu',array('hapus'=>0,'sub1'=>1));
		$data['sub2']=$this->GlobalModel->getData('menu',array('hapus'=>0,'sub2'=>1));
		$data['sub3']=$this->GlobalModel->getData('menu',array('hapus'=>0,'sub3'=>1));
		$data['kembali']=BASEURL.'masterdata/menu';
		$data['action']=BASEURL.'Masterdata/editmenu_save';
		$data['page']=$this->page.'masterdata/menu_edit';
		$this->load->view($this->page.'main',$data);
	}

	public function editmenu_save(){
		$data=$this->input->post();
		//pre($data);
		if($data['parent_id']==0){
			$parent_id=0;
			$insert=array(
				'nama'=>$data['nama'],
				//'url'=>$data['url'],
				'parent'=>1,
				'parent_id'=>0,
				'sub1'=>0,
				'sub2'=>0,
				'sub3'=>0,
				'icon'=>$data['icon'],
				'hapus'=>0
			);
		}else{
			$pid=$data['parent_id'];
			$s1=$data['sub1'];
			$s2=$data['sub2'];
			if($data['sub1']>1 && $data['sub2']>1 ){
				$pid=$data['sub2'];
				$s1=0;
				$s2=0;
			}else if($data['sub1']>1){
				$pid=$data['sub1'];
			}else{
				$pid=$data['parent_id'];
			}


			$insert=array(
				'nama'=>$data['nama'],
				'url'=>$data['url'],
				'parent'=>$data['parent_id']==0?1:0,
				'parent_id'=>$pid,
				'sub1'=>$s1,
				'sub2'=>$s2,
				'sub3'=>$data['sub3'],
				'icon'=>$data['icon'],
				'hapus'=>0
			);
		}
		
		//pre($data);
		$this->db->update('menu',$insert,array('id'=>$data['id']));
		$this->session->set_flashdata('msg','Data menu '.$data['nama'].' Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/menu');
	}


	public function lokasicmt(){
		$data=[];
		$data['products']=[];
		$data['title']='Master Lokasi CMT';
		$sql="SELECT * FROM lokasi_cmt WHERE hapus=0 ";
		$sql.=" ORDER BY lokasi";
		$results=$this->GlobalModel->queryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$r['id'],
				'lokasi'=>strtolower($r['lokasi']),
				'edit'=>null,
				'hapus'=>null,
			);
		}
		$data['page']=$this->page.'masterdata/lokasicmt';
		$data['action']=BASEURL.'Masterdata/lokasicmtsave';
		$this->load->view($this->layout,$data);
	}

	public function lokasicmtsave(){
		$data=$this->input->post();
		$insert=array(
			'lokasi'=>strtolower($data['lokasi']),
			'hapus'=>0,
		);
		$this->db->insert('lokasi_cmt',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/lokasicmt');
	}

	public function timpotong(){
		$data=array();
		$data['n']=1;
		$data['products']=array();
		$data['title']="Master Data Tim Potong";
		$data['edit']=BASEURL.'Masterdata/hargapotonganeditsave';
		$data['hapus']=BASEURL.'Masterdata/hargapotonganhapus/';
		$data['action']=BASEURL.'Masterdata/timpotongsave';
		$data['page']=$this->page.'masterdata/timpotong_list';
		$data['products']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	function detailtimpot(){
		$post = $this->input->post();
		$data = $this->GlobalModel->QueryManualRow("SELECT * FROM timpotong WHERE id='".$post['id']."' ");
		echo json_encode($data);
	}

	function edittimpotong(){
		$post = $this->input->post();
		$update = array(
			'nama' => $post['nama']
		);
		$where = array(
			'id' => $post['id']
		);
		$this->db->update(
			'timpotong',
			$update,
			$where
		);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/timpotong');
	}

	public function timpotongsave(){
		$data=$this->input->post();
		$insert=array(
			'nama'=>$data['nama'],
			'hapus'=>0,
		);
		$this->db->insert('timpotong',$insert);
		$insert2=array(
			'nama'=>$data['nama'],
		);
		$this->db->insert('bagian_pengambilan',$insert2);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/timpotong');
	}

	public function hargapotongan(){
		$data=array();
		$data['n']=1;
		$data['products']=array();
		$data['title']="Master Harga Potongan";
		$data['edit']=BASEURL.'Masterdata/hargapotonganeditsave';
		$data['hapus']=BASEURL.'Masterdata/hargapotonganhapus/';
		$data['action']=BASEURL.'Masterdata/hargapotongansave';
		$data['page']=$this->page.'masterdata/hargapotongan_list';
		$data['jenis']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$data['products']=$this->GlobalModel->getData('master_harga_potongan',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	public function hargapotongansave(){
		$data=$this->input->post();
		$insert=array(
			'nama_jenis_po'=>$data['jenis'],
			'harga_potongan'=>$data['nominal'],
			'resiko_potongan'=>0,
			'hapus'=>0
		);
		$this->db->insert('master_harga_potongan',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/hargapotongan');
	}

	public function hargapotonganeditsave(){
		$data=$this->input->post();
		foreach($data['products'] as $p){
			$update=array(
				'harga_potongan'=>$p['harga_potongan'],
			);
			$this->db->update('master_harga_potongan',$update,array('id_master_harga_potongan'=>$p['id_master_harga_potongan']));
		}
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/hargapotongan');
	}

	public function hargapotonganhapus($id){
		$update=array(
				'hapus'=>1,
			);
			$this->db->update('master_harga_potongan',$update,array('id_master_harga_potongan'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect(BASEURL.'Masterdata/hargapotongan');
	}

	public function hargajob($id){
		$data=array();
		$user=user();
		$edit=0;
		$hapus=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
			$hapus=akses($user['id_user'],2);
		}
		if($id==1){
			$title="jahit";
		}else{
			$title="Sablon";
		}
		$data['title']='Master Harga Pekerjaan '.$title;
		$data['edit']=$edit;
		$data['hapus']=$hapus;
		$data['action']=BASEURL.'Masterdata/hargajobsave';
		$data['n']=1;
		$data['products']=array();
		$data['products']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>$id));
		$data['page']=$this->page.'masterdata/hargajob_list';
		$this->load->view($this->layout,$data);
	}

	public function edithargacmt($id){
		$data=array();
		$data['title']='Edit Harga Pekerjaan ';
		$data['action']=BASEURL.'Masterdata/hargajobeditsave';
		$data['cancel']=BASEURL.'Masterdata/hargajob/'.$id;
		$data['n']=1;
		$data['products']=array();
		$data['products']=$this->GlobalModel->getDataRow('master_job',array('id'=>$id));
		$data['page']=$this->page.'masterdata/hargajob_edit';
		$this->load->view($this->layout,$data);	
	}

	public function hargajobsave(){
		$data=$this->input->post();
		$insert=array(
			'nama_job'=>$data['nama_job'],
			'harga'=>$data['harga'],
			'jenis'=>$data['jenis'],
			'keterangan'=>$data['keterangan'],
		);
		$this->db->insert('master_job',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/hargajob/'.$data['jenis']);
	}

	public function hargajobeditsave(){
		$data=$this->input->post();
		$update=array(
			'nama_job'=>$data['nama_job'],
			'harga'=>$data['harga'],
			'jenis'=>$data['jenis'],
			'keterangan'=>$data['keterangan'],
		);
		$this->db->update('master_job',$update,array('id'=>$data['id']));
		$this->session->set_flashdata('msg','Data Berhasil Diedit');
		redirect(BASEURL.'Masterdata/hargajob/'.$data['jenis']);
	}

	public function hapushargacmt($id){
		$update=array(
			'hapus'=>1,
		);
		$this->db->update('master_job',$update,array('id'=>$id));
		$s=$this->GlobalModel->getDataRow('master_job',array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect(BASEURL.'Masterdata/hargajob/'.$s['jenis']);
	}

	public function cmt(){
		$data=array();
		$data['title']='Masterdata CMT';
		$data['n']=1;
		$get=$this->input->get();
		if(isset($get['lokasi'])){
			$lokasi=$get['lokasi'];
			$data['products'] = $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'JAHIT','lokasi'=>$lokasi,'hapus'=>0));
		}else{
			$lokasi=null;
			$data['products'] = $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'JAHIT','hapus'=>0));
		}
		$data['tambah']=BASEURL.'Masterdata/cmtadd';
		$data['page']='newtheme/page/masterdata/cmt_list';
		$user=user();
		$edit=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
		}
		$data['edit']=$edit;
		$this->load->view('newtheme/page/main',$data);
	}

	public function ongkoshpp($id){
		$data=[];
		$data['title']='Ongkos Untuk HPP';
		$data['prods']=[];
		$prods=$this->GlobalModel->getData('biaya_hpp',array('hapus'=>0,'idcmt'=>$id));
		foreach($prods as $p){
			$data['prods'][]=array(
				'namapo'=>$p['namapo'],
				'namabiaya'=>$p['namabiaya'],
				'biaya'=>$p['biaya'],
				'keterangan'=>$p['keterangan'],
				'hapus'=>BASEURL.'Masterdata/ongkoshpp_hapus/'.$p['id'].'/'.$p['idcmt'],
			);
		}
		$data['jenispo']=$this->GlobalModel->getData('master_jenis_po',array('status'=>1));
		$data['biaya']=array(
			array('nama'=>'Tress & Gosok'),
			array('nama'=>'Packing'),
			array('nama'=>'Gosok'),
			array('nama'=>'Packing'),
		);
		$data['action']=BASEURL.'Masterdata/ongkoshpp_save';
		$data['batal']=BASEURL.'Masterdata/cmt';
		$data['idcmt']=$id;
		$data['page']='newtheme/page/masterdata/cmt_ongkoshpp';
		$this->load->view($this->layout,$data);
	}

	public function ongkoshpp_save(){
		$p=$this->input->post();
		$insert=array(
			'idcmt'=>$p['idcmt'],
			'namapo'=>$p['namapo'],
			'namabiaya'=>$p['namabiaya'],
			'biaya'=>$p['biaya'],
			'keterangan'=>$p['keterangan'],
			'hapus'=>0,
		);
		$this->db->insert('biaya_hpp',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/ongkoshpp/'.$p['idcmt']);
	}

	public function ongkoshpp_hapus($id,$cmt){
		$update=array(
			'hapus'=>1
		);
		$where=array(
			'id'=>$id
		);
		$this->db->update('biaya_hpp',$update,$where);
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect(BASEURL.'Masterdata/ongkoshpp/'.$cmt);
	}


	public function daftarhargacmt($id){
		$data=[];
		$data['title']='Tambah daftar harga cmt';
		$data['id']=$id;
		$data['c']=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$id));
		$data['page']=$this->page.'masterdata/hargacmt_add';
		$data['ongkos']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['action']=BASEURL.'Masterdata/daftarhargacmt_save';
		$this->load->view('newtheme/page/main',$data);
	}

	public function json_ongkos(){
		$data=$this->input->get();
		$r = $this->GlobalModel->getDataRow('master_job',array('id'=>$data['id']));
		echo json_encode($r);
	}

	public function daftarhargacmt_save(){
		$post=$this->input->post();
		//pre($post);
		foreach($post['products'] as $data){
			$insert=array(
				'idcmt'=>$post['idcmt'],
				'namapo'=>$data['namapo'],
				'hargalama'=>$data['hargalama'],
				'hargabaru'=>$data['hargabaru'],
				'keterangan'=>$data['keterangan'],
				'hapus'=>0,
			);
			$this->db->insert('daftarharga_cmt',$insert);
		}
		
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/cmt');
	}

	public function cmtsablon(){
		$data=array();
		$data['n']=1;
		//$data['products']=$this->GlobalModel->getData('master_cmt',array());
		$this->load->database();
		$jumlah_data = $this->GlobalModel->jumlah_data('master_cmt');
		$this->load->library('pagination');
		$config['base_url'] = BASEURL.'Masterdata/cmt';
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

		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);		
		//$data['products'] = $this->GlobalModel->data('master_cmt',$config['per_page'],$from);
		$data['products'] = $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'SABLON','hapus'=>0));
		$data['tambah']=BASEURL.'Masterdata/cmtadd';
		$data['page']='newtheme/page/masterdata/cmt_list';
		$user=user();
		$edit=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
		}
		$data['edit']=$edit;
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');
	}

	public function cmthapus($kode){
		$this->db->update('master_cmt',array('hapus'=>1),array('id_cmt'=>$kode));
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect(BASEURL.'Masterdata/cmt');
	}

	public function cmtcucian(){
		$data=array();
		$data['title']='Masterdata Cucian CMT';
		$data['n']=1;
		$get=$this->input->get();
		if(isset($get['lokasi'])){
			$lokasi=$get['lokasi'];
			$data['products'] = $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'CUCIAN','lokasi'=>$lokasi,'hapus'=>0));
		}else{
			$lokasi=null;
			$data['products'] = $this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'CUCIAN','hapus'=>0));
		}
		$data['tambah']=BASEURL.'Masterdata/cmtcucianadd';
		$data['page']='newtheme/page/masterdata/cmt_list';
		$user=user();
		$edit=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
		}
		$data['edit']=$edit;
		$this->load->view('newtheme/page/main',$data);
	}

	public function cmtcucianadd(){
		$data=array();
		$data['title']='Form tambah data cmt cucian';
		$data['cmtcucian']=true;
		$data['lokasi']=$this->GlobalModel->getData('lokasi_cmt',array('hapus'=>0));
		$data['page']='newtheme/page/masterdata/cmt_add';
		$data['action']=BASEURL.'Masterdata/cmtsavecucian';
		$data['batal']=BASEURL.'Masterdata/cmtcucian';
		$this->load->view('newtheme/page/main',$data);
	}

	public function cmtsavecucian(){
		$data=$this->input->post();
			$cmt=array(
				'cmt_name'=>$data['cmt_name'],
				'telephone'=>$data['telephone'],
				'cmt_job_desk'=>$data['cmt_job_desk'],
				'email'=>$data['email'],
				'alamat'=>$data['alamat'],
				'cmt_resiko'=>0,
				'lokasi'=>$data['lokasi'],
				'jenis_po'=>$data['jenis_po'],
				'keterangan'=>$data['keterangan'],
			);
			$this->db->insert('master_cmt',$cmt);
			$id=$this->db->insert_id();
			if(isset($data['products'])){
			foreach($data['products'] as $p){
				$jc=array(
					'cmt_job_parent'=>$id,
					'cmt_job_jenis'=>$p['cmt_job_jenis'],
					'cmt_job_price'=>$p['cmt_job_price']
				);
				$this->db->insert('master_cmt_job',$jc);
			}
			}
			$this->session->set_flashdata('msg','Data Berhasil Disimpan');
			if($data['cmt_job_desk']=="SABLON"){
				redirect(BASEURL.'Masterdata/cmtsablon');
			}else{
				redirect(BASEURL.'Masterdata/cmtcucian');
			}
	}

	public function cmtadd(){
		$data=array();
		$data['title']='Form tambah data cmt';
		$data['lokasi']=$this->GlobalModel->getData('lokasi_cmt',array('hapus'=>0));
		$data['page']='newtheme/page/masterdata/cmt_add';
		$data['action']=BASEURL.'Masterdata/cmtsave';
		$data['batal']=BASEURL.'Masterdata/cmt';
		$this->load->view('newtheme/page/main',$data);
	}
	public function cmtedit($id){
		$data=array();
		$data['page']='newtheme/page/masterdata/cmt_edit';
		$data['cmt']=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$id));
		$data['jobcmt']=$this->GlobalModel->getData('master_cmt_job',array('cmt_job_parent'=>$id));
		$data['lokasi']=$this->GlobalModel->getData('lokasi_cmt',array('hapus'=>0));
		$data['action']=BASEURL.'Masterdata/editcmtsave';
		$this->load->view('newtheme/page/main',$data);
	}

	public function editcmtsave(){
		$data=$this->input->post();
			$update=array(
				'cmt_name'=>$data['cmt_name'],
				'telephone'=>$data['telephone'],
				'cmt_job_desk'=>$data['cmt_job_desk'],
				'email'=>$data['email'],
				'alamat'=>$data['alamat'],
				'lokasi'=>$data['lokasi'],
				'jenis_po'=>$data['jenis_po'],
				'keterangan'=>$data['keterangan'],
				'bank'=>$data['bank'],
				'an'=>$data['an'],
				'norek'=>$data['norek'],
			);
			$this->db->update('master_cmt',$update,array('id_cmt'=>$data['id_cmt']));
			$this->db->query("DELETE FROM master_cmt_job WHERE cmt_job_parent='".$data['id_cmt']."' ");
			if(isset($data['prd'])){
				foreach($data['prd'] as $p){
					$jc=array(
						'cmt_job_parent'=>$data['id_cmt'],
						'cmt_job_jenis'=>$p['cmt_job_jenis'],
						'cmt_job_price'=>$p['cmt_job_price']
					);
					$this->db->insert('master_cmt_job',$jc);
				}
			}
			$this->session->set_flashdata('msg','Data Berhasil Disimpan');
			if($data['cmt_job_desk']=="SABLON"){
				redirect(BASEURL.'Masterdata/cmtsablon');
			}else{
				redirect(BASEURL.'Masterdata/cmt');
			}
	}
	public function cmtsave(){
		$data=$this->input->post();
			$cmt=array(
				'cmt_name'=>$data['cmt_name'],
				'telephone'=>$data['telephone'],
				'cmt_job_desk'=>$data['cmt_job_desk'],
				'email'=>$data['email'],
				'alamat'=>$data['alamat'],
				'cmt_resiko'=>0,
				'lokasi'=>$data['lokasi'],
				'jenis_po'=>$data['jenis_po'],
				'keterangan'=>$data['keterangan'],
			);
			$this->db->insert('master_cmt',$cmt);
			$id=$this->db->insert_id();
			if(isset($data['products'])){
			foreach($data['products'] as $p){
				$jc=array(
					'cmt_job_parent'=>$id,
					'cmt_job_jenis'=>$p['cmt_job_jenis'],
					'cmt_job_price'=>$p['cmt_job_price']
				);
				$this->db->insert('master_cmt_job',$jc);
			}
			}
			$this->session->set_flashdata('msg','Data Berhasil Disimpan');
			if($data['cmt_job_desk']=="SABLON"){
				redirect(BASEURL.'Masterdata/cmtsablon');
			}else{
				redirect(BASEURL.'Masterdata/cmt');
			}
	}

	public function jabatan(){
		$data=array();
		$data['title']='Masterdata Jabatan';
		$data['action']=BASEURL.'Masterdata/jabatansave';
		$data['n']=1;
		$data['page']='newtheme/page/masterdata/jabatan_list';
		//$data['products']=$this->GlobalModel->getData('master_cmt',array());
		$this->load->database();
		$jumlah_data = $this->GlobalModel->jumlah_data('jabatan');
		$this->load->library('pagination');
		$config['base_url'] = BASEURL.'Masterdata/jabatan';
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
		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);		
		$data['products'] = $this->GlobalModel->data('jabatan',$config['per_page'],$from);
		$data['hapus']=BASEURL.'Masterdata/jabatanhapus/';
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');
	}

	public function jabatansave(){
		$post=$this->input->post();
		$insert=array(
			'nama'=>$post['nama'],
			'hapus'=>0
		);
		$this->db->insert('jabatan',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
			redirect(BASEURL.'Masterdata/jabatan');
	}

	public function jabatanhapus($id){
		$insert=array(
			'hapus'=>1
		);
		$this->db->update('jabatan',$insert,array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
			redirect(BASEURL.'Masterdata/jabatan');
	}

	public function divisi(){
		$data=array();
		$data['title']='Master Divisi';
		$data['action']=BASEURL.'Masterdata/divisisave';
		$data['n']=1;
		$data['page']=$this->page.'masterdata/divisi_list';
		$data['products']=$this->db->query('SELECT * FROM divisi WHERE hapus=0 ORDER BY urutan')->result_array();
		$this->load->view($this->page.'main',$data);
	}

	public function divisisave(){
		$post=$this->input->post();
		$insert=array(
			'nama'=>$post['nama'],
			'hapus'=>0
		);
		$this->db->insert('divisi',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/divisi');
	}

	public function hapusdivisi($id){
		$this->db->update('divisi',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect(BASEURL.'Masterdata/divisi');
	}

	public function karyawan(){
		$data=array();
		$data['title']='Master Data Karyawan';
		$data['action']=BASEURL.'Masterdata/karyawansave';
		$data['n']=1;
		$data['page']='newtheme/page/masterdata/karyawan_list';
		//$data['products']=$this->GlobalModel->getData('master_cmt',array());
		$this->load->database();
		$jumlah_data = $this->GlobalModel->jumlah_data('karyawan');
		$this->load->library('pagination');
		$config['base_url'] = BASEURL.'Masterdata/karyawan';
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
		$from = $this->uri->segment(3);
		$this->pagination->initialize($config);		
		//$products = $this->GlobalModel->data('karyawan',$config['per_page'],$from);
		$products = $this->GlobalModel->getData('karyawan',array('hapus'=>0));
		$data['products']=array();
		$tahun=null;
		$bulan=null;
		$hari=null;
		$user=user();
		$edit=0;
		$hapus=0;
		$gaji=0;
		if(isset($user['id_user'])){
			$edit=akses($user['id_user'],1);
			$hapus=akses($user['id_user'],2);
		}
		foreach($products as $p){
			$tanggala = date('Y-m-d',strtotime($p['tglmasuk']));
			$tanggal = new DateTime($tanggala); 
			if($p['status_resign']==1){
				$sekarang = new DateTime();
				$perbedaan = $tanggal->diff($sekarang);
			}else{
				$sekarang = new DateTime($p['tglkeluar']);
				$perbedaan = $tanggal->diff($sekarang);
			}
			$jabatan=$this->GlobalModel->getDataRow('jabatan',array('id'=>$p['jabatan']));
			$divisi=$this->GlobalModel->getDataRow('divisi',array('id'=>$p['divisi']));
			$data['products'][]=array(
				'tglmasuk'=>date('d F Y',strtotime($p['tglmasuk'])),
				'id'=>$p['id'],
				'nik'=>$p['nik'],
				'nama'=>strtolower($p['nama']),
				'divisi'=>!empty($divisi) ? strtolower($divisi['nama']) : '',
				'jabatan'=>!empty($jabatan) ? strtolower($jabatan['nama']) : '',
				'gajipokok'=>number_format($p['gajipokok']),
				'masakerja'=>$perbedaan,
				'status_resign'=>$p['status_resign'],
				'tglkeluar'=>!empty($p['tglkeluar']) ? date('d F Y',strtotime($p['tglkeluar'])) : '',
			);
		}
		$data['jabatan']=$this->GlobalModel->getData('jabatan',array('hapus'=>0));
		$data['divisi']=$this->GlobalModel->getData('divisi',array('hapus'=>0));
		$nik=$this->GlobalModel->queryManualRow("SELECT * FROM karyawan WHERE hapus=0 ORDER BY id DESC LIMIT 1");
		$data['nik']=$nik['nik']+1;
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');
	}

	public function karyawansave(){
		$post=$this->input->post();
		$insert=array(
			'nik'=>$post['nik'],
			'nama'=>$post['nama'],
			'tglmasuk'=>$post['tglmasuk'],
			'jk'=>$post['jk'],
			'divisi'=>$post['divisi'],
			'jabatan'=>$post['jabatan'],
			'gajipokok'=>$post['gajipokok'],
			'hapus'=>0
		);
		$this->db->insert('karyawan',$insert);
		$this->session->set_flashdata('msg','Data Berhasil Disimpan');
		redirect(BASEURL.'Masterdata/karyawan');
	}

	public function karyawanedit($id){
		$data=array();
		$data['title']='Edit Data Karyawan';
		$data['jabatan']=$this->GlobalModel->getData('jabatan',array('hapus'=>0));
		$data['divisi']=$this->GlobalModel->getData('divisi',array('hapus'=>0));
		$data['products']=$this->GlobalModel->getDataRow('karyawan',array('id'=>$id));
		$data['action']=BASEURL.'Masterdata/karyawaneditsave';
		$data['batal']=BASEURL.'Masterdata/karyawan';
		$data['page']=$this->page.'masterdata/karyawan_edit';
		$this->load->view($this->page.'main',$data);
	}


	public function karyawaneditsave(){
		$post=$this->input->post();
		//pre($post);
		if($post['status_resign']==2){
			$tglkeluar=$post['tglkeluar'];
		}else{
			$tglkeluar=null;
		}
		$insert=array(
			'nik'=>$post['nik'],
			'nama'=>$post['nama'],
			'tglmasuk'=>$post['tglmasuk'],
			'jk'=>$post['jk'],
			'divisi'=>$post['divisi'],
			'jabatan'=>$post['jabatan'],
			'gajipokok'=>$post['gajipokok'],
			'status_resign'=>$post['status_resign'],
			'tglkeluar'=>$tglkeluar,
			'hapus'=>0
		);
		$this->db->update('karyawan',$insert,array('id'=>$post['id']));
		$this->session->set_flashdata('msg','Data Berhasil Diubah');
			redirect(BASEURL.'Masterdata/karyawan');
	}

	public function karyawanhapus($id){
		$this->db->update('karyawan',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Dihapus');
		redirect(BASEURL.'Masterdata/karyawan');
	}

	public function karyawanget(){
		$data=$this->input->get();
		$sql="SELECT d.id,d.nama from divisi d JOIN karyawan k ON(k.divisi=d.id) WHERE k.id='".$data['id']."' ";
		$k=$this->db->query($sql)->row_array();
		echo json_encode($k);
	}

	public function Persediaan(){
		$data=array();
		$data['title']='Master Persediaan';
		$data['products']=array();
		$data['action']=BASEURL.'Masterdata/Productsave';
		$data['url']=BASEURL.'Masterdata/Persediaan';
		$data['kat']=$this->GlobalModel->getData('kategori_barang',array());
		$get=$this->input->get();
		if(isset($get['product_id'])){
			$product_id=$get['product_id'];
		}else{
			$product_id=null;
		}
		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=null;
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
		}else{
			$kategori=null;
		}
		$data['kate']	= $kategori;

		$data['i']=1;
			$filter=array(
				'hapus'=>0,
				'product_id'=>$product_id,
				'jenis'=>$jenis,
			);
		$results=array();
		$sql="SELECT * FROM product WHERE hapus=0 ";
		$url='';
		if(!empty($product_id)){
			//$sql.=" AND product_id='".$product_id."' ";
			//$url.="&product_id=".$product_id;
			$sql.=" AND lower(nama) LIKE '".strtolower($product_id)."%' ";
			$url.="&product_id=".$product_id;
		}
		if(!empty($jenis)){
			$sql.=" AND jenis='".$jenis."' ";
			$url.="&jenis=".$jenis;
		}
		if(!empty($kategori)){
			$sql.=" AND kategori='".$kategori."' ";
			$url.="&kategori=".$kategori;
		}
		if(isset($get['pdf']) && $kategori==1){
			$sql.=" AND quantity >=200 ";
		}
		$results = $this->GlobalModel->QueryManual($sql);
		$satuan=0;
		$supplier=null;
		$color='white';
		$jenis=null;
		foreach($results as $result){
			$action=array();
			
			$action[] = array(
				'text' => 'Edit',
				'href' => BASEURL.'Masterdata/Edit/'.$result['product_id'],
			);
			
			if(akseshapus()==1){
				$action[] = array(
					'text' => 'Hapus',
					'href' => BASEURL.'Masterdata/hapus/'.$result['product_id'],
				);
			}
			$satuan = $this->GlobalModel->getDataRow('master_satuan_barang',array('id_satuan_barang'=>$result['satuan']));
			
				$supplier=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$result['supplier']));
			


			$data['products'][]=array(
				'supplier'=>!empty($supplier)?$supplier['nama']:'-',
				'foto'=>$result['foto'],
				'jenis'=>$result['jenis']==4?'Bahan':'',
				'product_id'=>$result['product_id'],
				'kodebarang'=>$result['kodebarang'],
				'nama'=>strtoupper($result['nama']),
				//'satuan'=>$satuan['kode_satuan_barang'],
				'ukuran_item'=>is_numeric($result['ukuran_item'])?number_format($result['ukuran_item'],2):$result['ukuran_item'],
				'satuan_ukuran_item'=>$result['satuan_ukuran_item'],
				'quantity'=>$result['quantity'],
				'minstok'=>$result['minstok'],
				'satuanqty'=>$result['satuan'],
				'color'=>$result['jenis']==4?'#ed8664':'',
				'price'=>($result['price']),
				'harga_beli'=>$result['harga_beli'],
				'harga_skb'=>$result['harga_skb'],
				'action'=>$action,
			);
		}
		//pre($results);
		$data['satuan']=$this->GlobalModel->getData('master_satuan_barang',array());
		$data['prods']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['kat']=$this->GlobalModel->getData('kategori_barang',array('hapus'=>0));
		$data['kate']=$kategori;
		$data['pdf']=BASEURL.'Masterdata/persediaan?&pdf=true'.$url;
		$data['supplier'] = $this->GlobalModel->queryManual('SELECT * FROM master_supplier WHERE hapus=0  ORDER BY nama ASC');
		if(isset($get['pdf'])){
			$html =  $this->load->view('newtheme/page/masterdata/persediaan_pdf',$data,true);
			$this->load->library('pdfgenerator');	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Laporan Persediaan';
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Laporan_Persediaan';
	        // setting paper
	        $paper = 'A4';
	        //orientasi paper potrait / landscape
	        $orientation = "potrait";
			$this->load->view('laporan_pdf',$this->data, true);	    
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			$data['page']='newtheme/page/masterdata/persediaan';
			$this->load->view('newtheme/page/main',$data);
		}
		
	}

	public function edit($id){
		$data['title']='Edit Master Persediaan';
		$data['batal']=BASEURL.'Masterdata/persediaanalat';
		$data['action']=BASEURL.'Masterdata/editsave';
		$data['page']=$this->page.'masterdata/persediaan_edit';	
		$data['prod']=$this->GlobalModel->getDataRow('product',array('product_id'=>$id));
		$data['kat']=$this->GlobalModel->getData('kategori_barang',array('hapus'=>0));
		$data['pgudang']=$this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$id));
		$data['supplier'] = $this->GlobalModel->queryManual('SELECT * FROM master_supplier WHERE hapus=0  ORDER BY nama ASC');
		$this->load->view('newtheme/page/main',$data);
	}

	public function editsave(){
		$post=$this->input->post();
		// pre($_FILES['gambarPO1']['name']);
		$id=$post['product_id'];
		if (isset($_FILES['gambarPO1']['name'])) {
			if(!empty($_FILES['gambarPO1']['name'])){
				$config['upload_path']          = './uploads/persediaan/';
				$config['allowed_types']        = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				$this->upload->do_upload('gambarPO1');
				$fileName = $this->upload->data('file_name');
				$this->db->update('product',array('foto'=>$fileName),array('product_id'=>$id));
			}
		}
		$u=array(
			'minstok'=>$post['minstok'],
			'nama'=>$post['nama'],
			'warna_item'=>$post['warna'],
			'supplier'=>$post['supplier'],
			'jenis'=>$post['jenis'],
			'kategori'=>$post['kategori'],
			'satuan'=>$post['satuan'],
			'price'	=>$post['price'], // harga di hpp
			'harga_beli'=>$post['harga_beli'], //harga untuk laporan rekap 
			'harga_skb'=>$post['harga_skb'], //harga untuk sj sukabumi
			'tipe' => $post['tipe'],
			'status' => $post['status'],
			'keterangan_tipe' => $post['keterangan_tipe'],
			'accsatuan' => $post['accsatuan'],
		);
		$this->db->update('product',$u,array('product_id'=>$id));
		$ug=array(
			'nama_item'=>$post['nama'],
			'warna_item'=>$post['warna'],
			'supplier'=>$post['supplier'],
			'jenis'=>$post['jenis'],
			'satuan_jumlah_item'=>$post['satuan'],
			'harga_item'	=>$post['price'], // harga di hpp
		);
		$this->db->update('gudang_persediaan_item',$ug,array('id_persediaan'=>$id));
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'masterdata/persediaanalat');
	}

	public function hapus($id){
		$this->db->update('product',array('hapus'=>1),array('product_id'=>$id));
		$this->db->update('gudang_persediaan_item',array('hapus'=>1),array('id_persediaan'=>$id));

		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'masterdata/persediaan');
	}

	public function Productsave(){
		$data=$this->input->post();
		//pre($data);
		$ip=array(
			'nama'=>$data['nama'],
			'warna_item'=>$data['warna_item'],
			'ukuran_item'=>$data['ukuran_item'],
			'satuan_ukuran_item'=>$data['satuan_ukuran_item'],
			'satuan'=>$data['satuan'],
			'quantity'=>0,
			'price'=>0,
			'hapus'=>0,
			'date_added'=>date('Y-m-d H:i:s'),
			'user_added'=>callSessUser('nama_user'),
			'jenis'=>$data['jenis'],
			'kategori'=>$data['kategori'],
			'minstok'=>$data['minstok'],
			'resiko'=>$data['resiko'],
			'supplier'=>$data['supplier'],
			'status' => $data['status'],
		);
		$this->db->insert('product',$ip);
		$id=$this->db->insert_id();
		$this->db->query("UPDATE product set kodebarang='ITM-0".$id."' WHERE product_id='$id' ");
		$gip=array(
			'id_persediaan'=>$id,
			'nama_item'=>$data['nama'],
			'warna_item'=>$data['warna_item'],
			'ukuran_item'=>$data['ukuran_item'],
			'satuan_ukuran_item'=>$data['satuan_ukuran_item'],
			'satuan_jumlah_item'=>$data['satuan'],
			'jumlah_item'=>0,			
			'created_date'=>date('Y-m-d'),
			'nama_supplier'=>'-',
			'kode_transfer'=>0,
			'contact_supplier'=>0,
			'harga_item'=>0,
			'resiko_item'=>0,
			'supplier'=>$data['supplier'],
		);

		$this->db->insert('gudang_persediaan_item',$gip);

		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'masterdata/persediaan');
	}

	public function supplier()

	{
		$data=array();
		$resutls=array();
		$data['title']='Master Supplier';
		$data['hasil']=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'Masterdata/supplieradd';
		$resutls = $this->GlobalModel->queryManual('SELECT * FROM master_supplier WHERE hapus=0  ORDER BY nama ASC');
		foreach($resutls as $s){
			$data['hasil'][]=array(
				'id'=>$s['id'],
				'kategori' => $s['category'],
				'nama'=>$s['nama'],
				'telephone'=>$s['telephone'],
				'alamat'=>$s['alamat'],
				'pic'=>$s['pic'],
				'edit'=>BASEURL.'Masterdata/supplieredit/'.$s['id'],
				'hapus'=>BASEURL.'Masterdata/supplierhapus/'.$s['id'],
			);
		}

		$data['page']='master/supplier/list';

		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');

	}

	public function supplieradd()

	{
		$data=array();
		$data['title']='Tambah Master Supplier';
		$data['action']=BASEURL.'Masterdata/suppliersave';
		$data['batal']=BASEURL.'Masterdata/supplier';
		$data['page']='master/supplier/form';
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');

	}


	public function suppliersave(){
		$data=$this->input->post();
		if(isset($data['data']) && !empty($data['data'])){
			foreach($data['data'] as $sup){
				if(!empty($sup['nama'])){
					$insert=array(
						'nama'=>$sup['nama'],
						'pic'=>$sup['pic'],
						'telephone'=>$sup['telephone'],
						'alamat'=>$sup['alamat'],
						'hapus'=>0,
					);
					$this->db->insert('master_supplier',$insert);
				}
			}
			$this->session->set_flashdata('msg','Data berhasil ditambah');
			redirect(BASEURL.'masterdata/supplier');
		}else{
			$this->session->set_flashdata('msg','Data Gagal ditambah');
			redirect(BASEURL.'masterdata/supplieradd');
		}
		
	}

	public function supplieredit($id){
		$data=array();
		$data['title']='Edit Supplier';
		$data['action']=BASEURL.'Masterdata/suppliereditsave';
		$data['products']=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$id));
		$data['page']='master/supplier/edit';
		$this->load->view($this->page.'main',$data);
	}

	public function suppliereditsave(){
		$sup=$this->input->post();
		$update=array(
			'nama'=>$sup['nama'],
			'pic'=>$sup['pic'],
			'telephone'=>$sup['telephone'],
			'alamat'=>$sup['alamat'],
			'category'=>$sup['category'],
		);
		$this->db->update('master_supplier',$update,array('id'=>$sup['id']));
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'masterdata/supplier');
	}


	public function user()
	{
		$users=array();
		$users = $this->GlobalModel->queryManual("SELECT * FROM user WHERE id_user<>11");
		foreach($users as $u){
			$action=array();
			$action[] = array(
				'class'=>'warning',
				'text' => 'Edit Detail',
				'href' => BASEURL.'Masterdata/useredit/'.$u['id_user'],
			);
			$action[] = array(
				'class'=>'primary',
				'text' => 'Akses CMT',
				'href' => BASEURL.'Masterdata/akses_cmt/'.$u['id_user'],
			);
			$action[] = array(
				'class'=>'success',
				'text' => 'Akses Data',
				'href' => BASEURL.'Masterdata/userakses/'.$u['id_user'],
			);
			$action[] = array(
				'class'=>'info',
				'text' => 'Akses Menu',
				'href' => BASEURL.'user/menu/'.$u['id_user'],
			);
			$action[] = array(
				'class'=>'danger',
				'text' => 'Hapus',
				'href' => BASEURL.'Masterdata/userhapus/'.$u['id_user'],
			);
			$viewData['user'][]=array(
				'id_user'=>$u['id_user'],
				'nama_user'=>$u['nama_user'],
				'jabatan_user'=>$u['jabatan_user'],
				'status_user'=>$u['status_user'],
				'created_date'=>$u['created_date'],
				'jabatan_user'=>null,
				'action'=>$action,
			);
		}
		//$viewData['jabatan']=flagJabatan();
		$viewData['jabatan']=array();
		$viewData['title']='List user';
		$viewData['page']='newtheme/page/masterdata/userlist';
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$viewData);
		$this->load->view('newtheme/layout/footer');
	}

	public function useredit($id){
		$data=[];
		$data['users']=$this->GlobalModel->getDataRow('user',array('id_user'=>$id,));
		$data['title']='Detail User';
		$data['kembali']=BASEURL.'masterdata/user';
		$data['action']=BASEURL.'masterdata/useredit_save';
		$data['page']=$this->page.'masterdata/userdetail';
		$this->load->view($this->page.'main',$data);
	}

	public function akses_cmt($id){
		$data=[];
		$data['users']=$this->GlobalModel->getDataRow('user',array('id_user'=>$id,));
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0));
		$data['title']='Detail User';
		$data['kembali']=BASEURL.'masterdata/user';
		$data['action']=BASEURL.'masterdata/useredit_save';
		$data['page']=$this->page.'masterdata/user_cmt';
		$this->load->view($this->page.'main',$data);
	}

	public function useredit_save(){
		$post = $this->input->post();
		$menuEx='5,44,45,10,11,12,13,14,15,33,43,22,23,24,25,26,43';
		$dataInserted = array(
			'nama_user'		=>	$post['nama_user'], 
			'email_user'	=>	$post['email_user'], 
			'password_user'	=>	password_hash($post['password_user'], PASSWORD_DEFAULT),	
			'status_user'	=> $post['status'],		
		);
		$where=array(
			'id_user'	=>$post['id_user'],
		);
		$this->db->update('user',$dataInserted,$where);
		$this->session->set_flashdata('msg','User berhasil diedit');
		redirect(BASEURL.'masterdata/user');
	}

	public function userakses($id=null)
	{
		$viewData['id']=$id;
		$viewData['aksesedit'] = $this->GlobalModel->getDataRow('aksesdata',array('user_id'=>$id,'akses'=>1));
		$viewData['akseshapus'] = $this->GlobalModel->getDataRow('aksesdata',array('user_id'=>$id,'akses'=>2));
		$viewData['setujui'] = $this->GlobalModel->getDataRow('aksesdata',array('user_id'=>$id,'akses'=>3));
		//pre($viewData['akseshapus']);
		$user=$this->GlobalModel->getDataRow('user',array('id_user'=>$id));
		$viewData['user']=$user['nama_user'];
		$viewData['action']=BASEURL.'Masterdata/useraksessimpan';
		$viewData['jabatan']=flagJabatan();
		$viewData['page']='master/user/aksesdata';
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$viewData);
		$this->load->view('newtheme/layout/footer');

	}

	public function useraksessimpan(){
		date_default_timezone_set("Asia/Jakarta");
		$data = $this->input->post();
		if(!empty($data['waktu'])){
			$date=date_create();
			date_add($date,date_interval_create_from_date_string($data['waktu']."minutes"));
			$batas = date_format($date,"Y-m-d H:i:s");
		}else{
			$this->session->set_flashdata('msgt','Waktu aktif belum disisi');
			redirect(BASEURL.'Masterdata/userakses/'.$data['user_id']);
		}
		//pre($batas);
		
		if(isset($data['user_id'])){
			$this->GlobalModel->deleteData('aksesdata',array('user_id'=>$data['user_id']));
			foreach($data['user_menu'] as $um){
				$insert=array(
					'user_id'=>$data['user_id'],
					'akses'=>$um['akses'],
					'nilai'=>$um['nilai'],
					'waktu'=>$data['waktu'],
					'batas'=>$batas,
					'hapus'=>0,
				);
				$this->db->insert('aksesdata',$insert);
			}

			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
			redirect(BASEURL.'Masterdata/user');
		}
		
	}

	public function userhapus($id='')
	{
		$this->GlobalModel->deleteData('user',array('id_user'=>$id));
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect(BASEURL.'masterdata/user');
		
	}

	public function karyawanbordiredit($id)
	{
		$data 	=array();
		$data['n']=1;
		$data['title']="Master operator bordir";
		$data['k']=$this->GlobalModel->queryManualRow('SELECT * FROM master_karyawan_bordir WHERE hapus=0 AND id_master_karyawan_bordir='.$id.' ');
		$data['update']=BASEURL.'masterdata/karyawanbordirupdate';
		$data['cancel']=BASEURL.'masterdata/karyawanbordir';
		$data['page']='master/karyawanbordir/detail';
		$this->load->view($this->page.'main',$data);

	}

	public function karyawanbordirupdate(){
		$post=$this->input->post();
		$insert=array(
			'nama_karyawan_bordir'=>$post['nama'],
			'no_telp'=>$post['no_telp'],
			'tgl_masuk'=>$post['tgl_masuk'],
			'karyawan_gaji_weekday'=>$post['karyawan_gaji_weekday'],
			'karyawan_gaji_weekend'=>$post['karyawan_gaji_weekend'],
		);
		$this->db->update('master_karyawan_bordir',$insert,array('id_master_karyawan_bordir'=>$post['id']));
		$this->session->set_flashdata('msg','Data berhasil diupdate');
		redirect(BASEURL.'masterdata/karyawanbordir');
	}

	public function karyawanbordir()
	{
		$data 	=array();
		$data['n']=1;
		$data['title']="Master operator bordir";
		$data['karyawan']=$this->GlobalModel->queryManual('SELECT * FROM master_karyawan_bordir WHERE hapus=0 ORDER BY nama_karyawan_bordir ASC');
		$data['tambah']=BASEURL.'masterdata/karyawanbordiradd';
		$data['page']='master/karyawanbordir/list';
		$this->load->view($this->page.'main',$data);

	}

	public function karyawanbordiradd(){
		$data=array();
		$data['title']='Tambah baru operator bordir';
		$data['insert']=BASEURL.'masterdata/karyawanbordirsave';
		$data['batal']=BASEURL.'masterdata/karyawanbordir';
		$data['page']='master/karyawanbordir/form';
		$this->load->view($this->page.'main',$data);
	}

	public function karyawanbordirsave(){
		$post=$this->input->post();
		$insert=array(
			'nama_karyawan_bordir'=>$post['nama'],
			'no_telp'=>$post['no_telp'],
			'tgl_masuk'=>$post['tgl_masuk'],
			'karyawan_gaji_weekday'=>$post['karyawan_gaji_weekday'],
			'karyawan_gaji_weekend'=>$post['karyawan_gaji_weekend'],
		);
		$this->db->insert('master_karyawan_bordir',$insert);
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'masterdata/karyawanbordir');
	}

	public function karyawanbordirhapus($id){
		$this->db->update('master_karyawan_bordir',array('hapus'=>1),array('id_master_karyawan_bordir'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'masterdata/karyawanbordir');
	}

	public function jenispo()

	{
		$data['title']='Master jenis po';
		$data['jenis']	= $this->GlobalModel->getData('master_jenis_kaos',null);
		$data['page']='master/jenispo/jenis-po';
		$data['tambah']=BASEURL.'Masterdata/jenispoTambah';
		$this->load->view($this->page.'main',$data);
	}



	public function jenispoTambah()

	{

		$data['title']='Tambah Jenis PO';
		$data['page']='master/jenispo/jenis-po-tambah';
		$this->load->view($this->page.'main',$data);

	}



	public function jenispoOnCreate()

	{

		$post = $this->input->post();
		$dataInserted = array(
			'nama_jenis_kaos'		=>	$post['namajenis'],
		);

		$this->GlobalModel->insertData('master_jenis_kaos',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'Masterdata/jenispo');

	}



	public function jenispoEdit($id)

	{

		$viewData['jenis']	= $this->GlobalModel->getDataRow('jenis_po',array('id_jenis_po'=>$id));



		$this->load->view('global/header');

		$this->load->view('master/jenispo/jenis-po-edit',$viewData);

		$this->load->view('global/footer');

	}



	public function jenispoOnChange($id)

	{

		$post = $this->input->post();

		$dataInserted = array(

			'kode_jenis_po'		=>	$post['kode'],

			'nama_jenis_po'		=>	$post['namajenis'],

			'dimodifikasi'		=>	date('Y-m-d'),

			'status'			=>	$post['status']

		);



		$this->GlobalModel->updateData('jenis_po',array('id_jenis_po'=>$id),$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil diupdate');

		redirect(BASEURL.'master/jenispo');

	}



	public function jenispoDelete($id)

	{

		$this->GlobalModel->deleteData('jenis_po',array('id_jenis_po'=>$id));

		$this->session->set_flashdata('msg','Data berhasil didelete');

		redirect(BASEURL.'master/jenispo');

	}



	public function satuanbarang()

	{

		$viewData['satuan']	= $this->GlobalModel->getData('master_satuan_barang',null);
		$viewData['page']='master/satuanbarang/satuan-view';
		$this->load->view('newtheme/page/main',$viewData);

	}



	public function satuanbarangTambah()

	{

		//$this->load->view('global/header');
		$data['page']='master/satuanbarang/satuan-tambah';
		$this->load->view('newtheme/page/main',$data);
		//$this->load->view('global/footer');

	}



	public function satuanbarangOnCreate()

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama_satuan_barang'	=> 	$post['nama'],

			'created_date'			=> 	date('Y-m-d'),

			'kode_satuan_barang'	=>	$post['kodeSatuan']

		);

		$this->GlobalModel->insertData('master_satuan_barang',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'Masterdata/satuanbarang');

	}



	public function satuanbarangEdit($id)

	{

		$viewData['satuan']	= $this->GlobalModel->getDataRow('master_satuan_barang',array('id_satuan_barang'=>$id));



		$this->load->view('global/header');

		$this->load->view('master/satuanbarang/satuan-edit',$viewData);

		$this->load->view('global/footer');

	}



	public function satuanbarangOnChange($id)

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama_satuan_barang'	=> 	$post['nama'],

			'created_date'			=> 	date('Y-m-d'),

			'kode_satuan_barang'	=>	$post['kodeSatuan']

		);



		$this->GlobalModel->updateData('master_satuan_barang',array('id_satuan_barang'=>$id),$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil diupdate');

		redirect(BASEURL.'masterdata/satuanbarang');

	}



	public function satuanDelete($id)

	{

		$this->GlobalModel->deleteData('master_satuan_barang',array('id_satuan_barang'=>$id));

		$this->session->set_flashdata('msg','Data berhasil didelete');

		redirect(BASEURL.'masterdata/satuanbarang');

	}



	public function namapo()

	{
		$data=[];
		$data['title']='Master Nama PO';
		$data['satuan']	= $this->GlobalModel->getData('master_jenis_po',array());
		$data['page']='master/po/po-view';
		$this->load->view($this->page.'main',$data);


	}

	public function editnamapo($id)

	{
		$data=[];
		$data['title']='Master Nama PO';
		$data['p']	= $this->GlobalModel->getDataRow('master_jenis_po',array('id_jenis_po'=>$id));
		$data['page']='master/po/namapo-edit';
		$this->load->view($this->page.'main',$data);
		

	}

	public function simpaneditnama(){
		$post=$this->input->post();
		$update=array(
			'nama_jenis_po'			=> 	$post['nama_jenis_po'],
			'idjenis'=>$post['idjenis'],
			'tampil'=>$post['tampil'],
			'online'=>$post['online'],
		);
		$where=array(
			'id_jenis_po'=>$post['id_jenis_po'],
		);
		$this->db->update('master_jenis_po',$update,$where);
		$this->session->set_flashdata('msg','Data berhasil didelete');
		redirect(BASEURL.'Masterdata/namapo');
	}



	public function namapoTambah()

	{

		$data=[];
		$data['title']='Tambah Nama PO Baru';
		$data['page']='master/po/po-tambah';
		$this->load->view($this->page.'main',$data);

	}



	public function namapoTambahOnCreate()

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama_jenis_po'			=> 	$post['nama_jenis_po'],

			'idjenis'	=> 	$post['idjenis'],

			'artikel_jenis_po'		=>	$post['artikel_jenis_po'],
			
			'perkalian'	=> 1,

			'tampil'  => 1,

			'status'=>1,

		);

		$this->GlobalModel->insertData('master_jenis_po',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'masterdata/namapo');

	}



	public function namapoEdit($id='')

	{

		$viewData['po']	= $this->GlobalModel->getDataRow('master_nama_po',array('id_nama_po'=>$id));

		$this->load->view('global/header');

		$this->load->view('master/po/po-edit',$viewData);

		$this->load->view('global/footer');

	}



	public function namapoEditOnCreate($id="")

	{

		$post = $this->input->post();

		$dataInserted = array(

			'kode_po'			=> 	$post['kodePO'],

			'nama_lengkap_po'	=> 	$post['namaLengkapPO'],

			'kode_artikel'		=>	$post['kodeArtikel'],

			'created_date'		=> 	date('Y-m-d')

		);



		$this->GlobalModel->updateData('master_nama_po',array('id_nama_po'=>$id),$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil diupdate');

		redirect(BASEURL.'master/namapo');

	}



	public function deletePoKode($id='')

	{

		$this->GlobalModel->deleteData('master_nama_po',array('id_nama_po'=>$id));

		$this->session->set_flashdata('msg','Data berhasil didelete');

		redirect(BASEURL.'master/namapo');

	}


	public function persediaanalat(){
		$data=array();
		$data['title']='Master Persediaan Alat-alat';
		$data['products']=array();
		$data['action']=BASEURL.'Masterdata/Productsave';
		$data['url']=BASEURL.'Masterdata/Persediaan';
		$data['kat']=$this->GlobalModel->getData('kategori_barang',array());
		$get=$this->input->get();
		if(isset($get['product_id'])){
			$product_id=$get['product_id'];
		}else{
			$product_id=null;
		}
		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=null;
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
		}else{
			$kategori=null;
		}

		$data['kate']	= $kategori;

		$data['i']=1;
			$filter=array(
				'hapus'=>0,
				'product_id'=>$product_id,
				'jenis'=>$jenis,
			);
		$results=array();
		$sql="SELECT * FROM product WHERE hapus=0 ";
		$url='';
		if(!empty($product_id)){
			$sql.=" AND product_id='".$product_id."' ";
			$url.="&product_id=".$product_id;
		}
		if(!empty($jenis)){
			$sql.=" AND jenis='".$jenis."' ";
			$url.="&jenis=".$jenis;
		}
		if(!empty($kategori)){
			$sql.=" AND kategori='".$kategori."' ";
			$url.="&kategori=".$kategori;
		}else{
			$sql.=" AND kategori NOT IN(12) ";
		}
		$results = $this->GlobalModel->QueryManual($sql);
		$satuan=0;
		$supplier=null;
		$color='white';
		$jenis=null;
		foreach($results as $result){
			$action=array();
			
			$action[] = array(
				'text' => 'Edit',
				'href' => BASEURL.'Masterdata/Edit/'.$result['product_id'],
			);

			if(akseshapus()==1){
				$action[] = array(
					'text' => 'Hapus',
					'href' => BASEURL.'Masterdata/hapus/'.$result['product_id'],
				);
			}
			$satuan = $this->GlobalModel->getDataRow('master_satuan_barang',array('id_satuan_barang'=>$result['satuan']));
			
			$supplier=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$result['supplier']));


			$data['products'][]=array(
				'supplier'=>!empty($supplier)?$supplier['nama']:'-',
				'foto'=>$result['foto'],
				'jenis'=>$result['jenis']==4?'Bahan':'',
				'product_id'=>$result['product_id'],
				'kodebarang'=>$result['kodebarang'],
				'nama'=>strtoupper($result['nama']),
				//'satuan'=>$satuan['kode_satuan_barang'],
				'ukuran_item'=>is_numeric($result['ukuran_item'])?number_format($result['ukuran_item'],2):$result['ukuran_item'],
				'satuan_ukuran_item'=>$result['satuan_ukuran_item'],
				'quantity'=>$result['quantity'],
				'minstok'=>$result['minstok'],
				'satuanqty'=>$result['satuan'],
				'color'=>$result['jenis']==4?'#ed8664':'',
				'price'=>number_format($result['price'],2),
				'harga_beli'=>$result['harga_beli'],
				'harga_skb'=>$result['harga_skb'],
				'action'=>$action,
			);
		}
		//pre($results);
		$data['satuan']=$this->GlobalModel->getData('master_satuan_barang',array());
		$data['prods']=$this->GlobalModel->getData('product',array('hapus'=>0));
		$data['pdf']=BASEURL.'Masterdata/persediaan?&pdf=true'.$url;
		$data['supplier'] = $this->GlobalModel->queryManual('SELECT * FROM master_supplier WHERE hapus=0  ORDER BY nama ASC');
		if(isset($get['pdf'])){
			$html =  $this->load->view('newtheme/page/masterdata/persediaan_pdf',$data,true);
			$this->load->library('pdfgenerator');	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Laporan Persediaan';
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Laporan_Persediaan';
	        // setting paper
	        $paper = 'A4';
	        //orientasi paper potrait / landscape
	        $orientation = "potrait";
			$this->load->view('laporan_pdf',$this->data, true);	    
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			$data['page']='newtheme/page/masterdata/persediaan';
			$this->load->view('newtheme/page/main',$data);
		}
		
	}

	public function kategoribarang()

	{
		$viewData['title']	= 'Kategori Barang';
		$viewData['satuan']	= $this->GlobalModel->getData('kategori_barang',null);
		$viewData['page']='master/satuanbarang/kategori-view';
		$this->load->view('newtheme/page/main',$viewData);

	}

	function kategoribarangEdit($id)

	{
		$viewData['title']	= 'Kategori Barang';
		$viewData['prods']	= $this->GlobalModel->getDataRow('kategori_barang',array('id'=>$id));
		$viewData['page']='master/satuanbarang/kategori-edit';
		$this->load->view('newtheme/page/main',$viewData);

	}

	function editkategori($id,$jenis){
		$this->db->update('kategori_barang',array('in_warning'=>$jenis),array('id'=>$id));
		redirect(BASEURL.'/Masterdata/kategoribarang');
	}

	function tampildicrosscek($id,$jenis){
		$this->db->update('kategori_barang',array('tampildicrosscek'=>$jenis),array('id'=>$id));
		redirect(BASEURL.'/Masterdata/kategoribarang');
	}



	public function kategoribarangAdd()

	{
		$data['title']	= 'Form Kategori Barang';
		//$this->load->view('global/header');
		$data['page']='master/satuanbarang/kategori-tambah';
		$this->load->view('newtheme/page/main',$data);
		//$this->load->view('global/footer');

	}



	public function kategoribarangOnCreate()

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama'	=> 	$post['nama'],

		);

		$this->GlobalModel->insertData('kategori_barang',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'Masterdata/kategoribarang');

	}


	public function kategoribarangOnCreateEdit()

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama'	=> 	$post['nama'],
			'variabel_pengirimanpo'	=> 	$post['variabel_pengirimanpo'],
			'rata_rata_dz'	=> 	$post['rata_rata_dz'],
			'spesial_warning'	=> 	$post['spesial_warning'],
			'in_warning'	=> 	$post['in_warning'],

		);
		$where = array(
			'id'	=> $post['id'],
		);
		$this->db->update('kategori_barang',$dataInserted,$where);

		$this->session->set_flashdata('msg','Data berhasil diubah');

		redirect(BASEURL.'Masterdata/kategoribarang');

	}


	public function size()

	{
		$viewData['title']	= 'Master Size';
		$viewData['satuan']	= $this->GlobalModel->getData('master_size',null);
		$viewData['page']='master/size/list';
		$this->load->view('newtheme/page/main',$viewData);

	}

	public function sizeAdd()

	{
		$data['title']	= 'Form Master Size';
		$data['page']='master/size/form';
		$data['cancel']=BASEURL.'Masterdata/size';
		$data['action']=BASEURL.'Masterdata/sizeOnCreate';
		$this->load->view('newtheme/page/main',$data);

	}



	public function sizeOnCreate()

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama_size'	=> 	$post['nama_size'],

		);

		$this->GlobalModel->insertData('master_size',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'Masterdata/size');

	}


	public function sizeOnDelete($id)

	{

		$this->db->delete('master_size',array('id_master_size'=>$id));

		$this->session->set_flashdata('msg','Data berhasil dihapus');

		redirect(BASEURL.'Masterdata/size');

	}

	public function modelpo()

	{
		$viewData['title']	= 'Model PO';
		$viewData['satuan']	= $this->GlobalModel->getData('model_po',null);
		$viewData['page']='master/modelpo/list';
		$this->load->view('newtheme/page/main',$viewData);

	}


	public function modelpoAdd(){
		$data['title']	= 'Form Model PO ';
		$data['page']='master/modelpo/form';
		$data['cancel']=BASEURL.'Masterdata/modelpo';
		$data['action']=BASEURL.'Masterdata/modelpo_save';
		$this->load->view('newtheme/page/main',$data);
	}


	public function modelpo_save()

	{
		$post = $this->input->post();
		$nama_model = strtolower($post['nama_model']);
		$insert = array(
			'nama_model' => ucwords($nama_model),
			'hapus'	     => 0,
		);
		$this->db->insert('model_po',$insert);

		$this->session->set_flashdata('msg','Data berhasil disimpan');

		redirect(BASEURL.'Masterdata/modelpo');

	}


}

