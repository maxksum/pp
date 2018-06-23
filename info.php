<?php 
	include_once('db.php');
	
	$id = $_REQUEST['id'];
	
	$res = $db->query("SELECT * FROM recipe WHERE id_dishes=" . $id);
	$res = $res->fetch_assoc();
	if (empty($res)) {
		die("no");
	}
	$result = '<img src="' . $res['image'] . '">';
	$result .= '<p>' . $res['recipe'] . '</p>';
	die($result);
?>