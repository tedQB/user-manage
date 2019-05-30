<?php 
	require_once("easyCRUD/easyCRUD.class.php");
	require_once("Db.class.php");
	$db = new Db();
	
	
	$content = $db->query("SELECT * FROM bang");
	
	print_r($content[0]['name']);
	
	
?>