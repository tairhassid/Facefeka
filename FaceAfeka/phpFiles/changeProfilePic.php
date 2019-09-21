<?php
include('session.php');
include('constants.php');

if(isset($_POST['uploadProfilePic'])) {    
    $targetDir = "uploads/photos/";
    $targetDirThumbs = "uploads/thumbs/";

    if(!empty($_FILES['profilePicFile']['name'])) {
        $uploadOk = 1;

        $fileName = $_FILES["profilePicFile"]["name"];
        $user = "user" . $loginSession;
        $newFileName = "profile_" . basename($fileName);

        $targetDirUser = $targetDir . $user . "/";
        $targetDirThumbsUser = $targetDirThumbs . $user . "/";

        $targetFile = $targetDirUser . $newFileName;
        $targetFileThumb = $targetDirThumbsUser . $newFileName;

        $check = getimagesize($_FILES['profilePicFile']['tmp_name']);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Allow certain file formats
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
   
        if(!file_exists($targetDirUser)) {
            mkdir($targetDirUser, 0755, true);
        }
        if(!file_exists($targetDirThumbsUser)) {
            mkdir($targetDirThumbsUser, 0755, true);
        }

        if ($uploadOk == 0) {
            $returnedMassage = "fail";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES['profilePicFile']['tmp_name'], $targetFile)) {
                createThumbs($targetFile, $targetFileThumb, 100);
            } else {
                $returnedMassage = "fail";
            }
        }

        $savePhotoQuery = $setLikesQuery = "UPDATE " . USERS_TABLE_NAME . " SET profilePic='" .
                            $newFileName . "' WHERE id=" . $loginSession;
        if (mysqli_query($conn, $savePhotoQuery)) {
            $returnedMassage = "success";
        } else {
            $returnedMassage = "fail";
        }
    
    }
}

function createThumbs($targetFile, $targetFileThumb, $thumbWidth) {
    $info= pathinfo($targetFile);
    $fileType = strtolower($info['extension']);
    if($fileType == 'jpg') {
        $img = imagecreatefromjpeg($targetFile);
    } else if($fileType == 'png') {
        $img = imagecreatefrompng($targetFile);
    }
        // echo "Creating thumbnail for {$targetFile} <br/>";

    $width = imagesx($img);
    $height = imagesy($img);

    // calculate thumbnail size
    $newWidth = $thumbWidth;
    $newHeight = floor($height * ($thumbWidth/ $width));

    // create a new tempoparyimage
    $tmpImg = imagecreatetruecolor($newWidth, $newHeight);

    // copy and resize old image into new image
    imagecopyresized( $tmpImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
    // save thumbnail into a file
    imagejpeg( $tmpImg, $targetFileThumb);
    
}

?>