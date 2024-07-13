<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KasbonModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    public function kasbon($bulan,$tahun,$idkaryawan){
        $hasil=[];
        $sql="SELECT DISTINCT tanggal FROM kasbon WHERE hapus=0 ";
        $sql.=" AND MONTH(tanggal)='".$bulan."' ";
        $sql.=" AND YEAR(tanggal)='".$tahun."' ";
        $sql.=" ORDER BY tanggal ASC ";
        $data=$this->GlobalModel->QueryManual($sql);
        $sql2=[];
        if(!empty($data)){
            foreach($data as $d){
                $s=" SELECT nominal_request as nominal,tanggal FROM kasbon WHERE DATE(tanggal)='".$d['tanggal']."' AND hapus=0 AND idkaryawan='".$idkaryawan."' ";
                $sql2=$this->GlobalModel->QueryManual($s);

            }
        }

        return $sql2;
    }

    public function tgl($bulan,$tahun){
        $hasil=[];
        $sql="SELECT DISTINCT tanggal FROM kasbon WHERE hapus=0 ";
         // $sql.=" AND MONTH(tanggal)='".$bulan."' ";
        // $sql.=" AND YEAR(tanggal)='".$tahun."' ";
        $sql.=" AND DATE(tanggal) BETWEEN '".$bulan."' ";
        $sql.=" AND '".$tahun."' ";
        $sql.=" ORDER BY tanggal ASC ";
        $data=$this->GlobalModel->QueryManual($sql);
        $sql2=[];
        if(!empty($data)){
            $hasil=$data;
        }

        return $hasil;
    }

    public function getkasbon($id,$tanggal){
        $hasil=0;
        $sql="SELECT nominal_request as nominal FROM kasbon WHERE hapus=0 ";
        $sql.=" AND (tanggal)='".$tanggal."' ";
        $sql.=" AND idkaryawan='".$id."' ";
        $data=$this->GlobalModel->QueryManualRow($sql);
        $sql2=[];
        if(!empty($data)){
            $hasil=$data['nominal'];
        }

        return $hasil;
    }

    public function getsumkasbon($id,$bulan,$tahun){
        $hasil=0;
        $sql="SELECT nominal_request as nominal FROM kasbon WHERE hapus=0 ";
        // $sql.=" AND MONTH(tanggal)='".$bulan."' ";
        // $sql.=" AND YEAR(tanggal)='".$tahun."' ";
        $sql.=" AND DATE(tanggal) BETWEEN '".$bulan."' ";
        $sql.=" AND '".$tahun."' ";
        $sql.=" AND idkaryawan='".$id."' ";
        $data=$this->GlobalModel->QueryManualRow($sql);
        $sql2=[];
        if(!empty($data)){
            $hasil=$data['nominal'];
        }

        return $hasil;
    }
    public function getsumkasbonPerdivisi($id,$bulan,$tahun){
        $hasil=0;
        $sql="SELECT COALESCE(SUM(nominal_request),0) as nominal FROM kasbon WHERE hapus=0 ";
        // $sql.=" AND MONTH(tanggal)='".$bulan."' ";
        // $sql.=" AND YEAR(tanggal)='".$tahun."' ";
        $sql.=" AND DATE(tanggal) BETWEEN '".$bulan."' ";
        $sql.=" AND '".$tahun."' ";
        $sql.=" AND bagian='".$id."' ";
        $data=$this->GlobalModel->QueryManualRow($sql);
        $sql2=[];
        if(!empty($data)){
            $hasil=$data['nominal'];
        }

        return $hasil;
    }

}