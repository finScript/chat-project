function _(el) {
	
	return document.getElementById(el);
	
}

var proceedOK = true;

function start() {
	
	if(proceedOK) {
		var host = _("hid_host").value;
		var participants = encodeURIComponent(_("hid_participants").value);
		var topic = encodeURIComponent(_("txt_topic").value);
		
		window.location = "create.php?h=" + host + "&p=" + participants + "&t=" + topic + "&time=" + encodeURIComponent(getT_only());
	}
	
}

function setErrorCount(i) {
	
	proceedOK = false;
	
}

function trackTime() {
	
	_("cur_time").innerHTML = " | " + getT();
	setTimeout("trackTime()", 1000);
	
}