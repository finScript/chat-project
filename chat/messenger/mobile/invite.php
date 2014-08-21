<?php
	
	session_start();
	require "UserClass.php";
	
	if(!isset($_SESSION['user'], $_POST['u'])) die();
	
	$user = unserialize($_SESSION['user']);
	
	$u = $_POST['u'];
	
	include("../../info.php");
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "' AND chatkey = '" . $user->access_to . "'";
	
	if($res = $db->query($sql)) {
		
		if($res->num_rows) {
			
			$sql = "SELECT * FROM participants WHERE username = '" . $u . "'";
			$res = $db->query($sql);
			if(!$res->num_rows) {
				
				$sql = "SELECT * FROM invites WHERE username = '" . $u . "' AND chatkey = '" . $user->access_to . "'";
				$res = $db->query($sql);
				if(!$res->num_rows) {
					
					$sql = "SELECT * FROM active_chats WHERE host = '" . $u . "'";
					$res = $db->query($sql);
					
					if(!$res->num_rows) {
						
						$sql = "INSERT INTO invites(username, chatkey) VALUES ('" . $u . "', '" . $user->access_to . "')";
						$db->query($sql);
						$sql = "INSERT INTO events(event_id, chatkey, username, occurred) VALUES (2, '" . $user->access_to . "', '" . $u . "', '" . $_POST['t'] . "')";
						$db->query($sql);
						echo "0";
						die();
						
					} else die("3");
					
				} else die("2");
				
			} else die("1");
			
		} else die();
		
	} else {
		
		echo "DB error: " . $db->error;
		
	}
	
?>