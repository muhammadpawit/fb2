<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accalatpo extends CI_Controller {

	function __construct() {
		parent::__construct();
		////sessionLogin(URLPATH."\\".$this->uri->segment(1));
		////session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/accalatpo/';
		$this->url=BASEURL.'accalatpo/';
	}

}