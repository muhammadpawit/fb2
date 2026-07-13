<?php
$db = new mysqli('localhost', 'pawit', '@Maspawit28', 'forboysp_2425');

$data = [
    [36, 200000, 0, 100000, 300000],
    [6, 200000, 30000, 0, 170000],
    [54, 200000, 5000, 0, 195000],
    [9, 200000, 0, 100000, 300000],
    [19, 200000, 90000, 0, 110000],
    [74, 200000, 0, 100000, 300000]
];

$t1 = '2026-07-06';
$t2 = '2026-07-13';

// Delete first
$db->query("DELETE FROM rekapinsentif_security WHERE tanggal1='$t1' AND tanggal2='$t2'");

foreach ($data as $d) {
    $db->query("INSERT INTO rekapinsentif_security (tanggal1, tanggal2, karyawan_id, insentif, potongan, uang_tambahan, total_diterima) VALUES ('$t1', '$t2', {$d[0]}, {$d[1]}, {$d[2]}, {$d[3]}, {$d[4]})");
}
echo "Inserted";
?>
