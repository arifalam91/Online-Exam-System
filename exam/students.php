<?php
include('includes/config.php');
include('includes/user.class.php');


// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');

//ERROR MESSAGE CODE
$errmsg = '';	

if(isset($_GET['msg']) && $_GET['msg']=='useradded'){
	$errmsg='Student successfully added';
}

if(isset($_GET['msg']) && $_GET['msg']=='updated'){
	$errmsg='Student successfully updated';
}


if(isset($_GET['action']) && $_GET['action']=='activate'){
	$usr->activateUser($_GET['id']);
	$errmsg='Student successfully activated.';
}

if(isset($_GET['action']) && $_GET['action']=='block'){
	$usr->deActivateUser($_GET['id']);
	$errmsg='Student successfully De-activated.';
}

if(isset($_GET['action']) && $_GET['action']=='delete'){
	$usr->deleteStudent($_GET['id']);
	$usr->deleteCurrentSemDivision($_GET['id']);
	$errmsg='Student successfully deleted.';
}



include('includes/header.php');
?>

<!-- JAVA SCRIPT TO CONFIRM THE DELETE ACTION -->
<script language="javascript">
function conf_del(id){
	var conf = window.confirm('Are you sure that you want to delete this user?');
	if(conf)
	{
		window.location='students.php?action=delete&id='+id;
	}
}
</script>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="list">
			<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span><br />' ?>
			<table cellpadding="0" cellspacing="0">
			<tr><td colspan="2" class="table_title">Student List</td><td colspan="6" class="table_options"><img src="images/add2.png"><a href="add_student.php">Add Student</a></td></tr>
			<tr class="table_header"><td>Roll No</td><td>First Name</td><td>Last Name</td><td>Course</td><td>Sem</td><td>Div</td><td>Options</td></tr>
			<?php

				$arr = $usr->getStudentList();
				if($arr){
					foreach($arr as $val){
						$color="#33ffff";
						if($val['div_name']=='B')
						{
							$color="#99ffff";
						}
						
						echo "<tr class=\"table_row\" style=\"background-color:$color;\">
							<td>$val[rollno]</td>
							<td>$val[first_name]</td>
							<td>$val[last_name]</td>
							<td>$val[course_name]</td>
							<td>$val[semister_name]</td>
							<td>$val[div_name]</td>
							<td>
								<a href=\"edit_students.php?msg=editstudent&id=$val[user_id]\" title=\"Edit Student\">
									<img src=\"images/edit.png\" style=\"border:0px;\" alt=\"Edit Student\">
								</a>
								<a href=\"javascript:conf_del($val[user_id])\" title=\"Delete Student\">
									<img src=\"images/delete2.png\" style=\"border:0px;\" alt=\"Delete Student\">
								</a>
							</td>
							</tr>";
					}					
				}
			?>
			</table>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>