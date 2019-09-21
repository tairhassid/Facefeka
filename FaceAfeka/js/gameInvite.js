$(document).ready(function () {
    $('#friendsTable').load("phpFiles/loadInvitations.php");
});

function startGame() {
    window.open('http://localhost:5000', '_target');
}

function invite(friendId) {
    var buttonId = "#inviteButton" + friendId;

    if ($('#tdInvite' + friendId).find('.joinGame').length == 1) {
        window.open('http://localhost:5000', '_target');
        $.post("phpFiles/gameInvitation.php", {
                startFriendId: friendId
            },
            function (data, success) {
                if (success == "success") {
                    alert(data);
                    $('#tdInvite' + friendId).find("button").text("invite to play");
                    $('#tdInvite' + friendId).find("button").removeClass('joinGame').addClass('invite');
                } else {
                    $('#err').html("Invitation was not sent, please try again");
                }
            })
    } else {
        $.post("phpFiles/gameInvitation.php", {
                friendId: friendId
            },
            function (data, success) {
                alert(data);
                if (data == "success") {
                    $('#tdInvite' + friendId).find('#inviteButton').text("invited");
                    $('#tdInvite' + friendId).find('#inviteButton').attr("disabled");
                    $('#tdInvite' + friendId).find("button").removeClass('invite').addClass('invited');
                } else {
                    $('#err').html("Invitation was not sent, please try again");
                }
            })
    }
    // alert(buttonId);
}