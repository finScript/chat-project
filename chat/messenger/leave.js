function _(el) { return document.getElementById(el); }

function trackTime() {
	
	_("cur_time").innerHTML = getT();
	setTimeout("trackTime()", 1000);
	
}