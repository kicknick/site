<?php include("sql.php"); ?>
<?php
	@$servername = "localhost";
	@$dbname = "test";
	@$username = "test";
	@$password = "lol";

	@$home = $_POST['home'];
	if($home == "registration") {
		registration();
	}
	if($home == "nutrition" && $res = isExist())
		nutrition($res);


	$request = $_POST['request'];
	if($request == 'getUsers') {
		echo "here they are";
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
?>