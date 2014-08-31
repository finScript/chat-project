<?php
	
	session_start();
	
	require "UserClass.php";
	include("../../info.php");
	
	if(!isset($_SESSION['user'])) {
		
		header("location: ../..");
		die();
		
	}
	
	$user = unserialize($_SESSION['user']);
	$db = new mysqli(_host, _user, _pass, _dbname);

	
?>

<html>
	
	<head>
		
		<link rel="stylesheet" type="text/css" href="../../global_style.css" />
		<link rel="icon" type="image/png" href="../../ch.png" />
		
		<script type="text/javascript" src="../../jquery.js"></script>
		<script type="text/javascript" src="leave.js"></script>
		<script type="text/javascript" src="../time.js"></script>
		
		<style>
			
			.buttons {
				
				border: 1px solid grey;
				background-color: D6D6D6;
				box-shadow: 2px 2px 2px #888888;
				padding: 30px;
				margin: 20px auto;
				width: 50%;
				text-align: center;
				
			}
			
			.buttons a {
				
				margin: 10px;
				
			}
			
		</style>
		
	</head>
	<body onload="trackTime();">
		
		<div id="wrapper">
			
			<p id="top_bar">
				
				Logged in as <b><?php echo $user->username; ?></b> (<a href="../../logout">Log Out</a>)
				|
				<a href="../..">Home</a>
				|
				<a href="../">Chat Lobby</a>
				|
				<a href="../messenger">Messenger</a>
				<span id="cur_time"></span>
				
			</p>
			
			<h1>Leave Session</h1>
			<hr>
			
			<?php
				
				$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "'";
				$res = $db->query($sql);
				
				if($res->num_rows) {
					
					while($row = $res->fetch_object()) {
						
						$session_name = $row->name;
						$chatkey = $row->chatkey;
						
					}
					
					?>
					
					<div class="leave_confirm">
						
						You are hosting this session: <b><?php echo $session_name; ?></b>. Therefore it will be ended if you leave. Are you sure you want to leave?<br /><br />
						<div class="buttons">
							<a href="" onclick="event.preventDefault();confirmLeave();" class="btn_enter">Yes, leave <img src="../img/validicon.png" width="20" height="20" style="vertical-align: -4px" /></a>
							<a href="" onclick="event.preventDefault();confirmLeave();" class="btn_delete">No, stay <img src="../img/invalidicon.png" width="20" height="20" style="vertical-align: -4px" /></a>
						</div>
						
					</div>
					
					<?php
					
				} else {
					
					$sql = "SELECT * FROM participants WHERE username = '" . $user->username . "'";
					$res = $db->query($sql);
					
					if($res->num_rows) {
						
						
						
					} else {
						
						?>
							
							<div class="buttons">
								
								You are not participating to any session.
								
							</div>
							
						<?php
						
					}
					
				}
				
			?>
			
		</div>
		
	</body>
	
</html>























