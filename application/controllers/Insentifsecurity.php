<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insentifsecurity extends CI_Controller {

	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->layout='newtheme/page/main';
		$this->page='newtheme/page/insentifsecurity/';
		$this->login 		= BASEURL.'login';
		$this->url 			= BASEURL.'Insentifsecurity/';
		$this->load->model('InsentifModel');
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

	function index(){
		$data    = [];
		$data['title'] = 'Insentif Security ';
		$data['products']=array();
		$data['url']=$this->url;
		$data['i']=1;
		$data['tambah']=$this->url.'kirimcmtadd';
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("Monday this week"));
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
		if(isset($get['sj'])){
			$sj=$get['sj'];
		}else{
			$sj=null;
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['cmt']=$cmt;
		$data['sj']=$sj;
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="JAHIT" ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM karyawan WHERE hapus=0 AND jabatan IN (10,46) ORDER BY nama ASC ');
		
		$data['karyawan']=[];
		$action=[];
		foreach($data['nosj'] as $n){
			$data['karyawan'][] = array(
				'id'	=> $n['id'],
				'nama'	=> $n['nama'],
				'products' => $this->InsentifModel->get($n['id'],$tanggal1,$tanggal2),
			);
		}
		// pre($data['karyawan']);
		$filter=array(
				'hapus'=>0,
		);

		if(empty($sj)){
			$data['products'][]=array(
				'no'=>'Mohon pilih karyawan',
				'id' => null,
				'tanggal'=>null,
				'nama'=>null,
				'shift'=>null,
				'action'=>$action,
				// 'dets'=>$dets,
			);
		}
		
		if(isset($get['excel'])){
			$this->load->view($this->page.'list_excel',$data);
		}else{
			$data['page']=$this->page.'list';
			$this->load->view($this->layout,$data);
		}
	}

	public function kirimcmtadd(){
		$data=array();
		$data['title']='Form Insentif Security';
		$data['url']=$this->url;
		$data['cancel']=$this->url;
		$data['action']=$this->url.'kirimcmtsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$data['pekerjaan']=$this->GlobalModel->getData('master_job',array('hapus'=>0,'jenis'=>1));
		$data['page']=$this->page.'kirimcmt_form';
		$data['kodepo']=$this->GlobalModel->getData('produksi_po',array('hapus'=>0));
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM karyawan WHERE hapus=0 AND jabatan IN (10,46) ORDER BY nama ASC ');
		$this->load->view($this->layout,$data);
		
	}

	public function kirimcmtsave(){
		$post=$this->input->post();
		// pre($post);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalpotongan=0;
		$jobprice=0;
		$masterpo=[];
		if(isset($post['tanggal'])){
			$insert=array(
				'tanggal'=>$post['tanggal'],
				'karyawan_id' => $post['karyawan_id'],
				'shift' => $post['shift'],
				'hapus'=>0,
			);
			$this->db->insert('insentifsecurity', $insert);
   			$id = $this->db->insert_id();
   			
   			$detail=array(
				'idint'=>$id,
				'tanggal'=>$post['tanggal'],
				'kedisiplinan'=>$post['kedisiplinan'],
				'kedisiplinan_pot'=>$post['kedisiplinan_pot'],
				'kebersihan'=>$post['kebersihan'],
				'kebersihan_pot'=>$post['kebersihan_pot'],
				'kontrol_vc'=>$post['kontrol_vc'],
				'kontrol_vc_pot'=>$post['kontrol_vc_pot'],
				'foto'=>$post['foto'],
				'foto_pot'=>$post['foto_pot'],
				'ketentuan'=>$post['ketentuan'],
				'ketentuan_pot'=>$post['ketentuan_pot'],
				'hapus'=>0,
			);
			$totalpotongan=($post['kedisiplinan_pot']+$post['kebersihan_pot']+$post['kontrol_vc_pot']+$post['foto_pot']+$post['ketentuan_pot']);
			$this->db->insert('insentifsecurity_detail',$detail);
			user_activity(callSessUser('id_user'),1,' input Insentif Security dengan id '.$id);
			$this->db->update('insentifsecurity',array('totalpotongan'=>$totalpotongan),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect($this->url);
			//pre($post);
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function kirimcmtview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['kembali']=$this->url.'';
		$data['cetak']=$this->url.'kirimcmtcetak/'.$id.'/1';
		// $data['excel']=$this->url.'kirimcmtcetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimbupot',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimbupot_detail',array('idkirim'=>$id,'hapus'=>0));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$k['kode_po']));
			$data['kirims'][]=array(
				'kode_po'=>$po['kode_po'].' '.$po['serian'],
				'rincian_po'=>$k['rincian_po'],
				'job'=>null,
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['page']=$this->page.'kirimcmt_view';
		$this->load->view($this->layout,$data);
	}

	public function kirimcmtcetak($id='',$type=''){
		$rincian=array();
		$data=array();
		$data['nota']='CMT';
		$data['no']=1;
		$data['alat']=null;
		$data['kirim']=$this->GlobalModel->getDataRow('kirimbupot',array('id'=>$id));
		// pre($data['kirim']);
		$data['kirims']=$this->GlobalModel->getData('kirimbupot_detail',array('hapus'=>0,'idkirim'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['alat']= $this->GlobalModel->getData('distribusi_alat_sukabumi',array('hapus'=>0,'nomorsj'=>$data['kirim']['nosj']));
		if($type==2){
			$pdf=false;
		}else{
			$pdf=true;
		}
		
		if($pdf==true){
			//$this->load->view('finishing/nota/nota-kirim-pdf',$viewData,true);
			
			$html =  $this->load->view($this->page.'/kirimcmt_pdf',$data,true);

			$this->load->library('pdfgenerator');
	        
	        // title dari pdf
	        $this->data['title_pdf'] = 'Surat Jalan Kirim Jahit';
	        
	        // filename dari pdf ketika didownload
	        $file_pdf = 'Surat_Jalan_Kirim_Jahit_'.time();
	        // setting paper
	        //$paper = 'A4';
	        $paper = array(0,0,800,800);
	        //orientasi paper potrait / landscape
	        $orientation = "potrait";
	        
			$this->load->view('laporan_pdf',$this->data, true);	    
	        
	        // run dompdf
	        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
		}else{
			if($type==1){
				//$this->load->view('produksi/kirimcmt_cetak',$data);
				$this->load->view('produksi/kirimcmt_pdf',$data);
			}else{
				$this->load->view('produksi/kirimcmt_excel',$data);
			}	
		}
		
		
	}	

	public function InsentifsecurityHapus($id)
	{
		// $this->GlobalModel->deleteData('user',array('id_user'=>$id));
		$this->db->update('insentifsecurity_detail',array('hapus'=>1),array('id'=>$id));
		user_activity(callSessUser('id_user'),1,' menghapus insentif dengan id '.$id);
		$this->session->set_flashdata('msg','Data Berhasil Di Hapus');
		redirect($this->url);
		
	}

	function rekap(){
		$post = $this->input->post();
		$no=1;
		$insentif=200000;
		$total=0;
		$kar= $this->GlobalModel->queryManual('SELECT * FROM karyawan WHERE hapus=0 AND jabatan IN (10,46) ORDER BY nama ASC ');
		echo '<form method="post" action="'.$this->url.'rekap_save">';
		echo '<table class="table table-bordered">';
		echo "<thead>";
		echo "<tr>";
		echo "<th>No</th>";
		echo "<th>Nama</th>";
		echo "<th>Insentif</th>";
		echo "<th>Potongan</th>";
		echo "<th>Uang Tambahan</th>";
		echo "<th>Total Yang Diterima</th>";
		echo "<th>Ket</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$no = 1;
		echo '<input type="hidden" name="tanggal1" class="form-control" value="'.$post['tanggal1'].'" readonly>';
		echo '<input type="hidden" name="tanggal2" class="form-control" value="'.$post['tanggal2'].'" readonly>';
		foreach($kar as $k){
			echo '<tr>';
			echo '<td>'.$no.' <input type="hidden" name="products['.$k['id'].'][karyawan_id]" class="form-control" value="'.$k['id'].'" readonly> </td>';
			echo '<td>'.$k['nama'].'</td>';
			echo '<td><input type="text" name="products['.$k['id'].'][insentif]" class="form-control" value="'.$insentif.'" readonly></td>';
			$potongan = $this->InsentifModel->totalpotongan($k['id'],$post['tanggal1'],$post['tanggal2']);
			echo '<td><input type="text" name="products['.$k['id'].'][potongan]" class="form-control" value="'.$potongan.'" readonly></td>';
			$uang_tambahan = $this->tambahan($potongan);
			echo '<td><input type="text" name="products['.$k['id'].'][uang_tambahan]" class="form-control" value="'.$uang_tambahan.'" readonly></td>';
			$total_diterima = $insentif - $potongan + $uang_tambahan;
			echo '<td><input type="text" name="products['.$k['id'].'][total_diterima]" class="form-control" value="'.$total_diterima.'" readonly></td>';
			echo '<td><input type="text" name="products['.$k['id'].'][keterangan]" class="form-control"></td>';
			echo '</tr>';
			$no++;
			$total += $total_diterima;
		}
		echo "</tbody>";
		echo "<tfoot>";
		echo "<tr>";
		echo "<td colspan='5' align='center'><b>Total</b></td>";
		echo '<td><b><input type="text" name="total" class="form-control" value="'.$total.'" readonly></b></td>';
		echo "<td></td>";
		echo "</tr>";
		echo "</tfoot>";
		echo '</table>';
		echo '<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;';
		echo '<a href="'.$this->url.'pdf/'.$post['tanggal1'].'/'.$post['tanggal2'].'" target="_blank" class="btn btn-warning">Print</a>';
		echo '</table>';
		echo '</form>';
	}

	function tambahan($total){
		$tambahan=0;
		if($total==0){
			$tambahan=100000;
		}
		return $tambahan;
	}

	function rekap_save(){
		$post=$this->input->post();
		
		$where = array(
			'tanggal1' => $post['tanggal1'],
			'tanggal2' => $post['tanggal2']
		);
		$this->db->delete('rekapinsentif_security',$where);
		foreach($post['products'] as $p){
			$insert = array(
				'tanggal1' 		=> $post['tanggal1'],
				'tanggal2' 		=> $post['tanggal2'],
				'karyawan_id' 	=> $p['karyawan_id'],
				'insentif' 		=> $p['insentif'],
				'potongan' 		=> $p['potongan'],
				'uang_tambahan' => $p['uang_tambahan'],
				'total_diterima'=> $p['total_diterima'],
			);
			$save =$this->db->insert('rekapinsentif_security',$insert);
		}

		
		if($save==true){
			$this->session->set_flashdata('msg','Data Berhasil Di Simpan');
		}else{
			$this->session->set_flashdata('gagal','Data Gagal Disimpan');
		}

		$url='';
		$url.="?&tanggal1=".$post['tanggal1']."&tanggal2=".$post['tanggal2']." ";

		redirect($this->url.$url);
	}

	public function pdf($tanggal1,$tanggal2) {
		$this->load->library('pdfgenerator');
	
		// Sample data retrieval
		$no = 1;
		$insentif = 200000;
		$total = 0;

		
		// Sample database query to retrieve employees
		$kar = $this->GlobalModel->queryManual('SELECT * FROM karyawan WHERE hapus=0 AND jabatan IN (10,46) ORDER BY nama ASC');
	
		// Start building the HTML content
		$html = '<center><h2>Rekap Penilaian Insentif Security</h2></center>';
		$html .= '<table border="1" style="width:100%; border-collapse:collapse;padding:5px">';
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<th>No</th>";
		$html .= "<th>Nama</th>";
		$html .= "<th>Insentif</th>";
		$html .= "<th>Potongan</th>";
		$html .= "<th>Uang Tambahan</th>";
		$html .= "<th>Total Yang Diterima</th>";
		$html .= "<th>Ket</th>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
	
		foreach ($kar as $k) {
			$potongan = $this->InsentifModel->totalpotongan($k['id'], $tanggal1, $tanggal2);
			$uang_tambahan = $this->tambahan($potongan);
			$total_diterima = $insentif - $potongan + $uang_tambahan;
	
			$html .= '<tr>';
			$html .= '<td align="center">' . $no . '</td>';
			$html .= '<td>&nbsp;' . $k['nama'] . '</td>';
			$html .= '<td align="center">' . number_format($insentif) . '</td>';
			$html .= '<td align="center">' . number_format($potongan) . '</td>';
			$html .= '<td align="center">' . number_format($uang_tambahan) . '</td>';
			$html .= '<td align="center">' . number_format($total_diterima) . '</td>';
			$html .= '<td></td>';
			$html .= '</tr>';
			$no++;
			if($total_diterima > 0){
				$total += $total_diterima;
			}
		}
	
		$html .= "</tbody>";
		$html .= "<tfoot>";
		$html .= "<tr>";
		$html .= "<td colspan='5' align='center'><b>Total</b></td>";
		$html .= '<td align="center"><b>' . number_format($total) . '</b></td>';
		$html .= "<td></td>";
		$html .= "</tr>";
		$html .= "</tfoot>";
		$html .= '</table>';

		// Additional content below the table
		$html .= '<div style="margin-top: 20px; text-align: left; padding-left:500px;">'; // Changed to left alignment with padding
		$html .= 'Jakarta, ' . date('d F Y', strtotime($tanggal2 . ' +1 day')) . ' <br>';
		$html .= '</div>';
		$html .= '<div style="margin-top: 20px; text-align: left; padding-left: 300px;">';
		$html .= '<div style="margin-top: 20px;">'; // Add some margin to the top
		$html .= '<table style="width: 100%; border: none;">'; // No border for this table
		$html .= '<tr>';
		$html .= '<td style="text-align: center;">Disetujui Oleh:<br>SPV</td>'; // Left side
		$html .= '<td style="text-align: center;">Dibuat Oleh:<br>Adm Keu</td>'; // Right side
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td style="text-align: center;"><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>';
		$html .= '<td style="text-align: center;"><br><br><br>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '</div>';
		// Footer
		$html .= '<div style="position: absolute; bottom: 0; width: 100%; text-align: left;font-size:13px;">';
		$html .= '<i class="registered">Registered by Forboys Production System ' . date('d-m-Y H:i:s') . '</i>';
		$html .= '</div>';


		
		// pre($html);
		// Prepare PDF parameters
		$file_pdf = 'rekap_insentif_karyawan_' . date('YmdHis') . '.pdf'; // PDF file name
		$paper = 'A4'; // Paper size
		$orientation = 'portrait'; // Orientation
	
		// Run the pdf generator
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}
	
}