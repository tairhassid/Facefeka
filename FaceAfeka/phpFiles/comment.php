<?php
include('session.php');
include('constants.php');
include('dbFunctions.php');

if(isset($_POST['post'])) {
    $id = $_POST['post'];
    $returnedMessage = "success";

    $getPostQuery = "SELECT id, likes FROM " . POSTS_TABLE_NAME . " WHERE id=" . $id;
    $numOfPosts = getNumOfRows($getPostQuery);
    if($numOfPosts < 1) {
        $returnedMessage = "fail";
    }
    else {
        $getAllCommentsQuery = "SELECT id, postId, userId, body FROM " . COMMENTS_TABLE_NAME . " WHERE postId=" . $id; 
        $getCommentsRes = getQueryRes($getAllCommentsQuery);

        while($comment = mysqli_fetch_assoc($getCommentsRes)) {
            $getUserQuery = "SELECT id, fname, lname FROM " . USERS_TABLE_NAME . " WHERE id=" . $comment['userId'];
            $user = fetchOne($getUserQuery);

            echo "<div class='comment'> ";
            echo "<label class='commentingUserName'>" . $user['fname'] . " " . $user['lname'] . "</label><br>";
            echo "<p class='commentParagraph'>" . $comment['body'] . "</p>";
            echo "<hr class='hrBetweenComments'>";
            echo "</div>";
        }
        echo "<div class='commentsDiv'><textarea id='commentText' name='commentText' class='commentText' rows='1' placeholder='Write your comment...'></textarea>";
        echo "<button class='postCommentButton' type='submit' name='postCommentButton' id='postCommentButton'" .
            " value='comment' onclick='postCommentButton(" . $id . ")'>Post</button>";
        echo "</div>";

    }
}


if(isset($_POST['commentBody'])) {
    $postId = $_POST['commentToPost'];
    $commentBody = $_POST['commentBody'];

    $saveCommentQuery = "INSERT INTO " . COMMENTS_TABLE_NAME . " (postId, userId, body) VALUES ($postId, $loginSession, '$commentBody')";
    if (mysqli_query($conn, $saveCommentQuery)) {
        // echo "New comment created successfully ";
    } else {
        // echo "Error: " . $saveCommentQuery . "<br>" . mysqli_error($conn);
    }

    $getUserQuery = "SELECT id, fname, lname FROM " . USERS_TABLE_NAME . " WHERE id=" . $loginSession;
    $getUserRes = mysqli_query($conn, $getUserQuery);
    $user = mysqli_fetch_assoc($getUserRes);

    echo "<div class='comment'> ";
    echo "<label class='commentingUserName'>" . $user['fname'] . " " . $user['lname'] . "</label><br>";
    echo "<p class='commentParagraph'>" . $commentBody . "</p>";
    echo "<hr class='hrBetweenComments'>";
    echo "</div>";
    
}

?>