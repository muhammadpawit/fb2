<?php
$namafile='Laporan_Pembelian_Lokal_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>

<table border="1" style="width: 100%;border-collapse: collapse;">