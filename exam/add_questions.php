<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/exam.class.php');

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');


$error_flag=false;
$errmsg = '';

$exm=new exam;

if(isset($_GET['msg']) && $_GET['msg']=='examadded'){
	$errmsg='Exam successfully added';
}

if(isset($_POST['noofques']) && isset($_POST['examid'])){
	for($i=1;$i<=intval($_POST['noofques']);$i++)
	{
		$question=$_POST['question'.$i];
		$op1=$_POST['op_1_'.$i];
		$op2=$_POST['op_2_'.$i];
		$op3=$_POST['op_3_'.$i];
		$op4=$_POST['op_4_'.$i];
		$ans=$_POST['correctoption_'.$i];
		$examid=$_POST['examid'];
		if(!$exm->addQuestions($question,$op1,$op2,$op3,$op4,$ans,$examid)){
			$error_flag=true;
			$errmsg='error inserting questions';
		}else{
			header('Location:exams.php?mesg=questionadded&id='.mysql_insert_id());
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
		<input type="hidden" name="action" id="action" value="addquestions" />
		<input type="hidden" name="noofques" id="noofques"  value="<?php echo $_GET['questions'];?>" />
		<input type="hidden" name="examid" id="examid" value="<?php echo $_GET['id'];?>" />
		
		<table cellpadding="3" cellspacing="0">
			<tr><td class="table_title" colspan="2">Add Questions for&nbsp;
			<?php  $etitle=$exm->getExamCourseSem($_GET['id']);foreach($etitle as $val_etitle){ echo $val_etitle['subject_name'].'&nbsp;('.$val_etitle['course_name'];echo "  ".$val_etitle['semister_name'].')';}?>
			</td></tr>
			<?php if(trim($errmsg)!='') echo '<tr><td colspan="2"><span class="errormsg">'.$errmsg.'</span></td></tr>' ?>
			<?php 
				$rowColor='FFFFFF';
				for($i=1; $i<=intval($_GET['questions']); $i++){
					if($i%2==0) $rowColor = '999999';
					else $rowColor = '#FFFFFF';
			?>
				<tr style="background-color:#<?php echo $rowColor; ?>"><td style="vertical-align:top;">Question-<?php echo $i; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<textarea name="question<?php echo $i;?>" id="question<?php echo $i;?>" rows="2" cols="50"></textarea></td></tr>
				<tr style="background-color:#<?php echo $rowColor; ?>"><td>Options</td><td>A:<input type="text" name="op_1_<?php echo $i; ?>" id="op_1_<?php echo $i; ?>"/>&nbsp;&nbsp;&nbsp;B:<input type="text" name="op_2_<?php echo $i; ?>" id="op_2_<?php echo $i; ?>"/>&nbsp;&nbsp;&nbsp;C:<input type="text" name="op_3_<?php echo $i; ?>" id="op_3_<?php echo $i; ?>"/>&nbsp;&nbsp;&nbsp;D:<input type="text" name="op_4_<?php echo $i; ?>" id="op_4_<?php echo $i; ?>"/> &nbsp;&nbsp;&nbsp; Correct Option <select name="correctoption_<?php echo $i; ?>" id="correctoption_<?php echo $i; ?>"> <option>A</option><option>B</option><option>C</option><option>D</option></select></td></tr>
				<tr><td colspan="2"><hr /> </td></tr>
			<?php
				} 
			?>
			<tr><td>&nbsp;</td><td>&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" id="submit"  value="Submit"/></td></tr>
			</table>
		</form>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>