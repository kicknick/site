var paintBars = function(status, id) {
	if(status & 1)
		$("#reg").addClass("ready");

	if(status & 8)
		$("#nut").addClass("ready");

	if(status & 32)
		$("#room").addClass("ready");

	$("#"+id).attr('class', '');
	$("#"+id).addClass("active");
}


var putEvent = function() {
	if(e = localStorage.getItem("event"))
		$("#events b").html(e);
}


var fillLFM = function(string) {
	var arr = string.split(' ');
	$("#lastname").val(arr[0]);
	$("#firstname").val(arr[1]);
	$("#middlename").val(arr[2]);
}

var fillFio = function() {
	if(status & 1) {
		var firstName = localStorage.getItem("firstName");
		var lastName = localStorage.getItem("lastName");
		var middleName = localStorage.getItem("middleName");
		$("#lfm").val(lastName+' '+firstName+' '+middleName);
	}	
}

var setFieldFromLS = function(selector, localvar){
	var string, elem;
	if((string = localStorage.getItem(localvar)) != undefined) {
		if ((elem = $(selector)).attr("type") == "text")
			elem.val(string);
		else
			elem.html(string);
	}
}

