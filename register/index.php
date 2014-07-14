<?php
	
	session_start();
	
?>

<html>
	
	<head>
		<script type="text/javascript" src="../jquery.js"></script>
		<script type="text/javascript" src="register.js"></script>
		
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		
	</head>
	
	<body onload="hideLoaders();">
		
		<div id="register_success"><p id="lbl_login_success">Registration Successfull!<img src="../login/loader.gif" width="100" height="100" style="vertical-align: -25px;margin-left: 20px;" /></p></div>
		
		<label>
			
			Username:<br />
			<input type="text" id="txt_username" />
			
		</label>
		<br />
		<label>
			
			Password:<br />
			<input type="password" id="txt_pwd" />
			
		</label>
		<br />
		<label>
			
			Repeat Password:<br />
			<input type="password" id="txt_pwd_rep" />
			
		</label>
		<br />
		<label>
			
			Full Name:<br />
			<input type="text" id="txt_fullname"  />
			
		</label>
		<br />
		<label>
			
			Email Address:<br />
			<input type="text" id="txt_email" />
			
		</label>
		<br />
		<button id="registration_button" onclick="register()" type="button">Register</button>
		
		
	</body>
	
</html>