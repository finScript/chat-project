<?php
	
	session_start();
	header("Content-type: text/xml");
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";
	
	require "UserClass.php";
	include("../info.php");
	
	if(!isset($_SESSION['user'], $_POST['h'])) die();
	
	$user = unserialize($_SESSION['user']);
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	echo "<response>";//=======================================================
	
	/*========== Host validation ==========*/
	
	$host = $user->username;
	
	if(check_active_chats($db, $user, $host)) {
		
		die("<failed>You are already hosting another session. You have to end it to start hosting a new session.</failed></response>");
		
	}
	
	if(check_participants($db, $user, $host)) {
		
		die("<failed>You are already participating another session. You have to leave it to start hosting a new session.</failed></response>");
		
	}
	
	if(check_invites($db, $user, $host)) {
		
		die("<failed>You have already been invited to another session. You have to either accept or decline the invitation before starting a new session.</failed></response>");
		
	}
	
	/*========== End host validation ==========*/
	
	/*========== Participant validation ==========*/
	
	$user_list = explode(',', $_POST['p']);
	$valid_users = [];
	$invalid_users = [];
	
	foreach($user_list as $p) {
		
		if(check_participants($db, $user, $p)) {
			
			array_push($invalid_users, ["p" => $p, "cause" => 1]);
			continue;
			
		}
		
		if(check_active_chats($db, $user, $p)) {
			
			array_push($invalid_users, ["p" => $p, "cause" => 1]);
			continue;
			
		}
		
		array_push($valid_users, $p);
		
	}
	
	/*========== End participant validation ==========*/
	
	$count = 0;
	
	if(count($invalid_users) != 0) {
	
		echo "<invalid>";
		
		foreach($invalid_users as $i_user) {
			
			echo "<invalid$count>" . $i_user['p'] . "</invalid$count>";
			echo "<cause$count>" . $i_user['cause'] . "</cause$count>";
			$count++;
			
		}
		
		echo "</invalid>";
	
	}
	
	echo "<invalidcount>$count</invalidcount>";
	
	$count = 0;
	
	if(count($valid_users) != 0) {
	
		echo "<valid>";
		
		foreach($valid_users as $v_user) {
			
			echo "<valid$count>" . $v_user . "</valid$count>";
			$count++;
			
		}
		
		echo "</valid>";
		
	} else {
		
		echo "<failed>None of the users are available at the moment.</failed>";
		
	}
	
	echo "<validcount>$count</validcount>";
	
	echo "</response>";//=======================================================
	
	if($_POST['dev'] != "true") {
	
		if(count($valid_users) != 0) {
			
			$chatkey = md5(uniqid(time()));
			
			$sql = "INSERT INTO active_chats(name, host, chatkey) VALUES ('" . $_POST['t'] . "', '$host', '$chatkey');";
			$db->query($sql);
			
			$t = date("H") . ":" . date("i") . ":" . date("s");
			
			foreach($valid_users as $p) {
				
				$sql = "INSERT INTO invites(username, chatkey) VALUES ('$p', '$chatkey')";
				$db->query($sql);
				$sql = "INSERT INTO events(event_id, chatkey, username, occurred) VALUES (2, '$chatkey', '$p', '$t')";
				$db->query($sql);
				
			}
			
			$user->access_to = $chatkey;
			$_SESSION['user'] = serialize($user);
			
		} else die();
	
	}
	
	
	function check_active_chats($_db, $_user, $name) {
		
		$db = $_db;
		$user = $_user;
		$q = $name;
		
		$sql = "SELECT * FROM active_chats WHERE host = '$q'";
		
		if($db->query($sql)->num_rows) return true;
		else return false;
		
	}
	
	function check_participants($_db, $_user, $name) {
		
		$db = $_db;
		$user = $_user;
		$q = $name;
		
		$sql = "SELECT * FROM participants WHERE username = '$q'";
		
		if($db->query($sql)->num_rows) return true;
		else return false;
		
	}
	
	function check_invites($_db, $_user, $name) {
		
		$db = $_db;
		$user = $_user;
		$q = $name;
		
		$sql = "SELECT * FROM invites WHERE username = '$q'";
		
		if($db->query($sql)->num_rows) return true;
		else return false;
		
	}
	
	
	
	
?>












