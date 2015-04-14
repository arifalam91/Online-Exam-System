<strong>Menu List</strong><br />
<!-- DISPLAYING MENUES FOR ONLY ADMIN USER-->
<?php if(intval($_SESSION['user_type'])==1){ ?>
	<table cellpadding="2" cellspacing="2">
	<tr><td style="width:25px;"><img src="images/users2.png" border="0" /></td><td><a href="users.php">Users</a></td></tr>
	<tr><td><img src="images/books.png" border="0" /></td><td><a href="courses.php">Courses</a></td></tr>
	<tr><td><img src="images/graduate.png" border="0" /></td><td><a href="students.php">Students</a></td></tr>
	<tr><td><img src="images/graphics-tablet.png" border="0" /></td><td><a href="exams.php">Exams</a></td></tr>
	<tr><td><img src="images/chart.png" border="0" /></td><td><a href="reports.php">Reports</a></td></tr>
	<tr><td><img src="images/auction_hammer.png" border="0" /></td><td><a href="examcontrol.php">Exam Control</a></td></tr>
	</table>
<?php } ?>
<?php if(intval($_SESSION['user_type'])==2){ ?>
	<table cellpadding="2" cellspacing="2">
	<!--<tr><td><img src="images/books.png" border="0" /></td><td><a href="courses.php">Courses</a></td></tr>
	<tr><td><img src="images/graduate.png" border="0" /></td><td><a href="students.php">Students</a></td></tr>-->
	<tr><td><img src="images/tablet.png" border="0" /></td><td><a href="exams.php">Exams</a></td></tr>
	<tr><td><img src="images/chart.png" border="0" /></td><td><a href="reports.php">Reports</a></td></tr>
	</table>
<?php } ?>
<?php if(intval($_SESSION['user_type'])==3){ ?>
	<table cellpadding="2" cellspacing="2">
	<tr><td><img src="images/graduate.png" border="0" /></td><td><a href="students.php">Students</a></td></tr>
	</table>
<?php } ?>
<?php if(intval($_SESSION['user_type'])==4){ ?>
	<table cellpadding="2" cellspacing="2">
	<tr><td><img src="images/tablet.png" border="0" /></td><td><a href="exams.php">Exams</a></td></tr>
	</table>
<?php } ?>