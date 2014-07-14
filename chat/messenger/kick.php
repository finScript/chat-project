<?php
	
	session_start();
	if(!isset($_POST['u'], $_POST['t']) or !isset($_SESSION['user'])) die();
	
	require "UserClass.php";
	
	$t = $_POST['t'];
	$kick_user = $_POST['u'];
	
	$db = new mysqli('localhost', 'root', '', 'chat');
	$user = unserialize($_SESSION['user']);
	$chatkey = $user->access_to;
	
	$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "' AND chatkey = '$chatkey'";
	if($res = $db->query($sql)) {
		
		if($res->num_rows) {
			
			
			$sql = "SELECT * FROM participants WHERE username = '$kick_user' AND chatkey = '$chatkey'";
			
			$res = $db->query($sql);
			if($res->num_rows) {
				
				$sql = "DELETE FROM participants WHERE username = '$kick_user' AND chatkey = '$chatkey'";
				if($db->query($sql)) {
					
					$sql = "INSERT INTO events (
						event_id,
						chatkey,
						username,
						occurred
					) VALUES (
						1,
						'$chatkey',
						'$kick_user',
						'$t'
					)";
					
					$db->query($sql);
					echo "0";
					
				} else {
					
					echo "Failed to kick user!";
					
				}
				
			} else {
				
				echo "Provided username was not found!";
				
			}
			
		} else {
			
			echo "host not found";
			
		}
		
	} else {
		
		echo "db error: " . $db->error;
		
	}
	
	
	
	
	
	
	
?>