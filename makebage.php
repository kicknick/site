<html>
<head>
	<title>Бэйдж</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="ias/css/imgareaselect-animated.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script type="text/javascript" src="ias/scripts/jquery.imgareaselect.js"></script>
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

<div id="content">
<h1>Отправляем изображение на сервер</h1>

<form action="bage.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
	<label for="user_pic">Отправка изображения:</label>
	<input id="user_pic" type="file" name="user_pic" size="30">
	<input type="hidden" name="foto_x" value="" />
  	<input type="hidden" name="foto_y" value="" />
  	<input type="hidden" name="x2" value="" />
  	<input type="hidden" name="y2" value="" />
  	<input type="hidden"name="foto_width" value="" />
  	<input type="hidden"name="foto_height" value="" />

	<img id="imgField">

	<input type="submit" value="Отправить">
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
            $('input[name="foto_x"]').val(selection.y1);
            $('input[name="x2"]').val(selection.x2);
            $('input[name="foto_width"]').val(selection.y2);   
            $('input[name="foto_height"]').val(selection.imageHeight);    
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
		$('#lfm').val('');
		url ="bage.php?lastname="+result.lastname+"&firstname="+result.firstname+"&middlename="+result.middlename;
		window.location.href=url;
	}

</script>
</body>
</html>