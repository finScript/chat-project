<?php
	
	session_start();
	
	include("../../info.php");
	require "UserClass.php";
	
	if(!isset($_SESSION['user'])) die();
	
	$user = unserialize($_SESSION['user']);
	$db = new mysqli(_host, _user, _pass, _dbname);
	
	
	if(isset($_FILES['f']))
		$f = $_FILES['f'];
	else
		die("No file");
	
	$file_name = $f['name'];
	$file_uniq_name = rand_name() . $file_name;
	$file_tmp_name = $f['tmp_name'];
	$file_size = $f['size'];
	$file_type = $f['type'];
	
	$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
	
	if($ext == "png" or $ext == "gif" or $ext == "jpg" or $ext == "jpeg") $m_type = "image";
	else $m_type = "file";
	
	$t = date('H') . ":" . date('i') . ":" . date('s');
	$d = date('Y') . " " . date('F') . " " . date('d');
	
	chmod("files", 0777);
	
	if(move_uploaded_file($file_tmp_name, "files/" . $file_uniq_name)) {
		
		$sql = "INSERT INTO messages(username, chatkey, msg_type, time_posted, time_read, date_posted, msg) VALUES
		(
			'" . $user->username . "',
			'" . $user->access_to . "',
			'$m_type',
			'" . time() . "',
			'$t',
			'$d',
			'$file_uniq_name'
		)";
		
		$db->query($sql);
		
	}
	
	
	
	function rand_name() {
		
		return substr(md5(rand()), 0, 7) . "_";
		
	}
	
?>