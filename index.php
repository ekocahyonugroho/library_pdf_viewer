
<html>
<head>
    <title>Login</title>
    <link rel="shortcut icon" href="images/icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/icon.ico" />
    <link href="theme/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="theme/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/font-awesome/css/font-awesome.min.css">

    <script type="text/javascript" src="theme/js/jquery.min.js"></script>
    <script src="theme/js/bootstrap.min.js"></script>
    <script src="jquery1.10.1.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
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
<p><center>
  <img src="images/logo.png" width="350" height="auto" />
</center></p>
<p>&nbsp;</p>
<table width="19%" border="0" cellpadding="0" cellspacing="0" bordercolor="#99CC99" align="center">
<tr> 
	<td width="4%" align="right"><img src="images/kiri.jpg"></td>
	<td width="74%" bgcolor="#5686c6" ><div align="center"><strong><font face="verdana" size="2" color="#FFFFFF">LOGIN</font></strong></div></td>
	<td width="21%"><img src="images/kanan.jpg"></td>
</tr>
<tr>
	<td background="images/b-kiri.jpg">&nbsp;</td>
	<td>
	<table width="259" align="center">
		<tr><td width="251"><font face="verdana" size="2">&nbsp;
		</font>
		
		<form action="auth.php" method="post" name="postform" id="postform">
            <input type="hidden" name="ip" id="ip" value="" />
            <input type="hidden" name="city" id="city" value="" />
            <input type="hidden" name="org" id="org" value="" />
            <input type="hidden" name="geo" id="geo" value="" />
		  <table width="251" height="101" border="0" align="center">
		  <tr valign="bottom">
			<td width="104" height="35"><font size="4" face="verdana">Username</font></td>
			  <td width="137"><font size="4" face="verdana">
				<input autocomplete="off" type="text" class="form-control" name="userid" size="20" id="userid">
			  </font></td>
		  </tr>
		  
		  <tr valign="top">
			<td height="34"><font size="4" face="verdana">Password</font></td>
			  <td><font size="4" face="verdana">
				<input type="password" class="form-control" name="pass" size="20" id="passwd">
			  </font></td>
		  </tr>
		  
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		  	<td>&nbsp;</td>
		  	<td><font size="4" face="verdana">
				<input type="submit" class="btn btn-primary" value="LOGIN">
			  </font></td>
		  </tr>
		  </table>
		</form>
		
				
		</td></tr>
	</table>
	</td>
	<td background="images/b-kanan.jpg">&nbsp;</td>
	<td width="1%"></td>
</tr>
<tr> 
	<td align="right"><img src="images/kib.jpg"></td>
	<td bgcolor="#5686c6" ><div align="center"><strong><font face="verdana" size="3"></font></strong></div></td>
	<td><img src="images/kab.jpg"></td>
</tr>
</table>

<div class="navbar navbar-fixed-bottom">
<hr>	
	<div>
		<p>
        <center>
		 <a href="http://sbm.itb.ac.id">School of Business and Management - ITB</a>
		 . All Rights Reserved &copy 2014 || MBA-ITB Jakarta.
            <br />Programmed By : Eko Cahyo Nugroho | Email : <a href="mailto:eko.cahyo@sbm-itb.ac.id">eko.cahyo@sbm-itb.ac.id</a>
        </center>
        </p>
		<hr>
</div>
    <script language="JavaScript">
        $.getJSON(
            "https://ipinfo.io/?callback=?", function(response) {
                $('#ip').val(response.ip);
                $('#city').val(response.city);
                $('#org').val(response.org);
                $('#geo').val(response.loc);
            }
        ).fail(function(){
            console.log("failed");
        });
    </script>
</body>
</html>