<?php

$servername= "localhost";
$username= "root";
$password= "";
$dbname= "facefeka";

$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
  die('Not connected : ' . mysql_error());
}

$db_selected = mysqli_select_db($conn, $dbname);
//create db if doesn't exist
if (!$db_selected) {
    $sql = "CREATE DATABASE $dbname";
    mysqli_query($conn, $sql);
}

?>