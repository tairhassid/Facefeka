<?php
include('session.php');
include('constants.php');

if(isset($_POST['post'])) {
    $id = $_POST['post'];
    $returnedMessage = "success";

    //get the relevant post
    $getPostQuery = "SELECT id, likes FROM " . POSTS_TABLE_NAME . " WHERE id=" . $id;
    $getPostRes = mysqli_query($conn, $getPostQuery);
    $numOfPosts = mysqli_num_rows($getPostRes);

    if($numOfPosts < 1) {

    }
    else {
        $post = mysqli_fetch_assoc($getPostRes);

        $checkLike = "SELECT id, postId, userId FROM " . LIKES_TABLE_NAME . " WHERE postId=$id AND userId=$loginSession";
        $checkLikeRes = mysqli_query($conn, $checkLike);
        $numOfRows = mysqli_num_rows($checkLikeRes);

        if($numOfRows > 0) {
            $like = mysqli_fetch_assoc($checkLikeRes);
            $removeLike = "DELETE FROM " . LIKES_TABLE_NAME . " WHERE id='" . $like['id'] . "'";

            if (mysqli_query($conn, $removeLike)) {
                $numOfLikes = $post['likes'] - 1;
                echo $numOfLikes;
            } 
        }
        else {
            $numOfLikes = $post['likes'] + 1;
            $addLikeQuery = "INSERT INTO " . LIKES_TABLE_NAME ." (postId, userId) VALUES ($id, $loginSession)";
            if (mysqli_query($conn, $addLikeQuery)) {
                echo $numOfLikes;
            } 
        }

        $setLikesQuery = "UPDATE " . POSTS_TABLE_NAME . " SET likes=" . $numOfLikes . " WHERE id=" . $id;
        if (mysqli_query($conn, $setLikesQuery)) {
        }     
    }    


}

?>