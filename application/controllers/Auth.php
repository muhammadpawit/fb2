<?php
defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Auth extends CI_Controller {


    public $layout;
	public $page;
	public $url;
	public $login;
	public $auth;
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
    public $session;
    public function __construct() {
        parent::__construct();
        // Load the Google API client library
        require_once 'vendor/autoload.php'; // Sesuaikan path jika berbeda
        $this->load->library('session');
    }

    public function index() {
        $client = new Google_Client();
        if (file_exists(APPPATH . 'config/google_oauth.php')) {
            require_once APPPATH . 'config/google_oauth.php';
        } else {
            if(!defined('GOOGLE_CLIENT_ID')) define('GOOGLE_CLIENT_ID', 'YOUR_GOOGLE_CLIENT_ID');
            if(!defined('GOOGLE_CLIENT_SECRET')) define('GOOGLE_CLIENT_SECRET', 'YOUR_GOOGLE_CLIENT_SECRET');
        }
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(BASEURL.'auth/google_callback'); // Sesuaikan dengan Redirect URI Anda
        $client->addScope('email');
        $client->addScope('profile');

        $data['auth_url'] = $client->createAuthUrl();
        
        $this->load->model('GlobalModel');
        $data['carousels'] = $this->GlobalModel->QueryManual("SELECT * FROM carousel_slide WHERE hapus=0 AND status=1 ORDER BY urutan ASC");
        
        // $this->load->view('login_view', $data);
        $this->load->view('login_view_modern_input', $data);
    }

    public function google_callback() {
        
        $client = new Google_Client();
        if (file_exists(APPPATH . 'config/google_oauth.php')) {
            require_once APPPATH . 'config/google_oauth.php';
        } else {
            if(!defined('GOOGLE_CLIENT_ID')) define('GOOGLE_CLIENT_ID', 'YOUR_GOOGLE_CLIENT_ID');
            if(!defined('GOOGLE_CLIENT_SECRET')) define('GOOGLE_CLIENT_SECRET', 'YOUR_GOOGLE_CLIENT_SECRET');
        }
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(BASEURL.'auth/google_callback'); // Sesuaikan dengan Redirect URI Anda
        // pre($client);
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            if (!isset($token['error'])) {
                $client->setAccessToken($token);
                // ✅ Token valid — simpan ke file atau session
                file_put_contents('token.json', json_encode($token));
                // echo 'Token berhasil disimpan!';
                
            } else {
                echo 'Error token: ' . $token['error'];
            }

            // Store the token in session (opsional, untuk menjaga sesi login)
            $this->session->set_userdata('google_access_token', $token);

            $oauth2 = new Google_Service_Oauth2($client);
            $user_info = $oauth2->userinfo->get();

            // Dapatkan informasi pengguna
            $google_id = $user_info->id;
            $email = $user_info->email;
            $name = $user_info->name;
            $picture = $user_info->picture;

            $dataUser = $this->GlobalModel->getDataRow('user',array('hapus'=>0,'status_user'=>1,'email_user' => trim($email)));
            $this->db->update('user',array('foto'=>$picture,'nama_user'=>$name),array('email_user'=>trim($email)));
            if (isset($dataUser['password_user'])) {
                $dataSession = array(
					'id_user'=> $dataUser['id_user'], 
					'nama_user'	=> $name, 
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

                 $this->session->set_userdata('user_id', $google_id);
                $this->session->set_userdata('user_email', $email);
                $this->session->set_userdata('user_name', $name);
                $this->session->set_userdata('user_picture', $picture);

                redirect(BASEURL.'dash/welcome');
            }else{

                    $login=array(
							'nama'	=> $name,
							'email'	=> $email,
							'tanggal'=>date('Y-m-d H:i:s'),
						);
						$this->db->insert('gagal_login',$login);

                $this->session->set_flashdata('gagal','Username atau password salah');
                redirect(BASEURL.'auth');
            }
           
        } else {
            // Jika ada error atau pengguna membatalkan login
            $this->session->set_flashdata('gagal','Username atau password salah');
            redirect(BASEURL.'auth');
        }
    }

    public function logout() {
        $this->session->unset_userdata('google_access_token');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_picture');
        session_destroy();
        redirect('auth');
    }

    public function login(){
        $post = $this->input->post();
        $dataUser = $this->GlobalModel->getDataRow('user',array('hapus'=>0,'status_user'=>1,'email_user' => trim($post['email'])));
         if (isset($dataUser['password_user'])) {
			if ((md5($post['password']) == $dataUser['password_user'])) {
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
}