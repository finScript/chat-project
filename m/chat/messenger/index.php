<?php
	
	session_start();
	require "UserClass.php";
	
	if(!isset($_SESSION['user'])) {
		
		header("location: ../../login");
		die();
	
	}
	
	$_SESSION['latest_e'] = 0;
	$_SESSION['latest_m'] = 0;
	$_SESSION['latest_r'] = 0;
	
	$user = unserialize($_SESSION['user']);
	include('../../info.php');
	$db = new mysqli(_host, _user, _pass, _dbname);
	if(!isset($user->access_to)) {
		header("location: access_to.php?k=" . getKey($db, $user));
		die();
	}
	
	
	
	
	function getKey($database, $u) {
		
		$res = $database->query("SELECT * FROM participants WHERE username = '" . $u->username . "'");
		
		if($res->num_rows) {
		
			$chatkey;
			
			while($row = $res->fetch_object()) {
				
				$chatkey = $row->chatkey;
				
			}
			
			return $chatkey;
		
		} else {
			
			$res = $database->query("SELECT * FROM active_chats WHERE host = '" . $u->username . "'");
			
			if($res->num_rows) {
				
				$chatkey;
				
				while($row = $res->fetch_object()) {
					
					$chatkey = $row->chatkey;
					
				}
				
				return $chatkey;
				
			} else {
				
				header("location: ../../chat");
				die();
				
				
			}
			
			
			
		}
	}
	
	
	
	
	
?>

<html>
	
	<head>
		
		<meta name="viewport" content="width=device-width">
		
		<title>
			
			Messenger - Chat Hole
			
		</title>
		
		<link rel="stylesheet" type="text/css" href="../../global_style.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="icon" type="image/png" href="../../ch.png" />
		
		<script type="text/javascript" src="messenger.js"></script>
		<script type="text/javascript" src="host_actions.js"></script>
		<script type="text/javascript" src="file_upload.js"></script>
		<script type="text/javascript" src="../time.js"></script>
		<script type="text/javascript" src="../../jquery.js"></script>
		
		<script type="text/javascript">
			
			window.addEventListener("load", function() {
				
				$("#page_loading").fadeOut(1000);
				
			});
			
		</script>
		
	</head>
	
	<body onload="trackTime(); inpSendText(1); hideLoaders(); hideFileSelect(); setTimeout('handleMessages();', 500);">
		
		<div id="page_loading">
			<div id="loading"><img src="../img/loader.gif" width="100" height="100" style="vertical-align: -40px"/>&nbsp;Loading Messenger...</div>
		</div>
		
		<audio id="notification" src="audio/notification.wav" type="audio/wav"></audio>
		
		<input type="hidden" id="hidden_username" value="<?php echo $user->username; ?>" />
		
		<div id="request">
			
			<div id="request_wrapper">
				<span style="font-size: 30px;">There are <span id="num_req">0</span> joining requests waiting for handling.</span>
				<br />
				<br />
				<a href="requests">Handle Requests</a> | <a href="" onclick="event.preventDefault(); $('#request').slideUp();">Hide</a>
			</div>
			
		</div>
		
		<p id="top_bar">Logged in as <b><?php echo $user->username; ?></b> (<a href='../../logout'>Log out</a>)
			|
			<a href="../../">Home</a>
			|
			<a href="..">Lobby</a>
			|
			<img src="../img/calendar.png" width="20" height="20" style="vertical-align: -4px;" />&nbsp;<span id="cur_time"></span>
			
		</p>
		
		<div id="wrapper">
			
			<h1 id="session_header">
				<?php 
					$res = $db->query("SELECT * FROM active_chats WHERE chatkey = '" . $user->access_to . "'");
					$session_name;
					$session_host;
					while($row = $res->fetch_object()) {
						
						echo $row->name . " - Messenger";
						$session_name = $row->name;
						$session_host = $row->host;
						
					}
				?>
			</h1>
			
			<input type="hidden" id="hidden_session_name" value="<?php echo $session_name; ?>" />
			<input type="hidden" id="hidden_session_name_new" value="" />
			
			<hr>
			<div id="event_area" style="float:right;"><h4>Events:</h4></div>
			
			
			<div id="msg_area">
				
				<?php
				
					$sql = "SELECT * FROM active_chats WHERE host = '" . $user->username . "'";
					$res = $db->query($sql);
					
					if($res->num_rows) {
						
						?>
						
						<div id="host_actions">
							

							<label><b>Host actions:</b></label>&nbsp;
							<a href="" onclick="event.preventDefault(); initAction('kick');" id="kick_user">
							
								<img src="../img/yellowcross.png" width="23" height="23" style="vertical-align: -5px;" />
								Kick User
								
							</a>
							|
							<a href="" onclick="event.preventDefault(); initAction('invite');" id="invite_user">
								
								<img src="../img/inviteicon.png" width="25" height="25" style="vertical-align: -7px;" />
								Invite User
								
							</a>
							|
							<a href="" id="invite_user" onclick="event.preventDefault(); openRequests();" style="color: ">
								
								<img src="../img/requests.png" width="25" height="25" style="vertical-align: -7px;" />
								See Requests
								
							</a>
							|
							<a href="" onclick="event.preventDefault(); initAction('rename');" id="rename_session">
								
								<img src="../img/rename.png" width="20" height="20" style="vertical-align: -4px;" />
								Rename Session
								
							</a>
							|
							<a href="" onclick="event.preventDefault(); initAction('hosts');" id="switch_hosts">
								
								<img src="../img/reload.png" width="20" height="20" style="vertical-align: -4px;" />
								Switch Hosts
								
							</a>
							|
							<a href="" onclick="event.preventDefault(); initAction('end');" id="end_session">
								
								<img src="../img/invalidicon.png" width="20" height="20" style="vertical-align: -4px;" />
								End Session
								
							</a>
							
							<div id="kick_user_inp">
							
								<label>Enter username: <input type="text" id="txt_kick_user" /></label>
								
								<button type="button" onclick="kickUser()">Go</button>
								
								<img class="hideAction" src="../img/arrowup.png" width="20" height="20" style="vertical-align: -4px;" onclick="hideAction(0);" />
								
								<img src="../img/loader_gif.gif" width="20" height="20" style="vertical-align: -4px;" id="loader_0" />
								
							</div>
							<div id="invite_user_inp">
							
								<label>Enter username: <input type="text" id="txt_invite_user" /></label>
								
								<button type="button" onclick="inviteUser()">Go</button>
								
								<img class="hideAction" src="../img/arrowup.png" width="20" height="20" style="vertical-align: -4px;" onclick="hideAction(1);" />
								
								<img src="../img/loader_gif.gif" width="20" height="20" style="vertical-align: -4px;" id="loader_1" />
								
							</div>
							<div id="rename_session_inp">
							
								<label>Enter name: <input type="text" id="txt_rename_session" /></label>
								
								<button type="button" onclick="renameSession()">Go</button>
								
								<img class="hideAction" src="../img/arrowup.png" width="20" height="20" style="vertical-align: -4px;" onclick="hideAction(2);" />
								
								<img src="../img/loader_gif.gif" width="20" height="20" style="vertical-align: -4px;" id="loader_2" />
								
							</div>
							<div id="switch_hosts_inp">
							
								<label>Enter username (must be participating this session!): <input type="text" id="txt_new_host" /></label>
								
								<button type="button" onclick="switchHosts()">Go</button>
								
								<img class="hideAction" src="../img/arrowup.png" width="20" height="20" style="vertical-align: -4px;" onclick="hideAction(3);" />
								
								<img src="../img/loader_gif.gif" width="20" height="20" style="vertical-align: -4px;" id="loader_3" />
								
							</div>
							<div id="end_session_inp">
							
								<label>Enter your password: <input type="password" id="txt_end_session_pwd" /></label>
								
								<button type="button" onclick="endSession()">Go</button>
								
								<img class="hideAction" src="../img/arrowup.png" width="20" height="20" style="vertical-align: -4px;" onclick="hideAction(4);" />
								
								<img src="../img/loader_gif.gif" width="20" height="20" style="vertical-align: -4px;" id="loader_4" />
								
							</div>
							
							
						</div>
						
						
						<?php
						
					} else {
						echo "<div style='margin-top: 15px;'>Host: <b>$session_host</b></div>";
					}
					//moro
				
					
					
					
				?>
				
				
				
				<div id="welcome">
					
					<label>&#62;&#62;Welcome, <?php echo $user->username; ?>! 
						<b>
							<?php
								
								$sql = "SELECT * FROM participants WHERE chatkey = '" . getKey($db, $user) . "' AND username !='" . $user->username . "'";
								
								if($res = $db->query($sql)) {
								
									if($res->num_rows) {
										
										echo "You are now chatting with ";
										
										$numr = $res->num_rows;
										
										$count = 0;
										$usercount = 0;
										
										while($row = $res->fetch_object()) {
											
											if($row->username != $user->username) {
												echo $row->username;
												$usercount++;
											} else continue;
											
											
											
											if($numr == 2 and $count == 0) echo " and ";
											elseif($count < $numr-1) echo ", ";
											elseif($numr == 2 and $count == 1) echo "";
											elseif($numr == 1) echo "";
											else echo " and ";
											
											$count++;
											
											
											
											
										}
									} else {
										
										$sql = "SELECT * FROM active_chats WHERE chatkey = '" . getKey($db, $user) . "' AND host != '" . $user->username . "'";
										
										if($res = $db->query($sql)) {
											
											if($res->num_rows) {
												
												while($row = $res->fetch_object()) {
													
													echo "You are now chatting with " . $row->host;
													
												}
												
											} else {
												
												echo "There are no other people currently active!";
												
											}
											
										} else {
											
											echo "db error: " . $db->error;
											
										}
										
										
										
									}
								} else {
									
									echo "db error: " . $db->error;
									
								}
								
								
							?>
						</b>
					</label>
				</div>
				
				
			</div>
			
			<div id="send_area">
				
				<input type="text" id="txt_message" autocomplete="off" onfocus="inpSendText(0);" onfocusout="inpSendText(1);" onkeyup="checkEnterSend(event);" />
				<button onclick="sendMessage()" type="button" id="btn_send">Send</button><br />
				<a href="" onclick="event.preventDefault();selectFile();"><img src="../img/file_black.png" width="40" height="40" style="vertical-align: -12px" title="Send file" /></a>
				
			</div>
			
			<form id="fileform" name="fileform" enctype="multipart/form-data" method="POST">
				
				<input type="file" id="file_send" name="file_send" onchange="sendFile();" />
				
			</form>
			
			<div id="dev_area" style="display:none;">
				<button onclick="testFunc()" type="button">Test</button>
				<input type="checkbox" onchange="setAllowed();" id="debug_enabled" checked /><label id="allowcheckbox" for="debug_enabled">enabled</label>
				<span id="output"></span>
				<br />
				<span id="loaded_n_total"></span>
			</div>
			
		</div>
		
		
		
	</body>
	
</html>











