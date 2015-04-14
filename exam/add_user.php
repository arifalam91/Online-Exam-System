<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/courses.class.php');

$course=new courses;

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');

$userid='';
$usertype='';
$firstname='';
$lastname='';
$email='';
$phoneno='';

$error_flag=false;
$errmsg = '';

$studentDisplay = 'none';
$examsDisplay = 'block';

if(isset($_POST['action']) && $_POST['action']=='adduser'){
	$userid=trim($_POST['userid']);
	$password=trim($_POST['password']);
	$retypassword=trim($_POST['retypepassword']);
	$usertype=trim($_POST['usertype']);
	$phoneno=trim($_POST['phoneno']);
	$studentSem = intval($usertype)==4?$_POST['course_sem']:0;
	$studentRoll = intval($usertype)==4?$_POST['rollno']:0;
	$studentDiv = intval($usertype)==4?$_POST['div']:0;
	$firstname=trim($_POST['firstname']);
	$lastname=trim($_POST['lastname']);
	$email=trim($_POST['email']);
	//echo $studentSem;
	//print_r($_POST);exit;
	//$id=1;
	//print_r($_POST['sub'.$id]);
	if($userid==''){
		$error_flag=true;
		$errmsg='UserId is a mandatory field.';
	}
		if(strlen($userid)<6){
			$error_flag=true;
			$errmsg.='User id must be atleast 6 characters';
		}
			
	if($password!=$retypassword){
		$error_flag=true;
		$errmsg.='your passwords do not match.<br />';
	}
	
	if(!$error_flag){
		if($usr->checkUserIdExists($userid)){
			$error_flag=true;
			$errmsg.='Given user already exists';
		}
	}
	
	if(!$error_flag){
		if(!$usr->addUser($userid,$password,$firstname,$lastname,$email,$phoneno,$studentSem,$studentRoll,$studentDiv,$usertype)){
			$error_flag=true;
			$errmsg='Could not create user.';
		}else{
				
				if($usertype==2){
					$user_id=mysql_insert_id();
					for($i=1;$i<$_POST['var_count'];$i++){
						if(isset($_POST['sub'.$i]))
							$usr->insertFacultySubjects($user_id,$_POST['sub'.$i]);
					}
					
				}
				if($usertype==4){
					$user_id=mysql_insert_id();
					if(isset($_POST['course_sem']))
						$usr->insertStudentSubject($user_id,$studentSem);
				}
				
				
			}header('Location: users.php?msg=useradded');
	}
	
	if(intval($usertype)==4){
		$studentDisplay = 'block';
		$examsDisplay = 'none';
	}elseif(intval($usertype)==3){
		$examsDisplay = 'none';
	}
	
}	
include('includes/header.php');
?>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="leftmenu">
		<?php include('includes/leftmenu.php'); ?>
	</td>
	<td>
		
		<div class="form">
		<form method="post">
		<input type="hidden" name="action" id="action" value="adduser" />
		<table cellpadding="3" cellspacing="0" border="0">
		<tr><td class="table_title" colspan="2">Add User</td></tr>
		<?php if(trim($errmsg)!='') echo '<tr><td colspan="2"><span class="errormsg">'.$errmsg.'</span></td></tr>' ?>
		<tr><td>User ID </td><td><input type="text" name="userid" id="userid" value="<?php echo $userid; ?>" /></td></tr>
		<tr><td>Password</td><td><input type="password" name="password" id="password" /></td></tr>
		<tr><td>Re-Type Password</td><td><input  type="password" name="retypepassword" id="retypepassword" /></td></tr>
		<tr>
			<td>User Type </td>
			<td>
				<select name="usertype" id="usertype" onchange="enableDisableExams(this.value);">
				<option value="2" <?php if(intval($usertype)==2) echo 'selected="selected"'?>>Faculty</option>
				<option value="3" <?php if(intval($usertype)==3) echo 'selected="selected"'?>>Data Entry Operator</option>
				<option value="4" <?php if(intval($usertype)==4) echo 'selected="selected"'?>>Student</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div id="student" style="display:<?php echo $studentDisplay?>;">
					<table cellpadding="5" cellspacing="0" border="0">
						<tr>
							
							<td>Sem: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<select name="course_sem" id="course_sem">
							<?php 
								$i=1;
								$arr_course=$course->getCourseList();
								foreach($arr_course as $val_course){
									$arr_sem=$course->getSemList($val_course['course_id']);
									foreach($arr_sem as $val_sem){
										echo '<option name="sem'.$i.'" id="sem'.$i.'" value="'.$val_sem['sem_id'].'">'.$val_course['course_name'].'('.$val_sem['semister_name'].')</option>';
										$i++;
									}
								}
								
							 ?>
							
							</select>
							</td>
						</tr>
						<tr>
							<td>Roll No:&nbsp;&nbsp;<input type="text" name="rollno" id="rollno"  /></td>
						</tr>
						<tr><td>Div: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="div" id="div">
						
							<?php
							
								$i=1;
								$arr_div=$course->getDivList();
								foreach($arr_div as $val_div){
									echo '<option name="div'.$i.'" id="div'.$i.'" value="'.$val_div['div_id'].'">'.'(Division)'.$val_div['div_name'].'</option>';
									$i++;
								}
							
							?>
						
						</select></td></tr>
						
					</table>
				</div>
				<div id="exams" style="display: <?php echo $examsDisplay; ?>;">
					<table>
							<?php
								
								$i=1;
								$arr=$course->getCourseList();
								foreach($arr as $val){
									//echo $val[course_id];
									$arr_sem=$course->getSemList($val['course_id']);
									foreach($arr_sem as $val_sem){
										$arr_subject=$course->getSubjectList($val_sem['sem_id']);
										if($arr_subject){
											echo "<tr><td class=\"cmheader\">$val[course_name] $val_sem[semister_name]</td></tr>";
											echo '<tr><td style="padding:5px 0px 10px 0px;">';
											foreach($arr_subject as $val_subject){
												echo '<input type="checkbox" name="sub'.$i.'" id="sub'.$i.'" value="'.$val_subject['subject_id'].'"/> '.$val_subject['subject_name'].'&nbsp;&nbsp;&nbsp;&nbsp;';
												if($i%3==0){
													echo '<br />';
												}
												$i++;								
											}
											echo '</td></tr>';
										}
									}
								}
							?>
						<input type="hidden" name="var_count" value="<?php echo $i;?>" />
					</table>
				</div>
			</td>	
		</tr>
		<tr><td>First Name </td><td><input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" /></td></tr>
		<tr><td>Last Name</td><td><input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>"/></td></tr>
		<tr><td>Email</td><td><input type="text" name="email" id="email" value="<?php echo $email; ?>"/></td></tr>
		<tr><td>Phone No</td><td><input type="text" name="phoneno" id="phoneno" value="<?php echo $phoneno; ?>" /></td></tr>
		<tr><td>&nbsp;</td><td><input type="submit" name="submit" id="submit"  value="Submit"/></td></tr>
				
		</table>
		
		</form>
		</div>
				
	</td>
</tr>	
</table>
<br />&nbsp;
<?php include('includes/footer.php'); ?>