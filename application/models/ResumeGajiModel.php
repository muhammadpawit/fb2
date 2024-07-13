<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ResumeGajiModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    function get($id,$tanggal1,$tanggal2){
        if($id==1){
            // kasbon karyawan konveksi . 15 sebagai id divisi konveksi
            $this->load->model('KasbonModel');
            $result = $this->KasbonModel->getsumkasbonPerdivisi(15,$tanggal1,$tanggal2);
            return $result;
        }else if($id==2){
            // Pinjaman Karyawan
            
            $result = $this->GetSumPinjamanKaryawan($tanggal1,$tanggal2);
            return $result;
        }else if($id==3){
            // Uang Makan Security
            $result = $this->UmSecurity($tanggal1,$tanggal2);
            return $result;
        }else if($id==6){
            // Gaji KLO
            $result = $this->GajiKlo($tanggal1,$tanggal2);
            return $result;
        }
        else if($id==7){
            // Gaji Tim Potong
            $result = $this->GajiTimPotong($tanggal1,$tanggal2);
            return $result;
        }else{
            return 0;
        }
    }

    function GetSumPinjamanKaryawan($tanggal1,$tanggal2){
        $hasil=0;
        $sql = " SELECT COALESCE(SUM(totalpinjaman-totalpotongan),0) as total FROM pinjaman_karyawan WHERE hapus=0
                AND status NOT IN (3)
                AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
        ";
        $data = $this->GlobalModel->QueryManualRow($sql);
        if(isset($data['total'])){
            $hasil = $data['total'];
        }
        return $hasil;
    }

    function UmSecurity($tanggal1,$tanggal2){
        $sql="SELECT COALESCE(SUM(um_security_detail.nominal),0) as total FROM um_security a JOIN
        um_security_detail ON um_security_detail.idum=a.id
         WHERE a.hapus=0 ";
		if(!empty($tanggal1)){
				$sql.=" AND date(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}
		
		$results=$this->GlobalModel->QueryManualRow($sql);
        return $results['total'];
    }

    function GajiKlo($tanggal1,$tanggal2){
        $totalpembulatan=0;
        $data['gaji']=$this->GlobalModel->QueryManual("
            SELECT * FROM gaji_finishing WHERE hapus=0 
            AND DATE(tanggal1) BETWEEN '".$tanggal1."'  AND  '".$tanggal2."' 
        ");
		
		if(!empty($data['gaji'])){
			foreach($data['gaji'] as $g){
                $details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$g['id']));
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
                        'saving'=>$d['saving'],
                        'keluarkansaving'=>$d['keluarkansaving'],
                    );
                }
            }

            
            foreach($data['karyawans'] as $k){
                $totalpembulatan += pembulatangaji($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']-$k['saving']+$k['keluarkansaving']);
            }
            
		}
        return $totalpembulatan;
    }

    function GajiTimPotong($tanggal1,$tanggal2){
        $hasil = 0;
        $data = $this->GlobalModel->QueryManualRow("
            SELECT COALESCE(SUM(nominal),0) as total FROM gaji_timpotong WHERE hapus=0 AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
        ");
        return $data['total'];
    }

}