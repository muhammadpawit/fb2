<?php
$db = new mysqli('localhost', 'pawit', '@Maspawit28', 'forboysp_2425');
$res = $db->query("DESCRIBE master_po_online_detail");
while($row = $res->fetch_assoc()){
    print_r($row);
}
?>
