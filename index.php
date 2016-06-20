<html>
<head>
	<title>Главная</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/statusBar.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<?php
	include ("config.php");
	?>
</head>
<body>

<?php echo file_get_contents("templates/header.tpl"); ?>

<div class="container">
	<div class="form-group"> 						
		<label for="events">Мероприятие</label>
		<br>
	<!-- 	<input id="event" class="ui-widget" type="text" class="form-control" name="event" /> -->
		<div id="events">
			<select id="event_selecter">
				<?php
				include ("Controller/Events.php");
				$events = getListOfEvents();
				echo count($events);
				if($events[0] == null)
					echo "<option id='0'>"."Нет событий"."</option>";
				else
					for($i = 0 ; $i < count($events) ; $i++)
						echo "<option id='".$events[$i]["idevent"]."'>".$events[$i]["name"]."</option>";
				?>
			</select>
		</div>
	</div>
</div>


<script type="text/javascript">


</script>

</body>
</html>

