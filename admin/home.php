<ul class="breadcrumb">
  <li>Home</li>
</ul>
<?php
include "session.php";
include "../conn.php";
$sql = mysql_query("select * from thesis, academic_conselor, program where thesis.conselor = academic_conselor.id and thesis.program = program.id order by year desc") or die (mysql_error());
$num = mysql_num_rows($sql);
$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
$key = "bladeyeshibbir?1%59#";
        
		if ($num > 0) { ?>
		  <table id="myTable" class="table table-bordered">
		    <thead>
                  <tr class="active">
				  <th>No.</th>
				  <th>Title</th>
                  <th>Year</th>
                  <th>Author</th>
                  <th>Barcode ID</th>
				  <th>Call Number</th>
				  <th>Academic Conselor</th>
				  <th>Program</th>
				  <th><img src="../images/book.png" width="30px" height="auto" /></th>
				  <th><img src="../images/pdf.png" width="27px" height="auto" /></th>
				  <th>Preview</th>
				  <th>Download</th>
                  <th>Edit</th>
                  <th>Delete</th>
                  </tr>
		    </thead>
		    <tbody>
<?php
           for($i=0;$i<$num;$i++)
            {
				  $row = mysql_fetch_array($sql);
				  $no = $i + 1;
				$text = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $row[0], MCRYPT_MODE_ECB, $iv);
				$encrypted_id = rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
                  echo "<tr>";
				  if ($row['status'] == 'available') {
					  echo "<td>" . $no . "</td>";
					  echo "<td>" . $row['title'] . "</td>";
					  echo "<td>" . $row['year'] . "</td>";
					  echo "<td>" . $row['author']. "</td>";
					  echo "<td>" . $row['barcode']. "</td>";
					  echo "<td>" .$row['call_no'] . "</td>";
					  echo "<td>" . $row['con_name']. "</td>";
					  echo "<td>" . $row['name']. "</td>";
					  if ($row['hard'] == 'y') {
						 echo "<td>Yes</td>";
					  }else {
						 echo "<td>No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
						 echo "<td>Yes</td>";
						 echo "<td><center><a target=\"_blank\" target=\"_blank\" href=\"../pdf/viewer.php?code=".$encrypted_id."\"><img src='../images/view.png' width='25px' height='auto' /></a></center></td>";
					     echo "<td><center><a href=\"../download.php?id=".$row[0]."\"><img src='../images/download.png' width='30px' height='auto' /></a></center></td>";
					  }else {
						 echo "<td>No</td>";
						 echo "<td>Unable to view</td>";
					     echo "<td>Unable to download</td>"; 
					  }
					  echo "<td><center><a href=\"?page=edit&id=".$row[0]."\"><img src='../images/edit.png' width='25px' height='auto' /></a></center></td>";
					  echo "<td><center><a href=\"?page=delete&id=".$row[0]."\" onclick=\"return confirm('Are you sure?')\"><img src='../images/delete.png' width='25px' height='auto' /></a></center></td>";
				  }
				  else if ($row['status'] == 'unavailable') {
				      echo "<td class=\"danger\">" . $no . "</td>";
					  echo "<td class=\"danger\">" . $row['title'] . "</td>";
					  echo "<td class=\"danger\">" . $row['year'] . "</td>";
					  echo "<td class=\"danger\">" . $row['author']. "</td>";
					  echo "<td class=\"danger\">" . $row['barcode']. "</td>";
					  echo "<td class=\"danger\">" .$row['call_no'] . "</td>";
					  echo "<td class=\"danger\">" . $row['con_name']. "</td>";
					  echo "<td class=\"danger\">" . $row['name']. "</td>";
					  if ($row['hard'] == 'y') {
						 echo "<td class=\"danger\">Yes</td>";
					  }else {
						 echo "<td class=\"danger\">No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
						 echo "<td class=\"danger\">Yes</td>";
					  }else {
						 echo "<td class=\"danger\">No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
					     echo "<td class=\"danger\"><center><a target=\"_blank\" target=\"_blank\" href=\"../pdf/viewer.php?code=".$encrypted_id."\"><img src='../images/view.png' width='25px' height='auto' /></a></center></td>";
						 echo "<td class=\"danger\"><center><a href=\"../download.php?id=".$row[0]."\"><img src='../images/download.png' width='30px' height='auto' /></a></center></td>";
					  }else{
						 echo "<td class=\"danger\">Unable to view</td>"; 
						 echo "<td class=\"danger\">Unable to download</td>"; 
					  }
					  echo "<td class=\"danger\"><center><a href=\"?page=edit&id=".$row[0]."\"><img src='../images/edit.png' width='25px' height='auto' /></a></center></td>";
					  echo "<td class=\"danger\"><center><a href=\"?page=delete&id=".$row[0]."\" onclick=\"return confirm('Are you sure?')\"><img src='../images/delete.png' width='25px' height='auto' /></a></center></td>";
				  }
				  else if ($row['status'] == 'unpublished') {
					  echo "<td class=\"warning\">" . $no . "</td>";
					  echo "<td class=\"warning\">" . $row['title'] . "</td>";
					  echo "<td class=\"warning\">" . $row['year'] . "</td>";
					  echo "<td class=\"warning\">" . $row['author']. "</td>";
					  echo "<td class=\"warning\">" . $row['barcode']. "</td>";
					  echo "<td class=\"warning\">" .$row['call_no'] . "</td>";
					  echo "<td class=\"warning\">" . $row['con_name']. "</td>";
					  echo "<td class=\"warning\">" . $row['name']. "</td>";
					  if ($row['hard'] == 'y') {
						 echo "<td class=\"warning\">Yes</td>";
					  }else {
						 echo "<td class=\"warning\">No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
						 echo "<td class=\"warning\">Yes</td>";
						 echo "<td class=\"warning\"><center><a target=\"_blank\" target=\"_blank\" href=\"../pdf/viewer.php?code=".$encrypted_id."\"><img src='../images/view.png' width='25px' height='auto' /></a></center></td>";
					     echo "<td class=\"warning\"><center><a href=\"../download.php?id=".$row[0]."\"><img src='../images/download.png' width='30px' height='auto' /></a></center></td>";
					  }else {
						 echo "<td class=\"warning\">No</td>";
						 echo "<td class=\"warning\">Unable to view</td>";
					     echo "<td class=\"warning\">Unable to download</td>"; 
					  }
					   echo "<td class=\"warning\"><center><a href=\"?page=edit&id=".$row[0]."\"><img src='../images/edit.png' width='25px' height='auto' /></a></center></td>";
					   echo "<td class=\"warning\"><center><a href=\"?page=delete&id=".$row[0]."\" onclick=\"return confirm('Are you sure?')\"><img src='../images/delete.png' width='25px' height='auto' /></a></center></td>";
				  }
				  else if ($row['status'] == 'published') {
					  echo "<td class=\"success\">" . $no . "</td>";
					  echo "<td class=\"success\">" . $row['title'] . "</td>";
					  echo "<td class=\"success\">" . $row['year'] . "</td>";
					  echo "<td class=\"success\">" . $row['author']. "</td>";
					  echo "<td class=\"success\">" . $row['barcode']. "</td>";
					  echo "<td class=\"success\">" .$row['call_no'] . "</td>";
					  echo "<td class=\"success\">" . $row['con_name']. "</td>";
					  echo "<td class=\"success\">" . $row['name']. "</td>";
					  if ($row['hard'] == 'y') {
						 echo "<td class=\"success\">Yes</td>";
					  }else {
						 echo "<td class=\"success\">No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
						 echo "<td class=\"success\">Yes</td>";
						 echo "<td class=\"success\"><center><a target=\"_blank\" target=\"_blank\" href=\"../pdf/viewer.php?code=".$encrypted_id."\"><img src='../images/view.png' width='25px' height='auto' /></a></center></td>";
					     echo "<td class=\"success\"><center><a href=\"../download.php?id=".$row[0]."\"><img src='../images/download.png' width='30px' height='auto' /></a></center></td>";
					  }else {
						 echo "<td class=\"success\">No</td>";
						 echo "<td class=\"success\">Unable to view</td>";
					     echo "<td class=\"success\">Unable to download</td>"; 
					  }
					  echo "<td class=\"success\"><center><a href=\"?page=edit&id=".$row[0]."\"><img src='../images/edit.png' width='25px' height='auto' /></a></center></td>";
					  echo "<td class=\"success\"><center><a href=\"?page=delete&id=".$row[0]."\" onclick=\"return confirm('Are you sure?')\"><img src='../images/delete.png' width='25px' height='auto' /></a></center></td>";
				  }
                  echo "</tr>";
            }
          echo "</tbody></table>";
	  ?>
	      <script language="javascript">
		$(document).ready(function() {
		    var wHeight = $(window).height();
		    var dHeight = wHeight * 0.60;
			$('#myTable').dataTable( {
				"iDisplayLength": 25,
			    "scrollY": dHeight,
			    "scrollX" : true
			} );
		} );
	      </script>    
	  <?php
		}
		else {
		    echo "<div class=\"well\"><center><h1>Data not found</h1></center></div>";	
		}
?>