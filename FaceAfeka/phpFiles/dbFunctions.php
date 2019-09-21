<?php


function CalculatePassword($pass) {
    $pass=$pass[0].$pass.$pass[0]; // 12345-->123455
    $pass=md5($pass);

    return $pass;
}

function getQueryRes($queryString) {
    include("dbConnect.php");
    return mysqli_query($conn, $queryString);
}

function getNumOfRows($queryString) {
    $res = getQueryRes($queryString);
    return mysqli_num_rows($res);
}

function fetchOne($queryString) {
    $res = getQueryRes($queryString);
    return mysqli_fetch_assoc($res);
}

?>