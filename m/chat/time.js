function getT() {
	d = new Date();

	if(d.getHours() < 10) {
		h = "0" + d.getHours();
	} else {
		h = d.getHours();
	}

	if(d.getMinutes() < 10) {
		min = "0" + d.getMinutes();
	} else {
		min = d.getMinutes();
	}

	if(d.getSeconds() < 10) {
		sec = "0" + d.getSeconds();
	} else {
		sec = d.getSeconds();
	}
	
	weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	
	var weekday = weekdays[d.getDay()];
	var monthday = d.getDate();
	var month = months[d.getMonth()];
	
	var t = weekday + ", " + month + " " + monthday + " | " + h + ":" + min + ":" + sec;
	
	
	return t;
}

function getD() {
	
	var d = new Date();
	
	weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	
	var year = d.getYear() + 1900;
	var weekday = weekdays[d.getDay()];
	var monthday = d.getDate();
	
	if(monthday < 10) {
		
		monthday = "0" + d.getDate();
		
	}
	
	var month = months[d.getMonth()];
	
	return year + " " + month + " " + monthday;
	
}

function getT_only() {
	d = new Date();

	if(d.getHours() < 10) {
		h = "0" + d.getHours();
	} else {
		h = d.getHours();
	}

	if(d.getMinutes() < 10) {
		min = "0" + d.getMinutes();
	} else {
		min = d.getMinutes();
	}

	if(d.getSeconds() < 10) {
		sec = "0" + d.getSeconds();
	} else {
		sec = d.getSeconds();
	}

	
	var t = h + ":" + min + ":" + sec;
	
	
	return t;
}













