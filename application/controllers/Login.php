<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$data=[];
		$this->load->view('login',$data);
	}

	public function auth()
	{
		$post = $this->input->post();
		$dataUser = $this->GlobalModel->getDataRow('user',array('email_user' => trim($post['email'])));
		 //pre(PASSWORD_DEFAULT);
		 //pre(password_hash($post['password'], PASSWORD_DEFAULT));
		if (isset($dataUser['password_user'])) {
			if (password_verify($post['password'],$dataUser['password_user'])) {
				$dataSession = array(
					'id_user'=> $dataUser['id_user'], 
					'nama_user'	=> $dataUser['nama_user'], 
					'jabatan_user'	=> $dataUser['jabatan_user'], 
					'email_user'	=> $dataUser['email_user'], 
					'status_user'	=> $dataUser['status_user'], 
					'menu_flag'		=> $dataUser['menu_flag'],
					'foto'			=> $dataUser['foto'],
					'LOGIN'			=> TRUE
				);
				$this->session->set_userdata($dataSession);
				if($dataUser['id_user']==11){

				}else{
					$cek=$this->GlobalModel->getDataRow('log_user',array('userid'=>$dataUser['id_user'],'tanggal'=>date('Y-m-d')));
					if(empty($cek)){
						$login=array(
							'userid'=> $dataUser['id_user'], 
							'nama'	=> $dataUser['nama_user'],
							'tanggal'=>date('Y-m-d'),
							'login'=>date('Y-m-d H:i:s'),
							'logout'=>null,
						);
						$this->db->insert('log_user',$login);
					}
				}
				//redirect(BASEURL.'dashboard');
				redirect(BASEURL.'dash/welcome');
			} else {
			$this->session->set_flashdata('gagal','Username atau password salah');
			redirect(BASEURL.'login');
			}
		} else {
			$this->session->set_flashdata('gagal','Username atau password salah');
			redirect(BASEURL.'login');
			$this->session->sess_destroy();
		}
	}

	public function signout()
	{
		$cek=$this->GlobalModel->getDataRow('log_user',array('userid'=>callSessUser('id_user'),'tanggal'=>date('Y-m-d')));
				if(!empty($cek)){
					$login=array(
						'logout'=>date('Y-m-d H:i:s'),
					);
					$this->db->update('log_user',$login,array('id'=>$cek['id']));
				}
		$this->session->sess_destroy();
		redirect(BASEURL);
	}
}
