<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->url=BASEURL.'User/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function myprofile(){
		$data=[];
		$data['pic']=1;
		$data['title']='Pengaturan Profil Saya';
		$data['page']=$this->page.'user/myprofile';
		$data['save']=$this->url.'update_myprofile';
		$data['save_password']=$this->url.'save_password';
		$data['p']=$this->GlobalModel->getDataRow('user',array('id_user'=>callSessUser('id_user')));
		$data['activity']=[];
		$data['activity']=activity();
		$this->load->view($this->page.'main',$data);
	}

	public function update_myprofile(){
		$config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $post = $this->input->post();
        $this->load->library('upload', $config);
        $this->upload->do_upload('foto');
        $fileName = 'uploads/'.$this->upload->data('file_name');
        $this->db->update('user',array('foto'=>$fileName),array('id_user'=>$post['id_user']));
        $this->session->set_flashdata('msg','Data Berhasil Di Simpan');
        redirect($this->url.'myprofile');
	}

	public function save_password(){
		$post = $this->input->post();

		// Ambil nilai saat ini dari database
		$this->db->select('ubah_password');
		$this->db->from('user');
		$this->db->where('id_user', $post['id_user']);
		$query = $this->db->get();
		$current_value = $query->row()->ubah_password;

		// Tambahkan 1 ke nilai saat ini
		$new_value = $current_value + 1;


		$update = array(
			'ubah_password' => $new_value,
			'ubah_at'		=> date('Y-m-d H:i:s'),
			'password_user'	=>	password_hash($post['password'], PASSWORD_DEFAULT), 
		);
        $this->db->update('user',$update,array('id_user'=>$post['id_user']));
		user_activity(callSessUser('id_user'),1,' mengubah password menjadi '.$post['password']);
        $this->session->set_flashdata('msg','Data Berhasil Di Simpan');
        redirect($this->url.'myprofile');
	}

	public function request(){
		$data=[];
		$data['title']='Data request otorisasi dan menu user';
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$no=1;
		$data['products']=[];
		$sql="SELECT * FROM user_request WHERE hapus=0 ";
		$sql.=" AND userid='".callSessUser('id_user')."' ";
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->queryManual($sql);
		foreach($results as $r){
			if(callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){
				$link=BASEURL.'User/accreq/'.$r['aksestable'].'/'.$r['userid'].'/'.$r['id'];
			}else{
				$link=BASEURL.'dash';
			}
			$data['products'][]=array(
				'n'=>$no++,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'nama'=>strtolower($r['nama']),
				'keterangan'=>strtolower($r['keterangan']),
				'setujui'=>$link,
				'stat'=>$r['status'],
				'status'=>$r['status']==1?'sudah diproses':'belum diproses',
			);
		}
		$data['action']=BASEURL.'User/requestsave';
		$data['page']=$this->page.'user/request';
		$this->load->view($this->page.'main',$data);
	}

	public function requestsave(){
		$data=$this->input->post();
		$cek=$this->GlobalModel->getData('user_request',array('userid'=>$data['userid'],'tanggal'=>date('Y-m-d')));
		//pre(count($cek));
		if(!empty($cek)){
			if(count($cek)==3){
				$this->session->set_flashdata('gagal','Data Gagal Di Simpan. Request sehari sudah mencapai batas maksimal yaitu 3.');
				redirect(BASEURL.'User/request');
			}else{
				$insert=array(
					'userid'=>$data['userid'],
					'nama'=>$data['nama'],
					'tanggal'=>date('Y-m-d'),
					'keterangan'=>$data['keterangan'],
					'aksestable'=>$data['aksestable'],
					'hapus'=>0,
				);
				$this->db->insert('user_request',$insert);
				kirim_email('muhammad.pawit93@gmail.com',$data['nama'].' meminta request otorisasi '.$data['keterangan'].' ');
				$this->session->set_flashdata('msg','Data Berhasil Di Simpan.');
				redirect(BASEURL.'User/request');
			}
		}else{
			$insert=array(
					'userid'=>$data['userid'],
					'nama'=>$data['nama'],
					'tanggal'=>date('Y-m-d'),
					'keterangan'=>$data['keterangan'],
					'aksestable'=>$data['aksestable'],
					'hapus'=>0,
				);
				$this->db->insert('user_request',$insert);
				kirim_email('muhammad.pawit93@gmail.com',$data['nama'].' meminta request otorisasi '.$data['keterangan'].' ');
				$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
				redirect(BASEURL.'User/request');
		}
		
	}

	public function accreq($menu,$menu2,$menu3,$id){
		$url=BASEURL.$menu.'/'.$menu2.'/'.$menu3;
		$this->db->query("UPDATE user_request SET status=1 WHERE id='$id' ");
		//echo $id;
		redirect($url);
	}

	public function menu($userid){
		$data=[];
		$users=$this->GlobalModel->getDataRow('user',array('id_user'=>$userid));
		$data['title']='Akses Menu '.$users['nama_user'];
		$data['userid']=$userid;
		$usermenu=[];
		$usermenu=$this->GlobalModel->getData('usermenu',array('userid'=>$userid));
		$idmenu=[];
		foreach($usermenu as $um){
			$idmenu[]=$um['menuid'];
		}
		if(empty($idmenu)){
			$data['inmenu']=array(1,2);
		}else{
			$data['inmenu']=$idmenu;
		}
		//pre($data['inmenu']);
		$data['page']=$this->page.'user/menu';
		$data['menus']=$this->GlobalModel->getData('menu',array('hapus'=>0));
		$data['action']=BASEURL.'User/usermenusave';
		$data['batal']=BASEURL.'masterdata/user';
		$this->load->view($this->page.'main',$data);
	}

	public function usermenusave(){
		$data=$this->input->post();
		//pre($data);
		$this->db->query("DELETE FROM usermenu WHERE userid='".$data['userid']."' AND menuid NOT IN(1,2,113) ");
		foreach($data['user_menu'] as $u=>$val){
			$insert=array(
				'userid'=>$data['userid'],
				'menuid'=>$val,
			);
			$this->db->insert('usermenu',$insert);
		}
		$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		redirect(BASEURL.'masterdata/user');
	}


	public function index()
	{
		$users=array();
		$users = $this->GlobalModel->queryManual("SELECT * FROM user WHERE id_user<>11");
		foreach($users as $u){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL.'user/edit/'.$u['id_user'],
			);
			$action[] = array(
				'text' => 'Hapus',
				'href' => BASEURL.'user/hapus/'.$u['id_user'],
			);
			$action[] = array(
				'text' => 'Akses Data',
				'href' => BASEURL.'user/akses/'.$u['id_user'],
			);
			$viewData['user'][]=array(
				'id_user'=>$u['id_user'],
				'nama_user'=>$u['nama_user'],
				'jabatan_user'=>$u['jabatan_user'],
				'status_user'=>$u['status_user'],
				'created_date'=>$u['created_date'],
				'action'=>$action,
			);
		}
		$viewData['jabatan']=flagJabatan();
		$this->load->view('global/header');
		$this->load->view('master/user/view',$viewData);
		$this->load->view('global/footer');
	}

	public function tambah()
	{
		$data=array();
		$data['title']='Tambah User';
		$data['jabatan']= $this->GlobalModel->getData('jabatan',array('hapus'=>0));
		$data['menu'] = $this->GlobalModel->getData('master_menu',null);
		//$this->load->view('global/header');
		//$this->load->view('master/user/tambah',$viewData);
		//$this->load->view('global/footer');
		$data['page']='master/user/tambah';
		$this->load->view('newtheme/page/main',$data);
	}

	public function akses($id=null)
	{
		$viewData['id']=$id;
		$viewData['aksesedit'] = $this->GlobalModel->getDataRow('aksesdata',array('user_id'=>$id,'akses'=>1));
		$viewData['akseshapus'] = $this->GlobalModel->getDataRow('aksesdata',array('user_id'=>$id,'akses'=>2));
		//pre($viewData['akseshapus']);
		$user=$this->GlobalModel->getDataRow('user',array('id_user'=>$id));
		$viewData['user']=$user['nama_user'];
		$viewData['action']=BASEURL.'user/aksessimpan';
		$this->load->view('global/header');
		$this->load->view('master/user/aksesdata',$viewData);
		$this->load->view('global/footer');

	}

	public function aksessimpan(){
		$data = $this->input->post();
		
		if(isset($data['user_id'])){
			$this->GlobalModel->deleteData('aksesdata',array('user_id'=>$data['user_id']));
			foreach($data['user_menu'] as $um){
				$insert=array(
					'user_id'=>$data['user_id'],
					'akses'=>$um['akses'],
					'nilai'=>$um['nilai'],
					'hapus'=>0,
				);
				$this->db->insert('aksesdata',$insert);
			}

			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
			redirect(BASEURL.'masterdata/user');
		}
		
	}

	public function tambahAct()
	{
		$post = $this->input->post();

		//$menuEx = implode(',',$post['menu_flag']);
		$menuEx='5,44,45,10,11,12,13,14,15,33,43,22,23,24,25,26,43';
		$dataInserted = array(
			'nama_user'		=>	$post['nama_user'], 
			'jabatan_user'	=>	$post['jabatan_user'], 
			'email_user'	=>	$post['email_user'], 
			'password_user'	=>	password_hash($post['password_user'], PASSWORD_DEFAULT), 
			'status_user'	=>	$post['status_user'], 
			'created_date'	=> 	date('Y-m-d'),
			'menu_flag'		=> 	$menuEx
		);

		$this->GlobalModel->insertData('user',$dataInserted);
		redirect(BASEURL.'masterdata/user');
	}

	public function edit($id='')
	{
		$viewData['user'] = $this->GlobalModel->getDataRow('user',array('id_user'=>$id));
		$viewData['menu'] = $this->GlobalModel->getData('master_menu',null);
		$this->load->view('global/header');
		$this->load->view('master/user/edit',$viewData);
		$this->load->view('global/footer');
	}

	public function editAct($id='')
	{
		$post = $this->input->post();
		// pre(password_hash($post['password_user'], PASSWORD_DEFAULT));
		$menuEx = implode(',',$post['menu_flag']);

		if (empty($post['password_user'])) {
			$dataInserted = array(
				'nama_user'		=>	$post['nama_user'], 
				'jabatan_user'	=>	$post['jabatan_user'], 
				'email_user'	=>	$post['email_user'], 
				'status_user'	=>	$post['status_user'], 
				'created_date'	=> 	date('Y-m-d'),
				'menu_flag'		=> 	$menuEx
			);
		} else {
			$dataInserted = array(
				'nama_user'		=>	$post['nama_user'], 
				'jabatan_user'	=>	$post['jabatan_user'], 
				'email_user'	=>	$post['email_user'], 
				'password_user'	=>	password_hash($post['password_user'], PASSWORD_DEFAULT), 
				'status_user'	=>	$post['status_user'], 
				'created_date'	=> 	date('Y-m-d'),
				'menu_flag'		=> 	$menuEx
			);
		}
		

		$this->GlobalModel->updateData('user',array('id_user' => $id),$dataInserted);
		redirect(BASEURL.'user');
	}

	public function editUserSetting()
	{
		$viewData['user'] = $this->GlobalModel->getDataRow('user',array('email_user'=>callSessUser('email_user')));

		$this->load->view('global/header');
		$this->load->view('master/user/setting',$viewData);
		$this->load->view('global/footer');
	}

	public function settingAct()
	{
		$post = $this->input->post();

		$datUser = $this->GlobalModel->getDataRow('user',array('id_user'=>$post['idUser']));
		// pre($post);
		if (!empty($post['passwordLama'])) {
			if (password_verify($post['passwordLama'], $dataUser['password_user'])) {
				$dataArray = array(
					'nama_user'	=>	$post['nama_user'],
					'email_user'	=>	$post['email_user'],
					'password_user'	=>	password_hash($post['passwordNew'], PASSWORD_DEFAULT)
				);

				$this->GlobalModel->updateData('user',array('id_user'=>$post['idUser']),$dataArray);

				$this->session->set_flashdata('msg','User Berhasil Di Ubah');
				redirect(BASEURL.'user/editUserSetting');
			} else {
				$this->session->set_flashdata('msg','User Gagal Di UBah Password lama anda tidak sesuai');
				redirect(BASEURL.'user/editUserSetting');
			}
		} else {
			$dataArray = array(
				'nama_user'	=>	$post['nama_user'],
				'email_user'	=>	$post['email_user'],
				'password_user'	=>	password_hash($post['passwordNew'], PASSWORD_DEFAULT)
			);
			$this->GlobalModel->updateData('user',array('id_user'=>$post['idUser']),$dataArray);
			$this->session->set_flashdata('msg','User Berhasil Di Ubah');
			redirect(BASEURL.'user/editUserSetting');

		}

	}

	public function hapus($id='')
	{
		if (callSessUser('jabatan_user') == 1 ||callSessUser('jabatan_user') == 5) {

			$this->GlobalModel->deleteData('user',array('id_user'=>$id));
			$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
			redirect(BASEURL.'user');
		} else {
			$this->session->set_flashdata('msg','JANGAN HAPUS HAPUS AKUN ORANG!');
			redirect(BASEURL.'user');

		}
		
	}
}