<html>
<head>
	<title>Регистрация</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="externals/css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="styles/site.css">
	<link rel="stylesheet" type="text/css" href="styles/statusBar.css">
 
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script type="text/javascript" src="js/custom.js"></script>
 
</head>
<body>

<?php echo file_get_contents("templates/header.tpl") ?>

<?php echo file_get_contents("templates/currentEvent.tpl"); ?>

<br>
<div class="container">
	<div class="col-md-4">
		<div>
			<div class="form-group">
				<label for="lastName">Фамилия</label>
				<br>
				<input id="lastName" class="form-control" type="text" class="form-control" name="lastname" autofocus/>
			</div>
			<div class="form-group">
				<label for="firstName">Имя</label>
				<br>
				<input id="firstName" class="form-control" type="text" class="form-control" name="firstname"/>
			</div>
			<div class="form-group">
				<label for="middleName">Отчество</label>
				<br>
				<input id="middleName" class="form-control" type="text" class="form-control" name="middlename" />
			</div>

			<div class="form-group">
				<label for="squad">Отряд</label>
				<br>
				<input id="squad" class="form-control" type="text" class="form-control" name="squad" />
			</div>

			<div class="form-group">
				<input id="button" class="btn btn-default" type="button" class="form-control" name="submit" value="Отправить">
			</div>
		</div>
		<script type="text/javascript">
			setFieldFromLS("#lastName","lastname");
			setFieldFromLS("#firstName","firstname");
			setFieldFromLS("#middleName","middlename");
			setFieldFromLS("#squad","squad");
		</script>
	</div>
</div>
 
 
<script type="text/javascript">

	// Отправка данных на сервер
	$("#button").click(function() {
		var lastname = $("#lastName").val().trim();
		var firstname = $("#firstName").val().trim();
		var middlename = $("#middleName").val().trim();
		var squad = $("#squad").val().trim();

		if(lastname != '' && firstname != '' && middlename != ''){
			$.ajax({
				type: "POST",
				url: "Controller/addUser.php",
				data:{
					lastname: lastname,
					firstname: firstname,
					middlename: middlename,
					squad: squad
				},
				success: function(data){
					if(! data){
						console.log("success");
						localStorage.setItem("lastname", lastname);
						localStorage.setItem("firstname", firstname);
						localStorage.setItem("middlename", middlename);
						localStorage.setItem("squad", squad);
						window.location = "makebage.php";
						return;
					}
					var a = JSON.parse(data);
					if (a["exitcode"])
						alert(a["err"]);
					else{

					}
				}
			});
		}
		else{
			alert("Заполните все поля");
		}
	});

 
	/*var type;
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