<style type="text/css">
    .no-close .ui-dialog-titlebar-close {display: none}
</style>
<?php
include "session.php";
if ($_GET['view'] == 'yes') {
    include "../conn.php";
    ?>
    <ul class="breadcrumb">
      <li>Home</li>
      <li>Other</li>
      <li class="active">Conselor</li>
    </ul>
    <?php
    if($_GET['do'] == 'add') { // Jika tambah conselor baru
        $name = $_POST['name'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$home = $_POST['home'];
	$office = $_POST['office'];
        
        $sql = mysql_query("select * from academic_conselor where con_name = '$name'") or die (mysql_error());
        $num = mysql_num_rows($sql);
        
        if($num == 0) { // Jika data yang dimasukkan belum ada di database
            mysql_query("insert into academic_conselor values (NULL, '$name', '$gender', '$email', '$phone', '$home', '$office')") or die (mysql_error());
            
            $sql = mysql_query("select * from academic_conselor where con_name = '$name'") or die (mysql_error());
            $data = mysql_fetch_array($sql);
            $id = $data['id'];
            
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
            mysql_query("insert into academic_conselor_photo values (NULL, '$id','$content','$file_name','$file_type','$file_size')") or die(mysql_error());
            ?>
            <script language="javascript">
                alert("<?php echo $name; ?> has been saved successfully.");
                document.location = "?page=conselor&view=yes";
            </script>
            <?php
        }else { // Jika nama conselor yang akan di simpan sudah ada di database
            ?>
            <script language="javascript">
                alert("<?php echo $name; ?> is already exist in database.");
                document.location = "?page=conselor&view=yes";
            </script>
            <?php
        }  
    }else if ($_GET['do'] == 'edit') {
        $id = $_GET['id'];
        $name = $_POST['name'];
	$gender = $_POST['gender'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$home = $_POST['home'];
	$office = $_POST['office'];
        $change = $_POST['change'];
        
        mysql_query("UPDATE `academic_conselor` SET `con_name`='$name',`gender`='$gender',`email`='$email',`phone`='$phone',`home_address`='$home',`office_address`='$office' WHERE id = '$id'") or die (mysql_error());
        
        if ($change == 'yes') { // Jika edit data dengan mengganti foto
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
            mysql_query("UPDATE `academic_conselor_photo` SET `file`='$content',`file_name`='$file_name',`file_type`='$file_type',`file_size`='$file_size' WHERE conselor_id = '$id'") or die (mysql_error());
        }
        ?>
        <script language="javascript">
            alert("Data has been updated successfully.");
            document.location = "?page=conselor&view=yes";
        </script>
        <?php
    }else if ($_GET['do'] == 'update') {
        
    }else if ($_GET['do'] == 'delete') {
        $id = $_GET['id'];
        $sql = mysql_query("delete from academic_conselor where id = '$id'") or die (mysql_error());
        $sql = mysql_query("delete from academic_conselor_photo where conselor_id = '$id'") or die (mysql_error());
        ?>
        <script language="javascript">
            alert("Deleted successfully.");
            document.location = "?page=conselor&view=yes";
        </script>
        <?php
    }else {
        $sql = mysql_query("select * from academic_conselor order by con_name asc") or die (mysql_error());
        $num = mysql_num_rows($sql);
        
        if ($num <> 0) { // Jika tabel ACademic COnselor ada
            ?>
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr class="active">
                                <th>No.</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Home Address</th>
                                <th>Office Address</th>
                                <th><center>Edit</center></th>
                                <th><center>Delete</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 0; $i < $num; $i++) {
                                $row = mysql_fetch_array($sql);
                                $no = $i + 1;
                                ?>
                                <tr class="info">
                                    <td><?php echo $no; ?></td>
                                    <td id="photo<?php echo $row['id']; ?>"><center><img class="img-thumbnail" width="60" height="auto" src="../show_foto.php?id=<?php echo $row['id']; ?>" /></center></td>
                                    <td id="name<?php echo $row['id']; ?>"><?php echo $row['con_name']; ?></td>
                                    <td id="gender<?php echo $row['id']; ?>">
                                        <?php
                                        if ($row['gender'] == 'M') {
                                            echo "Male";
                                        }else {
                                            echo "Female";
                                        }
                                        ?>
                                    </td>
                                    <td id="email<?php echo $row['id']; ?>"><a href="mailto:<?php echo $row['email']; ?>" target="_top"><?php echo $row['email']; ?></a></td>
                                    <td id="phone<?php echo $row['id']; ?>"><?php echo $row['phone']; ?></td>
                                    <td id="home<?php echo $row['id']; ?>"><?php echo $row['home_address']; ?></td>
                                    <td id="office<?php echo $row['id']; ?>"><?php echo $row['office_address']; ?></td>
                                    <td><center><button type="button" onclick="edit(<?php echo $row['id']; ?>)">Edit</button></center></td>
                                    <td><center><button type="button" onclick="del(<?php echo $row['id']; ?>)">Delete</button></center></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
            <div class="well"><button type="button" onclick="new_data()" class="btn btn-primary">Add New</button></div>
            <div id="dialog-form" title="Conselor Data" style="display: none;">
                    <p style="color: rgb(216,0,0);" class="validateTips">*All form fields are required.</p>   
                    <form id="new_conselor_form" name="new_conselor_form" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <fieldset>
                            <legend id="legend-dialog">Input new conselor data</legend>
                            <div class="form-group">
                              <label for="textArea" class="col-lg-2 control-label">Photo *</label>
                              <div id="form-image-photo" class="col-lg-5">
                                <input name="photo" id="photo" type="file" accept="image/jpeg">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="textArea" class="col-lg-2 control-label">Name *</label>
                              <div class="col-lg-5">
                                <input name="name" class="form-control" id="name" type="text">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="textArea" class="col-lg-2 control-label">Gender</label>
                              <div class="col-lg-2">
                                <select name="gender" class="form-control" id="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="textArea" class="col-lg-2 control-label">Email Address *</label>
                              <div class="col-lg-4">
                                <input name="email" class="form-control" id="email" type="text">
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="textArea" class="col-lg-2 control-label">Phone Number *</label>
                              <div class="col-lg-3">
                                <input name="phone" class="form-control" id="phone" type="text">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="textArea" class="col-lg-2 control-label">Home Address *</label>
                                <div class="col-lg-6">
                                    <textarea name="home" class="form-control" rows="3" id="home"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textArea" class="col-lg-2 control-label">Office Address</label>
                                <div class="col-lg-6">
                                    <textarea name="office" class="form-control" rows="3" id="office"></textarea>
                                </div>
                            </div>
                            </fieldset>
                    </form>
                    
            </div>
            <script type="text/javascript" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
            <script language="javascript">
                $(document).ready(function() {
		    var wHeight = $(window).height();
		    var dHeight = wHeight * 0.4;
			$('#myTable').dataTable( {
			    "scrollY": dHeight,
			    "scrollX": true
			} );
		} );
                
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
                
                function edit(id) {
                    if (searchReq.readyState == 4 || searchReq.readyState == 0) {
                        
                        
                        searchReq.open("GET", 'search.php?search=' + id, true);
                        
                        searchReq.onreadystatechange = handleView; 
                        searchReq.send(null);
                    } 
                }
                
                function handleView() {
                        if (searchReq.readyState == 4) {
                                var name = document.getElementById('name');
                                var email = document.getElementById('email');
                                var phone = document.getElementById('phone');
                                var home = document.getElementById('home');
                                var office = document.getElementById('office');
                                var gender = document.getElementById('gender');
                                var photo = document.getElementById("form-image-photo");
                                
                                var str =searchReq.responseText.split("\n");
                                
                                if(str.length==1) {
                                    name.innerHTML = '';
                                    name.style.visibility = "hidden";
                                    
                                    email.innerHTML = '';
                                    email.style.visibility = "hidden";
                                }
                                else
                                name.innerHTML = '';
                                email.innerHTML = '';
                                phone.innerHTML = '';
                                home.innerHTML = '';
                                office.innerHTML = '';
                                gender.selectedIndex = 0;
                                photo.innerHTML = '';
                                
                                name.value += str[0];
                                email.value += str[1];
                                phone.value += str[2];
                                home.value += str[3];
                                office.value += str[4];
                                
                                if (str[5] == 'M') {
                                    gender.selectedIndex = 0;
                                }else {
                                    gender.selectedIndex = 1;
                                }
                                photo.innerHTML += '<img class="img-thumbnail" width="60" height="auto" src="../show_foto.php?id='+str[6]+'" />';
                                photo.innerHTML += '<br /><input type="checkbox" onchange="if(this.checked){ enable() } else { disable() }" id="change" name="change" value="yes" />&nbsp Change photo';
                                photo.innerHTML += '<br /><input name="photo" disabled="disabled" id="photo" type="file" accept="image/jpeg">';
                                
                                var legend = document.getElementById("legend-dialog");
                                legend.innerHTML = "Edit Conselor Data";
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
                                                if (document.getElementById("change").checked) { // JIka change photo checked
                                                    var file_photo = $("#photo").val();
                                                    if ((file_photo.lastIndexOf("jpg")===file_photo.length-3) || (file_photo.lastIndexOf("jpeg")===file_photo.length-3) || (file_photo.lastIndexOf("JPG")===file_photo.length-3) || (file_photo.lastIndexOf("JPEG")===file_photo.length-3)) {
                                                        var name = document.getElementById("name").value;
                                                        var email = document.getElementById("email").value;
                                                        var phone = document.getElementById("phone").value;
                                                        var home = document.getElementById("home").value;
                                                        
                                                        if (name == "" || email == "" || phone == "" || home == "") {
                                                            alert("Please input all required fields.");
                                                        }else {
                                                            document.forms["new_conselor_form"].setAttribute("action", "?page=conselor&view=yes&do=edit&id="+str[6]+"");
                                                            document.forms["new_conselor_form"].submit();
                                                        }
                                                    }else {
                                                        alert("Please select photo file with correct file type : JPEG");
                                                    }
                                                }else { // Jika change photo unchecked
                                                    var name = document.getElementById("name").value;
                                                    var email = document.getElementById("email").value;
                                                    var phone = document.getElementById("phone").value;
                                                    var home = document.getElementById("home").value;
                                                        
                                                    if (name == "" || email == "" || phone == "" || home == "") {
                                                        alert("Please input all required fields.");
                                                    }else {
                                                        document.forms["new_conselor_form"].setAttribute("action", "?page=conselor&view=yes&do=edit&id="+str[6]+"");
                                                        document.forms["new_conselor_form"].submit();
                                                    }
                                                }
                                            },
                                            "Cancel": function() {
                                                document.forms["new_conselor_form"].reset();
                                                $( this ).dialog( "close" );
                                            }
                                            }
                                            });
                                });
                        }
                }
                
                function disable(){ // function untuk mengganti foto ketika edit foto
                    document.getElementById("photo").disabled=true;
                }
                
                function enable() {
                    document.getElementById("photo").disabled=false;
                }
                
                function del(id) {
                    var r = confirm("Are you sure to delete this data?");
		    if (r == true) {
			document.location="?page=conselor&view=yes&do=delete&id="+id+"";
		    }
                }
                
                function new_data() {
                    var legend = document.getElementById("legend-dialog");
                    var photo = document.getElementById("form-image-photo");
                    
                    legend.innerHTML = "Input New Conselor Data";
                    photo.innerHTML = '<input name="photo" id="photo" type="file" accept="image/jpeg">';
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
                                    var file_photo = $("#photo").val();
                                    if ((file_photo.lastIndexOf("jpg")===file_photo.length-3) || (file_photo.lastIndexOf("jpeg")===file_photo.length-3) || (file_photo.lastIndexOf("JPG")===file_photo.length-3) || (file_photo.lastIndexOf("JPEG")===file_photo.length-3)) {
                                        var name = document.getElementById("name").value;
                                        var email = document.getElementById("email").value;
                                        var phone = document.getElementById("phone").value;
                                        var home = document.getElementById("home").value;
                                        
                                        if (name == "" || email == "" || phone == "" || home == "") {
                                            alert("Please input all required fields.");
                                        }else {
                                            document.forms["new_conselor_form"].setAttribute("action", "?page=conselor&view=yes&do=add");
                                            document.forms["new_conselor_form"].submit();
                                        }
                                    }else {
                                        alert("Please select photo file with correct file type : JPEG");
                                    }
                                    
				},
				"Cancel": function() {
                                    document.forms["new_conselor_form"].reset();
                                    $( this ).dialog( "close" );
				}
				}
				});
		    });
                }
            </script>
            <?php
        }else {
            ?>
            <div class="well"><center>No Data</center></div>
            <?php
        }
    }
}
?>