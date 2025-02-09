<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!defined('DEPENDENCIES_INCLUDED')) {
    include __DIR__ . '/dependencies.php';
    define('DEPENDENCIES_INCLUDED', true);
}


?>

<link href="/assets/css/2013submenu.css" rel="stylesheet">
<script src="/assets/js/subheader.js"></script>

<div class="submenu-container">
    <div class="home-icon-container">
        <i class="home-h-icon-small"></i>
        <span class="home-icon">Home </span>
        <span class="arrow-icon"> &gt; </span>
    </div>

    <ul class="nav nav-tabs" style="margin: 0 auto;" id="submenu-nav">
        <li role="presentation" id="all-item"><a href="#">All</a></li>
        <li role="presentation" id="family-item"><a href="#">Family</a></li>
        <li role="presentation" id="friends-item"><a href="#">Friends</a></li>
        <li role="presentation" class="dropdown" id="more-item">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                More <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" id="more-dropdown">
                <li><a href="#">janovski_cz stop whining</a></li>
                <li><a href="#">Reagan</a></li>
                <li><a href="#">George W. Bush</a></li>
            </ul>
        </li>
        <li role="presentation" id="about-item"><a href="#">About</a></li>
        <li role="presentation" id="posts-item"><a href="#">Posts</a></li>
        <li role="presentation" id="photos-item"><a href="#">Photos</a></li>
        <li role="presentation" id="communities-item"><a href="#">All Communities</a></li>
        <li role="presentation" id="recommended-item"><a href="#">Recommended for you</a></li>
        <li role="presentation" id="your-communities-item"><a href="#">Your Communities</a></li>
        <li role="presentation" id="everything-item"><a href="#">Everything</a></li>
    </ul>

    <div class="sidebar-container" id="sidebar-container">
        <ul class="sidebar-menu">

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/index.php">
                    <div class="home-h-icon-medium"></div>
                    <p>Home</p>
                </a>
            </span>

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/">
                    <div class="profile-h-icon-medium"></div>
                    <p>Profile</p>
                </a>
            </span>

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/">
                    <div class="people-h-icon-medium"></div>
                    <p>People</p>
                </a>
            </span>

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/">
                    <div class="photos-h-icon-medium"></div>
                    <p>Photos</p>
                </a>
            </span>

            <hr>

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/">
                    <div class="wh-h-icon-medium"></div>
                    <p>What's Hot</p>
                </a>
            </span>

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/">
                    <div class="com-h-icon-medium"></div>
                    <p>Communties</p>
                </a>
            </span>

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/">
                    <div class="events-h-icon-medium"></div>
                    <p>Events</p>
                </a>
            </span>

            <span class="icon" id="sel">
                <a class="sidebar-list" href="/">
                    <div class="settings-h-icon-medium"></div>
                    <p>Settings</p>
                </a>
            </span>


        </ul>
    </div>
</div>

