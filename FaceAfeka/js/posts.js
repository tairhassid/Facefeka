$(document).ready(function () {
    $("#postForm").on('submit', function (e) {
        e.preventDefault();
        var postBody = $("#postText").val();
        var privacy = $('input[name=privacy]:checked').val();
        var form = new FormData(this);
        var numOfPhotos = $('.fileToUploadInput').get(0).files.length;

        if (numOfPhotos > 6) {
            $("#err").html("You can't upload more than 6 photos");
            return;
        }


        if (postBody.length == 0 && numOfPhotos == 0) {
            return;
        }

        for (let i = 0; i < numOfPhotos; i++) {
            if ($('.fileToUploadInput').get(0).files[i].size > 2000000) {
                $("#err").html("Image size should be under 2MB");
                return;

            }
        }

        $.ajax({
            url: "phpFiles/sharePost.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {},
            success: function (data) {
                if (data == "success") {
                    $("#showPostsDiv").load("phpFiles/loadPosts.php");

                    //empty all the elements that the post is composed of
                    $("#postText").val('');
                    $('input[name=privacy]').filter('[value=public]').prop('checked', true);
                    $('.fileToUploadInput').css('display', 'none');
                    $('.fileToUploadInput').val('');
                    $('#addImageButton').attr("onclick", "showUploadOptions(); this.onclick=null;");
                } else {
                    $("#err").html(data);
                }

            },
            error: function (e) {
                $("#err").html(e);
            }
        });

    });
    $("#showPostsDiv").load("phpFiles/loadPosts.php");
});

//like button pressed
function likeButton(postId) {
    var divId = "#commentAndLikeDiv" + postId;
    $.post("phpFiles/like.php", {
            post: postId
        },
        function (data, message) {

            $(divId).find(".mumOfLikes").text(data + " likes");
        })

    //change what's written on the button according to the action
    if (($(divId).find("#likeButton")).text().localeCompare("Like") == 0) {
        $(divId).find("#likeButton").text("Unlike");
    } else {
        $(divId).find("#likeButton").text("Like");
    }

}

//comment button pressed to load all comments
function commentButton(postId) {
    var divId = "#comments" + postId;
    $.post("phpFiles/comment.php", {
            post: postId
        },
        function (data, message) {
            $(divId).html(data);
        })
}

function postCommentButton(postId) {
    var divId = "#comments" + postId;
    var commentBody = $(divId).find("#commentText").val();

    if (commentBody.length == 0) {
        return;
    }

    $.post("phpFiles/comment.php", {
            commentToPost: postId,
            commentBody: commentBody
        },
        function (data, status) {
            $(data).insertBefore($(divId).find('.commentsDiv'));
        })
    $(divId).find("#commentText").val('');
}

function changePrivacy(postId) {
    alert("jquery");
    $.post("phpFiles/sharePost.php", {
            postId: postId,
            change: "changePrivacy"
        },
        function (data, success) {
            if (success == "success") {
                $("#showPostsDiv").load("phpFiles/loadPosts.php");
            }
        })
}