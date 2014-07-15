function _(el) {
	
	return document.getElementById(el);
	
}

var xmlHttp;

function trackTime() {
	
	_("cur_time").innerHTML = getT();
	setTimeout("trackTime()", 1000);
	
}

function login() {
	
	var username = encodeURIComponent(_("txt_username_email").value);
	var password = encodeURIComponent(_("txt_password").value);
	
	xmlHttp = new XMLHttpRequest();
	xmlHttp.open("POST", "login.php", true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.onreadystatechange = handleLogin;
	
	params = "username=" + username + "&password=" + password;
	
	xmlHttp.send(params);
	
}

function handleLogin() {
	
	if(xmlHttp.readyState == 4 && xmlHttp.status == 200) {
		
		response = xmlHttp.responseXML;
		if(response != null) {
			
			login_status = response.getElementsByTagName("status")[0].childNodes[0].nodeValue;
			
			if(login_status == "0") {
				
				$("#login_success").fadeIn("fast");
				setTimeout('window.location = "..";', 1000);
				
			} else if(login_status == "1000") {
				
				error = response.getElementsByTagName("err")[0].childNodes[0].nodeValue;
				alert("Error:" + error);
				
			} else if(login_status == "404") {
				
				alert("The login information is invalid!");
				
			} else if(login_status == "10") {
				
				alert("Database error! ErrorMessage: " + response.getElementsByTagName("err")[0].childNodes[0].nodeValue);
				
			} else alert("The given login information is invalid!");
			
		} else {
			
			alert("Xml doc is null!");
			
		}
		
	}
	
}


function hideLoaders() {
	
	$("#login_success").hide();
	
}

function checkEnter(e) {
	
	if(e.keyCode == 13) {
		
		login();
		
	}
	
}















