<?php
include('phpFiles/session.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Facefeka</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/posts.js"> </script>
    <script type="text/javascript" src="js/search.js"> </script>
    <script type="text/javascript" src="js/photos.js"> </script>
    <link rel="stylesheet" href="style/stylesheet.css">

</head>

<body>
    <?php include("topDiv.php");?>

    <div id="bottomDivHome">
        <table id="postsTable">
            <tr>
                <td class="tdPosts">
                    <div id="sharePostDiv">
                        <div class="sharePostSubDivs">
                            <label>Create Post</label>
                        </div>

                        <div id="err"></div>
                        <form id="postForm" method="post" enctype="multipart/form-data">
                            <div class="postSubDivs">
                                <textarea id="postText" name="postText" placeholder="Write your thoughts..."></textarea>
                            </div>

                            <div style="padding: 5px;">
                                <div>
                                    <button type="button" id="addImageButton" name="addImageButton" onclick="showUploadOptions(); this.onclick=null;">
                                        <img id="cameraImage" src="images/camera.png">
                                    </button>
                                    <div class="postPhotosDiv"><input type='file' style="display: none;" name='fileToUpload[]' class='fileToUploadInput' multiple><br><br></div>
                                </div>
                                <div>
                                    <label>Who can see this?</label><br>
                                    <input type="radio" name="privacy" id="privacy" value="public" checked><label>All My friends</label>&nbsp
                                    <input type="radio" name="privacy" id="privacy" value="private"><label>Only Me</label>&nbsp&nbsp
                                    <button class="buttons" type="submit" name="shareButton" id="shareButton" value="share">share</button>   
                                </div>
                            </div>
                        </form>
                    </div>
                </td>
                <td class="tdPosts" style="padding-left: 0%;">
                    <div id="showPostsDiv">
                       
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>



</html>