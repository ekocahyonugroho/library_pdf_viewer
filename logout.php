<?php  session_start();
if (isset($_SESSION['user']))
{ 
    include "conn.php";
	$logout = date('Y-m-d H:i:s', time());
    $date = date('Y-m-d', time());
	$cek = mysql_query("select * from log where user = '".$_SESSION["user"]."' and date = '$date'") or die (mysql_error());
	$num = mysql_num_rows($cek);
	
	if ($num == 0) {
		$log = mysql_query("insert into log values ('".$_SESSION["user"]."', '$date', '$logout', '')") or die(mysql_error());
		unset($_SESSION["user"]);
		unset($_SESSION["pass"]);
		unset($_SESSION["status"]);
		session_destroy();
		?><script language="javascript">
		document.location="index.php";
		</script><?php   
	}
	else if ($num <> 0) {
		$log = mysql_query("update log set logout = '$logout' where date = '$date' and user = '".$_SESSION["user"]."'") or die(mysql_error());
		unset($_SESSION["user"]);
		unset($_SESSION["pass"]);
		unset($_SESSION["status"]);
		session_destroy();
		?><script language="javascript">
		document.location="index.php";
		</script><?php
	}
	
}else{
	?><script language="javascript">
	alert("Sorry, you can't access this file directly");
	document.location="index.php";
	</script>
	<?php 
}
?>