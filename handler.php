<?php

	$servername = "localhost";
	// $dbname = "u405631617_test";
	// $username = "u405631617_odael";
	// $password = "lollol";
	$dbname = "test";
	$username = "odael";
	$password = "lol";

	// Create connection
	$conn =  new mysqli($servername, $username, $password, $dbname);
	$conn->query("set_client='utf8'");

	@$action = $_POST['action'];

	if($action == "registration") {
		registration();
	}
	if($action == "nutrition" && $usr = getUser())
		nutrition($usr);

	if(($action == "lodge") && ($app = getRoom()) && ($usr = getUser())){
		lodge($usr, $app);
	}

	if($action == 'getUser') {
		fromPHPToJSON(getUser());
	}
	if($action == 'getUsers') {
		$event = getEvent();
		fromPHPToJSON(getListOfUsers($event));
	}

	if($action == 'getRooms') {
		fromPHPToJSON(getListOfRooms());
	}

	if($action == 'getEvents'){
		fromPHPToJSON(getListOfEvents());
	}

	if($action == 'getEvent'){
		fromPHPToJSON(getEvent());
	}

	if($action == 'usrinfo') {
		fromPHPToJSON(getUser());
	}

	function getEvent() {
		global $conn;

		@$event = $_POST['event'];
		//echo $event;
		if($event)
		{	
			$query = 'SELECT * FROM `events` 
			WHERE `description` LIKE "' . $event . '"';

			$res = $conn->query($query);
			//echo $query;
		}
		else
			return;

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		//echo $arr[0]["id_event"];
		return $arr;
	}
	
	function getRoom() {
		global $conn;

		@$id_app = $_POST['id_app'];

		if($id_app)
		{	
			$query = 'SELECT * FROM `appartment` 
			WHERE `id_app` LIKE '.$id_app;
			$res = $conn->query($query);
			//echo $query;
		}
		else
			die("Заполните все поля");

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		return $arr;
	}

	function getUser() {	
		global $conn;

		@$firstname = $_POST['firstname'];
		@$lastname = $_POST['lastname'];
		@$middlename = $_POST['middlename'];
		//echo $firstname.' '.$lastname;

		if($firstname && $lastname && $middlename)
		{	
			$query = 'SELECT * FROM `users` 
			WHERE `first_name` LIKE "'.$firstname.'" AND
				`last_name` LIKE "'.$lastname.'" AND
				`middle_name` LIKE "'.$middlename.'"';
			$res = $conn->query($query) or die("Error");
		}
		else
			die("Заполните ФИО!");

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}

		if(count($arr) == 0)
			die("Такого пользователя не существует!");

		if($arr[0]['id_app'])
		{	
			$query = 'SELECT * FROM `appartment` 
			WHERE `id_app` LIKE '.$arr[0]['id_app'];
			$res = $conn->query($query) or die("Error");
		}

		@$row = $res->fetch_assoc();
		$arr[0]['room_num'] = $row['room_num'];
		$arr[0]['hostel_num'] = $row['hostel_num'];

		if($arr[0]['id_user'])
		{	
			$query = 'SELECT * FROM `food` 
			WHERE `id_user` LIKE '.$arr[0]['id_user'];
			$res = $conn->query($query) or die("Error");
		}

		@$row = $res->fetch_assoc();
		$arr[0]['nut_start'] = $row['start'];
		$arr[0]['nut_end'] = $row['end'];

		return $arr;
	}

	function registration(){
		global $conn;
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$middlename = $_POST['middlename'];
		$email = $_POST['email'];
		$mobnumber = $_POST['mobnumber'];
		$age = $_POST['age'];
		$sex = $_POST['sex'];
		
		if($firstname && $lastname && $middlename && $mobnumber && $age && $sex)
		{
			if(!isEmailAccept($email))
				die("Некорректный eMail!");
			$query = 'INSERT INTO `users`( `first_name`, 	`last_name`, 	`middle_name`, `id_event`, 	`mobile_number`,`email`,	`age`, 		`sex`) 
			VALUES 						("'.$firstname.'","'.$lastname.'","'.$middlename.'",	1,		'.$mobnumber.',"'.$email.'",'.$age.',"'.$sex.'")';
			//echo $query;
			$conn->query($query) or die("Error");

		}
		else
			die("Заполните все поля");
	}

	function nutrition($usr){
		global $conn;
		
		$start = $_POST['start'];	
		$end = $_POST['end'];	
		//echo $start;
		$query = 'DELETE FROM `food` WHERE id_user = '.$usr[0]["id_user"];
		$conn->query($query) or die("Error");
		
		if($start && $end)
		{	
			$query = 'INSERT INTO `food`( `id_user`, `start`, `end`) 
			VALUES ('.$usr[0]["id_user"].',"'.$start.'","'.$end.'")';
			$conn->query($query) or die("Error");
		}
		else
			die("Заполните все поля");
	}

	function lodge($usr, $app){
		global $conn;
		$start = $_POST['start'];	
		$end = $_POST['end'];	
		if($start && $end)
		{	
			$query = 'UPDATE `users` SET 
					`id_app`='.$app[0]["id_app"].' , 
					`start` = "'.$start.'", 
					`end` = "'.$end.'" 
				WHERE 
					`id_user` = '.$usr[0]["id_user"];
			$conn->query($query) or die( "Error" );
		}
		else
			die("Заполните все поля");	
	}

	function getListOfEvents(){
		global $conn;

		$res =$conn->query("Select * from `events` where 1");
		$arr = array();
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row["description"]);
		}
		return $arr;
	}

	function getListOfUsers($event){
		global $conn;

		$query = 'Select * from `users` where ';
		if($event)
			$query = $query . '`id_event` LIKE ' . $event[0]['id_event'];
		else
			$query = $query . '1';


		$res = $conn->query($query);
		$arr = array();
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		return $arr;
	}

	function getListOfRooms(){
		global $servername, $dbname, $username, $password, $conn;
		$query = 'SELECT * FROM `appartment` WHERE 1';
		$res = $conn->query($query);
		$arr = array();
		$i = 0;
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
			$query = 'SELECT * FROM `users` WHERE id_app = '.$row['id_app'];
			$usrs = $conn->query($query);
			$allusr = array();
			while(@$usr = $usrs->fetch_assoc())
			{
				array_push($allusr, $usr);
			}
			$arr[$i]['users'] = $allusr;
			$arr[$i]['num'] = count($allusr);
			$i++;
		}
		usort($arr, "cmpAppCrowd");
		return $arr;
	}

	function fromPHPToJSON($res){
		echo  json_encode ( $res );
	}	

	function cmpAppCrowd($a, $b){
	    return -($a['max'] - $a['num']) + ($b['max'] - $b['num']);
	}

	function isEmailAccept($em){
		if(@count($arr = split('[@]', $em)) != 2)
			return 0;
		$site = $arr[1];
		if(count(split('[.]', $site)) >= 2)
			return 1;
		return 0;
	}
?>