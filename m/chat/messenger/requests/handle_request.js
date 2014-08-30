function _(el) {
	return document.getElementById(el);
}

function trackTime() {
	
	_("cur_time").innerHTML = getT();
	setTimeout("trackTime()", 1000);
	
}

function accept(index) {
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "handle_request.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			resp = xhr.responseText;
			if(resp != null) {
				
				if(resp == "0") {
					
					alert("Request accepted successfully!");
					$("#req" + index).hide();
					
				} else {
					
					alert(resp);
					
				}
				
			} else {
				
				alert("XML Response is null");
				
			}
			
		}
	};
	
	var params = "u=" + _("req_user" + index).value + "&a=accept";
	xhr.send(params);
	
}

function decline(index) {
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "handle_request.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			resp = xhr.responseText;
			if(resp != null) {
				
				if(resp == "0") {
					
					alert("Request declined successfully!");
					$("#req" + index).hide();
					
				} else {
					
					alert(resp);
					
				}
				
			} else {
				
				alert("XML Response is null");
				
			}
			
		}
	};
	
	var params = "u=" + _("req_user" + index).value + "&a=decline";
	xhr.send(params);
	
}