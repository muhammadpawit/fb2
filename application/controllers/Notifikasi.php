<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

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
	public $image_lib;
    public $load;
    public $email;

    public function kirim()
    {
        // load library email + config
        $this->load->library('email');
        $this->load->config('email');
        $data=[];
        $user=11;
        $data['user']=$this->GlobalModel->GetDataRow('user',array('id_user'=>$user));
        $data['akses']=$this->GlobalModel->GetDataRow('aksesdata',array('user_id'=>$user));
        $message = $this->load->view('newtheme/page/email/aksesdata', $data, TRUE);
        $this->email->from(getenv('SMTP_USER'), 'Sistem Pengajuan');
        $this->email->to($data['user']['email_user']);
        $this->email->subject('Anda telah diberikan hak otorisasi '.$data['akses']['batas']);
        $this->email->message($message);

        if ($this->email->send()) {
            echo "✅ Email notifikasi berhasil dikirim!";
        } else {
            echo "❌ Gagal kirim email:";
            echo $this->email->print_debugger();
        }
    }
}
