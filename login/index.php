<?php
	
	session_start();
	
	if(isset($_SESSION['user'])) header("location: ../");
?>

<html>

	<head>
		
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script type="text/javascript" src="../jquery.js"></script>
		<script type="text/javascript" src="../chat/time.js"></script>
		<script type="text/javascript" src="login.js"></script>
		
	</head>
	<body onload="hideLoaders(); trackTime();">
		
		<div id="login_success"><p id="lbl_login_success">Login Successfull!<img src="loader.gif" width="100" height="100" style="vertical-align: -25px;margin-left: 20px;" /></p></div>
		
		<p id="top_bar">
			
			<a href="../register">Register</a>
			|
			<img src="../chat/img/calendar.png" width="20" height="20" style="vertical-align: -4px;" />&nbsp;<span id="cur_time"></span>
			
		</p>
		<h1>Log In</h1>
			
			<hr>
		<div id="wrapper">
			
			
			
			
			<label>
				
				Username or Email Address:<br />
				<input type="text" id="txt_username_email" class="u_inp" autofocus />
				<br />
				
			</label>
		
			<label>
				
				Password:<br />
				<input type="password" id="txt_password" onkeyup="checkEnter(event)" class="u_inp" />
				<br />
				
			</label>
			
			<button class="cancel_button" onclick="window.location = '..'">Cancel</button>
			<button class="login_button" type="button" onclick="login()">Login</button>
		
		</div>
		
	
	</body>
	

</html>