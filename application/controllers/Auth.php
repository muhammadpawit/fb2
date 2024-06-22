<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('google_client');
    }

    public function login() {
        $client = $this->google_client->getClient();
        $authUrl = $client->createAuthUrl();
        redirect($authUrl);
    }

    public function callback() {
        $client = $this->google_client->getClient();
        if ($this->input->get('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->input->get('code'));
            $client->setAccessToken($token);

            // Mendapatkan profil pengguna
            $oauth = new Google_Service_Oauth2($client);
            $userInfo = $oauth->userinfo->get();

            // Menyimpan data pengguna di session atau database
            $this->session->set_userdata('user_data', $userInfo);
            
            // Arahkan pengguna ke halaman utama atau dashboard
            redirect('home');
        } else {
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_data');
        redirect('auth/login');
    }
}
