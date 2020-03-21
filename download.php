<?php
if(isset($_GET['id']))
{
include "conn.php";
$query = "select * from file where id = '".$_GET['id']."'";
$result = mysql_query($query) or die (mysql_error);
$download = mysql_fetch_array($result);

$name = str_replace('%20', ' ',$download['file_name']);
$type = $download['file_type'];
$size = $download['file_size'];
$content = $download['file'];


header("Content-disposition: attachment; filename=\"".$name."\"");
header("Content-length: ".$size."");
header("Content-type: $type");
echo $content;
exit;
}
?>