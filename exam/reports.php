

<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/exam.class.php');
include('includes/courses.class.php');
include('includes/reports.class.php');

$exm=new exam;
$crs=new courses;
$rpts=new reports;

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
	$errmsg='Questions added succefully';
}

if(isset($_GET['msg']) && $_GET['msg']=='viewReports'){
	$examid=$_GET['examid'];
	$testid=$_GET['testid'];
			
}


include('includes/header.php');

?>


<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="list">
			<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span><br />'; ?>
			<table cellpadding="0" cellspacing="0">
				<tr><td colspan="2" class="table_title">Report List</td><td colspan="5" class="table_options"></td></tr>
				<tr class="table_header"><td>Exam</td><td>Subject</td><td>Course</td><td>Semister</td><td>End Date</td><td>Test</td><td>Options</td></tr>
				<?php
	
					$arr = $exm->getExamList($_SESSION['userid'],$_SESSION['user_type']);
					if($arr)
					{
						foreach($arr as $val){
						
							$chk_rpt_date=$rpts->checkValidDate($val['exam_id']);
							
							if($chk_rpt_date[0]>0){
																									
								echo "<tr class=\"table_row\"><td>$val[exam_name]</td><td>$val[subject_name]</td><td>$val[course_name]</td><td>$val[semister_name]</td><td>$val[end_date]</td><td>$val[test_name]</td>";
								if(intval($_SESSION['user_type'])==2 || intval($_SESSION['user_type'])==1){
								echo "<td><select name=\"div_$val[exam_id]\" id=\"div_$val[exam_id]\">";
																					
									$arr_div=$crs->getDivList();
									
									if($arr_div){
										foreach($arr_div as $val_div){
											echo '<option value='.$val_div['div_id'].'>'.$val_div['div_name'].'</option>';
										}
									}
									echo "</select>
									<a href=\"javascript:viewReportWindow($val[exam_id],$val[test_id])\" title=\"View Report\"><img src=\"images/report.png\" alt=\"View Report\" style=\"border:0px\";/></a>";
									echo "<a href=\"javascript:printReportWindow($val[exam_id],$val[test_id])\" title=\"Print Report\"><img src=\"images/printer.png\" alt=\"Print Report\" style=\"border:0px\";/></a>";
								}
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