<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller {

	function __construct() {
		parent::__construct();
		sessionLogin(URLPATH."\\".$this->uri->segment(1));
		session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->page='newtheme/page/';
	}

	public function Gudang(){
		$data=[];
		$data['title']='Gaji Karyawan Gudang Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('Monday last week'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 AND bagian LIKE 'GUDANG%' ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'bagian'=>'Gudang',
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Gaji/gudangdetail/'.$r['id'],
				'hapus'=>BASEURL.'Gaji/pressqchapus/'.$r['id'],
				'excel'=>BASEURL.'Gaji/gudangdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/gudang_add';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/pressqc';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function gudangdetail($id){
		$data=[];
		$data['title']='Gaji Karyawan Gudang Forboys';
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>round($gaji['gaji']/12*$d['senin']),
					'selasa'=>round($gaji['gaji']/12*$d['selasa']),
					'rabu'=>round($gaji['gaji']/12*$d['rabu']),
					'kamis'=>round($gaji['gaji']/12*$d['kamis']),
					'jumat'=>round($gaji['gaji']/12*$d['jumat']),
					'sabtu'=>round($gaji['gaji']/12*$d['sabtu']),
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
					'claim'=>$d['claim'],
					'pinjaman'=>$d['pinjaman'],
				);
			}
		}
		$data['kembali']=BASEURL.'Gaji/gudang';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/finishing_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function gudang_add(){
		$data=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Tambah Gaji Karyawan Gudang ';
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		//$data['harian']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0,'tipe'=>1));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE hapus=0 and tipe=1 AND lower(bagian) LIKE '%gudang%' ");
		foreach($results as $r){
			$lembur=$this->GlobalModel->QueryManualRow("SELECT SUM(jml_jam*upah) as total FROM lembur_harian WHERE hapus=0 AND idkaryawan='".$r['id']."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
			$data['harian'][]=array(
				'id'=>$r['id'],
				'nama'=>$r['nama'],
				'gaji'=>$r['gaji'],
				'bagian'=>$r['bagian'],
				'lembur'=>!empty($lembur)?$lembur['total']:0,
			);
		}
		$data['action']=BASEURL.'Gaji/gudang_save';
		$data['page']=$this->page.'finishing/gaji_finishing';
		$this->load->view($this->page.'main',$data);
	}

	public function gudang_save(){
		$data=$this->input->post();
		//pre($data);
		$cek=$this->GlobalModel->getDataRow('gaji_finishing',array('tanggal1'=>$data['tanggal1'],'bagian'=>'GUDANG'));
		//pre($data);
		if(!empty($cek)){
			$this->session->set_flashdata('msgt','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Finishing/gajifinishing');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'bagian'=>'GUDANG',
			'hapus'=>0,
		);
		$this->db->insert('gaji_finishing',$insert);
		$id=$this->db->insert_id();
		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){
				$detail=array(
					'idgaji'=>$id,
					'idkaryawan'=>$p['idkaryawan'],
					'nama'=>$p['nama'],
					'senin'=>isset($p['senin'])?$p['seninjamkerja']:0,
					'selasa'=>isset($p['selasa'])?$p['selasajamkerja']:0,
					'rabu'=>isset($p['rabu'])?$p['rabujamkerja']:0,
					'kamis'=>isset($p['kamis'])?$p['kamisjamkerja']:0,
					'jumat'=>isset($p['jumat'])?$p['jumatjamkerja']:0,
					'sabtu'=>isset($p['sabtu'])?$p['sabtujamkerja']:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lemburs'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
				);
				$this->db->insert('gaji_finishing_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Gaji/gudang');
	}

	public function pressqc(){
		$data=[];
		$data['title']='Gaji Press & QC Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('first day of this month'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime('last day of this month'));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' AND bagian='PRESSQC' ";
		$sql.=" ORDER BY id DESC";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'bagian'=>'Harian '.$r['bagian'],
				'detail'=>BASEURL.'Gaji/pressqcdetail/'.$r['id'],
				'hapus'=>BASEURL.'Gaji/pressqchapus/'.$r['id'],
				'excel'=>BASEURL.'Gaji/pressqcdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/pressqcadd';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/pressqc';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function pressqcadd(){
		$data=array();
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
		}

		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['title']='Tambah Gaji Press dan QC Finishing';
		$lembur=0;
		$data['karyawan']=$this->GlobalModel->getData('karyawan_harian',array('hapus'=>0));
		$results=$this->GlobalModel->QueryManual("SELECT * FROM karyawan_harian WHERE hapus=0 and tipe=1 AND bagian LIKE 'QC%' OR bagian LIKE '%PRESS%' ");
		foreach($results as $r){
			$lembur=$this->GlobalModel->QueryManualRow("SELECT SUM(jml_jam*upah) as total FROM lembur_harian WHERE hapus=0 AND idkaryawan='".$r['id']."' AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ");
			$data['harian'][]=array(
				'id'=>$r['id'],
				'nama'=>$r['nama'],
				'gaji'=>$r['gaji'],
				'bagian'=>$r['bagian'],
				'lembur'=>!empty($lembur)?$lembur['total']:0,
			);
		}
		//pre($data['harian']);
		$data['action']=BASEURL.'Gaji/pressqcsave';
		$data['page']=$this->page.'finishing/gaji_finishing';
		$this->load->view($this->page.'main',$data);
	}

	public function pressqcsave(){
		$data=$this->input->post();
		$cek=$this->GlobalModel->getDataRow('gaji_finishing',array('tanggal1'=>$data['tanggal1'],'hapus'=>0,'bagian'=>'PRESSQC'));
		//pre($data);
		if(!empty($cek)){
			$this->session->set_flashdata('msgt','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Gagal Di Simpan, karna sudah pernah dibuat. Silahkan pilih periode lainnya');
			redirect(BASEURL.'Gaji/pressqcadd');	
		}
		$insert=array(
			'tanggal1'=>$data['tanggal1'],
			'tanggal2'=>$data['tanggal2'],
			'bagian'=>'PRESSQC',
			'hapus'=>0,
		);
		$this->db->insert('gaji_finishing',$insert);
		$id=$this->db->insert_id();
		// 24 September 2022, Perhitungan gaji dihitung dari jam kerjanya GH/12*Jam Kerja
		foreach($data['products'] as $p){
			if(isset($p['idkaryawan'])){
				$detail=array(
					'idgaji'=>$id,
					'idkaryawan'=>$p['idkaryawan'],
					'nama'=>$p['nama'],
					'senin'=>isset($p['senin'])?$p['seninjamkerja']:0,
					'selasa'=>isset($p['selasa'])?$p['selasajamkerja']:0,
					'rabu'=>isset($p['rabu'])?$p['rabujamkerja']:0,
					'kamis'=>isset($p['kamis'])?$p['kamisjamkerja']:0,
					'jumat'=>isset($p['jumat'])?$p['jumatjamkerja']:0,
					'sabtu'=>isset($p['sabtu'])?$p['sabtujamkerja']:0,
					'minggu'=>isset($p['minggu'])?1:0,
					'lembur'=>isset($p['lemburs'])?$p['lemburs']:0,
					'insentif'=>isset($p['insentif'])?1:0,
					'claim'=>$p['claim'],
					'pinjaman'=>$p['pinjaman'],
				);
				$this->db->insert('gaji_finishing_detail',$detail);
			}
		}
		$this->session->set_flashdata('msg','Data Gaji Periode '.date('d F Y',strtotime($data["tanggal1"])).' s.d '.date('d F Y',strtotime($data["tanggal2"])).' Berhasil Di Simpan');
		redirect(BASEURL.'Gaji/pressqc');
	}

	public function pressqchapus($id){
		$update=array(
			'hapus'=>1
		);
		$where=array(
			'id'=>$id
		);
		$this->db->update('gaji_finishing',$update,$where);
		$this->session->set_flashdata('msg',' Berhasil Di Hapus');
		redirect(BASEURL.'Gaji/pressqc');
	}

	public function pressqcdetail($id){
		$data=[];
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['title']='Resume Gaji Karyawan Finishing Forboys';
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		// 24 September 2022, Perhitungan gaji dihitung dari jam kerjanya GH/12*Jam Kerja
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>round($gaji['gaji']/12*$d['senin']),
					'selasa'=>round($gaji['gaji']/12*$d['selasa']),
					'rabu'=>round($gaji['gaji']/12*$d['rabu']),
					'kamis'=>round($gaji['gaji']/12*$d['kamis']),
					'jumat'=>round($gaji['gaji']/12*$d['jumat']),
					'sabtu'=>round($gaji['gaji']/12*$d['sabtu']),
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
					'claim'=>$d['claim'],
					'pinjaman'=>$d['pinjaman'],
				);
			}
		}
		$data['kembali']=BASEURL.'Gaji/pressqc';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/finishing_detail';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function slip($id){
		$data=[];
		$data['title']='Slip Gaji Karyawan';
		$data['slip']=$this->GlobalModel->getDataRow('gaji_bulanan',array('id'=>$id));
		$nama=$this->GlobalModel->getDataRow('karyawan',array('id'=>$data['slip']['idkaryawan']));
		$data['nama']=$nama['nama'];
		$data['nik']=$nama['nik'];
		$bagian=$this->GlobalModel->getDataRow('jabatan',array('id'=>$nama['jabatan']));
		$data['bagian']=$bagian['nama'];
		$divisi=$this->GlobalModel->getDataRow('divisi',array('id'=>$nama['divisi']));
		$data['divisi']=$divisi['nama'];
		$data['batal']=BASEURL.'Gaji/bulanan';
		$data['page']=$this->page.'gaji/slip';
		$this->load->view($this->page.'main',$data);
	}

	public function bulanan(){
		$data=[];
		$data['title']='Gaji Bulanan Karyawan ';
		$data['gaji']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;

		$sql="SELECT * FROM gaji_bulanan WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$karyawan=$this->GlobalModel->getDataRow('karyawan',array('id'=>$r['idkaryawan']));
			$data['gaji'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tanggal'=>date('d F Y',strtotime($r['tanggal'])),
				'periode'=>strtolower($r['periode']),
				'nama'=>strtolower($karyawan['nama']),
				'total'=>($r['total']),
				'slip'=>BASEURL.'Gaji/Slip/'.$r['id'],
			);
			$no++;
		}
		$data['akseshapus']=akseshapus();
		$data['hapus']=BASEURL.'Gaji/hapusgaji/';
		$data['tambah']=BASEURL.'Gaji/bulananadd';
		
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/bulanan_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/bulanan';
			$this->load->view($this->page.'main',$data);
		}
	}

	public function bulananadd(){
		$data=[];
		$data['title']='Input Slip Gaji';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['karyawans']=$this->GlobalModel->getData('karyawan',array('hapus'=>0));
		$data['page']=$this->page.'gaji/slipform';
		$data['action']=BASEURL.'Gaji/slipsave';
		$data['batal']=BASEURL.'Gaji/bulanan';
		$this->load->view($this->page.'main',$data);
	}

	public function slipsave(){
		$data=$this->input->post();
		if(isset($data['idpinjaman'])){
			$cek=$this->GlobalModel->getDataRow('pinjaman_karyawan',array('id'=>$data['idpinjaman']));
			if($cek['totalpinjaman']==$cek['totalpotongan']){
				$status=3;
			}else{
				$insertpotongan=array(
					'tanggal'=>$data['tanggal'],
					'idkaryawan'=>$data['idkaryawan'],
					'idpinjaman'=>$data['idpinjaman'],
					'totalpotongan'=>$data['potongan_pinjaman'],
					'keterangan'=>'Potongan pinjaman tanggal '.$data['tanggal'],
					'hapus'=>0,
				);
				$this->db->insert('potongan_pinjaman_karyawan',$insertpotongan);
				$this->db->query("UPDATE pinjaman_karyawan set totalpotongan=totalpotongan+'".$data['potongan_pinjaman']."' WHERE id='".$data['idpinjaman']."' ");
				$cek2=$this->GlobalModel->getDataRow('pinjaman_karyawan',array('id'=>$data['idpinjaman']));
				if($cek2['totalpinjaman']==$cek2['totalpotongan']){
					$status=3;
				}else{
					$status=2;
				}
				$this->db->query("UPDATE pinjaman_karyawan set status='".$status."' WHERE id='".$data['idpinjaman']."' ");
			}
		}
		//pre($data);
		$insert=array(
			'tanggal'=>$data['tanggal'],
			'periode'=>date('Y-m-d',strtotime("first day of this month")).''.date('Y-m-d',strtotime("last day of this month")),
			'idkaryawan'=>$data['idkaryawan'],
			'gajipokok'=>$data['gajipokok'],
			'potongan_kasbon'=>$data['potongan_kasbon'],
			'potongan_pinjaman'=>$data['potongan_pinjaman'],
			'potongan_claim'=>$data['potongan_claim'],
			'bonus'=>$data['bonus'],
			'thr'=>$data['thr'],
			'subtotal'=>$data['subtotal'],
			'total'=>$data['total'],
			'keterangan'=>'Gaji Periode '.date('Y-m-d',strtotime("first day of this month")).''.date('Y-m-d',strtotime("last day of this month")),
			'hapus'=>0,
		);
		$this->db->insert('gaji_bulanan',$insert);
		$this->session->set_flashdata('msg','Data berhasil disimpan');
		redirect(BASEURL.'Gaji/bulanan');
	}

	public function hapusgaji($id){
		$this->db->update('gaji_bulanan',array('hapus'=>1),array('id'=>$id));
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		redirect(BASEURL.'Gaji/bulanan');
	}

	public function getkasbon(){
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		$sql="SELECT * FROM kasbon WHERE idkaryawan='".$get['idkaryawan']."'  ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id ASC ";
		$kasbon=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$total=0;
		if(!empty($kasbon)){
			foreach($kasbon as $k){
				echo "<tr>";
				echo "<td>".$no++."</td>";
				echo "<td>".date('d F Y',strtotime($k['tanggal']))."</td>";
				echo "<td>Rp.".number_format($k['nominal_request'])."</td>";
				echo "</tr>";
				$total+=($k['nominal_request']);
			}
			echo "<tr>";
			echo '<td></td>';
			echo '<td>Total</td>';
			echo '<td>Rp.'.number_format($total).'</td>';
			echo "</tr>";
		}else{
			echo "<tr>";
			echo '<td colspan="3">Tidak ada rincian kasbon</td>';
			echo "</tr>";
		}
	}

	public function getsumkasbon(){
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		$sql="SELECT * FROM kasbon WHERE idkaryawan='".$get['idkaryawan']."'  ";
		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql.=" ORDER BY id ASC ";
		$kasbon=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$total=0;
		foreach($kasbon as $k){
			$total+=($k['nominal_request']);
		}
		echo $total;
	}

	public function getpinjaman(){
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("first day of this month"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("last day of this month"));
		}
		//$sql="SELECT * FROM potongan_pinjaman_karyawan WHERE idkaryawan='".$get['idkaryawan']."' and hapus=0 ";
		//$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$sql="SELECT * FROM pinjaman_karyawan WHERE idkaryawan='".$get['idkaryawan']."' and hapus=0 ";
		$sql.=" ORDER BY id ASC ";
		$pinj=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$pinjaman=null;
		$sisa=0;
		if(!empty($pinj)){
			foreach($pinj as $k){
				$sisa=($k['totalpinjaman']-$k['totalpotongan']);
				if($sisa>0){
					echo "<tr>";
					echo "<td>".$no++." <input type='hidden' name='idpinjaman' value='".$k['id']."'/></td>";
					echo "<td>".date('d F Y',strtotime($k['tanggal']))."</td>";
					echo "<td>Rp.".number_format($k['totalpinjaman'])."</td>";
					echo "<td>Rp.".number_format($k['totalpinjaman']-$k['totalpotongan'])."</td>";
					echo "<td>".strtolower($k['keterangan'])."</td>";
					echo "</tr>";
				}else{
					echo "<tr>";
					echo "<td colspan='5'>Tidak ada rincian pinjaman</td>";
					echo "</tr>";
				}
			}
		}else{
			echo "<tr>";
			echo "<td colspan='5'>Tidak ada rincian pinjaman</td>";
			echo "</tr>";
		}
	}

	public function getkaryawan(){
		$get=$this->input->get();
		$gaji=$this->GlobalModel->getDataRow('karyawan',array('id'=>$get['idkaryawan']));
		echo $gaji['gajipokok'];
	}

	public function operatorbordir(){
		$data=[];
		$data['title']='Resume Gaji Karyawan operator Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('Monday last week'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM gaji_operator WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'tempat'=>$r['tempat']==1?'Rumah':'Cipadu',
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Gaji/operatorbordirdetail/'.$r['id'],
				'excel'=>BASEURL.'Bordir/operatorbordirdetail/'.$r['id'].'?&excel=1',
				'hapus'=>BASEURL.'Bordir/hapusgajioperator/'.$r['id'],
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tambah']=BASEURL.'Gaji/operatorbordir';
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/operatorbordir_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/bordirlist';
			$this->load->view($this->page.'main',$data);
		}	
		
	}

	public function operatorbordirdetail($id){
		$data=[];
		$data['karyawans']=[];
		$details=[];
		$data['title']='Resume Gaji Karyawan Bordir Forboys';
		$data['karyawans']=[];
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_operator',array('hapus'=>0,'id'=>$id));
		$bonussiang=0;
		$bonusmalam=0;
		$umsiang=0;
		$ummalam=0;
		if(!empty($data['gaji'])){
			
			$results=$this->GlobalModel->getData('gaji_operator_new',array('hapus'=>0,'idgajiopt'=>$id));
			foreach($results as $r){
				$data['karyawans'][]=array(
					'tgl1'=>$data['gaji']['tanggal1'],
					'tgl2'=>$data['gaji']['tanggal2'],
					'idkaryawan' =>$r['idkaryawan'],
					'nama'=>$r['nama'],
					'totalgaji'=>$r['totalgaji'],
					'totalbonus'=>$r['totalbonus'],
					'totalum'=>$r['totalum'],
					'grandtotal'=>$r['grandtotal'],
					'details'=>$this->GlobalModel->getData('gaji_operator_detail_new',array('hapus'=>0,'idgaji'=>$r['id'])),
				);
			}
			//pre($data['karyawans']);
			$bonussiang=$this->ReportModel->SumBonusOptBordir($id,1);
			$bonusmalam=$this->ReportModel->SumBonusOptBordir($id,2);
			$umsiang=$this->ReportModel->SumUmOptBordir($id,1);
			$ummalam=$this->ReportModel->SumUmOptBordir($id,2);
			$data['bonussiang']=$bonussiang;
			$data['bonusmalam']=!empty($bonusmalam)?$bonusmalam:0;
			//$data['umsiang']=$umsiang;
			$data['umsiang']=0;
			$data['ummalam']=!empty($ummalam)?21000:0;
		}
		$data['kembali']=BASEURL.'Bordir/gajioperator';
		$data['excel']=BASEURL.'Bordir/operatorbordirdetail/'.$id.'?&excel=1';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/operatorbordir_excel_new',$data);
		}else{
			$data['page']=$this->page.'gaji/operatorbordir_detail_new';
			$this->load->view($this->page.'main',$data);
		}
		
	}

	public function finishing(){
		$data=[];
		$data['title']='Resume Gaji Karyawan Finishing Forboys';
		$data['products']=[];
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime('Monday last week'));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("Sunday this week"));
		}
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		foreach($results as $r){
			$data['products'][]=array(
				'no'=>$no,
				'id'=>$r['id'],
				'periode'=> date('d F Y',strtotime($r['tanggal1'])) .' sd '.date('d F Y',strtotime($r['tanggal2'])),
				'detail'=>BASEURL.'Gaji/finishingdetail/'.$r['id'],
				'excel'=>BASEURL.'Gaji/finishingdetail/'.$r['id'].'?&excel=1',
			);
			$no++;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/finishing';
			$this->load->view($this->page.'main',$data);
		}
		
	}

	public function finishingdetail($id){
		$data=[];
		$data['karyawans']=[];
		$data['total']=0;
		$details=[];
		$data['title']='Resume Gaji Karyawan Finishing Forboys';
		$data['gaji']=$this->GlobalModel->getDataRow('gaji_finishing',array('hapus'=>0,'id'=>$id));
		if(!empty($data['gaji'])){
			$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$id));
			$gaji=0;
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$data['karyawans'][]=array(
					'idkaryawan'=>$d['idkaryawan'],
					'nama'=>strtolower($d['nama']),
					'senin'=>$d['senin']==1?$gaji['gaji']:0,
					'selasa'=>$d['selasa']==1?$gaji['gaji']:0,
					'rabu'=>$d['rabu']==1?$gaji['gaji']:0,
					'kamis'=>$d['kamis']==1?$gaji['gaji']:0,
					'jumat'=>$d['jumat']==1?$gaji['gaji']:0,
					'sabtu'=>$d['sabtu']==1?$gaji['gaji']:0,
					'minggu'=>$d['minggu']==1?$gaji['gaji']:0,
					'lembur'=>$d['lembur']>0?$d['lembur']:0,
					'insentif'=>$d['insentif']==1?$gaji['gaji']:0,
				);
			}
		}
		$data['kembali']=BASEURL.'Gaji/finishing';
		$get=$this->input->get();
		if(isset($get['excel'])){
			$this->load->view($this->page.'gaji/finishing_excel',$data);
		}else{
			$data['page']=$this->page.'gaji/finishing_detail';
			$this->load->view($this->page.'main',$data);
		}
	}
}