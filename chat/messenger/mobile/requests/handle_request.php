<?php
	
	session_start();
	include("info.php");
	require "UserClass.php";
	
	if(!isset($_SESSION['user'], $_POST['u'])) {
		die("failed");
	}
	
	$user = unserialize($_SESSION['user']);
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	$t = date('H') . ":" . date('i') . ":" . date('s');
	
	$a = $_POST['a'];
	
	if($a == "accept") {
		
		$u = $_POST['u'];
		$sql = "SELECT * FROM participants WHERE username = '" . $u . "'";
		$res = $db->query($sql);
		if($res->num_rows)
			$u_chatkey = $res->fetch_object()->chatkey;
		else $u_chatkey = "000";
		
		if($res->num_rows) {
			
			if($user->access_to != $u_chatkey) {
				
				echo "This person is already participating another chat session. This request will be removed.";
				remove_request($u, $db);
				die();
				
			} else {
				
				echo "This person is already participating this chat session. This request will be removed.";
				remove_request($u, $db);
				die();
				
			}
			
		} else {
			
			$sql = "SELECT * FROM active_chats WHERE host ='" . $u . "'";
			if($res->num_rows) {
				
				echo "This person is already hosting another chat session. This request will be removed.";
				remove_request($u, $db);
				die();
				
			} else {
				
				$sql_events = "INSERT INTO events(event_id, chatkey, username, occurred) VALUES (3, '" . $user->access_to . "', '$u', '$t')";
				$sql_participants = "INSERT INTO participants(username, chatkey) VALUES ('$u', '" . $user->access_to . "')";
				
				$db->query($sql_events);
				$db->query($sql_participants);
				
				remove_request($u, $db);
				die("0");
				
			}
			
		}
		
		
		
	} elseif($a == "decline") {
		
		
		
	}
	
	function remove_request($req_user, $_db) {
		
		$sql = "DELETE FROM requests WHERE user_from = '" . $req_user . "'";
		$_db->query($sql);
		
	}
	
	
?>