<?php
	
	
	session_start();
	if(!isset($_SESSION['user'], $_POST['host'])) die();
	
	require "UserClass.php";
	$user = unserialize($_SESSION['user']);
	
	include('requests/info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
	
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
					$sql = "INSERT INTO requests(user_from, chatkey_to, request_id) VALUES ('" . $user->username . "', '$chatkey', '" . substr(md5(rand()), 0, 7) . "')";
					if($res = $db->query($sql)) {
						
						echo "0";
						
					} else echo "DB error: " . $db->error;
					
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