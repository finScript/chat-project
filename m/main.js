function trackTime() {
	
	_("cur_time").innerHTML = getT();
	setTimeout("trackTime()", 1000);
	
}

function closeMenu() {
	
	$("#hidden_menu").animate({
		
		"margin-left":"-100%"
		
	});
	
}

function openMenu() {
	
	$("#hidden_menu").animate({
		
		"margin-left":"0%"
		
	});
	
}