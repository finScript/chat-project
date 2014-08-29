<?php
	
	session_start();
	if(!isset($_SESSION['user'])) die();
	
	include("info.php");
	require "UserClass.php";
	
	$user = unserialize($_SESSION['user']);
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	$sql = "SELECT * FROM active_chats WHERE chatkey = '" . $user->access_to . "' AND host = '" . $user->username . "'";
	$res = $db->query($sql);
	if($res->num_rows) {
		
		while($row = $res->fetch_object()) {
			
			$sessionname = $row->name;
			$chatkey = $row->chatkey;
			
		}
		
	} else die();
	
?>

<html>
	
	<head>
		
		<title>'<?php echo $sessionname; ?>' Requests</title>
		<link rel="stylesheet" type="text/css" href="../../../global_style.css" />
		<script type="text/javascript" src="handle_request.js"></script>
		<script type="text/javascript" src="../../time.js"></script>
		<script type="text/javascript" src="/jquery.js"></script>
		
	</head>
	
	<body onload="trackTime();">
		
		<p id="top_bar">
			
			Logged in as <b><?php echo $user->username; ?></b> (<a href="/logout">Log Out</a>)
			|
			<img src="../../img/calendar.png" width="20" height="20" style="vertical-align: -4px;" />
			<span id="cur_time"></span>
			
		</p>
		
		<h1>Handle Requests For Session '<?php echo $sessionname; ?>'</h1>
		
		<hr>
		
		<p style="font-size: 20px;">Requests:</p>
		
		<?php
			$sql = "SELECT * FROM requests WHERE chatkey_to = '" . $user->access_to . "'";
			$res = $db->query($sql);
			
			if($res->num_rows) {
				
				echo '<table id="request_table" cellpadding="5" border="1" style="margin-left: 30px; border-spacing: 0px;">';
				
				echo '
				<tr>
				<th>From</th>
				<th>Request ID</th>
				<th></th>
				<th></th>
				</tr>';
				
				$count = 0;
				while($row = $res->fetch_object()) {
					echo "<input type='hidden' id='req_user$count' value='" . $row->user_from . "' />";
					echo "<tr id='req$count'>";
						
						echo "<td>" . $row->user_from . "</td>";
						echo "<td>" . $row->request_id . "</td>";
						echo "
						<td>
							<a href='' onclick='event.preventDefault(); accept($count);'>
							<img src='../../img/validicon.png' widht='20' height='20' style='vertical-align:-4px;' />
							<span style='color: green;'>Accept</span>
							</a>
						</td>";
						echo "
						<td>
							<a href='' onclick='event.preventDefault(); decline($count);'>
							<img src='../../img/invalidicon.png' widht='20' height='20' style='vertical-align:-4px;' />
							<span style='color: darkred;'>Decline</span>
							</a>
						</td>";
						
					echo "</tr>";
					
					$count++;
					
				}
				
				echo "</table>";
				
			} else echo "<div style='margin-left: 30px;'>No requests!</div>";
			
		?>
		<br />
		<a href="" onclick="event.preventDefault(); window.close()" style="color: red;"><img src="../../img/invalidicon.png" width="20" height="20" style="vertical-align: -4px" />&nbsp;Close</a>
		
	</body>
	
</html>



