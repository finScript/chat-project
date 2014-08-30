<?php
	session_start();
	if(isset($_SESSION['user'])) {
		
		header("location: ..");
		die();
		
	}
?>

<!doctype html>

<html>
	
	<head>
		
		<meta name="viewport" content="width=device-width">
		
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script type="text/javascript" src="login.js"></script>
		<script type="text/javascript" src="../time.js"></script>
		
	</head>
	
	<body onload="trackTime();">
		
		<div id="wrapper">
			
			<div id="top_bar">
				<span id="cur_time"></span>
			</div>
			
			<div class="input_div">
				Username:<br />
				<input type="text" id="txt_username_email" />
			</div>
			
			<div class="input_div">
				Password:<br />
				<input type="password" id="txt_password" />
			</div>
			
			<div class="input_div">
				<button type="button" onclick="login();" id="submit">Log In</button>
			</div>
			
		</div>
		
	</body>
	
</html>