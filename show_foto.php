<?php
include "conn.php";
if (isset($_GET['id']) and $_GET['do'] == 'student') {
    $query = "select file_name,file_type,file_size,file from student_photo where user_id = '".$_GET['id']."'";
    $result = mysql_query($query) or die (mysql_error());
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
}else if (isset($_GET['id']) and $_GET['do'] == 'admin'){
    $query = "select file_name,file_type,file_size,file from admin_photo where user_id = '".$_GET['id']."'";
    $result = mysql_query($query) or die (mysql_error());
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
}else if (isset($_GET['id']) and $_GET['do'] == 'user'){
    $query = "select file_name,file_type,file_size,file from student_photo where user_id = '".$_GET['id']."'";
    $result = mysql_query($query) or die (mysql_error());
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
else if (isset($_GET['id']) and empty($_GET['do'])){
    $query = "select file_name,file_type,file_size,file from academic_conselor_photo where conselor_id = '".$_GET['id']."'";
    $result = mysql_query($query) or die (mysql_error());
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
