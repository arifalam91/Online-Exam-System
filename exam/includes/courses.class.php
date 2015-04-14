	<?php

	class courses{
	
		private $qry;
		private $res;
		
		//FUNCTION TO GET THE LIST OF COURSES
		public function getCourseList(){
			$this->qry="select course_id,course_name from course_master";
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
		
		//FUNCTION TO GET THE COURSE NAME DIRECTLY FROM COURSE_MASTER 
		public function getCourseName($id){
			$this->qry="select course_name from course_master where course_id=".$id;
			$this->res=mysql_query($this->qry);
			if($this->res){
				$obj=mysql_fetch_array($this->res);
				return $obj[0];
			}else
				return false;
		}
		
		//FUNCTION TO GET THE LIST OF SEMISTERS FOR A PARTICULAR COURSE
		public function getSemList($course_id){
			$this->qry="select sem_id,semister_name from semister_master where course_id=".$course_id;
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
		
		//FUNCTION TO GET THE SEMISTER NAME USING SEMISTER_ID
		public function getSemisterName($sem_id){
			$this->qry="select semister_name from semister_master where sem_id=".$sem_id;
			$this->res=mysql_query($this->qry);
			if($this->res){
				$obj=mysql_fetch_array($this->res);
				return $obj[0];
			}else
				return false;
		}
		
		//FUNCTION TO GET THE COURSE NAME FROM SEMISTER_MASTER USING SUB QUERY
		public function getCourseNameFromSemId($id){
			$this->qry="select course_name from course_master where course_id=(select course_id from semister_master where sem_id=".$id.")";
			$this->res=mysql_query($this->qry);
			if($this->res){
				$obj=mysql_fetch_array($this->res);
				return $obj[0];
			}else
				return false;			
		}
		
		//FUNCTION TO GET THE LIST OF SUBJECTS USING SEMISTER_ID
		public function getSubjectList($semister_id){
			$this->qry="select subject_id,subject_name,subject_code from subject_master where sem_id=".$semister_id;
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
		
		public function getDivList(){
			$this->qry="select div_id,div_name from div_master";
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
		
		public function getDivById($divid){
			$this->qry="select div_name from div_master where div_id=$divid";
			$this->res=mysql_query($this->qry);
			if($this->res){
				$retdiv=mysql_fetch_row($this->res);
				return $retdiv;
			}
		}
	
	}

?>