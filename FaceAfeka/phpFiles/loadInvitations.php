<?php 
include('session.php');
include('constants.php');
include('dbFunctions.php');

//get all of the owner friendships
$friendshipsQuery = "SELECT * FROM " . FRIENDSHIPS_TABLE_NAME .  " WHERE firstFriendId=" . $loginSession;
$friendshipsRes = getQueryRes($friendshipsQuery);

//make a list of friends with game options
while($friendship = mysqli_fetch_assoc($friendshipsRes)) {
    //get the friend's details from the 'users' table
    $friendQuery = "SELECT * FROM " . USERS_TABLE_NAME . " WHERE id=" . $friendship['secondFriendId'];
    $friend = fetchOne($friendQuery);
    
    buildRowInFriendsTableHtml($friend);
}

function buildRowInFriendsTableHtml($friend) {
    include('session.php');

    //get the game invitations involve this friend and the owner
    $invitationQuery = "SELECT * FROM " . GAME_INVITATIONS_TABLE_NAME .
    " WHERE (invitingFriendId=" . $friend['id'] . " AND invitedFriendId=" . $loginSession .
    ") OR (invitedFriendId=" . $friend['id'] . " AND invitingFriendId=" . $loginSession .")";
    $invitationRes = getQueryRes($invitationQuery);
    $numOfInvitations = mysqli_num_rows($invitationRes);
    
    echo "<tr><td><img src='images/blueBird1.png' height=20px>&nbsp" .
            $friend['fname'] . " " . $friend['lname'];
    echo "</td>";
    echo "<td id='tdInvite" . $friend['id'] . "'>";
    
    if($numOfInvitations > 0) {
        while($invitation = mysqli_fetch_assoc($invitationRes)) {
            if($invitation['invitingFriendId'] == $friend['id']) {
                echo "<button class='buttons joinGame' onclick='invite(".
                $friend['id'].")'>Join Game!</button>";
            } else {
                echo "<button class='buttons invited' onclick='startGame()' disabled>invited</button>";
            }
        }
    } else {
        echo "<button class='buttons invite' type='submit' name='invite' id='inviteButton' value='invite' onclick='invite(".
                $friend['id'].")'>invite to play</button>";
    }
    echo "</td>";
    echo "</tr>";
}



?>