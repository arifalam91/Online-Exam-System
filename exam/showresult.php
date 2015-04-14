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

if(isset($_GET['msg']) && $_GET['msg']=='showresult'){
	$examid=$_GET['id'];
	$score=$_GET['score'];
	$marks=$exm->getResult($_SESSION['userid'],$examid);
	
	$arr=$exm->getExamCourseSem($examid);
	if($arr)
	{
		foreach($arr as $val)
		{
			$coursename=$val['course_name'];
			$semistername=$val['semister_name'];
			$subjectname=$val['subject_name'];
			$maxmarks=$val['max_marks'];
			$minmarks=$val['min_marks'];
		}
	}

	$rules=$exm->getExamNameRules($examid);
	if($rules)
	{
		foreach($rules as $val)
		{
			$examname=$val['exam_name'];
			$examrule=$val['exam_rules'];
			$examtime=$val['time'];
		}
	}
}

if($_POST && $_POST['done']=='scoredone'){
	header('Location:exams.php?msg=done');
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
			<span class="exam_title" style="font-size:16px;">Exam : <?php echo $examname; ?><?php echo ' ('.$coursename.' '.$semistername.') '; ?>Result</span><br /><br />
		
			<table cellpadding="2" cellspacing="0" border="0">
				<tr class="table_header"><td>Subject Name</td><td>Maximum Marks</td><td>Minimum Passsing Marks</td><td>Correct Answers</td><td>Marks Obtained</td><td>Pass/Fail</td></tr>
				<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span><br />' ?>
				<tr>
					<td>
						<?php echo $subjectname; ?>
					</td>
					<td>		
						<?php echo $maxmarks; ?>
					</td>
					<td>
						<?php echo $minmarks; ?>
					</td>
					<td>
						<?php echo $score; ?>
					</td>
					<td>
						<?php echo $marks; ?>
					</td>
					
					<td>
						<?php echo ($marks>=$minmarks)?'Pass':'Fail'; ?>
					</td>
					
				</tr>
							
			</table>
		</div>			
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>