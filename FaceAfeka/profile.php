<?php
include("phpFiles/changeProfilePic.php");
?>

<!DOCTYPE html>
<html>

<head>
    <title> <?php
    include('phpFiles/session.php');
    echo $fname . " " . $lname;
    ?>
    </title>    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/search.js"> </script>
    <script type="text/javascript" src="js/photos.js"> </script>
    <script type="text/javascript" src="js/gameInvite.js"> </script>
    <link rel="stylesheet" href="style/stylesheet.css">

</head>

<body>

    <?php include("topDiv.php");?>

    <div id="bottomDivHome">
        <table style='width: 100%'>
            <tr>
                <td class="tdPosts" style="padding-left: 5%;">
                <div class="profilePageSubDivs">
                    <h5>Change Profile Picture</h5><br>
                    <!--old pic-->
                    <?php
                    include('phpFiles/session.php');
                    echo  "<img class='profilePicture' src='";
                    $old = $profilePic;
                    if(is_null($old)) {
                        echo "images/profilePicture.jpg";
                    } else {
                        echo "uploads/photos/user" . $loginSession . "/" . $old;
                    }
                    echo "'height=300px width=300px>";
                    ?>
                    <br><br>
                    <div>
                    <!--upload new pic-->
                        <form action="profile.php" method="post" enctype="multipart/form-data">
                            <input type='file' name='profilePicFile' class='fileToUploadInput'><br><br>
                            <input type="submit" class="buttons" name="uploadProfilePic" value="Upload">
                        </form>
                    </div>
                </div>
                </td>
                <td class="tdPosts" style="padding-left: 5%;">
                <div class="profilePageSubDivs">
                <table style="width: 100%">
                        <tr>
                            <td>
                                <button onclick="startGame()">
                                    <img src="images/bird1.png" width=60px>
                                    Play!
                                </button>
                                <br><br>
                                <div id="err"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Friends</h5><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table id="friendsTable" style="width: 100%">
                                </table>
                            </td>
                        </tr>
                </div>
                </table>
                </td>
                
            </tr>

        </table>
    </div>

</body>

</html>