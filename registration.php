<html>
<head>
	<title>Регистрация</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/statusBar.css">
 
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script type="text/javascript" src="js/custom.js"></script>
 
</head>
<body>

<?php echo file_get_contents("templates/header.tpl") ?>
 
<div style="margin-left:100px">
	<div>
		<h3>Мероприятие: <b id="current_event"></b></h3>
	</div>
</div>
<script type="text/javascript">
	var eventname;
	if((eventname = localStorage.getItem("eventname")) != undefined)
		$("#current_event").html(eventname);
	else
		$("#current_event").html("-");
</script>
</br>
 
<div class="container">
<form id="registration_form">
	<div class="col-md-6">

		</br>
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
		<input id="button" class="ui-widget" type="button" class="form-control" name="submit" value="Отправить">
	</div>
</form>
</div>
 
 
<script type="text/javascript">

	// Отправка данных на сервер
	$("#button").click(function() {
		var lastname = $("#lastName").val().trim();
		var firstname = $("#firstName").val().trim();
		var middlename = $("#middleName").val().trim();

		if(lastname != '' && firstname != '' && middlename != ''){
			$.ajax({
				type: "POST",
				url: "Controller/addUser.php",
				data:{
					lastname: lastname,
					firstname: firstname,
					middlename: middlename
				},
				success: function(data){
					if(! data){
						console.log("success");
						return;
					}
					var a = JSON.parse(data);
					if (a["exitcode"])
						alert(a["err"]);
					else{
						// Перенапривить на печать бэйджей
					}
				}
			})
		}
		else{
			alert("Заполните все поля");
		}
	});

	/*var LFM = new Array();
	putEvent();
 
	var type;
	$(function() {
 
		$("#submit").on("click", function() {
			sex = null;
			var sexCh = $("#sex input:checked").val();
			if(sexCh=='option1') {
				sex = "m";
			}
			else if(sexCh=='option2') {
				sex = "f";
			}
 
			userType= null;
			var ut = $("#userType input:checked").val();
			if(ut=='option1') {
				userType = "1";
			}
			else if(ut=='option2') {
				userType = "2"
			}
			else {
				userType = "3";
			}
 
			if($("#checkBox").prop("checked")) {
				checkBox = 1;
				console.log(1);
			}
			else {
				checkBox = 0;
			}
			sendData();
		});
 
 
		if(e = localStorage.getItem("event"))
			$( "#event" ).val(e);
	});
 
	var url = "handler.php";
	var sendReq = function(params, callback) {
		$.post(url, params, function(data) {
			callback(data);
		});
	}
	var users;
	sendReq({action: "getOldUsers"}, function(data){
		//console.log(data);
		if(data[0] == '['){
			users = JSON.parse(data);
			//console.log(users);
			for(var i in users) {
				LFM.push(users[i].fio);
			}
		}
		else
			console.log(data);
		console.log(LFM);
		$( "#lastName" ).autocomplete({source: LFM}); 
	});
 
 
 
	var sendData =  function() {
		firstName =$("#firstName").val();
		lastName = $("#lastName").val();
		middleName = $("#middleName").val();
		var mobNum = $("#mobNum").val();
		var region = $("#region").val();
		var email = $("#email").val();
		var age = $("#age").val();
		var country = $("#country").val();
		var city = $("#city").val();
		var Event = localStorage.getItem('event');
		//console.log(name, lastName, middleName, mobNum, region, email);
		var params = { action: "registration", 
					firstname: firstName,  
					lastname: lastName, 
		 			middlename: middleName, 
					mobnumber: mobNum,  
					email: email, 
					sex: sex, 
					age: age,
					event: Event,
					usertype: userType, 
					country: country,
					city: city,
					status: status, 
					notification: checkBox
				};
		sendReq(params, function(data) {
			if(data)
				//console.log(data);
				alert(data);
			else{
				status = status | 1;
 
 
				localStorage.setItem("status", status);
				localStorage.setItem("firstName", firstName);
				localStorage.setItem("lastName", lastName);
				localStorage.setItem("middleName", middleName);
				window.location.href = "nutrition.html";
			}
		});
		//console.log(res);
	};*/
</script>
 
</body>
</html>