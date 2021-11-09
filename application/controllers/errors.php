<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class errors extends CI_Controller {

    function __construct() {
        parent::__construct();
        sessionLogin();
    }

    public function page()
    {
        $this->load->view('pageerror');
    }
}