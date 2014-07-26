<?php
	
	$action = $_GET['action'];
	$id = $_GET['id'];
	
	require "UserClass.php";
	
	if(isset($_SESSION['user'])) $user = unserialize($_SESSION['user']);
	else die();
	
	
	include("info.php");
$db = new mysqli(_host, _user, _pass, _dbname);
	
	if($action == "u") {
		
		$sql = "SELECT * FROM users_waiting WHERE username = '$id'";
		if($res = $db->query($sql)) {
			
			if(!$res->num_rows) {
				
				echo "0";
				
			} else echo "1";
			
		} else {
			
			echo "404";
			
		}
		
	} elseif($action == "e") {
		
		$sql = "SELECT * FROM users_waiting WHERE email = '$id'";
		if($res = $db->query($sql)) {
			
			if(!$res->num_rows) {
				
				echo "0";
				
			} else echo "1";
			
		} else echo "404";
		
	}
	
	
	
	
	
	
	
	
	
	
?>