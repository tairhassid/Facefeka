<?php
include('dbConnect.php');

if(!session_id()) {
    session_start();
}

$userId = $_SESSION['userId'];
$selectUser = "SELECT id, fname, lname, profilePic FROM Users WHERE id='$userId'";

$res = mysqli_query($conn, $selectUser);
$row = mysqli_fetch_assoc($res);

$loginSession = $row['id'];
$fname = $row['fname'];
$lname = $row['lname'];
$profilePic = $row['profilePic'];

if(!isset($_SESSION['userId'])) {
    header("location: index.php");
}


?>