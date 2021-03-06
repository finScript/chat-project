<?php
	
	session_start();
	require "UserClass.php";
	
?>

<html>
	<head>
		
		<title>Chat Hole</title>
		
		<link rel="stylesheet" type="text/css" href="global_style.css" />
		<link rel="stylesheet" type="text/css" href="local_style.css" />
		<link rel="icon" type="image/png" href="ch.png" />
		
		<script type="text/javascript" src="chat/time.js"></script>
		<script type="text/javascript">
			
			function trackTime() {
				
				document.getElementById("cur_time").innerHTML = getT();
				setTimeout('trackTime()', 1000);
				
			}
			
		</script>
		
	</head>
		
	<body onload="trackTime();">
		<div id="wrapper">
		<?php
			
			$user;
			if(isset($_SESSION['user'])) {
				
				$user = unserialize($_SESSION['user']);
				echo "<p id='top_bar'>Logged in as <b>" . $user->username . "</b> (<a href='logout'>Log out</a>) | <a href='chat'>Chat Lobby</a>
				<span id='cur_time'></span></p>";
				
			} else {
				
				echo "<p id='top_bar'><a href='login'>Log In</a> | <a href='register'>Register</a>
				<span id='cur_time'></span></p>";
				
			}
			
			?>
			
			<h1>Chat Hole - Home</h1>
			<hr>
			
			
			
			<?php
			
			if(isset($_SESSION['user'])) {
				
				echo "<div id='invites'>";
				
				$sql = "SELECT * FROM invites WHERE username = '" . $user->username . "'";
				include("info.php");
				$db = new mysqli(_host, _user, _pass, _dbname);
				$res = $db->query($sql);
				
				echo "<h3><img src='chat/img/invites.png' width='40' height='40' style='vertical-align: -8px;' />&nbsp;&nbsp;Invitations:</h3>";
				
				if($res->num_rows) {
					
					
					
					echo "You have been invited to following chat sessions:";
					
					echo "<table cellpadding='10' border='1' id='invite_table'>";
					
					echo "<tr>";
						
						echo "<th>Session Name</th>";
						echo "<th>Session Host</th>";
						echo "<th>People</th>";
						echo "<th class='centered'>Action</th>";
						
					echo "</tr>";
					
					while($row = $res->fetch_object()) {
						
						$chatkey = $row->chatkey;
						
						$sql_2 = "SELECT * FROM active_chats WHERE chatkey = '$chatkey'";
						
						$res_2 = $db->query($sql_2);
						$session_name;
						$session_host;
						$session_participants;
						
						while($row_2 = $res_2->fetch_object()) {
							
							$session_name = $row_2->name;
							$session_host = $row_2->host;
							$session_participants = $db->query("SELECT * FROM participants WHERE chatkey = '$chatkey'")->num_rows;
							
						}
						
						echo "<tr>";
							
							echo "<td>" . $session_name . "</td>";
							echo "<td>" . $session_host . "</td>";
							echo "<td>" . $session_participants . "</td>";
							echo "<td class='centered'><a href='chat/messenger/'><b><a href='chat/messenger/request.php?host=$session_host' class='btn_enter'>
							Accept&nbsp;<img src='chat/img/arrow_right.png' width='20' height='20' style='vertical-align:-4px;' /></a>
							&nbsp;
							<a href='chat/messenger/decline.php?host=$session_host' class='btn_delete'>
							Decline&nbsp;<img src='chat/img/invalidicon.png' width='20' height='20' style='vertical-align:-4px;' /></a>
							</b></a></td>";
							
						echo "</tr>";
						
					}
					
					echo "</table><br/><br/><hr>";
					
					
					
				} else echo "You have not been invited to any chat sessions.<br/><br/><hr>";
				
				
				$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "'";
				$res = $db->query($sql);
				
				echo "<h3><img src='chat/img/hostings.png' width='40' height='40' style='vertical-align: -8px;' />&nbsp;Hostings:</h3>";
					
				if($res->num_rows) {
					
					while($row = $res->fetch_object()) {
						echo "You are hosting the following session: <b>";
						echo $row->name . " -
							
							<a href='chat/messenger/' class='btn_enter'>Enter&nbsp;<img src='chat/img/arrow_right.png' width='20' height='20' style='vertical-align:-4px;' /></a>
							<a href='chat/messenger/delete.php' class='btn_delete'>Delete&nbsp;<img src='chat/img/invalidicon.png' width='20' height='20' style='vertical-align:-4px;' /></a>
							
							
						</b><br/><br/><hr>";
						
					}
					
				} else echo "You are not hosting any session.<br/><br/><hr>";
				
				$sql = "SELECT * FROM participants WHERE username = '" . $user->username . "'";
				$res = $db->query($sql);
				
				echo "<h3><img src='chat/img/participant.png' width='40' height='40' style='vertical-align: -8px;' />&nbsp;Participations:</h3>";
				
				if($res->num_rows) {
					
					while($row = $res->fetch_object()) {
						
						echo "You are participating to following chat session: <b>";
						
						$sql_2 = "SELECT * FROM active_chats WHERE chatkey = '" . $row->chatkey . "'";
						$res_2 = $db->query($sql_2);
						
						while($row_2 = $res_2->fetch_object()) {
							
							echo $row_2->name . "
								
								<a href='chat/messenger/' class='btn_enter'>Enter <img src='chat/img/arrow_right.png' width='20' height='20' style='vertical-align:-4px;' /></a>
								<a href='chat/messenger/leave.php' class='btn_delete'>Leave <img src='chat/img/invalidicon.png' width='20' height='20' style='vertical-align:-4px;' /></a>
								
							";
							
						}
						
						echo "</b>";
						
					}
					
				} else echo "You are not participating to any chat session.";
				
				echo "</div>";
			
			} else {
				?>
				
				<p>Please <b><a href="login">Log In</a></b> or <b><a href="register">Register</a></b> to start chatting!</p>
				
				<?php
			}
		
		
		?>
		
		
		
		</div>
		<div id="footer">
			&copy;2014 Elias Nieminen
		</div>
	</body>

</html>












