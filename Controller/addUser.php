<?php
/**
 * Created by PhpStorm.
 * User: Александр Пенко
 * Date: 21.06.2016
 * Time: 19:45
 */

include ("../config.php");

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$middlename = $_POST['middlename'];


if($firstname && $lastname && $middlename)
{
    $query = 'INSERT INTO `users`( `firstname`, `lastname`, `middlename`)
			VALUES ("'.$firstname.'","'.$lastname.'","'.$middlename.'")';
    $db_conn->query($query) or die(json_encode(["exitcode" => 1, "err" => "DB error"]));
    return json_encode(["exitcode" => 0]);
}
else
    die(json_encode(["exitcode" => 1, "err" => "Empty field"]));

?>