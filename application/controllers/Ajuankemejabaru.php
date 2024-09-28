<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajuankemejabaru extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->page='newtheme/page/';
		$this->url=BASEURL.'Ajuankemejabaru/';
        // Memuat model
        $this->load->model('AjuanKemejaModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
    }

    // Fungsi untuk menampilkan semua data
    public function index() {
        $data = [];
        $data['title']='Ajuan Alat-alat Kirim PO Kemeja ';
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
		if(isset($get['cat'])){
			$cat=$get['cat'];
		}else{
			$cat=null;
		}
        $filter=array(
            'tanggal1' => $tanggal1,
            'tanggal2' => $tanggal2,
        );
        $data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
        $data['tambah']=null;
        $data['tambah_action']=$this->url.'store';
        $data['item'] = $this->GlobalModel->GetData('product',array('hapus'=>0));
        $data['products'] = $this->AjuanKemejaModel->get_all($filter);
        // Memuat view dan mengirimkan data
        if(isset($get['spv'])){
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_baru_spv';
		}else{
			$data['page']=$this->page.'gudang/pengajuan/mingguan_list_baru';
		}
        $this->load->view($this->page.'main',$data);
    }


    public function cariproduct($id='')
	{
		$getId = $this->input->get('id');
		// $data = $this->GlobalModel->getDataRow('stok_barang_skb',array('id_persediaan'=>$getId));
		$data = $this->GlobalModel->QueryManualRow(
			"SELECT COALESCE(SUM(quantity),0) as stock FROM product WHERE product_id='".$getId."' "
		);
		echo json_encode($data);
	}

    // Fungsi untuk menampilkan form tambah data
    public function create() {
        $this->load->view('ajuan_kemeja_baru/create');
    }

    // Fungsi untuk menyimpan data baru
    public function store() {
        // Mengambil data dari form
        $data = [
            'tanggal' => $this->input->post('tanggal'),
            'nama_barang' => $this->input->post('nama_barang'),
            'jumlah_lapisan' => $this->input->post('jumlah_lapisan'),
            'jumlah_dz' => $this->input->post('jumlah_dz'),
            'jumlah_per_baju' => $this->input->post('jumlah_per_baju'),
            'jumlah_per_cons' => $this->input->post('jumlah_per_cons'),
            'rincian' => $this->input->post('rincian'),
            'kebutuhan' => $this->input->post('kebutuhan'),
            'stok' => $this->input->post('stok'),
            'ajuan' => $this->input->post('ajuan'),
            'rincian_ajuan' => $this->input->post('rincian_ajuan')
        ];

        // Memasukkan data ke database
        $this->AjuanKemejaModel->insert($data);

        // Redirect setelah berhasil menambah data
        $this->session->set_flashdata('msg','Data berhasil disimpan');
        redirect($this->url);
    }

    // Fungsi untuk menampilkan form edit data
    public function edit($id) {
        $data['ajuan_kemeja_baru'] = $this->AjuanKemejaModel->get_by_id($id);
        $this->load->view('ajuan_kemeja_baru/edit', $data);
    }

    // Fungsi untuk memperbarui data berdasarkan ID
    public function update($id) {
        // Mengambil data dari form
        $data = [
            'nama_barang' => $this->input->post('nama_barang'),
            'jumlah_lapisan' => $this->input->post('jumlah_lapisan'),
            'jumlah_dz' => $this->input->post('jumlah_dz'),
            'jumlah_per_baju' => $this->input->post('jumlah_per_baju'),
            'jumlah_per_cons' => $this->input->post('jumlah_per_cons'),
            'rincian' => $this->input->post('rincian'),
            'kebutuhan' => $this->input->post('kebutuhan'),
            'stok' => $this->input->post('stok'),
            'ajuan' => $this->input->post('ajuan'),
            'rincian_ajuan' => $this->input->post('rincian_ajuan')
        ];

        // Mengupdate data di database
        $this->AjuanKemejaModel->update($id, $data);

        // Redirect setelah berhasil mengupdate data
        redirect('AjuanKemejaBaru');
    }

    // Fungsi untuk menghapus data berdasarkan ID
    public function delete($id) {
        // Menghapus data dari database
        $this->AjuanKemejaModel->delete($id);

        // Redirect setelah berhasil menghapus data
        $this->session->set_flashdata('msg','Data berhasil dihapus');
        redirect($this->url);
    }

    function setujui(){
		$post = $this->input->post();
		// pre($post);
		$cat=3; // kategori untuk ajuan harian bagian konveksi
		// $cekajuan_harian = $this->GlobalModel->QueryManualRow("SELECT * FROM pengajuan_harian_new WHERE kategori='".$cat."' AND from_alat IS NOT NULL AND DATE(tanggal)='".$post['tanggal']."' AND hapus=0 ");
		$cekajuan_harian = null;
		//pre($cekajuan_harian);
		//pre();
		if(empty($cekajuan_harian)){
			$ip=array(
				'kategori'=>$cat,
				'cash'=>0,
				'transfer'=>0,
				'status'=>1,
				'hapus'=>0,
				'tanggal'=>date('Y-m-d'),
				'keterangan'=>'',
				'dibuat'=>date('Y-m-d H:i:s'),
				'from_alat' => TRUE
			);
			$this->db->insert('pengajuan_harian_new',$ip);
			$id=$this->db->insert_id();
			$transfer=0;
			$cash=0;
			foreach($post['prods'] as $pr){
				$p=$this->GlobalModel->GetDataRow('ajuan_mingguan',array('id'=>$pr['id']));
				$item=$this->GlobalModel->GetDataRow('product',array('product_id'=>$pr['product_id']));
				// $supplier=$this->GlobalModel->GetDataRow('master_supplier',array('id'=>$p['supplier_id']));
				if(isset($pr['metodebayar'])){

					if($pr['metodebayar']=='Transfer'){
						$transfer+=($item['harga_beli']*$pr['jml_acc']);
						// $cash=0;
					}else{
						// $transfer=0;
						$cash+=($item['harga_beli']*$pr['jml_acc']);
					}
				}else{
                    $transfer+=($item['harga_beli']*$pr['jml_acc']);
                }
				$rip=array(
						'idpengajuan'=>$id,
						'nama_item'=>$item['nama'],
						'jumlah'=>$pr['jml_acc'],
						'satuan'=>$item['satuan'],
						'harga'=>$item['harga_beli'],
						'pembayaran'=> isset($pr['metodebayar']) && $pr['metodebayar'] == 'Cash'  ? 1:2, // 1 Cash, 2 Transfer
						// 'supplier'=>$supplier['nama'],
                        'supplier'=>'-',
						'keterangan'=>$pr['keterangan2'],
						'status'=>1,
						'from_alat' => $p['id']
				);
				$this->db->insert('pengajuan_harian_new_detail',$rip);
			}
			$this->db->update('pengajuan_harian_new',array('cash'=>$cash,'transfer'=>$transfer),array('id'=>$id));
			$image_data = $this->input->post('image_data');
			// pre($post);
			// Mengonversi data base64 menjadi file gambar
			$image_data = base64_decode($image_data);
			$file_name = uniqid() . '.png';
			$file_path = FCPATH . 'uploads/signatures/' . $file_name;

			if (file_put_contents($file_path, $image_data)) {
				$update = array(
					'paraf' => $file_name,
				);
				$where = array(
					'id' => $id,
				);
				$this->db->update('pengajuan_harian_new',$update,$where);
				
			} else {
				echo 'Failed to save signature.';
			}
		}else{
			
			$this->session->set_flashdata('gagal','Data gagal di tersimpan ke ajuan harian.');
			redirect(BASEURL.'Ajuankemejabaru?&spv=true');
		}

		echo $id;
	}
}
