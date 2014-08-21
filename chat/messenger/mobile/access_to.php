<?php
	
	session_start();
	include("requests/info.php");
	require "requests/UserClass.php";
	
	if(!isset($_SESSION['user'])) {
		
		die();
		
	}
	
	$user = unserialize($_SESSION['user']);
	$db = new mysqli(_host, _user, _pass, _dbname);
	if(!isset($user->access_to)) {
		
		$sql = "SELECT * FROM participants WHERE username = '" . $user->username . "' AND chatkey = '" . $_GET['k'] . "'";
		if($db->query($sql)->num_rows) {
			
			$user->access_to = $_GET['k'];
			$_SESSION['user'] = serialize($user);
			header("location: ../messenger/");
			
		} else {
			
			header("location: ../../");
			
		}
		
	}
	
?>