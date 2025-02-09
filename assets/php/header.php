    <?php

        if (!defined('DEPENDENCIES_INCLUDED')) {
            include __DIR__ . '/dependencies.php';
            define('DEPENDENCIES_INCLUDED', true);
        }
        
        include __DIR__ . '/../../important/config.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!defined('INCLUDE_SUBMENU')) {
            define('INCLUDE_SUBMENU', true); 
        }

        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

    ?>

    <script>
        const username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>";
    </script>

    <link href="<?php echo SITE_URL ?>/assets/css/2013header.css" rel="stylesheet">
    <script src="<?php echo SITE_URL ?>/assets/js/notifications.js"></script>

    <script src="<?php echo SITE_URL ?>/assets/js/alert_handler.js"></script>

    <nav class="navbar navbar-default" id="header">

        <div class="site-alert">
        
        </div>

        <div class="container-fluid">

            <div class="navbar-header">
                <a class="navbar-brand" href="/index.php">
                    <img alt="Logo" src="<?php echo SITE_URL ?>/assets/site_images/logo.png" class="header-logo">
                </a>
            </div>

            <form class="navbar-form navbar-left" role="search" action="search.php" method="get">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search" name="query" id="search-box">
                </div>
                <button type="submit" id="search-button" class="btn search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <ul class="nav navbar-nav navbar-right">
                
                <li class="dropdown red-square-dropdown">
                    <a href="#s" class="dropdown-toggle red-square" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">                    
                        <p id="notifications-count">0</p>
                    </a>
                    <div class="triangle"></div> 
                    <ul class="dropdown-menu">
                        <div class="above-mentions-container">
                            <span class="title-notifications">Loogle+ Notifications</span>
                            <span id="read-icon"></span>
                        </div>
                        <div class="mentions-container">
            
                        </div>
                    </ul>
                </li>

                
                <li class="dropdown" style="background: #FFF;">
                    <a href="#" class="dropdown-toggle" data-toggle="null" role="button" aria-expanded="false" style="background: #FFF;">
                        <span id="username-header">+<?php echo htmlspecialchars($username); ?></span>
                        <img src="<?php echo SITE_URL ?>/api/v1/fetch_profile_picture.php?username=<?php echo $username ?>" alt="Profile" class="profile-pic">
                    </a>
                </li>

            </ul>
        </div>

        <?php
            if (INCLUDE_SUBMENU) {
                include __DIR__ . '/submenu.php';
            }
        ?>

    </nav>

    
