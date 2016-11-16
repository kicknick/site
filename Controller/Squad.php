<?php
/**
 * Created by PhpStorm.
 * User: Александр Пенко
 * Date: 21.06.2016
 * Time: 22:36
 */

include("/config.php");

function getSquad($squadId){
    global $db_conn;

    $query = 'Select * from `squad` where idsquad = ' . $squadId;

    $res = $db_conn->query($query) or die('Error: cannot connect to base');

    $row = $res->fetch_assoc();

    return $row;
}

?>