<?php
date_default_timezone_set("Asia/Jakarta");
/*
'username' => 'forboysp_root',
	'password' => '@F0rb0ys2021',
	'database' => 'forboysp_forboys',
*/
// script cron job :  /usr/bin/php /home/forr3631/public_html/testing.php
$hariini=date('Y-m-d H:i:s');
$conn = new mysqli("localhost","forboysp_2223","@F0rb0ys2021","forboysp_2223");
$sql = "UPDATE aksesdata set nilai=2,waktu=null,batas=null WHERE user_id NOT IN(10,11,7) and batas<='$hariini'  ";
$conn->query($sql);
?>