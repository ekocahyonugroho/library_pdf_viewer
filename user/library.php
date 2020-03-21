<?php
include "session.php";
include "../conn.php";

$query_user = mysql_query("select * from user") or die (mysql_error());
$num_user = mysql_num_rows($query_user);

$sql_login = mysql_query("select * from user where user = '".$_SESSION['user']."'") or die (mysql_error());
$data_login = mysql_fetch_array($sql_login);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="../images/icon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Final Project Search Engine || SBM ITB Jakarta Campus</title>
<link href="../theme/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="../theme/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="../plugin/datatables_script/media/css/dataTables.bootstrap.css">
<link rel="stylesheet" type="text/css" href="../plugin/datatables_script/media/css/dataTables.responsive.css">

<script type="text/javascript" src="../theme/js/jquery.min.js"></script>
<script src="../theme/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="../theme/js/pass.js"></script>
<script type="text/javascript" language="javascript" src="../plugin/datatables_script/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../plugin/datatables_script/media/js/dataTables.responsive.js"></script>
<script type="text/javascript" language="javascript" src="../plugin/datatables_script/media/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" src="../plugin/datatables_script/media/js/common.js"></script>
    <script type="javascript">
        document.onkeydown = function (e) {
            e = e || window.event;//Get event
            if (e.ctrlKey) {
                var c = e.which || e.keyCode;//Get key code
                switch (c) {
                    case 83://Block Ctrl+S
                        e.preventDefault();
                        e.stopPropagation();
                        break;
                }
            }
        };
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-73649474-7"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-73649474-7');
    </script>


</head>
<body>
<div class="navbar-inverse"><img src="../images/logo2.png" width="250" height="auto" /></div>
<div class="navbar navbar navbar-inverse">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li><a style="border-radius: 10px;" href="?page=home">Final Project Data</a></li>
      <!-- <li class="dropdown">
        <a style="border-radius: 10px;" href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<b class="caret"></b></a>
        <ul class="dropdown-menu" style="opacity: 0.85; box-shadow: 10px 10px 5px #888888; border-radius: 10px;">
          <li><a href="?page=thesis&action=new">New Thesis Data</a></li>
          <li><a href="?page=thesis&action=import">Import Thesis data</a></li>
          <li><a href="?page=thesis&action=upload_pdf">Upload PDF</a></li>
          <li class="divider"></li>
          <li class="dropdown-header">User Access</li>
          <li><a href="?page=user&action=new">New User</a></li>
          <li><a href="?page=user&action=view">View User <span class="badge"><?php echo $num_user; ?> user</span></a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a style="border-radius: 10px;" href="#" class="dropdown-toggle" data-toggle="dropdown">Other<b class="caret"></b></a>
        <ul class="dropdown-menu" style="opacity: 0.85; box-shadow: 10px 10px 5px #888888; border-radius: 10px;">
          <li><a href="?page=conselor&view=yes">Academic Conselor</a></li>
          <li><a href="?page=program&view=yes">Program Data</a></li>
        </ul>
      </li> -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a style="border-radius: 10px;" href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $data_login['user']; ?><b class="caret"></b></a>
        <ul class="dropdown-menu" style="opacity: 0.85; box-shadow: 10px 10px 5px #888888; border-radius: 10px;">
          <li><a href="../logout.php" onclick="return confirm('Are you sure?')"><img src="https://cdn2.iconfinder.com/data/icons/picons-essentials/57/logout-128.png" width="25px" height="auto" /> Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<div id="page">
<div id="content">
<?php include "content.php"; ?>
</div>
</div>
</body>
</html>