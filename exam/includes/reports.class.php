<?php


	class reports{
	
		private $qry;
		private $res;
		
		public function getReport($examid,$testid){
			
			$this->qry="SELECT em.exam_id, sm.subject_id, sm.subject_name, stm.test_name, sem.semister_name,em.max_marks,em.min_marks, concat( concat( um.first_name, ' ' ) , um.last_name ) AS TeacherName,em.end_date,crs.course_name
						FROM exam_master em, subject_master sm, skilltest_master stm, semister_master sem, user_master um,course_master crs
						WHERE em.subject_id = sm.subject_id
						AND sm.sem_id = sem.sem_id
						AND em.test_id = stm.test_id
						AND um.user_id = em.user_id
						AND em.exam_id =$examid
						AND stm.test_id =$testid
						AND crs.course_id=sem.course_id";
			$this->res=mysql_query($this->qry);
						
			if($this->res){
				if(mysql_num_rows($this->res)>0){
					
					$row=mysql_fetch_row($this->res);
					return $row;
					
				}else{
						return false;
					}
			}else{
					return false;
				}
		}
		
		public function getMarkSheet($examid,$divid){
			$this->qry="select sum(am.student_score) as score,em.exam_name,am.student_id,um.rollno,dm.div_name 
			from answer_master am,question_master qm,exam_master em,user_master um,div_master dm 
			where am.question_id=qm.question_id and qm.exam_id=em.exam_id and am.student_id=um.user_id and dm.div_id=um.div_id and 
			am.student_id in(select student_id from exam_vs_student where exam_id=$examid) and em.exam_id=$examid and dm.div_id=$divid group by am.student_id";
			
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
		public function getMarkSheet1to30($examid,$divid){
			$this->qry="select sum(am.student_score) as score,em.exam_name,am.student_id,um.rollno,dm.div_name 
			from answer_master am,question_master qm,exam_master em,user_master um,div_master dm 
			where am.question_id=qm.question_id and qm.exam_id=em.exam_id and am.student_id=um.user_id and dm.div_id=um.div_id and 
			am.student_id in(select student_id from exam_vs_student where exam_id=$examid) and em.exam_id=$examid and dm.div_id=$divid group by am.student_id limit 0,30";
			
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
		
		public function getMarkSheet31to60($examid,$divid){
			$this->qry="select sum(am.student_score) as score,em.exam_name,am.student_id,um.rollno,dm.div_name 
			from answer_master am,question_master qm,exam_master em,user_master um,div_master dm 
			where am.question_id=qm.question_id and qm.exam_id=em.exam_id and am.student_id=um.user_id and dm.div_id=um.div_id and 
			am.student_id in(select student_id from exam_vs_student where exam_id=$examid) and em.exam_id=$examid and dm.div_id=$divid group by am.student_id limit 31,30";
			
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
		
		/*public function getReportDetails($examid){
		
			$this->qry="select "
		}*/
		
		
		public function checkValidDate($examid){
			$this->qry="SELECT TO_DAYS( NOW( ) ) - TO_DAYS( e.end_date )FROM exam_master e WHERE e.exam_id =$examid";
			$this->res=mysql_query($this->qry);
			
			if(mysql_num_rows($this->res)>0){
				return mysql_fetch_row($this->res);
			}else{
				return false;
			}
		}

					
	}
	
	
		

?>