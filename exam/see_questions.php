<?php
include('includes/config.php');
include('includes/reports.class.php');
include('includes/courses.class.php');
include('includes/exam.class.php');

$rpts=new reports;
$crs=new courses;
$exm=new exam;

if($_GET && $_GET['msg']=='seequestions'){

	$examid=$_GET['eid'];
	$testid=$_GET['tid'];
	$arr_ques=$exm->getQuestions($examid);
	$arr_examdtls=$exm->getExamDetails($examid);
	
	$examname=$arr_examdtls[0];
	$subjectname=$arr_examdtls[4];
	$examdate=$arr_examdtls[1];
	$testname=$arr_examdtls[3];
	$facultyname=$arr_examdtls[2];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Report Page</title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<body style="background-color:#FFFFFF;">
	<table cellpadding="10" cellspacing="0" border="0">
		<tr class="reporttitle"><td>Exam Name</td><td>Subject Name</td><td>Exam Date</td><td>Skilltest Name</td><td>Faculty Name</td></tr>
		<tr><td><?php echo $examname; ?></td><td><?php echo $subjectname; ?></td><td><?php echo $examdate; ?></td><td><?php echo $testname; ?></td><td><?php echo $facultyname; ?></td></tr>
	</table><br /><br />
	
	<table cellpadding="5" cellspacing="0" border="1">
		<tr><td><strong>Sr.No.</strong></td><td><strong>Question</strong></td><td><strong>A</strong></td><td><strong>B</strong></td><td><strong>C</strong></td><td><strong>D</strong></td><td><strong>Correct Answer</strong></td></tr>
		<?php 
		$count=1;
		if($arr_ques)
		{
			foreach($arr_ques as $val_ques)
			{
				echo 	'<tr><td>'.$count.'</td><td>'.$val_ques['question'].'</td><td>'.$val_ques['option1'].'</td><td>'.$val_ques['option2'].'</td><td>'.$val_ques['option3'].'</td><td>'.$val_ques['option4'].'</td><td>'.$val_ques['correct'].'</td></tr>';
				$count++;
			}		
		}
		?>
	
	</table><br />
	
	<form>
		<input type="button" id="Print" name="Print" value="Print Report" onclick="window.print();" />
	</form>
	
</body>
</html>