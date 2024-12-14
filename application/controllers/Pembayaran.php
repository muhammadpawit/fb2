<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
		$this->load->model('ReportModel');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
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
		$data['pekerjaan']=array();
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
		$data['cm']=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$cmt));
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
				'pekerjaan'=>$r['id_master_cmt_job'],
				'ket'=>!empty($job)?$job['nama_job']:null,
			);
			
		}

		//rekap

		$sql="SELECT COALESCE(SUM(kks.qty_tot_pcs/12),0) as dz, mj.grouping, mj.price_group FROM kelolapo_kirim_setor kks LEFT JOIN master_job mj ON mj.id=kks.id_master_cmt_job WHERE progress='SETOR' AND kategori_cmt='SABLON' ";
		$sql.=" AND id_master_cmt='".$cmt."' AND DATE(create_date) BETWEEN '".$tanggal1."' AND '".$tanggal2."' and kks.hapus=0";
		$sql.=" GROUP BY mj.grouping";
		$results=array();
		$data['rekap']=[];
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			//$job=$this->GlobalModel->getDataRow('master_job',array('hapus'=>0,'id'=>$r['id_master_cmt_job']));
			$data['rekap'][]=array(
				'no'=>$no++,
				'jenis'=>$r['grouping']==1?'Full Print':'Biasa',
				'dz'=>$r['dz'],
				'harga'=>$r['price_group'],
				'jumlah'=>($r['dz']*$r['price_group']),
			);
			
		}

		//pre($data['rekap']);


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
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'SABLON'));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		//$this->load->view($this->page.'main',$data);
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/sablon_excel',$data);
		}else{
			$data['page']=$this->page.'pembayaran/sablon_add';
			$this->load->view($this->page.'main',$data);
		}
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

		if(isset($get['tim'])){
			$tim=$get['tim'];
		}else{
			$tim=null;
		}

		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tim']=$tim;
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
				'claim'=>number_format($r['claim']),
				'nominal'=>number_format($r['nominal']),
				'keterangan'=>strtolower($r['keterangan']),
				'detail'=>BASEURL.'Pembayaran/timpotongdetail/'.$r['id'],
				'batalkan'=>BASEURL.'Pembayaran/timpotongbatalkan/'.$r['id'],
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
		$data['claims']=$this->GlobalModel->getDataRow('claim_timpotong',array('id_pembayaran'=>$id));
		$data['claim']=!empty($data['claims'])?$data['claims']['nominal']:0;
		$data['timnya']=$this->GlobalModel->getDataRow('timpotong',array('id'=>$data['prods']['timpotong']));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM gaji_timpotong_detail WHERE hapus=0 AND idgaji='".$id."' order by kode_po ASC ");
		$bukupotongan=null;
		$jenis=null;
		foreach($results as $r){
				$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$r['kode_po']));
				$timpotong=$this->GlobalModel->getDataRow('timpotong',array('id'=>$data['prods']['timpotong']));
				$bukupotongan=$this->GlobalModel->getDataRow('konveksi_buku_potongan',array('idpo'=>$r['kode_po']));
				$jenis=$this->GlobalModel->QueryManualRow("SELECT idjenis FROM master_jenis_po mjp JOIN produksi_po p ON(p.nama_po=mjp.nama_jenis_po) WHERE id_produksi_po='".$r['kode_po']."' ");
				$data['products'][]=array(
					'no'=>$no,
					'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
					'kode_po'=>isset($po['kode_po']) ? $po['kode_po'] : '',
					'jenis'=>($jenis['idjenis'] == 1) ? 'Kemeja' : 
					(($jenis['idjenis'] == 2) ? 'Kaos' : 
					(($jenis['idjenis'] == 3) ? 'Celana' : '')),
					// 'jenis'=>'Kaos',
					'size'=>isset($bukupotongan['size_potongan']) ? $bukupotongan['size_potongan'] : 0,
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
		$data['bersih']=number_format($total-$saving-$data['claim']);
		$data['totals']=($total);
		$data['savings']=($saving);
		$data['nominals']=($total-$saving-$data['claim']);
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
		//pre(substr("KM01_Simulasi", 0,3));
		$angka=0;
		// pre($results);
		$prod1=[];
		$prod2=[];
		foreach($results as $r){
			//$harga=$this->GlobalModel->getDataRow('master_harga_potongan',array('hapus'=>0,'nama_jenis_po'=>substr($r['kode_po'], 0,3)));
			$harga=$this->GlobalModel->getDataRow('master_harga_potongan',array('hapus'=>0,'nama_jenis_po'=>$r['nama_po']));
			$timpotong=$this->GlobalModel->getDataRow('timpotong',array('id'=>$r['tim_potong_potongan']));
			$roll=$this->ReportModel->getsumroll($r['kode_po'],'UTAMA');
			$rolv=$this->ReportModel->getsumroll($r['kode_po'],'CELANA');
			$angka=$this->ReportModel->getangkapotongan($r['idpo']);
			$totaldz+=($r['hasil_lusinan_potongan']);
			$totalpcs+=($r['hasil_pieces_potongan']);
			if(!empty($tim)){
				$prod1[]=array(
					'no'=>$no,
					'idpo'=>$r['idpo'],
					'tanggal'=>date('d-m-Y',strtotime($r['created_date'])),
					'kodepo'=>$r['kodepo'].'',
					'timpotong'=>$timpotong==null?$r['tim_potong_potongan']:$timpotong['nama'],
					'panjang_gelaran_potongan_utama'=>$r['panjang_gelaran_potongan_utama'],
					'pemakaian_bahan_utama'=>$r['pemakaian_bahan_utama'],
					'jumlah_pemakaian_bahan_variasi'=>$r['jumlah_pemakaian_bahan_variasi'],
					'size_potongan'=>$r['size_potongan'],
					'lusin'=>$angka,
					'pcs'=>($angka*12),
					'roll_utama'=>$roll->roll,
					'roll_variasi'=>$rolv->roll,
					'harga'=>!empty($harga)?number_format($harga['harga_potongan']):0,
					'total'=>!empty($harga)?number_format($harga['harga_potongan']* ($angka*12) ):0,
					'price'=>!empty($harga)?($harga['harga_potongan']):0,
					'totals'=>!empty($harga)?($harga['harga_potongan']* ($angka*12) ):0,
					'full'=>1,
				);
				if(!empty($harga)){
					$total+=($harga['harga_potongan']* ($angka*12) );
				
				}
			}
			$no++;
		}
		$sisa=[];
		$res=[];
		//$res=$this->GlobalModel->QueryManual("SELECT gt.timpotong,gtd.* FROM gaji_timpotong_detail gtd JOIN gaji_timpotong gt ON(gt.id=gtd.idgaji) WHERE gt.hapus=0 AND gt.timpotong='".$tim."' AND gtd.full=2 AND gtd.hapus=0 AND gtd.full_payment_id=0 ");
		$res=$this->GlobalModel->QueryManual("SELECT p.kode_po as kodepo,p.nama_po, gt.timpotong,gtd.* FROM gaji_timpotong_detail gtd JOIN gaji_timpotong gt ON(gt.id=gtd.idgaji) 
		JOIN produksi_po p ON p.id_produksi_po=gtd.kode_po
		WHERE gt.hapus=0 AND gt.timpotong='".$tim."' AND gtd.full=2 
		ORDER BY p.kode_po
		");
		// pre($res);
		foreach($res as $r){
			$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$r['kode_po']));
			// $harga=$this->GlobalModel->getDataRow('master_harga_potongan',array('hapus'=>0,'nama_jenis_po'=>substr($po['kode_po'], 0,3)));
			$harga=$this->GlobalModel->getDataRow('master_harga_potongan',array('hapus'=>0,'nama_jenis_po'=>$r['nama_po']));
			$timpotong=$this->GlobalModel->getDataRow('timpotong',array('id'=>$r['timpotong']));
			$totaldz+=($r['jml_dz']);
			$totalpcs+=($r['jml_pcs']);
			if(!empty($tim)){
				$prod2[]=array(
					'no'=>$no,
					'idpo'=>$r['kode_po'],
					'tanggal'=>date('d-m-Y',strtotime($r['tanggal'])),
					'kodepo'=>$po['kode_po'].'',
					'timpotong'=>$timpotong==null?$r['timpotong']:$timpotong['nama'],
					'lusin'=>$r['jml_dz'],
					'pcs'=>$r['jml_pcs'],
					'harga'=>!empty($r['harga']) ? number_format($harga['harga_potongan']) : 0,
					'total'=>!empty($r['harga']) ? number_format($harga['harga_potongan']*$r['jml_pcs']) : 0,
					'price'=>!empty($r['harga']) ? $harga['harga_potongan'] : 0,
					'totals'=>!empty($r['harga']) ? $harga['harga_potongan']*$r['jml_pcs'] : 0,
					'full'=>$r['full'],
				);
				if(!empty($r['harga'])){
					$total+=($harga['harga_potongan']*$r['jml_pcs']);
				}
			}
			$no++;
		}
		$data['products'] = array_merge($prod1,$prod2);
		// pre($prod2);
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
		// pre($data);
		if(isset($data['products'])){
			$insert=array(
				'tanggal'=>date('Y-m-d'),
				'periode'=>$data['periode'],
				'timpotong'=>$data['tim'],
				// 'total'=>$data['total'],
				// 'saving'=>$data['saving'],
				// 'nominal'=>$data['nominal'],
				'total'=>0,
				'saving'=>0,
				'nominal'=>0,
				'keterangan'=>'Gaji tim potong periode '.$data['periode'],
				'hapus'=>0,
				'claim'=>$data['nominal'],
			);
			$this->db->insert('gaji_timpotong',$insert);
			$id=$this->db->insert_id();
			$total=0;
			$saving=0;
			$perkalian=1;
			foreach($data['products'] as $p){
				if($p['perkalian']==1){
					$perkalian=1;
				}else if($p['perkalian']==0){
					$perkalian=0;
				}else{
					$perkalian=2;
				}
				$total+=($p['harga']*$p['pcs']*$p['perkalian']);
				$detail=array(
					'idgaji'=>$id,
					'tanggal'=>date('Y-m-d',strtotime($p['tanggal'])),
					'kode_po'=>$p['kode_po'],
					'jml_dz'=>isset($p['lusin']) ? $p['lusin'] : $p['jml_dz'],
					'jml_pcs'=> isset($p['pcs']) ? $p['pcs'] : $p['jml_pcs'],
					'harga'=>($p['perkalian']*$p['harga']),
					//'total'=>($p['total']),
					'total'=>($p['perkalian']*$p['harga']*$p['pcs']),
					'keterangan'=>null,
					'hapus'=>0,
					'full'=>$perkalian, // 1 full , 2 50%
				);
				$this->db->insert('gaji_timpotong_detail',$detail);

				$up=array(
					'full_payment_id'=>$id,
				);
				$wup=array(
					'kode_po'=>$p['kode_po'],
				);
				$this->db->update('gaji_timpotong_detail',$up,$wup);
			}
			$saving=0.05*$total;
			if(isset($data['nominal'])){
				if($data['nominal'] > 0){
					$claim=array(
						'id_pembayaran'=>$id,
						'tanggal'=>date('Y-m-d'),
						'id_timpotong'=>$data['tim'],
						'nominal'=>$data['nominal'],
						'keterangan'=>$data['keterangan'],
						'hapus'=>0,
					);
					$this->db->insert('claim_timpotong',$claim);
				}
			}
			$this->db->update('gaji_timpotong',array('saving'=>$saving,'total'=>$total,'nominal'=>($total-$saving-$data['nominal'])),array('id'=>$id));
			$this->session->set_flashdata('msg','Data berhasil ditambah');
			redirect(BASEURL.'Pembayaran/timpotong');
		}else{
			$this->session->set_flashdata('msg','Data gagal ditambah');
			redirect(BASEURL.'Pembayaran/timpotongadd');
		}
	}

	function timpotongbatalkan($id){
		$this->db->update('gaji_timpotong',array('hapus'=>1),array('id'=>$id));
		$this->db->update('gaji_timpotong_detail',array('hapus'=>1),array('idgaji'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dibatalkan');
		redirect(BASEURL.'Pembayaran/timpotong');
	}

	public function cmtjahit_allpo(){
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

		if(isset($get['kode_po'])){
			$po=$get['kode_po'];
		}else{
			$po=null;
		}

		$sql="SELECT pcd.*,pc.idcmt,pc.tanggal FROM pembayaran_cmt_detail pcd JOIN pembayaran_cmt pc ON(pc.id=pcd.idpembayaran) WHERE pc.hapus=0 ";
		if(!empty($tanggal1)){
			$sql.=" AND date(pc.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";	
		}
		
		if(!empty($po)){
			$sql.=" AND pcd.kode_po='".$po."' ";
		}



		if(!empty($cmt)){
			$sql.=" AND pc.idcmt='".$cmt."' ";
		}

		$sql.=" ORDER BY pc.id DESC";

		if(!empty($cmt) OR !empty($tanggal1)){
			
		}else{
			$sql.=" LIMIT 20 ";
		}

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
				'nama'=>strtolower($cmt['cmt_name']),
				'kode_po'=>$result['kode_po'],
				'kirim'=>$result['kirimpcs'],
				'harga'=>$result['harga'],
				'total'=>$result['total'],
				'keterangan'=>$result['keterangan'],
				'detail'=>BASEURL.'Pembayaran/cmtjahit_allpo_rincian/'.$result['kode_po'],
			);
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmtf']=$cmt;
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		//$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['kodepo']=$this->GlobalModel->QueryManual("SELECT * FROM produksi_po WHERE hapus=0 ORDER BY kode_po ASC ");
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_list_excel',$data);
		}else{
			$data['page']=$this->page.'pembayaran/cmtjahit_list_allpo';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function cmtjahit_allpo_rincian($kode_po){
		$kodepo=explode("_", $kode_po);
		pre($kodepo[0]);
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
			$tanggal1=date('Y-m-d',strtotime("-14 days"));
			//$tanggal1=null;
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

		if(isset($get['lokasicmt'])){
			$lokasicmt=$get['lokasicmt'];
		}else{
			$lokasicmt=null;
		}

		$data['lokasi']=$lokasicmt;
		$data['cmtf']=$cmt;
		$sql="SELECT * FROM pembayaran_cmt ";
		if(!empty($lokasicmt)){
			$sql.=" JOIN master_cmt ON master_cmt.id_cmt=pembayaran_cmt.idcmt WHERE pembayaran_cmt.hapus=0 AND master_cmt.lokasi='".$lokasicmt."' ";
		}else{
			$sql.=" WHERE hapus=0 ";
		}
		
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
			$jmlkirim=$this->GlobalModel->QueryManualRow("SELECT SUM(jk.jumlah_pcs) as total FROM kirimcmt_detail jk JOIN kirimcmt kc ON(kc.id=jk.idkirim) JOIN pembayaran_cmt_detail pcd ON(pcd.kode_po=jk.kode_po) WHERE idpembayaran='".$result['id']."' and jk.hapus=0 AND kc.idcmt='".$result['idcmt']."' ");
			$jmlsetor=$this->GlobalModel->QueryManualRow("SELECT SUM(jumlah_pcs) as total FROM pembayaran_cmt_detail WHERE idpembayaran='".$result['id']."' ");
			$cmt=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$result['id'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'periode'=>strtolower($result['periode']),
				'nama'=>strtolower($cmt['cmt_name']),
				'total'=>($result['total']),
				'potongan_bangke'=>($result['potongan_bangke']),
				'potongan_alat'=>($result['potongan_alat']),
				'potongan_mesin'=>($result['potongan_mesin']),
				'biaya_transport'=>($result['biaya_transport']-$result['potongan_transport']),
				'keterangan'=>strtolower($result['keterangan']),
				'detail'=>BASEURL.'Pembayaran/cmtjahitdetail/'.$result['id'],
				'hapus'=>BASEURL.'Pembayaran/cmtjahithapus/'.$result['id'],
				'totals'=>($result['total']),
				'an'=>$cmt['an'],
				'norek'=>$cmt['norek'],
				'bank'=>$cmt['bank'],
				'jmlkirim'=>$jmlkirim['total'],
				'jmlsetor'=>$jmlsetor['total'],
				'det'=>$this->GlobalModel->getData('pembayaran_cmt_detail',array('idpembayaran'=>$result['id'])),
			);
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		// rekapan gaji sukabumi
		$data['gajiskb']=[];
		$data['opsskb']=[];
		$data['vermak']=0;
		if(!empty($cmt)){
			$data['gajiskb']=$this->GlobalModel->QueryManual("SELECT COALESCE(SUM(b.total),0) as total, b.keterangan FROM gajisukabumi a LEFT JOIN gajisukabumi_detail b ON b.idgaji=a.id WHERE a.hapus=0 AND DATE(a.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' GROUP BY b.keterangan ");
			$data['opsskb']=$this->GlobalModel->QueryManualRow("SELECT * FROM anggaran_operasional_sukabumi WHERE hapus=0 AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
		}
		// pre($data['gajiskb']);
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_list_excel',$data);
		}else if(isset($get['rekap'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_rekap',$data);
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
		$pots=0;
		foreach($products as $p){
			$kirim=$this->GlobalModel->QueryManualRow("SELECT kcd.jumlah_pcs FROM kirimcmt_detail kcd JOIN kirimcmt k ON(k.id=kcd.idkirim) WHERE kcd.kode_po='".$p['kode_po']."' AND k.idcmt='".$data['detail']['idcmt']."' ");
			$pot=$this->GlobalModel->GetDataRow('konveksi_buku_potongan',array('idpo'=>$p['kode_po']));
			$po=$this->GlobalModel->GetDataRow('produksi_po',array('id_produksi_po'=>$p['kode_po']));
			if(!empty($pot)){
				$pots=$pot['hasil_pieces_potongan'];
			}else{
				$pots=!empty($p['potongan'])?$p['potongan']:0;
			}
			$data['products'][]=array(
				'id'=>$p['id'],
				'kode_po'=>$po['nama_hpp'],
				'potongan'=>$pots,
				'jumlah_po_dz'=>!empty($p['kirimpcs'])?($p['kirimpcs']/12):($kirim['jumlah_pcs']/12),
				'jumlah_po_pcs'=>!empty($p['kirimpcs'])?($p['kirimpcs']):($kirim['jumlah_pcs']/12),
				'jumlah_dz'=>$p['jumlah_dz'],
				'jumlah_pcs'=>$p['jumlah_pcs'],
				'harga'=>$p['harga'],
				'potpertama'	=>$p['potpertama'],
				'total'=>$p['total'],
				'keterangan'=>$p['keterangan'],
				'trans'=>$p['trans'],
			);
		}
		$data['bangke']=$this->GlobalModel->getData('potongan_bangke',array('idpembayaran'=>$id));
		$data['alat']=$this->GlobalModel->getData('potongan_alat',array('idpembayaran'=>$id));
		$data['mesin']=$this->GlobalModel->getData('potongan_mesin',array('idpembayaran'=>$id));
		$data['vermak']=$this->GlobalModel->getData('potongan_vermak',array('idpembayaran'=>$id));
		$data['kembalianbangke']=$this->GlobalModel->getData('pengembalian_bangke',array('idpembayaran'=>$id));
		$cmt=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$data['detail']['idcmt']));
		$data['harga']=$this->GlobalModel->getdata('daftarharga_cmt',array('hapus'=>0,'idcmt'=>$data['detail']['idcmt']));
		$data['saldo_bangke']=[];
		$data['saldo_bangke']=$this->GlobalModel->QueryManual("SELECT pb.*,mc.cmt_name, mc.id_cmt FROM potongan_bangke pb LEFT JOIN pembayaran_cmt pc ON pb.idpembayaran=pc.id LEFT JOIN master_cmt mc ON mc.id_cmt=pc.idcmt WHERE kode_po NOT IN (SELECT kode_po FROM pengembalian_bangke WHERE hapus=0) AND pc.hapus=0 AND mc.id_cmt='".$data['detail']['idcmt']."' ");
		// pre($cmt);
		$data['namacmt']=$cmt['cmt_name'];
		$data['rek']	=$cmt;
		$data['lokasi']=$cmt['lokasi'];
		$ttd		 = $this->GlobalModel->GetDataRow('user',array('bagian_user'=>1));
		$data['ttd'] = $ttd['ttd'];
		// pre($data['ttd']);
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_excel',$data);
		}else if(isset($get['pdf'])){
			
			$html = $this->load->view($this->page.'pembayaran/cmtjahit_pdf', $data, true);
			$this->load->library('pdfgenerator');
			$this->data['title_pdf'] = 'Pembayaran CMT '.ucwords($cmt['cmt_name']).' Periode '.format_tanggal($data['detail']['tanggal']);

			// Menentukan ukuran kertas dan orientasi
			$paper = array(0, 0, 800, 1000);  // Ukuran kertas kustom (sesuaikan jika perlu)
			$orientation = "portrait";  // Orientasi halaman

			// HTML Header (optional)
			$headerContent = $this->load->view($this->page.'pdf/header', $data, true);

			// HTML Footer yang berisi nomor halaman
			// $footerContent = '
			// <div style="text-align: center; font-size: 10pt; color: #555;">
			// 	<hr style="border: 1px solid #333; margin: 10px 0;">
			// 	<i>Registered by Forboys Production System '.format_tanggal_jam(date('Y-m-d H:i:s')).' </i>
			// </div>';
			$footerContent =null;

			// Gabungkan HTML header dan body
			$htmlWithHeaderFooter = $headerContent . $html . $footerContent;

			// Membuat PDF dengan footer yang diulang di setiap halaman
			$this->pdfgenerator->generate($htmlWithHeaderFooter, $this->data['title_pdf'], $paper, $orientation);


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
		//$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['kodepo']=$this->GlobalModel->QueryManual('SELECT * FROM produksi_po WHERE hapus=0 ORDER BY kode_po ASC');
		$this->load->view($this->page.'main',$data);
	}

	public function cmtjahittambah_skb(){
		$data=array();
		$data['title']='Form Pembayaran CMT Jahit Sukabumi';
		$get=$this->input->get();
		$results=array();
		if(isset($get['tanggal'])){
			$tanggal=$get['tanggal'];
		}else{
			//$tanggal1=date('Y-m-d',strtotime("first day of previous month"));
			$tanggal=null;
		}

		if(isset($get['cmt'])){
			$cmt=$get['cmt'];
		}else{
			$cmt=null;
		}

		if(isset($get['kode_po'])){
			$kode_po=explode("_", $get['kode_po']);
		}else{
			$kode_po=array('0');
		}

		$data['kode_po']=$kode_po[0];

		// history pembayaran
		$history = [];
		$history = $this->GlobalModel->getDataRow('pembayaran_skb',array('hapus'=>0,'kode_po'=>$kode_po[0],'id_cmt'=>$cmt));
		$history = !empty($history) ? $this->GlobalModel->getData('pembayaran_skb_pmb',array('hapus'=>0,'id_pembayaran_skb'=>$history['id'])) : [];
		$data['history']=$history;
		// pre($history);
		$data['kirim']=[];
		if(!empty($kode_po)){
			$data['kirim']=$this->GlobalModel->QueryManualRow("SELECT create_date as tanggal,id_master_cmt,cmt_job_price,SUM(qty_tot_pcs) as pcs FROM kelolapo_kirim_setor WHERE progress='KIRIM' AND kategori_cmt = 'JAHIT' AND kode_po LIKE '".$kode_po[0]."%' AND id_master_cmt='".$cmt."' AND hapus=0 ");
		}

		$data['setor']=[];
		if(!empty($kode_po)){
			$data['setor']=$this->GlobalModel->QueryManual("SELECT create_date as tanggal,id_master_cmt,cmt_job_price,SUM(qty_tot_pcs) as pcs FROM kelolapo_kirim_setor WHERE progress='SETOR' AND kategori_cmt = 'JAHIT' AND kode_po LIKE '".$kode_po[0]."%' AND id_master_cmt='".$cmt."' AND hapus=0 GROUP BY create_date ");
		}
		//pre($data['setor']);
		$data['action']=BASEURL.'Pembayaran/cmtjahitsave_skb';
		$data['page']=$this->page.'pembayaran/cmtjahit_form_skb';
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		//$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['kodepo']=$this->GlobalModel->QueryManual('SELECT * FROM produksi_po WHERE hapus=0 ORDER BY kode_po ASC');
		$this->load->view($this->page.'main',$data);
	}

	public function cmtjahit_skb(){
		$data['title']='Rincian Pembayaran CMT Jahit Sukabumi';
		$data['tambah']=BASEURL.'Pembayaran/cmtjahittambah_skb';
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

		if(isset($get['lokasicmt'])){
			$lokasicmt=$get['lokasicmt'];
		}else{
			$lokasicmt=null;
		}

		$data['lokasi']=$lokasicmt;
		$data['cmtf']=$cmt;
		$sql="SELECT * FROM pembayaran_skb ";
		if(!empty($lokasicmt)){
			$sql.=" JOIN master_cmt ON master_cmt.id_cmt=pembayaran_skb.id_cmt WHERE pembayaran_cmt.hapus=0 AND master_cmt.lokasi='".$lokasicmt."' ";
		}else{
			$sql.=" WHERE hapus=0 ";
		}
		
		if(!empty($tanggal1)){
			$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";	
		}
		
		if(!empty($cmt)){
			$sql.=" AND id_cmt='".$cmt."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$results=array();
		$results=$this->GlobalModel->QueryManual($sql);
		//pre($results);
		$no=1;
		$jmlsetor=0;
		$jmlkirim=0;
		$total_alat=0;
		$pelunasan=[];
		$ket=null;
		foreach($results as $result){
			$ket=$this->GlobalModel->getdataRow('pembayaran_skb_pmb',array('hapus'=>0,'id_pembayaran_skb'=>$result['id']));
			$pelunasan=$this->GlobalModel->getdataRow('pelunasan_pembayaran_skb',array('idpembayaran'=>$result['id']));
			$cmt=$this->GlobalModel->getdataRow('master_cmt',array('id_cmt'=>$result['id_cmt']));
			$total_alat=$this->GlobalModel->QueryManualRow("SELECT SUM(total) as total FROM pembayaran_skb_alat WHERE hapus=0 AND idpembayaran='".$result['id']."' ");
			$data['products'][]=array(
				'no'=>$no++,
				'id'=>$result['id'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'nama'=>strtolower($cmt['cmt_name']),
				'kode_po'=>$result['kode_po'],
				'tagihan'=>$result['tagihan'],
				'potongan_alat'=>!empty($total_alat)?$total_alat['total']:0,
				'detail'=>BASEURL.'Pembayaran/cmtjahit_skb_detail/'.$result['id'],
				'hapus'=>BASEURL.'Pembayaran/cmtjahit_skb_hapus/'.$result['id'],
				'pelunasan' => $pelunasan,
				'ket'		=> !empty($ket) ? $ket['keterangan']:null,
			);
		}
		//pre($data['products']);
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		
		$data['cmt']=$this->GlobalModel->getData('master_cmt',array('hapus'=>0,'cmt_job_desk'=>'JAHIT'));
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		// rekapan gaji sukabumi
		$data['gajiskb']=[];
		$data['opsskb']=[];
		$data['vermak']=0;
		
		if(!empty($cmt)){
			$data['gajiskb']=$this->GlobalModel->QueryManualRow("SELECT * FROM gajisukabumi WHERE hapus=0 AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
			$data['opsskb']=$this->GlobalModel->QueryManualRow("SELECT * FROM anggaran_operasional_sukabumi WHERE hapus=0 AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
		}
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_list_excel',$data);
		}else if(isset($get['rekap'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_rekap',$data);
		}else{
			$data['page']=$this->page.'pembayaran/cmtjahit_list_skb';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function cmtjahit_skb_hapus($id){
		$update = array(
			'hapus'=>1,
		);
		$where = array(
			'id'=>$id
		);
		$this->db->update('pembayaran_skb',$update,$where);
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Pembayaran/cmtjahit_skb');
	}

	public function cmtjahit_skb_detail($id){
		$data['title']='Detail Pembayaran CMT Sukabumi';
		$data['prods']=$this->GlobalModel->GetDataRow('pembayaran_skb',array('id'=>$id));
		$data['setor']=$this->GlobalModel->GetData('pembayaran_skb_setor',array('id_pembayaran_skb'=>$id));
		$data['pmby']=$this->GlobalModel->GetData('pembayaran_skb_pmb',array('id_pembayaran_skb'=>$id));
		$data['alat']=$this->GlobalModel->GetData('pembayaran_skb_alat',array('hapus'=>0,'idpembayaran'=>$id));
		$kode_po=explode("_", $data['prods']['kode_po']);
		$cmt=$data['prods']['id_cmt'];
		$data['cmt']=$cmt;
		$data['kode_po']=$kode_po[0];
		$data['action']=null;
		$data['kirim']=[];
		
		$history = [];
		$history = $this->GlobalModel->getDataRow('pembayaran_skb',array('hapus'=>0,'kode_po'=>$data['prods']['kode_po'],'id_cmt'=>$data['prods']['id_cmt']));
		$history = !empty($history) ? $this->GlobalModel->getData('pelunasan_pembayaran_skb',array('idpembayaran'=>$id)) : [];
		$data['history']=$history;
		// pre($history);

		if(!empty($kode_po)){
			$data['kirim']=$this->GlobalModel->QueryManualRow("SELECT create_date as tanggal,id_master_cmt,cmt_job_price,SUM(qty_tot_pcs) as pcs FROM kelolapo_kirim_setor WHERE progress='KIRIM' AND kategori_cmt = 'JAHIT' AND kode_po LIKE '".$kode_po[0]."%' AND id_master_cmt='".$cmt."' AND hapus=0 ");
		}
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'pembayaran/cmtjahit_detail_skb_excel',$data);
		}else{
			$data['page']=$this->page.'pembayaran/cmtjahit_detail_skb';
			$this->load->view($this->page.'main',$data);
		}
			
	}
	public function cmtjahitsave_skb(){
		$data=$this->input->post();
		// pre($data);		
		if(isset($data['tanggal_pelunasan'])){
			$pelunasan = array(
				'tagihan' => $data['tagihan'],
				'tanggal' => date('Y-m-d'),
				'idpembayaran'	=> $data['idpembayaran'],
				'tanggal_pelunasan'	=> $data['tanggal_pelunasan'],
				'rincian_pcs'	=> $data['rincian_pcs'],
				'nominal'		=> $data['nominal'],
				'keterangan'	=> $data['keterangan']
			);
			$this->db->insert('pelunasan_pembayaran_skb',$pelunasan);
		}else{
			$po=$this->GlobalModel->QueryManualRow("SELECT * FROM produksi_po WHERE kode_po LIKE '%".$data['kode_po']."%' LIMIT 1 ");
			$insert=array(
				'tanggal'=>$data['tgl'],
				'idpo'=>$po['id_produksi_po'],
				'kode_po'=>$data['kode_po'],
				'id_cmt'=>$data['id_cmt'],
				'tagihan'=>$data['tagihan'],
				'hapus'=>0,
			);
			$this->db->insert('pembayaran_skb',$insert);
			$id=$this->db->insert_id();
			// po
			foreach($data['po'] as $p){
				$pembayaran_skb_po=array(
					'id_pembayaran_skb'=>$id,
					'tanggal'=>$p['tanggal'],
					'idpo'=>$po['id_produksi_po'],
					'kode_po'=>$data['kode_po'],
					'jumlah_dz'=>$p['dz'],
					'jumlah_pcs'=>$p['pcs'],
					'harga'=>$p['harga'],
					'total'=>$p['nilaipo'],
					'hapus'=>0,
				);
				$this->db->insert('pembayaran_skb_po',$pembayaran_skb_po);
			}

			// po setor
			foreach($data['setor'] as $p){
				$pembayaran_skb_setor=array(
					'id_pembayaran_skb'=>$id,
					'tanggal'=>$p['tanggal'],
					'idpo'=>$po['id_produksi_po'],
					'kode_po'=>$data['kode_po'],
					'jumlah_pcs_kirim'=>$p['kirim_pcs']==0?null:$p['kirim_pcs'],
					'jumlah_pcs_setor'=>$p['setor_pcs']==0?null:$p['setor_pcs'],
					'hapus'=>0,
				);
				$this->db->insert('pembayaran_skb_setor',$pembayaran_skb_setor);
			}

			// pembayaran
			if(isset($data['pmby'])){
				foreach($data['pmby'] as $p){
					$pembayaran_skb_pmb=array(
						'id_pembayaran_skb'=>$id,
						'tanggal'=>$p['tgl'],
						'rincian'=>$p['rincian'],
						'kredit'=>$p['kredit'],
						'saldo'=>$p['saldo'],
						'keterangan'=>'Pembayaran '.($p['percent']*100).' %',
						'hapus'=>0,
					);
					$this->db->insert('pembayaran_skb_pmb',$pembayaran_skb_pmb);
				}
			}else{
				$kode_po=explode("_", $data['kode_po']);
				$p=$this->GlobalModel->QueryManualRow("SELECT create_date as tanggal,id_master_cmt,cmt_job_price,SUM(qty_tot_pcs) as pcs FROM kelolapo_kirim_setor WHERE progress='KIRIM' AND kategori_cmt = 'JAHIT' AND kode_po LIKE '".$kode_po[0]."%' AND id_master_cmt='".$data['id_cmt']."' AND hapus=0 ");
					$pembayaran_skb_pmb=array(
						'id_pembayaran_skb'=>$id,
						'tanggal'=>$p['tanggal'],
						'rincian'=>$p['pcs'],
						'kredit'=>0,
						'saldo'=>$data['tagihan'],
						'keterangan'=>'Pembayaran 100 %',
						'hapus'=>0,
					);
					$this->db->insert('pembayaran_skb_pmb',$pembayaran_skb_pmb);
			}
		}
		

		// alat
				if(isset($data['alat'])){
					foreach($data['alat'] as $p){
						$pembayaran_skb_alat=array(
							// 'idpembayaran'=>$id,
							'idpembayaran'=>isset($data['idpembayaran']) ? $data['idpembayaran'] : $id,
							'rincian'=>$p['rincian'],
							'qty'=>$p['qty'],
							'harga'=>$p['harga'],
							'total'=>($p['qty']*$p['harga']),
							'keterangan'=>$p['keterangan'],
							'hapus'=>0,
						);
						$totalalat+=($p['qty']*$p['harga']);
						$this->db->insert('pembayaran_skb_alat',$pembayaran_skb_alat);
					}
				}

		$this->session->set_flashdata('msg','Data berhasil ditambah');
		redirect(BASEURL.'Pembayaran/cmtjahit_skb');

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
		$transport=isset($data['pot_transport'])?explode('-',$data['pot_transport']):0;
		// pre($data);
		if($data['pot_pinjaman']==1){
			if($data['potongan_lainnya'] < 0){
				$this->session->set_flashdata('msg','Nilai Potongan harus lebih besar dari 0');
				redirect(BASEURL.'Pembayaran/cmtjahittambah');
			}
		}
		$totalbayar=0;
		$totalbangke=0;
		$totalpengembalianbangke=0;
		$totaldz=0;
		$btransport=0;
		$pottripke2=0;
		$totalalat=0;
		$totalpotmesin=0;
		$totalvermak=0;
		//echo 'Sedang dalam perbaikan.. Mohon tunggu beberapa saat lagi';exit;
		//pre($data);
		if(isset($data['cmt'])){
			if(isset($data['products'])){
				foreach($data['products'] as $p){
					$potptm=explode(",",$p['potpertama']);
					$totalbayar+=($p['total']-$potptm[0]);
					if($p['trans']==1){
						$totaldz+=($p['jumlah_pcs']/12);
					}
				}
				$sbt="SELECT * FROM harga_transport WHERE dz1<='".$totaldz."' AND '".$totaldz."' <=dz2 ";
				$tripke1=0;
				if(isset($data['pot_transport'])){
					$tripke1=$transport[1];
				}
				if($data['metode']==1){
					$bt=$this->GlobalModel->QueryManualRow($sbt);
					if(!empty($bt)){
						$btransport=$bt['harga'];
					}
				}

				if(isset($data['tripke'])){
					if($data['tripke']==2){
						$trip1=$this->GlobalModel->GetdataRow('pembayaran_cmt',array('id'=>$transport[0]));
						$dtrip1=$this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(jumlah_dz),0) as total FROM pembayaran_cmt_detail WHERE idpembayaran='".$trip1['id']."' AND trans=1 ");
						$alldz=($totaldz+$dtrip1['total']);
						$bt2=$this->GlobalModel->QueryManualRow("SELECT * FROM harga_transport WHERE dz1<='".$alldz."' AND '".$alldz."' <=dz2 ");
						$btransport=($bt2['harga']);
					}
				}

				//pre($btransport-$tripke1);
				$insert=array(
					'tanggal'=>$data['tanggal'],
					'periode'=>$data['tanggal'],
					'idcmt'=>$data['cmt'],
					'pengembalian_bangke'=>0,
					'potongan_bangke'=>0,
					'potongan_alat'=>0,
					//'biaya_transport'=>$data['biaya_transport'],
					'biaya_transport'=>$btransport,
					'potongan_lainnya'=>$data['potongan_lainnya'],
					'total'=>0,
					'keterangan'=>$data['keterangan'],
					'metode_pengiriman'=>$data['metode'],
					'hapus'=>0,
					'potongan_transport'=>isset($data['pot_transport'])?$transport[1]:0,
					'transport_dari_id'=>isset($data['pot_transport'])?$transport[0]:0,
					'tripke'=>isset($data['tripke'])?$data['tripke']:1,
					'potongan_alat'=>0,
					'potongan_mesin'=>0,
					'potongan_vermak'=>0,
				);
				//pre(($totalbayar+$totalpengembalianbangke-25000-($btransport-$tripke1)-$data['potongan_lainnya']));
				$this->db->insert('pembayaran_cmt',$insert);
				$id=$this->db->insert_id();
				if($data['pot_pinjaman']==1){
					$cek=$this->GlobalModel->QueryManualRow("SELECT * FROM pinjaman_cmt WHERE idcmt='".$data['cmt']."' AND status NOT IN (3) AND hapus=0 ");
					if(!empty($cek)){
						$insert_pot_pinjaman=array(
							'idcmt'=>$data['cmt'],
							'idpinjaman'=>$cek['id'],
							'tanggal'=>$data['tanggal'],
							'totalpotongan'=>$data['potongan_lainnya'],
							'sisa'=>($cek['totalpinjaman']-$cek['totalpotongan']-$data['potongan_lainnya']),
							'keterangan'=>'Potongan Pinjaman tanggal '.$data['tanggal'],
							'hapus'=>0,
							'idpembayaran'=>$id,
						);
						$this->db->insert('potongan_pinjaman_cmt',$insert_pot_pinjaman);

						$cek2=$this->GlobalModel->QueryManualRow("SELECT SUM(totalpotongan) as totalpotongan FROM potongan_pinjaman_cmt WHERE idcmt='".$data['cmt']."' AND hapus=0 AND idpinjaman='".$cek['id']."' ");

						if(!empty($cek2)){
							if($cek2['totalpotongan']==$cek['totalpinjaman']){
								$this->db->update('pinjaman_cmt',array('status'=>3,'totalpotongan'=>$cek2['totalpotongan']),array('id'=>$cek['id']));
							}else{
								$this->db->update('pinjaman_cmt',array('status'=>2,'totalpotongan'=>$cek2['totalpotongan']),array('id'=>$cek['id']));
							}
						}
					}
				}
				foreach($data['products'] as $p){
					$potptm=explode(",",$p['potpertama']);
					if($p['potpertama']==0){
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
							'potpertama'=>0,
							'idpembayaranpertama'=>0,
							'popembayaran'=>0,
							'trans'=>$p['trans'],
							'potongan'=>$p['potongan'],
							'kirimpcs'=>$p['kirimpcs'],
						);
					}else{
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
							'potongan'=>$p['potongan'],
							'kirimpcs'=>$p['kirimpcs'],
						);
					}
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
				if(isset($data['alat'])){
					foreach($data['alat'] as $p){
						$alat=array(
							'idpembayaran'=>$id,
							'rincian'=>$p['rincian'],
							'qty'=>$p['qty'],
							'harga'=>$p['harga'],
							'total'=>($p['qty']*$p['harga']),
							'keterangan'=>$p['keterangan'],
							'hapus'=>0,
						);
						$totalalat+=($p['qty']*$p['harga']);
						$this->db->insert('potongan_alat',$alat);
						if(isset($p['id_distribusi'])){
							$updatedis = array(
								'idpembayaran' => $id
							);
							$this->db->update('distribusi_alat_sukabumi',$updatedis,array('id'=> $p['id_distribusi']));
						}
					}
				}
				if(isset($data['mesin'])){
					foreach($data['mesin'] as $p){
						$insert_mesin=array(
							'idpembayaran'=>$id,
							'rincian'=>$p['rincian'],
							'qty'=>$p['qty'],
							'harga'=>$p['harga'],
							'total'=>($p['qty']*$p['harga']),
							'keterangan'=>$p['keterangan'],
							'hapus'=>0,
						);
						$totalpotmesin+=($p['qty']*$p['harga']);
						$this->db->insert('potongan_mesin',$insert_mesin);
					}
				}

				if(isset($data['vermak'])){
					foreach($data['vermak'] as $p){
						$insert_vermak=array(
							'idpembayaran'=>$id,
							'rincian'=>$p['rincian'],
							'qty'=>$p['qty'],
							'harga'=>$p['harga'],
							'total'=>($p['qty']*$p['harga']),
							'keterangan'=>$p['keterangan'],
							'hapus'=>0,
						);
						$totalvermak+=($p['qty']*$p['harga']);
						$this->db->insert('potongan_vermak',$insert_vermak);
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
					'potongan_alat' =>$totalalat,
					'potongan_mesin'=>$totalpotmesin,
					'potongan_vermak'=>$totalvermak,
					'total'=>($totalbayar+$totalpengembalianbangke-$totalbangke-($btransport-$tripke1)-$data['potongan_lainnya']-$totalalat-$totalpotmesin-$totalvermak),
				);
				//pre($potptm);
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
		// pre($data);
		$totalbayar=0;
		$totalbangke=0;
		$totalpengembalianbangke=0;
		$totaldz=0;
		$btransport=0;
		if(isset($data['cmt'])){
			if(isset($data['products'])){
				foreach($data['products'] as $p){
					$totalbayar+=(round($p['jumlah_pcs']/12)) * $p['harga'];
					$ids=array(
						'jumlah_dz'=>round($p['jumlah_pcs']/12), // qty setor
						'jumlah_pcs'=>$p['jumlah_pcs'], // qty setor
						'total'=>(round($p['jumlah_pcs']/12)) * $p['harga'],
						'keterangan'=>$p['keterangan'],
					);
					$this->db->update('pembayaran_cmt_detail',$ids,array('id'=>$p['id']));
				}

				$insert=array(
					'total'=>$totalbayar + $data['pengembalian_bangke'] - $data['potongan_bangke'] - $data['potongan_alat'] - $data['potongan_mesin'] - $data['potongan_vermak'] - $data['biaya_transport'] - $data['potongan_lainnya'],
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