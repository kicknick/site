<?php
/**
 * Created by PhpStorm.
 * User: Александр Пенко
 * Date: 21.06.2016
 * Time: 22:36
 */

include ("../config.php");

@$searchline = $_POST['searchline'];
$query = 'Select * from `users` where ';
if($searchline) {
    $query .= 'lastname LIKE "%' . $searchline . '%" OR ';
    $query .= 'firstname LIKE "%' . $searchline . '%" OR ';
    $query .= 'middlename LIKE "%' . $searchline . '%" OR ';
    $query .= 'CONCAT(lastname," ",firstname," ",middlename) LIKE "%' . $searchline . '%" ';
}
else
    $query = $query . '1 ';
$query .= 'LIMIT 15';
$res = $db_conn->query($query) or die('Error: cannot connect to base');
$arr = array();

while(@$row = $res->fetch_assoc())
    array_push($arr, $row);

echo json_encode($arr);

?>