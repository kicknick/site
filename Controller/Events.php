<?php
/**
 * Created by PhpStorm.
 * User: Александр Пенко
 * Date: 20.06.2016
 * Time: 17:37
 */

include ("config.php");
function getListOfEvents(){
    global $db_conn;

    $res =$db_conn->query("Select * from `events` where 1");
    $arr = array();
    while(@$row = $res->fetch_assoc())
    {
        array_push($arr, $row);
    }
    return $arr;
}

?>