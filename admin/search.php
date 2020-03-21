<?php
include "../conn.php";

if (isset($_GET['search']) and $_GET['search'] != '' and $_GET['do'] == 'admin') {
$id = $_GET['search'];

$sql = mysql_query("select * from user, admin where user.id = '$id' and user.id = admin.user_id") or die (mysql_error());
$num = mysql_num_rows($sql);

if ($num <> 0) {
    $data = mysql_fetch_array($sql);
    $str  = '<p style="color: rgb(216,0,0);" class="validateTips">*All form fields are required.</p>';
    $str .= '<form action="?page=user&action=view&do=edit&status=admin&id='.$id.'" id="edit_admin_form" name="edit_admin_form" method="post" enctype="multipart/form-data" class="form-horizontal">';
    $str .= '<fieldset><legend id="legend-dialog">Edit User Data ('.$data['user'].')</legend>';
    
    $str .= '<div class="form-group"><label for="textArea" class="col-lg-2 control-label">Photo</label><div id="form-image-photo" class="col-lg-5"><img width="80px" height="auto" class="img-thumbnail" src="../show_foto.php?id='.$id.'&do=admin" />';
    $str .= '<br /><input type="checkbox" onchange="if(this.checked){ enable_admin() } else { disable_admin() }" id="change" name="change" value="yes" />&nbsp Change photo';
    $str .= '<br /><input name="photo" disabled="disabled" id="photo" type="file" accept="image/jpeg"></div></div>';
    
    $str .= '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Name</label><div class="col-lg-5"><input name="name" id="name" value="'.$data['name'].'" class="form-control" type="text"></div></div>';
    
    $str .= '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Email</label><div class="col-lg-5"><input name="email" id="email" value="'.$data['email'].'" class="form-control" type="text"></div></div>';
    
    $str .= '<div class="form-group" id="addition_field"><label class="col-lg-2 control-label">Position</label><div class="col-lg-2"><input name="pos" id="pos" value="'.$data['position'].'" class="form-control" type="text" /></div></div>';
            
    $str .= '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Username</label><div class="col-lg-2"><input name="user" id="user" value="'.$data['user'].'" class="form-control" type="text"></div></div>';
    
    $str .= '<div class="form-group"><label for="inputPassword" class="col-lg-2 control-label">Password</label><div class="col-lg-3"><input name="password" id="password" value="'.$data['pass'].'" class="form-control" id="inputPassword" placeholder="Password" type="password"><span id="result"></span></div></div>';
    
    $str .= '</form>';
    
    echo $str."&nbsp;";
}else {
    echo "<center><b><font color='red'>DATA NOT FOUND</font></b></center>";
}

}else if (isset($_GET['search']) and $_GET['search'] != '' and $_GET['do'] == 'user') {
$id = $_GET['search'];

$sql = mysql_query("select * from user, student where user.id = '$id' and user.id = student.user_id") or die (mysql_error());
$num = mysql_num_rows($sql);

$sql_class = mysql_query("select * from program order by name asc") or die (mysql_error());
$num_class = mysql_num_rows($sql_class);

if ($num <> 0) {
    $data = mysql_fetch_array($sql);
    $str  = '<p style="color: rgb(216,0,0);" class="validateTips">*All form fields are required.</p>';
    $str .= '<form action="?page=user&action=view&do=edit&status=user&id='.$id.'" id="edit_user_form" name="edit_user_form" method="post" enctype="multipart/form-data" class="form-horizontal">';
    $str .= '<fieldset><legend id="legend-dialog">Edit User Data ('.$data['user'].')</legend>';
    
    $str .= '<div class="form-group"><label for="textArea" class="col-lg-2 control-label">Photo</label><div id="form-image-photo" class="col-lg-5"><img width="80px" height="auto" class="img-thumbnail" src="../show_foto.php?id='.$id.'&do=user" />';
    $str .= '<br /><input type="checkbox" onchange="if(this.checked){ enable_admin() } else { disable_admin() }" id="change" name="change" value="yes" />&nbsp Change photo';
    $str .= '<br /><input name="photo" disabled="disabled" id="photo" type="file" accept="image/jpeg"></div></div>';
    
	$str .= '<div class="form-group"><label class="col-lg-2 control-label">NIM</label><div class="col-lg-3"><input name="nim" id="nim" value="'.$data['nim'].'" class="form-control" type="text"></div></div>';
	
    $str .= '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Name</label><div class="col-lg-5"><input name="name" id="name" value="'.$data['name'].'" class="form-control" type="text"></div></div>';
    
    $str .= '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Email</label><div class="col-lg-5"><input name="email" id="email" value="'.$data['email'].'" class="form-control" type="text"></div></div>';
    
    $str .= '<div class="form-group" id="addition_field"><label class="col-lg-2 control-label">Class</label><div class="col-lg-2"><select name="class" id="class" class="form-control">';
    
    for ($a = 0; $a < $num_class; $a++) {
        $data_class = mysql_fetch_array($sql_class);
        if ($data['class'] == $data_class['id']) {
            $str .= '<option value="'.$data_class['id'].'" selected="selected">'.$data_class['name'].'</option>';
        }else {
            $str .= '<option value="'.$data_class['id'].'">'.$data_class['name'].'</option>';
        }
    }
    
    $str .= '</select></div></div>';
    
    $str .= '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Username</label><div class="col-lg-2"><input name="user" id="user" value="'.$data['user'].'" class="form-control" type="text"></div></div>';
    
    $str .= '<div class="form-group"><label for="inputPassword" class="col-lg-2 control-label">Password</label><div class="col-lg-3"><input name="password" id="password" value="'.$data['pass'].'" class="form-control" id="inputPassword" placeholder="Password" type="password"><span id="result"></span></div></div>';
    
    $str .= '</form>';
    
    echo $str."&nbsp;";
}else {
    echo "<center><b><font color='red'>DATA NOT FOUND</font></b></center>";
}

}else if (isset($_GET['search']) and $_GET['search'] != '' and $_GET['do'] == 'author_program') {
	$id = $_GET['search'];
		
	$sql = mysql_query("select * from student where class='$id' and name not in (select author from thesis) order by name asc") or die (mysql_error());
	$num = mysql_num_rows($sql);
	
	if ($num <> 0) {
		for ($i = 0; $i < $num; $i++) {
			$data = mysql_fetch_array($sql);
			echo "<option value='".$data['name']."'>".$data['name']."</option>";
		}
		echo "&nbsp;";
	}else {
		echo "<option>No Data</option>&nbsp;";
	}
	
}else if (isset($_GET['search']) and $_GET['search'] != '' and empty($_GET['do'])) {
	//Add slashes to any quotes to avoid SQL problems.
        $id = $_GET['search'];
	$sql = mysql_query("SELECT * FROM academic_conselor, academic_conselor_photo where academic_conselor.id = '$id' and academic_conselor.id = academic_conselor_photo.conselor_id");
	$num = mysql_num_rows($sql);
	
	if($num <> 0) {
		for ($i = 0; $i < $num; $i++) {
                    $data = mysql_fetch_array($sql);
                    echo $data['con_name']."\n";
                    echo $data['email']."\n";
                    echo $data['phone']."\n";
                    echo $data['home_address']."\n";
                    echo $data['office_address']."\n";
                    echo $data['gender']."\n";
                    echo $data[0]."\n";
                }
	} else {
		echo "Error\n";
    }
}
?>