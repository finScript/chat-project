<?php
	
	session_start();
	
	
?>

<html>

	<head>
		
		<link rel="stylesheet" type="text/css" href="../global_style.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script type="text/javascript" src="../jquery.js"></script>
		<script type="text/javascript" src="login.js"></script>
		
	</head>
	<body onload="hideLoaders()">
		
		<div id="login_success"><p id="lbl_login_success">Login Successfull!<img src="loader.gif" width="100" height="100" style="vertical-align: -25px;margin-left: 20px;" /></p></div>
		
		<label>
			
			Username or Email Address:<br />
			<input type="text" id="txt_username_email" autofocus />
			<br />
			
		</label>
	
		<label>
			
			Password:<br />
			<input type="password" id="txt_password" onkeyup="checkEnter(event)" />
			<br />
			
		</label>
	
		<button type="button" onclick="login()">Login</button>
	
	</body>
	

</html>