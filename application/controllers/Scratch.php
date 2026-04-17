<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scratch extends CI_Controller {
    public function index() {
        $supplier = $this->GlobalModel->getData('master_supplier', array('hapus' => 0));
        var_dump($supplier);
        $products = $this->GlobalModel->getData('product', array('hapus' => 0));
        var_dump($products);
    }
}
