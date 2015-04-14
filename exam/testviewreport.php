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
<link type="text/css" href="includes/stylesheet.css" rel="stylesheet" />
</head>
<body style="background-color:#FFFFFF;">
<table cellpadding="10" cellspacing="0" border="0">
	<tr class="reporttitle"><td>Course</td><td>Semister</td><td>Div</td><td>Test</td><td>Subject</td><td>Subject Teacher</td><td>Date Of Exam</td><td>Max. Marks</td><td>Min. Passing Marks</td></tr>
		
	<tr><td><?php echo $arr_rpt[9];?></td><td><?php echo $arr_rpt[4];?></td><td><?php echo $arr_div[0];?></td><td><?php echo $arr_rpt[3];?></td><td><?php echo $arr_rpt[2];?></td><td><?php echo $arr_rpt[7];?></td><td><?php echo $arr_rpt[8];?></td><td><?php echo $arr_rpt[5];?></td><td><?php echo $arr_rpt[6];?></td></tr>
			
		

</table>

  <br /> <br />
	
<table cellpadding="5" cellspacing="5" border="0">
		<tr>
		<td style="vertical-align:top;">
		<table cellpadding="5" cellspacing="0" border="1">
		<tr><td>Roll No</td><td>Marks</td><td>Pass/Fail</td></tr><!--<td>Roll No</td><td>Marks</td></tr>-->
		<?php
			
			$arr_marks1to30=$rpts->getMarkSheet1To30($examid,$divid);
			
			
			if($arr_marks1to30){
				foreach($arr_marks1to30 as $val_marks){
					if($val_marks['score']>=$arr_rpt[6]){
						$str='Pass';
					}else{
						$str='Fail';
					}
					echo '<tr><td>'.$val_marks['rollno'].'</td><td>'.$val_marks['score'].'</td><td>'.$str.'</td>';
				}
			}
			?>
			</table>
			</td>
				
			
			<td style="vertical-align:top;">
			<table cellspacing="0" cellpadding="5" border="1">
			<tr><td>Roll No</td><td>Marks</td><td>Pass/Fail</td></tr>
			<?php
			
			$arr_marks31to60=$rpts->getMarkSheet31To60($examid,$divid);
			if($arr_marks31to60){
				foreach($arr_marks31to60 as $val_marks){
					if($val_marks['score']>=$arr_rpt[6]){
						$str='Pass';
					}else{
						$str='Fail';
					}
					echo '<td>'.$val_marks['rollno'].'</td><td>'.$val_marks['score'].'</td><td>'.$str.'</td></tr>';
				}
			}
					
		
		?>
			</table>
			</td>
			</tr>
			
		
</table>
	
	<br /><br /><br /><br />
<table>
	
	<?php 
	
		//$arr_rpt_detl=$rpts->getReportDetails($examid,$arr_rpt[9],$arr_rpt[4],$arr_div[0],$arr_rpt[3],$arr_rpt[2]);
	
	?>
	<!--<tr class="reporttitle"><td width="20%">No. Of Students Appeared </td><td width="20%">No. Of Students Passed</td><td width="20%">No. Of Students Failed</td><td width="20%">Percentage Of Passing</td></tr>-->
		
</table>
		<br /><br /><br /><br />

<table style="margin-left:70px;">
	
	
	<tr class="reporttitle"><td width="50%">Subject Teacher</td><td width="40%">HOD</td><td width="10%">Director</td></tr>
	
</table>


</body>
</html>