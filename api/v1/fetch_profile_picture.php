<?php

$defaultProfilePicture = '../../assets/site_images/default_profile_picture.jpg';

function serveImage($imagePath, $imageType) {
    header('Content-Type: ' . $imageType);
    readfile($imagePath);
    exit();
}

if (isset($_GET['username'])) {

    $username = basename($_GET['username']);  

    $formats = ['webp', 'png', 'jpeg', 'jpg'];

    foreach ($formats as $format) {
        $profilePicturePath = '../assets/profile_pictures/' . $username . '.' . $format;

        if (file_exists($profilePicturePath)) {

            if ($format == 'webp') {
                serveImage($profilePicturePath, 'image/webp');
            } elseif ($format == 'png') {
                serveImage($profilePicturePath, 'image/png');
            } elseif ($format == 'jpeg' || $format == 'jpg') {
                serveImage($profilePicturePath, 'image/jpeg');
            }
        }
    }

    serveImage($defaultProfilePicture, 'image/jpeg');

} else {

    serveImage($defaultProfilePicture, 'image/jpeg');
}

?>