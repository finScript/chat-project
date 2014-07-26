<?php
	
	include('../../info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
	$sql = "SELECT * FROM active_chats WHERE host = 'elias.nieminen'";
	$res = $db->query($sql);
	if($res->num_rows) echo $res->fetch_object()->chatkey;
	
?>