<html>
<head>
	<title>Главная</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="externals/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="styles/site.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<?php
	include ("config.php");
	?>
</head>
<body>

<?php echo file_get_contents("templates/header.tpl"); ?>


<div class="container">
	<h3>Мероприятие: <p id="current_event"></p></h3>

	<select id="event_selector"  class="selectpicker">
		<?php
		include ("Controller/Events.php");
		$events = getListOfEvents();
		if($events[0] == null)
			echo "<option id='0'>"."Нет событий"."</option>";
		else {
			echo "<option id='0'></option>";
			for ($i = 0; $i < count($events); $i++)
				echo "<option id='" . $events[$i]["idevent"] . "'>" . $events[$i]["name"] . "</option>";
		}
		?>
	</select>
</div>



<script type="text/javascript">
	$("#event_selector").change(function(e){
		localStorage.setItem("idevent", $("option:selected").attr("id"));
		localStorage.setItem("eventname", this.value);
		window.location ="registration.php";
	});

</script>

</body>
</html>

