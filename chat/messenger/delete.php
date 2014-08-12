<?php

	session_start();
	if(!isset($_SESSION['user'])) die();

	require "UserClass.php";

	$user = unserialize($_SESSION['user']);
	
	
?>

<html>
	<head>
		
		<script type="text/javascript" src="delete.js"></script>
		<script type="text/javascript" src="../time.js"></script>
		<script type="text/javascript" src="../../jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="../../global_style.css" />
		<link rel="icon" type="image/png" href="../../ch.png" />
		
		<style>
			
			#delete_yes {
				
				color: green;
				
			}
			
			#delete_no {
				
				color: darkred;
				
			}
			
			#delete_success {
				
				color: green;
				
			}
			
			#wrapper {
				
				margin-left: 30px;
				margin-top: 30px;
				
			}
			
		</style>
		
	</head>
	<body onload="trackTime(); hideLoaders();">
		
		<p id="top_bar">Logged in as <b><?php echo $user->username; ?></b><span id="cur_time"></span></p>
		
		<h1>Delete Session</h1>
		<hr>
		
		<div id="wrapper">
			<?php
				
				$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "'";
				include('../../info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
				
				if($res = $db->query($sql)) {
					
					if($res->num_rows) {
						
						while($row = $res->fetch_object()) {
							
							?>
							
							<p id="query">
								<input type="hidden" id="hid_key" value="<?php echo $row->chatkey; ?>" />
								Are you sure you want to delete this session: <b><?php echo $row->name; ?></b>
								 | 
								<a href='' onclick="event.preventDefault();deleteSession();" id="delete_yes">
									<img src="../img/validicon.png" width="20" height="20" style="vertical-align: -4px;margin-right: 2px;" />
									Yes
								</a>
								&nbsp;&nbsp;
								<a href='../../chat' id="delete_no">
									<img src="../img/invalidicon.png" width="20" height="20" style="vertical-align: -4px;margin-right: 2px;" />
									No
								</a>
								<img src="../img/loader_gif.gif" id="loader" width="20" height="20"style="vertical-align: -4px;margin-left: 5px;" />
								
							</p>
							
							<?php
							
						}
						
					} else {
						
						echo "<span style='color:red;'>You are not hosting any sessions!</span>";
						
					}
					
				} else {
					
					?>
						
						<p>DB error</p>
						
					<?php
					
				}
				
			?>
			
			<p id="delete_success">Session deleted successfully!<br /><a href="../../chat">Return to Lobby</a></p>
			
			
			
		</div>
	</body>
<html>