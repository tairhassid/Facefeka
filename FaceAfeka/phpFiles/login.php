<?php
session_start();
include('dbFunctions.php');
include('dbConnect.php');
include('dbCreateTable.php');

if(isset($_POST['email'])) {
    $email = $_POST['email'];
    $encryptedPassword = CalculatePassword($_POST['password']);

    $selectUser = "SELECT id, email, pass FROM " . USERS_TABLE_NAME . "  WHERE email='$email' AND pass='$encryptedPassword'";
    $res = mysqli_query($conn, $selectUser);
    $numOfRows = mysqli_num_rows($res);
    if ($numOfRows < 1) {
        echo "email";
    } else {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['userId'] = $row['id'];
        header("location: ../home.php");
        echo "success";
    }
}
?>