// JavaScript Document
function enableDisableExams(usertypeid)
{
	if(parseInt(usertypeid)==2)
	{
		document.getElementById('exams').style.display='block';
		document.getElementById('student').style.display='none';
	}
	else if(parseInt(usertypeid)==4)
	{
		document.getElementById('exams').style.display='none';
		document.getElementById('student').style.display='block';
	}
	else
	{
		document.getElementById('student').style.display='none';
		document.getElementById('exams').style.display='none';
	}
	
}

var time = 0;
var timerOn = true;
var timer = 0;

function myCounter(){
	
	if(time <= 0){
		clearInterval(timer);
		document.getElementById('submitPaper').submit();
	}
	
	time = time-1;

	var dTimeM =  parseInt((time-(time%60))/60);
	dTimeM = String(dTimeM);
	if(dTimeM.length<2) dTimeM = '0'+dTimeM;

	
	var dTimeS = time%60;
	dTimeS = String(dTimeS);
	if(dTimeS.length<2) dTimeS = '0'+dTimeS;

	document.getElementById('timeleft').innerHTML = dTimeM+':'+dTimeS;
}

function startExamTimer(sTime,func){
	time = parseInt(sTime)*60;
	timer = setInterval('myCounter()',1000);
}

function viewReportWindow(examid,testid){
	var selDiv = document.getElementById('div_'+examid).value;
	window.open('testviewreport.php?msg=viewreport&eid='+examid+'&tid='+testid+'&div='+selDiv,'ExmRpt',"location=1,status=1,height=800,width=900");
}

function printReportWindow(examid,testid){
	var selDiv = document.getElementById('div_'+examid).value;
	window.open('printreport1.php?msg=printreport&eid='+examid+'&tid='+testid+'&div='+selDiv,'ExmRpt',"location=1,status=1,height=800,width=900");
}

function seeQuestions(examid,testid)
{
	window.open('see_questions.php?msg=seequestions&eid='+examid+'&tid='+testid,'Question Report',"location=1,status=1,height=800,width=800");
}

function test(url){
	
	var uid=document.getElementById('userid').value;
	var tid=document.getElementById('skilltest').value;
	document.getElementById("exam").disabled=false;
	window.location = 'examcontrol.php?msg=getsubjects&id='+uid+'&tid='+tid;
}

function disableEnable(){
	alert("Hello");
}
