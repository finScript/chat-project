<?php
	
	session_start();
	require "UserClass.php";
	include("info.php");
	
	if(isset($_SESSION['user'])) {
		
		$user = unserialize($_SESSION['user']);
		
	}
	
	$db = new mysqli(_host, _user, _pass, _dbname);
	
?>

<html>
	
	<head>
		
		<meta name="viewport" content="width=device-width">
		
		<script type="text/javascript" src="main.js"></script>
		<script type="text/javascript" src="time.js"></script>
		<script type="text/javascript" src="jquery.js"></script>
		
		<link rel="stylesheet" type="text/css" href="style.css" />
		
		<script type="text/javascript">
			
			function _(el) { return document.getElementById(el); }
			
		</script>
		
	</head>
	
	<body onload="trackTime();">
		
		<div id="hidden_menu">
			<div class="hidden_menu_item menu_control">
				<a href="" onclick="event.preventDefault(); closeMenu();"><img src="chat/img/menu_open.png" id="btn_menu_close" /></a>
			</div>
			
			<div class="hidden_menu_item">
				&nbsp;&nbsp;<a href="chat">Chat Lobby</a>
			</div>
			
			<div class="hidden_menu_item">
				&nbsp;&nbsp;<a href="chat">New Session...</a>
			</div>
			
			<div class="hidden_menu_item">
				&nbsp;&nbsp;<a href="chat">Log Out</a>
			</div>
			
		</div>
		
		<div id="wrapper">
			
			<div id="top_bar">
				
				<?php if(!isset($user)): ?>
					
					<a href="login">Log In</a>
					|
					<a href="register">Register</a>
					
				<?php else: ?>
					
					<span>Logged in as <b><?php echo $user->username; ?></b> (<a href="logout">Log Out</a>)</span>
					
				<?php endif; ?>
				<br />
				<span id="cur_time"></span>
				
			</div>
			
			<div id="content">
				
				<h1>
					<a href="" onclick="event.preventDefault(); openMenu();"><img src="chat/img/menu_open.png" height="50" width="50" style="vertical-align: -12px;" /></a>
					Chat Hole
				</h1>
				
				<?php if(!isset($user)): ?>
					<p>Please <a href="login">Log In</a> or <a href="register">Register</a> to start chatting.</p>
				<?php else: ?>
					<div class="activity" id="invites">
						
						<?php
							
							$sql = "SELECT * FROM invites WHERE username = '" . $user->username . "'";
							$res = $db->query($sql);
							
							if($res->num_rows) {
								
								$invite_array = [];
								while($row = $res->fetch_object()) {
									
									$chatkey = $row->chatkey;
									$num_participants = $db->query("SELECT * FROM participants WHERE chatkey = '$chatkey'")->num_rows;
									
									$sql = "SELECT * FROM active_chats WHERE chatkey = '$chatkey'";
									$res2 = $db->query($sql);
									
									while($row2 = $res2->fetch_object()) {
										
										array_push($invite_array, [
											
											"host" => $row2->host,
											"name" => $row2->name,
											"participants" => $num_participants,
											"chatkey" => $chatkey,
											
										]);
										
									}
									
								}
								
								$img_enter = '<img src="../chat/img/arrow_right.png" width="30" height="30" style="vertical-align: -8px;" />';
								$img_dec = '<img src="../chat/img/invalidicon.png" width="30" height="30" style="vertical-align: -8px;" />';
								
								foreach($invite_array as $i):?>
									
									<div class="invitation">
										
										<span style="font-size: 20px;">Session Name: <b><?php echo $i['name']; ?></b></span><br />
										&nbsp;&nbsp;&nbsp;&nbsp;
										<span>Host: <b><?php echo $i['host']; ?></b></span><br />
										&nbsp;&nbsp;&nbsp;&nbsp;
										<span>Active People: <b><?php echo $i['participants']; ?></b></span><br />
										&nbsp;&nbsp;&nbsp;&nbsp;
										<span>
											Actions:
											<a href="chat/messenger/request.php?host=<?php echo $i['host']; ?>"><?php echo $img_enter; ?></a>
											<a href="chat/messenger/decline.php?host=<?php echo $i['host']; ?>"><?php echo $img_dec; ?></a>
										</span>
										
									</div>
									
								<?php endforeach;
								
							} else {
								
								?>
								
								<p>You have no invitations at this moment.</p>
								
								<?php
								
							}
						
						?>
					</div>
					<div class="activity" id="hosting">
						
						<?php
							
							$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "'";
							$res = $db->query($sql);
							
							if($res->num_rows) {
								
								$session_array = [];
								while($row = $res->fetch_object()) {
									
									$chatkey = $row->chatkey;
									$num_participants = $db->query("SELECT * FROM participants WHERE chatkey = '$chatkey'")->num_rows;
									
									$sql = "SELECT * FROM active_chats WHERE chatkey = '$chatkey'";
									$res2 = $db->query($sql);
									
									while($row2 = $res2->fetch_object()) {
										
										array_push($session_array, [
											
											"name" => $row2->name,
											
										]);
										
									}
									
								}
								
								$img_enter = '<img src="chat/img/arrow_right.png" width="30" height="30" style="vertical-align: -8px;" />';
								$img_dec = '<img src="chat/img/invalidicon.png" width="30" height="30" style="vertical-align: -8px;" />';
								
								foreach($session_array as $i):?>
									
									<div class="invitation">
										
										<span style="font-size: 20px;">Session Name: <b><?php echo $i['name']; ?></b></span><br />
										&nbsp;&nbsp;&nbsp;&nbsp;
										<span>
											Actions:
											<a href="chat/messenger/"><?php echo $img_enter; ?></a>
											<a href="chat/messenger/delete.php"><?php echo $img_dec; ?></a>
										</span>
										
									</div>
									
								<?php endforeach;
								
							} else {
								
								?>
								
								<p>You aren't hosting any sessions at this time</p>
								
								<?php
								
							}
						
						?>
						
					</div>
					<div class="activity" id="participating">
						
						<p>Under Construction</p>
						
					</div>
				<?php endif; ?>
				
			</div>
			
		</div>
		
	</body>
	
</html>




















