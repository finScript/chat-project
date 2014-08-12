function _(el) {
	return document.getElementById(el);
}

var hidden = false;

function initAction(action) {
	
	
	var elem = "#switch_hosts,#end_session,#rename_session,#kick_user,#invite_user";
	
	if(action == "toggle") {
		
		if(!hidden) {
			
			$("#host_actions").slideUp("slow");
			_("toggle_host_actions").src = "../img/arrowdown.png";
			
		} else {
			
			$("#toggle_area").slideDown("slow");
			_("toggle_host_actions").src = "../img/arrowup.png";
			
		}
		
	}
	
	
	if(action == "kick") {
		
		slideUpAll();
		$("#kick_user_inp").slideDown("fast");
		
	}
	
	if(action == "invite") {
		
		slideUpAll();
		$("#invite_user_inp").slideDown("fast");
		
	}
	
	if(action == "rename") {
		
		slideUpAll();
		$("#rename_session_inp").slideDown("fast");
		
	}
	
	if(action == "hosts") {
		
		slideUpAll();
		$("#switch_hosts_inp").slideDown("fast");
		
	}
	
	if(action == "end") {
		
		slideUpAll();
		$("#end_session_inp").slideDown("fast");
		
	}
	
}

function hideLoaders() {
	
	$("#kick_user_inp,#invite_user_inp,#rename_session_inp,#switch_hosts_inp,#end_session_inp,.kick_user_confirm").hide();
	for(var i = 0; i <= 4; i++) {
		
		$("#loader_" + i).hide();
		
	}
	
	$("#request").hide();
	//setTimeout('$("#request").slideDown();', 1000);
	
}

function hideAction(index) {
	
	if(index == 0) $("#kick_user_inp").slideUp("fast");
	else if(index == 1) $("#invite_user_inp").slideUp("fast");
	else if(index == 2) $("#rename_session_inp").slideUp("fast");
	else if(index == 3) $("#switch_hosts_inp").slideUp("fast");
	else if(index == 4) $("#end_session_inp").slideUp("fast");
	
	
}



function slideUpAll() {
	
	$("#kick_user_inp").slideUp("fast");
	$("#invite_user_inp").slideUp("fast");
	$("#rename_session_inp").slideUp("fast");
	$("#switch_hosts_inp").slideUp("fast");
	$("#end_session_inp").slideUp("fast");
	
}



function renameSession() {
	
	$("#loader_2").fadeIn(500);
	
	var n = encodeURIComponent(_("txt_rename_session").value);
	var t = encodeURIComponent(getT_only());
	
	var xhr = new XMLHttpRequest();
	
	xhr.open("GET", "rename.php?n=" + n + "&t=" + t, true);
	xhr.onreadystatechange = function() {
		
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			var resp = xhr.responseText;
			
			if(resp != null) {
				
				if(resp == "0") {
					
					setTimeout(function() {
						
						slideUpAll();
						alert("Session renamed successfully!");
						$("#loader_2").fadeOut(500);
						_("session_header").innerHTML = decodeURIComponent(n) + " - Messenger";
						
					}, 1000);
					
					
					
				} else {
					
					setTimeout(function() {
						
						slideUpAll();
						alert("error: " + resp);
						$("#loader_2").fadeOut(500);
						
					}, 1000);
					
				}
				
			} else {
				
				alert("response is null!");
				$("#loader_2").fadeOut(500);
				
			}
			
		}
		
	};
	
	xhr.send(null);
	
}


function kickUser() {
	
	var u = encodeURIComponent(_("txt_kick_user").value);
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "kick.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	xhr.onreadystatechange = function() {
		
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			resp = xhr.responseText;
			if(resp != null || resp != "") {
				
				if(resp == "0") {
					
					alert(decodeURIComponent(u) + " has been kicked from this chat session successfully!");
					
				} else alert(resp);
				
			} else {
				
				window.console.log("kick_user: response is null!");
				
			}
			
		}
		
	};
	
	params = "u=" + u + "&t=" + encodeURIComponent(getT_only());
	xhr.send(params);
	
}



function inviteUser() {
	
	var u = _("txt_invite_user").value;
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "invite.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			resp = xhr.responseText;
			if(resp != null) {
				alert(resp);
			} else alert("Response null!");
			
		}
		
	}
	
	var params = "u=" + encodeURIComponent(u) + "&t=" + encodeURIComponent(getT_only());
	
	xhr.send(params);
	
}















































