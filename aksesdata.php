<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Jakarta");
$hariini = date('Y-m-d H:i:s');
$pass="?Bz%jsT]GyHp";
$user="forboysp_cronDB";
$conn = new mysqli("localhost", $user, $pass, "forboysp_2425");

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$sql = "UPDATE aksesdata SET nilai = 2, waktu = null, batas = null WHERE user_id NOT IN (10,11,7) AND batas <= '$hariini'";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    //echo "Update berhasil.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();

?>