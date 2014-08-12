CREATE TABLE active_chats (
	
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(100) NOT NULL UNIQUE,
	host VARCHAR(16) NOT NULL,
	chatkey VARCHAR(100) NOT NULL UNIQUE,
	PRIMARY KEY (id)
	
);

CREATE TABLE users_waiting (
	
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(16) NOT NULL UNIQUE,
	password VARCHAR(100) NOT NULL,
	email VARCHAR(100) NOT NULL UNIQUE,
	fullname VARCHAR(100) NOT NULL,
	sessionkey VARCHAR(100) NOT NULL UNIQUE,
	PRIMARY KEY (id)
	
);

CREATE TABLE events (
	
	id INT NOT NULL AUTO_INCREMENT,
	event_id INT NOT NULL,
	username VARCHAR(16) NOT NULL,
	occurred VARCHAR(100) NOT NULL,
	PRIMARY KEY (id)
	
);


CREATE TABLE invites (
	
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(16) NOT NULL,
	chatkey VARCHAR(100) NOT NULL,
	PRIMARY KEY (id)
	
);

CREATE TABLE participants (
	
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(16) NOT NULL,
	chatkey VARCHAR(100) NOT NULL,
	PRIMARY KEY (id)
	
);

CREATE TABLE `messages` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
 `chatkey` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `time_posted` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `time_read` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `date_posted` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `msg` text COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE requests (
	
	id INT NOT NULL AUTO_INCREMENT,
	user_from VARCHAR(16) NOT NULL,
	chatkey_to VARCHAR(100) NOT NULL,
	request_id VARCHAR(10) NOT NULL,
	PRIMARY KEY (id)
	
);

