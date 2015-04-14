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
			<tr><td colspan="2" class="table_title">Semister List for <?php echo $course->getCourseName($_GET['id']); ?> course.</td></tr>
			<tr class="table_header"><td>Semister Name</td><td>Options</td></tr>
			<?php
			$arr = $course->getSemList($_GET['id']);
			foreach($arr as $val){
			?>
				<tr class="table_row">
				<td style="vertical-align:top;"><?php echo $val['semister_name']; ?></td>
				<td>
					<a href="subjects.php?action=viewsubjectlist&id=<?php echo $val['sem_id']; ?>" title="View Subject List"><img src="images/colors.png" alt="View Subject List" style="border:0px;" /></a>
				</td>
				</tr>
			<?php } ?>
			</table>
		</div>
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>