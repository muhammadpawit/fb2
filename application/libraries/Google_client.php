<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "vendor/autoload.php";

class Google_client {
    protected $CI;
    protected $client;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->config('google_client');
        $this->client = new Google_Client();
        $this->client->setClientId($this->CI->config->item('google_client_id'));
        $this->client->setClientSecret($this->CI->config->item('google_client_secret'));
        $this->client->setRedirectUri($this->CI->config->item('google_redirect_uri'));
        $this->client->addScope($this->CI->config->item('google_scopes'));
    }

    public function getClient() {
        return $this->client;
    }
}
