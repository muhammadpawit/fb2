<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjuanalatModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function show($data){
		$hasil=[];
		$sql="SELECT als.*, p.nama FROM alat_sukabumi als JOIN product p ON(p.product_id=als.id_persediaan) WHERE als.hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}

		$sql.=" ORDER BY id DESC ";
		$result=$this->GlobalModel->QueryManual($sql);
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'id'=>$r['id'],
					'tanggal'=>date("d-m-Y",strtotime($r['tanggal'])),
					'nama'=>$r['nama'],
					'jumlah'=>$r['jumlah_terima'],
					'satuan'=>$r['satuan'],
					'keterangan'=>$r['keterangan'],
				);
			}
		}
		return $hasil;
	}

	public function insert($data){
		if(isset($data['products'])){
			foreach($data['products'] as $p){
				$insert=array(
					'tanggal'=>date('Y-m-d'),
					'id_persediaan'=>$p['idpersediaan'],
					'nama'=>$p['nama'],
					'jumlah_kirim'=>$p['jumlah'],
					'jumlah_terima'=>$p['terima'],
					'tanggal_terima'=>$data['tanggal'],
					'satuan'=>$p['satuan'],
					'keterangan'=>$p['keterangan'],
					'pembuat'=>callSessUser('nama_user').' pada '.date('d-m-Y H:i:s'),
					'status'=>2, // 1 dikirim. 2 diterima
					'hapus'=>0,
				);
				$this->db->insert('alat_sukabumi',$insert);
				$cek=$this->GlobalModel->getDataRow('stok_barang_skb',array('hapus'=>0,'id_persediaan'=>$p['idpersediaan']));
				if(!empty($cek)){
					$this->db->query("UPDATE stok_barang_skb SET stock=stock+'".$p['terima']."' WHERE id_persediaan='".$p['idpersediaan']."' AND hapus=0 ");
				}else{
					$insertbarang=array(
						'id_persediaan'=>$p['idpersediaan'],
						'nama'=>$p['nama'],
						'stock'=>$p['terima'],
						'satuan'=>$p['satuan'],
						'hapus'=>0,
					);
					$this->db->insert('stok_barang_skb',$insertbarang);
				}
			}
		}
	}

	public function terima($id,$tanggal){
		$update=array(
			'status'=>2,
			'tanggal_terima'=>$tanggal,
		);
		$$id=array(
			'id'=>$id,
		);
		$this->db->update('alat_sukabumi',$update,$where);
	}

	public function stock($data){
		$hasil=[];
		$sql="SELECT * FROM stok_barang_skb WHERE hapus=0 ";
		$sql.=" ORDER BY nama ASC ";
		$result=$this->GlobalModel->QueryManual($sql);
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'id'=>$r['id_persediaan'],
					'nama'=>$r['nama'],
					'jumlah'=>$r['stock'],
					'satuan'=>$r['satuan'],
				);
			}
		}
		return $hasil;
	}

	public function distribusi($data){
		$hasil=[];
		$sql="SELECT d.*, mc.cmt_name, s.nama, s.satuan FROM distribusi_alat_sukabumi d ";
		$sql.=" LEFT JOIN master_cmt mc ON mc.id_cmt=d.idcmt ";
		$sql.=" LEFT JOIN stok_barang_skb s ON s.id_persediaan=d.id_persediaan ";
		$sql.=" WHERE d.hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(d.tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}

		$sql.=" ORDER BY d.id DESC ";
		$result=$this->GlobalModel->QueryManual($sql);
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'id'=>$r['id'],
					'tanggal'=>date("d-m-Y",strtotime($r['tanggal'])),
					'nama'=>strtolower($r['cmt_name']),
					'alat'=>strtolower($r['nama']),
					'jumlah'=>$r['jumlah'],
					'satuan'=>$r['satuan'],
					'keterangan'=>strtolower($r['keterangan']),
					'validasi'=>$r['validasi'],
				);
			}
		}
		return $hasil;
	}

	public function distribusi_save(){
		$post = $this->input->post();
		if($post['jumlah'] >0){
			$insert = array(
				'tanggal' => isset($post['tanggal']) ? $post['tanggal'] : date('Y-m-d'),
				'id_persediaan' => $post['id_persediaan'],
				'idcmt'	=> $post['idcmt'],
				'jumlah' => $post['jumlah'],
				'keterangan' => $post['keterangan'],
				'hapus'=>0,
				'validasi'=>0,
			);
			$this->db->insert('distribusi_alat_sukabumi',$insert);
			$id = $this->db->insert_id();
			$this->db->query("UPDATE stok_barang_skb set stock=stock-'".$post['jumlah']."' WHERE id_persediaan='".$post['id_persediaan']."' ");
			user_activity(callSessUser('id_user'),1,' menambahkan distribusi alat dengan id '.$id);
		}else{
			$this->session->set_flashdata('gagal','Data gagal disimpan. Stok alat habis<br>'.json_encode($post));
			redirect($this->url.'distribusi');
		}
	}

	public function distribusi_hapus($id){
		$transaksi = $this->GlobalModel->GetDataRow('distribusi_alat_sukabumi',array('id'=>$id));
		$this->db->update(
			'distribusi_alat_sukabumi',
			array(
				'hapus'=>1
			),
			array(
				'id'=>$id
			)
		);
		$this->db->query("UPDATE stok_barang_skb set stock=stock+'".$transaksi['jumlah']."' WHERE id_persediaan='".$transaksi['id_persediaan']."' ");
		$this->session->set_flashdata('msg','Data berhasil dihapus');
		user_activity(callSessUser('id_user'),1,' hapus distribusi alat-alat dengan id '.$id);
		redirect($this->url.'distribusi');
	}

	public function distribusi_validasi($id){
		$transaksi = $this->GlobalModel->GetDataRow('distribusi_alat_sukabumi',array('id'=>$id));
		$this->db->update(
			'distribusi_alat_sukabumi',
			array(
				'validasi'=>1
			),
			array(
				'id'=>$id
			)
		);

		user_activity(callSessUser('id_user'),1,' validasi distribusi alat-alat dengan id '.$id);
		
		$this->session->set_flashdata('msg','Data berhasil divalidasi');
		redirect($this->url.'distribusi');
	}

	public function getshow($data){
		$hasil=[];
		$sql="SELECT a.*, p.product_id, p.nama,p.satuan FROM ajuanalatalat a LEFT JOIN product p ON p.product_id=a.id_persediaan WHERE a.hapus=0 and p.hapus=0 ";
		if(!empty($data['tanggal1'])){
			$sql.=" AND DATE(a.tanggal) BETWEEN '".$data['tanggal1']."' AND '".$data['tanggal2']."' ";
		}
		$sql .=" AND a.bagian='".$data['bagian']."' ";
		$sql.=" ORDER BY a.id DESC ";
		$result=$this->GlobalModel->QueryManual($sql);
		$no=1;
		if(!empty($result)){
			foreach($result as $r){
				$hasil[]=array(
					'no'=>$no++,
					'id'=>$r['id'],
					'tgl'=>date("d/m/Y",strtotime($r['tanggal'])),
					'tanggal'=>date("Y-m-d",strtotime($r['tanggal'])),
					'product_id' => $r['product_id'],
					'nama'=>$r['nama'],
					'kebutuhan'=>$r['kebutuhan'],
					'stok'=>$r['stok'],
					'ajuan'=>$r['ajuan'],
					'satuan'=>$r['satuan'],
					'keterangan'=>$r['keterangan'],
					'acc_ajuan'	=> $r['acc_ajuan'],
					'supplier_id'=>$r['supplier_id'],
				);
			}
		}
		return $hasil;
	}

	public function getshowId($id){
		$hasil=[];
		$sql="SELECT a.*, p.nama,p.satuan FROM ajuanalatalat a LEFT JOIN product p ON p.product_id=a.id_persediaan WHERE a.hapus=0 and p.hapus=0 ";
		
		$sql .=" AND a.id='".$id."' ";
		$sql.=" ORDER BY a.id DESC ";
		$result=$this->GlobalModel->QueryManualRow($sql);
		return $result;
	}

	function rincian($data,$idped){
		$get=$this->input->get();
		if(isset($get['tanggal1'])){
			$tanggal1=$get['tanggal1'];
		}else{
			$tanggal1=date('Y-m-d',strtotime("monday last week"));
		}
		if(isset($get['tanggal2'])){
			$tanggal2=$get['tanggal2'];
		}else{
			$tanggal2=date('Y-m-d',strtotime("saturday last week"));
		}

		if(isset($get['jenis'])){
			$jenis=$get['jenis'];
		}else{
			$jenis=null;
		}

		if(isset($get['kategori'])){
			$kategori=$get['kategori'];
		}else{
			$kategori=null;
		}

		if(isset($get['supplier'])){
			$supplier=$get['supplier'];
		}else{
			$supplier=null;
		}

		if(isset($get['bulan'])){
			$bulan=$get['bulan'];
		}else{
			$bulan=null;
		}
		$id=[];
		if(empty($idped)){
			foreach($data as $d){
				$id[]=$d['product_id'];
			}
		}
		$inId = implode(",",$id);
		$sql="SELECT gpi.* FROM gudang_persediaan_item gpi JOIN product p ON(p.product_id=gpi.id_persediaan) WHERE gpi.hapus=0 ";
		if(!empty($idped)){
			$sql.=" AND gpi.id_persediaan='$idped' ";
		}else{
			if(!empty($inId)){
				$sql.=" AND gpi.id_persediaan IN($inId) ";
			}else{
				$sql.=" AND gpi.id_persediaan IN(0) ";
			}
		}
		$sql.=" GROUP BY p.nama ASC , p.kategori ASC ";
		$results=$this->GlobalModel->QueryManual($sql);
		$no=1;
		$stokawal=0;
		$stokmasuk=0;
		$stokkeluar=0;
		$warna=null;
		$data['prods']=[];
		$barangmasukterakhir=null;
		$ratarata=0;
		$supplier=null;
		//pre($bulan);
		foreach($results as $row){
			$stokawal=$this->ReportModel->stokawal_alat($row['id_persediaan'],$tanggal1);
			$stokmasuk=$this->ReportModel->stokmasuk_alat($row['id_persediaan'],$tanggal1,$tanggal2);
			$stokkeluar=$this->ReportModel->stokkeluar_alat($row['id_persediaan'],$tanggal1,$tanggal2);
			$barangmasukterakhir=$this->ReportModel->barangmasukterakhir($row['id_persediaan'],$tanggal1,$tanggal2);
			$ratarata=$this->ReportModel->rataratabarangkeluar($row['id_persediaan'],$tanggal1,$tanggal2,$bulan);
			$sql2="SELECT pi.supplier FROM penerimaan_item pi JOIN penerimaan_item_detail pid ON (pid.penerimaan_item_id=pi.id) WHERE pi.hapus=0 and pid.id_persediaan= '".$row['id_persediaan']."' ";
			$sql2.=" AND date(pid.tanggal) <='".$tanggal2."' ORDER BY date(pid.tanggal) DESC LIMIT 1 ";
			$s=$this->GlobalModel->QueryManualRow($sql2);
			$sn=!empty($s)?$this->GlobalModel->getDataRow('master_supplier',array('id'=>$s['supplier'])):null;
			$supplier=!empty($sn)?$sn['nama']:null;
			//pre($stokkeluar);
			$data['prods'][]=array(
				'no'=>$no++,
				'id_persediaan'=>$row['id_persediaan'],
				'nama'	=>$row['nama_item'],
				'warna'	=>$row['warna_item'],
				'kode'=>null,
				'stokawal'=>$stokawal,
				'stokawalyard'=>0,
				'stokawalharga'=>$row['harga_item'],
				'stokmasuk'=>empty($stokmasuk['roll'])?0:$stokmasuk['roll'],
				'stokmasukyard'=>0,
				'stokmasukharga'=>$row['harga_item'],
				'stokkeluarroll'=>$stokkeluar,
				'stokkeluaryard'=>0,
				'stokkeluarharga'=>$row['harga_item'],
				'stokakhirroll'=>$row['jumlah_item'],
				'stokakhiryard'=>0,
				'stokakhirharga'=>$row['harga_item'],
				'total'=>round($row['harga_item']*($stokawal+($stokmasuk['yard']-$stokkeluar))),
				//'ket'=>!empty($barangmasukterakhir)?'barang masuk terakhir '.$supplier.' <br>'.$barangmasukterakhir['jumlah'].' '.$barangmasukterakhir['satuanJml'].' tanggal '.date('d-m-Y',strtotime($barangmasukterakhir['tanggal'])).'.<br> Rata-rata '.number_format($ratarata,2).' '.$barangmasukterakhir['satuanJml'].'/minggu':null,
				'ket'=>!empty($barangmasukterakhir)?'Rata-rata '.number_format($ratarata,2).' '.$barangmasukterakhir['satuanJml'].'/hari'.'<br>'.$barangmasukterakhir['keterangan']:null,
				'satuan'=>$row['satuan_jumlah_item'],
				'masukterakhir'=>!empty($barangmasukterakhir)?$supplier.' '.$barangmasukterakhir['jumlah'].' '.$barangmasukterakhir['satuanJml'].' tanggal '.date('d-m-Y',strtotime($barangmasukterakhir['tanggal'])):null,
			);
		}
		return $data['prods'];
	}

}