
<?php
include "session.php";
if ($_GET['view'] == 'yes') {
    include "../conn.php";
    ?>
    <ul class="breadcrumb">
      <li>Home</li>
      <li>Other</li>
      <li class="active">Program Data</li>
    </ul>
    <?php
    if ($_GET['do'] == 'add') {
        $name = $_POST['name'];
        $year = $_POST['year'];
        
        $sql = mysql_query("insert into program values (NULL, '$name', '$year')") or die (mysql_error());
        ?>
        <script language="javascript">
            alert('Saved successfully.');
            document.location = '?page=program&view=yes';
        </script>
        <?php
    }else if ($_GET['do'] == 'edit') {
        $id = $_GET['id'];
        $name = $_POST['name'];
        $year = $_POST['year'];
        
        $update = mysql_query("update program set name='$name', class_year='$year' where id = '$id'") or die (mysql_error());
        ?>
        <script language="javascript">
            alert('Updated successfully.');
            document.location = '?page=program&view=yes';
        </script>
        <?php
    }else if ($_GET['do'] == 'delete') {
        $id = $_GET['id'];
        $delete = mysql_query("delete from program where id = '$id'") or die (mysql_error());
        
        ?>
        <script language="javascript">
            alert('Deleted successfully.');
            document.location = '?page=program&view=yes';
        </script>
        <?php
    }else {
        $sql = mysql_query("select * from program order by class_year asc") or die (mysql_error());
        $num = mysql_num_rows($sql);
        
        if ($num <> 0) {
            ?>
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr class="active">
                                <th>No.</th>
                                <th><center>Name</center></th>
                                <th><center>Class Year</center></th>
                                <th><center>Total of Students</center></th>
                                <th><center>Total of Final Project</center></th>
                                <th><center>Final Project Percentage</center></th>
                                <th><center>Edit</center></th>
                                <th><center>Delete</center></th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                           for ($i = 0; $i < $num; $i++) {
                                $data = mysql_fetch_array($sql);
                                
                                $sql_student = mysql_query("select * from user, student where student.class = '".$data['id']."' and user.id = student.user_id") or die (mysql_error());
                                $num_student = mysql_num_rows($sql_student);
                                
                                $query = mysql_query("select * from thesis where program = '".$data['id']."'") or die (mysql_error());
                                $number = mysql_num_rows($query);
                                
                                $percent = $number / $num_student * 100;
                                
                                $no = $i + 1;
                                ?>
                                <tr class="info">
                                    <td><?php echo $no; ?></td>
                                    <td><center id="name<?php echo $data['id']; ?>"><?php echo $data['name']; ?></center></td>
                                    <td><center id="year<?php echo $data['id']; ?>"><?php echo $data['class_year']; ?></center></td>
                                    <td><center><b><?php echo $num_student; ?></b> student(s)</center></td>
                                    <td><center><b><?php echo $number; ?></b> title(s)</center></td>
                                    <td><center><b><?php echo round($percent, 2); ?></b> % of students</center></td>
                                    <td><center><button type="button" onclick="edit(<?php echo $data['id']; ?>)">Edit</button></center></td>
                                    <td><center><button type="button" onclick="del(<?php echo $data['id']; ?>)">Delete</button></center></td>
                                </tr>
                                <?php
                           }
                           ?>
                        </tbody>
                    </table>
            <div class="well"><button type="button" onclick="new_data()" class="btn btn-primary">Add New</button></div>
            <div id="dialog-form" style="display: none;">
                    <p style="color: rgb(216,0,0);" class="validateTips">*All form fields are required.</p>
            </div>
            <div id="new-form" style="display: none;">
                    <p style="color: rgb(216,0,0);" class="validateTips">*All form fields are required.</p>
                        <form id="add_new_form" name="add_new_form" action="?page=program&view=yes&do=add" method="post" class="form-horizontal">
                            <fieldset>
                            <legend id="legend-dialog">Input new program data</legend>
                            <div class="form-group">
                              <label for="textArea" class="col-lg-2 control-label">Name</label>
                              <div class="col-lg-5">
                                <input name="name" id="name" type="text" class="form-control" />
                              </div>
                            </div>
                            <div class="form-group">
                              <label for="textArea" class="col-lg-2 control-label">Year</label>
                              <div class="col-lg-5">
                                <select name="year" class="form-control" id="year" type="text"></select>
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
                
                function new_data() {
                    var current = new Date().getFullYear(),
			min = 2000,
			max = current + 3,
			select = document.getElementById('year');
							
		    for (var i = min; i<=max; i++){
			var opt = document.createElement('option');
			opt.value = i;
			opt.innerHTML = i;
			select.appendChild(opt);
		    }
                    
                    $(function() {
			var wWidth = $(window).width();
			var wHeight = $(window).height();
			var dWidth = wWidth * 0.6;
			var dHeight = wHeight * 0.6;
                        $( "#new-form" ).dialog({
			    resizable: false,
			    height:dHeight,
			    width : dWidth,
			    modal: true,
			    dialogClass: 'no-close',
			    buttons: {
					"Save": function() {
					    var text_name = document.getElementsByName('name')[0].value;
                                            if (text_name == '') {
                                                alert('Please fill the required field.');
                                            }else {
                                                document.forms["add_new_form"].submit();
                                            }
					},
					"Cancel": function() {
                                            document.forms["add_new_form"].reset();
					    $( this ).dialog( "close" );
					}
			    }
			});
                    });
                }
                
                function edit(id) {
                    var dialog = document.getElementById('dialog-form');
                    var name = document.getElementById('name'+id).innerHTML;
                    
                    dialog.setAttribute('title', 'Edit Program Data');
                    
                    var str = '<form id="edit_form" action="?page=program&view=yes&do=edit&id='+id+'" name="edit_form" method="post" class="form-horizontal">';
                    str += ' <fieldset>';
                    str += '     <legend id="legend-dialog">Edit Program Data ('+name+')</legend>';
                    str += '       <div class="form-group"><label for="textArea" class="col-lg-2 control-label">Name </label><div class="col-lg-5"><input class="form-control" name="name" id="name_edit" type="text" value="'+name+'" /></div></div>';
                    str += '       <div class="form-group"><label for="textArea" class="col-lg-2 control-label">Year </label><div class="col-lg-5"><select name="year" id="edit_year'+id+'" class="form-control"></select></div></div>';
                    str += ' </fieldset>';
                    str += '</form>';
                    
                    dialog.innerHTML = str;
                    
                    var year = document.getElementById('year'+id).innerHTML;
                    var current = new Date().getFullYear(),
			min = 2000,
			max = current + 3,
			select = document.getElementById('edit_year'+ id);
							
		    for (var i = min; i<=max; i++){
			var opt = document.createElement('option');
			opt.value = i;
			if (opt.value == year) {
                            opt.setAttribute("selected", "selected");
			}
			opt.innerHTML = i;
			select.appendChild(opt);
		    }						
                    
                    $(function() {
			var wWidth = $(window).width();
			var wHeight = $(window).height();
			var dWidth = wWidth * 0.5;
			var dHeight = wHeight * 0.5;
			$( "#dialog-form" ).dialog({
			    resizable: false,
			    height:dHeight,
			    width : dWidth,
			    modal: true,
			    dialogClass: 'no-close',
			    buttons: {
					"Save": function() {
					    var text_name = document.getElementById('name_edit').value;
                                            if (text_name == '') {
                                                alert('Please fill the required field.');
                                            }else {
                                                document.forms["edit_form"].submit();
                                            }
					},
					"Cancel": function() {
                                            dialog.innerHTML = '';
					    $( this ).dialog( "close" );
					}
			    }
			});
		    });
                }
                
                function del(id) {
                    var con = confirm('Are you sure to delete this data? Deleted data can not be restored.');
                    
                    if (con == true) {
                        document.location = '?page=program&view=yes&do=delete&id='+id+'';
                    }
                }
	    </script>
            <?php
        }else {
            ?>
            <div class="well">
                <center>
                    <h2>Data not found.</h2>
                </center>
            </div>
            <?php
        } 
    }
}
?>