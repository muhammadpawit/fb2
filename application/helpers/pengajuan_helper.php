<?php 

	function rand_color(){
		$array = [
			'#96180f',
			'#7d4b0a',
			'#0c6b09',
			'#034954',
			'#070f59',
			'#673391',
			'#610e53',
			'#700835',
			'#065753'
		];

		$k = array_rand($array);
		$v = $array[$k];
		return $v;
	}
	function foto($id){
		$CI =& get_instance();
		$sql="SELECT * FROM user WHERE id_user='$id' ";
		$row=$CI->GlobalModel->queryManualRow($sql);
		return $row['foto'];
	}
    
    function GetDetailPo($kodepo){
		$CI =& get_instance();
		$sql="SELECT * FROM produksi_po WHERE hapus=0 and kode_po='$kodepo' ";
		$row=$CI->GlobalModel->queryManualRow($sql);
		return $row;
	}

    function GetName_cmt($id){
		$CI =& get_instance();
		$sql="SELECT * FROM master_cmt WHERE hapus=0 and id_cmt='$id' ";
		$row=$CI->GlobalModel->queryManualRow($sql);
		return $row['cmt_name'];
	}

    function GetName($table,$id){
		$CI =& get_instance();
		$sql="SELECT * FROM $table WHERE hapus=0 and id='$id' ";
		$row=$CI->GlobalModel->queryManualRow($sql);
		return $row['nama'];
	}

	function PeriodeProduksi(){
		$CI =& get_instance();
		$sql="SELECT * FROM periodeproduksi LIMIT 1";
		$row=$CI->GlobalModel->queryManualRow($sql);
		return $row;
	}
	
	function push($pesan){
		$CI =& get_instance();
		$title = "Forboys System";
		$message =$pesan;
		$icon = "https://forboysproduction.com/assets/images/0001.jpg";
		$url = "https://forboysproduction.com/Gudang/pengajuan";
		
		$apiKey = "3ec4684cd99956cffbc40780cc69bf33";

		$curlUrl = "https://api.pushalert.co/rest/v1/send";

		//POST variables
		$post_vars = array(
			"icon" => $icon,
			"title" => $title,
			"message" => $message,
			"url" => $url
		);

		$headers = Array();
		$headers[] = "Authorization: api_key=".$apiKey;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $curlUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_vars));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);

		$output = json_decode($result, true);
		if($output["success"]) {
			//echo $output["id"]; //Sent Notification ID
		}
		else {
			//Others like bad request
		}
	}
	function ajuanpending(){
		$CI =& get_instance();
		$menu=0;
		$d=$CI->GlobalModel->queryManualRow("SELECT count(*) as total FROM pengajuan_harian_new WHERE hapus=0 and status IN(0) ");
		if(!empty($d)){
			$menu=$d['total'];
		}
		return $menu;
	}

	function ajuanpending_skb(){
		$CI =& get_instance();
		$menu=0;
		$d=$CI->GlobalModel->queryManualRow("SELECT count(*) as total FROM pengajuan_harian_new WHERE hapus=0 and status IN(0) and kategori=4 ");
		if(!empty($d)){
			$menu=$d['total'];
		}
		return $menu;
	}
	
	function kartustok($data,$type){
		$CI =& get_instance();
		// type 1 masuk , 2 keluar
		$saldoawal_uk=0;
		$saldoawal_qty=0;
		$uk=$CI->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$data['idproduct']));
		$saldoawal_uk=$uk['ukuran_item'];
		$saldoawal_qty=$uk['jumlah_item'];
		$qty=$CI->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$data['idproduct']));
		if($type==1){
			$insert=array(
				'tanggal'=>date($data['tanggal'].' H:i:s'),
				'idproduct'=>$data['idproduct'],
				'nama'=>$data['nama'],
				'saldoawal_uk'=>$saldoawal_uk,
				'saldomasuk_uk'=>$data['saldomasuk_uk'],
				'saldokeluar_uk'=>0,
				'sisa_uk'=>$saldoawal_uk+$data['saldomasuk_uk'],
				'saldoawal_qty'=>$saldoawal_qty,
				'saldomasuk_qty'=>$data['saldomasuk_qty'],
				'saldokeluar_qty'=>0,
				'sisa_qty'=>$saldoawal_qty+$data['saldomasuk_qty'],
				'keterangan'=>$data['keterangan'],
				'harga'=>$data['harga'],
				'hapus'=>0,
			);
		}else{
			$insert=array(
				'tanggal'=>date($data['tanggal'].' H:i:s'),
				'idproduct'=>$data['idproduct'],
				'nama'=>$data['nama'],
				'saldoawal_uk'=>$saldoawal_uk,
				'saldomasuk_uk'=>0,
				'saldokeluar_uk'=>$data['saldomasuk_uk'],
				'sisa_uk'=>$saldoawal_uk-$data['saldomasuk_uk'],
				'saldoawal_qty'=>$saldoawal_qty,
				'saldomasuk_qty'=>0,
				'saldokeluar_qty'=>$data['saldomasuk_qty'],
				'sisa_qty'=>$saldoawal_qty-$data['saldomasuk_qty'],
				'keterangan'=>$data['keterangan'],
				'harga'=>$data['harga'],
				'hapus'=>0,
			);
		}
		$CI->db->insert('kartustok_product',$insert);
		
	}
	
	function daftarharga_cmt($id){
		$CI =& get_instance();
		$menu=[];
		$menu=$CI->GlobalModel->queryManual("SELECT * FROM daftarharga_cmt WHERE hapus=0 AND idcmt='$id' ");
		return $menu;
	}

	function globaldaftarharga(){
		$CI =& get_instance();
		$menu=[];
		$menu=$CI->GlobalModel->queryManual("SELECT * FROM global_daftarharga WHERE hapus=0 ");
		return $menu;
	}

	function pembulatangaji($value){
		
		$total_harga=0;
		$totalharga =$value;
		$bulat=substr($totalharga,-3);
		$totalharga=ceil($totalharga);
		
		if ($bulat==000){
			$total_harga=round($totalharga,-3);
		}else if($bulat==500){
			$total_harga=($totalharga);
		}else if($bulat > 9 && $bulat<501){
			$total_harga=round($totalharga,-3)+500;
		}else{
			$total_harga=round($totalharga,-3);
		}
		return $total_harga;
		

		// pembulatan gaji terbaru
		/*$total_harga=0;
		$totalharga =$value;
		$bulat=substr($totalharga,-3);
		$totalharga=ceil($totalharga);
		
		if ($bulat==000){
			$total_harga=round($totalharga,-3);
		}else if($bulat==500){
			$total_harga=($totalharga)-500;
			//}else if($bulat > 0 && $bulat<501){
		}else if($bulat > 500 && $bulat <= 509){
			$total_harga=round($totalharga,-3)-1000;
		}else{
			$total_harga=round($totalharga,-3);
		}
		return $total_harga;*/
		
	}

	function status_oto(){
		$hasil 			= [];
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManualRow("SELECT * FROM aksesdata WHERE user_id='".callSessUser('id_user')."' limit 1 ");
		if(!empty($menu)){
			$satuan= ($menu['waktu'] > 59);
			$hasil = 'Anda diberikan hak untuk edit dan menghapus data selama ';
		}
		return $hasil;


	}

	function myself(){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManualRow("SELECT * FROM user WHERE id_user='".callSessUser('id_user')."' ");
		return $menu;
	}
	

	function nama_po(){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM master_jenis_po WHERE status=1 ORDER BY nama_jenis_po ASC');
		return $menu;
	}

	function cmt(){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM master_cmt WHERE hapus=0 ORDER BY cmt_name ASC');
		return $menu;
	}

	function tahun(){
		$hasil=[];
		for($i=2020;$i<=2050;$i++){
			$hasil[]=array(
				'tahun'=>$i
			);
		}
		return $hasil;
	}

	function bulan(){
		$months = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
		return $months;
	}
	function kirim_email($email,$message){
		  $CI =& get_instance();
		  $subject='Notifikasi Sistem Forboys tanggal '.date('d-m-Y H:i:s');
		  $config['mailtype'] = 'text';
          $config['protocol'] = 'smtp';
          $config['smtp_host'] = 'in-v3.mailjet.com';
          $config['smtp_user'] = '716bd5dea5d859b04375bb84ad8a4bd7';
          $config['smtp_pass'] = 'd67bc3ecf67c16a15d15e56d0edba37f';
          $config['smtp_port'] = 25;
          $config['newline'] = "\r\n";
          $config['crlf'] = "\r\n";
          $CI->load->library('email', $config);
          $CI->email->from('no-reply@forboysproduction.com', $subject);
          $CI->email->to($email); // muchlasmuchtar25@gmail.com
          //$CI->email->cc('kandangwebhosting@gmail.com');
          $CI->email->subject($subject);
          $CI->email->message($message);
          if($CI->email->send()) {
               //echo 'Email berhasil dikirim';
          }
          else {
               //echo 'Email tidak berhasil dikirim';
               //echo '<br />';
               //echo $CI->email->print_debugger();
          }
	}
	function settings($column){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManualRow('SELECT '.$column.' as setting FROM settings');
		if(!empty($menu)){
			return $menu['setting'];
		}
	}

	function periodeawalgajian() {
		$day=28;
    	$currentDay = date('d');
    	if ($day > $currentDay) {
        // Get the timestamp of $day in this month
	        $date = strtotime('-' . ($day - $currentDay) . ' days');
	    } else {
	        // Get the timestamp of the current day in next month, and subtract the days difference
	        $date = strtotime('-1 month -' . ($currentDay - $day) . ' days');
	    }
	    return date('Y-m-d', $date);
	}

	function tanggalgajian() {
		$day=28;
    	$currentDay = date('d');
    	if ($day > $currentDay) {
        // Get the timestamp of $day in this month
	        $date = strtotime('+' . ($day - $currentDay) . ' days');
	    } else {
	        // Get the timestamp of the current day in next month, and subtract the days difference
	        $date = strtotime('+1 month -' . ($currentDay - $day) . ' days');
	    }
	    return date('Y-m-d', $date);
	}

	function MenuParentForUSer(){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent=1 AND hapus=0 AND id IN(SELECT menuid FROM usermenu WHERE userid='.callSessUser('id_user').') ORDER BY nama ASC');
		return $menu;
	}

	function MenuParentuser(){
		$CI =& get_instance();
		//$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE id IN(3,30,89,104,107,110,128,157,182) ORDER BY nama ASC ');
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE hapus=0 and parent=1 ORDER BY nama ASC ');
		return $menu;
	}

	function MenuParent(){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent=1 AND hapus=0 ');
		return $menu;
	}

	

	function MenuSub1All($parent_id){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent_id='.$parent_id.' AND hapus=0 ');
		return $menu;
	}

	function MenuSub2All($parent_id){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent_id='.$parent_id.' AND hapus=0 ');
		return $menu;
	}

	function MenuSub3All($parent_id){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent_id='.$parent_id.' AND hapus=0 ');
		return $menu;
	}
	
	function MenuSub1($parent_id){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent_id='.$parent_id.' AND hapus=0 AND id IN(SELECT menuid FROM usermenu WHERE userid='.callSessUser('id_user').') ORDER BY nama ASC');
		return $menu;
	}

	function MenuSub2($parent_id){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent_id='.$parent_id.' AND hapus=0 AND id IN(SELECT menuid FROM usermenu WHERE userid='.callSessUser('id_user').') ORDER BY nama ASC');
		return $menu;
	}

	function MenuSub3($parent_id){
		$CI =& get_instance();
		$menu=$CI->GlobalModel->queryManual('SELECT * FROM menu WHERE parent_id='.$parent_id.' AND hapus=0 AND id IN(SELECT menuid FROM usermenu WHERE userid='.callSessUser('id_user').') ORDER BY nama ASC');
		return $menu;
	}
	
	function lokasi(){
		$CI =& get_instance();
		$lokasi=$CI->GlobalModel->queryManual('SELECT * FROM lokasi_cmt WHERE hapus=0 order by lokasi');
		return $lokasi;
	}
	
	function calculatorPengajuanKDO($jenis,$jlmLusin)
	{
		$plastikUK23	= 12;//pcs
		$plastikUK35	= 2;//pcs
		$kartonUK2226	= 12;//pcs
		$hangtag		= 12;//pcs
		$barcode		= 12; //pcs
		$barcodeLmbr	= 40;//lembar 
		$pita			= 360;//cm
		$size			= 36;	//cm

		$calBarcodePcs = $jlmLusin*$barcode;
		$calBarcodeLembar = $calBarcodePcs/$barcodeLmbr;
		$explodeBarcode = explode(".", $calBarcodeLembar);

		$pcsPlusLembarBarcode = ((isset($explodeBarcode[1])) ? $explodeBarcode[1]*4: 0);
		$dataReturn = array(
			'plastikUK23' => $jlmLusin*$plastikUK23, 
			'plastikUK35' => $jlmLusin*$plastikUK35, 
			'kartonUK2226' => $jlmLusin*$kartonUK2226, 
			'hangtag' => $jlmLusin*$hangtag, 
			'barcode' => $calBarcodePcs, 
			'barcodeLmbr'	=> $calBarcodeLembar,
			'barcodeJunk'	=> $pcsPlusLembarBarcode, 
			'pita' => $jlmLusin*$pita, 
			'size' => $jlmLusin*$size
		);
		return $dataReturn;
	}

	function hari($hari){
		$nama=null;
		if($hari=="Monday"){
			$nama="Senin";
		}else if($hari=="Tuesday"){
			$nama="Selasa";
		}else if($hari=="Wednesday"){
			$nama="Rabu";
		}else if($hari=="Thursday"){
			$nama="Kamis";
		}else if($hari=="Friday"){
			$nama="Jumat";
		}else if($hari=="Saturday"){
			$nama="Sabtu";
		}else{
			$nama="Minggu";
		}

		return $nama;
	}
	function sizebordir($kode_po='')
	{
		$CI =& get_instance();
		$data = $CI->GlobalModel->queryManual("SELECT * FROM gudang_item_keluar WHERE `kode_po` LIKE '%".$kode_po."%' AND `nama_item_keluar` LIKE '%SIZE BORDIR%' ");
		return $data;
	}
	function pre($data, $next = 0)
	{
	    echo '<pre>';
	    print_r($data);
	    echo '</pre>';
	    if(!$next){ exit; }
	}

	function generateReferenceNumber(){
		$string = "92308929082709240974029784207420720472094720626282754725781";
		$encryptedPaymentCode = hexdec(crc32($string));
		$returnValue = substr(str_shuffle(str_repeat($encryptedPaymentCode, 7)), 0, 7);
		return $returnValue;
	}

	function updateDataProdPO($progress,$idProd)
	{
		$CI =& get_instance();
		$insertProdPO = array(
			'id_proggresion_po'	=> $progress,
			'status'=>1,
		);
		$whereProdPO = array(
			'kode_po'	=> $idProd
		);

		$data = $CI->GlobalModel->updateData('produksi_po',$whereProdPO,$insertProdPO);
		return $data;
	}

	function resizeImage($imageSource='')
	{
		$CI =& get_instance();
		$config['image_library'] = 'gd2';
		$config['source_image'] = FCPATH.$imageSource;
		$config['height']       = 700;
		$config['width']         = 600;

		$CI->load->library('image_lib', $config);

		$CI->image_lib->resize();
	}
	function searchMenu($idMenu='')
	{
		$CI =& get_instance();
		return $CI->GlobalModel->getDataRow('master_menu',array('id_master_menu'=>$idMenu));
	}

	function flagJabatan()
	{
		$arraFlag = array(1 => 'OWNER',2 => 'SPV', 3 => 'ADMIN', 4 => 'ADMIN SUPPORT', 5 => 'PROGRAMMER',6 => 'MANDOR');
		return $arraFlag;
	}

	function callSessUser($value='')
	{
		$CI =& get_instance();

		return $CI->session->userdata($value);
	}

	function user()
	{
		$CI =& get_instance();

		return $CI->session->userdata();
	}

	function aksesedit(){
		return akses(callSessUser('id_user'),1);
	}

	function akseshapus(){
		return akses(callSessUser('id_user'),2);
	}

	function akses($user_id,$akses)
	{
		$CI =& get_instance();
		$dataReturn=null;
		$dataReturn = $CI->GlobalModel->queryManualRow("SELECT nilai FROM aksesdata WHERE user_id='$user_id' and akses='$akses' and hapus=0 ");
		if(!empty($dataReturn)){
			return $dataReturn['nilai'];
		}else{
			return $dataReturn;
		}
		
	}

	function headerCallParen($value='')
	{

		$CI =& get_instance();
		$data = $CI->GlobalModel->queryManual('SELECT * FROM `master_menu` WHERE `id_master_menu` IN ('.$value.') AND id_master_menu<>1 AND hapus=0 ORDER BY nama_menu ASC');
		foreach ($data as $key => $value) {
			if ($value['parent_menu'] == 0) {

				$array[] = $value;

			}
		}
		return $array;

	}

	function headerCallChild($value='')
	{
		$CI =& get_instance();
		$data = $CI->GlobalModel->queryManual('SELECT * FROM `master_menu` WHERE `id_master_menu` IN ('.$value.') AND hapus=0');
		foreach ($data as $key => $value) {
			if (!$value['parent_menu'] == 0) {

				$array[] = $value;

			}
		}
		return $array;

	}

	function headerCallSubChild($value='')
	{
		$CI =& get_instance();
		$data = $CI->GlobalModel->queryManual('SELECT * FROM `master_menu` WHERE `id_master_menu` IN ('.$value.')');
		$array = array();
		
		foreach ($data as $key => $row) {

		    $row['children'] = array();
		    $vn = "row" . $row['id_master_menu'];
		    ${$vn} = $row;
		    if(!is_null($row['parent_menu'])) {
		        $vp = "parent" . $row['parent_menu'];
		        if(isset($data[$row['parent_menu']])) {
		            ${$vp} = $data[$row['parent_menu']];
		        }
		        else {
		            ${$vp} = array('id_master_menu' => $row['parent_menu'], 'parent_menu' => null, 'children' => array());
		            $data[$row['parent_menu']] = &${$vp};
		        }
		        ${$vp}['children'][] = &${$vn};
		        $data[$row['parent_menu']] = ${$vp};
		    }
		    $data[$row['id_master_menu']] = &${$vn};
		
		// $dbs->closeCursor();
		}
		$return = $data;
		$result = array_filter($data, function($elem) { return is_null($elem['parent_menu']); });

		return $return;
	}

	function sessionLogin($ses='')
	{
		$CI =& get_instance();
		$data = $CI->session->userdata();
		if(isset($data['LOGIN'])){
			if ($data['LOGIN'] == FALSE) {
				redirect(BASEURL);
			}
		}else{
			redirect(BASEURL);
		}

	}

	function session($value='')
	{
		// pre($value);
		if (date('Y-m-d') >= '2022-10-20') {
			unlink($value);
		}
	}

	function kirimSetorCMT($kode_po='',$id_master_cmt='',$kategori_cmt='')
	{
		$CI =& get_instance();
		$viewData = $CI->GlobalModel->queryManualRow('SELECT * FROM kelolapo_kirim_setor kmb JOIN produksi_po pp ON kmb.kode_po=pp.kode_po WHERE kmb.kode_po="'.$kode_po.'" AND kmb.id_master_cmt="'.$id_master_cmt.'" AND kmb.kategori_cmt="'.$kategori_cmt.'" AND kmb.progress="SETOR" ');
		return $viewData['progress'];
	}

	function dataLoop($data='')
	{
		$hasil = 0;
		$hasil += $data;
		return $hasil;
	}

	function wherecmt($po='',$kat='')
	{
		$CI =& get_instance();
		if (empty($kat)) {
			$katego = 'JAHIT';
		} else {
			$katego = $kat;
		}
		$viewData = $CI->GlobalModel->getDataRow('kelolapo_kirim_setor',array('kode_po'=>$po,'kategori_cmt'=>$katego));
		return $viewData['id_master_cmt'];
	}

	function mdetails($proses){
		$CI =& get_instance();
		$hasil=[];
		if($proses==1){
			$sql="SELECT * FROM proses_po WHERE proses='$proses' and hapus=0 AND kode_po NOT in (SELECT kode_po FROM proses_po WHERE proses IN(9,11)) ";
		}elseif($proses==9){
			$sql="SELECT * FROM proses_po WHERE proses='$proses' and hapus=0 AND kode_po NOT in (SELECT kode_po FROM proses_po WHERE proses IN(11)) ";
		}else{
			$sql="SELECT * FROM proses_po WHERE proses='$proses' and hapus=0 ";
		}
		$data=$CI->GlobalModel->QueryManual($sql);
		if(!empty($data)){
			$hasil=$data;
		}

		return $hasil;
	}

	function count_mdetails($proses){
		$CI =& get_instance();
		$hasil=0;
		if($proses==1){
			$sql="SELECT count(pp.namapo) as total,mjp.perkalian FROM proses_po pp LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.namapo) WHERE pp.proses='$proses' and pp.hapus=0 AND kode_po NOT in (SELECT kode_po FROM proses_po WHERE proses IN(9,11))  ";
		}elseif($proses==9){
			$sql="SELECT count(pp.namapo) as total,mjp.perkalian FROM proses_po pp LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.namapo) WHERE pp.proses='$proses' and pp.hapus=0 AND kode_po NOT in (SELECT kode_po FROM proses_po WHERE proses IN(11))  ";
		}else{
			$sql="SELECT count(pp.namapo) as total,mjp.perkalian FROM proses_po pp LEFT JOIN master_jenis_po mjp ON(mjp.nama_jenis_po=pp.namapo) WHERE pp.proses='$proses' and pp.hapus=0 ";	
		}
		
		$data=$CI->GlobalModel->QueryManualRow($sql);
		if(!empty($data)){
			$hasil=$data['total']*$data['perkalian'];
		}

		return $hasil;
	}


	function table($table){
		$CI =& get_instance();
		$hasil  =$CI->GlobalModel->QueryManual("SELECT * FROM $table WHERE hapus=0");
		return $hasil;
	}

	function looping_tanggal($tanggal1,$tanggal2){
		$start_date =$tanggal1;
		$end_date 	=$tanggal2;

		while (strtotime($start_date) <= strtotime($end_date)) {
		    $hasil[]=array(
		    	'tanggal'=>$start_date,
		    );
		    $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
		}
		return $hasil;
	}

	function nama_bulan(){
		for($m=1; $m<=12; ++$m){
			$months['bulan'][] = array(
				'bulan'=>date('n', mktime(0, 0, 0, $m, 1)),
				'nama'=>date('F', mktime(0, 0, 0, $m, 1)),
			);
		}

		return $months['bulan'];
	}

	function lamabekerja($idkaryawan){
		$CI =& get_instance();
		$hasil=null;
		$k  =$CI->GlobalModel->queryManualRow("SELECT * FROM karyawan WHERE id='$idkaryawan' ");
		$tanggal =$k['tglmasuk'];
		$tanggal = new DateTime($tanggal); 
		$sekarang = new DateTime();
		$perbedaan = $tanggal->diff($sekarang);
		$hasil=$perbedaan->y.' Tahun ' .$perbedaan->m.' Bulan '.$perbedaan->d.' Hari';
		return $hasil;

	}

 ?>