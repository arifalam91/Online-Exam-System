<?php
	class user{
		
		private $qry;
		private $res;
		
		//FUNCTION FOR USER LOGIN
		public function loginUser($username, $password){
			
			$this->qry = 'select user_id, user_type_id from user_master where user_name="'.$username.'" and password="'.$password.'" and isactive=1';
			//echo $this->qry;
			//die();
			$this->res = mysql_query($this->qry);
			//echo $this->qry;
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					$row = mysql_fetch_row($this->res);
					$_SESSION['userid'] = $row[0];
					$_SESSION['user_type'] = $row[1];
					$_SESSION['valid'] = true;
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		//FUNCTION TO CHECK SESSION
		public function checkSession(){
			if(isset($_SESSION['valid']) && $_SESSION['valid']==true){
				if(isset($_SESSION['userid']) && intval($_SESSION['userid'])>0)
				return true;
			}
			return false;
		}
		
		//FUNCTION TO GET THE FULLNAME OF LOGIN USER
		public function getUserFullname($id){
			$this->qry = 'select first_name, last_name from user_master where user_id='.$id;
			$this->res = mysql_query($this->qry);
			//echo $this->qry;
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					$row = mysql_fetch_row($this->res);
					return $row[0].' '.$row[1];
				}
			}			
		}
		
		//FUNCTION TO GET THE DETAILS OF ALL USERS
		public function getUserList(){
			$this->qry='select um.user_id,um.first_name,um.last_name,um.email,um.phoneno,um.isactive,ut.user_type_name from user_master um,user_type_master ut where um.user_type_id=ut.user_type_id and um.isdeleted = 0';
			$this->res=mysql_query($this->qry);
			$retArr = array();
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC)){
						array_push($retArr,$rowArr);
											
					}
					return $retArr;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		//FUNCTION TO ACTIVATE THE USER DYNAMICALLY
		public function activateUser($id){
		
			$this->qry='update user_master set isactive=1 where user_id='.$id;
			return mysql_query($this->qry);
		}
		
		//FUNCTION TO DE-ACTIVATE THE USER DYNAMICALLY
		public function deActivateUser($id){
		
			$this->qry='update user_master set isactive=0 where user_id='.$id;
			return mysql_query($this->qry);
		}
		
		//FUNCTION TO DELETE THE USER DYNAMICALLY
		public function deleteUser($id){
		
			$this->qry='update user_master set isdeleted=1,isActive=0 where user_id='.$id;
			return mysql_query($this->qry);
		}
		
		//FUNCTION TO CHECK WHETHER THE GIVEN USER EXISTS OR NOT
		public function checkUserIdExists($username){
			$this->qry = "select count(user_id) from user_master where user_name='".$username."'";
			$this->res=mysql_query($this->qry);
			if($this->res){
				$obj=mysql_fetch_array($this->res);
				return $obj[0];
			}else
				return false;
		}
		
		//FUNCTION TO ADD THE NEW USER
		public function addUser($username,$password,$firstname,$lastname,$email,$phoneno,$studentSem,$studentRoll,$studentDiv,$usertype=4,$enrolment=0){
			//echo $studentSem;
			if($usertype==4)
			{
				$this->qry="insert into div_vs_rollno(div_id,rollno,sem_id) values($studentDiv,$studentRoll,$studentSem)";
				mysql_query($this->qry);
			}
			$this->qry="insert into user_master (user_name,password,first_name,last_name,user_type_id,sem_id,enrolment_number,email,phoneno,rollno,div_id) values('$username','$password','$firstname','$lastname',$usertype,$studentSem,$enrolment,'$email','$phoneno',$studentRoll,$studentDiv)";
			return mysql_query($this->qry);
		}
		
		//FUNCTION TO GET THE DETAILS OF SPECIFIED USER
		public function getUserDetails($user_id){
			$this->qry="select user_name,first_name,last_name,user_type_id,email,phoneno,sem_id,div_id,rollno from user_master where user_id=".$user_id;
			$this->res=mysql_query($this->qry);
			return mysql_fetch_object($this->res);
		}
		
		//FUNCTION TO UPDATE THE DETAILS OF SPECIFIED USER
		public function updateUser($user_id,$password,$firstname,$lastname,$email,$phoneno){
			
			$this->qry="update user_master set ";
			if($password!='') $this->qry .= " password='$password', ";
			$this->qry .= " first_name='$firstname',last_name='$lastname',email='$email',phoneno='$phoneno' where user_id=$user_id";
			//die($this->qry);
			return mysql_query($this->qry);
		}
		
		//FUNCTION TO INSERT THE DATAILS OF FACULTY VERSUS SUBJECT
		public function insertFacultySubjects($userid,$subid){
			$this->qry="insert into faculty_vs_subject(user_id,subject_id)values($userid,$subid)";
			mysql_query($this->qry);
			
		}
		
		//FUNCTION TO DELETE THE SUBJECTS OF PARTICULAR FACULTY BEFORE INSERTING OR UPDATING HIS NEW SUBJECTS
		public function deleteFacultySubjects($userid){
			$this->qry="delete from faculty_vs_subject where user_id=$userid";
			mysql_query($this->qry);		
		}
		
		//FUNCTION TO UPDATE THE SUBJECTS OF FACULTIES
		public function updateFacultySubjects($userid,$subid){
			//$this->qry="select user_id,subject_id from faculty_vs_subject where user_id=$userid and subject_id=$subid";
//			$this->res=mysql_query($this->qry);
//			if(!$this->res){
				$this->qry="insert into faculty_vs_subject(user_id,subject_id)values($userid,$subid)";
				return mysql_query($this->qry);
			//}
		}
		
		//FUNCTION TO GET THE DETAILS OF FACULTY SUBJECTS
		public function getFacultySubjectDetails($userid){
			$this->qry="select subject_id from faculty_vs_subject where user_id=$userid";
			$this->res=mysql_query($this->qry);
			$retArr = array();
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC)){
						array_push($retArr,$rowArr['subject_id']);
											
					}
					return $retArr;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		//FUNCTION TO INSERT THE STUDENT SEMISTER AGAINST HIS USERID IN FACULTY_VS_SUBJECT TABLE
		public function insertStudentSubject($userid,$sem){
			$this->qry="select sm.subject_id,cm.sem_id from subject_master sm,semister_master cm where sm.sem_id=cm.sem_id and cm.sem_id=$sem";
			$this->res=mysql_query($this->qry);
			while($arr = mysql_fetch_array($this->res,MYSQL_ASSOC)){
				mysql_query("insert into faculty_vs_subject(user_id,subject_id)values($userid,$val[subject_id])");
			}
		}
		
		public function getStudentList(){
			$this->qry='SELECT um.user_id, um.rollno, um.first_name, um.last_name ,sm.semister_name,cm.course_name,dm.div_name
						FROM user_master um ,semister_master sm,course_master cm,div_master dm
						WHERE um.sem_id=sm.sem_id and sm.course_id=cm.course_id and um.div_id=dm.div_id and um.user_type_id =4 and um.isActive=1 and um.isDeleted=0 order by sm.semister_name,dm.div_name,um.rollno';

			$this->res=mysql_query($this->qry);
			$retArr = array();
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC)){
						array_push($retArr,$rowArr);
											
					}
					return $retArr;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		public function checkExistance($studentDiv,$studentRoll,$studentSem){
			$this->qry="select div_id,rollno from div_vs_rollno where div_id=$studentDiv and rollno=$studentRoll and sem_id=$studentSem";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		
		public function editStudent($userid){
			
			$this->qry="select user_name,rollno,div_id,first_name,last_name,email,phoneno,sem_id from user_master where user_id=$userid";
			$this->res=mysql_query($this->qry);
			
			$retArr = array();
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC)){
						array_push($retArr,$rowArr);
											
					}
					return $retArr;
				}else{
					return false;
				}
			}else{
				return false;
			}

			
		}
		
		
		public function getStudentSemDivision($studentSem,$studentDiv){
			//echo $studentDiv;
			$this->qry="select dm.div_name,sm.semister_name from div_master dm,semister_master sm where dm.div_id=$studentDiv and sm.sem_id=$studentSem";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					$did=mysql_fetch_row($this->res);
					return $did;
				}
			}
		}
		
		
		public function deleteCurrentSemDivision($userid){
			$this->qry="delete from div_vs_rollno where div_id=(select div_id from user_master where user_id=$userid) and rollno=(select rollno from user_master where user_id=$userid) and sem_id=(select sem_id from user_master where user_id=$userid)";
			return mysql_query($this->qry);
			
		}
		
		public function deleteStudent($userid){
			$this->qry="delete from user_master where user_id=$userid";
			mysql_query($this->qry);
		}
		
		public function updatePassword($userid,$fname,$lname,$oldpassword,$newpassword){
		
			$this->qry="update user_master set password='$newpassword' where user_name='$userid' and first_name='$fname' and last_name='$lname' and password='$oldpassword'";
			return mysql_query($this->qry);
		}
		
		public function checkUserExistance($username,$fname,$lname,$email){
			$this->qry="select user_id from user_master where user_name='$username' and first_name='$fname' and last_name='$lname' and email='$email'";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					return true;
				}
			}
			
		}
		
		
		public function getExamsByUserId($username,$testid){
			$this->qry="select exam_id,exam_name from exam_master 
						where exam_id in(select exam_id from exam_vs_student
						where student_id=(select user_id from user_master where user_name='$username'))
						and test_id=$testid";
			$this->res=mysql_query($this->qry);
			
			$retArr = array();
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC)){
						array_push($retArr,$rowArr);
											
					}
					return $retArr;
				}else{
					return false;
				}
			}else{
				return false;
			}
			
		}
		
		public function checkExamTestExists($examid,$testid){
			echo $examid;
			echo $testid;
			$this->qry="select * from exam_master where exam_id=$examid and test_id=$testid";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					return true;
				}
			}
		}
		
		
	}
?>