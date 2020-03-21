<script>
function disable()
  {
  document.getElementById("file_pdf").disabled=true;
  }
function enable()
  {
  document.getElementById("file_pdf").disabled=false;
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
</script>
<ul class="breadcrumb">
      <li>Home</li>
      <li class="active">Edit Thesis Data</li>
    </ul>
<?php
include "session.php";
include "../conn.php";

if (!empty($_GET['id'])) {
	$id = $_GET['id'];
	$sql = mysql_query("select * from thesis where id = '$id'") or die (mysql_error());
	$data = mysql_fetch_array($sql);
	?>
    <div class="scrollbar">
    <form name="form" method="post" action="?page=edit&action=update" enctype="multipart/form-data" class="form-horizontal">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
      <fieldset>
        <legend>Edit <?php echo $data['title']; ?></legend>
        <div class="form-group">
          <label for="textArea" class="col-lg-2 control-label">Title</label>
          <div class="col-lg-6">
            <textarea name="title" class="form-control" rows="3" id="textArea" ><?php  echo $data['title']; ?></textarea>
            <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Year</label>
          <div class="col-lg-1">
            <input name="year" class="form-control" id="focusedInput" type="text" value="<?php  echo $data['year']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Author Name</label>
          <div class="col-lg-5">
            <input name="author" class="form-control" id="focusedInput" type="text" value="<?php  echo $data['author']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Barcode ID</label>
          <div class="col-lg-2">
            <input name="barcode" class="form-control" id="focusedInput" type="text" value="<?php  echo $data['barcode']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Call Number</label>
          <div class="col-lg-2">
            <input name="num" class="form-control" id="focusedInput" type="text" value="<?php  echo $data['call_no']; ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="select" class="col-lg-2 control-label">Academic Conselor</label>
          <div class="col-lg-4">
          <?php
             $query = "select * from academic_conselor";
             $result = mysql_query($query);

             echo "<select class=\"form-control\" id=\"select\" name=\"conselor\">";

             while ($row = mysql_fetch_assoc($result)) {
                echo "<option ";
				if ($data['conselor'] == $row['id']) {
				  echo "selected='\"selected\"'";	
				}
		        echo "value='".$row['id']."'> ".$row['con_name']." </option>";
             }
             echo '</select>';
             mysql_free_result($result);
             echo $selectbox;
          ?>
          </div>
        </div>
        <div class="form-group">
          <label for="select" class="col-lg-2 control-label">Program</label>
          <div class="col-lg-2">
          <?php
             $query = "select * from program";
             $result = mysql_query($query);

             echo "<select class=\"form-control\" id=\"select\" name=\"prog\">";

             while ($row = mysql_fetch_assoc($result)) {
                echo "<option ";
				if ($data['program'] == $row['id']) {
				  echo "selected='\"selected\"'";	
				}
		        echo "value='".$row['id']."'> ".$row['name']." </option>";
             }
             echo '</select>';
             mysql_free_result($result);
             echo $selectbox;
          ?>
          </div>
        </div>
        <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">Softcopy Availability</label>
          <div class="col-lg-10">
            <select name="soft">
             <option <?php if ($data['soft'] == 'y') { echo "selected='\"selected\"'"; }?> value="y">Yes</option>
             <option <?php if ($data['soft'] == 'n') { echo "selected='\"selected\"'"; }?> value="n">No</option>
            </select> 
          </div>
          <p></p>
          <label for="focusedInput" class="col-lg-2 control-label">Hardcopy Availability</label>
          <div class="col-lg-10">
            <select name="hard">
              <option <?php if ($data['hard'] == 'y') { echo "selected='\"selected\"'"; }?> value="y">Yes</option>
              <option <?php if ($data['hard'] == 'n') { echo "selected='\"selected\"'"; }?> value="n">No</option>
            </select> 
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label">Status</label>
          <div class="col-lg-10">
            <select name="status">
            <option <?php if ($data['status'] == 'available') { echo "selected='\"selected\"'"; }?> value="available">Available</option>
            <option <?php if ($data['status'] == 'published') { echo "selected='\"selected\"'"; }?> value="published">Published</option>
            <option <?php if ($data['status'] == 'unpublished') { echo "selected='\"selected\"'"; }?> value="unpublished">Unpublished</option>
            <option <?php if ($data['status'] == 'unavailable') { echo "selected='\"selected\"'"; }?> value="unavailable">Unvailable</option>
            </select>
          </div>
        </div>
         <div class="form-group">
          <label for="focusedInput" class="col-lg-2 control-label">PDF File</label>
          <div class="col-lg-10">
              <div class="checkbox">
              <label>
                <input onchange="if(this.checked){ enable()} else {disable()}" on type="checkbox"> Update PDF File
              </label>
             </div>
            <input onchange="return checkPDF()" disabled="disabled" class="btn btn-default" id="file_pdf" type="file" name="file">
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <a href="?page=home"><button type="button" class="btn btn-default">Cancel</button></a>
            <button onclick="return IsEmptyField()" type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
      </fieldset>
    </form>
    </div>
    <?php
}
else if ($_GET['action'] == 'update') {
	if (empty($_FILES['file'])) {
		$id = $_POST['id'];
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
		
		$update = mysql_query("UPDATE `thesis` SET title='$title',`author`='$an',`year`='$year',`barcode`='$bar',`call_no`='$cn',`conselor`='$con',`program`='$prog',`hard`='$hard',`soft`='$soft',`status`='$status' WHERE id = '$id'") or die (mysql_error());
		if (!mysql_error()) { ?>
					<script language="javascript">
						alert("Thesis data has been updated.");
	    				document.location="?page=home";
					</script>
          <?php
		}
	}
	else if (!empty($_FILES['file'])) {
		$id = $_POST['id'];
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
		    $insert = mysql_query("UPDATE `thesis` SET title='$title',`author`='$an',`year`='$year',`barcode`='$bar',`call_no`='$cn',`conselor`='$con',`program`='$prog',`hard`='$hard',`soft`='$soft',`status`='$status' WHERE id = '$id'") or die (mysql_error());
		
		    if (!mysql_error()) {
				$fp      = fopen($tmp_name, 'r');
				$content = fread($fp, filesize($tmp_name));
				$content = addslashes($content);
				fclose($fp);
			
				if(!get_magic_quotes_gpc())
				{
				 $file_name = addslashes($file_name);
				}
			
				$result= mysql_query("UPDATE `file` SET `file`='$content',`file_name`='$file_name',`file_type`='$file_type',`file_size`='$file_size' WHERE id = '$id'") or die(mysql_error());	
				if (!mysql_error()) { ?>
					<script language="javascript">
						alert("Thesis data has been updated.");
	    				document.location="?page=home";
					</script>
                <?php
				}
			}
		}else { ?>
		<script language="javascript">
			alert("Sorry, pdf file format only.");
	    	document.location="?page=edit&id=<?php echo $id; ?>";
		</script>
    <?php	
		}
	}
}
?>