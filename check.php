<?php
$db = new mysqli('localhost', 'pawit', '@Maspawit28', 'forboysp_2425');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$result = $db->query("SELECT * FROM rekapinsentif_security WHERE tanggal1 >= '2026-07-01'");
if ($result) {
    while($row = $result->fetch_assoc()) {
        print_r($row);
    }
}
?>
