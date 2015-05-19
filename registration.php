<html>
<head>
	<title>site</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<body>
<div class="container">
<a href="index.php"><input type="button" value="Home"></a><br>
<br>
<form role="form" action="" method="post">
	<div class="form-group">
		<label for="firstName">Имя</label>
		<br>
		<input id="firstName" class="ui-widget" type="text" class="form-control" name="firstname"/>
	</div>
	<div class="form-group">
		<label for="lastName">Фамилия</label>
		<br>
    	<input id="lastName" class="ui-widget" type="text" class="form-control" name="lastname" />
    </div>
    <div class="form-group">
		<label for="middleName">Отчество</label>
		<br>
    	<input id="middleName" class="ui-widget" type="text" class="form-control" name="middlename" />
    </div>
    <div class="form-group">
		<label for="mobNum">Мобильный телефон</label>
		<br>
    	<input id="mobNum" class="ui-widget" type="text" class="form-control" name="mobnum" />
    </div>
    <div class="form-group">
		<label for="region">Область</label>
		<br>
    	<input id="region" class="ui-widget" type="text" class="form-control" name="region" />
    </div>
    <div class="form-group">
		<label for="email">Email</label>
		<br>
    	<input id="email" class="ui-widget" type="email" class="form-control" name="email" />
    </div>

    <!-- <input id="button" type="submit" name="submit" value="Submit" /> -->
	<button id="button" class="btn btn-default" type="button">Подтвердить!</button>
</form>
</div>

<script type="text/javascript">
$(function() {
	var users;
	sendReq({action: "getUsers"}, function(data){
		users = data;
		console.log(data);
	});

	var firstNames = ["sasha", "nikita"];
	var lastNames = ["penko", "rogals"];
	$( "#firstName" ).autocomplete({source: firstNames}); 

	$( "#lastName" ).autocomplete({source: lastNames});
	
	$( "#firstName" ).on( "autocompleteselect", function( event, ui ) {
		console.log(ui.item.value);
	});
	$( "#lastName" ).on( "autocompleteselect", function( event, ui ) {
		console.log(ui.item.value);
	});

	$("#button").on("click", function() {
		sendData();
	});
});


var url = "/site/handler.php"
var sendReq = function(params, callback) {
	$.post(url, params, function(data) {
		callback(data);
	});
}
var sendData =  function() {
	var firstName =$("#firstName").val();
	var lastName = $("#lastName").val();
	var middleName = $("#middleName").val();
	var mobNum = $("#mobNum").val();
	var region = $("#region").val();
	var email = $("#email").val();
	console.log(name, lastName, middleName, mobNum, region, email);
	var params = { action: "registration", 
				firstname: firstName,  
				lastname: lastName, 
	 			middlename: middleName, 
				mobnumber: mobNum,  
				region: region, 
				email: email };
	var res = sendReq(params, function() {
		location.reload();
	});
	console.log(res);
};


</script>

</body>
</html>