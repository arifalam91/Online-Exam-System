<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/courses.class.php');

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');


include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu"><?php include('includes/leftmenu.php'); ?></td>
	<td>
		<div class="list">
			<table cellpadding="0" cellspacing="0">
			<tr><td colspan="2" class="table_title">Course List</td></tr>
			<tr class="table_header"><td>Course Name</td><td>Options</td></tr>
			<?php
			$course= new courses;
			$arr = $course->getCourseList();
			foreach($arr as $val){
			?>
				<tr class="table_row">
				<td style="vertical-align:top;"><?php echo $val['course_name']; ?></td>
				<td>
					<a href="semisters.php?action=viewsemlist&id=<?php echo $val['course_id']; ?>" title="View Semister List"><img src="images/colors.png" alt="View Semister List" style="border:0px;" /></a>
				</td>
				</tr>
			<?php }	?>
			</table>
		</div>
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>