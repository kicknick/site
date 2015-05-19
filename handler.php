<?php

	// getListOfEvents() Выдает массив содержащий список событий
	// getListOfUsers() Выдает массив содержащий список юзеров
	// fromResToJSON($res) По заданному массиву в php выдает в javascript JSON массив
	// makeDataList($res) По заданному массиву делает option теги с элементами массива


	$servername = "localhost";
	$dbname = "test";
	$username = "test";
	$password = "lol";
	$action = $_POST['action'];

	@$home = $_POST['home'];
	if($home == "registration") {
		registration();
	}
	if($home == "nutrition" && $res = isExist())
		nutrition($res);


	$action = $_POST['action'];
	if($action == 'getUsers') {
		fromPHPToJSON(getListOfUsers());
	}
	
	function isExist(){	
		global $servername, $dbname, $username, $password;

		@$firstname = $_POST['firstname'];
		@$lastname = $_POST['lastname'];
		@$middlename = $_POST['middlename'];
		echo $firstname.' '.$lastname;

		$conn = mysql_connect($servername, $username, $password);
		mysql_select_db($dbname, $conn);
		mysql_query("set_client='utf8'");

		if($firstname && $lastname && $middlename)
		{	
			$querry = 'SELECT * FROM `user` 
			WHERE `first_name` LIKE "'.$firstname.'" AND
				`last_name` LIKE "'.$lastname.'" AND
				`middle_name` LIKE "'.$middlename.'"';
			$res = mysql_query($querry);
		}
		mysql_close ($conn);
		$arr = array();

		while(@$row = mysql_fetch_array($res))
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
		$age = 12;	
		$sex = "f";
		$mobnumber = $_POST['mobnumber'];

		$conn = mysql_connect($servername, $username, $password);
		mysql_select_db($dbname, $conn);
		mysql_query("set_client='utf8'");

		if($firstname)
		{	
			$querry = 'INSERT INTO `user`( `first_name`, `last_name`, `middle_name`, `id_event`, `mobile_number`,`email`,`age`, `sex`) 
			VALUES ("'.$firstname.'","'.$lastname.'","'.$middlename.'",1,'.$mobnumber.',"'.$email.'",'.$age.',"'.$sex.'")';
			echo $querry;
			mysql_query($querry);
			$querry = "";
		}
		mysql_close ($conn);
		echo "set to base";
	}

	function nutrition($res){
		global $servername, $dbname, $username, $password;
		
		$start = $_POST['start'];	
		$end = $_POST['end'];	
		
		$conn = mysql_connect($servername, $username, $password);
		mysql_select_db($dbname, $conn);
		mysql_query("set_client='utf8'");

		if($start && $end)
		{	
			$querry = 'INSERT INTO `food`( `id_user`, `start`, `end`) 
			VALUES ('.$res[0]["id_user"].',"'.$start.'","'.$end.'")';
			echo $querry;
			mysql_query($querry);
		}
		mysql_close ($conn);
	}

	function getListOfEvents(){
		global $servername, $dbname, $username, $password;

		// Create connection
		$conn = mysql_connect($servername, $username, $password);
		mysql_select_db($dbname, $conn);
		mysql_query("set_client='utf8'");

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$res = mysql_query("Select * from `events` where 1");
		mysql_close ($conn);
		$arr = array();
		while(@$row = mysql_fetch_array($res))
		{
			array_push($arr, $row["description"]);
		}
		return $arr;
	}

	function getListOfUsers(){
		$servername = "localhost";
		$dbname = "test";
		$username = "odael";
		$password = "lol";

		// Create connection
		$conn = mysql_connect($servername, $username, $password);
		mysql_select_db($dbname, $conn);
		mysql_query("set_client='utf8'");

		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$res = mysql_query("Select * from `user` where 1");
		mysql_close ($conn);
		$arr = array();
		while(@$row = mysql_fetch_array($res))
		{
			array_push($arr, $row);
			//echo $arr[0]." ";
		}
		return $arr;
	}

	function fromPHPToJSON($res){
		$jsonres = json_encode ( $res );
		echo $res;
	}	

	function makeDataList($res){
		for($i = 0 ; $i < count($res) ; $i++)
		{
			echo '<option value="'.$res[$i].'">';
		}
	}
?>