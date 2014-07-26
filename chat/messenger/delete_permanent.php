<?php
	
	session_start();
	if(!isset($_SESSION['user'], $_POST['secure'])) die();
	
	require "UserClass.php";
	
	$user = unserialize($_SESSION['user']);
	
	$key = $_POST['key'];
	
	include('../../info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
	
	if($res = $db->query("SELECT * FROM active_chats WHERE host = '" . $user->username . "'")) {
		
		if($res->num_rows) {
			
			$sql = "DELETE FROM active_chats WHERE host = '" . $user->username . "'";
			$db->query($sql);
			
			$sql = "DELETE FROM participants WHERE chatkey = '$key'";
			$db->query($sql);
			
			$sql = "DELETE FROM invites WHERE chatkey='$key'";
			$db->query($sql);
			
			$sql = "DELETE FROM messages WHERE chatkey = '$key'";
			$db->query($sql);
			
			echo "0";
			
		} else {
			
			echo "404";
			
		}
		
	} else {
		
		echo "db error: " . $db->error;
		
	}
	
?>