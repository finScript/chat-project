function _(el) {
	return document.getElementById(el);
}

var xmlHttp;

function register() {
	
	try {
	
		if(checkUsername() == false) { alert("username faulty"); return; }
		if(checkEmail() == false) { alert("email faulty"); return; }
		if(checkName() == false) { alert("name faulty"); return; }
		if(checkPassword() == false) { alert("password faulty"); return; }
		
		var username = encodeURIComponent(_("txt_username").value);
		var password = encodeURIComponent(_("txt_pwd").value);
		var email = encodeURIComponent(_("txt_email").value);
		var fullname = encodeURIComponent(_("txt_fullname").value);
		
		xmlHttp = new XMLHttpRequest();
		xmlHttp.open("POST", "register.php", true);
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlHttp.onreadystatechange = handleRegistration;
		
		var params = "username=" + username + "&password=" + password + "&fullname=" + fullname + "&email=" + email;
		
		xmlHttp.send(params);
	
	} catch(ex) {
		
		alert(ex.toString());
		
	}
}

function handleRegistration() {
	
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		
		response = xmlHttp.responseXML;
		if(response != null) {
			
			registration_status = response.getElementsByTagName("status")[0].childNodes[0].nodeValue;
			
			if(registration_status == "0") {
				
				$("#register_success").fadeIn("fast");
				setTimeout('window.location = "..";', 1000);
				
			} else if(registration_status == "10") {
				
				alert("Database error! ErrorMessage: " + response.getElementsByTagName("err")[0].childNodes[0].nodeValue);
				
			} else if(registration_status == "20") {
				
				alert("Username and/or email address are already in use!");
				
			}
			
		} else {
			
			alert("XMlResponse is null!");
			
		}
		
	}
	
}


function checkUsername() {
	
	try {
	
		var u = _("txt_username").value;
		var letters = /^[a-zA-Z0-9_ -]+$/;
		
		if(u.length >= 6) {
			
			if(!letters.test(u)) {
				
				return false;
				
			}
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "check_id.php", true);
			xhr.setRequestHeader("Content-type", "x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				
				if(xhr.readyState == 4 && xhr.status == 200) {
					
					response = xhr.responseText;
					
					if(response != null) {
					
						if(response == "0") {
							
							return true;
							
						} else {
							
							return false;
							
						}
						
					} else {
						
						alert("response is null");
						
					}
					
				}
				
			};
			
			var params = "id=" + encodeURIComponent(u) + "&action=u";
			xhr.send(params);
			
		} else {
			return false;
		}
		
	} catch(ex) {
		
		alert(ex.toString());
		
	}
	
}


function checkEmail() {
	
	try {
	
		var u = _("txt_email").value;
		
		
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		if(u.length >= 6) {
			
			if(!re.test(u)) {
				
				return false;
				
			}
			
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "check_id.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function() {
				
				if(xhr.readyState == 4 && xhr.status == 200) {
					
					response = xhr.responseText;
					
					if(response != null) {
					
						if(response == "0") {
							
							return true;
							
						} else {
							
							return false;
							
						}
						
					} else {
						
						alert("response is null");
						
					}
					
				}
				
			};
			
			var params = "id=" + encodeURIComponent(u) + "&action=e";
			xhr.send(params);
			
		} else {
			return false;
		}
	
	} catch(ex) {
		
		alert(ex.toString());
	
	}
	
	
}

function checkPassword() {
	
	try {
		var p = _("txt_pwd").value;
		var p_rep = _("txt_pwd_rep").value;
		
		var letters = /^[a-zA-Z0-9_ -]+$/;
		
		if(p != p_rep) return false;
		
		if(p.length >= 6) {
			
			if(!letters.test(p)) return false;
			else return true;
			
			
		} else {
			return false;
		}
	} catch(ex) {
		
		alert(ex.toString());
		
	}
}

function checkName() {
	
	try {
		var n = _("txt_fullname").value;
		var letters = /^[a-zA-Z0-9_ -]+$/;
		
		if(letters.test(n)) return true;
		else return false;
	} catch(ex) {
		
		alert(ex.toString());
		
	}
}



function hideLoaders() {
	
	$("#register_success").hide();
	
}


















