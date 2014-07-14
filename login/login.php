<?php
	
	session_start();
	
	header("Content-type: text/xml");
	
	if(!isset($_POST['username'])) die("<status>403</status>");
	
	require "UserClass.php";
	
	$user = new User();
	
	$client_username = $_POST['username'];
	$client_password = $_POST['password'];
	
	$db = new mysqli('localhost', 'root', '', 'user_data');
	
	$sql = "SELECT * FROM users_waiting WHERE username = '$client_username' OR email = '$client_username'";
	
	try {
	
		if($res = $db->query($sql)) {
			
			if($res->num_rows) {
				
				$password;
				while($row = $res->fetch_object()) {
					
					$password = $row->password;
					
				}
				
				if(password_verify($client_password, $password)) {
					
					$sql = "SELECT * FROM users_waiting WHERE username = '$client_username' OR email = '$client_username'";
					$res = $db->query($sql);
					
					while($row_2 = $res->fetch_object()) {
						
						$user->username = $row_2->username;
						$user->fullname = $row_2->fullname;
						$user->email = $row_2->email;
						$user->sessionkey = $row_2->sessionkey;
						
						$db_2 = new mysqli('localhost', 'root', '', 'chat');
						$res_3 = $db_2->query("SELECT * FROM participants WHERE username = '" . $row_2->username . "'");
						if($res_3->num_rows) {
							
							while($row_3 = $res_3->fetch_object()) {
								
								$user->access_to = $row_3->chatkey;
								
							}
							
						}
						
						$res_3 = $db_2->query("SELECT * FROM active_chats WHERE host = '" . $row_2->username . "'");
						if($res_3->num_rows) {
							
							while($row_3 = $res_3->fetch_object()) {
								
								$user->access_to = $row_3->chatkey;
								
							}
							
						}
						
						$_SESSION['user'] = serialize($user);
						
						die("<status>0</status>");
						
					}
					
				} else die("<status>20</status>");
				
				
				
			} else die("<status>404</status>");
			
		} else die("<status>10</status><err>" . $db->error . "</err>");
	} catch(Exception $e) {
		
		die("<status>1000</status><err>Fatal: " . $e->getMessage() . "</err>");
		
	}
	
	
?>