<?php
if(!isset($_SESSION)) 
 { 
    session_start(); 
	if (!empty($_SESSION['user'])) {
		if ($_SESSION['status'] == 'admin') {
			?><script language="javascript">
			alert("Sorry, this page for user only!");
			document.location="../admin/library.php?page=home";
			</script>
			<?php 	
		}
	}
	else if (empty($_SESSION['user']))
	{
		?><script language="javascript">
		alert("Sorry, you must be login first to access this page");
		document.location="../login.php";
		</script>
		<?php 	
	}
  } 
else {
  if (!empty($_SESSION['user'])) {
		if ($_SESSION['status'] == 'admin') {
			?><script language="javascript">
			alert("Sorry, this page for admin only!");
			document.location="../admin/library.php?page=home";
			</script>
			<?php 	
		}
	}
	else if (empty($_SESSION['user']))
	{
		?><script language="javascript">
		alert("Sorry, you must be login first to access this page");
		document.location="../index.php";
		</script>
		<?php 	
	}	  
}
?>