<?php 

$user = 'root';
$password = 'root';
$db = 'dodopizza';
$host = 'localhost';

$mysqli = new mysqli($host,$user,$password,$db,);
if ($mysqli->connect_error) {
    die ("error rom MYDAK" . $mysqli->connect_error); 
}
?>