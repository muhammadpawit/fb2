<?php
// Mock script to connect to db and test the logic
$db = new mysqli('localhost', 'pawit', '@Maspawit28', 'forboysp_2425');
$idpo = 4843;
$setor = $db->query("SELECT * FROM kelolapo_rincian_setor_cmt WHERE idpo=$idpo")->fetch_assoc();
$id_cmt = '';
if(!empty($setor)){
    $nama_cmt = $setor['nama_cmt'];
    $cmt = $db->query("SELECT id_cmt FROM master_cmt WHERE cmt_name = '".$db->real_escape_string($nama_cmt)."' AND hapus=0 LIMIT 1")->fetch_assoc();
    if(!empty($cmt)){
        $id_cmt = $cmt['id_cmt'];
    }
}
echo "id_cmt: " . $id_cmt . "\n";
if(empty($id_cmt)){
    $kks = $db->query("SELECT id_master_cmt FROM kelolapo_kirim_setor WHERE idpo='$idpo' AND kategori_cmt='JAHIT' ORDER BY id_kelolapo_kirim_setor DESC LIMIT 1")->fetch_assoc();
    $id_cmt = !empty($kks) ? $kks['id_master_cmt'] : '';
    echo "Fallback id_cmt: " . $id_cmt . "\n";
}
