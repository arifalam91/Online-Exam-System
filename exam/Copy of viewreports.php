<?php
include('includes/config.php');
include('includes/reports.class.php');
include('includes/courses.class.php');

$rpts=new reports;
$crs=new courses;

if($_GET && $_GET['msg']=='viewreport'){

	$examid=$_GET['eid'];
	$testid=$_GET['tid'];
	$divid=$_GET['div'];
	$arr_rpt=$rpts->getReport($examid,$testid);
	$arr_div=$crs->getDivById($divid);
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Report Page</title>
</head>
<body>
<table cellpadding="10" cellspacing="0" border="0">
	<tr>
	
		<td><strong>Semister:</strong><?php echo $arr_rpt[4];?></td>
		<td><strong>Div:</strong><?php echo $arr_div[0]; ?></td>
		<td><strong>Test:</strong><?php echo $arr_rpt[3];?></td>
	</tr>
	
	<tr>
		<td><strong>Subject:</strong><?php echo $arr_rpt[2];?></span></td>	
		<td><strong>Subject Teacher:</strong><?php echo $arr_rpt[7];?></span></td>
		<td><strong>Date Of Exam:</strong><?php echo $arr_rpt[8];?></td>
	</tr>
	
	<tr>
		<td><strong>Max. Marks:</strong><?php echo $arr_rpt[5];?></span></td>	
		<td><strong>Min. Passing Marks:</strong><?php echo $arr_rpt[6];?></span></td>
		
	</tr>

<table cellpadding="10" cellspacing="0" border="1">
	<tr><td>Roll No</td><td>Marks</td><!--<td>Roll No</td><td>Marks</td></tr>-->
	<?php
		
		$arr_marks=$rpts->getMarkSheet($examid,$divid);
		
		if($arr_marks){
			foreach($arr_marks as $val_marks){
				echo '<tr><td>'.$val_marks['rollno'].'</td><td>'.$val_marks['score'].'</td></tr>';
			}
		}
	
	?>
	
</table>

<br /><br /><br /><br />
<table>

	<tr><td width="50%">Subject Teacher</td><td width="40%">HOD</td><td width="10%">Director</td></tr>

</table>

</table>
</body>
</html>