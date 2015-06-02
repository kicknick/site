<html>
<head>
	<title>Бэйдж</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="ias/css/imgareaselect-animated.css">
    <link rel="stylesheet" type="text/css" href="css/statusBar.css">

  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script type="text/javascript" src="ias/scripts/jquery.imgareaselect.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script type="text/javascript" src="js/custom.js"></script>

	<style type="text/css">
		#imgField{
			width:400px;
		}
	</style>

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
<div class="col-md-6">
	<form action="bage.php" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="lfm">ФИО</label>
			<br>
	    	<input id="lfm" class="ui-widget" type="text" class="form-control" name="lfm" />
	    </div>
<!-- 		<button id="button" class="btn btn-default" type="button">Получить бэйдж</button> -->

	
		<!-- <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> -->
		<label for="user_pic">Отправка изображения:</label>
		<input id="user_pic" type="file" class="btn btn-default" name="user_pic" size="30">
		<br>
		<input type="hidden" name="foto_x" value="" />
		<input type="hidden" name="foto_y" value="" />
		<input type="hidden" name="foto_width" value="" />
		<input type="hidden" name="foto_height" value="" />

		<input type="hidden" id="firstname" name="firstname" value="" />
		<input type="hidden" id="lastname" name="lastname" value="" />
		<input type="hidden" id="middlename" name="middlename" value="" />

		<input type="submit" class="btn btn-default" value="Получить бэйдж">
	</form>
</div>

<div class="col-md-6">
	<img id="imgField">
</div>
</div>

<script type="text/javascript">
	var status = localStorage.getItem("status");
	paintBars(status, "bage");

	var LFM = new Array();
	var result = {action: "bage", firstname: null, lastname: null, middlename: null, start: null, end: null};
	$(function() {
		if(status & 1) {
			var firstName = localStorage.getItem("firstName");
			var lastName = localStorage.getItem("lastName");
			var middleName = localStorage.getItem("middleName");
			$("#lfm").val(lastName+' '+firstName+' '+middleName);
		}
		$("#user_pic").val("");
		fillLFM($("#lfm").val());
		$( "#lfm" ).autocomplete({source: LFM}); 

		$( "#lfm" ).on( "autocompleteselect", function( event, ui ) {
			var string = ui.item.value;
			fillLFM(string);
		});
		// $("#button").on("click", function() {
		// 		sendData();
		// });
	});



    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgField').attr('src', e.target.result);
                image = e.target.result;
                handleImgInit();
            }       
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#user_pic").change(function(){
        readURL(this);
    });



	var handleImgInit = function() {
		$("#imgField").imgAreaSelect({ aspectRatio: '3:4', x1: 100, y1: 100, x2: 175, y2: 200,
	       	onSelectEnd: function (img, selection) { 
	            $('input[name="foto_x"]').val(selection.x1);
	            $('input[name="foto_y"]').val(selection.y1);
	            $('input[name="foto_width"]').val(selection.x2 - selection.x1);   
	            $('input[name="foto_height"]').val(selection.y2 - selection.y1);   
	            console.log(selection.x1); 
	            console.log(selection.y1); 
	            console.log(selection.x2); 
	            console.log(selection.y2); 
	        	}
	    });
	} 



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
		console.log(LFM);
	});


	var sendData = function() {
		console.log("dfdf");
		var res = $( "#lfm" ).val()
		var arr = res.split(' ');
		result.lastname = arr[0];
		result.firstname = arr[1];
		result.middlename = arr[2];
		console.log(result.lastname);
		url ="bage.php?lastname="+result.lastname+"&firstname="+result.firstname+"&middlename="+result.middlename;
		//window.open(url);
	}

</script>
</body>
</html>