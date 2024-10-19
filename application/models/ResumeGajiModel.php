<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ResumeGajiModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->model('InsentifModel');
    }


    function get($id,$tanggal1,$tanggal2){

        $get=$this->input->get();
        if(isset($get['tanggal11'])){
            $tanggal11=$get['tanggal11'];
        }else{
            $tanggal11=periodeproduksi()['tahun'].'-'.periodeproduksi()['bulan'].'-01';
        }
        if(isset($get['tanggal22'])){
            $tanggal22=$get['tanggal22'];
        }else{
            $tanggal22=date('Y-m-d');
        }

        
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
        }else if($id==4){
            // Uang Makan Security
            $result = $this->InsentifModel->rekap($tanggal11,$tanggal22);
            return $result;
        }else if($id==5){
            // Gaji Karyawan Finishing
            $result = $this->GajiFinishing($tanggal1,$tanggal2);
            return $result;
        }else if($id==6){
            // Gaji KLO
            $result = $this->GajiKlo($tanggal1,$tanggal2);
            return $result;
        }
        else if($id==7){
            // Gaji Gudang
            $result = $this->GajiGudang($tanggal1,$tanggal2);
            return $result;
        }else if($id==8){
            // Gaji Timpotong
            $result = $this->GajiTimPotong($tanggal1,$tanggal2);
            return $result;
        }
        else if($id==9){
            // Gaji Timpotong
            $result = $this->GajiSukabumi($tanggal1,$tanggal2);
            return $result;
        }else if($id==10){
            // Gaji Timpotong
            $result = $this->AjuanHarian($tanggal1,$tanggal2);
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
            AND bagian LIKE '%KLO%'
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
        $data = [];
        // $data = $this->GlobalModel->QueryManualRow("
        //     SELECT COALESCE(SUM(nominal),0) as total FROM gaji_timpotong WHERE hapus=0 AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
        // ");
        $data = $this->GlobalModel->QueryManual("
            SELECT t.nama , a.* FROM gaji_timpotong a LEFT JOIN timpotong t ON t.id=a.timpotong WHERE a.hapus=0 AND DATE(a.tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."'
        ");
        
        return $data;
    }

    public function GajiFinishing($tanggal1,$tanggal2){
		$sql="SELECT * FROM gaji_finishing WHERE hapus=0 AND bagian LIKE '%Finishing%' ";
		$sql.=" AND DATE(tanggal1) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		$results=$this->GlobalModel->QueryManualRow($sql);
		$details=$this->GlobalModel->getData('gaji_finishing_detail',array('idgaji'=>$results['id']));
        $gaji=0;
        $karyawans=[];
			foreach($details as $d){
				$gaji=$this->GlobalModel->getDataRow('karyawan_harian',array('id'=>$d['idkaryawan']));
				$karyawans[]=array(
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

            $totgaji=0;
            foreach($karyawans as $k){
                $totgaji+=($k['senin']+$k['selasa']+$k['rabu']+$k['kamis']+$k['jumat']+$k['sabtu']+$k['minggu']+$k['lembur']+$k['insentif']-$k['claim']-$k['pinjaman']);
            }

        return pembulatangaji($totgaji);
	}

    function GajiGudang($tanggal1,$tanggal2){
        $totalpembulatan=0;
        $data['gaji']=$this->GlobalModel->QueryManual("
            SELECT * FROM gaji_finishing WHERE hapus=0 
            AND bagian LIKE '%Gudang%'
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

    function GajiSukabumi($tanggal1,$tanggal2){
        $results=array();
		$sql='SELECT * FROM gajisukabumi WHERE hapus=0 ';
		if(!empty($tanggal1)){
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}		
		$sql.=" ORDER BY id DESC ";
		$results= $this->GlobalModel->queryManualRow($sql);
        $hasil=0;
        $anggarantotal=0;        
        if(isset($results['total'])){
            $anggaran = $this->GlobalModel->QueryManualRow("SELECT COALESCE(SUM(total),0) as total from anggaran_operasional_sukabumi WHERE hapus=0 AND DATE(tanggal)='".$results['tanggal']."' ");
            $hasil=$results['total'] + $anggaran['total'];
        }
        return $hasil;
    }

    function AjuanHarian($tanggal1,$tanggal2){
        $results=array();
		$sql='SELECT COALESCE(SUM(cash),0) as total FROM pengajuan_harian_new WHERE hapus=0 and status=1 ';
		if(!empty($tanggal1)){
			$sql.=" AND DATE(tanggal) BETWEEN '".$tanggal1."' AND '".$tanggal2."' ";
		}		
		$sql.=" ORDER BY id DESC ";
		$results= $this->GlobalModel->queryManualRow($sql);
        $hasil=0;
        $anggarantotal=0;        
        if(isset($results['total'])){
            $hasil=$results['total'];
        }
        return $hasil;
    }


}