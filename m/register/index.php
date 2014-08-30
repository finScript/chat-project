<?php
	
?>

<!doctype html>

<html>
	
	<head>
		
		<meta name="viewport" content="width=device-width">
		
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script type="text/javascript" src="register.js"></script>
		<script type="text/javascript" src="../time.js"></script>
		
	</head>
	
	<body onload="trackTime();">
		
		<div id="wrapper">
			
			<div id="top_bar">
				<span id="cur_time"></span>
			</div>
			
			<h1>Register</h1>
			
			<div class="input_div">
				Username:<br />
				<input type="text" id="txt_username" />
			</div>
			
			<div class="input_div">
				Password:<br />
				<input type="password" id="txt_password" />
			</div>
			
			<div class="input_div">
				Repeat Password:<br />
				<input type="password" id="txt_password_rep" />
			</div>
			
			<div class="input_div">
				Full Name:<br />
				<input type="text" id="txt_fullname" />
			</div>
			
			<div class="input_div">
				Email Address:<br />
				<input type="text" id="txt_email" />
			</div>
			
			<div class="input_div">
				<button type="button" onclick="register()" id="submit">Register</button>
			</div>
			
		</div>
		
	</body>
	
</html>