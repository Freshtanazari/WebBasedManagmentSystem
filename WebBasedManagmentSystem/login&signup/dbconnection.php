<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_server = "localhost";
$db_user ="root";
$db_pass = "";
$db_name = "sales";


$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if(!$conn){
    die("Failed to connect!".$mysqli_connect_error());
}
?>