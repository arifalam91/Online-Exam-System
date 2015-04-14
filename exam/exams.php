<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/exam.class.php');

$exm=new exam;

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');

//ERROR MESSAGE CODE
$errmsg = '';	

if(isset($_GET['msg']) && $_GET['msg']=='Appeared'){
	$errmsg='You have already appeared for this exam';
}

if(isset($_GET['msg']) && $_GET['msg']=='done'){
	$errmsg='Thank you for using our online examination system';
}

if(isset($_GET['msg']) && $_GET['msg']=='testrepeated'){
	$arr=$exm->getTestSubject($_GET['tid'],$_GET['sid']);
	$errmsg='The '.$arr[0].' for subject '.$arr[1].' is already exists.So you can not add it again';
}


if(isset($_GET['mesg']) && $_GET['mesg']=='questionadded'){
	$errmsg='Questions added successfully';
}

include('includes/header.php');
?>
</script>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="list">
			<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span><br />'; ?>
			<table cellpadding="0" cellspacing="0">
				<tr><td colspan="2" class="table_title">Exam List</td><td colspan="5" class="table_options">
				<?php if(intval($_SESSION['user_type'])!=4){?>
					<img src="images/add2.png"><a href="add_exam.php">Add Exam</a>
				<?php }?>
				</td></tr>
				<tr class="table_header"><td>Exam</td><td>Subject</td><td>Course</td><td>Semister</td><td>End Date</td><td>Test</td><td>Options</td></tr>
				<?php
	
					$arr = $exm->getExamList($_SESSION['userid'],$_SESSION['user_type']);
					if($arr)
					{
						foreach($arr as $val){
							echo "<tr class=\"table_row\"><td>$val[exam_name]</td><td>$val[subject_name]</td><td>$val[course_name]</td><td>$val[semister_name]</td><td>$val[end_date]</td><td>$val[test_name]</td>";
							if(intval($_SESSION['user_type'])==4){
								echo "<td><a href=\"showexam.php?msg=showexam&id=$val[exam_id]\" title=\"Give Exam\"><img src=\"images/note.png\" alt=\"Give Exam\" style=\"border:0px\";/></a></td></tr>";
							}
							if(intval($_SESSION['user_type'])==2 || intval($_SESSION['user_type'])==1){
								echo "<td><a href=\"edit_exam.php?msg=editexam&id=$val[exam_id]\" title=\"Edit Exam\"><img src=\"images/edit.png\" alt=\"Give Exam\" style=\"border:0px\";/></a><a href=\"javascript:seeQuestions($val[exam_id],$val[test_id])\" title=\"Print Questions\"><img src=\"images/printer.png\" alt=\"Print\" style=\"border:0px\";/></a></td></tr>";
							}
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