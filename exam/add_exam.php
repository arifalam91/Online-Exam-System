<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/exam.class.php');

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');


$examname='';
$commencedate='';
$enddate='';
$rules='';
$time='';
$noofques='';
$maxmarks='';
$minmarks='';
$mca='';
$mwa='';
	

$error_flag=false;
$errmsg = '';

$exm=new exam;

if(isset($_POST['action']) && $_POST['action']=='addexam'){
	$examname=trim($_POST['examname']);
	//$commencedate=trim($_POST['commencedate']);
	$enddate=trim($_POST['enddate']);
	$rules=trim($_POST['rules']);
	$time=trim($_POST['time']);
	$noofques=trim($_POST['noofques']);
	$maxmarks=trim($_POST['maxmarks']);
	$minmarks=trim($_POST['minmarks']);
	$mca=trim($_POST['mca']);
	$mwa=trim($_POST['mwa']);
	$skilltest=trim($_POST['skilltest']);
	$subject=trim($_POST['subject']);
	
	
	if(!$error_flag){
		if(!$exm->checkSkilltestSubject($subject,$skilltest)){
			if(!$exm->addExam($examname,$subject,$_SESSION['userid'],$enddate,$rules,$time,$noofques,$maxmarks,$minmarks,$mca,$mwa,$skilltest)){
				$error_flag=true;
				$errmsg='Could not create exam.';
			}else{
				header('Location: add_questions.php?msg=examadded&questions='.$_POST['noofques'].'&id='.mysql_insert_id());
			}
		}else{
			header('Location:exams.php?msg=testrepeated&tid='.$skilltest.'&sid='.$_POST['subject']);
		}
	}
	
}	


include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="form">
		<form method="post">
		<input type="hidden" name="action" id="action" value="addexam" />
		<table cellpadding="3" cellspacing="0">
		<tr><td class="table_title" colspan="2">Add Exam</td></tr><?php echo '<span class="errormsg"> * - Mandatory Fields </span>'; ?>
		<?php if(trim($errmsg)!='') echo '<tr><td colspan="2"><span class="errormsg">'.$errmsg.'</span></td></tr>' ?>
		<tr>
			<td>Subject</td>
			<td>
				<select type="text" name="subject" id="subject">
					<?php
						$arr_sub=$exm->getSubjectsForExam($_SESSION['userid'],$_SESSION['user_type']);
						if($arr_sub){
							foreach($arr_sub as $val_sub){
								print_r($val_sub);
								echo '<option value="'.$val_sub['subject_id'].'" />'.$val_sub['subject_name'].' ('.$val_sub['course_name'].' '.$val_sub['semister_name'].')</option>';
							}
						}
					?>	
				</select>
			</td>
		</tr>
		<tr><td>Exam Name</td><td><input type="text" name="examname" id="examname" value="<?php echo $examname; ?>" /><span class="date_format"> * </span></td></tr>
		<tr><td style="vertical-align:top;">Rules</td><td><textarea name="rules" id="rules" rows="10" cols="50"><?php echo $rules?></textarea></td></tr>
		<!--<tr><td>Commence Date</td><td><input type="text" name="commencedate" id="commencedate" value="<?php echo $commencedate; ?>"/> <span class="date_format">(yyyy/mm/dd)&nbsp;Example:2009/10/30</span></td></tr>-->
		<tr><td>Date</td><td><input type="text" name="enddate" id="enddate" value="<?php echo $enddate; ?>" /> <span class="date_format"> * (yyyy/mm/dd)</span></td></tr>
		<tr><td>Time</td><td><input type="text" name="time" id="time" value="<?php echo $time; ?>" /> <span class="date_format"> * (Minutes) </span></td></tr>
		<tr><td>Number Of Questions</td><td><input type="text" name="noofques" id="noofques"  maxlength="2" value="<?php echo $noofques; ?>" /><span class="date_format"> * </span></td></tr>
		<tr><td>Max. Passing Marks</td><td><input type="text" name="maxmarks" id="maxmarks"  maxlength="2" value="<?php echo $maxmarks; ?>" /><span class="date_format"> * </span></td></tr>
		<tr><td>Min. Passing Marks</td><td><input type="text" name="minmarks" id="minmarks"  maxlength="2" value="<?php echo $minmarks; ?>" /><span class="date_format"> * </span></td></tr>
		<tr><td>Marks for correct answer</td><td><input type="text" name="mca" id="mca"  maxlength="2" value="<?php echo $mca; ?>" /><span class="date_format"> * </span></td></tr>
		<tr><td>Marks for wrong answer</td><td><input type="text" name="mwa" id="mwa"  maxlength="2" value="<?php echo $mwa; ?>" /><span class="date_format"> * </span></td></tr>
		<tr>
			<td>
				Select Test
			</td>
			<td>
				<select name="skilltest" id="skilltest">
					<?php 
						$arr_test=$exm->selectTest();
						foreach($arr_test as $val_test){
							echo '<option value="'.$val_test['test_id'].'">'.$val_test['test_name'].'</option>';
						}
					?>
				</select>
			</td>
		</tr>
		<tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit"  value="Submit"/></td></tr>
				
		</table>
		
		</form>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>