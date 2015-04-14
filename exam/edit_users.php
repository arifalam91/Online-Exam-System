<?php
include('includes/config.php');
include('includes/user.class.php');
include('includes/courses.class.php');

$course=new courses;

// CHECK SESSION VALIDITY AND REDIRECT THE USER
$usr = new user;
if(!$usr->checkSession()) header('Location: index.php?msg=login');


$error_flag=false;
$errmsg = '';

$studentDisplay = 'none';
$examDisplay = 'block';

if(isset($_POST['action']) && $_POST['action']=='updateuser'){

	$user_id=trim($_POST['uid']);
	$password=trim($_POST['password']);
	$retypassword=trim($_POST['retypepassword']);
	$usertype=trim($_POST['usertype']);
	$firstname=trim($_POST['firstname']);
	$lastname=trim($_POST['lastname']);
	$email=trim($_POST['email']);
	$phoneno=trim($_POST['phoneno']);
	$sem_id=intval($usertype)==4?trim($_POST['course_sem']):0;
	$div_id=intval($usertype)==4?trim($_POST['div']):0;
	$roll_no=intval($usertype)==4?trim($_POST['rollno']):0;
	
	//if(strlen($user_id)<6){
//		$error_flag=true;
//		$errmsg.='User id must be atleast 6 characters';
//	}
		
	if(!$error_flag){
		if($usr->checkUserIdExists($user_id)){
			$error_flag=true;
			$errmsg.='Given user already exists';
		}
	}
		
	if($password!='' && $password!=$retypassword){
		$error_flag=true;
		$errmsg.='your passwords do not match.<br />';
	}
	
	if(!$error_flag){
		if(!$usr->updateUser($user_id,$password,$firstname,$lastname,$email,$phoneno,$usertype,$sem_id,$div_id,$roll_no)){
			$error_flag=true;
			$errmsg='Could not update user details.';
		}
		else
		{
			if($usertype==2)
			{
				$user_id=$_POST['uid'];
				$usr->deleteFacultySubjects($user_id);
				for($i=1;$i<$_POST['var_count'];$i++){
					if(isset($_POST['sub'.$i])) $usr->updateFacultySubjects($user_id,$_POST['sub'.$i]);
				}
			}
			header('Location: users.php?msg=updated');
		}
	}	
			
			
	if(intval($usertype)==4){
		$studentDisplay = 'block';
		$examDisplay = 'none';
	}elseif(intval($usertype)==3){
		$examDisplay = 'none';
	}
}

if(isset($_GET['id']) && intval($_GET['id'])>0){

	
	$ud=$usr->getUserDetails($_GET['id']);
		
	$user_id=$_GET['id'];
	$userid=$ud->user_name;
	$usertype=$ud->user_type_id;
	$firstname=$ud->first_name;
	$lastname=$ud->last_name;
	$email=$ud->email;
	$phoneno=$ud->phoneno;
	$sem_id=$ud->sem_id;
	$divid=$ud->div_id;
	$rollno=$ud->rollno;
	
	//if($user_id==2){
//		$sd=$usr->getFacultySubjectDetails($user_id);
//	}

	if($errmsg=='') $errmsg='Leave the password field blank if you do not wish to change.';

	$studentDisplay = 'none';
	$examsDisplay = 'block';

	/*	
		
	if(!$error_flag){
		if(!$usr->addUser($userid,$password,$firstname,$lastname,$email,$phoneno,$usertype)){
			$error_flag=true;
			$errmsg='Could not create user.';
		}else{
			header('Location: users.php?msg=useradded');
		}
	}
	*/
	
	if(intval($usertype)==4){
		$examsDisplay = 'none';
		$studentDisplay = 'block';
	}elseif(intval($usertype)==3){
		$examsDisplay = 'none';
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
		<input type="hidden" name="action" id="action" value="updateuser" />
		<input type="hidden" name="uid" id="uid" value="<?php echo $user_id ?>" />
		<table cellpadding="3" cellspacing="0">
		<tr><td class="table_title" colspan="2">Update User</td></tr>
		<?php if(trim($errmsg)!='') echo '<tr><td colspan="2"><span class="errormsg">'.$errmsg.'</span></td></tr>' ?>
		<tr><td>User ID </td><td><input type="text" name="userid" id="userid" value="<?php echo $userid; ?>" readonly="readonly" style="background-color:#CCCCCC;" /></td></tr>
		<tr><td>Password</td><td><input type="password" name="password" id="password" /></td></tr>
		<tr><td>Re-Type Password</td><td><input  type="password" name="retypepassword" id="retypepassword" /></td></tr>
		<tr>
			<td>User Type </td>
			<td>
				<select type="text" name="usertype" id="usertype" onchange="enableDisableExams(this.value)";>
				<option value="2" <?php if(intval($usertype)==2) echo 'selected="selected"'; else echo 'disabled="disabled"';?>>Faculty</option>
				<option value="3" <?php if(intval($usertype)==3) echo 'selected="selected"'; else echo 'disabled="disabled"';?>>Data Entry Operator</option>
				<option value="4" <?php if(intval($usertype)==4) echo 'selected="selected"'; else echo 'disabled="disabled"';?>>Student</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<div id="student" style="display:<?php echo $studentDisplay?>;">
					Sem:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="course_sem" id="course_sem" disabled="disabled">
					<?php 
						$i=1;
						$arr_course=$course->getCourseList();
						foreach($arr_course as $val_course){
							$arr_sem=$course->getSemList($val_course['course_id']);
							foreach($arr_sem as $val_sem){
								echo '<option name="sem'.$i.'" id="sem'.$i.'" value="'.$val_sem['sem_id'].'" ';
								if($val_sem['sem_id']==$sem_id) echo 'selected="selected"';
								echo '>'.$val_course['course_name'].'('.$val_sem['semister_name'].')</option>';
								$i++;
							}
						}
						
					 ?>
					</select><br /><br />
					Roll No:&nbsp;<input type="text" name="rollno" id="rollno" value="<?php echo $rollno; ?>" disabled="disabled" /><br /><br />
					Div:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select name="div" id="div" disabled="disabled">
							
							<?php 
								$arr_div=$course->getDivList();
								foreach($arr_div as $val_div){
									$selDiv=(intval($val_div['div_id'])==$divid)?'selected="selected"':'';
									echo '<option value="'.$val_div['div_id'].'"'.$selDiv.'>'.$val_div['div_name'].'</option>';
								}
							?>
						</select>
				</div>
				<div id="exams" style="display: <?php echo $examsDisplay; ?>;">
					<table>
							<?php
								
								$i=1;
								$faculty_subjects=$usr->getFacultySubjectDetails($_GET['id']);
								if($faculty_subjects)
								{
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
													echo '<input type="checkbox" name="sub'.$i.'" id="sub'.$i.'" value="'.$val_subject['subject_id'].'"';
													if(array_search($val_subject['subject_id'],$faculty_subjects)>-1) echo ' checked="checked" ';
													echo '" /> '.$val_subject['subject_name'].'&nbsp;&nbsp;&nbsp;&nbsp;';
													if($i%3==0){
														echo '<br />';
													}
													$i++;								
												}
												echo '</td></tr>';
											}
										}
									}
								}else
								{
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
													echo '<input type="checkbox" name="sub'.$i.'" id="sub'.$i.'" value="'.$val_subject['subject_id'].'"';
													echo '" /> '.$val_subject['subject_name'].'&nbsp;&nbsp;&nbsp;&nbsp;';
													if($i%3==0){
														echo '<br />';
													}
													$i++;								
												}
												echo '</td></tr>';
											}
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