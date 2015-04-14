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

if(isset($_GET['msg']) && $_GET['msg']=='showexam'){
	$examid=$_GET['id'];
	
	$arr=$exm->getExamCourseSem($examid);
	if($arr)
	{
		foreach($arr as $val)
		{
			$coursename=$val['course_name'];
			$semistername=$val['semister_name'];
			$subjectname=$val['subject_name'];
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
	
	$marks=$exm->getExamMarks($examid);
	if($marks){
		foreach($marks as $val){
			$maxmarks=$val['max_marks'];
			$minmarks=$val['min_marks'];
			$mca=$val['marks_correct'];
			$mwa=$val['marks_wrong'];
			$test_name=$val['test_name'];
		}
	}
		
}

if($_POST && $_POST['startexam']=='start'){
	header('Location:startexam.php?msg=startexam&id='.$_GET['id']);
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
			<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span><br />' ?>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td class="exam_title">
						<span style="font-size:16px;">Exam : <?php echo $examname.'('.$test_name.')'; ?></span><br /><br />
						<span style="font-size:12px; color:#333333; font-weight:normal;"><strong>Subject : </strong><?php echo $subjectname; ?>&nbsp;&nbsp;&nbsp;<strong>Course : </strong><?php echo $coursename; ?>&nbsp;&nbsp;&nbsp;<strong>Semister : </strong><?php echo $semistername; ?></span>
						<br /><br />
						<span style="font-size:14px; color:#333333; font-weight:normal;"><strong>Exam Duration : </strong><?php echo $examtime; ?> Minutes</span>
					</td>
				</tr>
				<tr>
					<td><br /><br />
						<span style="font-size:12px; color:#333333; font-weight:normal;"><strong>Max. Marks:</strong><?php echo $maxmarks;?></span>&nbsp;&nbsp;&nbsp;
						<span style="font-size:12px; color:#333333; font-weight:normal;"><strong>Min. Marks:</strong><?php echo $minmarks;?></span><br /><br /><br />
						<span style="font-size:12px; color:#333333; font-weight:normal;"><strong>Marks for Correct Answer:</strong><?php echo $mca;?></span>&nbsp;&nbsp;&nbsp;
						<span style="font-size:12px; color:#333333; font-weight:normal;"><strong>Marks for Wrong Answer:</strong><?php echo $mwa;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<br /><br />
						<strong>Note : </strong>One student can give exam once only.A student can not opt twice for same exam.&nbsp;
						<div style="height:300px; width:500px; border:1px solid #CCCCCC; padding:10px; overflow:scroll; margin:15px 0px;">
							<?php echo $examrule; ?>
						</div>
					</td>
				</tr>
				<tr><td><form method="post"><input type="hidden" name="startexam" id="startexam" value="start" /><input type="submit" name="agree" id="agree" value="Agree and Proceed to Exam" />&nbsp;&nbsp;<input type="button" name="cancel" id="cancel" value="Cancel" /></form></td></tr>
				
			</table>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>