<?php
include "../conn.php";

if ($_GET['action'] == 'conselor_details') {
    $id = $_GET['id'];
    
    $sql = mysql_query("select * from academic_conselor where id = '$id'") or die (mysql_error());
    $num = mysql_num_rows($sql);
    
    if ($num <> 0) {
        $data = mysql_fetch_array($sql);
        
        echo "<center><img class='img-thumbnail' src='../show_foto.php?id=".$id."' width='100px' height='auto' /></center>";
        echo "<br /><font style='font-family:Monotype Corsiva, Times, serif; font-size: 26px;'><center>".$data['con_name']."</center></font>";
        echo "<br /><font style='font-family:Lucida Console, Monaco, monospace; font-size: 18px;'><center><a href='mailto:".$data['email']."'>".$data['email']."</a></center></font>&nbsp;";
    }else {
        echo "<center><b>Data not found</b></center>&nbsp;";
    }
}
?>