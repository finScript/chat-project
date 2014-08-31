<?php
	
	session_start();
	
	if(isset($_SESSION['user'])) header("location: ../");
?>

<html>

	<head>
		
		<title>Log In</title>
		
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="icon" type="image/png" href="../ch.png" />
		
		<script type="text/javascript" src="../jquery.js"></script>
		<script type="text/javascript" src="../chat/time.js"></script>
		<script type="text/javascript" src="login.js"></script>
		
	</head>
	<body onload="hideLoaders(); trackTime();">
		
		
		<div id="wrapper">
		
			
			
			<p id="top_bar">
				
				<a href="../register">Register</a>
				|
				<a href="../">Home</a>
				<span id="cur_time"></span>
				
			</p>
			<h1>Log In</h1>
			
			<hr>
			
			<div id="login_area">
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
			
			<div id="login_success">
				
				<img src="loader.gif" width="50" height="50" style="vertical-align: -19px;" />
				Log in successful!
				
			</div>
			
		</div>
		<div id="footer">
			&copy;2014 Elias Nieminen
		</div>
		
	</body>
	

</html>