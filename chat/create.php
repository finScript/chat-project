<html>
	<head>
		
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		
	</head>
	<body>
		<?php
			
			session_start();
			if(!isset($_SESSION['user'])) { header("location: ../login"); die(); }
			if(!isset($_GET['h']) or !isset($_GET['p']) or !isset($_GET['t'], $_GET['time'])) {
				
				die("vars not set!");
				
			}
			
			require "UserClass.php";
			$user = unserialize($_SESSION['user']);
			$db = new mysqli('localhost', 'root', '', 'chat');
			
			$valid = true;
			
			$host = $_GET['h'];
			$participants = $_GET['p'];
			$topic = $_GET['t'];
			$sessionkey = md5(uniqid(time()));
			
			$sql = "SELECT * FROM active_chats WHERE chatkey = '$sessionkey'";
			
			$invalid_users = [];
			
			$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "'";
			
			$res = $db->query($sql);
			if($res->num_rows) die("<span style='color:red;'>You are already hosting another session! End it before creating a new session!</span><br /><a href='../chat'>Return</a>");
			
			if($res = $db->query($sql)) {
				
				if($res->num_rows) {
					
					$valid = false;
					echo "You are already hosting another session! You have to end it before you can start a new session!";
					
				} else {
					
					$sql = "INSERT INTO active_chats(name, host, chatkey) VALUES ('$topic', '$host', '$sessionkey')";
					if($res = $db->query($sql)) {
						
						$user_array = explode(",", $participants);
						
						//loop through users
						for($i = 1; $i <= count($user_array); $i++) {
							
							$u = $user_array[$i-1];
							
							//first check other sessions
							$sql = "SELECT * FROM participants WHERE username = '" . $u ."'";
							$res = $db->query($sql);
							
							//if user found from another chat, don't invite him. (add to invalid_users array)
							if($res->num_rows) {
								
								echo "<span style='color:red'>" . $u . " is already participating another session.</span><br />";
								array_push($invalid_users, $u);
								
							} else {
								
								//then check if user is hosting another session.
								$sql = "SELECT * FROM active_chats WHERE host = '" . $u . "'";
								$res = $db->query($sql);
								
								//if user was found, don't invite him (add to invalid_users array)
								if($res->num_rows) {
									
									echo "<span style='color:red'>" . $u . " is already hosting another session.</span><br />";
									array_push($invalid_users, $u);
									
								} else {
									
									
									
									//if there were no fatal parameters, add user to participants list with another user's sessionkey.
									$sql = "INSERT INTO invites(username, chatkey) VALUES ('" . $u . "', '$sessionkey')";
									$db->query($sql);
									
									//tell host about the success!
									echo "<span style='color:green;'>" . $u . " was invited successfully!</span><br />";
									
									$sql = "INSERT INTO events (
										event_id, chatkey, username, occurred
									) VALUES (
										2,
										'$sessionkey',
										'$u',
										'" . $_GET['time'] . "'
									)";
									
									$db->query($sql);
									
								}
							}
						}
						
						if(count($invalid_users) != 0) {
						
							echo "<pre>";
							print_r($invalid_users);
							echo "</pre>";
						
						}
						
						$sql = "INSERT INTO participants(chatkey, username) VALUES ('$sessionkey', '$host')";
						$db->query($sql);
						
						$user->access_to = $sessionkey;
						$_SESSION['user'] = serialize($user);
						
					} else {
						
						echo "db error (2): " . $db->error;
						
					}
					
				}
				
			} else {
				
				echo "db error (1): " . $db->error;
				
			}
			
		?>
		
		<br />
		<a href='../chat'>Return</a>
		
	</body>
</html>