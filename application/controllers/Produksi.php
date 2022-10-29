<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi extends CI_Controller {


	function __construct() {

		parent::__construct();

		//sessionLogin(URLPATH."\\".$this->uri->segment(1));

		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');

	}

	public function kirimcmt(){
		$data=array();
		$data['products']=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Produksi/kirimcmt';
		$data['i']=1;
		$data['tambah']=BASEURL.'Produksi/kirimcmtadd/';
			$filter=array(
				'hapus'=>0,
			);
		$results=array();
		$results= $this->GlobalModel->queryManual('SELECT * FROM kirimcmt ORDER BY id DESC ');
		$namacmt=null;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL.'Produksi/kirimcmtview/'.$result['id'].'/'.$result['kode_po'],
			);

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			
			$data['products'][]=array(
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d/m/Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalkirim'],
				'namacmt'=>$namacmt['cmt_name'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
			);
		}
		
		$this->load->view('produksi/kirimcmt_list',$data);
		$this->load->view('global/footer');
	}

	public function kirimcmtadd(){
		$data=array();
		$data['url']=BASEURL.'Produksi/kirimcmt';
		$data['action']=BASEURL.'Produksi/kirimcmtsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(1) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$this->load->view('global/header');
		$this->load->view('produksi/kirimcmt_form',$data);
		$this->load->view('global/footer');
	}

	public function kirimcmtsave(){
		$post=$this->input->post();
		//pre($post);
		$po=implode(",", $post['namaPo']);
		$rowpo=count($post['namaPo']);
		$atas=array();
		$bawah=array();
		$totalatas=0;
		$totalbawah=0;
		$totalkirim=0;
		if(isset($post['tanggal'])){
			$job=explode("-",$post['cmtJob']);
			$cmt=explode('-', $post['cmtName']);
			$insert=array(
				'tanggal'=>$post['tanggal'],
				'kode_po'=>$po,
				'totalkirim'=>0,
				'cmtkat'=>$post['cmtKat'],
				'idcmt'=>$cmt[0],
				'cmtkat'=>$post['cmtKat'],
				'cmtjob'=>$job[0],
				'status'=>0,
				'keterangan'=>$post['keterangan'],
				'dibuat'=>date('Y-m-d H:i:s'),
				'hapus'=>0,
			);
			$this->db->insert('kirimcmt', $insert);
   			$id = $this->db->insert_id();
   			for($i=0;$i<$rowpo;$i++){
   				// cek pengecekan potongan
   				$pp=$this->GlobalModel->getData('kelolapo_pengecekan_potongan',array('kode_po'=>$post['namaPo'][$i]));
   				foreach($pp as $a){
   						$insertkirimcmt_po=array(
		   					'idkirim'=>$id,
		   					'kode_po'=>$a['kode_po'],
		   					'quantity'=>$a['jumlah_total_potongan'],
		   				);
	   				$this->db->insert('kirimcmt_po',$insertkirimcmt_po);
   				}
	   			$atas = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$post['namaPo'][$i]));
	   			if(!empty($atas)){
	   				foreach($atas as $a){
	   					$totalatas+=$a['jumlah_potongan'];
	   					$ia=array(
	   						'idkirim'=>$id,
	   						'idpengecekan'=>$a['id_kelolapo_pengecekan_potongan'],
	   						'qty'=>$a['jumlah_potongan'],
	   					);
	   					$this->db->insert('kirimcmt_detailatas',$ia);
	   				}
	   			}
	   			$bawah = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$post['namaPo'][$i]));
	   			if(!empty($bawah)){
	   				foreach($bawah as $b){
	   					$totalbawah+=$b['jumlah_potongan'];
	   					$ib=array(
	   						'idkirim'=>$id,
	   						'idpengecekan'=>$b['id_kelolapo_pengecekan_potongan'],
	   						'qty'=>$b['jumlah_potongan'],
	   					);
	   					$this->db->insert('kirimcmt_detailbawah',$ib);
	   				}
	   			}
	   			$this->db->update('produksi_po',array('id_proggresion_po'=>7,'progress_lokasi'=>'KIRIM-CMT'),array('kode_po'=>$post['namaPo'][$i]));
	   			$this->db->update('konveksi_buku_potongan',array('status'=>2),array('kode_po'=>$post['namaPo'][$i]));
	   		}
	   		$nosj='SJFB'.'-'.date('Y-m').'-'.$id;
	   		$this->db->update('kirimcmt',array('totalkirim'=>$totalatas+$totalbawah,'nosj'=>$nosj),array('id'=>$id));
   			$this->session->set_flashdata('msg','Data berhasil disimpan');
			redirect(BASEURL.'Produksi/kirimcmt');
		}else{
			echo "Gagal. Tanggal kirim harus diisi";
		}
	}

	public function kirimcmtview($id='',$kodepo=''){
		/*
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		for($i=0;$i<$row;$i++){
			$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('kode_po'=>$toarray[$i]));
			$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
			$data['atasan']=$this->GlobalModel->queryManual("SELECT kda.*,kpa.* FROM kirimcmt_detailatas kda JOIN kelolapo_pengecekan_potongan_atas kpa ON(kpa.id_kelolapo_pengecekan_potongan=kda.idpengecekan) WHERE kpa.kode_po='$toarray[$i]' ");
			$data['bawahan']=$this->GlobalModel->queryManual("SELECT kda.*,kpa.* FROM kirimcmt_detailbawah kda JOIN konveksi_buku_potongan_variasi kpa ON(kpa.id_potongan_utama=kda.idpengecekan) WHERE kpa.kode_po='$toarray[$i]' ");
		}
		*/
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['cetak']=BASEURL.'Produksi/kirimcmtcetak/'.$id.'/'.$kodepo;
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		for($i=0;$i<$row;$i++){
			$results[]=$this->GlobalModel->queryManual("SELECT pp.kode_po,kpp.jumlah_total_potongan as qty FROM produksi_po pp join  kelolapo_pengecekan_potongan kpp on(kpp.kode_po=pp.kode_po) WHERE pp.kode_po='$toarray[$i]' ");
			$data['bawahan']=$this->GlobalModel->queryManual("SELECT kda.*,kpa.* FROM kirimcmt_detailbawah kda JOIN konveksi_buku_potongan_variasi kpa ON(kpa.id_potongan_utama=kda.idpengecekan) WHERE kpa.kode_po='$toarray[$i]' ");
		}
		$rpo=array();
		foreach($results as $r){
			foreach($r as $t){
				$rpo=$this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$t['kode_po']));
				$data['kirims'][]=array(
					'kode_po'=>$t['kode_po'],
					'qty'=>$t['qty'],
					'rpo'=>$rpo,
				);
			}
		}
		//pre($data['kirims']);
		// foreach($rincian as $po){
		// 	$rinci=array();
		// 	$rinci=$this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$po['kode_po']));
		// 	foreach($rinci as $r){
		// 		$rincinya[]=$r['bagian_potongan_atas'];
		// 		$keterangan[]=$r['keterangan_potongan'];
		// 		$jml[]=$r['jumlah_potongan'];
		// 	}
		// 	$data['atasan'][]=array(
		// 		'kode_po'=>$po['kode_po'],
		// 		'rinci'=>implode(",", $rincinya),
		// 		'qty'=>$po['qty'],
		// 		'keterangan'=>implode(",", $keterangan),
		// 	);
		// }
		//pre($rincian);
		$this->load->view('global/header');
		$this->load->view('produksi/kirimcmt_view',$data);
		$this->load->view('global/footer');
	}

	public function kirimcmtcetak($id='',$kodepo=''){
		/*
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		for($i=0;$i<$row;$i++){
			$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('kode_po'=>$toarray[$i]));
			$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
			$data['atasan']=$this->GlobalModel->queryManual("SELECT kda.*,kpa.* FROM kirimcmt_detailatas kda JOIN kelolapo_pengecekan_potongan_atas kpa ON(kpa.id_kelolapo_pengecekan_potongan=kda.idpengecekan) WHERE kpa.kode_po='$toarray[$i]' ");
			$data['bawahan']=$this->GlobalModel->queryManual("SELECT kda.*,kpa.* FROM kirimcmt_detailbawah kda JOIN konveksi_buku_potongan_variasi kpa ON(kpa.id_potongan_utama=kda.idpengecekan) WHERE kpa.kode_po='$toarray[$i]' ");
		}
		*/
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$rincian=array();
		$data=array();
		$data['no']=1;
		$data['cetak']=BASEURL.'Produksi/kirimcmtcetak/'.$id.'/'.$kodepo;
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		for($i=0;$i<$row;$i++){
			$results[]=$this->GlobalModel->queryManual("SELECT pp.kode_po,kpp.jumlah_total_potongan as qty FROM produksi_po pp join  kelolapo_pengecekan_potongan kpp on(kpp.kode_po=pp.kode_po) WHERE pp.kode_po='$toarray[$i]' ");
			$data['bawahan']=$this->GlobalModel->queryManual("SELECT kda.*,kpa.* FROM kirimcmt_detailbawah kda JOIN konveksi_buku_potongan_variasi kpa ON(kpa.id_potongan_utama=kda.idpengecekan) WHERE kpa.kode_po='$toarray[$i]' ");
		}
		$rpo=array();
		foreach($results as $r){
			foreach($r as $t){
				$rpo=$this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$t['kode_po']));
				$data['kirims'][]=array(
					'kode_po'=>$t['kode_po'],
					'qty'=>$t['qty'],
					'rpo'=>$rpo,
				);
			}
		}
		//pre($rinci);
		//$this->load->view('global/header');
		$this->load->view('produksi/kirimcmt_cetak',$data);
		//$this->load->view('global/footer');
	}

	public function setorcmt(){
		$data=array();
		$data['tambah']=BASEURL.'Produksi/setorcmtadd';
		$this->load->view('global/header');
		$this->load->view('setorcmt/list',$data);
		$this->load->view('global/footer');
	}

	public function setorcmtadd(){
		$data=array();
		$data['url']=BASEURL.'Produksi/setorcmt';
		$data['action']=BASEURL.'Produksi/setorcmtsave';
		$data['progress'] = $this->GlobalModel->queryManual('SELECT * FROM master_progress WHERE id_progress IN(3) ');
		$data['po']=$this->GlobalModel->queryManual('SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE progress_lokasi="PENGECEKAN" ');
		$data['sj']=$this->GlobalModel->queryManual("SELECT * FROM kirimcmt WHERE hapus=0");

		$this->load->view('global/header');
		$this->load->view('setorcmt/add',$data);
		$this->load->view('global/footer');
	}

	public function setorcmtsave(){
		$data = $this->input->post();
		$excmt=explode('-', $data['cmtName']);
		$sj=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$data['sj']));
		$jobprice=$this->GlobalModel->getDataRow('master_cmt_job',array('cmt_job_parent'=>$excmt[0],'id_master_cmt_job'=>$sj['cmtjob']));
		$jml_setor_qty=0;
		$pcs_setor_qty=0;
		$bangke_qty=0;
		$barang_claim_qty=0;
		$barang_hilang_qty=0;
		$jumlah_piece_diterima=0;
		$barang_cacad_qty=0;
		//pre($data);
		if(isset($data['po'])){
			foreach($data['po'] as $po){
				if(isset($po['pilih'])){
					$insert=array(
						'create_date'=>date('Y-m-d H:i:s'),
						'kode_po'=>$po['kode_po'],
						'kode_nota_cmt'=>$sj['nosj'],
						'progress'=>'SETOR',
						'kategori_cmt'=>$data['cmtKat'],
						'id_master_cmt'=>$excmt[0],
						'id_master_cmt_job'=>$sj['cmtjob'],
						'cmt_job_price'=>$jobprice['cmt_job_price'],
						'nama_cmt'=>$excmt[1],
						'qty_tot_pcs'=>0,
						'qty_tot_atas'=>0,
						'qty_tot_bawah'=>0,
						'keterangan'=>'',
						'status'=>1,
						'jml_barang'=>0,
						'qty_bangke'=>0,
						'qty_reject'=>0,
						'qty_hilang'=>0,
						'qty_claim'=>0,
						'status_keu'=>0,
					);
					//$this->db->insert('kelolapo_kirim_setor',$insert);
					if(isset($data['products'])){
						foreach($data['products'] as $p){
							if(isset($p['pilih'])){
								$jml_setor_qty+=($p['jmlAtas']);
								$pcs_setor_qty+=($p['jmlAtas']);
								$bangke_qty+=($p['qtyBankeAtas']);
								$barang_cacad_qty+=($p['qtyRejectAtas']);
								$barang_claim_qty+=($p['qtyClaimAtas']);
								$barang_hilang_qty+=($p['qtyHilangAtas']);
							}
						}
					}
					$insertsetoran=array(
						'kode_po' =>$po['kode_po'],
						'jml_setor_qty'=>$jml_setor_qty-$bangke_qty-$barang_cacad_qty-$barang_hilang_qty-$barang_claim_qty,
						'pcs_setor_qty'=>$jml_setor_qty-$bangke_qty-$barang_cacad_qty-$barang_hilang_qty-$barang_claim_qty,
						'bangke_qty'=>$bangke_qty,
						'barang_cacad_qty'=>$barang_cacad_qty,
						'nama_cmt'=>$excmt[1],
						'created_date'=>date('Y-m-d H:i:s'),
						'barang_claim_qty'=>$barang_claim_qty,
						'barang_hilang_qty'=>$barang_hilang_qty,
						'jumlah_piece_diterima'=>$jml_setor_qty-$bangke_qty-$barang_cacad_qty-$barang_hilang_qty-$barang_claim_qty,
					);
					$this->db->insert('kelolapo_rincian_setor_cmt',$insertsetoran);
				}
			}
		}
	}

	public function searchSJ(){
		$post=$this->input->post();
		$id=$post['sj'];
		$data['kirims']=array();
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$toarray=explode(",", $data['kirim']['kode_po']);
		$row=count($toarray);
		for($i=0;$i<$row;$i++){
			$results[]=$this->GlobalModel->queryManual("SELECT pp.kode_po,kpp.jumlah_total_potongan as qty FROM produksi_po pp join  kelolapo_pengecekan_potongan kpp on(kpp.kode_po=pp.kode_po) WHERE pp.kode_po='$toarray[$i]' ");
			$data['bawahan']=$this->GlobalModel->queryManual("SELECT kda.*,kpa.* FROM kirimcmt_detailbawah kda JOIN konveksi_buku_potongan_variasi kpa ON(kpa.id_potongan_utama=kda.idpengecekan) WHERE kpa.kode_po='$toarray[$i]' ");
		}
		$rpo=array();
		foreach($results as $r){
			foreach($r as $t){
				$rpo=$this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$t['kode_po'],'status_penerimaan'=>0));
				$data['kirims'][]=array(
					'kode_po'=>$t['kode_po'],
					'qty'=>$t['qty'],
					'rpo'=>$rpo,
				);
			}
		}
		$y=0;
		$z=0;
		foreach($data['kirims'] as $dk){
			echo "<tr>";
			echo '<td><input type="checkbox" class="'.$dk['kode_po'].'" name="po['.$z.'][pilih]" value="1"></td> ';
			echo "<td colspan='9'><input type='hidden' name='po[".$z."][kode_po]' value='".$dk['kode_po']."'/> ".$dk['kode_po']."</td> ";
			foreach($dk['rpo'] as $rpo){
				echo "<tr>";
				echo '<td></td>';
				//echo "<td>".$dk['kode_po']."</td>";
				echo '<td><input type="checkbox" class="'.$dk['kode_po'].'" name="products['.$z.'][pilih]" value="1"></td>';
				echo "<td>".$rpo['bagian_potongan_atas']."</td>";
				echo "<td>".$rpo['warna_potongan_atas']."<input type='hidden' value='".$dk['kode_po']."' class='form-control' name='products[".$z."][kodepo]'/> <input type='hidden' value='".$rpo['bagian_potongan_atas']."' class='form-control' name='products[".$z."][bagian_potongan_atas]'/> <input type='hidden' value='".$rpo['warna_potongan_atas']."' class='form-control' name='products[".$z."][warna_potongan_atas]'/></td>";
				echo "<td><input type='text' value='".$rpo['jumlah_potongan']."' class='form-control' name='products[".$z."][jmlAtas]' readonly/></td>";
				echo "<td><input type='text' value='0' class='form-control' name='products[".$z."][qtyBankeAtas]'/></td>";
				echo "<td><input type='text' value='0' class='form-control' name='products[".$z."][qtyRejectAtas]'/></td>";
				echo "<td><input type='text' value='0' class='form-control' name='products[".$z."][qtyHilangAtas]'/></td>";
				echo "<td><input type='text' value='0' class='form-control' name='products[".$z."][qtyClaimAtas]'/></td>";
				echo "<td><input type='text' value='-' class='form-control' name='products[".$z."][keteranganAts]'/></td>";
				echo "</tr>";
				$z++;
			}
			echo "</tr>";
			$y++;
		}
		echo '
		<script>
		$("input:checkbox").change(function () {
		    var value = $(this).attr("class");
		    $(":checkbox[class=" + value + "]").prop("checked", this.checked);
		});
		</script>
		';
		//pre($data['kirims']);

	}

	public function searchSJcmt(){
		$post=$this->input->post();
		$results=array();
		$results=$this->GlobalModel->getData('kirimcmt',array('idcmt'=>$post['idcmt'],'status'=>0,'hapus'=>0));
		if(!empty($results)){
			foreach($results as $r){
				echo "<option value=''>Pilih Surat Jalan</optio>";
				echo "<option value='".$r['id']."'>".$r['nosj']."</optio>";	
			}
		}else{
			echo "<option>Data tidak ditemukan</optio>";
		}		

	}

	public function autocompletePO()
	{
		$post = $this->input->post();
		$data = $this->GlobalModel->getData('konveksi_buku_potongan',array('status'=>0));
		if(!empty($data)){
			foreach($data as $po){
				echo "<option value=''></option>";
				echo '<option value="'.$po['kode_po'].'">'.$po['kode_po'].'</option>';
			}
		}
	}

	public function searchPO($value='')
	{
		$post = $this->input->post();
		$explode = $post['POid'];
		$data = $this->GlobalModel->queryManual("SELECT * FROM konveksi_buku_potongan kbp JOIN produksi_po pp ON kbp.kode_po=pp.kode_po WHERE pp.kode_po='".$explode."' ");
		if(!empty($data)){
			foreach ($data as $row) {
				echo "<tr>";
				echo "<td>".$row['kode_po']."</td>";
				echo "<td>".$row['hasil_lusinan_potongan']."</td>";
				echo "<td>".$row['hasil_pieces_potongan']."</td>";
				echo "</tr>";
			}
		}
	}

	public function searchPObahan($value='')
	{
		$post = $this->input->post();
		$kode_po = $post['POid'];
		$atasan=array();
		$bawahan=array();
		$atasan = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_atas',array('kode_po'=>$kode_po));
		if(!empty($atasan)){
			echo "<table class='table table-bordered'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Atasan</th>";
			echo "<th>Bagian</th>";
			echo "<th>Warna</th>";
			echo "<th>Qty</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach($atasan as $a){
				echo "<tr>";
				echo "<td></td>";
				echo "<td>".$a['bagian_potongan_atas']."</td>";
				echo "<td>".$a['warna_potongan_atas']."</td>";
				echo "<td>".$a['jumlah_potongan']."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
		$bawahan = $this->GlobalModel->getData('kelolapo_pengecekan_potongan_bawah',array('kode_po'=>$kode_po));
		if(!empty($bawahan)){
			echo "<table class='table'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Bawahan</th>";
			echo "<th>Bagian</th>";
			echo "<th>Warna</th>";
			echo "<th>Qty</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach($bawahan as $a){
				echo "<tr>";
				echo "<td></td>";
				echo "<td>".$a['bagian_potongan_atas']."</td>";
				echo "<td>".$a['warna_potongan_atas']."</td>";
				echo "<td>".$a['jumlah_potongan']."</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}

		
	}

	public function Add(){
		$data=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Product';
		$data['tambah']=BASEURL.'ProductAdd';
		$this->load->view('master/product/add_product',$data);
		$this->load->view('global/footer');
	}

	public function View($id){
		$data=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Product';
		$data['tambah']=BASEURL.'ProductAdd';
		$this->load->view('master/product/add_product',$data);
		$this->load->view('global/footer');
	}

	public function Color($id){
		$data=array();
		$this->load->view('global/header');
		$data['url']=BASEURL.'Product';
		$data['tambah']=BASEURL.'ProductAdd';
		$this->load->view('master/product/add_product',$data);
		$this->load->view('global/footer');
	}
}

?>