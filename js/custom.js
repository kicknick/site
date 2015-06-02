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