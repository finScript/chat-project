function hideFileSelect() {
	
	$("#file_send").hide();
	
}


function selectFile() {
	
	$("#file_send").trigger('click');
	
}

function sendFile() {
	
	if(_("file_send").files.length != 0) {
		
		var f = _("file_send").files[0];
		
		if(f.size / 1024 / 1000 > 4) {
			
			alert("File size limit exceeded! The maximum file size is 4 MB");
			return;
			
		}
		
		var formdata = new FormData();
		formdata.append("f", f);
		
		var ajax = new XMLHttpRequest();
	
		ajax.upload.addEventListener("progress", progressHandler, false);
		ajax.addEventListener("load", completeHandler, false);
		ajax.addEventListener("error", errorHandler, false);
		ajax.addEventListener("abort", abortHandler, false);
		ajax.open("POST", "file_upload.php");
		
		ajax.send(formdata);
		
	}
	
	
}

function progressHandler(event) {
	
	_("loaded_n_total").innerHTML = "Uploaded: " + (Math.round((event.loaded / 1024) * 10) / 10) + "kB from " + (Math.round((event.total / 1024) * 10) / 10) + "kB";
	var percent = parseInt((event.loaded / event.total) * 100);
	
	_("loaded_n_total").innerHTML += "; " + percent + "% uploaded.";
	
}

function completeHandler() {
	
	alert("The file was sent successfully!");
	
}

function errorHandler() {
	
	alert("There was an error sending the image.");
	
}

function abortHandler() {
	
	alert("There was an error sending the image. (a)");
	
}




















