<?php
include "conn.php";

if (!empty($_POST['userid'])) {
	$user = $_POST['userid'];
	$pass = $_POST['pass'];
	//echo md5($pass);exit;
	$sql = mysql_query("select * from user where user = '$user'") or die (mysql_error());
	$num = mysql_num_rows($sql);
	

     $sql = mysql_query("select status from user where user = '$user' and pass = '".md5($pass)."'") or die (mysql_error());
     if(mysql_num_rows($sql) == 0){
         ?><script language="javascript">
             alert("Sorry, wrong username");
             document.location="index.php";
         </script>
         <?php
         exit;
     }
     $status = mysql_fetch_array($sql);
     if ($status['status'] == 'admin') {
         session_start();
         $login = date('Y-m-d H:i:s', time());
         $date = date('Y-m-d', time());

         $cek = mysql_query("select * from log where user = '$user' and date = '$date'") or die (mysql_error());
         $num = mysql_num_rows($cek);
         if ($num <> 0) {
             $_SESSION['user'] = $user;
             $_SESSION['pass'] = $pass;
             $_SESSION['status'] = 'admin';
             $log = mysql_query("update log set login = '$login' where date = '$date' and user = '$user'") or die(mysql_error());
         }
         else if ($num == 0) {
             $_SESSION['user'] = $user;
             $_SESSION['pass'] = $pass;
             $_SESSION['status'] = 'admin';
             $log = mysql_query("insert into log values ('$user', '$date', '$login', '')") or die(mysql_error());
         }

         $clientIP = $_POST['ip'];
         $clientBrowser = $_SERVER['HTTP_USER_AGENT'];
         $dateNow = date('Y-m-d H:i:s');

         $json  = file_get_contents("http://api.ipstack.com/$clientIP?access_key=158f11a8ed517d243088ad82a0a8892a");
         //$json  = file_get_contents("http://api.ipstack.com/103.119.52.58?access_key=158f11a8ed517d243088ad82a0a8892a");
         $json  =  json_decode($json ,true);
         $country =  $json['country_name'];
         $region= $json['region_name'];
         $capital = $json['location']['capital'];
         $city = $json['city'];
         $cityFront = $_POST['city'];
         $lat = $json['latitude'];
         $long = $json['longitude'];
         $org = $_POST['org'];
         $geo = $_POST['geo'];

         $location = "Country : $country, Region : $                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    region, City : $city, Capital : $capital, Long : $long, Lat : $lat";

         mysql_query("INSERT INTO lib.user_activity_log VALUES(NULL, '$user', '$dateNow', '$clientIP', '$org', '$cityFront', '$clientBrowser', '$location', '$geo', 'login')") or die (mysql_error());
         echo "<script>document.location.href='admin/library.php?page=home';</script>";
     }
     else if ($status['status'] == 'user') {
         session_start();
         $login = date('Y-m-d H:i:s', time());
         $date = date('Y-m-d', time());

         $cek = mysql_query("select * from log where user = '$user' and date = '$date'") or die (mysql_error());
         $num = mysql_num_rows($cek);
         if ($num <> 0) {
             $_SESSION['user'] = $user;
             $_SESSION['pass'] = $pass;
             $_SESSION['status'] = 'user';
             $log = mysql_query("update log set login = '$login' where date = '$date' and user = '$user'") or die(mysql_error());
         }
         else if ($num == 0) {
             $_SESSION['user'] = $user;
             $_SESSION['pass'] = $pass;
             $_SESSION['status'] = 'user';
             $log = mysql_query("insert into log values ('$user', '$date', '$login', '')") or die(mysql_error());
         }

         $clientIP = $_POST['ip'];
         $clientBrowser = $_SERVER['HTTP_USER_AGENT'];
         $dateNow = date('Y-m-d H:i:s');

         $json  = file_get_contents("http://api.ipstack.com/$clientIP?access_key=158f11a8ed517d243088ad82a0a8892a");
         //$json  = file_get_contents("http://api.ipstack.com/103.119.52.58?access_key=158f11a8ed517d243088ad82a0a8892a");
         $json  =  json_decode($json ,true);
         $country =  $json['country_name'];
         $region= $json['region_name'];
         $capital = $json['location']['capital'];
         $city = $json['city'];
         $cityFront = $_POST['city'];
         $lat = $json['latitude'];
         $long = $json['longitude'];
         $org = $_POST['org'];
         $geo = $_POST['geo'];

         $location = "Country : $country, Region : $region, City : $city, Capital : $capital, Long : $long, Lat : $lat";

         mysql_query("INSERT INTO lib.user_activity_log VALUES(NULL, '$user', '$dateNow', '$clientIP', '$org','$cityFront', '$clientBrowser', '$location', '$geo', 'login')") or die (mysql_error());
         echo "<script>document.location.href='user/library.php?page=home';</script>";
     }
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>