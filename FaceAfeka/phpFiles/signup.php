<?php
include('dbFunctions.php');
include('dbConnect.php');
include('dbCreateTable.php');

if(isset($_POST['fname'])) { //if a new user wants to sign up
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    //check if the user already exists by email
    $selectUser = "SELECT email FROM " . USERS_TABLE_NAME . " WHERE email='$email'";
    $res = mysqli_query($conn, $selectUser);
    $numOfRows = mysqli_num_rows($res);

    if ($numOfRows > 0) {
        echo "email";
    } else {
        $encryptedPassword = CalculatePassword($_POST['password']);

        $sql = "INSERT INTO " . USERS_TABLE_NAME .
                " (fname, lname, email, pass) VALUES ('$fname', '$lname', '$email', '$encryptedPassword')";
        
        if (!mysqli_query($conn, $sql)) {
            echo "query";
        }
    }
}
?>