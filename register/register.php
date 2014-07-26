<?php
	include("../info.php");
	session_start();
	if(isset($_SESSION['user'])) die('Other session running!');
	header("Content-type: text/xml");
	
	require "UserClass.php";
	
	if(!isset($_POST['username'])) die("<status>403</status>");
	
	$client_username = $_POST['username'];
	$client_password = $_POST['password'];
	$client_fullname = $_POST['fullname'];
	$client_email = $_POST['email'];
	
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	$sql = "SELECT * FROM users_waiting WHERE username = '$client_username' OR email = '$client_email'";
	
	if($res = $db->query($sql)) {
		
		if(!$res->num_rows) {
			
			$pwd_encrypt = password_hash($client_password, PASSWORD_DEFAULT);
			$session_key = md5(uniqid(time()));
			$sql = "INSERT INTO users_waiting(username, password, email, fullname, sessionkey) VALUES ('$client_username', '$pwd_encrypt', '$client_email', '$client_fullname', '$session_key')";
			
			if($db->query($sql)) {
				
				echo "<status>0</status>";
				
			} else die("<status>10</status><err>". $db->error ."</err>");
			
		} else die("<status>20</status>");
		
	} else {
		
		die("<status>10</status><err>". $db->error ."</err>");
		
	}
	
?>