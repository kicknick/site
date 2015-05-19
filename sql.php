<?php
	// getListOfEvents() Выдает массив содержащий список событий
	// getListOfUsers() Выдает массив содержащий список юзеров
	// fromResToJSON($res) По заданному массиву в php выдает в javascript JSON массив
	// makeDataList($res) По заданному массиву делает option теги с элементами массива


	function getListOfEvents(){
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

		$res = mysql_query("Select * from `events` where 1");
		mysql_close ($conn);
		$arr = array();
		while(@$row = mysql_fetch_array($res))
		{
			array_push($arr, $row["description"]);
		}
		return $arr;
	}

	function getListOfUser(){
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
		echo '<script> var res = '.$jsonres.';</script><br>';
	}	

	function makeDataList($res){
		for($i = 0 ; $i < count($res) ; $i++)
		{
			echo '<option value="'.$res[$i].'">';
		}
	}
?>