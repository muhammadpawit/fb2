<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->load->model('ReportModel');
	}

	public function sablon(){
		$data=array();
		$data['title']='Pembayaran CMT Sablon';
		$data['tambah']=BASEURL.'Pembayaran/sablon_add';
		$data['products']=array();
		$user=user();
		$menghapus=0;
		if(isset($user['id_user'])){
			$menghapus=akses($user['id_user'],2);
		}
		$data['menghapus']=akseshapus();
		$get=$this->input->get();
		$results=array();
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

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
		$sql="SELECT * FROM pembayaran_sablon WHERE hapus=0 ";
		$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		if(!empty($cmt)){
			$sql.=" AND idcmt='".$cmt."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=array();
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $result){
			$cmt=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$result['id'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'periode'=>strtolower($result['periode']),
				'nama'=>strtolower($cmt['cmt_name']),
				'total'=>number_format($result['total']),
				'potongan_bangke'=>number_format($result['potongan_bangke']),
				'biaya_transport'=>number_format($result['biaya_transport']),
				'keterangan'=>strtolower($result['keterangan']),
				'detail'=>BASEURL.'Pembayaran/cmtjahitdetail/'.$result['id'],
				'hapus'=>BASEURL.'Pembayaran/cmtjahithapus/'.$result['id'],
			);
		}
		$data['page']=$this->page.'pembayaran/sablon_list';
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	public function sablon_add(){
		$data=array();
		$data['title']='Pembayaran CMT Sablon';
		$data['action']=BASEURL.'Pembayaran/sablon_save';
		$data['products']=array();
		$user=user();
		$menghapus=0;
		if(isset($user['id_user'])){
			$menghapus=akses($user['id_user'],2);
		}
		$data['menghapus']=akseshapus();
		$get=$this->input->get();
		$results=array();
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

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=0;
		}
		$sql="SELECT * FROM kelolapo_kirim_setor WHERE progress='SETOR' AND kategori_cmt='SABLON' ";
		$sql.=" AND id_master_cmt='".$cmt."' AND DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and hapus=0";
		$results=array();
		$data['pendapatan']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$job=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$r['id_master_cmt_job']));
			$data['pendapatan'][]=array(
				'no'=>$no++,
				'namapo'=>	$r['kode_po'],
				'dz'=>	($r['qty_tot_pcs']/12),
				'pcs'=>	$r['qty_tot_pcs'],
				'harga'=>($r['cmt_job_price']),
				'total'=>(round(($r['qty_tot_pcs']/12)*$r['cmt_job_price'])),
				'ket'=>$job['nama_job'],
			);
			
		}

		// pengeluaran
		$data['pengeluaran']=[];
		$sqlp="SELECT * FROM pengeluaran_sablon WHERE hapus=0 ";
		$sqlp.=" AND idcmt='".$cmt."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and hapus=0";
		$res=$this->GlobalModel->querymanual($sqlp);
		$p=1;
		foreach($res as $r){
			$data['pengeluaran'][]=array(
				'no'=>$p++,
				'belanjacat'=>($r['belanjacat']),
				'upahtukang_harian'=>($r['upahtukang_harian']),
				'upahtukang_borongan'=>($r['upahtukang_borongan']),
				'biayalain'=>($r['biayalain']),
				'tokenlistrik'=>($r['tokenlistrik']),
				'total'=>($r['total']),
			);
		}
		$sewa=0;
		$sqlsewa="SELECT keluar FROM sablon_sewarumah_detail swd JOIN sablon_sewarumah sw ON(sw.id=swd.idsewa) WHERE DATE(swd.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and swd.hapus=0";
		$ds=$this->GlobalModel->QueryManualRow($sqlsewa);
		if(!empty($ds)){
			$sewa=$ds['keluar'];
		}
		$data['sewa']=$sewa;
		$data['page']=$this->page.'pembayaran/sablon_add';
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'SABLON'));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	public function loadk(){
		$output=[];
		$get=$this->input->get();
		$sql="SELECT * FROM kelolapo_kirim_setor WHERE progress='SETOR' AND kategori_cmt='SABLON' ";
		$sql.=" AND id_master_cmt='".$get['cmt']."' AND DATE(create_date) BETWEEN '".$get['tanggal1']."' AND '".$get['tanggal2']."' and hapus=0";
		$results=$this->GlobalModel->querymanual($sql);
		$no=1;
		foreach($results as $r){
			$job=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$r['id_master_cmt_job']));
			$output['data'][]=array( 
					$no++,
					$r['kode_po'],
					number_format($r['qty_tot_pcs']/12,2),
					$r['qty_tot_pcs'],
					number_format($r['cmt_job_price']),
					number_format(round(($r['qty_tot_pcs']/12)*$r['cmt_job_price'])),
					$job['nama_job'],
				);
		}
							
		echo json_encode($output);
	}

	public function pengeluaransablon(){
		$output=[];
		$get=$this->input->get();
		$sql="SELECT * FROM pengeluaran_sablon WHERE hapus=0 ";
		$sql.=" AND idcmt='".$get['cmt']."' AND DATE(tanggal) BETWEEN '".$get['tanggal1']."' AND '".$get['tanggal2']."' and hapus=0";
		$results=$this->GlobalModel->querymanual($sql);
		$no=1;
		if(!empty($results)){
			foreach($results as $r){
			
			if(!empty($results)){
				$output['data'][]=array( 
					$no++,
					$r['belanjacat'],
					number_format($r['upahtukang_harian']),
					number_format($r['upahtukang_borongan']),
					number_format($r['biayalain']),
					number_format($r['tokenlistrik']),
					number_format($r['total']),
				);
			}else{
				$output['data'][]=array( 
					null,
					null,
					null,
					null,
					null,
					null,
					null,
				);		

			}
			
		}
		}else{
			$output['data'][]=array( 
					null,
					null,
					null,
					null,
					null,
					null,
					null,
				);		
		}
							
		echo json_encode($output);
	}

	public function sablon_save(){
		$data=$this->input->post();
		pre($data);
	}



	public function timpotong(){
		$data=array();
		$data['title']='Pembayaran Tim Potong';
		$data['tambah']=BASEURL.'Pembayaran/cmtjahittambah';
		$data['products']=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['products']=[];
		$results=[];
		$sql="SELECT * FROM gaji_timpotong WHERE hapus=0 ";
		if(empty($cmt)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}else{
			$sql.=" AND timpotong='".$cmt."' ";
		}
		$sql.=" ORDER BY id DESC LIMIT 30";
		$results = $this->GlobalModel->QueryManual($sql);
		$no=1;
		$nama=null;
		foreach($results as $r){
			$nama=$this->GlobalModel->getdataRow('timpotong',array('id'=>$r['timpotong']));
			$data['products'][]=array(
				'no'=>$no,
				'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
				'periode'=>strtolower($r['periode']),
				'nama'=>strtolower($nama['nama']),
				'total'=>number_format($r['total']),
				'saving'=>number_format($r['saving']),
				'nominal'=>number_format($r['nominal']),
				'keterangan'=>strtolower($r['keterangan']),
				'detail'=>BASEURL.'Pembayaran/timpotongdetail/'.$r['id'],
			);
			$no++;
		}
		$data['tambah']=BASEURL.'Pembayaran/timpotongadd';
		$data['timpotong']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));
		$data['page']=$this->page.'gaji/timpotong_list';
		$this->load->view($this->page.'main',$data);
	}

	public function timpotongdetail($id){
		$data=[];
		$data['title']='Tambah Pembayaran Tim Potong';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}

		if(isset($get['tim'])){
			$tim=$get['tim'];
		}else{
			$tim=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tim']=$tim;
		$data['cmtf']=$cmt;
		$data['tp']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));

		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'tim'=>$tim,
		);
		$data['products']=array();
		//$results=$this->ReportModel->potongan($filter);
		$data['n']=1;
		$timpotong=null;
		$totaldz=0;
		$totalpcs=0;
		$roll=0;
		$rolv=0;
		$no=1;
		$harga=0;
		$total=0;
		$saving=0;
		$nominal=0;
		$data['prods']=$this->GlobalModel->getDataRow('gaji_timpotong',array('id'=>$id));
		$data['timnya']=$this->GlobalModel->getDataRow('timpotong',array('id'=>$data['prods']['timpotong']));
		$results=$this->GlobalModel->getData('gaji_timpotong_detail',array('idgaji'=>$id));
		$bukupotongan=null;
		$jenis=null;
		foreach($results as $r){
				$timpotong=$this->GlobalModel->getDataRow('timpotong',array('id'=>$data['prods']['timpotong']));
				$bukupotongan=$this->GlobalModel->getDataRow('konveksi_buku_potongan',array('kode_po'=>$r['kode_po']));
				$jenis=$this->GlobalModel->QueryManualRow("SELECT idjenis FROM master_jenis_po mjp JOIN produksi_po p ON(p.nama_po=mjp.nama_jenis_po) WHERE kode_po='".$r['kode_po']."' ");
				$data['products'][]=array(
					'no'=>$no,
					'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
					'kode_po'=>$r['kode_po'],
					'jenis'=>($jenis['idjenis']==1)?'Kemeja':($jenis['idjenis']==2?'Kaos':'Celana'),
					'size'=>$bukupotongan['size_potongan'],
					'timpotong'=>$timpotong==null?'':$timpotong['nama'],
					'lusin'=>$r['jml_dz'],
					'pcs'=>$r['jml_pcs'],
					'harga'=>round($r['harga']),
					'total'=>round($r['harga']*$r['jml_pcs']),
					'harga'=>round($r['harga']),
				);
			$total+=($r['harga']*$r['jml_pcs']);
			$no++;
		}
		$saving=0.05*$total;
		$data['total']=number_format($total);
		$data['saving']=number_format($saving);
		$data['nominal']=number_format($total-$saving);
		$data['totals']=($total);
		$data['savings']=($saving);
		$data['nominals']=($total-$saving);
		$data['action']=BASEURL.'Pembayaran/gajitimpotongsave';
		$data['batal']=BASEURL.'Pembayaran/timpotong';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/timpotong_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/timpotong_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function timpotongadd(){
		$data=[];
		$data['title']='Tambah Pembayaran Tim Potong';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d');
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}

		if(isset($get['tim'])){
			$tim=$get['tim'];
		}else{
			$tim=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tim']=$tim;
		$data['cmtf']=$cmt;
		$data['tp']=$this->GlobalModel->getData('timpotong',array('hapus'=>0));

		$filter=array(
			'tanggal1'=>$tanggal1,
			'tanggal2'=>$tanggal2,
			'tim'=>$tim,
		);
		$data['products']=array();
		$results=$this->ReportModel->potongan($filter);
		$data['n']=1;
		$timpotong=null;
		$totaldz=0;
		$totalpcs=0;
		$roll=0;
		$rolv=0;
		$no=1;
		$harga=0;
		$total=0;
		$saving=0;
		$nominal=0;
		foreach($results as $r){
			$harga=$this->GlobalModel->getDataRow('master_harga_potongan',array('hapus'=>0,'nama_jenis_po'=>substr($r['kode_po'], 0,3)));
			$timpotong=$this->GlobalModel->getDataRow('timpotong',array('id'=>$r['tim_potong_potongan']));
			$roll=$this->ReportModel->getsumroll($r['kode_po'],'UTAMA');
			$rolv=$this->ReportModel->getsumroll($r['kode_po'],'CELANA');
			$totaldz+=($r['hasil_lusinan_potongan']);
			$totalpcs+=($r['hasil_pieces_potongan']);
			if(!empty($tim)){
				$data['products'][]=array(
					'no'=>$no,
					'tanggal'=>date('d-m-Y',strtotime($r['created_date'])),
					'kode_po'=>$r['kode_po'],
					'timpotong'=>$timpotong==null?$r['tim_potong_potongan']:$timpotong['nama'],
					'panjang_gelaran_potongan_utama'=>$r['panjang_gelaran_potongan_utama'],
					'pemakaian_bahan_utama'=>$r['pemakaian_bahan_utama'],
					'jumlah_pemakaian_bahan_variasi'=>$r['jumlah_pemakaian_bahan_variasi'],
					'size_potongan'=>$r['size_potongan'],
					'lusin'=>$r['hasil_lusinan_potongan'],
					'pcs'=>$r['hasil_pieces_potongan'],
					'roll_utama'=>$roll->roll,
					'roll_variasi'=>$rolv->roll,
					'harga'=>number_format($harga['harga_potongan']),
					'total'=>number_format($harga['harga_potongan']*$r['hasil_pieces_potongan']),
					'harga'=>number_format($harga['harga_potongan']),
					'total'=>number_format($harga['harga_potongan']*$r['hasil_pieces_potongan']),
					'price'=>($harga['harga_potongan']),
					'totals'=>($harga['harga_potongan']*$r['hasil_pieces_potongan']),
				);
				$total+=($harga['harga_potongan']*$r['hasil_pieces_potongan']);
			}
			$no++;
		}
		$saving=0.05*$total;
		$data['total']=number_format($total);
		$data['saving']=number_format($saving);
		$data['nominal']=number_format($total-$saving);
		$data['totals']=($total);
		$data['savings']=($saving);
		$data['nominals']=($total-$saving);
		$data['action']=BASEURL.'Pembayaran/gajitimpotongsave';
		$data['batal']=BASEURL.'Pembayaran/timpotong';
		$data['page']=$this->page.'gaji/timpotong_form';
		$this->load->view($this->page.'main',$data);
	}

	public function gajitimpotongsave(){
		$data=$this->input->post();
		//pre($data);
		if(isset($data['products'])){
			$insert=array(
				'tanggal'=>date('Y-m-d'),
				'periode'=>$data['periode'],
				'timpotong'=>$data['tim'],
				'total'=>$data['total'],
				'saving'=>$data['saving'],
				'nominal'=>$data['nominal'],
				'keterangan'=>'Gaji tim potong periode '.$data['periode'],
				'hapus'=>0,
			);
			$this->db->insert('gaji_timpotong',$insert);
			$id=$this->db->insert_id();
			foreach($data['products'] as $p){
				$detail=array(
					'idgaji'=>$id,
					'tanggal'=>date('Y-m-d',strtotime($p['tanggal'])),
					'kode_po'=>$p['kode_po'],
					'jml_dz'=>$p['lusin'],
					'jml_pcs'=>$p['pcs'],
					'harga'=>$p['harga'],
					'total'=>($p['total']),
					'keterangan'=>null,
					'hapus'=>0
				);
				$this->db->insert('gaji_timpotong_detail',$detail);
			}
			$this->session->set_flashdata('msg','Data berhasil ditambah');
			redirect(BASEURL.'Pembayaran/timpotong');
		}else{
			$this->session->set_flashdata('msg','Data gagal ditambah');
			redirect(BASEURL.'Pembayaran/timpotongadd');
		}
	}

	public function cmtjahit(){
		$data=array();
		$data['title']='Pembayaran CMT Jahit';
		$data['tambah']=BASEURL.'Pembayaran/cmtjahittambah';
		$data['products']=array();
		$user=user();
		$menghapus=0;
		if(isset($user['id_user'])){
			$menghapus=akses($user['id_user'],2);
		}
		$data['menghapus']=akseshapus();
		$get=$this->input->get();
		$results=array();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			//$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
			$tanggal1=null;
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=null;
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}
		$sql="SELECT * FROM pembayaran_cmt WHERE hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";	
		}
		
		if(!empty($cmt)){
			$sql.=" AND idcmt='".$cmt."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=array();
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$jmlsetor=0;
		$jmlkirim=0;
		foreach($results as $result){
			$jmlkirim=$this->GlobalModel->QueryManualRow("SELECT SUM(jk.jumlah_pcs) as total FROM kirimcmt_detail jk JOIN pembayaran_cmt_detail pcd ON(pcd.kode_po=jk.kode_po) WHERE idpembayaran='".$result['id']."' and jk.hapus=0 ");
			$jmlsetor=$this->GlobalModel->QueryManualRow("SELECT SUM(jumlah_pcs) as total FROM pembayaran_cmt_detail WHERE idpembayaran='".$result['id']."' ");
			$cmt=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$result['id'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'periode'=>strtolower($result['periode']),
				'nama'=>strtolower($cmt['cmt_name']),
				'total'=>number_format($result['total']),
				'potongan_bangke'=>number_format($result['potongan_bangke']),
				'biaya_transport'=>number_format($result['biaya_transport']),
				'keterangan'=>strtolower($result['keterangan']),
				'detail'=>BASEURL.'Pembayaran/cmtjahitdetail/'.$result['id'],
				'hapus'=>BASEURL.'Pembayaran/cmtjahithapus/'.$result['id'],
				'totals'=>($result['total']),
				'an'=>$cmt['an'],
				'norek'=>$cmt['norek'],
				'bank'=>$cmt['bank'],
				'jmlkirim'=>$jmlkirim['total'],
				'jmlsetor'=>$jmlsetor['total'],
			);
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_list_excel',$data);
		}else{
			$data['page']=$this->page.'pembayaran/cmtjahit_list';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function cmtjahitdetail($id){
		$data=array();
		$data['title']='Pembayaran Upah Jahit';
		$data['update']=BASEURL.'Pembayaran/cmtjahit_update';
		$data['detail']=$this->GlobalModel->getdataRow('pembayaran_cmt',array('id'=>$id));
		$products=$this->GlobalModel->getData('pembayaran_cmt_detail',array('idpembayaran'=>$id));
		foreach($products as $p){
			$kirim=$this->GlobalModel->QueryManualRow("SELECT kcd.jumlah_pcs FROM kirimcmt_detail kcd JOIN kirimcmt k ON(k.id=kcd.idkirim) WHERE kcd.kode_po='".$p['kode_po']."' AND k.idcmt='".$data['detail']['idcmt']."' ");
			$data['products'][]=array(
				'id'=>$p['id'],
				'kode_po'=>$p['kode_po'],
				'jumlah_po_dz'=>round($kirim['jumlah_pcs']/12),
				'jumlah_po_pcs'=>round($kirim['jumlah_pcs']),
				'jumlah_dz'=>$p['jumlah_dz'],
				'jumlah_pcs'=>$p['jumlah_pcs'],
				'harga'=>$p['harga'],
				'potpertama'	=>$p['potpertama'],
				'total'=>$p['total'],
				'keterangan'=>$p['keterangan'],
			);
		}
		$data['bangke']=$this->GlobalModel->getData('potongan_bangke',array('idpembayaran'=>$id));
		$data['kembalianbangke']=$this->GlobalModel->getData('pengembalian_bangke',array('idpembayaran'=>$id));
		$cmt=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$data['detail']['idcmt']));
		$data['harga']=$this->GlobalModel->getdata('daftarharga_cmt',array('hapus'=>0,'idcmt'=>$data['detail']['idcmt']));
		//pre($data['harga']);
		$data['namacmt']=$cmt['cmt_name'];
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_excel',$data);
		}else{
			$data['page']=$this->page.'pembayaran/cmtjahit_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function cmtjahittambah(){
		$data=array();
		$data['title']='Form Pembayaran CMT Jahit';
		$data['action']=BASEURL.'Pembayaran/cmtjahitsave';
		$data['page']=$this->page.'pembayaran/cmtjahit_form';
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$this->load->view($this->page.'main',$data);
	}

	public function caripembayaran(){
		$get = $this->input->get();
		$sql="SELECT pc.kode_po,pc.idpembayaran,SUM(pc.total) as total FROM pembayaran_cmt_detail pc JOIN pembayaran_cmt p ON(p.id=pc.idpembayaran) WHERE p.hapus=0 AND p.idcmt='".$get['cmt']."' ";
		if(isset($get['po'])){
			$sql.=" AND pc.kode_po LIKE '%".$get['po']."%'";
		}
		$sql.=" GROUP BY pc.kode_po";
		$results=$this->GlobalModel->QueryManual($sql);
		$json=[];
		foreach($results as $r){
			$json[] = array(
				'id' => round($r['total']).','.$r['idpembayaran'].','.$r['kode_po'],
				'text' =>$r['kode_po'].' '.round($r['total']),
			);
		}
		echo json_encode($json);
	}

	public function cmtjahitsave(){
		$data=$this->input->post();
		$totalbayar=0;
		$totalbangke=0;
		$totalpengembalianbangke=0;
		$totaldz=0;
		$btransport=0;
		//echo 'Sedang dalam perbaikan.. Mohon tunggu beberapa saat lagi';exit;
		//pre($data);
		if(isset($data['cmt'])){
			if(isset($data['products'])){
				foreach($data['products'] as $p){
					$potptm=explode(",",$p['potpertama']);
					$totalbayar+=($p['total']-$potptm[0]);
					if($p['trans']==1){
						$totaldz+=round($p['jumlah_pcs']/12);
					}
				}
				$sbt="SELECT * FROM harga_transport WHERE dz1<='".$totaldz."' AND '".$totaldz."' <=dz2 ";
				if($data['metode']==1){
					$bt=$this->GlobalModel->QueryManualRow($sbt);
					if(!empty($bt)){
						$btransport=$bt['harga'];
					}
				}
				$insert=array(
					'tanggal'=>$data['tanggal'],
					'periode'=>$data['tanggal'],
					'idcmt'=>$data['cmt'],
					'pengembalian_bangke'=>0,
					'potongan_bangke'=>0,
					//'biaya_transport'=>$data['biaya_transport'],
					'biaya_transport'=>$btransport,
					'potongan_lainnya'=>$data['potongan_lainnya'],
					'total'=>0,
					'keterangan'=>$data['keterangan'],
					'metode_pengiriman'=>$data['metode'],
					'hapus'=>0,
				);
				$this->db->insert('pembayaran_cmt',$insert);
				$id=$this->db->insert_id();
				foreach($data['products'] as $p){
					$potptm=explode(",",$p['potpertama']);
					$ids=array(
						'idpembayaran'=>$id,
						'kode_po'=>$p['kode_po'],
						'jumlah_po_dz'=>$p['jumlah_po_dz'], // qty potongan
						'jumlah_po_pcs'=>$p['jumlah_po_pcs'], // qty potongan
						'jumlah_dz'=>$p['jumlah_dz'], // qty setor
						'jumlah_pcs'=>$p['jumlah_pcs'], // qty setor
						'jumlah_bangke'=>0,
						'harga'=>$p['harga'],
						'total'=>$p['total'],
						'keterangan'=>$p['keterangan'],
						'potpertama'=>$potptm[0],
						'idpembayaranpertama'=>$potptm[1],
						'popembayaran'=>$potptm[2],
						'trans'=>$p['trans'],
					);
					$this->db->insert('pembayaran_cmt_detail',$ids);
				}
				if(isset($data['bangke'])){
					foreach($data['bangke'] as $p){
						$bangke=array(
							'idpembayaran'=>$id,
							'kode_po'=>$p['kode_po'],
							'qty'=>$p['qty'],
							'harga'=>$p['harga'],
							'total'=>($p['qty']*$p['harga']),
							'keterangan'=>$p['keterangan'],
							'hapus'=>0,
						);
						$totalbangke+=($p['qty']*$p['harga']);
						$this->db->insert('potongan_bangke',$bangke);
					}
				}
				if(isset($data['kembalianbangke'])){
					foreach($data['kembalianbangke'] as $kb){
						$kbangke=array(
							'idpembayaran'=>$id,
							'kode_po'=>$kb['kode_po'],
							'qty'=>$kb['qty'],
							'harga'=>$kb['harga'],
							'total'=>$kb['qty']*$kb['harga'],
							'keterangan'=>$kb['keterangan'],
							'hapus'=>0,
						);
						$totalpengembalianbangke+=($kb['qty']*$kb['harga']);
						$this->db->insert('pengembalian_bangke',$kbangke);
					}
				}
				$update=array(
					'pengembalian_bangke'	=>$totalpengembalianbangke,
					'potongan_bangke'	=>$totalbangke,
					'total'=>($totalbayar+$totalpengembalianbangke-$totalbangke-$btransport-$data['potongan_lainnya']),
				);
				$where=array(
					'id'=>$id,
				);
				$this->db->update('pembayaran_cmt',$update,$where);
				$this->session->set_flashdata('msg','Data berhasil ditambah');
				redirect(BASEURL.'Pembayaran/cmtjahit');
			}else{
				$this->session->set_flashdata('msg','Mohon memasukan data dengan lengkap dan benar');
				redirect(BASEURL.'Pembayaran/cmtjahittambah');
			}
		}else{
			$this->session->set_flashdata('msg','Mohon memasukan data dengan lengkap dan benar');
			redirect(BASEURL.'Pembayaran/cmtjahittambah');
		}
	}

	public function cmtjahithapus($id){
		$update=array(
			'hapus'=>1,
		);
		$this->db->update('pembayaran_cmt',$update,array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Pembayaran/cmtjahit');
	}

	public function cmtjahit_update(){
		$data=$this->input->post();
		//pre($data);
		$totalbayar=0;
		$totalbangke=0;
		$totalpengembalianbangke=0;
		$totaldz=0;
		$btransport=0;
		if(isset($data['cmt'])){
			if(isset($data['products'])){
				foreach($data['products'] as $p){
					$totalbayar+=($p['total']);
					$ids=array(
						'jumlah_dz'=>round($p['jumlah_pcs']*12), // qty setor
						'jumlah_pcs'=>$p['jumlah_pcs'], // qty setor
						'total'=>$p['total'],
						'keterangan'=>$p['keterangan'],
					);
					$this->db->update('pembayaran_cmt_detail',$ids,array('id'=>$p['id']));
				}

				$insert=array(
					'total'=>$totalbayar,
				);
				$this->db->update('pembayaran_cmt',$insert,array('id'=>$data['id']));

				$this->session->set_flashdata('msg','Data berhasil ditambah');
				redirect(BASEURL.'Pembayaran/cmtjahit');
			}else{
				$this->session->set_flashdata('msg','Mohon memasukan data dengan lengkap dan benar');
				redirect(BASEURL.'Pembayaran/cmtjahittambah');
			}
		}else{
			$this->session->set_flashdata('msg','Mohon memasukan data dengan lengkap dan benar');
			redirect(BASEURL.'Pembayaran/cmtjahittambah');
		}
	}
}