<html>
<head>
	<title>Регистрация</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/statusBar.css">

  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

</head>
<body>
<div>
	<nav class="navbar navbar-default navbar-top">
		<div class="container-fluid">
			<div class="navbar-header"> 
				<a class="navbar-brand" href="index.html">Главная</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="registration.php">Регистрация</a></li>
				<li><a href="nutrition.php">Питание</a></li>
				<li><a href="rooms.html">Поселение</a></li>
				<li><a href="makebage.php">Сделать Бэйдж</a></li>
				<li><a href="info.php">Информация о юзере</a></li>

			</ul>
		</div>
	</nav>	
</div>
<div class="container">
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
	          <input type="radio" name="radioGroup" id="male" value="option1"> М
	        </label>
	        <label class="radio-inline">
	          <input type="radio" name="radioGroup" id="female" value="option2"> Ж
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
var LFM = new Array();
var sex = null;
var status;
var type
$(function() {
	$( "#lastName" ).on( "autocompleteselect", function( event, ui ) {
		var res = ui.item.value;
		var arr = res.split(' ');
		var request = {lastname: arr[0], firstname: arr[1], middlename: arr[2], action: "getUser"};
		sendReq(request, function(data) {
			if(data[0] == '[')
			{
				//console.log(111111);
				var user = JSON.parse(data);
				console.log(user[0]);
				$( "#lastName" ).val(user[0].last_name);
				$( "#firstName" ).val(user[0].first_name);
				$( "#middleName" ).val(user[0].middle_name);
				$("#mobNum").val(user[0].mobile_number);
				$("#email").val(user[0].email);
				$("#age").val(user[0].age);
				var rb = user[0].sex;
				console.log(rb);
				if(rb == 'm') {
					$("#male").prop( "checked", true );
				}
				if(rb == 'f') {
					$("#female").prop( "checked", true );
				}
			}
			else
			{
				alert(data);
			}
		});														
	});
	$("#button").on("click", function() {
		sex = null;
		var sexCh = $("input:checked").val();
		if(sexCh=='option1') {
			sex = "m";
		}
		else if(sexCh=='option2') {
			sex = "f";
		}
		sendData();
		//else alert("Введите пол");
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
	if(data[0] == '[')
	{
		users = JSON.parse(data);
		for(var i in users) {
			var firstname = users[i].first_name;
			var lastname= users[i].last_name;
			var middlename = users[i].middle_name;
			var lfm = lastname+' '+firstname+' '+middlename;
			LFM.push(lfm);
			}
	}
	else
	{
		alert(data);
	}
	console.log(users);
	$( "#lastName" ).autocomplete({source: LFM}); 
});

var sendData =  function() {
	var firstName =$("#firstName").val();
	var lastName = $("#lastName").val();
	var middleName = $("#middleName").val();
	var mobNum = $("#mobNum").val();
	var region = $("#region").val();
	var email = $("#email").val();
	var age = $("#age").val();
	//console.log(name, lastName, middleName, mobNum, region, email);
	var params = { action: "registration", 
				firstname: firstName,  
				lastname: lastName, 
	 			middlename: middleName, 
				mobnumber: mobNum,  
				region: region, 
				email: email, 
				sex: sex, 
				age: age, 
				status: status};
	sendReq(params, function(data) {
		if(data)
			alert(data);
		else
			location.reload();
	});
	//console.log(res);
};
</script>

</body>
</html>