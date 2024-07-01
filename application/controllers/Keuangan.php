<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	public function pengajuantransfer(){
		$data=[];
		$data['title']='Ajuan Transfer';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$sql="SELECT * FROM ajuan_transfer WHERE hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id desc ";
		$results = $this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $result){
			$data['products'][]=array(
				'no'	=>$no++,
				'tanggal'	=>date("d-m-Y",strtotime($result['tanggal'])),
				'pembayaran'=>$result['pembayaran'],
				'metode'=>$result['metode'],
				'a_nama'=>$result['a_nama'],
				'no_rek'=> $result['no_rek'],
				'tgl_nota'=> $result['tgl_nota'],
				'nominal'	=>($result['nominal']),
				'tglbayar'	=>$result['tglbayar']==null?'':date("d-m-Y",strtotime($result['tglbayar'])),
				'status_pemb'=>$result['status_pemb']==1?'Sudah dibayar':'Belum Dibayar',
				'keterangan'	=>$result['keterangan'],
				'status'           => $result['status_pemb'],
				'hapus'=>BASEURL.'Keuangan/hapusbayar/'.$result['id'],
			);
		}
		$data['tambah']=BASEURL.'Keuangan/ajuantransfer_add';
		$data['bayar']=BASEURL.'Keuangan/bayarajuan';
		$url='';
		if(!empty($tanggal1)){
			$url.="&tanggal1=".$tanggal1;
		}
		if(!empty($tanggal2)){
			$url.="&tanggal2=".$tanggal2;
		}
		$data['excel']=BASEURL.'Keuangan/pengajuantransfer?&excel=true'.$url;
		if(isset($get['excel'])){
			$this->load->view($this->page.'keuangan/ajuan_transfer_excel',$data);	
		}else{
			$data['page']=$this->page.'keuangan/ajuan_transfer';
			$this->load->view($this->layout,$data);	
		}
		
	}

	public function ajuantransfer_add(){
		$data=[];
		$data['title']='Ajuan Transfer';
		$data['batal']=BASEURL.'Keuangan/pengajuantransfer';
		$data['action']=BASEURL.'Keuangan/ajuantransfer_save';
		$data['page']=$this->page.'keuangan/ajuan_transfer_add';
		$this->load->view($this->layout,$data);
	}

	public function ajuantransfer_save(){
		$data=$this->input->post();
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert =array(
					'tanggal' =>$p['tanggal'],
					'pembayaran'	=>$p['pembayaran'],
					'metode'	=>$p['metode'],
					'a_nama'	=>$p['a_nama'],
					'no_rek'	=>$p['no_rek'],
					'tgl_nota'	=>$p['tgl_note'],
					'nominal'	=>$p['nominal'],
					'tglbayar'	=>null,
					'status_pemb'	=>0,
					'keterangan'	=>$p['keterangan'],
					'hapus'	=>0
				);
				$this->db->insert('ajuan_transfer',$insert);
			}
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Keuangan/pengajuantransfer');	
		}
	}

	public function bayarajuan(){
		$data=[];
		$data['title']='Bayar Ajuan Transfer';
		$data['batal']=BASEURL.'Keuangan/pengajuantransfer';
		$data['action']=BASEURL.'Keuangan/bayarajuan_save';
		$data['k']=$this->GlobalModel->getData('ajuan_transfer',array('hapus'=>0,'status_pemb'=>0));
		$data['page']=$this->page.'keuangan/ajuan_transfer_bayar';
		$this->load->view($this->layout,$data);
	}

	public function bayarajuan_save(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert =array(
					'tglbayar'	=>$p['tglbayar'],
					'status_pemb'	=>1,
					'hapus'	=>0
				);
				$this->db->update('ajuan_transfer',$insert,array('id'=>$p['id']));
			}
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Keuangan/pengajuantransfer');	
		}
	}

	public function hapusbayar($id){
		$insert =array(
			'hapus'	=>1
		);
		$this->db->update('ajuan_transfer',$insert,array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Keuangan/pengajuantransfer');	
	}

	public function searchbayar(){
		$get=$this->input->get();
		$sql="SELECT * FROM ajuan_transfer WHERE hapus=0 ";
		$sql.= "AND id='".$get['id']."' ";
		$result=$this->GlobalModel->QueryManualRow($sql);
		echo json_encode($result);
	}

	public function getpinjaman(){
		$get=$this->input->get();
		$pinjaman=[];
		$pinjaman=$this->GlobalModel->getData('pinjaman_karyawan',array('hapus'=>0,'status <>'=>3,'idkaryawan'=>$get['idkaryawan']));
		if(!empty($pinjaman)){
			echo "<option value=''>Pilih</option>";
		}
		foreach($pinjaman as $p){
			echo '<option value="'.$p['id'].'"> Tgl '.date('d/m/Y',strtotime($p['tanggal'])).' Sisa Rp.'.number_format($p['totalpinjaman']-$p['totalpotongan']).' ('.$p['keterangan'].') </option>';
		}
	}
	public function potonganpinjaman(){
		$data=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Potongan Pinjaman karyawan';
		$data['n']=1;
		$data['action']=BASEURL.'Keuangan/potonganpinjamansave';;
		$data['products']=array();
		$products=$this->GlobalModel->getData('potongan_pinjaman_karyawan',array('hapus'=>0));
		foreach($products as $p){
			$hari=date('l',strtotime($p['tanggal']));
			$karyawan=$this->GlobalModel->getDataRow('karyawan',array('id'=>$p['idkaryawan']));
			$data['products'][]=array(
				'tanggal'=>hari($hari).', '.date('d-m-Y',strtotime($p['tanggal'])),
				'nama'=>strtolower($karyawan['nama']),
				//'totalpinjaman'=>number_format($p['totalpinjaman']),
				'totalpotongan'=>number_format($p['totalpotongan']),
				'sisa'=>number_format(($p['totalpotongan'])),
				'keterangan'=>$p['keterangan'],
				'status'=>$p['status'],
				'edit'=>BASEURL.'Keuangan/pinjamankaryawanedit/'.$p['id'],
				'rincian'=>BASEURL.'Keuangan/rincianpinjaman/'.$p['id'],
			);
		}
		$data['karyawan']=karyawan();
		$data['page']=$this->page.'keuangan/potongan_list';
		$this->load->view($this->page.'main',$data);
	}
	public function potonganpinjamansave(){
		$data=$this->input->post();
		//pre($data);
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'idkaryawan'=>$data['idkaryawan'],
			'idpinjaman'=>$data['listpinjaman'],
			'totalpotongan'=>$data['totalpotongan'],
			'keterangan'=>$data['keterangan'],
			'hapus'=>0,
		);
		$this->db->query("UPDATE pinjaman_karyawan set totalpotongan=totalpotongan+'".$data['totalpotongan']."' WHERE id='".$data['listpinjaman']."' ");
		$cek=$this->GlobalModel->getDataRow('pinjaman_karyawan',array('id'=>$data['listpinjaman']));
		if($cek['totalpinjaman']==$cek['totalpotongan']){
			$status=3;
		}else{
			$status=2;
		}
		$this->db->query("UPDATE pinjaman_karyawan set status='".$status."' WHERE id='".$data['listpinjaman']."' ");
		$this->db->insert('potongan_pinjaman_karyawan',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Keuangan/potonganpinjaman');	
	}

	public function uangmakansecurity(){
		$data=[];
		$data['title']='Uang makan security';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-30 days"));
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['products']=[];
		$sql="SELECT * FROM um_security WHERE hapus=0 ";
		if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=' ORDER BY id desc';
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no++,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'periode'=>$r['periode'],
				'tempat'=>$r['tempat'] == 3 ? 'Cipadu':'Rumah & Finishing',
				'total' => $this->sumKeuSecurity($r['id']),
				'detail'=>BASEURL.'Keuangan/uangmakansecuritydetail/'.$r['id'],
				'excel'=>BASEURL.'Keuangan/uangmakansecuritydetailexcel/'.$r['tanggal'],
				'edit'=>BASEURL.'Keuangan/uangmakansecurity_edit/'.$r['id'],
			);
		}
		$data['tambah']=BASEURL.'Keuangan/uangmakansecurityadd';
		$data['page']=$this->page.'keuangan/um_security';
		$this->load->view($this->page.'main',$data);
	}

	function uangmakansecurity_edit($id){
		$data=[];
		$data['title']='Edit Uang makan security';
		$data['prods']=$this->GlobalModel->getDataRow('um_security',array('id'=>$id));
		$details=[];
		$details=$this->GlobalModel->getData('um_security_detail',array('idum'=>$id));
		$total=0;
		$no=1;
		$data['details']=[];
		foreach($details as $d){
			$nama=$this->GlobalModel->getDataRow('karyawan',array('id'=>$d['nama']));
			$total+=($d['nominal']);
			$data['details'][]=array(
				'no'=>$no++,
				'id'=>$d['id'],
				'nama'=>$nama['nama'],
				'nominal'=>($d['nominal']),
				'keterangan'=>strtolower($d['keterangan']),
			);
		}
		$data['total']=($total);
		$data['batal']=BASEURL.'Keuangan/uangmakansecurity';
		$data['action']=BASEURL.'Keuangan/uangmakansecurity_edit_save';
		$data['edit']=true;
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'keuangan/um_security_excel',$data);
		}else{
			$data['page']=$this->page.'keuangan/um_security_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	function uangmakansecurity_edit_save(){
		$post = $this->input->post();
		foreach($post['prods'] as $p){
			$update = array(
				'nominal'=>$p['nominal'],
				'keterangan'=>$p['keterangan'],
			);
			$this->db->update('um_security_detail',$update,array('id'=>$p['id']));
		}
		//pre($post);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Keuangan/uangmakansecurity');	
	}

	public function uangmakansecuritydetail($id){
		$data=[];
		$data['title']='Detail Uang makan security';
		$data['prods']=$this->GlobalModel->getDataRow('um_security',array('id'=>$id));
		$details=[];
		$details=$this->GlobalModel->getData('um_security_detail',array('idum'=>$id));
		$total=0;
		$no=1;
		$data['details']=[];
		foreach($details as $d){
			$nama=$this->GlobalModel->getDataRow('karyawan',array('id'=>$d['nama']));
			$total+=($d['nominal']);
			$data['details'][]=array(
				'no'=>$no++,
				'nama'=>$nama['nama'],
				'nominal'=>($d['nominal']),
				'keterangan'=>strtolower($d['keterangan']),
			);
		}
		$data['total']=($total);
		$data['batal']=BASEURL.'Keuangan/uangmakansecurity';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'keuangan/um_security_excel',$data);
		}else{
			$data['page']=$this->page.'keuangan/um_security_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function uangmakansecuritydetailexcel($id){
		$data=[];
		$data['title']='Detail Uang makan security';
		$data['prods']=$this->GlobalModel->getData('um_security',array('tanggal'=>$id,'hapus'=>0));
		//pre($data['prods']);
		$idt=[];
		foreach($data['prods'] as $dp){
			$idt[]=$dp['id'];
		}
		$kid=implode($idt, ",");
		$details=[];
		$details=$this->GlobalModel->QueryManual("SELECT * FROM um_security_detail WHERE idum IN($kid) AND hapus=0 ");
		// pre($details);
		$total=0;
		$no=1;
		$data['details']=[];
		foreach($details as $d){
			$nama=$this->GlobalModel->getDataRow('karyawan',array('id'=>$d['nama']));
			$total+=($d['nominal']);
			$data['details'][]=array(
				'no'=>$no++,
				'nama'=>$nama['nama'],
				'nominal'=>($d['nominal']),
				'keterangan'=>strtolower($d['keterangan']),
			);
		}
		$data['total']=($total);
		$data['batal']=BASEURL.'Keuangan/uangmakansecurity';
		$get=$this->input->get();
		$data['periode']=$id;
		$this->load->view($this->page.'keuangan/um_security_excel',$data);
	}

	public function uangmakansecurityadd(){
		$data=[];
		$data['title']='Form Uang makan security';
		$data['page']=$this->page.'keuangan/umsecurity_form';
		$data['action']=BASEURL.'Keuangan/uangmakansecuritysave';
		$data['batal']=BASEURL.'Keuangan/uangmakansecurity';
		// $data['sec']=$this->GlobalModel->getData('karyawan',array('jabatan'=>10,'hapus'=>0));
		$data['sec']=$this->GlobalModel->QueryManual("SELECT * FROM karyawan WHERE hapus=0 AND jabatan IN (10,46) ");
		$this->load->view($this->page.'main',$data);
	}

	public function uangmakansecuritysave(){
		$data=$this->input->post();
		if(isset($data['products'])){
			$insert=array(
				'tanggal' =>$data['tanggal'],
				'periode'=>$data['periode'],
				'tempat'=>$data['tempat'],
				'hapus'=>0
			);
			$this->db->insert('um_security',$insert);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$detail=array(
					'idum'=>$id,
					'nama'=>($p['nama']),
					'nominal'=>$p['nominal'],
					'keterangan'=>strtolower($p['keterangan']),
					'hapus'=>0
				);
				$this->db->insert('um_security_detail',$detail);
			}
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Keuangan/uangmakansecurity');	
		}else{
			$this->session->set_flashdata('msg','Data gagal disimpan');
			redirect(BASEURL.'Keuangan/uangmakansecurityadd');	
		}
		
	}

	function sumKeuSecurity($id){
		$hasil = 0;
		$data = $this->GlobalModel->QueryManualRow("
			SELECT COALESCE(SUM(nominal),0) as nominal FROM um_security_detail 
			WHERE idum='$id'
		");

		if(isset($data['nominal'])){
			return $data['nominal'];
		}else{
			return $hasil;
		}
	}

	public function lemburkaryawan(){
		$data=[];
		$data['title']='Lembur karyawan harian';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['products']=[];
		$data['tambah']=BASEURL.'Keuangan/lemburkaryawanadd';
		if(isset($get['excel'])){
			$sql="SELECT upah,SUM(jml_jam) as jml_jam,idkaryawan,count(tanggal) as hari FROM lembur_harian WHERE hapus=0 ";
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
			$sql.=" GROUP BY idkaryawan";
			$results=$this->GlobalModel->QueryManual($sql);
			$no=1;
			$nama=null;
			foreach ($results as $r) {
				$nama=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$r['idkaryawan']));
				$data['products'][]=array(
					'no'=>$no++,
					'bagian'=>strtolower($nama['bagian']),
					'nama'=>strtolower($nama['nama']),
					'jam'=>$r['jml_jam'],
					'upah'=>($r['upah']),
					'total'=>($r['upah']*$r['jml_jam']),
					'hapus'=>0,
				);
			}
			$this->load->view($this->page.'keuangan/lembuarharian_excel',$data);
		}else{
			$sql="SELECT * FROM lembur_harian WHERE hapus=0";
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
			$sql.=" ORDER BY id desc ";
			$results=$this->GlobalModel->QueryManual($sql);
			$no=1;
			$nama=null;
			foreach ($results as $r) {
				$nama=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$r['idkaryawan']));
				$data['products'][]=array(
					'no'=>$no++,
					'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
					'bagian'=>strtolower($nama['bagian']),
					'nama'=>strtolower($nama['nama']),
					'mulai'=>$r['mulai'],
					'selesai'=>$r['selesai'],
					'jam'=>$r['jml_jam'],
					'upah'=>($r['upah']),
					'total'=>($r['upah']*$r['jml_jam']),
					'hapus'=>0,
				);
			}

			if(isset($get['excelcatatan'])){
				$this->load->view($this->page.'keuangan/lembuarharian_excelcatatan',$data);
			}else{
				$data['page']=$this->page.'keuangan/lembuarharian_list';
				$this->load->view($this->page.'main',$data);
			}
			
		}
	}

	public function lemburkaryawanadd(){
		$data=[];
		$data['title']='Tambah lemburan karyawan ';
		$data['page']=$this->page.'keuangan/lembuarharian_form';
		$data['action']=BASEURL.'Keuangan/lemburkaryawansave';
		$data['batal']=BASEURL.'Keuangan/lemburkaryawan';
		$data['karyawan'] = $this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	public function lemburkaryawansave(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>$data['tanggal'],
					'idkaryawan'=>$p['idkaryawan'],
					'mulai'=>$p['mulai'],
					'selesai'=>$p['selesai'],
					'jml_jam'=>$p['jml_jam'],
					'upah'=>$p['upah'],
					'hapus'=>0,
				);
				$this->db->insert('lembur_harian',$insert);
			}
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Keuangan/lemburkaryawan');
		}else{
			$this->session->set_flashdata('msg','Data Gagal disimpan.Periksa kembali formnya');
			redirect(BASEURL.'Keuangan/lemburkaryawanadd');
		}
	}

	public function pinjamankaryawan(){
		$data=array();
		$data['title']='List Pinjaman';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['n']=1;
		$data['action']=BASEURL.'Keuangan/pinjamansave';;
		$data['products']=array();
		$products=$this->GlobalModel->getData('pinjaman_karyawan',array('hapus'=>0));
		foreach($products as $p){
			$hari=date('l',strtotime($p['tanggal']));
			$karyawan=$this->GlobalModel->getDataRow('karyawan',array('id'=>$p['idkaryawan']));
			$data['products'][]=array(
				'tanggal'=>hari($hari).', '.date('d-m-Y',strtotime($p['tanggal'])),
				'nama'=>strtolower($karyawan['nama']),
				'totalpinjaman'=>number_format($p['totalpinjaman']),
				'totalpotongan'=>number_format($p['totalpotongan']),
				'sisa'=>number_format(($p['totalpinjaman']-$p['totalpotongan'])),
				'keterangan'=>$p['keterangan'],
				'status'=>$p['status'],
				'edit'=>BASEURL.'Keuangan/pinjamankaryawanedit/'.$p['id'],
				'rincian'=>BASEURL.'Keuangan/rincianpinjaman/'.$p['id'],
			);
		}
		$data['karyawan']=karyawan();
		$data['page']=$this->page.'keuangan/pinjaman_list';
		$this->load->view($this->page.'main',$data);
	}

	public function pinjamansave(){
		$data=$this->input->post();
		$insert=array(
			'idkaryawan'=>$data['idkaryawan'],
			'tanggal'=>$data['tanggal'],
			'totalpinjaman'=>$data['totalpinjaman'],
			'totalpotongan'=>0,
			'keterangan'=>$data['keterangan'],
			'status'=>1,
			'hapus'=>0,
		);
		$this->db->insert('pinjaman_karyawan',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Keuangan/pinjamankaryawan');
	}

	public function rincianpinjaman($id){
		$data=array();
		$data['n']=1;
		$data['products']=array();
		$data['cancel']=BASEURL.'Keuangan/pinjamankaryawan';
		$data['products']=$this->db->query("SELECT pk.*, k.nama FROM pinjaman_karyawan pk LEFT JOIN karyawan k ON (k.id=pk.idkaryawan) WHERE pk.id='$id' ")->row_array();
		$data['details']=$this->GlobalModel->getData('potongan_pinjaman_karyawan',array('idpinjaman'=>$id));
		//pre($data['products']);
		$data['page']=$this->page.'keuangan/pinjaman_detail';
		$this->load->view($this->page.'main',$data);
	}

	public function transferan(){
		$data=array();
		$data['title']='List Transferan';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['n']=1;
		$results=[];
		$sql="SELECT * FROM transferan WHERE hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		$sql.=" ORDER BY id desc ";
		$results = $this->GlobalModel->QueryManual($sql);
		$data['products']=$results;
		$data['action']=BASEURL.'Keuangan/transferansave';
		$data['mutasi']=BASEURL.'Keuangan/mutasibank/';
		$data['page']=$this->page.'keuangan/transferan_list';
		$this->load->view($this->page.'main',$data);
	}

	public function transferansave(){
		$data=$this->input->post();
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'nominal'=>$data['nominal'],
			'keterangan'=>$data['keterangan'],
			'bagian'=>$data['bagian'],
			'alokasi'=>$data['alokasi'],
			'hapus'=>0,
		);
		$this->db->insert('transferan',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Keuangan/transferan');
	}

	public function edit_transferan($id){
		$data['title']='Edit Transferan';
		$data['k']=$this->GlobalModel->GetDataRow('transferan',array('id'=>$id));
		$data['action']=BASEURL.'Keuangan/edit_transferansave';
		$data['batal']=BASEURL.'Keuangan/transferan/';
		$data['page']=$this->page.'keuangan/transferan_edit';
		$this->load->view($this->page.'main',$data);
	}

	public function edit_transferansave(){
		$data=$this->input->post();
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'nominal'=>$data['nominal'],
			'keterangan'=>$data['keterangan'],
			'bagian'=>$data['bagian'],
			'hapus'=>0,
		);
		$this->db->update('transferan',$insert,array('id'=>$data['id']));
		$this->session->set_flashdata('msg','Data berhasil diubah');
		redirect(BASEURL.'Keuangan/transferan');
	}

	public function bank(){
		$data=array();
		$data['title']='Operasional';
		$data['n']=1;
		$data['action']=BASEURL.'Keuangan/transaksibanksave';
		$data['mutasi']=BASEURL.'Keuangan/mutasibank/';
		$data['page']=$this->page.'keuangan/bank_list';
		$data['products']=$this->GlobalModel->getData('bank',array('hapus'=>0));
		$data['alokasi']=$this->GlobalModel->QueryManual("SELECT * FROM pengalokasian WHERE hapus=0 AND id IN (17,18,19)");
		$this->load->view('newtheme/page/main',$data);
	}

	public function transaksibanksave(){
		$data=$this->input->post();
		//pre($data);
		$cursaldo=$this->GlobalModel->getDataRow('bank',array('id'=>$data['bank_id']));
		$saldomasuk=0;
		$saldokeluar=0;
		if($data['jenis']==1){
			$saldomasuk=$data['nominal'];
			$saldokeluar=0;
		}else{
			$saldomasuk=0;
			$saldokeluar=$data['nominal'];
		}
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'tgltransaksi'=>date('Y-m-d H:i:s'), // tanggal input
			'bank_id'=>$data['bank_id'],
			'saldoawal'=>$cursaldo['saldo'],
			'saldomasuk'=>$saldomasuk,
			'saldokeluar'=>$saldokeluar,
			'saldo'=>$cursaldo['saldo']+$saldomasuk-$saldokeluar,
			'keterangan'=>$data['keterangan'],
			'referensi'=>0,
			'bagian'=>$data['bagian'],
			'pengalokasian'=>$data['pengalokasian'],
			'hapus'=>0
		);
		$this->db->insert('aruskas',$insert);
		$ref=$this->db->insert_id();
		$this->db->update('aruskas',array('referensi'=>$ref),array('id'=>$ref));
		if($data['jenis']==1){
			$this->db->query("UPDATE bank set saldo=saldo+'".$data['nominal']."' ");
		}else{
			$this->db->query("UPDATE bank set saldo=saldo-'".$data['nominal']."' ");
		}
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Keuangan/bank');
	}

	public function mutasibank($id){
		$data=array();
		$data['title']='Daftar Mutasi ';
		$data['n']=1;
		$data['kembali']=BASEURL.'Keuangan/bank';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("-7 days"));
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
		$sql="SELECT * FROM aruskas WHERE hapus=0 AND bank_id='".$id."'";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		if(!empty($cat)){
			$sql.=" AND bagian='".$cat."' ";
		}
		$sql.=" ORDER BY id ";
		$data['mutasi']=$this->db->query($sql)->result_array();
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cat']=$cat;
		if(isset($get['excel'])){
			$this->load->view($this->page.'keuangan/mutasi_excel',$data);
		}else{
			$data['page']='newtheme/page/keuangan/mutasi';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function kasbonkaryawan(){
		$data=array();
		$data['title']='List Kasbon karyawan';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['n']=1;
		$data['tambah']=BASEURL.'Keuangan/kasbonadd';
		$data['products']=array();
		$sql=" SELECT * FROM kasbon WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->QueryManual($sql);

		$total=0;
		foreach($results as $result){
			$karyawan=$this->GlobalModel->getDataRow('karyawan',array('id'=>$result['idkaryawan']));
			$bagian=$this->GlobalModel->getDataRow('divisi',array('id'=>$result['bagian']));
			$data['products'][]=array(
				'tanggal'=>date('d/m/Y',strtotime($result['tanggal'])),
				'nama'=>$karyawan['nama'],
				'divisi'=>$bagian['nama'],
				'nominal'=>number_format($result['nominal_request'],2),
				'nominal_acc'=>number_format($result['nominal_acc'],2),
				'status'=>$result['status'],
				'detail'=>BASEURL.'Keuangan/kasbondetail/'.$result['tanggal'],
			);
		}
		$data['page']='newtheme/page/keuangan/kasbonlist';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kasbonadd(){
		$data=array();
		$data['n']=1;
		$data['title']='Form Kasbon karyawan';
		$data['action']=BASEURL.'Keuangan/kasbonsave';
		$data['batal']=BASEURL.'Keuangan/kasbonkaryawan';
		$data['karyawan']=karyawan();
		$data['page']='newtheme/page/keuangan/kasbonadd';
		$this->load->view('newtheme/page/main',$data);
	}

	public function kasbonsave(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$acc=array(
				'tanggal'=>$data['tanggal'],
				'dibuat'=>callSessUser('nama_user'),
				'hapus'=>0,
				'status'=>1,
			);
			$this->db->insert('kasbon_acc',$acc);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$insert=array(
					'idacc'=>$id,
					'tanggal'=>$data['tanggal'],
					'idkaryawan'=>$p['idkaryawan'],
					'bagian'=>$p['bagian'],
					'nominal_request'=>$p['jumlah'],
					'nominal_acc'=>$p['jumlah'],
					'status'=>1,
					'hapus'=>0,
				);
				$this->db->insert('kasbon',$insert);
			}
			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Keuangan/kasbonkaryawan');
		}
	}

	public function kasbondetail($id){
		$data=array();
		$data['title']='Persetujuan Kasbon Karyawan Forboys';
		$data['n']=1;
		$data['i']=0;
		$data['kembali']=BASEURL.'Keuangan/kasbonkaryawan';
		$data['action']=BASEURL.'Keuangan/kasbonkaryawan';
		$data['detail']=array();
		$data['acc']=null;
		$data['acc']=$this->GlobalModel->getDataRow('kasbon_acc',array('tanggal'=>$id,'hapus'=>0));
		// $results=$this->GlobalModel->getData('kasbon',array('tanggal'=>$id,'hapus'=>0));
		$results = $this->GlobalModel->QueryManual(
			"SELECT a.* FROM kasbon a JOIN karyawan b ON b.id=a.idkaryawan WHERE tanggal='".$id."' AND a.hapus=0 ORDER BY b.nama ASC "
		);
		$total=0;
		$ajuan=0;
		foreach($results as $result){
			$ajuan+=($result['nominal_request']);
			$total+=($result['nominal_acc']);
			$karyawan=$this->GlobalModel->getDataRow('karyawan',array('id'=>$result['idkaryawan']));
			$bagian=$this->GlobalModel->getDataRow('divisi',array('id'=>$result['bagian']));
			$data['detail'][]=array(
				'id'=>$result['id'],
				'tanggal'=>date('d/m/Y',strtotime($result['tanggal'])),
				'nama'=>$karyawan['nama'],
				'divisi'=>$bagian['nama'],
				'nominal'=>$result['nominal_request'],
				'nominal_acc'=>$result['nominal_acc'],
				'status'=>$result['status'],
				'terbilang' => terbilang($result['nominal_request'])
			);
		}
		$data['total']=($total);
		$data['ajuan']=($ajuan);
		$get=$this->input->get();
		$data['excel']=BASEURL.'Keuangan/kasbondetail/'.$id.'?&excel=true';
		$data['pdf']=BASEURL.'Keuangan/kasbondetail/'.$id.'?&pdf=true';
		if(isset($get['excel'])){
			$this->load->view('newtheme/page/keuangan/kasbondetail_excel',$data);
		}else{
			if(isset($get['pdf'])){
				$get = $this->input->get();
				$html =  $this->load->view('newtheme/page/keuangan/kasbondetail_pdf',$data,true);
	
				$this->load->library('pdfgenerator');
				
				// title dari pdf
				$this->data['title_pdf'] = 'Surat Jalan Kirim Jahit';
				
				// filename dari pdf ketika didownload
				$file_pdf = 'Surat_Jalan_Kirim_Jahit_'.time();
				// setting paper
				$paper = 'A4';
				// $paper = array(0,0,900,1250);
				//orientasi paper potrait / landscape
				$orientation = "potrait";
				
	
				
				// run dompdf
				$this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
			}else{
				$data['page']='newtheme/page/keuangan/kasbondetail';
				$this->load->view('newtheme/page/main',$data);
			}
			
		}
	}

}