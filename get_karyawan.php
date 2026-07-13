<?php
$db = new mysqli('localhost', 'pawit', '@Maspawit28', 'forboysp_2425');
$names = ['ACHMAD DAILAMY', 'ARFAN', 'RUDI', 'SUGENG', 'TAUFAN MAULANA', 'ZULKIFLI'];
foreach ($names as $name) {
    $res = $db->query("SELECT id, nama FROM karyawan WHERE nama LIKE '%$name%'");
    if ($res) {
        $row = $res->fetch_assoc();
        echo $name . " -> " . $row['id'] . "\n";
    }
}
?>
