<html>
<head>
	<title>Бэйдж</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<body>
<div class="container">
<a href="index.html"><input type="button" class="btn btn-default" value="Главная"></a><br>
<br>
<form role="form" action="" method="post">
	<div class="form-group">
		<label for="lfm">ФИО</label>
		<br>
    	<input id="lfm" class="ui-widget" type="text" class="form-control" name="lfm" />
    </div>
    
	<button id="button" class="btn btn-default" type="button">Получить бэйдж</button>
</form>
</div>
<script type="text/javascript">

var LFM = new Array();
var result = {action: "bage", firstname: null, lastname: null, middlename: null, start: null, end: null};
$(function() {
	$( "#lfm" ).autocomplete({source: LFM}); 
	
	$( "#lfm" ).on( "autocompleteselect", function( event, ui ) {
		var res = ui.item.value;
		var arr = res.split(' ');
		result.lastname = arr[0];
		result.firstname = arr[1];
		result.middlename = arr[2];															
	});

	$("#button").on("click", function() {
		sendData();
	});
});


var url = "handler.php"
var sendReq = function(params, callback) {
	$.post(url, params, function(data) {
		callback(data);
	});
}
var users;
sendReq({action: "getUsers"}, function(data){
	users = JSON.parse(data);
	for(var i in users) {
		var firstname = users[i].first_name;
		var lastname= users[i].last_name;
		var middlename = users[i].middle_name;
		var lfm = lastname+' '+firstname+' '+middlename;
		LFM.push(lfm);
	}
});
var sendData = function() {
	console.log(result);
	$('#lfm').val('');
	url ="bage.php?lastname="+result.lastname+"&firstname="+result.firstname+"&middlename="+result.middlename;
	window.location.href=url;
}

</script>
</body>
</html>