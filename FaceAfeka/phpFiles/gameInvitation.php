<?php
include('session.php');
include('constants.php');
include('dbFunctions.php');

/**invite a friend to the game */
if(isset($_POST['friendId'])) {
    $friendId = $_POST['friendId'];
    $returnedMessage = "success";

    $checkInvitationQuery = "SELECT * FROM " . GAME_INVITATIONS_TABLE_NAME .
                        " WHERE invitingFriendId=" . $friendId .
                        " AND invitedFriendId=" . $loginSession;
    $numOfInvitations = getNumOfRows($checkInvitationQuery);

    if($numOfInvitations > 0) {
        $returnedMessage = "exists";
    } else {
        $inviteQuery = "INSERT INTO " . GAME_INVITATIONS_TABLE_NAME .
            " (invitingFriendId, invitedFriendId) VALUES ($loginSession,  $friendId)";
        
        mysqli_query($conn, $inviteQuery);
        $returnedMessage = "success";
    }
    echo $returnedMessage;
}

/**if the friend who was invited joined the game */
if(isset($_POST['startFriendId'])) {
    $friendId = $_POST['startFriendId'];
    
    $findInviteQuery = "SELECT * FROM " . GAME_INVITATIONS_TABLE_NAME .
        " WHERE invitingFriendId=" . $friendId . " AND invitedFriendId=" . $loginSession;
    $invitation = fetchOne($findInviteQuery);

    $deleteInvitationQuery = "DELETE FROM " . GAME_INVITATIONS_TABLE_NAME . " WHERE id=" . $invitation['id'];
    mysqli_query($conn, $deleteInvitationQuery);
    
    echo $loginSession;
}
?>