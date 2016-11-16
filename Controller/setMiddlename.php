<?php
/**
 * Created by PhpStorm.
 * User: Александр Пенко
 * Date: 21.06.2016
 * Time: 19:45
 */

include ("../config.php");

$value = $_POST['value'];
$iduser = $_POST['iduser'];

if($value)
{
    $query = 'UPDATE `users` SET `middlename` = "' . $value . '" WHERE iduser = ' . $iduser;
    $db_conn->query($query) or die(json_encode(["exitcode" => 1, "err" => "DB error"]));
    return json_encode(["exitcode" => 0]);
}
else
    die(json_encode(["exitcode" => 1, "err" => "Empty field"]));

?>