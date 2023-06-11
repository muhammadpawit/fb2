<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poretur extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/poretur/';
		$this->url=BASEURL.'Poretur/';
		$this->load->model('AdjustModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function index(){
		$data['title']='PO Retur';
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kodepo=$get['kode_po'];
		}else{
			$kodepo=null;
		}

		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=null;
		}

        if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=null;
		}

        if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=null;
		}

        $data['tanggal1']=$tanggal1;
        $data['tanggal2']=$tanggal2;

		$data['kode_po']=$kodepo;
		$data['tahun']=$tahun;
		$sql="SELECT * FROM po_retur WHERE hapus=0 ";
		if(!empty($tahun)){
			$sql .= " AND tahun='".$tahun."' ";
		}
		if(!empty($kodepo)){
			$sql .= " AND kode_po LIKE '%".$kodepo."%' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=[];
		$data['prods']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no++,
				'id'=>$r['id'],
				'jumlah'=>$r['jumlah_pcs'],
				'idpo'=>$r['idpo'],
				'kode_po'=>$r['kodepo'],
				'keterangan'=>$r['keterangan'],
                'detail'=>$this->url.'poretur_detail/'.$r['id'],
			);
		}
        //pre($data['prods']);
		$data['tambah']=$this->url.'add';
		$data['page']=$this->page.'list';
		$this->load->view($this->layout,$data);
	}

    function caripo(){
        $get = $this->input->get();
        $lastyear=date('Y',strtotime('-1 year'));
        $tahun=$lastyear.'_'.date('Y');
        $po = explode(',',$get['kode_po']);
        $sql="SELECT kd.* FROM finishing_kirim_gudang_".getTahunProduksiBefore()." fkg ";
        $sql.=" LEFT JOIN finishing_kirim_gudang_rincian_".getTahunProduksiBefore()." kd ON kd.id_finishing_kirim_gudang=fkg.id_finishing_kirim_gudang ";
        $sql.=" WHERE fkg.kode_po='".$po[1]."' ";
        $data = $this->GlobalModel->QueryManual($sql);
        echo json_encode($data);
    }

    public function add(){
		$data['title']='PO Retur';
		$get=$this->input->get();
		if(isset($get['kode_po'])){
			$kodepo=$get['kode_po'];
		}else{
			$kodepo=null;
		}

		if(isset($get['tahun'])){
			$tahun=$get['tahun'];
		}else{
			$tahun=null;
		}
		$data['kode_po']=$kodepo;
		$data['tahun']=$tahun;
		$sql="SELECT * FROM pogagalproduksi WHERE hapus=0 ";
		if(!empty($tahun)){
			$sql .= " AND tahun='".$tahun."' ";
		}
		if(!empty($kodepo)){
			$sql .= " AND kode_po LIKE '%".$kodepo."%' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=[];
		$data['prods']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['prods'][]=array(
				'no'=>$no++,
				'id'=>$r['id'],
				'tahun'=>$r['tahun'],
				'idpo'=>$r['idpo'],
				'kode_po'=>$r['kode_po'],
				'keterangan'=>$r['keterangan'],
			);
		}
		
        $data['action']=$this->url.'save';
		$data['page']=$this->page.'form';
		$this->load->view($this->layout,$data);
	}


    public function save(){
        $post = $this->input->post();
        $po = explode(',',$post['kode_po']);
        if(!isset($post['prods'])){
            $this->session->set_flashdata('gagal','Data Gagal disimpan. Harap coba lagi nanti');
			redirect($this->url.'add');
        }
        //pre($post);
        $this->db->insert(
            'po_retur',
            array(
                'tanggal'   => $post['tanggal'],
                'idpo'      => $po[0],
                'kodepo'    => $po[1],
                'tanggal'   => $post['tanggal'],
                'keterangan'=> $post['keterangan'],
            )
        );
        $lastId = $this->db->insert_id();

        $prods = $post['prods'];
        $totpcs=0;
        foreach ($prods as $prod) {
            $totpcs+=($prod['rincian_lusin']*12)+$prod['rincian_piece'];
            $data = array(
                'idretur' => $lastId,
                'tanggal'=>$post['tanggal'],
                'size' => $prod['size'],
                'jumlah_dz' => $prod['rincian_lusin'],
                'jumlah_pcs' => $prod['rincian_piece'],
                'keterangan' => $prod['keterangan']
            );
        
            $this->db->insert('po_retur_detail', $data);
        }

        $this->db->update(
            'po_retur',
            array(
                'jumlah_pcs'=>$totpcs,
            ),
            array('id'=>$lastId)
        );

        $this->session->set_flashdata('msg','Data Berhasil disimpan.');
		redirect($this->url.'');
        
    }

	public function poretur_detail($id){
        $data['title'] = 'Detail Retur';
        $data['po_retur'] = $this->db->get_where('po_retur', array('id' => $id))->row_array();
        $data['po_retur_detail'] = $this->db->get_where('po_retur_detail', array('idretur' => $id))->result_array();
    
        // Load view dengan tema AdminLTE
		
        $data['action']=$this->url.'update_data';
        $data['batal']=$this->url.'';
        $data['surat_jalan']=$this->url.'creat_sj';
		$data['page']=$this->page.'detail';
		$this->load->view($this->layout,$data);
	}

    public function update_data()
    {
        $post = $this->input->post();
        $po = explode(',', $post['kode_po']);

        if (!isset($post['prods'])) {
            $this->session->set_flashdata('gagal', 'Data Gagal disimpan. Harap coba lagi nanti');
            redirect($this->url . 'add');
        }

        $returId = $post['retur_id'];

        $this->db->update(
            'po_retur',
            array(
                'tanggal' => $post['tanggal'],
                'idpo' => $po[0],
                'kodepo' => $po[1],
                'tanggal' => $post['tanggal'],
                'keterangan' => $post['keterangan'],
            ),
            array('id' => $returId)
        );

        $this->db->delete('po_retur_detail', array('idretur' => $returId));

        $prods = $post['prods'];
        $totpcs = 0;
        foreach ($prods as $prod) {
            $totpcs += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
            $data = array(
                'idretur' => $returId,
                'tanggal' => $post['tanggal'],
                'size' => $prod['size'],
                'jumlah_dz' => $prod['rincian_lusin'],
                'jumlah_pcs' => $prod['rincian_piece'],
                'keterangan' => $prod['keterangan']
            );

            $this->db->insert('po_retur_detail', $data);
        }

        $this->update_retur_jumlah_pcs($returId, $totpcs);

        $this->session->set_flashdata('msg', 'Data Berhasil disimpan.');
        redirect($this->url . '');
    }

    public function update_retur_jumlah_pcs($returId, $jumlah_pcs)
    {
        $this->db->update(
            'po_retur',
            array('jumlah_pcs' => $jumlah_pcs),
            array('id' => $returId)
        );

        return ($this->db->affected_rows() > 0);
    }

    public function update($id)
    {
        $post = $this->input->post();
        $prods = $post['prods'];

        // Update data PO Retur
        $data = array(
            'tanggal' => $post['tanggal'],
            'keterangan' => $post['keterangan']
        );

        $this->db->update('po_retur', $data, array('id' => $id));

        // Update data PO Retur Detail
        $totpcs = 0;
        foreach ($prods as $key => $prod) {
            $totpcs += ($prod['rincian_lusin'] * 12) + $prod['rincian_piece'];
            $data = array(
                'size' => $prod['size'],
                'jumlah_dz' => $prod['rincian_lusin'],
                'jumlah_pcs' => $prod['rincian_piece'],
                'keterangan' => $prod['keterangan']
            );

            $this->db->update('po_retur_detail', $data, array('id' => $prod['id']));
        }
        $this->update_retur_jumlah_pcs($id, $totpcs);

        $this->session->set_flashdata('msg', 'Data Berhasil diperbarui.');
        redirect($this->url . '');
    }

    function generate_kirim_gudang(){
        $post = $this->input->post();
        $idpo=Getpo_produksi_tahun($post['kodepo']);
        //pre($post['prods']);
        // exit;
        // pembuatan nomor faktur
        $dataKirim = array(
            'finishing_kirim_gudang_faktur'	=>	$post['faktur'],
            'tanggal_kirim'	=> $post['tanggal']
        );
        $this->GlobalModel->insertData('finishing_kirim_gudang_faktur',$dataKirim);

        // create sj
        $totalpcs=0;
        foreach ($post['prods'] as $rincian) {
            $totalpcs+=(($rincian['rincian_lusin']*12)+$rincian['rincian_piece']);
        }
                        
						$dataInsert = array(
							'idpo'				=> $idpo['id_produksi_po'],
							'nofaktur'			=> 	$post['faktur'],
							'nama_penerima'		=>  'Gudang Forboys',
							'tujuan'			=>	$post['tujuanItem'],
							'artikel_po'			=>	$idpo['kode_artikel'], 
							'kode_po'			=> 	$idpo['kode_po'],
							'harga_satuan'		=> 	$idpo['harga_satuan'],
							'jumlah_harga_piece'	=> 	$totalpcs* $idpo['harga_satuan'],
							'jumlah_piece_diterima'	=> $totalpcs,
							'keterangan'		=>	$idpo['jenis_po'],
							'created_date'		=> date('Y-m-d'),
							'tanggal_kirim'		=>	$post['tanggal'],
							'tahunpo'			=> getTahunProduksiBefore(),
						);

                        $this->GlobalModel->insertData('finishing_kirim_gudang',$dataInsert);
						$lastId = $this->db->insert_id();

                        foreach ($post['prods'] as $rincian) {
							$dataRincian = array(
								'id_finishing_kirim_gudang'		=> $lastId,
								'rincian_size'		=> $rincian['size'], 
								'rincian_lusin'		=> $rincian['rincian_lusin'], 
								'rincian_piece'		=> $rincian['rincian_piece'],
								'created_date'		=> date('Y-m-d')
							);
							$this->GlobalModel->insertData('finishing_kirim_gudang_rincian',$dataRincian);
						}

                        echo $lastId;
    }


}