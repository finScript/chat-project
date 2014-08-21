<?php
	
	session_start();
	
	if(isset($_SESSION['user'])) header("location: ../");
	
?>

<html>
	
	<head>
		
		<title>Register</title>
		
		<script type="text/javascript" src="../jquery.js"></script>
		<script type="text/javascript" src="../chat/time.js"></script>
		<script type="text/javascript" src="register.js"></script>
		
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="icon" type="iamge/png" href="../ch.png" />
		
		
	</head>
	
	<body onload="hideLoaders(); trackTime();">
		
		<div id="register_success"><p id="lbl_login_success">Registration Successfull!<img src="../login/loader.gif" width="100" height="100" style="vertical-align: -25px;margin-left: 20px;" /></p></div>
		
		<div id="top_bar">
			
			<a href="../login">Log In</a>
			|
			<a href="../">Home</a>
			|
			<img src="../chat/img/calendar.png" width="20" height="20" style="vertical-align: -4px;" />&nbsp;<span id="cur_time"></span>
			
		</div>
		
		<h1>Register</h1>
		
		<hr>
		
		<div id="wrapper">
		
			<label>
				
				Username:<br />
				<input class="u_inp" type="text" id="txt_username" />
				
			</label>
			<br />
			<label>
				
				Password:<br />
				<input class="u_inp" type="password" id="txt_pwd" />
				
			</label>
			<br />
			<label>
				
				Repeat Password:<br />
				<input class="u_inp" type="password" id="txt_pwd_rep" />
				
			</label>
			<br />
			<label>
				
				Full Name:<br />
				<input class="u_inp" type="text" id="txt_fullname"  />
				
			</label>
			<br />
			<label>
				
				Email Address:<br />
				<input class="u_inp" type="text" id="txt_email" />
				
			</label>
			<br />
			<button class="cancel_button" onclick="window.location = '..'">Cancel</button>
			<button class="login_button" type="button" onclick="register()">Register</button>
			
		</div>
		
		
	</body>
	
</html>