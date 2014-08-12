<?php
	
	session_start();
	include("info.php");
	require "UserClass.php";
	
	if(!isset($_SESSION['user'], $_POST['u'])) {
		die("failed");
	}
	
	$user = unserialize($_SESSION['user']);
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	$a = $_POST['a'];
	
	if($a == "accept") {
		
		$u = $_POST['u'];
		$sql = "SELECT * FROM participants WHERE username = '" . $u . "'";
		$res = $db->query($sql);
		
		
	} elseif($a == "decline") {
		
		
		
	}
	
	
	
	
?>