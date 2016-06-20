<?php
/**
 * Created by PhpStorm.
 * User: Александр Пенко
 * Date: 20.06.2016
 * Time: 17:25
 */

$servername = "localhost";
$dbname = "school_registration";
$username = "penko";
$password = "penko";

$db_conn =  new mysqli($servername, $username, $password, $dbname);
$db_conn->query("set_client='utf8'");

?>