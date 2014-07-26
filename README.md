chat-project
============

Chatter...

============

The info for the database used for this project:

Main {
	
	DBName: 'chat'
	DBUser: 'root'
	DBPass: ''
	DBHost: 'localhost'
	
}

Tables {
	
	users_waiting {
		id (int 11, a_i)
		username (varchar 16)
		password (varchar 100)
		email (varchar 100)
		fullname (varchar 100)
		sessionkey (varchar 100)
	}
	
	events {
		id (int 11)
		event_id (int 11)
		username (varchar 16)
		occurred (varchar 100)
	}
	
	invites {
		id (int 11)
		username (varchar 16)
		chatkey (varchar 100)
	}
	
	participants {
		id (int 11)
		username (varchar 16)
		chatkey (varchar 100)
	}
	
	active_chats {
		id (int 11)
		name (varchar 100)
		host (varchar 100)
		chatkey (varchar 100)
	}
	
}

add to all .php files: include('info.php'); or include('../info.php'); or include('../../info.php') etc...;
