<?php
include('session.php');
include('constants.php');

//ajax call from search.js - search results to complete the string written in the search input at any moment
if(isset($_GET['q'])) {
    $q=$_GET['q'];
    $sql = "";
    
    if(strcmp($q, '*') == 0){
        $sql = "SELECT * FROM ". USERS_TABLE_NAME;
    }
    else {
        $sql="SELECT * FROM ". USERS_TABLE_NAME . " WHERE CONCAT( fname, ' ', lname ) LIKE '%" . $q . "%'" .
        " AND id != $loginSession";
    }
    
    $result = mysqli_query($conn,$sql);
    
    echo "<table class='searchResultTable'>";
    
    while($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td><button class='searchResultButton' onclick='addFriend(" . $row['id'] . 
        ")'>" . $row['fname'] . " " . $row['lname'] . "</button></td>";
        echo "</tr>";
    }
    echo "</table>";
}

//add friend- ajax call from search.js
if(isset($_POST['user'])) {
    $id = $_POST['user'];

    if($id != $loginSession) {
        $addFriendshipQuery = "INSERT INTO " . FRIENDSHIPS_TABLE_NAME . " (firstFriendId, secondFriendId) VALUES " . 
        "($loginSession, $id)";
    
        if (mysqli_query($conn, $addFriendshipQuery)) {
            echo "success";
        } else {
            echo "Error: " . $addFriendshipQuery . "<br>" . mysqli_error($conn);
        }
    }
}
?>