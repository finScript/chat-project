var keyOK = false;

function _(el) {
	
	return document.getElementById(el);
	
}

function trackTime() {
	
	var t = getT();
	_("cur_time").innerHTML = t;
	setTimeout(function() {trackTime();}, 1000);
	
}

function hideLoaders() {
	
	$("#searching, #loader_gif_enter, #key_status").hide();
	
}

function checkKey() {
	
	if(_("txt_sessionkey").value.length == 32) {
		
		_("sessionkey_button").disabled = false;
		keyOK = true;
		
	} else {
		
		_("sessionkey_button").disabled = true;
		keyOK = false;
		
	}
	
}

function enterChat() {
	
	if(keyOK) {
		
		$("#loader_gif_enter").fadeIn(200);
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "check_key.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
			
			if(xhr.readyState == 4 && xhr.status == 200) {
				
				response = xhr.responseXML;
				
				if(response != null) {
					
					key_status = response.getElementsByTagName("status")[0].childNodes[0].nodeValue;
					if(key_status == "0") {
						
						setTimeout(function() {
							
							//$("#loader_gif_enter").hide();
							_("key_status").setAttribute("style", "color:green;");
							_("key_status").innerHTML = "The key you entered was valid. You will be redirected in a moment.";
							setTimeout('$("#key_status").fadeIn();', 1000);
							
							setTimeout(function() {
								
								window.location = 'messenger';
								
							}, 2000);
							
						}, 1500);
						
						
						
					} else {
						
						setTimeout(function() {
						
							$("#loader_gif_enter").hide();
							_("key_status").setAttribute("style", "color:red;");
							_("key_status").innerHTML = "The key you entered was invalid! Please try again.";
							setTimeout('$("#key_status").fadeIn();', 1000);
							
						}, 1500);
						
					}
					
				} else {
					
					alert("response is null");
					
				}
				
			}
			
		};
		
		params = "key=" + encodeURIComponent(_("txt_sessionkey").value) + "&t=" + encodeURIComponent(getT_only());
		
		xhr.send(params);
		
	}
	
	
}

function refreshSessions() {
	

	//e.preventDefault();
	$("#searching").slideDown(200);
	$("#refresh_icon").fadeOut(100);
	
	$("#session_table").hide();
	
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "sessions.php", true);
	xhr.onreadystatechange = function() {
		
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			try {
			
				response = xhr.responseXML;
				if(response != null) {
					
					session_count = parseInt(response.getElementsByTagName("SessionCount")[0].childNodes[0].nodeValue);
					//alert(session_count);
					
					if(session_count != 0) {
						
						_("session_table").innerHTML = "<tr><th><label>Session Name</label></th><th><label>Host</label></th><th><label>People (#)</label></th><th><label>Action</label></th></tr>";
						for(var i = 1; i <= session_count; i++) {
							
							try {
								
								session_name = response.getElementsByTagName("SessionName" + (i-1))[0].childNodes[0].nodeValue;
								session_host = response.getElementsByTagName("SessionHost" + (i-1))[0].childNodes[0].nodeValue;
								session_p = response.getElementsByTagName("SessionP" + (i-1))[0].childNodes[0].nodeValue;
								
								
								
								if(session_host != getUsername()) {
									
									enter_img = "<img src='img/arrow_right.png' width='20' height='20' style='vertical-align:-5px' />";
									_("session_table").innerHTML += "<tr><td>" + session_name + "</td><td>" + session_host + "</td><td>" + (parseInt(session_p)) + "</td><td class='centered'><a href='messenger/request.php?host=" + session_host + "'>" + enter_img + "</a></td></tr>";
								
								} else {
									
									delete_img = "<img src='img/invalidicon.png' width='20' height='20' style='vertical-align:-5px' />";
									enter_img = "<img src='img/arrow_right.png' width='20' height='20' style='vertical-align:-5px' />";
									
									_("session_table").innerHTML += "<tr><td>" + session_name + "</td><td><b style='color:green'>You</b></td><td>" + (parseInt(session_p)) + "</td><td class='centered'><a href='messenger/delete.php'>" + delete_img + "</a>&nbsp;&nbsp;<a href='messenger/request.php?host=" + session_host + "'>" + enter_img + "</a></td></tr>";
									
								}
								
								setTimeout('$("#searching").slideUp(); $("#refresh_icon").fadeIn(300); $("#session_table").fadeIn();', 1500);
								
							} catch(ex) {
								
								alert(ex.toString());
								
							}
						}
					} else {
						
						_("session_table").innerHTML = "<tr><th>No sessions found!</th></tr>";
						setTimeout('$("#searching").slideUp(); $("#refresh_icon").fadeIn(300); $("#session_table").fadeIn();', 1500);
						
					}
					
				} else {
					
					alert("response is null");
					
				}
			
			} catch(ex) {
				alert(ex.toString());
			}
			
		}
		
	};
	 
	xhr.send(null);
	
}

function startSession() {
	
	var query = encodeURIComponent(_("txt_participants").value);
	if(query.length >= 6) {
		
		window.location = "start_session.php?q=" + query;
		
	}
	
}

function checkOwnUsername() {
	
	var own_user = _("hid_username").value;
	if(_("txt_participants").value.indexOf(own_user) > -1 || _("txt_participants").value.length < 6) {
		
		_("btn_start_session").disabled = true;
		
	} else {
		
		_("btn_start_session").disabled = false;
		
	}
	
}






function getUsername() {
	
	return _("hid_username").value;
	
}














