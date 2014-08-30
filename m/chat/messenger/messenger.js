function _(el) {
	
	return document.getElementById(el);
	
}

var global_time;
var millisec = 0;
var msg_array = [];
var event_array = [];
var request_array = [];


var allowed = true;

function setAllowed() {
	
	allowed = !allowed;
	//alert(allowed);
	
	_("allowcheckbox").innerHTML = allowed ? "connection enabled" : "connection disabled";
	
	//handleMessages();
	
}

var p_intervall = 5000;

function trackTime() {
	
	_("cur_time").innerHTML = getT();
	global_time = getT();
	var d = new Date();
	millisec = d.getMilliseconds();
	//_("msg_area").innerHTML += millisec;
	setTimeout("trackTime()", 1);
	
}


function handleMessages() {
	
	if(allowed) {
	
		var count;
		
		if(msg_array.length != 0 && msg_array != undefined && msg_array != null) {
			
			count = msg_array.length;
			var params = "";
			
			for(var i = 0; i < count; i++) {
				
				if(i == 0) params += "msg0=" + encodeURIComponent(msg_array[0].msg) + "&time0=" + encodeURIComponent(msg_array[i].time) + "&date0=" + encodeURIComponent(msg_array[i].date);
				else params += "&msg" + i + "=" + encodeURIComponent(msg_array[i].msg) + "&time" + i + "=" + encodeURIComponent(msg_array[i].time) + "&date" + i + "=" + encodeURIComponent(msg_array[i].date);
				
			}
			
			if(params != "")
				params += "&count=" + count;
			else
				params = "count=" + count;
			
			var xhr = new XMLHttpRequest();
			
			xhr.open("POST", "handler.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				
				if(xhr.readyState == 4 && xhr.status == 200) {
					
					response = xhr.responseXML;
					
					if(response != null) {
						
						handleResponses(response);
						
					} else {
						
						__("response is null");
						
					}
					
				}
				
			};
			
			
			
			__(params);
			
			xhr.send(params);
			
			msg_array = [];
			
			//alert(params);
			
		} else {
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "handler.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				
				if(xhr.readyState == 4 && xhr.status == 200) {
				
					response = xhr.responseXML;
					if(response != null) {
						
						handleResponses(response);
						xhr.abort();
						
					} else {
						
						__("failed fetching the events! XML Response is null!");
						
					}
				
				}
			};
			
			var params = "ms=" + millisec;
			
			xhr.send(params);
			
		}
	}
	
	setTimeout('handleMessages()', p_intervall);
}

function inpSendText(i) {
	
	if(i == 1) {
		
		if(_("txt_message").value == "" || _("txt_message").value == undefined) {
			
			_("txt_message").value = "Write a message...";
			_("txt_message").setAttribute("style", "color: darkgrey;");
		
		} else {
			
			_("txt_message").setAttribute("style", "color: darkgrey;");
			
		}
	
	} else {
		
		if(_("txt_message").value == "Write a message...") {
		
			_("txt_message").value = "";
			_("txt_message").setAttribute("style", "color:black");
		
		} else {
			
			_("txt_message").setAttribute("style", "color:black");
			
		}
	}
	
}


function writeMessage(action, msg, username, time, date, msg_type) {
	
	//alert(msg_type + "write");
	
	var m;
	var timestring = "<span class='time_posted'>&#91;" + date + ", " + time + "&#93;&#58;</span>&nbsp;";
	var timestring_grey = "<span class='time_posted_grey'>&#91;" + time + "&#93;&#58;</span>&nbsp;";
	var timestring_red = "<span class='time_posted_red'>&#91;" + time + "&#93;&#58;</span>&nbsp;";
	
	if(action == undefined || msg == undefined || username == undefined || time == undefined || date == undefined) return;
	
	if(action == "ended") {
		
		m = '<div class="end">' + timestring_red + '<label>&#62;&#62;The session has been terminated!</label></div>';
		
	} else if(action == "left") {
		
		m = '<div class="notification">' + timestring_grey + '<label>&#62;&#62;' + username + ' left.</label></div>';
		
	} else if(action == "kicked") {
		
		m = '<div class="notification">' + timestring_grey + '<label>&#62;&#62;' + username + ' was kicked by host.</label></div>';
		
	} else if(action == "invited") {
		
		m = '<div class="notification">' + timestring_grey + '<label>&#62;&#62;' + username + ' was invited by host.</label></div>';
		
	} else if(action == "joined") {
		
		m = '<div class="notification">' + timestring_grey + '<label>&#62;&#62;' + username + ' joined.</label></div>';
		
	} else if(action == "renamed") {
		

		m = '<div class="notification">' + timestring_grey + '<label>&#62;&#62;The session was renamed by host.</label></div>';
		
	} else if(action == "host_switched") {
		
		m = '<div class="notification">' + timestring_grey + '<label>&#62;&#62;The session host was switched.</label></div>';
		
	} else if(action == "write") {
		
		if(msg_type == "text") {
			
			m = '<div class="msg_wrapper"><label class="msg_username">' + username + ':</label><br /><label class="message">' + timestring + msg + '</label></div>';
			
		} else if(msg_type == "image") {
			
			try {
			
				img_id = msg.split("_")[0];
				
				msg_wrapper = document.createElement("div");
				msg_wrapper.className = "msg_wrapper";
				
				msg_username = document.createElement("label");
				msg_username.className = "msg_username";
				ap_user = document.createTextNode(username);
				msg_username.appendChild(ap_user);
				
				lblmsg = document.createElement("label");
				lblmsg.className = "message";
				lblmsg.innerHTML = "<br />" + timestring + "<br /><br />";
				
				imgdiv = document.createElement("div");
				imgdiv.className = "userimgwrapper";
				
				userimg = document.createElement("img");
				userimg.className = "userimg";
				userimg.setAttribute("id", img_id);
				userimg.setAttribute("src", "files/" + msg);
				
				
				
				msg_area = _("msg_area");
				
				msg_wrapper.appendChild(msg_username);
				msg_wrapper.appendChild(lblmsg);
				
				imgdiv.appendChild(userimg);
				
				msg_wrapper.appendChild(imgdiv);
				
				msg_area.appendChild(msg_wrapper);
				userimg.addEventListener('load', function() { resizeImg(img_id); });
				
			} catch(ex) {
				
				alert(ex.toString());
				
			}
			
			m = "";
			
			
		} else if(msg_type == "file") {
			
			m = '<div class="msg_wrapper">';
			m += '<label class="msg_username">' + username + ':</label><br />';
			m += '<label class="message">' + timestring;
			m += '<div class="userfilewrapper">';
			m += '<div class="userfile">';
			m += '<img src="../img/download.png" width="20" height="20" style="vertical-align: -4px;" />&nbsp;';
			m += '<a title="Download" href="files/' + msg + '" download>' + msg + '</a>';
			m += '</div></div></label></div>';
			
		}
		
	}
	
	if(action == "write") {
		
		_("msg_area").innerHTML += m;
		
	} else {
		
		_("event_area").innerHTML += m;
		
	}
	
	$('#msg_area').stop().animate({
		scrollTop: $("#msg_area")[0].scrollHeight
	}, 2000);
	
	if(username != _("hidden_username").value) _("notification").play();
	
}

var tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};

function replaceTag(tag) {
    return tagsToReplace[tag] || tag;
}

function safe_tags_replace(str) {
    return str.replace(/[&<>]/g, replaceTag);
}

function sendMessage() {
	
	var username = getUsername();
	var msg = safe_tags_replace(_("txt_message").value);
	var time = getT_only();
	var date = getD();
	
	//alert(getD());
	
	addToQueue(username, msg, time, date, 'text');
	
	writeMessage('write', msg, username, time, date, 'text');
	
	_("txt_message").value = "";
	//inpSendText(1);
	
}


function getUsername() {
	
	return _("hidden_username").value;
	
}


function testFunc() {
	
	if(msg_array != undefined) {
		
		_("output").innerHTML = "<br />";
		
		for(i = 0; i < msg_array.length; i++) {
			
			_("output").innerHTML += "[" + i + "]<br />";
			_("output").innerHTML += "Username: " + msg_array[i].username + "<br />";
			_("output").innerHTML += "Message: " + msg_array[i].msg + "<br />";
			_("output").innerHTML += "Time: " + msg_array[i].time + "<br />";
			_("output").innerHTML += "Date: " + msg_array[i].date + "<br />";
			
		}
		
		
	} else alert("undef");
	
	if(_("file_send").files.length == 0) alert("No files"); else alert(_("file_send").files[0].name);
	
}



function addToQueue(username, msg, time, date, msg_type) {
	
	try {
		if(msg_array == undefined) {
			
			msg_array = [
				
				{
					"username":username,
					"msg":msg,
					"time":time,
					"date":date,
					"msg_type":msg_type
				}
				
			];
			
		} else {
			
			msg_array.push({
			
				"username":username,
				"msg":msg,
				"time":time,
				"date":date,
				"msg_type":msg_type
				
			});
			
		}
	} catch(ex) {
		
		alert(ex.toString());
		
	}
	
}

function addToEvents(user, ev, occurred) {
	
	if(event_array.length == 0 || event_array == undefined || event_array == null) {
		
		event_array = [
			
			{
				
				"ev":ev,
				"username":user,
				"occurred":occurred
				
			}
			
		];
		
	} else {
		
		event_array.push(
			
			{
				
				"ev":ev,
				"username":user,
				"occurred":occurred
				
			}
			
		);
		
	}
	
}

var latest_req_num = 0;

function addToRequests(num_req) {
	
	if(num_req > latest_req_num) {
		_("num_req").innerHTML = num_req;
		$("#request").slideDown();
		latest_num_req = num_req;
	}
	
}


function handleResponses(resp) {
	
	__(resp);
	
	if(resp.getElementsByTagName("special").length != 0) {
		
		if(resp.getElementsByTagName("special")[0].childNodes[0].nodeValue == "kicked") {
			
			alert("You were kicked from this chat session!");
			window.location = "../../chat";
			
		}
		
	}
	
	if(resp.getElementsByTagName("request_count").length != 0) {
		
		var request_count = resp.getElementsByTagName("request_count")[0].childNodes[0].nodeValue;
		//alert("Reqs");
		addToRequests(request_count);
		
	} //else alert("No reqs");
	
	try {
		
		var event_count = resp.getElementsByTagName("event_count")[0].childNodes[0].nodeValue;
		var message_count = resp.getElementsByTagName("message_count")[0].childNodes[0].nodeValue;
		
	} catch(ex) {
		__("could not get event_count or message_count");
	}
	
	__(event_count + "; " + message_count);
	
	for(var i = 0; i < event_count; i++) {
		
		__("started events (" + i + ")");
		
		try {
			
			var u = resp.getElementsByTagName("userevent" + i)[0].childNodes[0].nodeValue;
			var o = resp.getElementsByTagName("occurred" + i)[0].childNodes[0].nodeValue;
			var e = resp.getElementsByTagName("event" + i)[0].childNodes[0].nodeValue;
			
			addToEvents(u, e, o);
			
		} catch(ex) {
			
			__(ex.toString());
			
		}
	}
	
	for(var i = 0; i < message_count; i++) {
		
		__("started messages (" + i + ")");
		
		try {
			
			var u = resp.getElementsByTagName("user" + i)[0].childNodes[0].nodeValue;
			var t = resp.getElementsByTagName("time_read" + i)[0].childNodes[0].nodeValue;
			var d = resp.getElementsByTagName("date_posted" + i)[0].childNodes[0].nodeValue;
			var m = resp.getElementsByTagName("msg" + i)[0].childNodes[0].nodeValue;
			var m_t = resp.getElementsByTagName("msg_type" + i)[0].childNodes[0].nodeValue;
			
			addToQueue(u, m, t, d, m_t);
			
			//alert(m_t);
			
		} catch(ex) {
			
			__(ex.toString());
			
		}
		
	}
	
	emptyMessages();
	emptyEvents();
	emptyRequests();
	
}

function emptyMessages() {
	
	if(msg_array.length == 0 || msg_array == undefined || msg_array == null) return;
	
	for(var i = 0; i < msg_array.length; i++) {
		
		var u = msg_array[i].username;
		var t = msg_array[i].time;
		var d = msg_array[i].date;
		var m = msg_array[i].msg;
		var m_t = msg_array[i].msg_type;
		
		writeMessage('write', m, u, t, d, m_t);
		
		__("wrote message.");
		
	}
	
	msg_array = [];	
}

function emptyEvents() {
	
	if(event_array.length == 0 || event_array == undefined || msg_array == null) return;
	
	for(var i = 0; i < event_array.length; i++) {
		
		var u = event_array[i].username;
		var t = event_array[i].occurred;
		var e = event_array[i].ev;
		
		writeMessage(e, '', u, t, '', '');
		
		__("wrote event: u = " + u + "; t = " + t + "; e = " + e);
		
	}
	
	event_array = [];
	
}

function emptyRequests() {
	
	if(request_array.length == 0 || request_array == undefined || request_array == null) return;
	
	for(var i = 0; i < request_array.length; i++) {
		
		var u = event_array[i].username;
		
		
	}
	
	event_array = [];
	
}

var limit = 50;
var entry_count = 0;

function __(txt) {
	
	if(entry_count > limit) {
		
		window.console.clear();
		entry_count = 0;
		
	}
	
	window.console.log(txt);
	
	entry_count++;
}


function checkEnterSend(e) {
	
	if(e.keyCode == 13) {
		
		sendMessage();
		
	}
	
}

function resizeImg(el) {
	
	setTimeout(function() {
	
		try {
			
			msg_area_width = _("msg_area").clientWidth - 60;
			img_width = _(el).clientWidth;
			
			if(img_width > msg_area_width) {
				_(el).setAttribute("width", img_width / 2);
			}
			
		} catch(ex) {
			
			alert(ex.toString());
			
		}
	
	}, 500);
	
}



























