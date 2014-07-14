<?php
	
	$db = new mysqli('localhost', 'root', '', 'chat');
	$sql = "SELECT * FROM active_chats WHERE host = 'elias.nieminen'";
	$res = $db->query($sql);
	if($res->num_rows) echo $res->fetch_object()->chatkey;
	
?>