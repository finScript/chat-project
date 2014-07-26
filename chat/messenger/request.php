<?php
	
	session_start();
	if(!isset($_SESSION['user'])) die("Unauthorized access!");
	if(!isset($_GET['host'])) die("Vars not set");
	
	require "UserClass.php";
	
	$user = unserialize($_SESSION['user']);
	include('../../info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
	$sessionname;
	$sessionkey;
	
	$sql = "SELECT * FROM active_chats WHERE host = '" . $_GET['host'] . "'";
	if($res = $db->query($sql)) {
		
		if($res->num_rows) {
			
			while($row = $res->fetch_object()) {
				
				$sessionname = $row->name;
				$sessionkey = $row->chatkey;
				
			}
			
		} else {
			
			die();
			
		}
		
	} else echo "An error occurred: " . $db->error;
	
?>

<html>
	
	<head>
		
		<link rel="stylesheet" type="text/css" href="../../global_style.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script type="text/javascript" src="../time.js"></script>
		<script type="text/javascript" src="request.js"></script>
		<script type="text/javascript" src="../../jquery.js"></script>
		
		
	</head>
	
	<body>
		<input type="hidden" id="hid_host" value="<?php echo $_GET['host'] ?>" />
		<p id="top_bar">Logged in as <b><?php echo $user->username; ?></b> (<a href='../../logout'>Log out</a>)
			 | 
			<img src="../img/calendar.png" width="20" height="20" style="vertical-align: -4px;" />&nbsp;<span id="cur_time"></span>
			
		</p>
		
		<h1>Request Joining</h1>
		
		<hr>
		
		<div id="wrapper" style="margin-left: 30px;margin-top: 30px;">
			
			<p id="confirm">
				
				Do you want to request joining to this chat session: <b><?php echo $sessionname; ?></b>?
				<a href="" onclick="event.preventDefault(); sendRequest();" style="color: green">
					<img src="../img/validicon.png" width="20" height="20" style="vertical-align: -4px;" />
					Yes
				</a>
				&nbsp;
				<a href="../../chat" style="color: darkred">
					<img src="../img/invalidicon.png" width="20" height="20" style="vertical-align: -4px;" />
					No
				</a>
				
				&nbsp;
				<img src="../img/loader_gif.gif" id="loader" width="20" height="20" style="vertical-align: -4px" />
				
			</p>
			
			<p id="result">
				
				<span id="res_message">You request has been sent successfully! You will be notified if your request gets accepted.</span>
				<br />
				<a href="../">&#60;&#60; Return</a>
				
			</p>
			
		</div>
		
	</body>
	
</html>
















