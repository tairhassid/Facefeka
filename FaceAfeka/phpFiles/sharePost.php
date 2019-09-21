<?php
include('session.php');
include('constants.php'); //includes dbConnection.php

if(isset($_POST['postText'])) {
    $returnedMassage = "success";
    $postBody = mysqli_real_escape_string($conn, $_POST['postText']);
    $privacy = $_POST['privacy'];

    $query = "INSERT INTO " . POSTS_TABLE_NAME .
    " (body, datePosted, userId, privacy) VALUES ('$postBody', NOW(), $loginSession, '$privacy')";

    if (!mysqli_query($conn, $query)) {
        $returnedMassage = "fail";
        echo " insert post";
    } else {
        $returnedMassage = "success";
        $lastId = mysqli_insert_id($conn);
        $returnedMassage = savePhotos($lastId);
    }
    echo $returnedMassage;
}

function savePhotos($lastId) {
    include('session.php');
    $returnedMassage = "success";

    $targetDir = "../uploads/photos/";
    $targetDirThumbs = "../uploads/thumbs/";
    foreach($_FILES['fileToUpload']['name'] as $idx => $fileName) {
        if(!empty($_FILES['fileToUpload']['name'][$idx])) {
            $uploadOk = 1;

            $user = "user" . $loginSession;
            $post = "post" . $lastId;
            $newFileName = $post . "_" . basename($fileName);

            $targetDirUser = $targetDir . $user . "/";
            $targetDirThumbsUser = $targetDirThumbs . $user . "/";

            $targetFile = $targetDirUser . $newFileName;
            $targetFileThumb = $targetDirThumbsUser . $newFileName;

            $check = getimagesize($_FILES['fileToUpload']['tmp_name'][$idx]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            // Allow certain file formats
            $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $uploadOk = 0;
            }

            if(!file_exists($targetDirUser)) {
                mkdir($targetDirUser, 0755, true);
            }
            if(!file_exists($targetDirThumbsUser)) {
                mkdir($targetDirThumbsUser, 0755, true);
            }
    
            if ($uploadOk == 0) {
                $returnedMassage = "fail";;
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$idx], $targetFile)) {
                    createThumbs($targetFile, $targetFileThumb, 100);
                } else {
                    $returnedMassage = "fail";
                }
            }
    
            $savePhotoQuery = "INSERT INTO " . PHOTOS_TABLE_NAME .
            " (postId, userId, fileName) VALUES ($lastId, $loginSession,'$newFileName')";
    
            if (mysqli_query($conn, $savePhotoQuery)) {
                $returnedMassage = "success";
            } else {
                $returnedMassage = "fail";
            }
        }
    }
    return $returnedMassage;
}


function createThumbs($targetFile, $targetFileThumb, $thumbWidth) {
    $info= pathinfo($targetFile);
    $fileType = strtolower($info['extension']);
    if($fileType == 'jpg') {
        $img = imagecreatefromjpeg($targetFile);
    } else if($fileType == 'png') {
        $img = imagecreatefrompng($targetFile);
    }

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

if(isset($_POST['change'])) {
    $id = $_POST['postId'];

    $findPostQuery = "SELECT id, privacy FROM " . POSTS_TABLE_NAME . " WHERE id=" . $id;
    $findPostRes = mysqli_query($conn, $findPostQuery);
    $post = mysqli_fetch_assoc($findPostRes);
    echo $findPostQuery;
    if(strcasecmp($post['privacy'], 'private') == 0) {
        echo $post['privacy'];
        $privacy = "public";
    }
    else {
        echo $post['privacy'];
        $privacy = "private";
    }

    $updatePrivacyQuery = "UPDATE " . POSTS_TABLE_NAME . " SET privacy='" . $privacy . "' WHERE id=" . $id;
    echo $updatePrivacyQuery;
    if (mysqli_query($conn, $updatePrivacyQuery)) {
        echo "Privacy updated";
    }
}
?>