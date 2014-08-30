<?php
	
	session_start();
	if(!isset($_POST['key'])) {
		
		die();
		
	}
	
	header("Content-type: text/xml");
	
	require "UserClass.php";
	
	echo "<status>";
		
		$user = unserialize($_SESSION['user']);
		include('../info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
		
		$key = $_POST['key'];
		
		if(isset($user->access_to)) {
			
			if($user->access_to == $key) { echo "0</status>"; die(); }
			
		}
		
		$sql = "SELECT * FROM invites WHERE chatkey = '$key' AND username = '" . $user->username . "'";
		
		if($res = $db->query($sql)) {
			
			if($res->num_rows) {
				
				echo "0";
				
				$sql = "DELETE FROM invites WHERE chatkey = '$key' AND username = '" . $user->username . "'";
				$db->query($sql);
				
				$sql = "INSERT INTO participants(chatkey, username) VALUES ('$key', '" . $user->username . "')";
				$db->query($sql);
				
				$t = $_POST['t'];
				
				$sql = "INSERT INTO events(event_id, chatkey, username, occurred) VALUES (3, '$key', '" . $user->username . "', '$t')";
				$db->query($sql);
				
				$user->access_to = $key;
				$_SESSION['user'] = serialize($user);
				
			} else {
				
				echo "404";
				
			}
			
		} else {
			
			echo "500";
			
		}
		
	echo "</status>";

?>