<?php 
ini_set('display_errors',FALSE);
$host="localhost";
$user="root";
$pass="123sbm1tb123";
$db="lib";


$koneksi=mysql_connect($host,$user,$pass);
mysql_select_db($db,$koneksi);

if ($koneksi)
{
	//echo "berhasil : )";
}else{
	?><script language="javascript">alert("Failed to connected with Database Server !!")</script><?php 
}

?>