<?php
include('session.php');//includes dbConnection.php
include('constants.php'); 
include('dbFunctions.php');

//ajax call from posts.js to load all the relevant posts
//get all the posts of the owner and his friends only
$selectPosts = "SELECT Posts.id, Posts.body, Posts.datePosted, Posts.userId, Posts.privacy, Posts.likes".
" FROM " . POSTS_TABLE_NAME .
" LEFT JOIN " . FRIENDSHIPS_TABLE_NAME .
" ON Posts.userId=Friendships.secondFriendId WHERE (Friendships.firstFriendId=" . $loginSession .
" AND Posts.privacy='public') OR (Posts.userId=" . $loginSession . ") ORDER BY datePosted DESC LIMIT 8";

$res = getQueryRes($selectPosts);

while($post = mysqli_fetch_assoc($res)) {
    //get the posting user in order to build the comment with his details
    $getUserQueryString = "SELECT id, fname, lname, profilePic FROM " . USERS_TABLE_NAME . " WHERE id=" . $post['userId'];
    $user = fetchOne($getUserQueryString);

    //check if the account owner liked the post so that the like button will say "unlike"
    $checkLikeQuery = "SELECT * FROM " . LIKES_TABLE_NAME . " WHERE userId=" . $loginSession . " AND postId=" . $post['id'];
    $like = checkIfLiked($checkLikeQuery);
    $allLikesRes = getQueryRes($checkLikeQuery);

    buildPostDiv($post, $user, $like, $allLikesRes);
}

/** build the html*/
function buildPostDiv($post, $user, $like) {
    include('session.php');

    $privacy = $post['privacy'];
    $body = htmlspecialchars($post['body']);

    //if the post is public or published by the owner of the account
    if(strcasecmp($privacy, 'private') != 0|| $userId == $post['userId']) {
        echo "<div class='postDiv'>";
        echo  "<img class='profilePicture' src='";
        if(is_null($user['profilePic'])){
            echo "images/profilePicture.jpg";
        } else {
            
            echo "uploads/thumbs/user" . $user['id'] . "/" . $user['profilePic'];
        }
        echo "' width=40px height=40px>&nbsp";
        echo "<label class='userName'>";
        echo $user['fname'] . " " . $user['lname'];
        echo "</label>";

        //if the post is published by account owner create privacy button
        if($userId == $post['userId']) {
            echo "<button class='changePrivacyButton' onclick='changePrivacy(" . $post['id'] . ")'>";
            if(strcasecmp($privacy, 'private') != 0) {
                echo "Make Private";
            } else {
                echo "Make Public";
            }
            echo "</button>";
        }
        echo "<h4 class='datePosted'>";
        echo $post['datePosted'];
        echo "</h4>";
        echo "<p class='postBody'>";
        echo $body . "<br>";
        echo "</p>";

        loadPhotos($post['id']);

        echo "<div class='commentAndLikeDiv' id='commentAndLikeDiv" . $post['id'] ."'>";
        echo "<button class='buttons likeAndComment' type='submit' name='likeButton' id='likeButton'" .
            "value='like' onclick='likeButton(" . $post['id'] . ")'>" .$like ."</button>&nbsp";
        // echo "<label class='mumOfLikes'>" . $post['likes'] . " likes</label>";
       
        addAllLikes($post);
        
        echo "<button class='buttons likeAndComment' type='submit' name='commentButton' id='commentButton'" .
            " value='comment' style='float:right' onclick='commentButton(" . $post['id'] . ")'>Comment</button>";
        echo "</div>";
        echo "</div><div id='comments" . $post['id'] . "' class='commentsDiv'></div>";
        echo "<hr style='margin-top:0; margin-bottom:0.5rem' />";

    }
}

/** add the photos*/
function loadPhotos($postId) {
    include('session.php');

    $pathToThumbs = "uploads/thumbs/";
    $pathToImgs = "uploads/photos/";

    //select the photos published in the current post
    $selectPhotosQuery = "SELECT * FROM " . PHOTOS_TABLE_NAME . " WHERE postId=" . $postId;
    $selectPhotosRes = getQueryRes($selectPhotosQuery);
    $numOfPhotos = mysqli_num_rows($selectPhotosRes);

    if($numOfPhotos > 0) {
        echo "<div class='photosDiv'>";
        while($photo = mysqli_fetch_assoc($selectPhotosRes)) {
            $endingPath = "user" .$photo['userId'] . "/" . $photo['fileName'];
            echo "<a target='_blank' href='" . $pathToImgs . $endingPath . "'><img src='"
            . $pathToThumbs . $endingPath . "'></a>";
        }
        echo "</div>";
    }
}

/** mark the like button*/
function checkIfLiked($checkLikeQuery) {
    $numOfLikes = getNumOfRows($checkLikeQuery);

    if($numOfLikes > 0) {
        $like = "Unlike";
    }
    else {
        $like = "Like";
    }

    return $like;
}

/** list of likes in tooltip */
function addAllLikes($post) {
    $getLikesQuery = "SELECT * FROM " . LIKES_TABLE_NAME . " WHERE postId=" . $post['id'];

    $likesRes = getQueryRes($getLikesQuery);

    if($post['likes'] > 0) {
    echo "<div class='tooltipLikes'>" . $post['likes'] . " likes" .
    "<span class='tooltipLikestext'>"; //all the names here
        echo "<ul class='listOfLikes' style='list-style-type:none;'>";
        $num = mysqli_num_rows($likesRes);
        while($like = mysqli_fetch_assoc($likesRes)) {
            $getLikingUserQuery = "SELECT * FROM " . USERS_TABLE_NAME . " WHERE id=" . $like['userId'];
            $userRes = fetchOne($getLikingUserQuery);
            echo "<li>" . $userRes['fname'] . " " . $userRes['lname'] . "</li>";
        }
        echo "</ul>";
        echo "</span>";
        echo "</div>";
    }
}
?>