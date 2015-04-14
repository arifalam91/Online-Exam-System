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

	
if(isset($_GET['msg']) && $_GET['msg']=='startexam'){
	$examid=$_GET['id'];
	
	//CONDITION TO CHECK WHETHER THE STUDENT HAS ALREADY APPEARED FOR THE PARTICULAR EXAM
	if($exm->checkExamAppeared($_GET['id'],$_SESSION['userid'])){
			header('Location: exams.php?msg=Appeared');
	}else{
		//TO STORE THE STUDENT_ID AGAINST ITS EXAM_ID TO RESTRICT THE STUDENT TO APPEAR SAME EXAM TWICE.
		$exm->rememberStudentExam($examid,$_SESSION['userid']);
	}
			
	
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
	
}


if($_POST && $_POST['action']=='submitpaper'){
		
	$score=0;
	$i=0;
	$temp=0;
	$ansflag=0;
	$ans=0;
	$answers=$exm->getExamAnswers($_GET['id']);
	
	//LET GET THE MARKS ALLOTTED FOR CORRECT AS WELL AS WRONG ANSWER USING EXAM ID.
	$mks=$exm->getDefinedMarks($_GET['id']);
	
	//LOOP FOR INSERTING QUESTION_ID,STUDENT_ID,STUDENT_ANSWER AND ISCORRECT OR NOT IN ANSWER_MASTER TABLE
	foreach($answers as $ans_val){
		$i++;
		if(isset($_POST['op_'.$i])){
			if($_POST['op_'.$i]==$ans_val['correct']){
				$score++;
				$ansflag=1;
				$ans=$mks[0];
			}else{
				$temp++;
				$ansflag=0;
				$ans=$mks[1];
			}		
			$exm->storeExamAnswers($ans_val['question_id'],$_POST['op_'.$i],$_SESSION['userid'],$ansflag,$ans);	
		}
	}
	//echo $score;
	//	echo $temp;
	header('Location: showresult.php?msg=showresult&id='.$_GET['id'].'&score='.$score);
}

$bodyFunc = 'onload="javascript:startExamTimer('.$examtime.')"';
include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="list">
			<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span><br />' ?>
			<table cellpadding="0" cellspacing="5">
				<tr>
					<td class="exam_title">
						<span style="font-size:16px;">Exam : <?php echo $examname; ?></span><br /><br />
						<span style="font-size:12px; color:#333333; font-weight:normal;"><strong>Subject : </strong><?php echo $subjectname; ?>&nbsp;&nbsp;&nbsp;<strong>Course : </strong><?php echo $coursename; ?>&nbsp;&nbsp;&nbsp;<strong>Semister : </strong><?php echo $semistername; ?></span>
						<br /><br />
						<span style="font-size:14px; color:#333333; font-weight:normal;"><strong>Time Left : </strong><div id="timeleft" style="display:inline;"><?php echo $examtime; ?> Minutes</div></span>
					</td>
				</tr>
				<tr><td><hr /></td></tr>
				<form name="submitPaper" id="submitPaper" method="post">
				<input type="hidden" name="action" id="action" value="submitpaper"/>
						 
						<?php 
							$i=0;
							
							$questions=$exm->getQuestions($examid);
							foreach($questions as $q_val){
								$i++;
								$color="";
								//echo $i;
								if(($i%2)==0)
								{
									$color="#aaaaaa";
								}
								echo "<tr style=\"background-color:$color\"><td style=\"padding:10px; font-size:12px; border:1px solid #CCCCCC; line-height:20px;\"><strong>Question $i : </strong>$q_val[question]<br >";
								echo '<strong>Options</strong>&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" name="op_'.$i.'"id="op_'.$i.'" value="A" />'.$q_val['option1'].'&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" name="op_'.$i.'" id="op_'.$i.'" value="B" />'.$q_val['option2'].'&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" name="op_'.$i.'" id="op_'.$i.'" value="C" />'.$q_val['option3'].'&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" name="op_'.$i.'" id="op_'.$i.'" value="D" />'.$q_val['option4'].'
											<input type="hidden" name="question" id="question" values="'.$q_val['question_id'].'"/>
										</td>
									</tr>';
							}
						?>
				<tr>
					<td>
							<input type="submit" name="submitpaper" id="submitpaper" value="Submit Paper" />
						
					</td>
				</tr>
				</form>
			</table>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>