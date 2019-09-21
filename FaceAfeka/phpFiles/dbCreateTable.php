<?php

include('dbConnect.php');
include('constants.php');

$users = "CREATE TABLE " . USERS_TABLE_NAME . "(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(60) NOT NULL,
    lname VARCHAR(60) NOT NULL,
    email VARCHAR(60) NOT NULL UNIQUE,
    pass VARCHAR(60) NOT NULL,
    profilePic VARCHAR(60)
    )";

$query = mysqli_query($conn, $users);

$posts = "CREATE TABLE " . POSTS_TABLE_NAME . "(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    body VARCHAR(200) NOT NULL,
    datePosted DATETIME NOT NULL,
    userId INT(11) NOT NULL,
    privacy ENUM('public','private'),
    likes INT(11) NOT NULL DEFAULT 0
    )";

$query = mysqli_query($conn, $posts);

$likes = "CREATE TABLE " . LIKES_TABLE_NAME . "(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    postId INT(11) NOT NULL,
    userId INT(11) NOT NULL
    )";

$query = mysqli_query($conn, $likes);

$comments = "CREATE TABLE " . COMMENTS_TABLE_NAME . "(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    postId INT(11) NOT NULL,
    userId INT(11) NOT NULL,
    body VARCHAR(200) NOT NULL
    )";

$query = mysqli_query($conn, $comments);

$friendships = "CREATE TABLE " . FRIENDSHIPS_TABLE_NAME . "(
    firstFriendId INT(11) NOT NULL,
    secondFriendId INT(11) NOT NULL,
    PRIMARY KEY (firstFriendId, secondFriendId)
    )";

$query = mysqli_query($conn, $friendships);

$photos = "CREATE TABLE " . PHOTOS_TABLE_NAME . "(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    postId INT(11) NOT NULL,
    userId INT(11) NOT NULL,
    fileName VARCHAR(200) NOT NULL
    )";

$query = mysqli_query($conn, $photos);

$gameInvitations = "CREATE TABLE " . GAME_INVITATIONS_TABLE_NAME . "(
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    invitingFriendId INT(11) NOT NULL,
    invitedFriendId INT(11) NOT NULL
    )";

$query = mysqli_query($conn, $gameInvitations);

?>