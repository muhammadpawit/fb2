<?php
$file = '/var/www/fb2/application/controllers/Monitoring.php';
$content = file_get_contents($file);

$kirimgudang_new = '	public function kirimgudang() {
		$data=[];
		$data[\'title\']=\'Monitoring Kirim Gudang\';
		$get=$this->input->get();
		if(isset($get[\'tanggal1\'])){
			$tanggal1=$get[\'tanggal1\'];
		}else{
			$tanggal1=date(\'Y-m-d\',strtotime("first day of previous month"));
		}
		if(isset($get[\'tanggal2\'])){
			$tanggal2=$get[\'tanggal2\'];
		}else{
			$tanggal2=date(\'Y-m-d\',strtotime(\'last day of this month\'));
		}
		$data[\'tanggal1\']=$tanggal1;
		$data[\'tanggal2\']=$tanggal2;
    	$j=1;
		$pdz=0;
		$ppcs=0;
		$jmlpo=0;
		$arpo=array(
			array(\'type\'=>\'Kemeja\',\'id\'=>1),
			array(\'type\'=>\'Kaos\',\'id\'=>2),
			array(\'type\'=>\'Celana\',\'id\'=>3),
		);
		
		$i=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$res = $this->ReportModel->get_monitoring_kirimgudang_stat($arp[\'id\'],$tanggal1,$tanggal2);
			$data[\'rekap\'][]=array(
				\'no\'=>$i,
				\'id\'=>$arp[\'id\'],
				\'type\'=>$arp[\'type\'],
				\'po\'=>$res->po,
				\'dz\'=>$res->pcs/12,
				\'pcs\'=>$res->pcs,
				\'total\'=>$res->total,
			);
			$i++;
		}
		//pre($data[\'rekap\']);
		// kemeja
		$kemeja=$this->GlobalModel->Getdata(\'master_jenis_po\',array(\'tampil\'=>1,\'status\'=>1,\'idjenis\'=>1));
		$nok=1;
		foreach($kemeja as $k){
			$res_det = $this->ReportModel->get_monitoring_kirimgudang_stat_detail($k[\'nama_jenis_po\'],$k[\'id_jenis_po\'],$tanggal1,$tanggal2);
			$data[\'rekapkemeja\'][]=array(
				\'no\'=>$nok++,
				\'id\'=>$k[\'id_jenis_po\'],
				\'type\'=>$k[\'nama_jenis_po\'],
				\'po\'=>$res_det->po*$k[\'perkalian\'],
				\'dz\'=>$res_det->pcs/12,
				\'pcs\'=>$res_det->pcs,
				\'total\'=>$res_det->total,
				\'hppdz\'=>($res_det->pcs>0)?( $res_det->total / ($res_det->pcs/12) ):0,
				\'hpppcs\'=>($res_det->pcs>0)?($res_det->total/$res_det->pcs):0,
			);
		}

		//pre($data[\'rekapkemeja\']);

		
		
		// kaos 
		$kaos=$this->GlobalModel->Getdata(\'master_jenis_po\',array(\'tampil\'=>1,\'status\'=>1,\'idjenis\'=>2));
		$nokaos=1;
		foreach($kaos as $k){
			$res_det = $this->ReportModel->get_monitoring_kirimgudang_stat_detail($k[\'nama_jenis_po\'],$k[\'id_jenis_po\'],$tanggal1,$tanggal2);
			$data[\'rekapkaos\'][]=array(
				\'no\'=>$nokaos++,
				\'id\'=>$k[\'id_jenis_po\'],
				\'type\'=>$k[\'nama_jenis_po\'],
				\'po\'=>$res_det->po*$k[\'perkalian\'],
				\'dz\'=>$res_det->pcs/12,
				\'pcs\'=>$res_det->pcs,
				\'total\'=>$res_det->total,
				\'hppdz\'=>($res_det->pcs>0)?( $res_det->total / ($res_det->pcs/12) ):0,
				\'hpppcs\'=>($res_det->pcs>0)?($res_det->total/$res_det->pcs):0,
			);
		}

		// celana
		$celana=$this->GlobalModel->Getdata(\'master_jenis_po\',array(\'tampil\'=>1,\'status\'=>1,\'idjenis\'=>3));
		$nocelana=1;
		$data[\'rekapcelana\']=array();
		foreach($celana as $k){
			$res_det = $this->ReportModel->get_monitoring_kirimgudang_stat_detail($k[\'nama_jenis_po\'],$k[\'id_jenis_po\'],$tanggal1,$tanggal2);
			$data[\'rekapcelana\'][]=array(
				\'no\'=>$nocelana++,
				\'id\'=>$k[\'id_jenis_po\'],
				\'type\'=>$k[\'nama_jenis_po\'],
				\'po\'=>$res_det->po*$k[\'perkalian\'],
				\'dz\'=>$res_det->pcs/12,
				\'pcs\'=>$res_det->pcs,
				\'total\'=>$res_det->total,
				\'hppdz\'=>($res_det->pcs>0)?( $res_det->total / ($res_det->pcs/12) ):0,
				\'hpppcs\'=>($res_det->pcs>0)?($res_det->total/$res_det->pcs):0,
			);
		}


		//adjustment
		$this->load->model(\'AdjustModel\');
		$adjustment=[];
		$filter_adj=array(
			\'tampil\'=>1,
			\'hapus\'=>0,
		);
		$adjustment=$this->AdjustModel->kirimgudang($filter_adj);
		$data[\'adjustment\'] = $adjustment;
		$data[\'adjustment_detail\']=[];
		$adjustment_detail=$this->AdjustModel->kirimgudang_detail($filter_adj);
		$data[\'adjustment_detail\'] = $adjustment_detail;

		if(isset($get[\'excel\'])){
			$data[\'page\']=$this->page.\'kirimgudang\';
			$this->load->view($this->page.\'kirimgudang_excel\',$data);
		}else{
			$data[\'page\']=$this->page.\'kirimgudang\';
			$this->load->view($this->layout.\'main\',$data);
		}
	}';

$penjualan_new = '	public function penjualan() {
		$data=[];
		$data[\'title\']=\'Monitoring Penjualan Langsung & Online  \';
		$get=$this->input->get();
		if(isset($get[\'tanggal1\'])){
			$tanggal1=$get[\'tanggal1\'];
		}else{
			$tanggal1=date(\'Y-m-d\',strtotime("first day of previous month"));
		}
		if(isset($get[\'tanggal2\'])){
			$tanggal2=$get[\'tanggal2\'];
		}else{
			$tanggal2=date(\'Y-m-d\',strtotime(\'last day of this month\'));
		}
		$data[\'tanggal1\']=$tanggal1;
		$data[\'tanggal2\']=$tanggal2;
    	$j=1;
		$pdz=0;
		$ppcs=0;
		$jmlpo=0;
		$arpo=array(
			array(\'type\'=>\'Kemeja\',\'id\'=>1),
			array(\'type\'=>\'Kaos\',\'id\'=>2),
			array(\'type\'=>\'Celana\' ,\'id\'=>3),
		);
		
		$i=1;
		$qty=0;
		$qtysetor=0;
		$ckirim=0;
		$csetor=0;
		foreach($arpo as $arp){
			$res = $this->ReportModel->get_monitoring_kirimgudangLangsung_stat($arp[\'id\'],$tanggal1,$tanggal2);
			$data[\'rekap\'][]=array(
				\'no\'=>$i,
				\'id\'=>$arp[\'id\'],
				\'type\'=>$arp[\'type\'],
				\'po\'=>$res->po,
				\'dz\'=>$res->pcs/12,
				\'pcs\'=>$res->pcs,
				\'total\'=>$res->total,
			);
			$i++;
		}
		//pre($data[\'rekap\']);
		// kemeja
		$kemeja=$this->GlobalModel->Getdata(\'master_jenis_po\',array(\'online\'=>\'ya\',\'status\'=>1,\'idjenis\'=>1));
		$nok=1;
		foreach($kemeja as $k){
			$res_det = $this->ReportModel->get_monitoring_kirimgudangLangsung_stat_detail($k[\'nama_jenis_po\'],$k[\'id_jenis_po\'],$tanggal1,$tanggal2);
			$data[\'rekapkemeja\'][]=array(
				\'no\'=>$nok++,
				\'id\'=>$k[\'id_jenis_po\'],
				\'type\'=>$k[\'nama_jenis_po\'],
				\'po\'=>$res_det->po*$k[\'perkalian\'],
				\'dz\'=>$res_det->pcs/12,
				\'pcs\'=>$res_det->pcs,
				\'total\'=>$res_det->total,
				\'hppdz\'=>($res_det->pcs>0)?( $res_det->total / ($res_det->pcs/12) ):0,
				\'hpppcs\'=>($res_det->pcs>0)?($res_det->total/$res_det->pcs):0,
			);
		}

		//pre($data[\'rekapkemeja\']);

		
		
		// kaos 
		$kaos=$this->GlobalModel->Getdata(\'master_jenis_po\',array(\'online\'=>\'ya\',\'status\'=>1,\'idjenis\'=>2));
		$nokaos=1;
		foreach($kaos as $k){
			$res_det = $this->ReportModel->get_monitoring_kirimgudangLangsung_stat_detail($k[\'nama_jenis_po\'],$k[\'id_jenis_po\'],$tanggal1,$tanggal2);
			$data[\'rekapkaos\'][]=array(
				\'no\'=>$nokaos++,
				\'id\'=>$k[\'id_jenis_po\'],
				\'type\'=>$k[\'nama_jenis_po\'],
				\'po\'=>$res_det->po*$k[\'perkalian\'],
				\'dz\'=>$res_det->pcs/12,
				\'pcs\'=>$res_det->pcs,
				\'total\'=>$res_det->total,
				\'hppdz\'=>($res_det->pcs>0)?( $res_det->total / ($res_det->pcs/12) ):0,
				\'hpppcs\'=>($res_det->pcs>0)?($res_det->total/$res_det->pcs):0,
			);
		}

		// celana
		$celana=$this->GlobalModel->Getdata(\'master_jenis_po\',array(\'online\'=>\'ya\',\'status\'=>1,\'idjenis\'=>3));
		$nocelana=1;
		foreach($celana as $k){
			$res_det = $this->ReportModel->get_monitoring_kirimgudangLangsung_stat_detail($k[\'nama_jenis_po\'],$k[\'id_jenis_po\'],$tanggal1,$tanggal2);
			$data[\'rekapcelana\'][]=array(
				\'no\'=>$nocelana++,
				\'id\'=>$k[\'id_jenis_po\'],
				\'type\'=>$k[\'nama_jenis_po\'],
				\'po\'=>$res_det->po*$k[\'perkalian\'],
				\'dz\'=>$res_det->pcs/12,
				\'pcs\'=>$res_det->pcs,
				\'total\'=>$res_det->total,
				\'hppdz\'=>($res_det->pcs>0)?( $res_det->total / ($res_det->pcs/12) ):0,
				\'hpppcs\'=>($res_det->pcs>0)?($res_det->total/\$res_det->pcs):0,
			);
		}


		//adjustment
		$this->load->model(\'AdjustModel\');
		$adjustment=[];
		$filter_adj=array(
			\'tampil\'=>1,
			\'hapus\'=>0,
		);
		$adjustment=$this->AdjustModel->kirimgudang($filter_adj);
		$data[\'adjustment\'] = $adjustment;
		$data[\'adjustment_detail\']=[];
		$adjustment_detail=$this->AdjustModel->kirimgudang_detail($filter_adj);
		$data[\'adjustment_detail\'] = $adjustment_detail;

		if(isset($get[\'excel\'])){
			$data[\'page\']=$this->page.\'kirimgudang\';
			$this->load->view($this->page.\'kirimgudang_excel\',$data);
		}else{
			$data[\'page\']=$this->page.\'penjualan\';
			$this->load->view($this->layout.\'main\',$data);
		}
	}';

// Regex to replace the whole functions
$pattern_kg = '/public function kirimgudang\(\) \{.*?\}\n\n\n	public function penjualan/s';
$pattern_pj = '/public function penjualan\(\) \{.*?\}\n\n\n	public function bahanmasuk/s';

// Wait, I will use strpos and substr_replace for safety.
$start_kg = strpos($content, "public function kirimgudang()");
$end_kg = strpos($content, "public function penjualan()");
if ($start_kg !== false && $end_kg !== false) {
    $content = substr_replace($content, $kirimgudang_new . "\n\n\n	", $start_kg, $end_kg - $start_kg);
}

// Re-find penjualan as its position might have changed
$start_pj = strpos($content, "public function penjualan()");
$end_pj = strpos($content, "public function bahanmasuk()");
if ($start_pj !== false && $end_pj !== false) {
    $content = substr_replace($content, $penjualan_new . "\n\n\n	", $start_pj, $end_pj - $start_pj);
}

file_put_contents($file, $content);
echo "Final replacement successful\n";
