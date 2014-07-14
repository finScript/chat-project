<?php
	
	if(!isset($_GET['q'])) die("vars not set");
	
	session_start();
	
	if(!isset($_SESSION['user'])) {
		
		header("location: ../");
		die();
		
	}
	
	
	
	require "UserClass.php";
	
	$user = unserialize($_SESSION['user']);
	$db_user = new mysqli('localhost', 'root', '', 'user_data');
	$sessionkey = $user->sessionkey;

	$q = $_GET['q'];
	
	$user_array = explode(",", $q);

	/*echo "<pre>";
	
		print_r($user_array);
		echo "<br />";
		echo "num_items: " . count($user_array);
		echo "<br />";
		echo $sessionkey;
		
	echo "</pre>";*/
	
	$error_count = 0;
	
	
	
	if($error_count != 0) {
		
		die($error_count . " user(s) not found!");
		
	}
	
?>




<html>
	
	<head>
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		<script type="text/javascript" src="start_session.js"></script>
		<script type="text/javascript" src="time.js"></script>
	</head>
	<body onload="trackTime();">
		
		<p id="top_bar" style="border-bottom: 1px solid black; padding-bottom:5px;"><?php echo "Logged in as <b>" . $user->username . "</b>"; ?><span id="cur_time"></span></p>
		<h1>Confirm New Session</h1>
		
		<div id="participants" style="margin-left: 30px; margin-bottom: 30px;">
			
			The Participants:<br />
			<?php
				
				for($i = 1; $i <= count($user_array); $i++) {
					
					$u_search = $user_array[$i-1];
					
					
					
					$sql = "SELECT * FROM users_waiting WHERE username = '$u_search'";
					
					if($res = $db_user->query($sql)) {
						
						if(!$res->num_rows) {
						
							$error_count++;
							echo "<img src='img/invalidicon.png' width='20' height='20' style='vertical-align: -4px;' />&nbsp;<span style='color:red;'><b>" . $u_search . " --INVALID USERNAME!--</b></span>";
							
						} elseif($u_search == $user->username) {
							
							echo "<img src='img/invalidicon.png' width='20' height='20' style='vertical-align: -4px;' />&nbsp;<span style='color:red;'><b>" . $u_search . " --CAN'T START A SESSION WITH YOUR SELF!--</b></span>";
							$error_count++;
							
						} else {
							
							echo "<img src='img/validicon.png' width='20' height='20' style='vertical-align: -4px;' />&nbsp;<span style='color:green'>" . $u_search . "</span>";
							
						}
						
					} else {
						
						echo "database error! " . $db_user->error;
						
					}
					
					echo "<br />";
					
				}
				
				if($error_count != 0) {
					
					echo "<script type='text/javascript'>setErrorCount($error_count);</script>";
					
				}
				
			?>
			
		</div>
		
		<div id="start" style="margin-left: 30px;margin-top: 30px;">
			
			<label>
				
				Set Session Topic:
				<br />
				<input type="hidden" id="hid_participants" value="<?php echo $q; ?>" />
				<input type="hidden" id="hid_host" value="<?php echo $user->username; ?>" />
				<input type="text" id="txt_topic" />
				<button onclick="start()" type="button" <?php if($error_count != 0) echo "disabled"; ?>>Confirm and Create Session</button>
				<br />
				
			</label>
			
		</div>
		
		
	</body>
	
</html>

















