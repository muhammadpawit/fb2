<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengalihanPoSukabumi extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		//sessionLogin(URLPATH."\\".$this->uri->segment(1));
		//session(dirname(__FILE__)."\\".$this->uri->segment(1).'.php');
		$this->url=BASEURL.'PengalihanPoSukabumi/';
		$this->page='newtheme/page/pengalihanpo_sukabumi/';
		$this->layout='newtheme/page/main';
		$this->login 		= BASEURL.'login';
		$this->auth 	= $this->session->userdata('id_user');
		if(empty($this->auth)) {redirect($this->login);}
	}

    public function index(){
		$data=array();
		$data['title']='Surat Jalan Pengiriman Jahit';
		$data['products']=array();
		$data['url']=$this->url;
		$data['i']=1;
		$data['tambah']=$this->url.'tambah';
		$get=$this->input->get();
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
		$data['listcmt']= $this->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 AND cmt_job_desk="JAHIT" AND lokasi=3 ORDER BY cmt_name ASC ');
		$data['nosj']= $this->GlobalModel->queryManual('SELECT * FROM kirimcmt WHERE hapus=0');
		$filter=array(
				'hapus'=>0,
		);
		$results=array();
		$sql="SELECT kc.* FROM kirimcmt kc ";
        $sql .=" LEFT JOIN master_cmt mc ON mc.id_cmt=kc.idcmt ";

        $sql.=" WHERE kc.hapus=0 AND mc.lokasi=3 ";

		if(!empty($cmt)){
			$sql.=" AND idcmt='$cmt' ";
		}

		if(!empty($sj)){
			$sql.=" AND id='$sj' ";
		}

		if(empty($cmt) OR empty($sj)){
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
		}

		$sql.=' ORDER BY kc.id DESC ';
		$sql.=" LIMIT 20 ";
		$results= $this->GlobalModel->queryManual($sql);
		$namacmt=null;
		$no=1;
		foreach($results as $result){
			$action=array();
			$action[] = array(
				'text' => 'Detail',
				'href' => BASEURL.'PengalihanPoSukabumi/kirimcmtview/'.$result['id'],
			);

			if(aksesedit()==1){
				$action[] = array(
					'text' => 'Edit',
					'href' => BASEURL.'Kelolapo/kirimcmtedit/'.$result['id'],
				);
			}

			$namacmt = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$result['idcmt']));
			// $dets = $this->GlobalModel->GetData('kirimcmt_detail',array('hapus'=>0,'idkirim'=>$result['id']));
			$dets = $this->detail($result['id']);
			
			$data['products'][]=array(
				'no'=>$no++,
				'nosj'=>$result['nosj'],
				'tanggal'=>date('d-m-Y',strtotime($result['tanggal'])),
				'kode_po'=>$result['kode_po'],
				'quantity'=>$result['totalkirim'],
				'namacmt'=>$namacmt['cmt_name'],
				'keterangan'=>$result['keterangan'],
				'status'=>$result['status']==1?'Disetor':'Dikirim',
				'action'=>$action,
				'dets' => $dets,
			);
		}
		$data['page']='produksi/kirimcmt_list';
		$this->load->view('newtheme/page/main',$data);
		
	}

	function detail($id){
		$sql =" SELECT p.kode_po, k.jumlah_pcs FROM produksi_po p INNER JOIN kirimcmt_detail k ON k.kode_po=p.id_produksi_po WHERE k.hapus=0 and k.idkirim='$id' ";
		return $this->db->query($sql)->result_array();
	}

	public function kirimcmtview($id='',$kodepo=''){
		$toarray=explode(",", $kodepo);
		$row=count($toarray);
		$data=array();
		$rincian=array();
		$data['no']=1;
		$data['kembali']=BASEURL.'PengalihanPoSukabumi';
		$data['cetak']=BASEURL.'Kelolapo/kirimcmtcetak/'.$id.'/1';
		$data['excel']=BASEURL.'Kelolapo/kirimcmtcetak/'.$id.'/2';
		$data['kirim']=$this->GlobalModel->getDataRow('kirimcmt',array('id'=>$id));
		$kirims=$this->GlobalModel->getData('kirimcmt_detail',array('idkirim'=>$id,'hapus'=>0));
		$job=null;
		foreach($kirims as $k){
			$job=$this->GlobalModel->getDataRow('master_job',array('id'=>$k['cmtjob']));
			$po=$this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$k['kode_po']));
			$data['kirims'][]=array(
				'kode_po'=>$po['kode_po'].' '.(($po['serian']!=0) ? $po['serian'] :''),
				'rincian_po'=>$k['rincian_po'],
				'job'=>$job['nama_job'],
				'jumlah_pcs'=>$k['jumlah_pcs'],
				'keterangan'=>$k['keterangan'],
				'jml_barang'=>$k['jml_barang'],
			);
		}
		$data['cmt'] = $this->GlobalModel->getDataRow('master_cmt',array('id_cmt'=>$data['kirim']['idcmt']));
		$data['page']='produksi/kirimcmt_view';
		$this->load->view('newtheme/page/main',$data);
	}


    // public function index(){
	// 	$data=[];
	// 	$data['title']='Kirim PO CMT Sukabumi';
	// 	$get=$this->input->get();
	// 	if(isset($get['tanggal1'])){
	// 		$tanggal1=$get['tanggal1'];
	// 	}else{
	// 		$tanggal1=null;
	// 	}
	// 	if(isset($get['tanggal2'])){
	// 		$tanggal2=$get['tanggal2'];
	// 	}else{
	// 		$tanggal2=null;
	// 	}
	// 	$data['tanggal1']=$tanggal1;
	// 	$data['tanggal2']=$tanggal2;
	// 	$sql="SELECT * FROM pengalihanpo WHERE hapus=0";
	// 	if(!empty($tanggal1)){
	// 		$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
	// 	}
	// 	$sql.=" ORDER BY id desc ";
	// 	$data['prods']=[];
	// 	$results=$this->GlobalModel->QueryManual($sql);
	// 	$sql.=" ORDER BY id DESC ";
	// 	foreach ($results as $r) {
	// 		$cmtasal=$this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$r['cmt_asal']));
	// 		$cmttujuan=$this->GlobalModel->GetDataRow('master_cmt',array('id_cmt'=>$r['cmt_tujuan']));
	// 		$sjasal=$this->GlobalModel->GetDataRow('kirimcmt',array('id'=>$r['sj_asal']));
	// 		$sjtujuan=$this->GlobalModel->GetDataRow('kirimcmt',array('id'=>$r['sj_tujuan']));
	// 		$data['prods'][]=array(
	// 			'tanggal'=>date('d F Y',strtotime($r['tanggal'])),
	// 			'sj_asal'=>$sjasal['nosj'],
	// 			'sj_tujuan'=>$sjtujuan['nosj'],
	// 			'cmt_asal'=>$cmtasal['cmt_name'],
	// 			'cmt_tujuan'=>$cmttujuan['cmt_name'],
	// 			'kode_po'=>$r['kode_po'],
	// 			'keterangan'=>$r['keterangan'],
	// 		);
	// 	}
	// 	$data['page']=$this->page.'pengalihanpo';
	// 	$data['tambah']=$this->url.'tambah';
	// 	$this->load->view($this->layout,$data);	
	// }

	public function tambah(){
		$data=[];
		$data['title']='Pengiriman PO';
		$data['kirim']=$this->GlobalModel->QueryManual("SELECT kd.*, k.idcmt,k.nosj,k.tanggal as tglsj,k.id as idsj FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) WHERE k.idcmt=85 AND kd.hapus=0 AND k.hapus=0");
		$data['cmt']=$this->GlobalModel->QueryManual("SELECT * FROM master_cmt WHERE lokasi=3 and hapus=0 AND id_cmt NOT IN(85) ORDER BY cmt_name ");
		$data['action']=$this->url.'tambah_save';
		$data['cancel']=$this->url;
		$data['page']=$this->page.'pengalihanpo_tambah';
		$this->load->view($this->layout,$data);	
	}

    public function carip(){
		$get = $this->input->get();
		$sql="SELECT kd.*, k.idcmt,k.nosj,k.tanggal as tglsj,k.id as idsj FROM kirimcmt_detail kd JOIN kirimcmt k ON(k.id=kd.idkirim) WHERE k.idcmt=85 AND kd.hapus=0 AND k.hapus=0 ";
		if(isset($get['po'])){
			$sql.=" AND kd.kode_po LIKE '%".$get['po']."%'";
		}
		$sql.=" GROUP BY kd.kode_po";
        $data = $this->GlobalModel->QueryManualRow($sql);
		echo json_encode($data);
	}

	public function tambah_save(){
		$post=$this->input->post();
        $cmt=$this->GlobalModel->QueryManualRow("SELECT * FROM master_cmt WHERE id_cmt='".$post['id_cmt']."' ");
		//pre($post);
        $insert=array(
            'tanggal'=>$post['tanggal'],
            'kode_po'=>'-',
            'totalkirim'=>0,
            'cmtkat'=>'JAHIT',
            'idcmt'=>$cmt['id_cmt'],
            'cmtjob'=>'-',
            'status'=>0,
            'keterangan'=>'',
            'dibuat'=>date('Y-m-d H:i:s'),
            'hapus'=>0,
        );
        $this->db->insert('kirimcmt', $insert);
        $id = $this->db->insert_id();
        $totalkirim=0;
        foreach($post['prods'] as $p){
            $explode=explode('-', $p['kode_po']);
            $klo =$this->GlobalModel->GetDataRow('kelolapo_kirim_setor',
                    array(
                        'hapus'=>0,
                        'kode_po'=>$explode[0],
                        'kode_nota_cmt'=>$explode[1],
                        'progress'=>'KIRIM',
                        'kategori_cmt'=>'JAHIT',
                    )
                );
            // // hapus sj lama di klo
            $this->db->update('kelolapo_kirim_setor',
                array(
                    'hapus'=>1
                ),
                array(
                    'kode_po'=>$explode[0],
                    'kode_nota_cmt'=>$explode[1],
                ));
            
            $sj =$this->GlobalModel->GetDataRow('kirimcmt_detail',
                array(
                    'hapus'=>0,
                    'kode_po'=>$explode[0],
                    'idkirim'=>$explode[1],
                )
            );

            // kurangi qty kirim pada surat jalan
            $this->db->query("UPDATE kirimcmt set totalkirim=totalkirim-'".$klo['qty_tot_pcs']."' 
                WHERE id='".$explode[1]."'
            ");
            // hapus sj lama di surat jalan
            $this->db->update('kirimcmt_detail',
                array(
                    'hapus'=>1
                ),
                array(
                    'kode_po'=>$explode[0],
                    'idkirim'=>$explode[1],
                ));
                
                $detail=array(
                    'idkirim'=>$id,
                    'kode_po'=>$klo['kode_po'],
                    'cmtjob'=>$klo['id_master_cmt_job'],
                    'rincian_po'=>$sj['rincian_po'],
                    'jumlah_pcs'=>$klo['qty_tot_pcs'],
                    'keterangan'=>$sj['keterangan'],
                    'jml_barang'=>$sj['jml_barang'],
                    'hapus'=>0,
                );

               $this->db->insert('kirimcmt_detail',$detail);
               $masterpo=$this->GlobalModel->GetdataRow('produksi_po',array('hapus'=>0,'kode_po'=>$explode[0]));
               $jobprice=$this->GlobalModel->getDataRow('master_job',array('id'=>$klo['id_master_cmt_job']));
               $totalkirim+=($klo['qty_tot_pcs']);
               $insertkks=array(
                   'kode_po'=>$explode[0],
                   'create_date'=>$post['tanggal'],
                   //'kode_nota_cmt'=>$id,
                   'progress'=>'KIRIM',
                   'kategori_cmt'=>'JAHIT',
                   'id_master_cmt'=>$post['id_cmt'],
                   'id_master_cmt_job'=>$klo['id_master_cmt_job'],
                   'cmt_job_price'=>$jobprice['harga'],
                   'nama_cmt'=>$cmt['cmt_name'],
                   'qty_tot_pcs'=>$klo['qty_tot_pcs'],
                   'qty_tot_atas'=>0,
                   'qty_tot_bawah'=>0,
                   'keterangan'=>'-',
                   'status'=>0,
                   'jml_barang'=>$sj['jml_barang'],
                   'qty_bangke'=>0,
                   'qty_reject'=>0,
                   'qty_hilang'=>0,
                   'qty_claim'=>0,
                   'status_keu'=>0,
                   'tglinput'=>date('Y-m-d'),
                   'idpo'=>!empty($masterpo)?$masterpo['id_produksi_po']:0,
               );
               $this->db->insert('kelolapo_kirim_setor',$insertkks);
        }
            $nosj='SJFB'.'-'.date('Y-m').'-'.$id;
            user_activity(callSessUser('id_user'),1,' input pengiriman surat jalan jahit '.$nosj);
            $this->db->update('kirimcmt',array('totalkirim'=>$totalkirim,'nosj'=>$nosj),array('id'=>$id));
            $this->session->set_flashdata('msg','Data berhasil disimpan');
            redirect(BASEURL.'PengalihanPoSukabumi');
		
	}

}