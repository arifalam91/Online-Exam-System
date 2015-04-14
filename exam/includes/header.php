<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Online Examination</title>
	<!-- LINK THE EXTERNAL STYLESHEET-->
	<link type="text/css" rel="stylesheet" media="all"  href="includes/stylesheet.css"/>
	<!-- LINK THE EXTERNAL JAVASCRIPT-->
	<script language="javascript" src="includes/javascript.js"></script>
</head>
<body <?php if(isset($_GET['msg']) && $_GET['msg']=='startexam')echo $bodyFunc;?>>
<!-- MAIN BODY TABLE-->
<table cellpadding="5" cellspacing="0" class="body_table">
<tr>
	<td class="body_header">
		<div class="topmenu">
		<?php 
			$usr = new user;
			if($usr->checkSession()){
		?>
		<strong>Welcome : <?php echo $usr->getUserFullname($_SESSION['userid']); ?></strong> | <a href="home.php">Home</a> | <a href="logout.php">Logout</a>
		<?php } ?>
		</div>
		
		<div align="center" style="color:#990000;"><h2> Online Examination System </h2></div>
	</td>
</tr>
<tr><td>
