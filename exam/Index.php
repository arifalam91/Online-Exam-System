<?php

include('includes/config.php');
include('includes/user.class.php');

$usr=new user;

if($usr->checkSession()) header('Location: home.php');


//ERROR MESSAGE CODE
$errmsg = '';
if(isset($_GET['msg']) && $_GET['msg']=='login') $errmsg = 'You have logged out or the session has expired.';
if(isset($_GET['msg']) && $_GET['msg']=='logout') $errmsg = 'You have successfully logged out.';
if(isset($_GET['msg']) && $_GET['msg']=='changedpassword') $errmsg = 'Password changed successfully.';


//LOGIN CODE
//THIS IS A CODE TO CHECK THE TYPE OF HIDDEN INPUT TYPE. IN SHORT FROM WHICH FORM THE PAGE IS BEING CALLED.
if($_POST && isset($_POST['action'])){
	if($_POST['action'] == 'loginuser'){
		$userid = trim($_POST['username']);
		$password = trim($_POST['password']);
		$usr = new user;
		if($usr->loginUser($userid, $password)){
			header('Location: home.php');
		}else{
			$errmsg = 'Wrong userid or password. Please try again.';
		}
	}
}

include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0" border="0">
	
	<tr>
	<td>
	
		<h2> Exam Login </h2>
		<?php if(trim($errmsg)!='') echo '<span class="errormsg">'.$errmsg.'</span>' ?>
		<form method="post">
		<input type="hidden" name="action" id="action" value="loginuser" />
		<table cellpadding="3" cellspacing="0">
		<tr>
			<td>User ID</td>
			<td><input type="text" maxlength="20" name="username" id="username"/></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" maxlength="20" name="password" id="password" /></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" id="login" name="login" value="Login" style="background-color:white;" /></td>
		</tr>
		<tr>
			<!--<td colspan="2"><a class="topmenu" href="recoverpassword.php">Forgot Password? Click here to retrieve.</a></td>-->
		</tr>
		</table>
		</form>
	
	</td>
	
	<td style="vertical-align:top;">

		<div style="margin-left:250px;">
			<p style="color:red; font-size:14px; font-family:'Times New Roman', Times, serif;">NOTE: Regarding any query please contact administrator of this system.</p>
		</div>

	</td>
	
</table>
<br />&nbsp;
<?php
include('includes/footer.php');
?>