<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if (!defined('DEPENDENCIES_INCLUDED')) {
   include './assets/php/dependencies.php';
   define('DEPENDENCIES_INCLUDED', true);
}

include './account/check_login.php';

$username = isset($_SESSION['username']) ? $_SESSION['username'] : (isset($_COOKIE['username']) ? $_COOKIE['username'] : 'Not logged in');
$password = isset($_SESSION['password']) ? $_SESSION['password'] : (isset($_COOKIE['password']) ? $_COOKIE['password'] : 'Not available');


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Loogle+</title>

   <script src="/assets/js/masonry.js"></script>
   <script src="/assets/js/imagesloaded.js"></script>
   
   <link href="/assets/css/2013index.css" rel="stylesheet">
   <script src="/assets/js/2013index.js"></script>
   
</head>

<body>


   <?php include './assets/php/header.php'; ?>

   <!-- This is just for this bad boi -->
   <div class="container">
      <div class="write-post-expanded" id="write-post-expanded">

         <div class="write-post-stuff">
            <img class="profile-pic-h5n1"
               src="<?php echo SITE_URL ?>/api/v1/fetch_profile_picture.php?username=<?php echo $username ?>"
               alt="Profile Picture">

            <div class="post-content">

               <textarea class="yap-here" rows="3" placeholder="Share what's new..."></textarea>

               <div id="triangle" class="triangle"></div>
            </div>

         </div>

         <div class="attach-photos-row">
            <div class="attach">Attach</div>

            <div id="mymotherquestionmark" class="photo-icon">
               <div class="icon-row image-photo-blue"></div>
               <span>Photo</span>
            </div>

            <div id="bobisbackbutfuckhim" class="photo-icon">
               <div class="icon-row image-link"></div>
               <span>Link</span>
            </div>

            <div id="videosarebackbaby" class="photo-icon">
               <div class="icon-row image-video"></div>
               <span>Video</span>
            </div>
         </div>

         <div class="upload-area" style="display: none;">

            <div class="add-photos">Add Photos:</div>

            <button class="upload-button" id="openFileDialog">Upload from computer</button>
            <input type="file" id="image-upload" style="display:none">
         </div>



         <div class="write-post-footer">

            <button class="btn btn-primary" id="submit-post">Share</butt>
               <button class="btn btn-default" id="cancel-post">Cancel</button>

         </div>

      </div>
   </div>


   <div class="posts-container">

         <div class="write-post-card" id="write-post-card">

            <textarea id="post-text-area">Share what's new...</textarea>
            <div id="triangle-write" class="triangle-write"></div>

            <div class="post-create-icons">
               <div class="write-post-icon">
                  <div id="ue-image-write" class="image-write"></div>
                  <br> <br>
                  <span style="color: black; font-weight: bold;">Text</span>
               </div>
               
               <div class="write-post-icon">
                  <div id="ue-image-photo" class="image-photo"></div>
                  <br> <br>
                  <span class="ue-attach-photo-row-photo-icon-adjust">Photos</span>
               </div>
            </div>

         </div>


   </div>

   </div>

</body>

</html>