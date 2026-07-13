<?php
$db = new mysqli('localhost', 'pawit', '@Maspawit28', 'forboysp_2425');
$res = $db->query("
    SELECT b.id as id_master_po_online, c.kode_po, d.nama as serian
    FROM master_po_online_detail a 
    LEFT JOIN master_po_online b ON b.id = a.id_master_po_online
    LEFT JOIN produksi_po c ON c.id_produksi_po=b.id_po
    LEFT JOIN master_po_online_serian d ON d.id=a.id_serian
    WHERE a.hapus=0 AND b.hapus=0 AND a.pcs > 0 
    GROUP BY b.id, a.id_serian
    LIMIT 10
");
while($row = $res->fetch_assoc()){
    print_r($row);
}
?>
