<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/courses.class.php');

$course=new courses;

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');

//$userid='';
//$password='';
//$retypassword='';
//$usertype='';
//$phoneno='';
//$studentSem ='';
//$studentRoll='';
//$studentDiv='';
//$firstname='';
//$lastname='';
//$email='';

$error_flag=false;
$errmsg = '';


if($_GET && $_GET['msg']=='editstudent'){
	
	
	$user_id=$_GET['id'];
	
	
		$arr=$usr->editStudent($user_id);
		
		if($arr){
			foreach($arr as $val){
				$uname=$val['user_name'];
				$rno=$val['rollno'];
				$divid=$val['div_id'];
				$fname=$val['first_name'];
				$lname=$val['last_name'];
				$email=$val['email'];
				$pno=$val['phoneno'];
				$semid=$val['sem_id'];
			}
		}
		
		$errmsg="Leave the password field blank if you do not wish to change.";
		
}


if(isset($_POST['action']) && $_POST['action']=='editstudent'){
	
	$userid=trim($_POST['uid']);
	$password=trim($_POST['password']);
	$retypassword=trim($_POST['retypepassword']);
	$usertype=trim($_POST['usertype']);
	$phoneno=trim($_POST['phoneno']);
	//$studentSem = $_POST['course_sem'];
	//$studentRoll=$_POST['rollno'];
	//$studentDiv=$_POST['div'];
	$firstname=trim($_POST['firstname']);
	$lastname=trim($_POST['lastname']);
	$email=trim($_POST['email']);
	
	echo $userid;
	
	if($password!=$retypassword){
		$error_flag=true;
		$errmsg.='your passwords do not match.<br />';
	}
	
	if(!$error_flag){
				
			

			if(!$usr->updateUser($userid,$password,$firstname,$lastname,$email,$phoneno,$usertype)){
					$error_flag=true;
					$errmsg='Could not create user.';
			}else{
						if($usertype==4){
							$user_id=mysql_insert_id();
							if(isset($_POST['course_sem']))
								$usr->insertStudentSubject($user_id,$studentSem);
						}
				header('Location: students.php?msg=updated');				
			 }
		
	}
}	
include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="form">
		<form method="post">
		<input type="hidden" name="action" id="action" value="editstudent" />
		<input type="hidden" name="uid" id="uid" value="<?php echo $user_id; ?>" />
		<table cellpadding="3" cellspacing="0">
		<tr><td class="table_title" colspan="2">Edit Student</td></tr>
		<?php if(trim($errmsg)!='') echo '<tr><td colspan="2"><span class="errormsg">'.$errmsg.'</span></td></tr>' ?>
		<tr><td>User ID </td><td><input type="text" name="userid" id="userid" value="<?php echo $uname; ?>" readonly="readonly" style="background-color:#CCCCCC;"/></td></tr>
		<tr><td>Password</td><td><input type="password" name="password" id="password" /></td></tr>
		<tr><td>Re-Type Password</td><td><input  type="password" name="retypepassword" id="retypepassword" /></td></tr>
			<tr>
			<td>User Type </td>
			<td>
				<select name="usertype" id="usertype">
					<option value="4">Student</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div id="student">
					<table cellpadding="5" cellspacing="0" border="0">
						<tr>
							<td>Sem: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<select name="course_sem" id="course_sem" disabled="disabled">
							<?php 
								$i=1;
								$arr_course=$course->getCourseList();
								foreach($arr_course as $val_course){
									$arr_sem=$course->getSemList($val_course['course_id']);
									//echo $semid;
									foreach($arr_sem as $val_sem){
										$selVar = intval($val_sem['sem_id'])==$semid?'selected="seleted"':'';
										echo '<option name="sem'.$i.'" id="sem'.$i.'" value="'.$val_sem['sem_id'].'" '.$selVar.'>'.$val_course['course_name'].'('.$val_sem['semister_name'].')</option>';
										$i++;
									}
								}
								
							 ?>
							
							</select>
							</td>
						</tr>
						<tr>
							<td>Roll No:&nbsp;&nbsp;<input type="text" name="rollno" id="rollno"  value="<?php echo $rno; ?>" disabled="disabled"/></td>
						</tr>
						<tr><td>Div: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<select name="div" id="div" disabled="disabled">
							
								<?php
								
									$i=1;
									$arr_div=$course->getDivList();
									foreach($arr_div as $val_div){
										$selDiv=intval($val_div['div_id']==$divid)?'selected="selected"':'';
										echo '<option name="div'.$i.'" id="div'.$i.'" value="'.$val_div['div_id'].'"'.$selDiv.'>'.'(Division)'.$val_div['div_name'].'</option>';
										$i++;
									}
								
								?>
							
							</select>
						</td></tr>
						
					</table>
				</div>
			</td>	
		</tr>
		<tr><td>First Name </td><td><input type="text" name="firstname" id="firstname" value="<?php echo $fname; ?>" /></td></tr>
		<tr><td>Last Name</td><td><input type="text" name="lastname" id="lastname" value="<?php echo $lname; ?>"/></td></tr>
		<tr><td>Email</td><td><input type="text" name="email" id="email" value="<?php echo $email; ?>"/></td></tr>
		<tr><td>Phone No</td><td><input type="text" name="phoneno" id="phoneno" value="<?php echo $pno; ?>" /></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit"  value="Submit"/></td></tr>
				
		</table>
		
		</form>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>