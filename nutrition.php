<html>
<head>
	<title>Кормление</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/statusBar.css">

  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script type="text/javascript" src="js/custom.js"></script>

</head>
<body>
<div>
	<nav class="navbar navbar-default navbar-top">
		<div class="container-fluid">
			<div class="navbar-header"> 
				<a class="navbar-brand" href="index.html">Главная</a>
			</div>
			<ul class="nav navbar-nav">
				<li id="reg"><a href="registration.php">Регистрация</a></li>
				<li id="nut"><a href="nutrition.php">Питание</a></li>
				<li id="room"><a href="rooms.html">Поселение</a></li>
				<li id="bage"><a href="makebage.php">Сделать Бэйдж</a></li>
				<li id="userInfo"><a href="info.php">Информация о юзере</a></li>
			</ul>
		</div>
	</nav>	
</div>	
<div class="container">
<form role="form" action="" method="post">
	<div class="form-group">
		<label for="lfm">ФИО</label>
		<br>
    	<input id="lfm" class="ui-widget" type="text" class="form-control" name="lfm" />
    </div>
    <div class="form-group">
		<label for="start">Заезд</label>
		<br>
    	<input id="start" class="ui-widget" type="date" class="form-control" name="start" />
    </div>
    <div class="form-group">
		<label for="end">Отезд</label>
		<br>
    	<input id="end" class="ui-widget" type="date" class="form-control" name="end" />
    </div>
    <!-- <input id="button" type="submit" name="submit" value="Submit" /> -->
	<button id="button" class="btn btn-default" type="button">Покормить!</button>
</form>
</div>
<script type="text/javascript">

	var fio = "";
	var LFM = new Array();
	var result = {action: "nutrition", firstname: null, lastname: null, middlename: null, start: null, end: null};
	var status = localStorage.getItem("status");
	paintBars(status);

	$(function() {
		$( "#lfm" ).autocomplete({source: LFM}); 

		$("#button").on("click", function() {
			sendData();
		});

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth() + 1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd < 10) {
    		dd = '0' + dd
		} 
		if(mm < 10) {
		    mm = '0' + mm
		} 
		var today = yyyy + '-' + mm + '-' + dd;
		$("#start").val(today);
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
		fio = $( "#lfm" ).val();
		var res = window.fio;
		var arr = res.split(' ');
		result.lastname = arr[0];
		result.firstname = arr[1];
		result.middlename = arr[2];
		result.start = $("#start").val();
		result.end = $("#end").val();
		console.log(result);
		sendReq(result, function(data) {
			if(data)
				alert(data);
			else
				location.reload();
		});
	}

</script>
</body>
</html>