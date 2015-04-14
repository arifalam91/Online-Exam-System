<?php
include('includes/config.php');
include('includes/user.class.php');

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');


include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu"><?php include('includes/leftmenu.php'); ?></td>
	<td>
	
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>