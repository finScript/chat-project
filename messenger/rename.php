<?php
	
	session_start();
	include("../../ChromePhp.php");
	require "UserClass.php";
	
	function _log($s) {
		ChromePhp::log($s);
	}
	
	if(!isset($_SESSION['user'], $_GET['n'], $_GET['t'])) die("vars not set");
	$user = unserialize($_SESSION['user']);
	include('../../info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
	
	$new_name = $_GET['n'];
	$chatkey = $user->access_to;
	
	
	$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "' AND chatkey = '$chatkey'";
	
	if($res = $db->query($sql)) {
		
		if($res->num_rows) {
			
			$sql = "
				
				UPDATE active_chats
				SET name = '$new_name'
				WHERE chatkey = '$chatkey'
				
			";
			
			if($res = $db->query($sql)) {
				
				
				
				$sql = "
					INSERT INTO 
					events (
						event_id,
						chatkey,
						username,
						occurred
					)
					VALUES (
						4,
						'" . $user->access_to . "',
						'" . $user->username . "',
						'" . $_GET['t'] . "'
					)
				";
					
				$db->query($sql);
				
				echo "0";
				
			} else {
				
				echo "db error: " . $db->error;
				
			}
			
		} else {
			
			echo "unauthorized access!";
			
		}
		
	} else {
		echo "db error: " . $db->error;
	}
	
?>