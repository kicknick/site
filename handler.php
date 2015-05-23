<?php

	// getListOfEvents() Выдает массив содержащий список событий
	// getListOfUsers() Выдает массив содержащий список юзеров
	// fromResToJSON($res) По заданному массиву в php выдает в javascript JSON массив
	// makeDataList($res) По заданному массиву делает option теги с элементами массива

	$servername = "localhost";
	$dbname = "u922837214_test";
	$username = "u922837214_odael";
	$password = "lollol";
	// $servername = "localhost";
	// $dbname = "test";
	// $username = "odael";
	// $password = "lol";
	
	@$action = $_POST['action'];

	if($action == "registration") {
		registration();
	}
	if($action == "nutrition" && $usr = getUser())
		nutrition($usr);

	if($action == "lodge" && $usr = getUser() && $app = getRoom())
		lodge($usr, $app);

	if($action == 'getUsers') {
		fromPHPToJSON(getListOfUsers());
	}

	if($action == 'getUser') {
		fromPHPToJSON(getUser());
	}
	
	function getRoom() {
		global $servername, $dbname, $username, $password;

		@$room = $_POST['room'];

		$conn =  new mysqli($servername, $username, $password, $dbname);
		$conn->query("set_client='utf8'");

		if($room)
		{	
			$querry = 'SELECT * FROM `appartment` 
			WHERE `description` LIKE "'.$room.'"';
			$res = $conn->query($query);
		}

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		return $arr;
	}

	function getUser() {	
		global $servername, $dbname, $username, $password;

		@$firstname = $_POST['firstname'];
		@$lastname = $_POST['lastname'];
		@$middlename = $_POST['middlename'];
		//echo $firstname.' '.$lastname;

		$conn =  new mysqli($servername, $username, $password, $dbname);
		$conn->query("set_client='utf8'");

		if($firstname && $lastname && $middlename)
		{	
			$query = 'SELECT * FROM `users` 
			WHERE `first_name` LIKE "'.$firstname.'" AND
				`last_name` LIKE "'.$lastname.'" AND
				`middle_name` LIKE "'.$middlename.'"';
			$res = $conn->query($query);
		}

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		return $arr;
	}

	function registration(){
		global $servername, $dbname, $username, $password;
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$middlename = $_POST['middlename'];
		$email = $_POST['email'];
		$mobnumber = $_POST['mobnumber'];
		$age = $_POST['age'];
		$sex = $_POST['sex'];
		
		$conn =  new mysqli($servername, $username, $password, $dbname);
		$conn->query("set_client='utf8'");

		if($firstname)
		{	
			$query = 'INSERT INTO `users`( `first_name`, `last_name`, `middle_name`, `id_event`, `mobile_number`,`email`,`age`, `sex`) 
			VALUES ("'.$firstname.'","'.$lastname.'","'.$middlename.'",1,'.$mobnumber.',"'.$email.'",'.$age.',"'.$sex.'")';
			//echo $query;
			$conn->query($query);
		}
		echo "set to base";
	}

	function nutrition($usr){
		global $servername, $dbname, $username, $password;
		
		$start = $_POST['start'];	
		$end = $_POST['end'];	
		
		$conn =  new mysqli($servername, $username, $password, $dbname);
		$conn->query("set_client='utf8'");

		if($start && $end)
		{	
			$query = 'INSERT INTO `food`( `id_user`, `start`, `end`) 
			VALUES ('.$usr[0]["id_user"].',"'.$start.'","'.$end.'")';
			//echo $querry;
			$conn->query($query);
		}
	}

	function lodge($usr, $app){
		global $servername, $dbname, $username, $password;
		
		$start = $_POST['start'];	
		$end = $_POST['end'];	
		$room = $_POST['room'];

		$conn =  new mysqli($servername, $username, $password, $dbname);
		$conn->query("set_client='utf8'");

		if($start && $end)
		{	
			$query = 'UPDATE `users` SET `id_app`='.$app[0]["id_app"].' WHERE `id_user` = '.$usr[0]["id_user"];
			//echo $querry;
			$conn->query($query);
			$query = 'INSERT INTO `appartment`( `id_app`, `start`, `end`, `room`) 
			VALUES ('.$app[0]["id_app"].',"'.$start.'","'.$end.'", '.$room.')';
			//echo $querry;
			$conn->query($query);
		}
	}

	function getListOfEvents(){
		global $servername, $dbname, $username, $password;

		// Create connection
		$conn =  new mysqli($servername, $username, $password, $dbname);
		$conn->query("set_client='utf8'");

		$res =$conn->query("Select * from `events` where 1");
		$arr = array();
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row["description"]);
		}
		return $arr;
	}

	function getListOfUsers(){
		global $servername, $dbname, $username, $password;

		// Create connection
		$conn =  new mysqli($servername, $username, $password, $dbname);
		$conn->query("set_client='utf8'");
		$res = $conn->query('Select * from `users` where 1');
		$arr = array();
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		return $arr;
	}

	function fromPHPToJSON($res){
		$jsonres = json_encode ( $res );
		echo $jsonres;
	}	

	function makeDataList($res){
		for($i = 0 ; $i < count($res) ; $i++)
		{
			echo '<option value="'.$res[$i].'">';
		}
	}
?>