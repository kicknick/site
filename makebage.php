<html>
<head>
	<title>Бэйдж</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="externals/css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="externals/ias/css/imgareaselect-animated.css">
    <link rel="stylesheet" type="text/css" href="styles/statusBar.css">

  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script type="text/javascript" src="externals/ias/scripts/jquery.imgareaselect.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script type="text/javascript" src="js/custom.js"></script>



</head>
<body>

<?php echo file_get_contents("templates/header.tpl"); ?>

<?php echo file_get_contents("templates/currentEvent.tpl"); ?>

<form action="bage.php" method="post" enctype="multipart/form-data" onsubmit="lol()">
	<div class="container" id="form_content">
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
			</div>
			<script type="text/javascript">
				setFieldFromLS("#lastName","lastname");
				setFieldFromLS("#firstName","firstname");
				setFieldFromLS("#middleName","middlename");
			</script>
		</div>
		<div class="col-md-4">
			<label for="user_pic">Отправка изображения:</label>
			<input id="user_pic" type="file" class="btn btn-default" name="user_pic" size="30" accept="image/*" onchange="openFile(event)">
			<br>
			<input type="hidden" name="foto_x" value="" />
			<input type="hidden" name="foto_y" value="" />
			<input type="hidden" name="foto_width" value="" />
			<input type="hidden" name="foto_height" value="" />
			<input type="hidden" id="event" name="event" value="" />
			<input type="hidden" id="usertype" name="usertype" value="" />
			<input type="submit" class="btn btn-default" value="Получить бэйдж">
		</div>
		<div class="col-md-4">
			<img id="imgField" style="max-width: 400px;">
		</div>
	</div>
</form>



<script type="text/javascript">

	var lol = function(){
		alert($("#lastName").val());
	}

	 var result = {action: "bage", firstname: null, lastname: null, middlename: null, start: null, end: null, event: null, usertype: null};

	$(function() {
		$("#user_pic").val("");
	});


	 var openFile = function(event) { // Handle input[type:file] and make a preview
		 var input = event.target;

		 var reader = new FileReader();
		 reader.onload = function(){
			 var dataURL = reader.result;
			 var output = document.getElementById('imgField');
			 output.src = dataURL;
			 handleImgInit();
		 };
		 $.when(reader.readAsDataURL(input.files[0])).then(handleImgInit());
	 };


	var handleImgInit = function() {
		$("#imgField").imgAreaSelect({
			aspectRatio: '1:1',
			x1: 0,
			y1: 0,
			x2: 0,
			y2: 0,
	       	onSelectEnd: function (img, selection) { 
	            $('input[name="foto_x"]').val(selection.x1);
	            $('input[name="foto_y"]').val(selection.y1);
	            $('input[name="foto_width"]').val(selection.x2 - selection.x1);   
	            $('input[name="foto_height"]').val(selection.y2 - selection.y1); 
	            $('input[name="event"]').val(localStorage.getItem('event'));

	            console.log(selection.x1); 
	            console.log(selection.y1); 
	            console.log(selection.x2); 
	            console.log(selection.y2); 
			}
	    });
	} 



	var url = "handler.php";
	var sendReq = function(params, callback) {
		$.post(url, params, function(data) {
			callback(data);
		});
	}

	var users;


	// var sendData = function() {
	// 	console.log("dfdf");
	// 	var res = $( "#lfm" ).val()
	// 	var arr = res.split(' ');
	// 	result.lastname = arr[0];
	// 	result.firstname = arr[1];
	// 	result.middlename = arr[2];
	// 	result.event = localStorage.getItem("event");
	// 	result.usertype = "abit"; ////////////////////////////////////////////////////////////// 1!!!!11!1!!!1111!1!!!11!1
	// 	console.log(result.lastname);
	// 	url ="bage.php?lastname="+result.lastname+"&firstname="+result.firstname+"&middlename="+result.middlename;
	// 	//window.open(url);
	// }*/


</script>
</body>
</html>