<?php

	//START THE SESSION BEFORE ANY OUTPUT BEGINS
	session_start();
	
	//GLOBAL VARIABLES TO CONNECT DATABASE
	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASS','');
	define('DB_NAME','examProd');
	
	//FUNCTION TO CONNECT TO THE DATABASE
	if(!mysql_connect(DB_HOST,DB_USER,DB_PASS))
		die('Could not connect : '.mysql_error());
	
	//FUNCTION TO SELECT THE DATABASE
	if(!mysql_select_db(DB_NAME))
		die('Could not select database : '.mysql_error());
?>