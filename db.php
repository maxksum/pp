<?php 
//    error_reporting(0);
	
	$db_address = '127.0.0.1';
	$db_user = 'root';
	$db_password = 'root';
	$db_name = 'pp';
	
	$db = new mysqli($db_address, $db_user, $db_password, $db_name);
	$db->set_charset("utf8");
?> 