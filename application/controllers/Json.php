<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	

	public function checkpinjaman(){
		$data=$this->input->get();
		$hasil=0;
		$cek=$this->GlobalModel->QueryManualRow("SELECT SUM(totalpinjaman-totalpotongan) as sisa FROM pinjaman_cmt WHERE idcmt='".$data['cmt']."' AND status NOT IN (3) AND hapus=0 ");
		if(!empty($cek)){
			$hasil=$cek['sisa'];
		}
		echo $hasil;
	}


	public function search_po_pot(){
		$data=$this->input->get();
		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";
		if(!empty($data['term'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY id_produksi_po DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$count=$this->GlobalModel->GetData('konveksi_buku_potongan',array('hapus'=>0,'kode_po'=>$row['kode_po']));
			$hasil[]=array(
				'id'=>$row['kode_po'],
				'label'=>$row['kode_po'],
				'text'=>$row['kode_po'],
				'details'=>$count,
			);
		}

		echo json_encode($hasil);
	}

	public function search_po(){
		$data=$this->input->get();
		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";
		if(!empty($data['term'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY id_produksi_po DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['kode_po'],
				'label'=>$row['kode_po'],
				'text'=>$row['kode_po'].' '.$row['serian'],
			);
		}

		echo json_encode($hasil);
	}

	public function search_po_autocomplete(){
		$data=$this->input->get();
		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";
		if(!empty($data['term'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY id_produksi_po DESC ";
		$sql.=" LIMIT 5";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['kode_po'],
				'label'=>$row['kode_po'],
				'text'=>$row['kode_po'].' '.$row['serian'],
			);
		}

		echo json_encode($hasil);
	}


	public function search_po_for_input_potongan(){
		$data=$this->input->get();
		//$sql="SELECT po.* FROM produksi_po po JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=po.nama_po) WHERE po.hapus=0 and po.kode_po NOT IN(SELECT kode_po FROM konveksi_buku_potongan WHERE kode_po NOT LIKE 'BJF%' AND kode_po NOT LIKE 'BJK%' ) ";
		//$sql="SELECT po.* FROM produksi_po po JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=po.nama_po) WHERE po.hapus=0 and po.kode_po NOT IN(SELECT kode_po FROM konveksi_buku_potongan WHERE kode_po NOT LIKE 'BJF%' AND kode_po NOT LIKE 'BJK%' AND kode_po NOT LIKE 'FBS%' AND kode_po NOT LIKE 'KDS%' ) ";
		$sql="SELECT po.* FROM produksi_po po JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=po.nama_po) WHERE po.hapus=0 ";
		if(!empty($data['term'])){
			$sql .= " AND lower(po.kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}
		$sql.=" ORDER BY po.id_produksi_po DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				// 'id'=>$row['nama_po'].'-'.$row['kode_po'],
				'id'=>$row['id_produksi_po'],
				'text'=>$row['kode_po'].' '.$row['serian'],
			);
		}

		echo json_encode($hasil);
	}

	public function search_po_luar(){
		$data=$this->input->get();
		$sql="SELECT * FROM master_po_luar WHERE hapus=0 ";
		if(!empty($data['term'])){
			$sql .= " AND lower(nama) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(nama) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY id DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['id'],
				'label'=>$row['nama'],
				'text'=>$row['nama'],
			);
		}

		echo json_encode($hasil);
	}


	public function monitor(){
		$fil=0;
		$draw=isset($_REQUEST['draw'])?$_REQUEST['draw']:0;
		$length=isset($_REQUEST['length'])?$_REQUEST['length']:0;
		$start=isset($_REQUEST['start'])?$_REQUEST['start']:0;
		$search=isset($_REQUEST['search']["value"])?$_REQUEST['search']["value"]:'';
		$nama=isset($_REQUEST['nama'])?$_REQUEST['nama']:'';
		$notelp=isset($_REQUEST['notelp'])?$_REQUEST['notelp']:'';
		$posisi=isset($_REQUEST['posisi'])?$_REQUEST['posisi']:'';
		$jenispo=isset($_REQUEST['jenispo'])?$_REQUEST['jenispo']:null;
		$validasi=isset($_REQUEST['validasi'])?$_REQUEST['validasi']:null;
		$model_po=isset($_REQUEST['model_po'])?$_REQUEST['model_po']:null;
		$output['data']=array();
		$output=array();
		$output['draw']=$draw;
		$nomors=$start+1;
		$allpo=[];
		$sql="SELECT * FROM produksi_po LEFT JOIN master_jenis_po ON (master_jenis_po.nama_jenis_po=produksi_po.nama_po) WHERE hapus=0 AND kode_po IN(SELECT kode_po FROM konveksi_buku_potongan where hapus=0 ) AND nama_po NOT IN('BJF','BJK','BJH') ";
		if($jenispo!='null'){
			$sql.=" AND master_jenis_po.id_jenis_po='".$jenispo."' ";
		}else{
			//$sql.=" AND master_jenis_po.id_jenis_po='0' ";
		}
		if($validasi!='null'){
			$sql.=" AND produksi_po.validasi='".$validasi."' ";
		}

		if($model_po!='null'){
			$sql.=" AND produksi_po.model_po='".$model_po."' ";
		}


		$sql.=" ORDER BY kode_po ASC";
		//echo $sql; die();
		$allpos=$this->GlobalModel->QueryManual($sql);
		$potongan=0;
		$pengecekan=0;
		$sablon=0;
		$bordir=0;
		$kirimjahit=0;
		$setorjahit=0;
		$stokfinishing=0;
		$rijek=0;
		$bangke=0;
		if(!empty($allpos)){
			foreach($allpos as $p){
				$selisih=$this->ReportModel->selisih($p['kode_po']);
				$bangke=$this->ReportModel->bangke($p['kode_po']);
				// $potongan="<a href='".BASEURL.'kelolapo/bukupotonganDetail/'.$p['kode_po']."'>".$this->ReportModel->getpcs($p['kode_po'],1)."</a>";
				// $pengecekan="<a href='".BASEURL.'kelolapo/pengecekanpotongandetail/'.$p['kode_po']."'>".$this->ReportModel->getpcs($p['kode_po'],2)."</a>";
				// $sablon="<a href='".BASEURL.'kelolapo/pengecekanpotongandetail/'.$p['kode_po']."'>".$this->ReportModel->getpcsK($p['kode_po'],"SABLON","KIRIM")."</a>";
				//$bordir="<a href='".BASEURL.'kelolapo/bukupotonganDetail/'.$p['kode_po']."'>".$this->ReportModel->getpcsK($p['kode_po'],"BORDIR","KIRIM")."</a>";
				//$kirimcmt="<a href='".BASEURL.'kelolapo/bukupotonganDetail/'.$p['kode_po']."'>".$this->ReportModel->getpcsK($p['kode_po'],"JAHIT","KIRIM")."</a>";
				// $setorcmt="<a href='".BASEURL.'kelolapo/bukupotonganDetail/'.$p['kode_po']."'>".$this->ReportModel->getpcsK($p['kode_po'],"JAHIT","SETOR")."</a>";
				// $kirimgudang="<a href='".BASEURL.'kelolapo/bukupotonganDetail/'.$p['kode_po']."'>".$this->ReportModel->dashkirimgdgpcs($p['kode_po'])."</a>";

				$potongan=$this->ReportModel->getpcs($p['kode_po'],1);
				$pengecekan=$this->ReportModel->getpcs($p['kode_po'],2);
				$sablon=$this->ReportModel->getpcsK($p['kode_po'],"SABLON","KIRIM");
				$bordir=$this->ReportModel->getpcsK($p['kode_po'],"BORDIR","KIRIM");
				$kirimcmt=$this->ReportModel->getpcsK($p['kode_po'],"JAHIT","KIRIM");
				$setorcmt=$this->ReportModel->getpcsK($p['kode_po'],"JAHIT","SETOR");
				$kirimgudang=$this->ReportModel->dashkirimgdgpcs($p['kode_po']);
				$rijek=$this->ReportModel->pcsRijek($p['kode_po'],null,null);
				$output['data'][]=array(
					$nomors,
					!empty($p['keterangan']) ? strtoupper($p['keterangan']):strtoupper($p['kode_po']),
					$potongan,
					$pengecekan,
					$sablon,
					$bordir,
					$kirimcmt,
					$setorcmt,
					$kirimgudang,
					$rijek,
					$selisih,
					$bangke,
				);
				$nomors++;
			}
		}else{
			$output['data'][]=array(
					'Tidak ada data',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
			);
		}			
				
		echo json_encode($output);

	}


	public function bawahansablon(){
		$fil=0;
		$draw=isset($_REQUEST['draw'])?$_REQUEST['draw']:0;
		$length=isset($_REQUEST['length'])?$_REQUEST['length']:0;
		$start=isset($_REQUEST['start'])?$_REQUEST['start']:0;
		$search=isset($_REQUEST['search']["value"])?$_REQUEST['search']["value"]:'';
		$nama=isset($_REQUEST['kode_po'])?$_REQUEST['kode_po']:'';
		$notelp=isset($_REQUEST['notelp'])?$_REQUEST['notelp']:'';
		$posisi=isset($_REQUEST['posisi'])?$_REQUEST['posisi']:'';
		$output['data']=array();
		$output=array();
		$output['draw']=$draw;
		$nomors=$start+1;
		$allpo=[];
		$sql="SELECT * FROM sablonbawahan WHERE hapus=0 ";
		if(!empty($nama)){
			$sql .= " AND kode_po='".$nama."' ";
		}
		$sql.=" ORDER BY id DESC ";
		$allpos=$this->GlobalModel->QueryManual($sql);
		$potongan=0;
		$pengecekan=0;
		$sablon=0;
		$bordir=0;
		$kirimjahit=0;
		$setorjahit=0;
		foreach($allpos as $p){
			$link='
				<a href="'.BASEURL.'Sablonbawahan/hapus/'.$p['id'].'" class="btn btn-danger btn-sm text-white">Hapus</a>
			';
			$output['data'][]=array(
				$nomors,
				strtoupper($p['kode_po']),
				strtoupper($p['namacmt']),
				strtoupper($p['namajob']),
				number_format($p['price']),
				strtoupper($p['keterangan']),
				$link,
			);
			$nomors++;
		}			
				
		echo json_encode($output);

	}

	public function search_po_bawahansablon(){
		$data=$this->input->get();
		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";
		if(!empty($data['term'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY id_produksi_po DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['id_produksi_po'].','.$row['kode_po'],
				'label'=>$row['kode_po'],
				'text'=>$row['kode_po'],
			);
		}

		echo json_encode($hasil);
	}

	public function search_cmt_bawahansablon(){
		$data=$this->input->get();
		$sql="SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk='SABLON' ";
		if(!empty($data['term'])){
			$sql .= " AND lower(cmt_name) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(cmt_name) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY cmt_name ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['id_cmt'].','.$row['cmt_name'],
				'label'=>$row['cmt_name'],
				'text'=>$row['cmt_name'],
			);
		}

		echo json_encode($hasil);
	}


	public function search_job_bawahansablon(){
		$data=$this->input->get();
		$sql="SELECT * FROM master_job WHERE hapus=0 AND jenis=2 ";
		if(!empty($data['term'])){
			$sql .= " AND lower(nama_job) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(nama_job) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY nama_job ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['id'].','.$row['nama_job'].','.$row['harga'],
				'label'=>$row['nama_job'],
				'text'=>$row['nama_job'],
			);
		}

		echo json_encode($hasil);
	}


	public function search_po_kirimjahit(){
		$data=$this->input->get();
		$sql="SELECT * FROM produksi_po WHERE hapus=0 ";
		//$sql="SELECT * FROM produksi_po WHERE hapus=0 and kode_po IN(select kode_po from kelolapo_pengecekan_potongan) ";
		if(!empty($data['term'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(kode_po) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY id_produksi_po DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['kode_po'],
				'label'=>$row['kode_po'],
				'text'=>$row['kode_po'].' '.$row['serian'],
			);
		}

		echo json_encode($hasil);
	}

	public function search_operator(){
		$data=$this->input->get();
		$sql="SELECT * FROM master_karyawan_bordir WHERE hapus=0 ";

		if(!empty($data['term'])){
			$sql .= " AND lower(nama_karyawan_bordir) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(nama_karyawan_bordir) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY nama_karyawan_bordir ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['id_master_karyawan_bordir'].','.$row['nama_karyawan_bordir'],
				'label'=>strtolower($row['nama_karyawan_bordir']),
				'text'=>strtolower($row['nama_karyawan_bordir']),
			);
		}

		echo json_encode($hasil);
	}


	public function search_jenispotongan(){
		$data=$this->input->get();
		$sql="SELECT * FROM jenis_potongan WHERE hapus=0 ";

		if(!empty($data['term'])){
			$sql .= " AND lower(nama) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(nama) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY nama ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['id'],
				'label'=>strtolower($row['nama']),
				'text'=>strtolower($row['nama']),
			);
		}

		echo json_encode($hasil);
	}

	public function search_sj(){
		$data=$this->input->get();
		$sql="SELECT * FROM kirimcmt WHERE hapus=0 ";

		if(!empty($data['term'])){
			$sql .= " AND lower(nosj) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(nosj) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" AND nosj !='' ";

		$sql.=" ORDER BY nosj DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$cmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$row['idcmt']));;
			$hasil[]=array(
				'id'=>$row['id'],
				'label'=>strtoupper($row['nosj']),
				'text'=>strtoupper($cmt['cmt_name'].'('.date('d F Y',strtotime($row['tanggal'])).' '.$row['nosj'].')'),
			);
		}

		echo json_encode($hasil);
	}

	public function search_sj_sablon(){
		$data=$this->input->get();
		$sql="SELECT * FROM kirimcmtsablon WHERE hapus=0 ";

		if(!empty($data['term'])){
			$sql .= " AND lower(nosj) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(nosj) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" AND nosj !='' ";

		$sql.=" ORDER BY nosj DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$cmt=$this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$row['idcmt']));;
			$hasil[]=array(
				'id'=>$row['id'],
				'label'=>strtoupper($row['nosj']),
				'text'=>strtoupper($cmt['cmt_name'].'('.date('d F Y',strtotime($row['tanggal'])).' '.$row['nosj'].')'),
			);
		}

		echo json_encode($hasil);
	}


	public function search_po_kirimjahitpenambahan(){
		$data=$this->input->get();
		//$sql="SELECT * FROM produksi_po WHERE hapus=0  ";
		//$sql="SELECT * FROM produksi_po WHERE hapus=0 and kode_po IN(select kode_po from kelolapo_pengecekan_potongan) AND kode_po NOT IN (SELECT kode_po FROM kirimcmt_detail WHERE hapus=0 ) ";
		$sql ="SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE kbp.kode_po NOT IN(SELECT kode_po from finishing_kirim_gudang WHERE tahunpo is null )";
		if(!empty($data['term'])){
			$sql .= " AND lower(kbp.kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}

		if(!empty($data['search'])){
			$sql .= " AND lower(kbp.kode_po) LIKE '%".strtolower($data['search'])."%' ";
		}

		$sql.=" ORDER BY id_produksi_po DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['kode_po'],
				'label'=>$row['kode_po'].' '.$row['serian'],
				'text'=>$row['kode_po'],
			);
		}

		echo json_encode($hasil);
	}


	public function pmbpotong()
	{
		$post = $this->input->get();
		$data = $this->GlobalModel->QueryManualRow("SELECT SUM(kbp.hasil_pieces_potongan) as potongan FROM konveksi_buku_potongan kbp WHERE kode_po='".$post['kodepo']."' ");
		echo json_encode($data);
	}

	public function pmbkirim()
	{
		$post = $this->input->get();
		$data = $this->GlobalModel->QueryManualRow("SELECT SUM(kbp.qty_tot_pcs) as kirimpcs, kbp.cmt_job_price as harga FROM kelolapo_kirim_setor kbp WHERE kode_po='".$post['kodepo']."' AND hapus=0 AND kategori_cmt='JAHIT' AND progress='KIRIM' AND id_master_cmt='".$post['cmt']."' ");
		echo json_encode($data);
	}


	public function pot_transport()
	{
		$data=[];
		$post = $this->input->get();
		$data = $this->GlobalModel->QueryManual("SELECT * FROM pembayaran_cmt WHERE hapus=0 AND id NOT IN(SELECT transport_dari_id from pembayaran_cmt WHERE hapus=0) AND idcmt='".$post['cmt']."' AND tripke=1 ORDER BY ID DESC ");
		// echo "<option value='0-0'>0</option>";
		if(!empty($data)){
			echo "<option value='0-0'>0</option>";
			foreach($data as $d){
				echo "<option value='".$d['id']."-".$d['biaya_transport']."'>".date('d/m/Y',strtotime($d['tanggal']))." ".$d['biaya_transport']."</option>";
			}
		}
	}

	public function autopoid(){
		$data=$this->input->get();
		$sql="SELECT po.* FROM produksi_po po WHERE hapus=0 AND id_produksi_po NOT IN (SELECT idpo from pogagalproduksi WHERE hapus=0 ) ";
		if(!empty($data['term'])){
			$sql .= " AND lower(po.kode_po) LIKE '%".strtolower($data['term'])."%' ";
		}
		$sql.=" ORDER BY po.id_produksi_po DESC ";
		$results=$this->GlobalModel->QueryManual($sql);
		foreach($results as $row){
			$hasil[]=array(
				'id'=>$row['id_produksi_po'].'-'.$row['kode_po'],
				'text'=>$row['kode_po'].' '.$row['serian'],
			);
		}

		echo json_encode($hasil);
	}




}
