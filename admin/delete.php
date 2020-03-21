<?php
include "session.php";
include "../conn.php";
if (!empty($_GET['id'])) {
	$id = $_GET['id'];
	
	$cek = mysql_query("select * from file where id = '$id'") or die (mysql_error());
	$num = mysql_num_rows($cek);
	
	if ($num > 0) {
		$del = mysql_query("delete from file where id = '$id'") or die (mysql_error());
		if (!mysql_error()) {
		   $del = mysql_query("delete from thesis where id = '$id'") or die (mysql_error());
		   ?>
           			<script language="javascript">
						alert("Data has been deleted");
	    				document.location="?page=home";
					</script>
           <?php
		}
	}
	else if ($num == 0) {
		$del = mysql_query("delete from thesis where id = '$id'") or die (mysql_error());
		   ?>
           			<script language="javascript">
						alert("Data has been deleted");
	    				document.location="?page=home";
					</script>
           <?php
	}
}
?>