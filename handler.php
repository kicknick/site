<?php

	$servername = "localhost";
	$dbname = "u922837214_test";
	$username = "u922837214_odael";
	$password = "lollol";

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

	if($action == 'getUsers') {
		fromPHPToJSON(getListOfUsers());
	}

	if($action == 'getUser') {
		fromPHPToJSON(getUser());
	}

	if($action == 'getUser') {
		fromPHPToJSON(getUser());
	}

	if($action == 'usrinfo') {
		fromPHPToJSON(getUser());
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
			$res = $conn->query($query);
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

		$query = 'DELETE FROM `food` WHERE id_user = '.$usr[0]["id_user"];
		$conn->query($query);

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
					`start` ='.$start.', 
					`end` = '.$end.' 
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

	function getListOfUsers(){
		global $conn;

		$res = $conn->query('Select * from `users` where 1');
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
	    return $a['num'] - $b['num'];
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