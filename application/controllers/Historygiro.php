<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historygiro extends CI_Controller {

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
	public $HistorygiroModel;


	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/historygiro/';
		$this->layout='newtheme/page/';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
		$this->load->model('HistorygiroModel');
		$this->uri=BASEURL.'Historygiro/';
	}

	public function index()
	{
		$data=array();
		$resutls=array();
		$data['title']='Master Supplier';
		$data['hasil']=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'Masterdata/supplieradd';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday this week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['products']=array();
		$data['supplier']= $this->GlobalModel->getData('master_supplier',array('hapus'=>0));
		$data['penerimaan_item']=[];
		


		$query = "SELECT a.*, b.nama FROM supplier_giro a LEFT JOIN master_supplier b ON b.id = a.supplier_id WHERE a.hapus=0 ";
		if(!empty($tanggal1)){
			$query.=" AND date(a.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'";
		}

		$query.=" ORDER BY a.id DESC";
		$resutls = $this->GlobalModel->queryManual($query);
		$data['action']=[];
		foreach($resutls as $s){

			$action[] = array(
				'text' => 'detail',
				'href' => $this->uri.'detail/'.$s['id'],
				'bg' => bgColor('detail'),
			);


			$data['products'][]=array(
				'id'=>$s['id'],
				'tanggal'=>formatTanggalIndo($s['tanggal']),
				'namasupplier'=>$s['nama'],
				'jumlah'=>$s['nominal'],
				'keterangan'=>$s['keterangan'],
				'action' => $action,
				// 'edit'=>BASEURL.'Masterdata/supplieredit/'.$s['id'],
				// 'hapus'=>BASEURL.'Masterdata/supplierhapus/'.$s['id'],
			);
		}

		$data['page']=$this->page.'list';

		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');

	}
	

	public function supplieradd()

	{
		$data=array();
		$data['title']='Tambah Master Supplier';
		$data['action']=BASEURL.'Masterdata/suppliersave';
		$data['batal']=BASEURL.'Masterdata/supplier';
		$data['page']='master/supplier/form';
		$this->load->view('newtheme/layout/header');
		$this->load->view('newtheme/page/main',$data);
		$this->load->view('newtheme/layout/footer');

	}


	public function suppliersave(){
		$data=$this->input->post();
		if(isset($data['data']) && !empty($data['data'])){
			foreach($data['data'] as $sup){
				if(!empty($sup['nama'])){
					$insert=array(
						'nama'=>$sup['nama'],
						'pic'=>$sup['pic'],
						'telephone'=>$sup['telephone'],
						'alamat'=>$sup['alamat'],
						'hapus'=>0,
					);
					$this->db->insert('master_supplier',$insert);
				}
			}
			$this->session->set_flashdata('msg','Data berhasil ditambah');
			redirect(BASEURL.'masterdata/supplier');
		}else{
			$this->session->set_flashdata('msg','Data Gagal ditambah');
			redirect(BASEURL.'masterdata/supplieradd');
		}
		
	}

	public function supplieredit($id){
		$data=array();
		$data['title']='Edit Supplier';
		$data['action']=BASEURL.'Masterdata/suppliereditsave';
		$data['products']=$this->GlobalModel->getDataRow('master_supplier',array('id'=>$id));
		$data['page']='master/supplier/edit';
		$this->load->view($this->page.'main',$data);
	}

	public function suppliereditsave(){
		$sup=$this->input->post();
		$update=array(
			'nama'=>$sup['nama'],
			'pic'=>$sup['pic'],
			'telephone'=>$sup['telephone'],
			'alamat'=>$sup['alamat'],
			'category'=>$sup['category'],
			'is_supplier_bahan'=> isset($sup['is_supplier_bahan']) ? $sup['is_supplier_bahan'] : null,
		);
		$this->db->update('master_supplier',$update,array('id'=>$sup['id']));
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'masterdata/supplier');
	}

	function get_penerimaan_items($supplier_id) {
		// Initialize the response array
		$response = array();
		
		// Get penerimaan items for the supplier
		$penerimaan_items = $this->GlobalModel->GetData(
			'penerimaan_item',
			array(
				'hapus' => 0,
				'tipepembayaran' => 'Tempo',
				'status_pembayaran' => 'belum',
				'supplier' => $supplier_id
			),
			array(
				'tanggal >=' => '2024-12-01',
				'tanggal <=' => date('Y-m-d'),
				'id NOT IN (SELECT penerimaan_item_id FROM supplier_giro_pembayaran WHERE hapus = 0)' => null
			)
		);
		
		// Get supplier name for display
		$supplier = $this->GlobalModel->getDataRow('master_supplier', array('id' => $supplier_id));
		$supplier_name = $supplier ? $supplier['nama'] : 'Unknown Supplier';
		
		// Prepare the data for each item
		$data = array();
		foreach ($penerimaan_items as $p) {
			// Calculate total
			$total = $this->GlobalModel->QueryManualRow("
				SELECT COALESCE(SUM(ukuran*harga), 0) as total 
				FROM penerimaan_item_detail 
				WHERE penerimaan_item_id='".$p['id']."' 
				AND hapus=0
			");
			
			// Format the display text
			$text = $p['keterangan'] . ' dari ' . $supplier_name . ' ' . 
					date('d F Y', strtotime($p['tanggal'])) . ' Rp.' . 
					number_format($total['total']);
			
			// Add to data array
			$data[] = array(
				'id' => $p['id'],
				'text' => $text,
				'total' => $total['total']
			);
		}
		
		// Set the response
		$response = array(
			'status' => true,
			'data' => $data
		);
		
		// Return as JSON
		header('Content-Type: application/json');
		echo json_encode($response);
		exit();
	}

	 private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        // Validasi tanggal
        if ($this->input->post('tanggal') == '') {
            $data['inputerror'][] = 'tanggal';
            $data['error_string'][] = 'Tanggal harus diisi';
            $data['status'] = FALSE;
        }

        // Validasi nama supplier
        if ($this->input->post('namasupplier') == '') {
            $data['inputerror'][] = 'namasupplier';
            $data['error_string'][] = 'Nama Supplier harus diisi';
            $data['status'] = FALSE;
        }

        // Validasi jumlah
        if ($this->input->post('jumlah') == '') {
            $data['inputerror'][] = 'jumlah';
            $data['error_string'][] = 'Jumlah harus diisi';
            $data['status'] = FALSE;
        } elseif (!is_numeric(str_replace(',', '', $this->input->post('jumlah')))) {
            $data['inputerror'][] = 'jumlah';
            $data['error_string'][] = 'Jumlah harus berupa angka';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

	function save(){
		$this->_validate(); // Validasi input
        
        $data = array(
            'tanggal' => $this->input->post('tanggal'),
            'supplier_id' => $this->input->post('namasupplier'),
			'keterangan' => $this->input->post('keterangan'),
            'nominal' => str_replace(',', '', $this->input->post('jumlah')) // Format angka
        );
        
        $insert = $this->HistorygiroModel->save($data);
        
        if ($insert) {
            $this->session->set_flashdata('msg', 'Data berhasil disimpan');
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("status" => FALSE, "message" => "Gagal menyimpan data"));
        }
	}

	public function detail($id) {
        $data = $this->HistorygiroModel->get_by_id($id);
        if ($data) {
            // Format data sebelum dikirim ke view
            $data->tanggal = date('Y-m-d', strtotime($data->tanggal));
            $data->nominal = number_format($data->nominal, 0, ',', '.');
            echo json_encode($data);
        } else {
            echo json_encode(array("status" => FALSE, "message" => "Data tidak ditemukan"));
        }
    }
}