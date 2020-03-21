<ul class="breadcrumb">
  <li>Final Project Data</li>
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
				  //$encrypted_id = base64_encode($row[0]);
                  echo "<tr>";
				  if ($row['status'] == 'available') {
					  echo "<td>" . $no . "</td>";
					  echo "<td>" . $row['title'] . "</td>";
					  echo "<td>" . $row['year'] . "</td>";
					  echo "<td>" . $row['author']. "</td>";
					  echo "<td>" . $row['barcode']. "</td>";
					  echo "<td>" .$row['call_no'] . "</td>";
					  echo "<td><a style='cursor: pointer;' onclick='view_conselor(".$row[12].")'>" . $row['con_name']. "</a></td>";
					  echo "<td>" . $row['name']. "</td>";
					  if ($row['hard'] == 'y') {
						 echo "<td>Yes</td>";
					  }else {
						 echo "<td>No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
						 echo "<td>Yes</td>";
						 echo "<td><center><img onclick=\"view_pdf('".$encrypted_id."')\" src='../images/view.png' width='25px' height='auto' /></center></td>";
					     
					  }else {
						 echo "<td>No</td>";
						 echo "<td>Unable to view</td>";
					  }
				  }
				  else if ($row['status'] == 'unavailable') {
				      echo "<td class=\"danger\">" . $no . "</td>";
					  echo "<td class=\"danger\">" . $row['title'] . "</td>";
					  echo "<td class=\"danger\">" . $row['year'] . "</td>";
					  echo "<td class=\"danger\">" . $row['author']. "</td>";
					  echo "<td class=\"danger\">" . $row['barcode']. "</td>";
					  echo "<td class=\"danger\">" .$row['call_no'] . "</td>";
					  echo "<td class=\"danger\"><a style='cursor: pointer;' onclick='view_conselor(".$row[12].")'>" . $row['con_name']. "</a></td>";
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
					     echo "<td class=\"danger\"><center><img onclick='view_pdf(\"".$encrypted_id."\")' src='../images/view.png' width='25px' height='auto' /></center></td>";
						 
					  }else{
						 echo "<td class=\"danger\">Unable to view</td>"; 
						 
					  }
			
				  }
				  else if ($row['status'] == 'unpublished') {
					  echo "<td class=\"warning\">" . $no . "</td>";
					  echo "<td class=\"warning\">" . $row['title'] . "</td>";
					  echo "<td class=\"warning\">" . $row['year'] . "</td>";
					  echo "<td class=\"warning\">" . $row['author']. "</td>";
					  echo "<td class=\"warning\">" . $row['barcode']. "</td>";
					  echo "<td class=\"warning\">" .$row['call_no'] . "</td>";
					  echo "<td class=\"warning\"><a style='cursor: pointer;' onclick='view_conselor(".$row[12].")'>" . $row['con_name']. "</a></td>";
					  echo "<td class=\"warning\">" . $row['name']. "</td>";
					  if ($row['hard'] == 'y') {
						 echo "<td class=\"warning\">Yes</td>";
					  }else {
						 echo "<td class=\"warning\">No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
						 echo "<td class=\"warning\">Yes</td>";
						 echo "<td class=\"warning\"><center><img onclick='view_pdf(\"".$encrypted_id."\")' src='../images/view.png' width='25px' height='auto' /></center></td>";
					     
					  }else {
						 echo "<td class=\"warning\">No</td>";
						 echo "<td class=\"warning\">Unable to view</td>";
					     
					  }
					   
				  }
				  else if ($row['status'] == 'published') {
					  echo "<td class=\"success\">" . $no . "</td>";
					  echo "<td class=\"success\">" . $row['title'] . "</td>";
					  echo "<td class=\"success\">" . $row['year'] . "</td>";
					  echo "<td class=\"success\">" . $row['author']. "</td>";
					  echo "<td class=\"success\">" . $row['barcode']. "</td>";
					  echo "<td class=\"success\">" .$row['call_no'] . "</td>";
					  echo "<td class=\"success\"><a style='cursor: pointer;' onclick='view_conselor(".$row[12].")'>" . $row['con_name']. "</a></td>";
					  echo "<td class=\"success\">" . $row['name']. "</td>";
					  if ($row['hard'] == 'y') {
						 echo "<td class=\"success\">Yes</td>";
					  }else {
						 echo "<td class=\"success\">No</td>"; 
					  }
					  if ($row['soft'] == 'y') {
						 echo "<td class=\"success\">Yes</td>";
						 echo "<td class=\"success\"><center><img onclick='view_pdf(\"".$encrypted_id."\")' src='../images/view.png' width='25px' height='auto' /></center></td>";
					     
					  }else {
						 echo "<td class=\"success\">No</td>";
						 echo "<td class=\"success\">Unable to view</td>";
					    
					  }
					  
				  }
                  echo "</tr>";
            }
          echo "</tbody></table>";
	  ?>
	      <div id="dlg_details" style="display: none;"></div>
	      
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

			  			function view_pdf(id) {
							window.open("../pdf/viewer.php?code="+id, "", "_blank");
						}
						
						function view_conselor(id) {
						    if (searchReq.readyState == 4 || searchReq.readyState == 0) {
							
							
							searchReq.open("GET", '../plugin/searchexec.php?action=conselor_details&id=' + id, true);
							
							searchReq.onreadystatechange = handleView; 
							searchReq.send(null);
						    }
						}
						
						function handleView() {
							if (searchReq.readyState == 4) {
								var dialog = document.getElementById("dlg_details");
								var str =searchReq.responseText.split("&nbsp;");
								
								if(str.length==1) {
								    dialog.innerHTML = '';
								    dialog.style.visibility = "hidden";
								}
								else
								dialog.innerHTML = '';
								dialog.innerHTML += str[0];
								$(function() {
								    var wWidth = $(window).width();
								    var wHeight = $(window).height();
								    var dWidth = wWidth * 0.5;
								    var dHeight = wHeight * 0.7;
								    $( "#dlg_details" ).dialog({
									    resizable: false,
									    height:dHeight,
									    width : dWidth,
									    modal: true,
									    dialogClass: 'no-close',
									    buttons: {
									    "Close": function() {
										dialog.innerHTML = "";
										$( this ).dialog( "close" );
									    }
									    }
									    });
								});
							}
						}
	      </script>    
	  <?php
		}
		else {
		    echo "<div class=\"well\"><center><h1>Data not found</h1></center></div>";	
		}
?>