<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/courses.class.php');

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');

$course =  new courses;

include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu"><?php include('includes/leftmenu.php'); ?></td>
	<td>
		<div class="list">
			<table cellpadding="0" cellspacing="0">
			<tr><td colspan="2" class="table_title">Subject List for <?php echo $course->getCourseNameFromSemId($_GET['id']).' '.$course->getSemisterName($_GET['id']); ?>.</td></tr>
			<tr class="table_header"><td>Subject Name</td><td>Subject Code</td></tr>
			<?php
			$arr = $course->getSubjectList($_GET['id']);
			if($arr){
				foreach($arr as $val){
				?>
					<tr class="table_row">
					<td style="vertical-align:top;"><?php echo $val['subject_name']; ?></td>
					<td><?php echo $val['subject_code']; ?></td>
					</tr>
			<?php
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