function _(el) {
	
	return document.getElementById(el);
	
}

function trackTime() {
	
	_("cur_time").innerHTML = " | " + getT();
	setTimeout("trackTime()", 1000);
	
}

function deleteSession() {
	
	$("#loader").fadeIn(300);
	
	var xhr = new XMLHttpRequest();
	
	xhr.open("POST", "delete_permanent.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			response = xhr.responseText;
			
			if(response != null) {
				
				if(response == "0") {
					
					setTimeout(function() {
						
						$("#loader").fadeOut();
						$("#delete_success").slideDown();
						setTimeout('$("#query").slideUp()', 1000);
						
					}, 2000);
					
				} else alert(response);
				
			} else {
				
				alert("something went wrong!");
				
			}
			
		}
		
	};
	
	xhr.send("secure=true&key=" + _("hid_key").value);
	
	
	
}

function hideLoaders() {
	
	$("#loader").hide();
	$("#delete_success").hide();
	
}