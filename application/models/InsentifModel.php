<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InsentifModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id,$tanggal1,$tanggal2){
        $results=array();
		$sql="SELECT GROUP_CONCAT(id ORDER BY id ASC) as id FROM insentifsecurity WHERE hapus=0";

		if(!empty($id)){
			$sql.=" AND karyawan_id='".$id."' ";
		}

		if(!empty($tanggal1)){
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
			$sql.=' ORDER BY tanggal ASC ';
			// $sql.=" LIMIT 7 ";
		}else{
			$sql.=' ORDER BY id DESC ';
			$sql.=" LIMIT 28 ";
		}

		
		$results= $this->GlobalModel->queryManualRow($sql);
        $idint = isset($results['id']) ? $results['id'] : 0;
		$namacmt=null;
		$no=1;

        $dets=[];
		$dets = $this->GlobalModel->QueryManual(
			"
				SELECT a.*, b.karyawan_id, b.shift, b.totalpotongan FROM insentifsecurity_detail a LEFT JOIN insentifsecurity b ON b.id=a.idint

				WHERE idint IN($idint) AND a.hapus=0
			"
		);
		// pre($dets);
		$action=array();
        $products=[];
		foreach($dets as $result){
			
			$action[] = array(
				'text' => 'Hapus',
				'class' => 'btn btn-xs btn-danger',
				'href' => $this->url.'InsentifsecurityHapus/'.$result['id'],
			);

			$namacmt = $this->GlobalModel->getDataRow('karyawan',array('id'=>$result['karyawan_id']));
			$hari = date('l',strtotime($result['tanggal']));
            
			
				$products[]=array(
					'no'=>$no++,
					'id' => $result['id'],
					'tanggal'=>hari($hari).','.date('d-m-Y',strtotime($result['tanggal'])),
					'kedisiplinan'=>$result['kedisiplinan'],
					'kebersihan'=>$result['kebersihan'],
					'kontrol_vc'=>$result['kontrol_vc'],
					'foto'=>$result['foto'],
					'ketentuan'=>$result['ketentuan'],
					'totalpotongan'=> $result['totalpotongan'],
					'hapus'=>BASEURL.'Insentifsecurity/InsentifsecurityHapus/'.$result['id'],
                    // 'hapus' => null,
					// 'dets'=>$dets,
				);
			

            
		}
        
        return $products;
    }

	function totalpotongan($id,$tanggal1,$tanggal2){
        $results=array();
		$sql="SELECT GROUP_CONCAT(id ORDER BY id ASC) as id FROM insentifsecurity WHERE hapus=0";

		if(!empty($id)){
			$sql.=" AND karyawan_id='".$id."' ";
		}

		if(!empty($tanggal1)){
			if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
			}
			$sql.=' ORDER BY tanggal ASC ';
			// $sql.=" LIMIT 7 ";
		}else{
			$sql.=' ORDER BY id DESC ';
			$sql.=" LIMIT 28 ";
		}

		
		$results= $this->GlobalModel->queryManualRow($sql);
        $idint = isset($results['id']) ? $results['id'] : 0;
		$namacmt=null;
		$no=1;

        $dets=[];
		$dets = $this->GlobalModel->QueryManual(
			"
				SELECT a.*, b.karyawan_id, b.shift, b.totalpotongan, b.nominal_insentif FROM insentifsecurity_detail a LEFT JOIN insentifsecurity b ON b.id=a.idint

				WHERE idint IN($idint) AND a.hapus=0
			"
		);
		// pre($dets);
		$action=array();
        $products=[];
		$total=0;
		$tambahan=0;
		foreach($dets as $result){
					
			$total+=($result['totalpotongan']);
            
		}

        
        return $total;
    }

	function rekap($tanggal1,$tanggal2){
		$hasil=0;
		// 1. Cek berdasarkan tanggal laporan keuangan gajian (tanggal_lap_keu_akhir atau tanggal_lap_keu_awal)
		$sql_lap = "SELECT COALESCE(SUM(total_diterima),0) as total FROM rekapinsentif_security WHERE hapus=0 
			AND (
				(tanggal_lap_keu_akhir BETWEEN '$tanggal1' AND '$tanggal2')
				OR (tanggal_lap_keu_awal BETWEEN '$tanggal1' AND '$tanggal2')
			)";
		$data_lap = $this->GlobalModel->QueryManualRow($sql_lap);
		if(!empty($data_lap['total']) && $data_lap['total'] > 0){
			return $data_lap['total'];
		}

		// 2. Cek jika tanggal sama persis dengan tanggal1 dan tanggal2 periode insentif
		$sql="SELECT COALESCE(SUM(total_diterima),0) as total FROM rekapinsentif_security WHERE hapus=0 AND ( (tanggal1='$tanggal1' AND tanggal2='$tanggal2') OR (tanggal2 BETWEEN '$tanggal1' AND '$tanggal2') ) ";
		$data = $this->GlobalModel->QueryManualRow($sql);
		return !empty($data['total']) ? $data['total'] : 0;
	}


   

}