var paintBars = function(status) {
	if(status & 1)
		$("#reg").addClass("ready");

	if(status & 8)
		$("#nut").addClass("ready");
}