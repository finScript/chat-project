<?php
	session_start();
	
	if(!isset($_SESSION['user'])) { header("location: ../login"); die(); }
	
	require "UserClass.php";
	$user = unserialize($_SESSION['user']);
	
?>

<html>
	
	<head>
		
		<title>Chat Lobby</title>
		
		<script type="text/javascript" src="lobby.js"></script>
		<!--<script type="text/javascript" src="refresh_sessions.js"></script>-->
		<script type="text/javascript" src="time.js"></script>
		<script type="text/javascript" src="../jquery.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		<link rel="icon" type="image/png" href="../ch.png" />
		
	</head>
	
	<body onload="hideLoaders(); refreshSessions(); trackTime();">
		
		<input type="hidden" id="hid_username" value="<?php echo $user->username; ?>" />
		
		<p id="top_bar">
			
			<label>
				
				Logged in as <b><?php echo $user->username; ?></b> (<a href="../logout">Log out</a>)
				|
				<a href="../">Home</a>
				|
				<a href="messenger">Messenger</a>
				|
				<img src='img/calendar.png' width='20' height='20' style='vertical-align: -4px;' />
				<span id="cur_time"></span>
				
			</label>
			
		</p>
		
		<div id="wrapper">
			<h1>Chat Lobby</h1>
			<hr>
			<br />
			<div id="chat_enter">
				
				<label>
					
					Enter a session key (received by chat host):
					<input type="text" id="txt_sessionkey" onkeyup="checkKey()" style="width: 300px;" /><button id="sessionkey_button" onclick="enterChat()" type="button" disabled>Enter</button>
					<img src="img/loader_gif.gif" width="20" height="20" id="loader_gif_enter" style="vertical-align: -5px;" />
					<span id="key_status"></span>
					
				</label>
				
			</div>
			
			<hr>
			
			<div id="chat_active">
				
				<h3>Active chats: <a href="" onclick="event.preventDefault(); refreshSessions();"><img src="img/reload.png" width="20" height="20" style="vertical-align: -5px;" id="refresh_icon"/></a></h3>
				<div id="chat_active_subsect">
					<p id="searching">
						Searching sessions... <img src="img/loader_gif.gif" width="20" height="20" id="loader_gif_session" style="vertical-align: -5px;" />
					</p>
					
					<table cellpadding="10" border="1" id="session_table">
						
						<tr>
							
							<th>
								<label>Session Name</label>
							</th>
							
							<th>
								<label>Participants</label>
							</th>
							
							<th>
								<label>Host</label>
							</th>
							
							<th>
								
							</th>
						</tr>
						
						
						
					</table>
					
				</div>
				
			</div>
			
			<hr>
			
			<div id="chat_start">
				
				<h3>Start a new session:</h3>
				<label id="chat_start_subsect">
					
					Enter the participants (separated by comma <code>&#60;&#44;&#62;</code>): <input type="text" id="txt_participants" onkeyup="checkOwnUsername()" />
					<button id="btn_start_session" onclick="startSession()" type="button" disabled>Start</button>
					
				</label>
				
			</div>
			
			<hr>
			
			<footer>Chat | &copy;2014 Elias Nieminen</footer>
			
		</div>
		
	</body>
	
</html>






