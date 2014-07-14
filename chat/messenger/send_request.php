<?php
	
	
	session_start();
	if(!isset($_SESSION['user'], $_POST['host'])) die();
	
	$user = unserialize($_SESSION['user']);
	
	$db = new mysqli('localhost', 'root', '', 'chat');
	
	$sql = "SELECT * FROM participants WHERE username = '" . $user->username . "'";
	
	if($res = $db->query($sql)) {
		
		if(!$res->num_rows) {
			
			$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "'";
			
			$res = $db->query($sql);
			
			if(!$res->num_rows) {
				
				$sql = "SELECT * FROM active_chats WHERE host = '" . $_POST['host'] . "'";
				$res = $db->query($sql);
				if($res->num_rows) {
				
					$chatkey = $res->fetch_object()->chatkey;
					$sql = "INSERT INTO requests(username, chatkey) VALUES ('" . $user->username . "', '$chatkey')";
					if($res = $db->query($sql)) {
						
						echo "0";
						
					} else echo "3";
					
				} else {
				
					echo "2";
					
				}
				
				
			} else {
				
				echo "1";
				
			}
			
		} else {
			
			echo "1";
			
		}
		
	} else {
		
		echo "DB error: " . $db->error;
		
	}
	
	
	
?>