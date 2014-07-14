(function() {
	
	window.onload = function() { trackTime(); hideLoaders(); };
	
})();

function _(el) {
	
	return document.getElementById(el);
	
}


function hideLoaders() {
	
	$("#loader,#result").hide();
	
}

function trackTime() {
	
	_("cur_time").innerHTML = getT();
	
	setTimeout('trackTime()', 1000);
	
}


function sendRequest() {
	
	$("#loader").fadeIn(500);
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "send_request.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		
		if(xhr.readyState == 4 && xhr.status == 200) {
			
			response = xhr.requestText;
			if(response != null) {
				
				if(response == "0") {
					
					setTimeout(function() {
						
						$("#result").slideDown("fast");
						$("#loader").fadeOut(500);
						
					}, 1000);
					
				} else window.console.log("error: " + response);
				
			} else {
				
				window.console.log("XML Response is null!");
				
			}
			
		}
		
	};
	
	var params = 'host=' + encodeURIComponent(_("hid_host").value);
	
	xhr.send(params);
	
}





