<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PembayaranModel extends CI_Model {

	function __construct() {
		parent::__construct();
		
	}

    function getPeriode($tgl1,$tgl2){
        $hasil = [];
        $hasil = $this->db->query("SELECT tanggal from pembayaran_cmt WHERE DATE(tanggal) BETWEEN '".$tgl1."' AND '".$tgl2."' AND hapus=0 GROUP BY tanggal ")->result_array();
        return $hasil;
    }

    function getSum($tgl1,$tgl2,$cmt){
        return $this->db->query("SELECT COALESCE(SUM(total),0) as total from pembayaran_cmt where hapus=0 and DATE(tanggal) BETWEEN '".$tgl1."' AND '".$tgl2."' AND idcmt='".$cmt."' ")->row();
    }

    function getTotalPeriode($tgl1,$tgl2){
        $hasil = [];
        $prs = $this->db->query("SELECT tanggal from pembayaran_cmt WHERE DATE(tanggal) BETWEEN '".$tgl1."' AND '".$tgl2."' AND hapus=0 GROUP BY tanggal ")->result_array();
        foreach($prs as $h){
            $sum =$this->db->query("SELECT COALESCE(SUM(total),0) as total from pembayaran_cmt where hapus=0 and date(tanggal)='".$h['tanggal']."' ")->row();
            $hasil[]=array(
                'total'     => $sum->total,
            );
        }
        return $hasil;
    }

    function getRekapTgl($tgl1,$tgl2,$cmt){
        $hasil = [];
        $tgl = $this->db->query("SELECT tanggal from pembayaran_cmt WHERE DATE(tanggal) BETWEEN '".$tgl1."' AND '".$tgl2."' AND hapus=0 GROUP BY tanggal ")->result_array();
        foreach($tgl as $t){
            $qry =$this->db->query("SELECT COALESCE(SUM(total),0) as total from pembayaran_cmt where hapus=0 and date(tanggal)='".$t['tanggal']."' AND idcmt='".$cmt."' ")->row();
            $hasil[]=array(
                'tanggal' => $t['tanggal'],
                'total'   => $qry->total,
            );
        }
        return $hasil;
    }

    function getRekapCmt($tgl1,$tgl2){
        $hasil = [];

        $sql ="SELECT b.id_cmt, b.cmt_name,a.tanggal from master_cmt b JOIN pembayaran_cmt a ON a.idcmt=b.id_cmt where a.hapus=0 and date(a.tanggal) BETWEEN '".$tgl1."' AND '".$tgl2."' ";
        $sql.=" GROUP BY a.idcmt ";
        return $this->db->query($sql)->result_array();
    }

    function saving($id,$tgl1,$tgl2){
		$hasil=0;
		$sql="SELECT COALESCE(SUM(saving)) as saving FROM gaji_finishing_detail WHERE idkaryawan='$id' AND hapus=0 ";
		$sql .=" AND DATE(tanggal_saving) BETWEEN '".$tgl1."' AND '".$tgl2."' ";
		$data = $this->GlobalModel->QueryManualRow($sql);
		if(isset($data['saving'])){
			$hasil = $data['saving'];
		}
		return $hasil;
	}

}