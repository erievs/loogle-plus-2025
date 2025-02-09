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
      <link href="/assets/css/2013index.css" rel="stylesheet">
      <script src="/assets/js/2013index.js"></script>
   </head>
   <body>



         <?php include './assets/php/header.php'; ?>
         
         <div class="container post-container">
            <div class="write-post-expanded" id="write-post-expanded">
               
               <div class="write-post-stuff">
                  <img class="profile-pic-h5n1" src="<?php echo SITE_URL ?>/api/v1/fetch_profile_picture.php?username=<?php echo $username ?>" alt="Profile Picture">
                  
                  
                  <div class="post-content">

                        <textarea class="yap-here" rows="3" placeholder="Share what's new..."></textarea>

                        <div id="triangle" class="triangle"></div>

                  </div>

                  </div>

                  <div class="write-post-footer">

                     <button class="btn btn-default" id="cancel-post">Cancel</button>
                     <button class="btn btn-primary" id="submit-post">Post</button>

                  </div>
               
            </div>
         </div>


         <div class="row">
            
            <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="write-post-card" id="write-post-card">
                <p>Write something...</p>
            </div>
            </div>

         </div>
      </div>
   </body>
</html>
