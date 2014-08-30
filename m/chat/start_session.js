function _(el) {
	
	return document.getElementById(el);
	
}

function hideLoaders() {
	
	$("#loader").hide();
	
}

var proceedOK = true;

function start() {
	
	if(proceedOK) {
		
		$("#loader").fadeIn(500);
		_("create_btn").disabled = true;
		
		var host = _("hid_host").value;
		var participants = encodeURIComponent(_("hid_participants").value);
		var topic = encodeURIComponent(_("txt_topic").value);
		var session_public = _("cb_public").checked;
		
		var params = "";
		params += "h=" + host;
		params += "&p=" + participants;
		params += "&t=" + topic;
		params += "&session_public=" + session_public;
		params += "&dev=" + _("cb_dev").checked;
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "create.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.onreadystatechange = function() {
			
			if(xhr.readyState == 4 && xhr.status == 200) {
				
				resp = xhr.responseXML;
				if(resp != null) {
					
					if(resp.getElementsByTagName("failed").length != 0) {
						
						_("successfull").innerHTML = "<span style='color: red;'>" + resp.getElementsByTagName("failed")[0].childNodes[0].nodeValue + "</span>";
						
					} else {
						
						setTimeout(function() {
						
							try {
								
								var valid_img = "<img src='img/validicon.png' width='20' height='20' style='vertical-align: -4px;' />&nbsp;";
								var invalid_img = "<img src='img/invalidicon.png' width='20' height='20' style='vertical-align: -4px;' />&nbsp;";
								
								var invalids = resp.getElementsByTagName("invalidcount")[0].childNodes[0].nodeValue;
								var valids = resp.getElementsByTagName("validcount")[0].childNodes[0].nodeValue;
								_("successfull").innerHTML += "Invited users: " + valids + "<br />";
								
								if(valids != 0) {
									
									for(var i = 0; i < valids; i++) {
										
										_("successfull").innerHTML += "&nbsp;&nbsp;&nbsp;&nbsp;" + valid_img + resp.getElementsByTagName("valid" + i)[0].childNodes[0].nodeValue + "<br />";
										
									}
									
								}
								
								_("successfull").innerHTML += "<br />Not invited users: " + invalids + "<br />";
								
								if(invalids != 0) {
									
									for(var i = 0; i < invalids; i++) {
										
										_("successfull").innerHTML += "&nbsp;&nbsp;&nbsp;&nbsp;" + invalid_img + resp.getElementsByTagName("invalid" + i)[0].childNodes[0].nodeValue + "<br />";
										
									}
									
								}
								
								
								
							} catch(ex) { alert(ex.toString()); }
							
							$("#loader").fadeOut(500);
							
						}, 1000);
						
					}
					
				} else {
					
					alert("response null");
					
				}
				
			}
			
		};
		
		xhr.send(params);
		
	}
	
}

function setErrorCount(i) {
	
	proceedOK = false;
	
}

function trackTime() {
	
	_("cur_time").innerHTML = " | " + getT();
	setTimeout("trackTime()", 1000);
	
}