<?php
include('includes/config.php');
include('includes/user.class.php');


$userid='';
$firstname='';
$lastname='';
$email='';
$error_flag=false;
$errmsg = '';

$usr=new user;

if(isset($_GET['msg']) && $_GET['msg']=='usernotexists'){
	$error_flag=true;
	$errmsg='Given user does not exists';
}

if(isset($_POST['action']) && $_POST['action']=='adduser'){
	$userid=trim($_POST['userid']);
	$firstname=trim($_POST['firstname']);
	$lastname=trim($_POST['lastname']);
	$email=trim($_POST['email']);
	$oldpassword=trim($_POST['oldpassword']);
	$newpassword=trim($_POST['newpassword']);
	
	if($firstname=='' || $lastname=='' || $userid=='' and $email==''){
		$error_flag=true;
		$errmsg='All fields are mandatory';
	}
	
	if($userid==''){
		$error_flag=true;
		$errmsg='UserId is a mandatory field.';
	}
	
	if(strlen($userid)<6){
		$error_flag=true;
		$errmsg.='User id must be atleast 6 characters';
	}
			
	
	
	if(!$error_flag){
		if($usr->checkUserExistance($userid,$firstname,$lastname,$email)){
			
			if(!$usr->updatePassword($userid,$firstname,$lastname,$oldpassword,$newpassword)){
				$errmsg='Error changing password';
			}else{
				
				header('Location: Index.php?msg=changedpassword');
			}
			
		}else{
			
				header('Location: recoverpassword.php?msg=usernotexists');
			
		}
	}
	
}
	
include('includes/header.php');
?>

<table cellpadding="0" cellspacing="0" border="0">
<tr>
	
	<td>
		
		<div class="form">
		<form method="post">
		<input type="hidden" name="action" id="action" value="adduser" />
		<table cellpadding="3" cellspacing="0" border="0">
		
			<tr><td class="table_title" colspan="2">Recover Password</td></tr>
			<tr><td colspan="2" style="color:#990000;">Forgot Password?? Enter following details to set new password</td></tr>
			<?php if(trim($errmsg)!='') echo '<tr><td colspan="2"><span class="errormsg">'.$errmsg.'</span></td></tr>' ?>
			<tr><td>User ID </td><td><input type="text" name="userid" id="userid" value="<?php echo $userid; ?>" /></td></tr>
			<tr><td>First Name </td><td><input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" /></td></tr>
			<tr><td>Last Name</td><td><input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>"/></td></tr>
			<tr><td>Email</td><td><input type="text" name="email" id="email" value="<?php echo $email; ?>"/></td></tr>
			<tr><td>Old Password</td><td><input type="password" name="oldpassword" id="oldpassword" /></td></tr>
			<tr><td>New Password</td><td><input  type="password" name="newpassword" id="newpassword" /></td></tr>
			<tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit"  value="Submit"/></td></tr>
				
		</table>
		
		</form>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>