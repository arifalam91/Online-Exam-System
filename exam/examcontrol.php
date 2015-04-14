<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/courses.class.php');
include('includes/exam.class.php');

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');

$crs=new courses;
$exm=new exam;

$error_flag=false;
$errmsg='';

$username='';
$testid='';
if(isset($_GET['msg']) && $_GET['msg']=='getsubjects'){
	$username=$_GET['id'];
	$testid=$_GET['tid'];
	//echo $testid;
	if($usr->checkUserIdExists($username)){
		$exams=$usr->getExamsByUserId($username,$testid);
	}else{
		$error_flag=true;
		$errmsg="Wrong User Id. Please enter valid User Id";
	}
}

if(isset($_GET['msg']) && $_GET['msg']=='wrongcombo'){
	$errmsg='Incorrect input combination';
	$error_flag=true;
}

if(isset($_GET['msg']) && $_GET['msg']=='successfullyreallowed'){
	$errmsg='Exam successfully Re-Allowed';
	$error_flag=true;
}

if(isset($_GET['msg']) && $_GET['msg']=='queryerror'){
	$errmsg='Error in requesting process';
	$error_flag=true;
}



if(isset($_POST['action']) && $_POST['action']=='allowreexam'){
	
	$username=$_POST['userid'];
	$exam=$_POST['exam'];
	$test=$_POST['skilltest'];
	
	//echo $username;
	//echo $exam;
	//echo $test;
	
	if($username=='' || $exam=='none' || $test=''){
		
		if($exam=='none'){
			$errmsg='You have not appeared for any exam.';
			$error_flag=true;
		}else{
			$errmsg='All fields are compulsory.';
			$error_flag=true;
		}
	}
	
	if($exam=='0'){
		$errmsg='Please select proper Exam.';
		$error_flag=true;
	}
	
	if(!$error_flag){
		
		//if($usr->checkExamTestExists($exam,$test)==true){
			if($exm->allowReExam($username,$exam,$test)){
				header('Location: examcontrol.php?msg=successfullyreallowed');
			}else{
				header('Location: examcontrol.php?msg=queryerror');
			}
		//}else{
			//	header('Location:examcontrol.php?msg=wrongcombo');
		//}
	}
}

include('includes/header.php');

?>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu"><?php include('includes/leftmenu.php'); ?></td>
	<td style="vertical-align:top;">
		<form method="post">
		<input type="hidden" id="action" name="action" value="allowreexam"/>
			<table cellpadding="3" cellspacing="3" border="0">
			<tr><td class="table_title" colspan="2">Admin Control</td></tr>
			<?php if(trim($errmsg)!='') echo '<tr><td colspan="2"><span class="errormsg">'.$errmsg.'</span></td></tr>' ?>
			<tr><td>User ID</td><td><input type="text" id="userid" name="userid" value="<?php echo $username;?>"/></td></tr>
			<tr>
				<td>Skill Test</td>
				<td>
					<select id="skilltest" name="skilltest">
					<?php
						
						$tests=$exm->selectTest();
						$abc='selected="selected"';
						foreach($tests as $val_tests){
						echo "<option value=$val_tests[test_id]>$val_tests[test_name]</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Exam</td>
				<td>
					<select id="exam" name="exam">
						
						<?php
							
							if($exams)
							{
								echo '<option value="0">Select Exam</option>';
								foreach($exams as $val_exams)
								{
									echo "<option value=$val_exams[exam_id]>$val_exams[exam_name]</option>";
								}
							}else{
								echo '<option value="none">Exams Not Available</option>';
							}
						?>
					</select>
					
					<span><input type="button" name="check" id="check" value="Check Availability" onclick="javascript:test('examcontrol.php?msg=getsubjects');" /></span>
				</td>
			</tr>
			<tr><td>&nbsp;</td><td><input type="submit" id="submit" name="submit" value="Allow Re-exam" /></td></tr>
			</table>				
		</form>
	</td>
</tr>	
</table>
<br />&nbsp;

<?php include('includes/footer.php'); ?>