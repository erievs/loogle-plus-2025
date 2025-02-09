$(document).ready(function() {

    var currentPage = window.location.pathname.split('/').pop();

    $('#submenu-nav li').hide();

    $('#submenu-nav li').removeClass('active');

    var defaultPage = function() {
        $('#all-item').addClass('active').show();
        $('#family-item').show();
        $('#friends-item').show();
        $('#more-item').show();
    };

    if (currentPage === 'index.php' || currentPage === '') {
        $('#all-item').addClass('active').show();
        $('#family-item').show();
        $('#friends-item').show();
        $('#more-item').show();
    } else if (currentPage === 'about.php') {
        $('#about-item').addClass('active').show();
        $('#posts-item').show();
        $('#photos-item').show();
    } else if (currentPage === 'profile.php') {
        $('#posts-item').addClass('active').show();
        $('#about-item').show();
        $('#photos-item').show();
    } else if (currentPage === 'communities.php') {
        $('#communities-item').addClass('active').show();
        $('#recommended-item').show();
        $('#your-communities-item').show();
    } else if (currentPage === 'photos.php') {
        $('#photos-item').addClass('active').show();
        $('#about-item').show();
        $('#posts-item').show();
    } else if (currentPage === 'search.php') {
        $('#everything-item').addClass('active').show();
    } else {

        defaultPage();
    }

    $('#more-dropdown li').show();

});

$(document).ready(function () {

    $(".home-icon-container").on("click", function () {
        $("#sidebar-container").toggleClass("open");
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest(".sidebar-container, .home-icon-container").length) {
            $("#sidebar-container").removeClass("open");
        }
    });
});