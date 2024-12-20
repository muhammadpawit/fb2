<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterpoonline extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('CustomerModel');
		$this->load->model('PenjualanModel');
		$this->load->model('OnlineModel');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/masterpoonline/';
		$this->url=BASEURL.'Masterpoonline/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data=[];
		$data['title']='Data Master PO Online';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 day"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$filter = array();
		$data['prods']=[];
		$data['prods']=$this->OnlineModel->getMasterPoOnline($filter);
		$data['action'] = $this->url.'add';
		$data['link'] = $this->url;
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

	public function add(){
		$data=[];
		$data['title']='Data Master PO Online';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 day"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['prods']=[];
		$data['customer']=$this->CustomerModel->getDataCustomer();
		$data['ekspedisi']=$this->PenjualanModel->getDataEkspedisi();
		$data['marketplace']=$this->PenjualanModel->getDataMarketplace();
		// pre($data['marketplace']);
		$data['po']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('cmt_job_desk'=>'JAHIT','hapus'=>0));
		$data['serian']=$this->GlobalModel->getData('master_po_online_serian',array('hapus'=>0));
		// pre($data['customer']);
		$data['action'] = $this->url.'insert';
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'add';
			$this->load->view($this->layout,$data);
		}
	}

	function detail($id){
		$data['title']='Detail Penerimaan PO Online';
		$data['prods']=$this->OnlineModel->getMasterPoOnlineDetail($id);
		$data['products']=[];
		// $data['products']=$this->GlobalModel->getData('master_po_online_detail',array('id_master_po_online'=>$id,'hapus'=>0));
		$data['products']= $this->OnlineModel->getMasterPoDetail($id);
		// pre($data['products']);
		$data['page']=$this->page.'detail';
		$data['action']= $this->url.'terima';
		$data['batal']= $this->url.'';
		$this->load->view($this->layout,$data);
	}

	function getPo(){
		$get = $this->input->get();
		$id  = $get['id'];
		$data = $this->OnlineModel->getPo($id);
		echo json_encode($data);
	}

	function terima(){
		// $input = $this->input->post();
		// pre($input);
		$input = $this->input->post();
		// pre($input);
		$save = $this->OnlineModel->terima($input);
		if($save==TRUE){
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}

	public function insert(){
		$input = $this->input->post();
		// pre($input);
		$save = $this->OnlineModel->insert($input);
		if($save==TRUE){
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}

	public function serian(){
		$data=[];
		$data['title']='Data Master Serian PO Online';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 day"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$filter = array();
		$data['prods']=[];
		$data['prods']=$this->OnlineModel->getSerian($filter);
		$data['action'] = $this->url.'add_serian';
		$data['link'] = $this->url;
		if(isset($get['excel'])){
			$this->load->view($this->page.'excel',$data);
		}else{
			$data['page']=$this->page.'serian';
			$this->load->view($this->layout,$data);
		}
	}

	function add_serian(){
		$data 			=[];
		$data['action'] = $this->url.'save_serian';
		$data['batal'] = $this->url.'serian';
		$data['page']=$this->page.'serian_form';
		$this->load->view($this->layout,$data);
	}

	public function save_serian(){
		$input = $this->input->post();
		// pre($input);
		if(isset($input['id'])){
			$insert = array('nama'=>$input['nama']);
			$save = $this->db->update('master_po_online_serian',$insert,array('id'=>$input['id']));
		}else{
			$insert = array('nama'=>$input['nama']);
			$save = $this->db->insert('master_po_online_serian',$insert);
		}
		if($save==TRUE){
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url.'serian');
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url.'serian');
		}
	}

	function editserian($id){
		$data 			=[];
		$data['title']	= 'Edit Serian';
		$data['prods']	= $this->GlobalModel->getDataRow('master_po_online_serian',array('id'=>$id));
		$data['action'] = $this->url.'save_serian';
		$data['batal'] = $this->url.'serian';
		$data['page']=$this->page.'serian_form';
		$this->load->view($this->layout,$data);
	}

	function edit($id){
		$data['title']='Edit Master PO Online';
		$data['prods']=$this->OnlineModel->getMasterPoOnlineDetail($id);
		$data['products']=[];
		// $data['products']=$this->GlobalModel->getData('master_po_online_detail',array('id_master_po_online'=>$id,'hapus'=>0));
		$data['products']= $this->OnlineModel->getMasterPoDetail($id);
		$data['serians'] = $this->GlobalModel->GetData('master_po_online_serian',array('hapus'=>0));
		$data['sizes'] = $this->GlobalModel->GetData('size_po_online',array('hapus'=>0));
		// pre($data['products']);
		$data['page']=$this->page.'edit';
		$data['action']= $this->url.'edit_save';
		$data['batal']= $this->url.'';
		$this->load->view($this->layout,$data);
	}

	function edit_save(){
		// $input = $this->input->post();
		// pre($input);
		$input = $this->input->post();
		// pre($input);
		$save = $this->OnlineModel->updateDetail($input);
		if($save==TRUE){
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan');
			redirect($this->url);
		}
	}
}