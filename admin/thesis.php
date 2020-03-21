<script>
function disable()
  {
  document.getElementById("file_pdf").disabled=true;
  }
function enable()
  {
  document.getElementById("file_pdf").disabled=false;
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
function checkPDF() {
        var fileElement = document.getElementById("file_pdf");
        var fileExtension = "";
        if (fileElement.value.lastIndexOf(".") > 0) {
            fileExtension = fileElement.value.substring(fileElement.value.lastIndexOf(".") + 1, fileElement.value.length);
        }
        if (fileExtension == "pdf") {
            return true;
        }
        else {
            alert("You must select a PDF file for upload");
			document.getElementById('file_pdf').value='';
            return false;
        }
    }
function IsEmptyField(){
  if(document.forms['form'].title.value == "" || document.forms['form'].year.value == "" || document.forms['form'].author.value == "" || document.forms['form'].barcode.value == "" || document.forms['form'].num.value == "")
  {
    alert("There is/are empty field.");
    return false;
  }
    return true;
}
function IsEmptyImport(){
  if(document.forms['form'].file.value == "")
  {
    alert("There is/are empty field.");
    return false;
  }
    return true;
}
</script>
<?php
include "../conn.php";
if (!empty($_GET['action']) and $_GET['action'] == 'upload_pdf') { ?>
<ul class="breadcrumb">
      <li>Menu</li>
      <li class="active">Upload PDF</li>
</ul>
<?php 
 if (!empty($_POST['uploading'])) {
	 $id = $_POST['uploading'];
	 
     $file_name = str_replace(' ', '%20', $_FILES['file']['name']); //nama file (tanpa path)
	 $tmp_name  = $_FILES['file']['tmp_name']; //nama local temp file di server
     $file_size = $_FILES['file']['size']; //ukuran file (dalam bytes)
     $file_type = $_FILES['file']['type']; //tipe filenya (langsung detect MIMEnya)
	 
	 if ($file_type == 'application/pdf') {
	 $fp      = fopen($tmp_name, 'r');
	 $content = fread($fp, filesize($tmp_name));
	 $content = addslashes($content);
	 fclose($fp);
			
	 if(!get_magic_quotes_gpc())
	 {
	  $file_name = addslashes($file_name);
	 }
			
	 $result= mysql_query("INSERT INTO `file`(`id`, `file`, `file_name`, `file_type`, `file_size`) VALUES ('$id','$content','$file_name','$file_type','$file_size')") or die(mysql_error());	
	 mysql_query("update thesis set soft = 'y' where id = '$id'") or die (mysql_error());
	 if (!mysql_error()) { ?>
		<script language="javascript">
			alert("You're file has been upladed");
	    	document.location="?page=thesis&action=upload_pdf";
			</script>
        <?php
	 }
	}else{?>
		<script language="javascript">
			alert("Sorry, pdf file format only.");
	    	document.location="?page=thesis&action=upload_pdf";
		</script>
    <?php
	}
 } 
 else { ?>
<form method="post" action="?page=thesis&action=upload_pdf" enctype="multipart/form-data">
  <div class="well">
   <table width="1178" border="0">
      <tr>
        <td width="92">Title</td>
        <td width="544"><?php 
		     $query = "select * from thesis where id not in (select id from file) order by title asc";
             $result = mysql_query($query) or die (mysql_error());

             echo "<select class=\"form-control\" name=\"uploading\">";
			 echo "<option>Choose Title</option>";
             while ($row = mysql_fetch_assoc($result)) {
                echo "<option ";
		        echo "value='".$row['id']."'> ".$row['title']." </option>";
             }
             echo '</select>';
             mysql_free_result($result);
             echo $selectbox;
		?> 
        </td>
        <td width="375"><input type="file" name="file" id="file" class="btn-default" /></input></td>
        <td width="149">&nbsp;<button type="submit" class="btn btn-default">Upload</button></td>
      </tr>
   </table>
  </div>
 </form>
 <?php	 
 }
}
else if (!empty($_GET['action']) and $_GET['action'] == 'new') {
	?>
    <ul class="breadcrumb">
      <li>Menu</li>
      <li class="active">Add new final project</li>
    </ul>
    <div class="scrollbar">
    <form name="form" method="post" action="?page=thesis&action=add_new" enctype="multipart/form-data" class="form-horizontal">
      <fieldset>
        <legend>Input new final project data</legend>
        <div class="form-group">
          <label for="textArea" class="col-lg-2 control-label">Title</label>
          <div class="col-lg-6">
            <textarea name="title" class="form-control" rows="3" id="textArea"></textarea>
            <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Year</label>
          <div class="col-lg-1">
            <input name="year" class="form-control" id="focusedInput" type="text">
          </div>
        </div>
		<div class="form-group">
          <label for="select" class="col-lg-2 control-label">Program</label>
          <div class="col-lg-2">
          <?php
             $query = "select * from program order by program.name asc";
             $result = mysql_query($query);

             echo "<select onchange='program_select()' class=\"form-control\" id=\"prog\" name=\"prog\">";
			 echo "<option>Choose Program</option>";
             while ($row = mysql_fetch_assoc($result)) {
                echo "<option ";
		        echo "value='".$row['id']."'> ".$row['name']." </option>";
             }
             echo '</select>';
             mysql_free_result($result);
             echo $selectbox;
          ?>
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Author Name</label>
          <div class="col-lg-5">
            <!-- <input name="author" class="form-control" id="focusedInput" type="text"> -->
			<select id="author" name="author" class="form-control">
            	<option>No Value</option>
            </select>
          </div>
        </div>
		<div class="form-group">
          <label for="select" class="col-lg-2 control-label">Academic Conselor</label>
          <div class="col-lg-4">
          <?php
             $query = "select * from academic_conselor order by con_name asc";
             $result = mysql_query($query);

             echo "<select class=\"form-control\" id=\"select\" name=\"conselor\">";

             while ($row = mysql_fetch_assoc($result)) {
                echo "<option ";
		        echo "value='".$row['id']."'> ".$row['con_name']." </option>";
             }
             echo '</select>';
             mysql_free_result($result);
             echo $selectbox;
          ?>
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Barcode ID</label>
          <div class="col-lg-2">
            <input name="barcode" class="form-control" id="focusedInput" type="text">
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Call Number</label>
          <div class="col-lg-2">
            <input name="num" class="form-control" id="focusedInput" type="text">
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Softcopy Availability</label>
          <div class="col-lg-10">
            <select name="soft">
            <option value="y">Yes</option>
            <option value="n">No</option>
            </select> 
          </div>
          <p></p>
          <label for="focusedInput" class="col-lg-2 control-label">Hardcopy Availability</label>
          <div class="col-lg-10">
            <select name="hard">
            <option value="y">Yes</option>
            <option value="n">No</option>
            </select> 
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label">Status</label>
          <div class="col-lg-10">
            <select name="status">
            <option value="available">Available</option>
            <option value="published">Published</option>
            <option value="unpublished">Unpublished</option>
            <option value="unavailable">Unvailable</option>
            </select>
          </div>
        </div>
         <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">PDF File</label>
          <div class="col-lg-10">
              <div class="checkbox">
              <label>
                <input onchange="if(this.checked){ enable()} else {disable()}" on type="checkbox"> With PDF File
              </label>
             </div>
            <input onchange="return checkPDF()" disabled="disabled" class="btn btn-default" id="file_pdf" type="file" name="file">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <a href="?page=home"><button type="button" class="btn btn-default">Cancel</button></a>
            <button onclick="return IsEmptyField()" type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </fieldset>
    </form>
    </div>
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
	
    function program_select() {
		if (searchReq.readyState == 4 || searchReq.readyState == 0) {
			var e = document.getElementById("prog");
			var id = e.options[e.selectedIndex].value;
            searchReq.open("GET", 'search.php?search=' + id + '&do=author_program', true);
                        
            searchReq.onreadystatechange = authorOption; 
            searchReq.send(null);
        } 	
	}
	
	function authorOption() {
		if (searchReq.readyState == 4) {
			var str =searchReq.responseText.split("&nbsp;");
			var option = document.getElementById("author");
			
			option.innerHTML = str;	
		}
	}
    </script>
    <?php
}
else if (!empty($_GET['action']) and $_GET['action'] == 'add_new') { // jika ada perintah simpan add new thesis data
    $date = date('Y-m-d', time());
	if (empty($_FILES['file'])) { // jika upload pdf non aktif
		$title = preg_replace('~[\\\\/:*?"<>|\n]~'," ",json_encode($_POST['title']));
		$year = $_POST['year'];
		$an = $_POST['author'];
		$bar = $_POST['barcode'];
		$cn = $_POST['num'];
		$con = $_POST['conselor'];
		$prog = $_POST['prog'];
		$status = $_POST['status'];
		$soft = $_POST['soft'];
		$hard = $_POST['hard'];
		
		$insert = mysql_query("INSERT INTO `thesis`(`id`, `title`, `author`, `date`, `year`, `barcode`, `call_no`, `conselor`, `program`, `hard`, `soft`, `status`) VALUES (NULL,'$title','$an', '$date', '$year','$bar','$cn','$con','$prog','$hard','$soft','$status')") or die (mysql_error());
		if (!mysql_error()) { ?>
					<script language="javascript">
						alert("New thesis data has been saved.");
	    				document.location="?page=thesis&action=new";
					</script>
          <?php
		}
	}
	else if (!empty($_FILES['file'])) { // jika upload pdf aktif
		$title = $_POST['title'];
		$year = $_POST['year'];
		$an = $_POST['author'];
		$bar = $_POST['barcode'];
		$cn = $_POST['num'];
		$con = $_POST['conselor'];
		$prog = $_POST['prog'];
		$status = $_POST['status'];
		$soft = $_POST['soft'];
		$hard = $_POST['hard'];
		
		$file_name = str_replace(' ', '%20', $_FILES['file']['name']); //nama file (tanpa path)
	    $tmp_name  = $_FILES['file']['tmp_name']; //nama local temp file di server
		$file_size = $_FILES['file']['size']; //ukuran file (dalam bytes)
		$file_type = $_FILES['file']['type']; //tipe filenya (langsung detect MIMEnya)
		
		if ($file_type == 'application/pdf') {
		    $insert = mysql_query("INSERT INTO `thesis`(`id`, `title`, `author`, `date`, `year`, `barcode`, `call_no`, `conselor`, `program`, `hard`, `soft`, `status`) VALUES (NULL,'$title','$an', '$date', '$year','$bar','$cn','$con','$prog','$hard','$soft','$status')") or die (mysql_error());
		
		    if (!mysql_error()) {
				$cek = mysql_query("select id from thesis where title = '$title'") or die (mysql_error());
				$id = mysql_fetch_array($cek);
		
				$fp      = fopen($tmp_name, 'r');
				$content = fread($fp, filesize($tmp_name));
				$content = addslashes($content);
				fclose($fp);
			
				if(!get_magic_quotes_gpc())
				{
				 $file_name = addslashes($file_name);
				}
			
				$result= mysql_query("INSERT INTO `file`(`id`, `file`, `file_name`, `file_type`, `file_size`) VALUES ('".$id['id']."','$content','$file_name','$file_type','$file_size')") or die(mysql_error());	
				if (!mysql_error()) { ?>
					<script language="javascript">
						alert("You're file has been upladed");
	    				document.location="?page=thesis&action=new";
					</script>
                <?php
				}
			}
		}else { ?>
		<script language="javascript">
			alert("Sorry, pdf file format only.");
	    	document.location="?page=thesis&action=new";
		</script>
    <?php	
		}
	}
}
else if (!empty($_GET['action']) and $_GET['action'] == 'import') { // jika ada perintah import 
if (!empty($_FILES['file'])) { // jika ada perintah import file excel
 include "excel_reader.php";
 include "../conn.php";	
 
 $date = date('Y-m-d', time());
 
 $data = new Spreadsheet_Excel_Reader($_FILES['file']['tmp_name']);

// membaca jumlah baris dari data excel
 $baris = $data->rowcount($sheet_index=0);
 
// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
 $count = $baris - 1; // menghitung jumlah baris dikurangi kolom
 $sukses = 0;
 $gagal = 0;
 
 // import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
 for ($i=2; $i<=$baris; $i++)
 {
  // membaca data nim (kolom ke-1)
  $title = $data->val($i, 1);
  // membaca data nama (kolom ke-2)
  $author = $data->val($i, 2);
  // membaca data alamat (kolom ke-3) dst
  $year = $data->val($i, 3);
  $barcode = $data->val($i, 4);
  $call = $data->val($i, 5);
  $conselor = $data->val($i, 6);
  $program = $data->val($i, 7);
  $hard = $data->val($i, 8);
  $soft = $data->val($i, 9);
  $status = $data->val($i, 10);
  $sql = mysql_query("select id from academic_conselor where con_name like '%$conselor%'") or die (mysql_error());
  $sql_program = mysql_query("SELECT id FROM program WHERE program.name LIKE '%$program%'");
  $data_program = mysql_fetch_array($sql_program);
    if (!mysql_error()) { 
     $num = mysql_num_rows($sql);
  	 if ($num == 1) {
		$id = mysql_fetch_array($sql);
        $query = "INSERT INTO thesis VALUES (NULL, '$title', '$author', '$date', '$year', '$barcode', '$call', '".$id['id']."', '".$data_program['id']."', '$hard', '$soft', '$status')";
        $hasil = mysql_query($query) or die (mysql_error());

		  // jika proses insert data sukses, maka counter $sukses bertambah
		  // jika gagal, maka counter $gagal yang bertambah
       if (!mysql_error()) $sukses++;
       else $gagal++;
       }
   
       // tampilan status sukses dan gagal
    }
    else{ ?>
	  <meta http-equiv="refresh" content="5;url=?page=home" />
      <div class="well">
      <h3>There is ambiguous data in conselor name. Failed to import.</h3>
      </div>
     <?php
   }
  }
  ?>
      
      <div class="well">
      <h3>Import process has been completed. <br>The page will be redirect automatically in 5 seconds.</h3>
      <p>Row counts : <?php echo $count; ?></p>
      <p>Successfully Imported : <?php echo $sukses; ?><br>
      Failed to be imported : <?php echo $gagal; ?></p>
      </div>
      <?php
}
else {
?>
	<center><b>Import Thesis Data</b></center>
    <br /><center>DOWNLOAD TEMPLATE <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/thesis_import_template.xls" target="_blank">HERE</a></center>
    <div class="well">
	<form name="form" method="post" enctype="multipart/form-data" action="?page=thesis&action=import">
		 <label>Please choose Excel File (2003 Format : xls) :</label><input class="btn btn-default" onchange="return checkFile()" id="file" type="file" name="file">
         <p>&nbsp;</p>
         <p><button onclick="return IsEmptyImport()" type="submit" class="btn btn-primary">Import</button>&nbsp;<button type="reset" class="btn btn-warning">Cancel</button></p>
	</form>
    </div>
    <?php
}
}
?>