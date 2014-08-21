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
			
			$file_arr = [];
			
			$sql = "SELECT * FROM messages WHERE msg_type = 'file' AND chatkey = '$key'";
			
			$res = $db->query($sql);
			
			if($res->num_rows) {
				while($row = $res->fetch_object()) {
					
					array_push($file_arr, $row->msg);
					
				}
			}
			
			$sql = "SELECT * FROM messages WHERE msg_type = 'image' AND chatkey = '$key'";
			
			$res = $db->query($sql);
			
			if($res->num_rows) {
				while($row = $res->fetch_object()) {
					
					array_push($file_arr, $row->msg);
					
				}
			}
			
			chmod("files", 0777);
			
			if(count($file_arr) != 0) {
				foreach($file_arr as $file) {
					
					unlink("files/" . $file);
					
				}
			}
			
			$sql = "DELETE FROM active_chats WHERE host = '" . $user->username . "'";
			$db->query($sql);
			
			$sql = "DELETE FROM participants WHERE chatkey = '$key'";
			$db->query($sql);
			
			$sql = "DELETE FROM invites WHERE chatkey='$key'";
			$db->query($sql);
			
			$sql = "DELETE FROM messages WHERE chatkey = '$key'";
			$db->query($sql);
			
			$sql = "DELETE FROM events WHERE chatkey = '$key'";
			$db->query($sql);
			
			echo "0";
			
		} else {
			
			echo "404";
			
		}
		
	} else {
		
		echo "db error: " . $db->error;
		
	}
	
?>