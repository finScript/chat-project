<?php
	
	require "UserClass.php";
	
	include("../../ChromePhp.php");
	
	function _log($s) {
		ChromePhp::log($s);
	}
	
	
	session_start();
	
	
	
	_log("latest_e = " . $_SESSION['latest_e']);
	_log("latest_m = " . $_SESSION['latest_m']);
	_log("latest_r = " . $_SESSION['latest_r']);
	
	header("Content-type: text/xml");
	if(!isset($_SESSION['user'])) die();
	
	if(!isset($_SESSION['latest_m'], $_SESSION['latest_e'], $_SESSION['latest_r'])) {
		
		$_SESSION['latest_e'] = 0;
		$_SESSION['latest_m'] = 0;
		$_SESSION['latest_r'] = 0;
		
	}
	
	
	
	$user = unserialize($_SESSION['user']);
	include('../../info.php');
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	$sql = "SELECT * FROM events WHERE username = '" . $user->username . "' AND event_id = 1 AND chatkey = '" . $user->access_to . "'";
	if($res = $db->query($sql)) {
		
		if($res->num_rows) {
			
			unset($user->access_to);
			$_SESSION['user'] = serialize($user);
			die("<response><special>kicked</special></response>");
			
		}
		
	}
	
	
	echo "<response>";
	
	
	if(isset($_POST['count'])) {
		
		_log("count = " . $_POST['count']);
		
		insert_messages($db, $user);
		
		$events = get_events($db, $user, $_SESSION['latest_e']);
		$messages = get_messages($db, $user, $_SESSION['latest_m']);
		$requests = get_requests($db, $user, $_SESSION['latest_r']);
		
		if($events == 0) {
			
			_log("event count = 0");
			echo "<event_count>0</event_count>";
			
		} else {
			
			echo handle_return_string('e', $events, $user);
			_log("event count = " . count($events));
		
		}
		
		
		if($messages == 0) {
			
			_log("message count = 0");
			echo "<message_count>0</message_count>";
			
		} else {
			
			echo handle_return_string('m', $messages, $user);
			_log("message count = " . count($messages));
		
		}
		
		if($requests == 0) {
			
			_log("request count = 0");
			echo "<request_count>0</request_count>";
			
		} else {
			
			echo handle_return_string('r', $requests, $user);
			_log("request count = " . count($requests));
		
		}
		
	} else {
		
		_log("count is not set");
		
		$events = get_events($db, $user, $_SESSION['latest_e']);
		$messages = get_messages($db, $user, $_SESSION['latest_m']);
		$requests = get_requests($db, $user, $_SESSION['latest_r']);
		
		if($events == 0) {
			
			_log("event count = 0");
			echo "<event_count>0</event_count>";
			
		} else {
			
			echo handle_return_string('e', $events);
			_log("event count = " . count($events));
		
		}
		
		
		if($messages == 0) {
			
			_log("message count = 0");
			echo "<message_count>0</message_count>";
			
		} else {
			
			echo handle_return_string('m', $messages);
			_log("message count = " . count($messages));
		
		}
		
		if($requests == 0) {
			
			_log("request count = 0");
			echo "<request_count>0</request_count>";
			
		} else {
			
			echo handle_return_string('r', $requests, $user);
			_log("request count = " . count($requests));
		
		}
		
	}
	
	echo "</response>";
	
	function get_events($_db, $_user, $latest) {
		
		$chatkey = $_user->access_to;
		
		$event_ids = [
			
			0 => "ended",
			1 => "kicked",
			2 => "invited",
			3 => "joined",
			4 => "renamed",
			5 => "host_switched",
			
		];
		
		
		$sql = "SELECT MAX(id) AS id FROM events WHERE chatkey = '$chatkey'";
		$res = $_db->query($sql);
		$max_id = $res->fetch_object()->id;
		
		
		
		$sql = "SELECT * FROM events WHERE id > $latest AND chatkey = '$chatkey'";
		
		if($res = $_db->query($sql)) {
			
			if($res->num_rows) {
				
				$events = [];
				
				while($row = $res->fetch_object()) {
					
					array_push($events, [
						
						"event" => $event_ids[$row->event_id],
						"username" => $row->username,
						"occurred" => $row->occurred,
						
					]);
					
				}
				
				$_SESSION['latest_e'] = $max_id;
				return $events;
				
			} else {
				
				return 0;
				
			}
			
		}

	}
	
	function get_requests($_db, $_user, $latest) {
		
		$chatkey = $_user->access_to;
		
		$sql = "SELECT MAX(id) AS id FROM requests WHERE chatkey_to = '$chatkey'";
		$max_id = $_db->query($sql)->fetch_object()->id;
		
		$sql = "SELECT * FROM requests WHERE chatkey_to = '$chatkey' AND id > $latest";
		$res = $_db->query($sql);
		
		if($res->num_rows) {
			
			$requests = [];
			
			while($row = $res->fetch_object()) {
				
				array_push($requests, [
					
					"user_from" => $row->user_from,
					"request_id" => $row->request_id,
					
				]);
				
				
			}
			
			$_SESSION['latest_r'] = $max_id;
			return $requests;
			
		} else return 0;
		
	}
	
	function get_messages($_db, $_user, $latest) {
		
		_log("[messages] latest: " . $latest);
		
		$chatkey = $_user->access_to;
		
		$sql = "SELECT MAX(id) AS id FROM messages WHERE chatkey = '$chatkey'";
		$res = $_db->query($sql);
		$max_id = $res->fetch_object()->id;
		
		//$_SESSION['latest_m'] = $max_id;
		
		$sql = "SELECT * FROM messages WHERE id > $latest AND chatkey = '$chatkey'";
		
		if($res = $_db->query($sql)) {
			
			if($res->num_rows) {
				
				$messages = [];
				
				while($row = $res->fetch_object()) {
					
					array_push($messages, [
						
						"username" => $row->username,
						"msg_type" => $row->msg_type,
						"time_read" => $row->time_read,
						"date_posted" => $row->date_posted,
						"msg" => $row->msg,
						
					]);
					
				}
				
				$_SESSION['latest_m'] = $max_id;
				return $messages;
				
			} else {
				
				return 0;
				
			}
			
		}
		
	}
	
	function insert_messages($_db, $_user) {
		
		$db = $_db;
		$user = $_user;
		
		if(isset($_POST['count'])) {
			
			$count = $_POST['count'];
			$msg_arr = [];
			
			for($i = 0; $i < $count; $i++) {
				
				array_push($msg_arr, [
					
					"msg" => $_POST['msg' . $i],
					"time" => $_POST['time' . $i],
					"date" => $_POST['date' . $i],
					
				]);
				
			}
			
			
			
			$error_count = 0;
			for($i = 0; $i < $count; $i++) {
				
				
				$sql = "
				
				INSERT INTO
					messages(username, chatkey, msg_type, time_posted, time_read, date_posted, msg)
				VALUES
					('" . $user->username . "', '" . $user->access_to . "', 'text', '" . time() . "', '" . $msg_arr[$i]["time"] . "', '" . $msg_arr[$i]["date"] . "', '" . $msg_arr[$i]["msg"] . "')";
				
				if($res = $db->query($sql)) {
					continue;
				} else {
					$error_count++;
				}
				
			}
			
		}
		
	}
	
	
	
	function handle_return_string($action, $arr, $_user) {
		
		$r = "";
		
		if($action == 'e') {
			
			$count = 0;
			foreach($arr as $event) {
				
				$r .= "<event$count>" . $event["event"] . "</event$count>";
				$r .= "<userevent$count>" . $event["username"] . "</userevent$count>";
				$r .= "<occurred$count>" . $event["occurred"] . "</occurred$count>";
				$count++;
				
			}
			
			return "<event_count>" . $count . "</event_count>" . $r;
			
		} elseif($action == 'm') {
			
			$count = 0;
			foreach($arr as $message) {
				
				if($message["username"] != $_user->username) {
				
					$r .= "<user$count>" . $message["username"] . "</user$count>";
					$r .= "<msg_type$count>" . $message["msg_type"] . "</msg_type$count>";
					$r .= "<time_read$count>" . $message["time_read"] . "</time_read$count>";
					$r .= "<date_posted$count>" . $message["date_posted"] . "</date_posted$count>";
					$r .= "<msg$count>" . $message["msg"] . "</msg$count>";
					$count++;
				
				}
				
			}
			
			return "<message_count>" . $count . "</message_count>" . $r;
			
		} elseif($action == 'r') {
			
			$count = 0;
			foreach($arr as $request) {
				
				$count++;
				
			}
			return "<request_count>" . $count . "</request_count>";
			
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
?>