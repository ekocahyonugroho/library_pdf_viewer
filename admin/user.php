<style type="text/css">
#result{
	margin-left:5px;
}

#register .short{
	color:#FF0000;
}

#register .weak{
	color:#E66C2C;
}

#register .good{
	color:#2D98F3;
}

#register .strong{
	color:#006400;
}
</style>
<?php
include "session.php";
include "../conn.php";
if ($_GET['action'] == 'new') { 
    if ($_POST['add'] == 'manual') { // jika ada perintah input database dengan manual
		$name = $_POST['name'];
		$email = $_POST['email'];
		$user = $_POST['user'];
		$pass = md5($_POST['password']);
		$status = $_POST['status'];
		
		$sql = mysql_query("insert into user (id, user, pass, status) values (NULL, '$user', '$pass', '$status')") or die (mysql_error());
		$sql = mysql_query("select id from user where user = '$user' and pass = '$pass'") or die (mysql_error());
		$data = mysql_fetch_array($sql);
		
		if ($status == 'user') {
		  $class = $_POST['class'];
		  $nim = $_POST['nim'];
		  $sql = mysql_query("insert into student values (NULL, '".$data[0]."', '$class', '$nim', '$name', '$email')") or die (mysql_error());
		  
		  $file_name = str_replace(' ', '%20', $_FILES['photo']['name']); //nama file (tanpa path)
		  $tmp_name  = $_FILES['photo']['tmp_name']; //nama local temp file di server
		  $file_size = $_FILES['photo']['size']; //ukuran file (dalam bytes)
		  $file_type = $_FILES['photo']['type']; //tipe filenya (langsung detect MIMEnya)
		  
		  $fp      = fopen($tmp_name, 'r');
		  $content = fread($fp, filesize($tmp_name));
		  $content = addslashes($content);
		  fclose($fp);
	      
		  if(!get_magic_quotes_gpc()){
		      $file_name = addslashes($file_name);
		  }
		  mysql_query("insert student_photo values (NULL, '".$data[0]."','$content','$file_name','$file_type','$file_size')") or die(mysql_error());
		}else {
		  $pos = $_POST['pos'];
		  $sql = mysql_query("insert into admin values (NULL, '".$data[0]."', '$pos', '$name', '$email')") or die (mysql_error());
		  
		  $file_name = str_replace(' ', '%20', $_FILES['photo']['name']); //nama file (tanpa path)
		  $tmp_name  = $_FILES['photo']['tmp_name']; //nama local temp file di server
		  $file_size = $_FILES['photo']['size']; //ukuran file (dalam bytes)
		  $file_type = $_FILES['photo']['type']; //tipe filenya (langsung detect MIMEnya)
		  
		  $fp      = fopen($tmp_name, 'r');
		  $content = fread($fp, filesize($tmp_name));
		  $content = addslashes($content);
		  fclose($fp);
	      
		  if(!get_magic_quotes_gpc()){
		      $file_name = addslashes($file_name);
		  }
		  mysql_query("insert admin_photo values (NULL, '".$data[0]."','$content','$file_name','$file_type','$file_size')") or die(mysql_error());
		}
		if (!mysql_error()) { ?>
			<script language="javascript">
					alert("New user has been saved.");
	    				document.location="?page=user&action=new";
			</script>
		<?php
		}
	}else if ($_POST['add'] == 'import') {
		include "excel_reader.php";
		$data = new Spreadsheet_Excel_Reader($_FILES['file']['tmp_name']);
		$status = "user";
		$class = $_POST['class'];
		// membaca jumlah baris dari data excel
		 $row = $data->rowcount($sheet_index=0);
		 
		// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
		 $count = $row - 1; // menghitung jumlah baris dikurangi kolom
		 $success = 0;
		 $fail = 0;
		 
		 for ($i=2; $i<=$row; $i++)
 		{
			  // membaca kolom username
			  $username = $data->val($i, 1);
			  // membaca kolom password
			  $password = sha1($data->val($i, 2));
			  // membaca kolom nim
			  $nim = $data->val($i, 3);
			  // membaca kolom nama
			  $name = $data->val($i, 4);
			  // membaca kolom email
			  $email = $data->val($i, 5);
			  
			  mysql_query("insert into user values (NULL, '$username', '$password', '$status')") or die (mysql_error());
			  $sql = mysql_query("select id from user where status = 'user' order by id desc limit 0,1") or die (mysql_error());
			  $data_user = mysql_fetch_array($sql);
			  $user_id = $data_user['id'];
			  
			  mysql_query("insert into student values (NULL, '$user_id', '$class', '$nim', '$name', '$email')") or die (mysql_error());
			  if (!mysql_error()) { $success = $success + 1; }
              else { $fail = $fail + 1; };
			  
			  echo '<script language="javascript">alert("'.$success.' data was/were imported successfully. '.$fail.' data was/were failed to be imported.");document.location="?page=user&action=new";</script>';
		}
	}else {
   ?>
    <ul class="breadcrumb">
      <li>Menu</li>
      <li class="active">New User</li>
    </ul>
    <form name="manual" id="register" class="form-horizontal" method="post" action="?page=user&action=new" enctype="multipart/form-data">
    <input type="hidden" name="add" value="manual">
      <fieldset>
        <legend>New User</legend>
	<div class="form-group">
          <label for="textArea" class="col-lg-2 control-label">Photo *</label>
          <div id="form-image-photo" class="col-lg-5">
            <input name="photo" id="photo" type="file" accept="image/jpeg">
          </div>
        </div>
        <div class="form-group">
          <label for="select" class="col-lg-2 control-label">Selects</label>
          <div class="col-lg-2">
            <select onchange="status_check()" name="status" id="status" class="form-control">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
        <div id="addition_field">
            <div class="form-group">
              <label class="col-lg-2 control-label">Class</label>
              <div class="col-lg-2">
                <select name="class" id="addition" class="form-control">
                  <?php
                  $sql = mysql_query("select * from program order by name asc") or die (mysql_error());
                  $num = mysql_num_rows($sql);
                  for ($i = 0; $i < $num; $i++) {
                $data = mysql_fetch_array($sql);
                echo "<option value='".$data['id']."'>".$data['name']."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">NIM</label>
              <div class="col-lg-2">
                <input type="text" autocomplete="off" id="nim" name="nim" class="form-control" />
              </div>
            </div>
    	</div>
	<div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Name</label>
          <div class="col-lg-5">
            <input name="name" id="name" class="form-control" placeholder="Complete Name" type="text">
          </div>
        </div>
	<div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Email</label>
          <div class="col-lg-5">
            <input name="email" id="email" class="form-control" placeholder="Email Address" type="text">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-lg-2 control-label">Username</label>
          <div class="col-lg-5">
            <input name="user" id="user" class="form-control" placeholder="Username" type="text">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-lg-2 control-label">Password</label>
          <div class="col-lg-3">
            <input name="password" id="password" class="form-control" placeholder="Password" type="password">
            <span id="result"></span>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <button id="btn-cancel" type="reset" class="btn btn-default">Cancel</button>
            <button onclick="return IsEmptyField()" id="btn-submit" type="submit" class="btn btn-primary">Submit</button>
            <button onclick="import_excel()" id="btn-import" type="button" class="btn btn-info">Import</button>
          </div>
        </div>
      </fieldset>
    </form>
    <div id="import-dlg" style="display: none;">
    	<form name="import_user" id="import_user"  class="form-horizontal" method="post" action="?page=user&action=new" enctype="multipart/form-data">
        <input type="hidden" name="add" value="import">
      	<fieldset>
        <legend>Add New User by Import</legend>
			<div class="form-group">
          		<label class="col-lg-2 control-label">Class</label>
          		<div class="col-lg-5">
                	<select class="form-control" name="class" id="class">
            		<?php 
					$sql = mysql_query("select * from program where name <> 'GUEST' order by name asc") or die (mysql_error());
					$num = mysql_num_rows($sql);
					
					if ($num <> 0) {
						for ($i = 0; $i < $num; $i++) {
							$data = mysql_fetch_array($sql);
							echo '<option value="'.$data['id'].'">'.$data['name'].'</option>';
						}
					}else {
						echo '<option value="no_data">No data</option>';
					}
					?>
                    </select>
          		</div>
        	</div>
            <div class="form-group">
          		<label class="col-lg-2 control-label">Class</label>
          		<div class="col-lg-5">
                	<input type="file" name="file" id="file" class="form-control" />
          		</div>
        	</div>
        </fieldset>
        </form>
    </div>
    <!-- Javascript for one by one new user input -->
    <script language="javascript">
	
		function import_excel() {
			$(function() {
				var wWidth = $( window ).width();
				var wHeight = $( window ).height();
				var dWidth = wWidth * 0.6;
				var dHeight = wHeight * 0.5;
				$( "#import-dlg" ).dialog({
							resizable: false,
							height:dHeight,
							width : dWidth,
							modal: true,
							dialogClass: 'no-close',
								buttons: {
										"Close": function() {
											$( this ).dialog( "close" );
									    },
									    "Submit": function() {
											document.forms['import_user'].submit();
											$( this ).dialog( "close" );
									    }
								}
				});
			});
		}
		
	
	    function status_check() {
	      var status = document.getElementById("status").value;
	      var addition = document.getElementById("addition_field");
	      addition.innerHTML = '';
	      
	      if (status == 'user') {
		<?php
		$sql = mysql_query("select * from program order by name asc") or die (mysql_error());
		$num = mysql_num_rows($sql);
		?>
		var selection = '<?php for ($i = 0; $i < $num; $i++) { $data = mysql_fetch_array($sql); echo "<option value=\"".$data['id']."\">".$data['name']."</option>"; } ?>';
		
		addition.innerHTML = '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Class</label><div class="col-lg-2"><select name="class" id="addition" class="form-control" id="select">'+selection+'</select></div></div><div class="form-group"><label class="col-lg-2 control-label">NIM</label><div class="col-lg-2"><input type="text" autocomplete="off" id="nim" name="nim" class="form-control" /></div></div>';
	      }else if (status == 'admin') {
		addition.innerHTML = '<div class="form-group"><label for="inputEmail" class="col-lg-2 control-label">Position</label><div class="col-lg-2"><input name="pos" id="addition" class="form-control" placeholder="e.g Librarian" type="text" /></div></div>';
	      }
	    }
  
function IsEmptyField(){
  var file_photo = $("#photo").val();
  if ((file_photo.lastIndexOf("jpg")===file_photo.length-3) || (file_photo.lastIndexOf("jpeg")===file_photo.length-3) || (file_photo.lastIndexOf("JPG")===file_photo.length-3) || (file_photo.lastIndexOf("JPEG")===file_photo.length-3)) {
    if(document.forms['manual'].user.value == "" || document.forms['manual'].password.value == "" || document.forms['manual'].name.value == "" || document.forms['manual'].email.value == "")
    {
      alert("There is empty field.");
      return false;
    }
    return true;
  }else {
      alert("Please select photo file with correct file type : JPEG.");
      return false;
  }
}
  
function IsEmptyImport(){
    if(document.forms['import'].file.value == "")
    {
      alert("There is/are empty field.");
      return false;
    }
      return true;
}
  function checkFile() {
        var fileElement = document.getElementById("file");
        var fileExtension = "";
        if (fileElement.value.lastIndexOf(".") > 0) {
            fileExtension = fileElement.value.substring(fileElement.value.lastIndexOf(".") + 1, fileElement.value.length);
        }
        if (fileExtension == "xls") {
            return true;
        }
        else {
            alert("You must select a xls file for upload");
			document.getElementById('file').value='';
            return false;
        }
    }
    </script>
<?php
	}
}
else if ($_GET['action'] == 'view') { ?>
<ul class="breadcrumb">
  <li>Menu</li>
  <li class="active">View User</li>
</ul>
<?php
if ($_GET['do'] == 'delete') {
	$id = $_GET['id'];
	
	mysql_query("delete from user where id = '$id'") or die(mysql_error());
	
	if ($_GET['status'] = 'user') {
	  mysql_query("delete from student where user_id = '$id'") or die(mysql_error());
	  mysql_query("delete from student_photo where user_id = '$id'") or die(mysql_error());
	}else if ($_GET['status'] = 'admin') {
	  mysql_query("delete from admin where user_id = '$id'") or die(mysql_error());
	  mysql_query("delete from admin_photo where user_id = '$id'") or die(mysql_error());
	}
	?>
	<script language="javascript">
		alert("Deleted Successfully.");
		document.location="?page=user&action=view";
	</script>
	<?php
}else if ($_GET['do'] == 'edit') {
  $id = $_GET['id'];
      
  $sql = mysql_query("select pass from user where id = '$id'") or die (mysql_error());
  $data = mysql_fetch_array($sql);
  
  $change = $_POST['change'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $user = $_POST['user'];
  
  if ($data['user'] <> $_POST['password']) {
    $pass = md5($_POST['password']);
  }else {
    $pass = $_POST['password'];
  }
  
  if ($_GET['status'] == 'admin') {
      
      $pos = $_POST['pos'];
      
      mysql_query("update user set user = '$user', pass = '$pass' where id = '$id'") or die (mysql_error());
      mysql_query("update admin set position = '$pos', name = '$name', email = '$email' where user_id = '$id'") or die (mysql_error());
      
      if ($change == 'yes') {
	    $file_name = str_replace(' ', '%20', $_FILES['photo']['name']); //nama file (tanpa path)
            $tmp_name  = $_FILES['photo']['tmp_name']; //nama local temp file di server
            $file_size = $_FILES['photo']['size']; //ukuran file (dalam bytes)
            $file_type = $_FILES['photo']['type']; //tipe filenya (langsung detect MIMEnya)
            
            $fp      = fopen($tmp_name, 'r');
	    $content = fread($fp, filesize($tmp_name));
	    $content = addslashes($content);
	    fclose($fp);
	
	    if(!get_magic_quotes_gpc()){
		$file_name = addslashes($file_name);
	    }
            mysql_query("UPDATE `admin_photo` SET `file`='$content',`file_name`='$file_name',`file_type`='$file_type',`file_size`='$file_size' WHERE user_id = '$id'") or die (mysql_error());
      }
  }else if ($_GET['status'] == 'user') {
      $class = $_POST['class'];
      $nim = $_POST['nim'];
	  
      mysql_query("update user set user = '$user', pass = '$pass' where id = '$id'") or die (mysql_error());
      mysql_query("update student set class = '$class', nim = '$nim', name = '$name', email = '$email' where user_id = '$id'") or die (mysql_error());
      
      if ($change == 'yes') {
	    $file_name = str_replace(' ', '%20', $_FILES['photo']['name']); //nama file (tanpa path)
            $tmp_name  = $_FILES['photo']['tmp_name']; //nama local temp file di server
            $file_size = $_FILES['photo']['size']; //ukuran file (dalam bytes)
            $file_type = $_FILES['photo']['type']; //tipe filenya (langsung detect MIMEnya)
            
            $fp      = fopen($tmp_name, 'r');
	    $content = fread($fp, filesize($tmp_name));
	    $content = addslashes($content);
	    fclose($fp);
	
	    if(!get_magic_quotes_gpc()){
		$file_name = addslashes($file_name);
	    }
            mysql_query("UPDATE `student_photo` SET `file`='$content',`file_name`='$file_name',`file_type`='$file_type',`file_size`='$file_size' WHERE user_id = '$id'") or die (mysql_error());
      }
  }
  
	?>
        <script language="javascript">
            alert("Data has been updated successfully.");
            document.location = "?page=user&action=view";
        </script>
        <?php
}else {
?>
<!-------->
<div id="content">
  <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
    <li class="active"><a href="#admin" data-toggle="tab">Admin</a></li>
    <li><a href="#student" data-toggle="tab">Students</a></li>
  </ul>
  <div id="my-tab-content" class="tab-content">
      <div class="tab-pane active" id="admin">
      <?php

      $sql_admin = mysql_query("select * from user where status = 'admin' order by id asc") or die (mysql_error());
      $num_admin = mysql_num_rows($sql_admin);

      if ($num_admin <> 0) { ?>
      <table id="myAdminTable" class="table table-bordered">
	<thead>
	<tr class="active">
	  <th>No.</th>
	  <th>Photo</th>
	  <th>Name</th>
	  <th>Email</th>
	  <th>Username</th>
	  <th>Position</th>
	  <th>Edit</th>
	  <th>Delete</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for ($i=0;$i<$num_admin;$i++) {
	  $row_admin = mysql_fetch_array($sql_admin);
	  $sql_details_admin = mysql_query("select * from admin where user_id = '".$row_admin['id']."'");
	  $data_details_admin = mysql_fetch_array($sql_details_admin);
	  $no_admin = $i + 1;
	?>
	  <tr>
	    <td><?php echo $no_admin; ?></td>
	    <td><center><img class="img-thumbnail" width="80px" height="auto" src="../show_foto.php?id=<?php echo $row_admin['id']; ?>&do=admin" /></center></td>
	    <td><?php echo $data_details_admin['name']; ?></td>
	    <td><a href="mailto:<?php echo $data_details_admin['email']; ?>"><?php echo $data_details_admin['email']; ?></a></td>
	    <td><?php echo $row_admin['user']; ?></td>
	    <td><?php echo $data_details_admin['position']; ?></td>
	    <td><center><button type="button" onclick="edit_admin(<?php echo $row_admin['id']; ?>)"><img src="../images/edit.png" width="25px" height="auto" /></button></center></td>
	    <td><center><button type="button" onclick="delete_admin(<?php echo $row_admin['id']; ?>)"><img src="../images/delete.png" width="25px" height="auto" /></button></center></td>
	  </tr>     
	<?php
	}
	?>
	</tbody>
      </table>
      </div>
      <?php
      }
      ?>
      <div class="tab-pane" id="student">
	<?php
	$sql_user = mysql_query("select * from user where status = 'user' order by id asc") or die (mysql_error());
	$num_user = mysql_num_rows($sql_user);
	
	if ($num_user <> 0) {
	  ?>
	  <table id="myUserTable" class="table table-bordered">
	    <thead>
	    <tr class="active">
	      <th>No.</th>
	      <th>Photo</th>
          <th>NIM</th>
	      <th>Name</th>
	      <th>Email</th>
	      <th>Username</th>
	      <th>Class</th>
	      <th>Edit</th>
	      <th>Delete</th>
	    </tr>
	    </thead>
	    <tbody>
	      <?php
	      for ($u = 0; $u < $num_user; $u++) {
		$no_u = $u + 1;
		$data_user = mysql_fetch_array($sql_user);
		$sql_details_user = mysql_query("select * from student, program where student.user_id = '".$data_user['id']."' and student.class = program.id");
		$data_details_user = mysql_fetch_array($sql_details_user);
		$check_photo = mysql_query("select id from student_photo where user_id = '".$data_user['id']."'") or die (mysql_error());
		$num_photo = mysql_num_rows($check_photo);
		?>
		<tr>
		  <td><?php echo $no_u; ?></td>
          <?php 
		  if ($num_photo == 0) {
			  	echo '<td><center><img class="img-thumbnail" width="80px" height="auto" src="../images/individual.jpg" /></center></td>';
		  }else {
		  		echo '<td><center><img class="img-thumbnail" width="80px" height="auto" src="../show_foto.php?id='.$data_user['id'].'&do=user" /></center></td>';
		  }
		  ?>
		  <td><?php echo $data_details_user[3]; ?></td>
          <td><?php echo $data_details_user[4]; ?></td>
		  <td><a href="mailto:<?php echo $data_details_user['email']; ?>"><?php echo $data_details_user['email']; ?></a></td>
		  <td><?php echo $data_user['user']; ?></td>
		  <td><?php echo $data_details_user['name']; ?></td>
		  <td><center><button type="button" onclick="edit_user(<?php echo $data_user['id']; ?>)"><img src="../images/edit.png" width="25px" height="auto" /></button></center></td>
		  <td><center><button type="button" onclick="delete_user(<?php echo $data_user['id']; ?>)"><img src="../images/delete.png" width="25px" height="auto" /></button></center></td>
		</tr> 
		<?php
	      }
	      ?>
	    </tbody>
	  </table>
	  <?php
	}else {
	  echo "<center><b><font style='font-size: 16px;'>DATA NOT FOUND</font></b></center>";
	}
	?>
      </div>
    </div>
  </div>
    <div id="dialog-form" title="User Data" style="display: none;"></div>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
    <script language="javascript">
      function getXmlHttpRequestObject() {
        if (window.XMLHttpRequest) {
          return new XMLHttpRequest();
        } else if(window.ActiveXObject) {
          return new ActiveXObject("Microsoft.XMLHTTP");
        } else {
          alert("Your Browser Sucks!");
        }
      }
                
      var searchReq = getXmlHttpRequestObject();
      
      $(document).ready(function() {
	var wHeight = $(window).height();
	var dHeight = wHeight * 0.6;
	$('#myAdminTable').dataTable();
	$('#myUserTable').dataTable();
      } );
      
      
		
      function delete_admin(id) {
	var x = confirm("Are you sure to delete this user? Deleted user can not be restored.");
	if (x == true) {
	  document.location = "?page=user&action=view&do=delete&status=admin&id="+id+"";
	}
      }
      
      function delete_user(id) {
	var x = confirm("Are you sure to delete this user? Deleted user can not be restored.");
	if (x == true) {
	  document.location = "?page=user&action=view&do=delete&status=user&id="+id+"";
	}
      }
      
      function edit_admin(id) {
        if (searchReq.readyState == 4 || searchReq.readyState == 0) {
            searchReq.open("GET", 'search.php?search='+id+'&do=admin', true);
                        
            searchReq.onreadystatechange = view_edit_admin; 
            searchReq.send(null);
        } 
      }
      
      function edit_user(id) {
        if (searchReq.readyState == 4 || searchReq.readyState == 0) {
            searchReq.open("GET", 'search.php?search='+id+'&do=user', true);
                        
            searchReq.onreadystatechange = view_edit_user; 
            searchReq.send(null);
        } 
      }
      
      function view_edit_user(id) {
	if (searchReq.readyState == 4) {
	  var dialog = document.getElementById('dialog-form');
	  var str =searchReq.responseText.split("&nbsp;");
	  dialog.innerHTML = str;
	  
	  $(function() {
	    var wWidth = $(window).width();
	    var wHeight = $(window).height();
	    var dWidth = wWidth * 0.8;
	    var dHeight = wHeight * 0.9;
	    $( "#dialog-form" ).dialog({
	      resizable: false,
	      height:dHeight,
	      width : dWidth,
	      modal: true,
	      dialogClass: 'no-close',
	      buttons: {
		"Save": function() {
		  if (document.getElementById("change").checked) {
			      var file_photo = $("#photo").val();
                              if ((file_photo.lastIndexOf("jpg")===file_photo.length-3) || (file_photo.lastIndexOf("jpeg")===file_photo.length-3) || (file_photo.lastIndexOf("JPG")===file_photo.length-3) || (file_photo.lastIndexOf("JPEG")===file_photo.length-3)) {
				    var name = document.getElementById("name").value;
                                    var email = document.getElementById("email").value;
                                    var user = document.getElementById("user").value;
				    var pass = document.getElementById("password").value;
                                                        
                                    if (name == "" || email == "" || user == "" || pass == "") {
                                        alert("Please input all required fields.");
                                    }else {
					document.forms["edit_user_form"].submit();
                                    }
                              }else {
                                     alert("Please select photo file with correct file type : JPEG");
                              }
		  }else {
			      var name = document.getElementById("name").value;
                              var email = document.getElementById("email").value;
                              var user = document.getElementById("user").value;
			      var pass = document.getElementById("password").value;
                                                        
                              if (name == "" || email == "" || user == "" || pass == "") {
                                  alert("Please input all required fields.");
                              }else {
                                  document.forms["edit_user_form"].submit();
                              }
		  }
	      },
		"Cancel": function() {
		dialog.innerHTML = "";
		$( this ).dialog( "close" );
		}
	      }
	    });
	  });
	}
      }
      
      function view_edit_admin(id) {
	if (searchReq.readyState == 4) {
	  var dialog = document.getElementById('dialog-form');
	  var str =searchReq.responseText.split("&nbsp;");
	  dialog.innerHTML = str;
	  
	  $(function() {
	    var wWidth = $(window).width();
	    var wHeight = $(window).height();
	    var dWidth = wWidth * 0.8;
	    var dHeight = wHeight * 0.9;
	    $( "#dialog-form" ).dialog({
	      resizable: false,
	      height:dHeight,
	      width : dWidth,
	      modal: true,
	      dialogClass: 'no-close',
	      buttons: {
		"Save": function() {
		  if (document.getElementById("change").checked) {
			      var file_photo = $("#photo").val();
                              if ((file_photo.lastIndexOf("jpg")===file_photo.length-3) || (file_photo.lastIndexOf("jpeg")===file_photo.length-3) || (file_photo.lastIndexOf("JPG")===file_photo.length-3) || (file_photo.lastIndexOf("JPEG")===file_photo.length-3)) {
				    var name = document.getElementById("name").value;
                                    var email = document.getElementById("email").value;
                                    var pos = document.getElementById("pos").value;
                                    var user = document.getElementById("user").value;
				    var pass = document.getElementById("password").value;
                                                        
                                    if (name == "" || email == "" || pos == "" || user == "" || pass == "") {
                                        alert("Please input all required fields.");
                                    }else {
					document.forms["edit_admin_form"].submit();
                                    }
                              }else {
                                     alert("Please select photo file with correct file type : JPEG");
                              }
		  }else {
			      var name = document.getElementById("name").value;
                              var email = document.getElementById("email").value;
                              var pos = document.getElementById("pos").value;
                              var user = document.getElementById("user").value;
			      var pass = document.getElementById("password").value;
                                                        
                              if (name == "" || email == "" || pos == "" || user == "" || pass == "") {
                                  alert("Please input all required fields.");
                              }else {
                                  document.forms["edit_admin_form"].submit();
                              }
		  }
	      },
		"Cancel": function() {
		dialog.innerHTML = "";
		$( this ).dialog( "close" );
		}
	      }
	    });
	  });
	}
      }
      
      function disable_admin()
      {
      document.getElementById("photo").disabled=true;
      }
      
      function enable_admin()
      {
      document.getElementById("photo").disabled=false;
    }
    </script>
    <?php
}
}
?>