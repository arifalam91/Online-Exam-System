<?php

	class exam{
		private $qry;
		private $res;
		
		//FUNCTION TO GET ALLOTED SUBJECTS FOR PARTICULAR USER
		public function getSubjectsForExam($id,$type){
			$this->qry="select sum.subject_id,sum.subject_name,sm.semister_name,cm.course_name 
						from subject_master sum,semister_master sm,course_master cm 
						where sum.sem_id=sm.sem_id and sm.course_id=cm.course_id ";
						if(intval($type)!=1) $this->qry.=" and sum.subject_id in (select subject_id from faculty_vs_subject where user_id=$id)";

			$this->res=mysql_query($this->qry);
			
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		//FUNCTION TO ADD THE DETAILS OF NEW EXAM IN EXAM_MASTER
		public function addExam($examname,$subjectid,$userid,$enddate,$rules,$time,$noofques,$maxmarks,$minmarks,$mca,$mwa,$skilltest){
			$this->qry="insert into subject_vs_skilltest(test_id,subject_id)values($skilltest,$subjectid)";
			mysql_query($this->qry);
			$this->qry="insert into exam_master(subject_id,exam_name,exam_rules,user_id,end_date,time,no_of_ques,max_marks,min_marks,marks_correct,marks_wrong,test_id)values($subjectid,'$examname','$rules',$userid,'$enddate','$time',$noofques,$maxmarks,$minmarks,$mca,$mwa,$skilltest)";
			return mysql_query($this->qry);
		}
		
		//FUNCTION TO GET THE COURSE NAME,SEMISTER NAME,SUBJECT NAME FOR PARTICULAR EXAM
		public function getExamCourseSem($id){
			$this->qry="SELECT em.exam_id, sum.subject_id, sum.subject_name, sm.semister_name, cm.course_name,em.max_marks,em.min_marks FROM exam_master em, subject_master sum, semister_master sm, course_master cm
						WHERE em.subject_id = sum.subject_id AND sum.sem_id = sm.sem_id	AND sm.course_id = cm.course_id AND exam_id =$id";
			$this->res=mysql_query($this->qry);
			
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		
		//FUNCTION TO ADD ALL THE QUESTIONS IN A QUESTION_MASTER
		public function addQuestions($question,$op1,$op2,$op3,$op4,$ans,$examid){
			$this->qry="insert into question_master(exam_id,question,option1,option2,option3,option4,correct)values($examid,'$question','$op1','$op2','$op3','$op4','$ans')";
			return mysql_query($this->qry);
		}
		
		//FUNCTION TO GET THE LIST EXAMS
		public function getExamList($userid,$usertype){
			
			
			$this->qry="select 
						ex.exam_id, ex.exam_name,ex.end_date, ex.time, sum.subject_name, sm.semister_name, cm.course_name, concat(concat(um.first_name,' '),um.last_name) as user_fullname,stm.test_name,stm.test_id
						from 
						exam_master ex, subject_master sum, semister_master sm, course_master cm, user_master um,skilltest_master stm
						where
						ex.subject_id = sum.subject_id
						and sum.sem_id = sm.sem_id
						and sm.course_id = cm.course_id
						and ex.user_id = um.user_id
						and ex.test_id = stm.test_id";
						
						if(intval($usertype)==2)
							$this->qry.=" and ex.user_id =$userid";
						if(intval($usertype)==4)
							$this->qry.=" and sm.sem_id =(select sem_id from user_master where user_id=$userid)";
						
			$this->res=mysql_query($this->qry);
			
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		//FUNCTION TO GET THE SUBJECT NAME FROM SUBJECT_MASTER OF PARTICULAR EXAM.
		public function getSubjectName($examid){
			$this->qry="select sm.subject_name from subject_master sm where sm.subject_id=(select subject_id from exam_master where exam_id=$examid)";
			$this->res=mysql_query($this->qry);
			
			$arr=mysql_fetch_object($this->res);
			return $arr->subject_name;
		}
		
		//FUNCTION TO GET THE EXAM NAME,EXAM RULES AND TIME OF PARTICULAR EXAM.
		public function getExamNameRules($examid){
			$this->qry="select exam_name,exam_rules,time from exam_master where exam_id=$examid";
			$this->res=mysql_query($this->qry);
						
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		//FUNCTION TO GET ALL THE QUESTION FROM QUESTION_MASTER OF PARTICULAR EXAM.
		public function getQuestions($examid){
			$this->qry="select question_id,question,option1,option2,option3,option4,correct from question_master where exam_id=$examid";
			$this->res=mysql_query($this->qry);
			
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		//FUNCTION TO GET THE ANSWERS OF PARTICULAR EXAM FROM QUESTION_MASTER.
		public function getExamAnswers($examid){
			$this->qry="select correct,question_id from question_master where exam_id=$examid";
			$this->res=mysql_query($this->qry);
			
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
			
		}
		
		//FUNCTION TO STORE THE ANSWERS OF PARTICULAR STUDENT AGAINST HIS ID AND ALSO STORE HIS CORRECT ANSWERS.
		public function storeExamAnswers($qid,$ans,$userid,$iscorrect,$mks){
		
			//$ans=mysql_query("select marks_correct,marks_wrong where exam_id=(select exam_id from exam_master e)")
		
			$this->qry="insert into answer_master(question_id,student_id,student_answer,iscorrect_answer,student_score)values($qid,$userid,'$ans',$iscorrect,$mks)";
			$this->res=mysql_query($this->qry);
		}
		
		//FUNCTION TO STORE THE EXAMID AGAINST THE STUDENT ID IF THAT STUDENT HAS APPEARED THE EXAM.
		public function rememberStudentExam($examid,$userid){
			$this->qry="insert into exam_vs_student(exam_id,student_id)values($examid,$userid)";
			$this->res=mysql_query($this->qry);
			
		}
		
		//FUNCTION TO CHECK WHETHER THE GIVEN STUENT HAS APPEARED FOR THE PARTICULAR EXAM.
		public function checkExamAppeared($examid,$userid){
			$this->qry="select student_id from exam_vs_student where exam_id=$examid and student_id=$userid";
			$this->res=mysql_query($this->qry);
			if(mysql_num_rows($this->res)>0){
				return true;
			}else{
				return false;
			}
		}
		
		public function selectTest(){
			$this->qry="select test_id,test_name from skilltest_master";
			$this->res=mysql_query($this->qry);
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
			
		}
		
		public function getExamMarks($examid){
			$this->qry="select em.max_marks,em.min_marks,em.marks_correct,em.marks_wrong,sm.test_name from exam_master em,skilltest_master sm where em.test_id=sm.test_id and exam_id=$examid";
			$this->res=mysql_query($this->qry);
			if($this->res)
			{
				$retArr = array();
				if(mysql_num_rows($this->res)>0){
					while($rowArr = mysql_fetch_array($this->res,MYSQL_ASSOC))
					{
						array_push($retArr,$rowArr);							
					}
					return $retArr;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		public function checkSkilltestSubject($sub,$testid){
			$this->qry="select subject_id,test_id from subject_vs_skilltest where subject_id=$sub and test_id=$testid";
			$this->res=mysql_query($this->qry);
			
			if($this->qry){
				if(mysql_num_rows($this->res)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		public function getTestSubject($tid,$sid){
			$this->qry="select stm.test_name,sm.subject_name from skilltest_master stm,subject_master sm where test_id=$tid and subject_id=$sid";
			$this->res=mysql_query($this->qry);
			
			
				return mysql_fetch_row($this->res);
		}
		
		public function getDefinedMarks($examid){
			$this->qry="select marks_correct,marks_wrong from exam_master where exam_id=$examid";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				$row=mysql_fetch_row($this->res);
				return $row;
			}
		}
		
		public function getResult($userid,$examid){
			$this->qry="select sum(a.student_score) as result from answer_master a,exam_master e,question_master q where e.exam_id=q.exam_id and q.question_id=a.question_id and e.exam_id=$examid group by student_id having a.student_id=$userid";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					$row=mysql_fetch_row($this->res);
					return $row[0];
					
				}
			}
		}
		
		public function getExamDetails($examid){
			$this->qry="select em.exam_name,em.end_date,concat(concat(um.first_name,' '),um.last_name),tm.test_name,sm.subject_name
						from exam_master em,user_master um,skilltest_master tm,subject_master sm
						where em.user_id=um.user_id and em.test_id=tm.test_id and em.subject_id=sm.subject_id and em.exam_id=$examid";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					$row=mysql_fetch_row($this->res);
					return $row;
					
				}
			}
			
		}
		
		public function getAllExamDetails($examid){
			$this->qry="select em.exam_id,em.exam_name,em.exam_rules,em.end_date,em.time,em.no_of_ques,em.max_marks,em.min_marks,em.marks_correct,em.marks_wrong,sm.subject_name,tm.test_name ,sm.subject_id,tm.test_id
						from exam_master em,subject_master sm,skilltest_master tm
						where em.subject_id=sm.subject_id and em.test_id=tm.test_id and em.exam_id=$examid";
			$this->res=mysql_query($this->qry);
			
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					$row=mysql_fetch_row($this->res);
					return $row;
					
				}
			}
		}	
		
		public function allowReExam($username,$exam,$test){
			$this->qry="delete from exam_vs_student 
						where exam_id=$exam
						and student_id=(select user_id from user_master where user_name='$username')";
			mysql_query($this->qry);
			
			$this->qry="delete from answer_master 
						where question_id in (select question_id from question_master where exam_id=$exam)
						and student_id=(select user_id from user_master where user_name='$username')";
			return mysql_query($this->qry);
		}
		
	}
	
?>

