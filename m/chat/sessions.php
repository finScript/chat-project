<?php
	
	header("Content-type: text/xml");
	
	echo "<Sessions>";
	
	
		session_start();
		if(!isset($_SESSION['user'])) die();
		
		require "UserClass.php";
		$user = unserialize($_SESSION['user']);
		
		include('../info.php');
$db = new mysqli(_host, _user, _pass, _dbname);
		
		$sql = "SELECT * FROM active_chats";
		
		if($res = $db->query($sql)) {
			
			if($res->num_rows) {
				
				$count = 0;
				while($row = $res->fetch_object()) {
					
					echo "<SessionName$count>";
					echo $row->name;
					echo "</SessionName$count>";
					
					echo "<SessionHost$count>";
					echo $row->host;
					echo "</SessionHost$count>";
				
					$sql_2 = "SELECT * FROM participants WHERE chatkey = '" . $row->chatkey . "'";
					$res_2 = $db->query($sql_2);
					
					echo "<SessionP$count>";
					echo $res_2->num_rows;
					echo "</SessionP$count>";
					
					$count++;
					
				}
				
				
				
				echo "<SessionCount>" . $count . "</SessionCount>";
				
				
			} else {
				
				echo "<SessionCount>0</SessionCount>";
				
			}
			
		}
		
	echo "</Sessions>";
	
?>