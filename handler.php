<?php


	include ("config.php");
	// Create connection


	@$action = $_POST['action'];

	if($action == "registration") {
		$event = getEvent();
		registration($event);
	}
	if($action == "nutrition" && $usr = getUser())
		nutrition($usr);

	if(($action == "lodge") && ($usr = getUser())){
		$app = getRoom();
		lodge($usr, $app);
	}

	if($action == 'getUser') {
		fromPHPToJSON(getUser());
	}

	if($action == 'getUsers') {
		$event = getEvent();
		fromPHPToJSON(getListOfUsers($event));
	}

	if($action == 'getOldUsers') {
		//$event = getEvent();
		fromPHPToJSON(getOldUsers());
	}

	if($action == 'getOldUser') {
		fromPHPToJSON(getOldUser());
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
		global $db_conn;

		@$event = $_POST['event'];
		//die($event);
		//echo $event;
		if($event)
		{	
			$query = 'SELECT * FROM `events` 
			WHERE `description` LIKE "' . $event . '"';

			$res = $db_conn->query($query);
			//echo $query;
		}
		else
			return;

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		//die($arr[0]['id_event']);
		//echo $arr[0]["id_event"];
		return $arr;
	}
	
	function getRoom() {
		global $db_conn;

		@$id_app = $_POST['id_app'];

		if($id_app)
		{	
			$query = 'SELECT * FROM `appartment` 
			WHERE `id_app` LIKE '.$id_app;
			$res = $db_conn->query($query);
			//echo $query;
		}
		else
			return 0;;

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		return $arr;
	}

	function getUser($firstname, $lastname, $middlename) {
		global $db_conn;

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
			$res = $db_conn->query($query) or die("Error");
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
			$res = $db_conn->query($query) or die("Error");
		}

		@$row = $res->fetch_assoc();
		$arr[0]['room_num'] = $row['room_num'];
		$arr[0]['hostel_num'] = $row['hostel_num'];

		if($arr[0]['id_user'])
		{	
			$query = 'SELECT * FROM `food` 
			WHERE `id_user` LIKE '.$arr[0]['id_user'];
			$res = $db_conn->query($query) or die("Error");
		}

		@$row = $res->fetch_assoc();
		$arr[0]['nut_start'] = $row['start'];
		$arr[0]['nut_end'] = $row['end'];

		return $arr;
	}

	function getUserBy($firstname, $lastname, $middlename) {	
		global $db_conn;

		//@$firstname = $_POST['firstname'];
		// @$lastname = $_POST['lastname'];
		 // @$middlename = $_POST['middlename'];
		//echo $firstname.' '.$lastname;

		if($firstname && $lastname && $middlename)
		{	
			$query = 'SELECT * FROM `users` 
			WHERE `first_name` LIKE "'.$firstname.'" AND
				`last_name` LIKE "'.$lastname.'" AND
				`middle_name` LIKE "'.$middlename.'"';
			$res = $db_conn->query($query) or die("Error");
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
			$res = $db_conn->query($query) or die("Error");
		}

		@$row = $res->fetch_assoc();
		$arr[0]['room_num'] = $row['room_num'];
		$arr[0]['hostel_num'] = $row['hostel_num'];

		if($arr[0]['id_user'])
		{	
			$query = 'SELECT * FROM `food` 
			WHERE `id_user` LIKE '.$arr[0]['id_user'];
			$res = $db_conn->query($query) or die("Error");
		}

		@$row = $res->fetch_assoc();
		$arr[0]['nut_start'] = $row['start'];
		$arr[0]['nut_end'] = $row['end'];

		return $arr;
	}

	function registration($event){

	}

	function nutrition($usr){
		global $db_conn;
		
		$start = $_POST['start'];	
		$end = $_POST['end'];	
		//echo $start;
		$query = 'DELETE FROM `food` WHERE id_user = '.$usr[0]["id_user"];
		$db_conn->query($query) or die("Error");
		
		if($start && $end)
		{	
			$query = 'INSERT INTO `food`( `id_user`, `start`, `end`) 
			VALUES ('.$usr[0]["id_user"].',"'.$start.'","'.$end.'")';
			$db_conn->query($query) or die("Error");
		}
		else
			die("Заполните все поля");
	}

	function lodge($usr, $app){
		global $db_conn;
		$start = $_POST['start'];	
		$end = $_POST['end'];	
		if($start && $end && $app)
		{	
			$query = 'UPDATE `users` SET 
					`id_app`='.$app[0]["id_app"].' , 
					`start` = "'.$start.'", 
					`end` = "'.$end.'" 
				WHERE 
					`id_user` = '.$usr[0]["id_user"];
			$db_conn->query($query) or die( "Error" );
		}
		else if(!$app)
		{
			$query = 'UPDATE `users` SET 
					`id_app`= 0 , 
					`start` = "'.$start.'", 
					`end` = "'.$end.'" 
				WHERE 
					`id_user` = '.$usr[0]["id_user"];
			$db_conn->query($query) or die( "Error" );
		}
		else
			die("Заполните все поля");	
		
	}



	function getListOfUsers($event){
		global $db_conn;

		$query = 'Select * from `users` where ';
		if($event)
			$query = $query . '`id_event` LIKE ' . $event[0]['id_event'];
		else
			$query = $query . '1';


		$res = $db_conn->query($query) or die('Error: cannot connect to base');
		$arr = array();
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}

		$l = count($arr);
		for($i = 0 ; $i < $l ; $i++)
		{
			$usr = getUserBy($arr[$i]['first_name'], $arr[$i]['last_name'], $arr[$i]['middle_name']);
			$arr[$i]['room_num'] = $usr[0]['room_num'];
			$arr[$i]['hostel_num'] = $usr[0]['hostel_num'];
			$arr[$i]['nut_start'] = $usr[0]['nut_start'];
			$arr[$i]['nut_end'] = $usr[0]['nut_end'];
		}

		usort($arr, "cmpUsrName");

		return $arr;
	}

	function getOldUsers(){
		global $db_conn;

		$query = 'Select `fio` from `Flat_table` where 1';

		$res = $db_conn->query($query) or die('Error: cannot connect to base');

		$arr = array();
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}

		return $arr;
	}

	function getOldUser(){
		global $db_conn;

		@$firstname = $_POST['firstname'];
		@$lastname = $_POST['lastname'];
		@$middlename = $_POST['middlename'];
		$fio = $lastname.' '.$firstname.' '.$middlename;

		if($fio)
		{	
			$query = 'SELECT * FROM `Flat_table` 
			WHERE `fio` LIKE "'.$fio.'"';
			$res = $db_conn->query($query) or die("Error");
		}
		else
			die("Заполните ФИО!");

		$arr = array();

		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
		}
		return $arr;
	}

	function getListOfRooms(){
		global $servername, $dbname, $username, $password, $db_conn;
		$query = 'SELECT * FROM `appartment` WHERE 1';
		$res = $db_conn->query($query);
		$arr = array();
		$i = 0;
		while(@$row = $res->fetch_assoc())
		{
			array_push($arr, $row);
			$query = 'SELECT * FROM `users` WHERE id_app = '.$row['id_app'];
			$usrs = $db_conn->query($query);
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

	function cmpUsrName($a, $b){
	    //return $a['lastname'].localeCompare($b['lastname']);
	    //return ( ( $a['lastname'] == $b['lastname'] ) ? 0 : ( ( $a['lastname'] > $b['lastname'] ) ? 1 : -1 ) );
	    if($a['last_name'] > $b['last_name'])
	    	return 1;
	    else if($b['last_name'] > $a['last_name'])
	    	return -1;
	    return 0;
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