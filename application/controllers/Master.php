<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Master extends CI_Controller {



	function __construct() {

		parent::__construct();

		sessionLogin(URLPATH."\\".$this->uri->segment(1));

		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

	}

	public function supplier()

	{
		$data=array();
		$resutls=array();
		$data['hasil']=array();
		$data['n']=1;
		$data['tambah']=BASEURL.'master/supplieradd';
		$resutls = $this->GlobalModel->queryManual('SELECT * FROM master_supplier WHERE hapus=0  ORDER BY nama ASC');
		foreach($resutls as $s){
			$data['hasil'][]=array(
				'id'=>$s['id'],
				'nama'=>$s['nama'],
				'telephone'=>$s['telephone'],
				'alamat'=>$s['alamat'],
			);
		}
		$this->load->view('global/header');

		$this->load->view('master/supplier/list',$data);

		$this->load->view('global/footer');

	}

	public function supplieradd()

	{
		$data=array();
		$data['action']=BASEURL.'master/suppliersave';
		$this->load->view('global/header');

		$this->load->view('master/supplier/form',$data);

		$this->load->view('global/footer');

	}


	public function suppliersave(){
		$data=$this->input->post();
		if(isset($data['data']) && !empty($data['data'])){
			foreach($data['data'] as $sup){
				if(!empty($sup['nama'])){
					$insert=array(
						'nama'=>$sup['nama'],
						'telephone'=>$sup['telephone'],
						'alamat'=>$sup['alamat'],
						'hapus'=>0,
					);
					$this->db->insert('master_supplier',$insert);
				}
			}
			$this->session->set_flashdata('msg','Data berhasil ditambah');
			redirect(BASEURL.'master/supplier');
		}else{
			$this->session->set_flashdata('msg','Data Gagal ditambah');
			redirect(BASEURL.'master/supplieradd');
		}
		
	}

	public function karyawanbordir()

	{
		$data 	=array();
		$data['n']=1;
		$data['karyawan']=$this->GlobalModel->queryManual('SELECT * FROM master_karyawan_bordir ORDER BY nama_karyawan_bordir ASC');
		$data['tambah']=BASEURL.'master/karyawanbordiradd';
		$this->load->view('global/header');

		$this->load->view('master/karyawanbordir/list',$data);

		$this->load->view('global/footer');

	}

	public function karyawanbordiradd(){
		$data=array();
		$data['insert']=BASEURL.'master/karyawanbordirsave';
		$this->load->view('global/header');

		$this->load->view('master/karyawanbordir/form',$data);

		$this->load->view('global/footer');
	}

	public function karyawanbordirsave(){
		$post=$this->input->post();
		$insert=array(
			'nama_karyawan_bordir'=>$post['nama'],
			'karyawan_gaji_weekday'=>65000,
			'karyawan_gaji_weekend'=>130000,
		);
		$this->db->insert('master_karyawan_bordir',$insert);
		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'master/karyawanbordir');
	}

	public function jenispo()

	{

		$viewData['jenis']	= $this->GlobalModel->getData('jenis_po',null);

		$this->load->view('global/header');

		$this->load->view('master/jenispo/jenis-po',$viewData);

		$this->load->view('global/footer');

	}



	public function jenispoTambah()

	{

		$this->load->view('global/header');

		$this->load->view('master/jenispo/jenis-po-tambah');

		$this->load->view('global/footer');

	}



	public function jenispoOnCreate()

	{

		$post = $this->input->post();



		$dataInserted = array(

			'kode_jenis_po'		=>	$post['kode'],

			'nama_jenis_po'		=>	$post['namajenis'],

			'tanggal_created'	=>	date('Y-m-d'),

			'status'			=>	$post['status']

		);

		$this->GlobalModel->insertData('jenis_po',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'master/jenispo');

	}



	public function jenispoEdit($id)

	{

		$viewData['jenis']	= $this->GlobalModel->getDataRow('jenis_po',array('id_jenis_po'=>$id));



		$this->load->view('global/header');

		$this->load->view('master/jenispo/jenis-po-edit',$viewData);

		$this->load->view('global/footer');

	}



	public function jenispoOnChange($id)

	{

		$post = $this->input->post();

		$dataInserted = array(

			'kode_jenis_po'		=>	$post['kode'],

			'nama_jenis_po'		=>	$post['namajenis'],

			'dimodifikasi'		=>	date('Y-m-d'),

			'status'			=>	$post['status']

		);



		$this->GlobalModel->updateData('jenis_po',array('id_jenis_po'=>$id),$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil diupdate');

		redirect(BASEURL.'master/jenispo');

	}



	public function jenispoDelete($id)

	{

		$this->GlobalModel->deleteData('jenis_po',array('id_jenis_po'=>$id));

		$this->session->set_flashdata('msg','Data berhasil didelete');

		redirect(BASEURL.'master/jenispo');

	}



	public function satuanbarang()

	{

		$viewData['satuan']	= $this->GlobalModel->getData('master_satuan_barang',null);

		$this->load->view('global/header');

		$this->load->view('master/satuanbarang/satuan-view',$viewData);

		$this->load->view('global/footer');

	}



	public function satuanbarangTambah()

	{

		$this->load->view('global/header');

		$this->load->view('master/satuanbarang/satuan-tambah');

		$this->load->view('global/footer');

	}



	public function satuanbarangOnCreate()

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama_satuan_barang'	=> 	$post['nama'],

			'created_date'			=> 	date('Y-m-d'),

			'kode_satuan_barang'	=>	$post['kodeSatuan']

		);

		$this->GlobalModel->insertData('master_satuan_barang',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'master/satuanbarang');

	}



	public function satuanbarangEdit($id)

	{

		$viewData['satuan']	= $this->GlobalModel->getDataRow('master_satuan_barang',array('id_satuan_barang'=>$id));



		$this->load->view('global/header');

		$this->load->view('master/satuanbarang/satuan-edit',$viewData);

		$this->load->view('global/footer');

	}



	public function satuanbarangOnChange($id)

	{

		$post = $this->input->post();

		$dataInserted = array(

			'nama_satuan_barang'	=> 	$post['nama'],

			'created_date'			=> 	date('Y-m-d'),

			'kode_satuan_barang'	=>	$post['kodeSatuan']

		);



		$this->GlobalModel->updateData('master_satuan_barang',array('id_satuan_barang'=>$id),$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil diupdate');

		redirect(BASEURL.'master/satuanbarang');

	}



	public function satuanDelete($id)

	{

		$this->GlobalModel->deleteData('master_satuan_barang',array('id_satuan_barang'=>$id));

		$this->session->set_flashdata('msg','Data berhasil didelete');

		redirect(BASEURL.'master/satuanbarang');

	}



	public function namapo()

	{

		$viewData['satuan']	= $this->GlobalModel->getData('master_nama_po',null);

		$this->load->view('global/header');

		$this->load->view('master/po/po-view',$viewData);

		$this->load->view('global/footer');

	}



	public function namapoTambah()

	{

		$this->load->view('global/header');

		$this->load->view('master/po/po-tambah');

		$this->load->view('global/footer');

	}



	public function namapoTambahOnCreate()

	{

		$post = $this->input->post();

		$dataInserted = array(

			'kode_po'			=> 	$post['kodePO'],

			'nama_lengkap_po'	=> 	$post['namaLengkapPO'],

			'kode_artikel'		=>	$post['kodeArtikel'],

			'created_date'		=> 	date('Y-m-d')

		);

		$this->GlobalModel->insertData('master_nama_po',$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil ditambah');

		redirect(BASEURL.'master/namapo');

	}



	public function namapoEdit($id='')

	{

		$viewData['po']	= $this->GlobalModel->getDataRow('master_nama_po',array('id_nama_po'=>$id));

		$this->load->view('global/header');

		$this->load->view('master/po/po-edit',$viewData);

		$this->load->view('global/footer');

	}



	public function namapoEditOnCreate($id="")

	{

		$post = $this->input->post();

		$dataInserted = array(

			'kode_po'			=> 	$post['kodePO'],

			'nama_lengkap_po'	=> 	$post['namaLengkapPO'],

			'kode_artikel'		=>	$post['kodeArtikel'],

			'created_date'		=> 	date('Y-m-d')

		);



		$this->GlobalModel->updateData('master_nama_po',array('id_nama_po'=>$id),$dataInserted);

		$this->session->set_flashdata('msg','Data berhasil diupdate');

		redirect(BASEURL.'master/namapo');

	}



	public function deletePoKode($id='')

	{

		$this->GlobalModel->deleteData('master_nama_po',array('id_nama_po'=>$id));

		$this->session->set_flashdata('msg','Data berhasil didelete');

		redirect(BASEURL.'master/namapo');

	}





}

