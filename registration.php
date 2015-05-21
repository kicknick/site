<html>
<head>
	<title>Регистрация</title>
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
		<label for="lastName">Фамилия</label>
		<br>
    	<input id="lastName" autofocus class="ui-widget" type="text" class="form-control" name="lastname" />
    </div>
	<div class="form-group">
		<label for="firstName">Имя</label>
		<br>
		<input id="firstName" class="ui-widget" type="text" class="form-control" name="firstname"/>
	</div>
    <div class="form-group">
		<label for="middleName">Отчество</label>
		<br>
    	<input id="middleName" class="ui-widget" type="text" class="form-control" name="middlename" />
    </div>

	<div class="container">
		<div class="row">
	  	<b>Выберите пол</b> </br>
	  		<label class="radio-inline">
	          <input type="radio" id="male" name="radioGroup" id="radio1" value="option1"> М
	        </label>
	        <label class="radio-inline">
	          <input type="radio" id="female "name="radioGroup" id="radio2" value="option2"> Ж
	        </label>
	  	</div>
	</div>
	<br>

	<div class="form-group">
		<label for="age">Возраст</label>
		<br>
		<input id="age" class="ui-widget" type="text" class="form-control" name="firstname"/>
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
var firstNames = new Array();
var	lastNames = new Array();
var	middleNames = new Array();
var sex = null;
$(function() {
	$( "#firstName" ).autocomplete({source: firstNames}); 

	$( "#lastName" ).autocomplete({source: lastNames});

	$( "#middleName" ).autocomplete({source: middleNames});
	
	$( "#firstName" ).on( "autocompleteselect", function( event, ui ) {
		console.log(ui.item.value);
	});
	$( "#lastName" ).on( "autocompleteselect", function( event, ui ) {
		console.log(ui.item.value);
	});

	// $( "input" ).on( "click", function() {
 //  		console.log($("input:checked").val() + " is checked!");
	// });
	$("#button").on("click", function() {
		var sexCh = $("input:checked").val();
		if(sexCh=='option1') {
			sex = "m";
			sendData();
		}
		else if(sexCh=='option2') {
			sex = "f";
			sendData();
		}
		else alert("веедите пол");
	});
});

var url = "handler.php";
var sendReq = function(params, callback) {
	$.post(url, params, function(data) {
		callback(data);
	});
}
var users;
sendReq({action: "getUsers"}, function(data){
	//console.log(data);
	users = JSON.parse(data);
	for(var i in users) {
		var firstname = users[i].first_name;
		var lastname= users[i].last_name;
		var middlename = users[i].middle_name;
		firstNames.push(firstname);
		lastNames.push(lastname);
		middleNames.push(middlename);
	}
	console.log(firstNames);
	console.log(lastNames);
	console.log(middleNames);
});
var sendData =  function() {
	var firstName =$("#firstName").val();
	var lastName = $("#lastName").val();
	var middleName = $("#middleName").val();
	var mobNum = $("#mobNum").val();
	var region = $("#region").val();
	var email = $("#email").val();
	var age = $("#age").val();
	console.log(name, lastName, middleName, mobNum, region, email);
	var params = { action: "registration", 
				firstname: firstName,  
				lastname: lastName, 
	 			middlename: middleName, 
				mobnumber: mobNum,  
				region: region, 
				email: email, 
				sex: sex, 
				age: age};
	var res = sendReq(params, function() {
		location.reload();
	});
	console.log(res);
};
</script>

</body>
</html>