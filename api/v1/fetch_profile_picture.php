<?php

$defaultProfilePicture = '../../assets/site_images/default_profile_picture.jpg';

function SendImage($imagePath, $imageType) {


    header(header: 'Content-Type: ' . $imageType);
    
    readfile(filename: $imagePath);

    exit();

}

// ~~uh maybe we should compress or something idk~~

if (isset($_GET['username'])) {

    $username = basename($_GET['username']);  

    $formats = ['webp', 'png', 'jpeg', 'jpg', 'gif'];

    foreach ($formats as $format) {
        $profilePicturePath = '../../assets/profile_pictures/' . $username . '.' . $format;

        if (file_exists($profilePicturePath)) {

            if ($format == 'webp') {
                SendImage($profilePicturePath, 'image/webp');
            } elseif ($format == 'png') {
                SendImage($profilePicturePath, 'image/png');
            } elseif ($format == 'jpeg' || $format == 'jpg') {
                SendImage($profilePicturePath, 'image/jpeg');
            } elseif ($format == 'gif') {
                SendImage($profilePicturePath, 'image/gif');
            }
        }
    }

    SendImage($defaultProfilePicture, 'image/jpeg');

} else {

    SendImage($defaultProfilePicture, 'image/jpeg');
}

?>