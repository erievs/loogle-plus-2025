
// things for me when I am deving

$(document).ready(function() {
    var totalReplacements = 0; 

    $('script').each(function() {
        var scriptContent = $(this).html(); 
        var checkForLetConst = /\b(let|const)\b/;

        if (checkForLetConst.test(scriptContent)) {
            console.warn('Warning: "let" or "const" found in an inline script. Replacing with "var".');

            var replacementsInScript = (scriptContent.match(/\b(let|const)\b/g) || []).length;

            totalReplacements += replacementsInScript;

            var updatedScriptContent = scriptContent.replace(/\b(let|const)\b/g, 'var');

            $(this).html(updatedScriptContent);
        }
    });

    if (totalReplacements > 0) {
        console.log(`Total replacements made: ${totalReplacements}`);
    } else {
        console.log("No 'let' or 'const' found to replace.");
    }
});


$(document).ready(function () {

    $('#write-post-card').on('click', function () {

        $(this).closest('.col-md-4').fadeOut(function () {

            $(this).remove(); 

            $('#write-post-expanded').fadeIn(); 
        });

        $('#write-post-expanded').css('display', 'block'); 
    });

    $('#cancel-post').on('click', function () {

        $('#write-post-expanded').fadeOut(function () {

            var writePostCard = $('<div class="col-md-4 col-sm-6 col-xs-12">' +
                '<div class="write-post-card" id="write-post-card">' +
                    '<textarea id="post-text-area">Share what\'s new...</textarea>' +
                    '<div id="triangle-write" class="triangle-write"></div>' +
                    '<div class="post-create-icons">' +
                        '<div class="write-post-icon">' +
                            '<div class="image-write"></div>' +
                            '<br><br>' +
                            '<span style="color: black; font-weight: bold;">Text</span>' +
                        '</div>' +
                        '<div class="write-post-icon">' +
                            '<div class="image-photo"></div>' +
                            '<br><br>' +
                            '<span>Photos</span>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>');            
            
            
            $('.row').prepend(writePostCard); 

            writePostCard.fadeIn();

            writePostCard.find('#write-post-card').on('click', function () {

                $(this).closest('.col-md-4').fadeOut(function () {

                    $(this).remove(); 

                    $('#write-post-expanded').fadeIn(); 
                });

                $('#write-post-expanded').css('display', 'block'); 
            });
        });
    });
});

$(document).ready(function () {
    var protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';
    var hostname = window.location.hostname;
    var port = window.location.port ? ':' + window.location.port : '';  
    var siteUrl = protocol + hostname + port;

    console.log("Site URL: ", siteUrl);  

    var currentPage = 1;
    var pageSize = 15;
    var isLoading = false;
    var hasMorePosts = true;

    function fetchPosts(page) {
        if (isLoading || !hasMorePosts) return;  
        isLoading = true;

        console.log(`Fetching posts for page: ${page}`);

        $.ajax({
            url: `${siteUrl}/api/v1/fetch_posts.php`,
            type: 'GET',
            data: { page, page_size: pageSize },
            success: function(response) {
                console.log('API Response:', response);

                if (response.status === 'success' && response.data.posts.length > 0) {
                    var posts = response.data.posts;

                    posts.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                    posts.forEach(post => {
                        var date = new Date(post.created_at);
                        var options = { year: 'numeric', month: 'long', day: 'numeric' };
                        var formattedDate = date.toLocaleDateString(undefined, options);

                        console.log('Formatted Date:', formattedDate);

                        var postHtml = `
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="post-card">
                                <div class="post-header-top">
                                    <img src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${post.username}" 
                                        alt="${post.username}'s profile picture" 
                                        class="profile-pic-index">
                                    <div class="profile-info">
                                        <div class="profile-line1">${post.username}</div>
                                        <div class="profile-line2">Sharing Publicly <span class="post-footer">${formattedDate}</span></div>
                                    </div>
                                </div>
                                <div class="post-body">${post.content}</div>
                            </div>
                        </div>
                        `;
                        $('.row').append(postHtml);
                    });

                    if (response.pagination && response.pagination.next_url) {
                        currentPage++;
                    } else {
                        console.log('No more posts available.');
                        hasMorePosts = false;
                    }
                } else {
                    console.log('No posts returned.');
                    hasMorePosts = false;
                }

                isLoading = false;
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                isLoading = false;
            }
        });
    }

    function onScroll() {
        if (!hasMorePosts || isLoading) return;

        var scrollY = window.scrollY;
        var windowHeight = window.innerHeight;
        var docHeight = document.documentElement.scrollHeight;

        if (scrollY + windowHeight >= docHeight - 200) {  
            console.log('Near bottom, fetching more posts...');
            fetchPosts(currentPage);
        }
    }

    $(window).on('scroll', onScroll);

    fetchPosts(currentPage);
});

$(document).ready(function () {

    function getCookie(name) {
        var cookieArr = document.cookie.split(';');
        for (var i = 0; i < cookieArr.length; i++) {
            var cookie = cookieArr[i].trim();
            if (cookie.startsWith(name + "=")) {
                return cookie.substring(name.length + 1);
            }
        }
        return null;
    }    

    var protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';
    var hostname = window.location.hostname;
    var port = window.location.port ? ':' + window.location.port : '';  
    var siteUrl = protocol + hostname + port;

    console.log("Site URL: ", siteUrl);  

    $('#submit-post').on('click', function () {

        var username = getCookie('username'); 

        var password = getCookie('password'); 

        var content = $('.yap-here').val(); 

        console.log("Post Data: ", {
            username: username,
            password: password,
            content: content,
        });

        var postData = {
            username: username,
            password: password,
            content: content,
        };

        $('#submit-post').prop('disabled', true);

        $.ajax({
            url: `${siteUrl}/api/v1/submit_post.php`,  
            type: 'POST',
            data: JSON.stringify(postData),
            contentType: 'application/json',
            success: function(response) {
                if (response.status === 'success') {
                    var date = new Date(response.data.created_at);
                    var options = { year: 'numeric', month: 'long', day: 'numeric' };
                    var formattedDate = date.toLocaleDateString(undefined, options);

                    var postHtml = `
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="post-card">
                            <div class="post-header-top">
                                <img src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${response.data.username}" 
                                    alt="${response.data.username}'s profile picture" 
                                    class="profile-pic-index">
                                <div class="profile-info">
                                    <div class="profile-line1">${response.data.username}</div>
                                    <div class="profile-line2">Sharing Publicly <span class="post-footer">${formattedDate}</span></div>
                                </div>
                            </div>
                            <div class="post-body">${response.data.content}</div>
                        </div>
                    </div>
                    `;
                    $('.row').prepend(postHtml);  

                    $('#post-content').val('');

                    $('#submit-post').prop('disabled', false);

                    $('#write-post-expanded').fadeOut(function () {

                        var writePostCard = $('<div class="col-md-4 col-sm-6 col-xs-12">' +
                            '<div class="write-post-card" id="write-post-card">' +
                                '<textarea id="post-text-area">Share what\'s new...</textarea>' +
                                '<div id="triangle-write" class="triangle-write"></div>' +
                                '<div class="post-create-icons">' +
                                    '<div class="write-post-icon">' +
                                        '<div class="image-write"></div>' +
                                        '<br><br>' +
                                        '<span style="color: black; font-weight: bold;">Text</span>' +
                                    '</div>' +
                                    '<div class="write-post-icon">' +
                                        '<div class="image-photo"></div>' +
                                        '<br><br>' +
                                        '<span>Photos</span>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>');                        
                        
                        
                        $('.row').prepend(writePostCard); 
            
                        writePostCard.fadeIn();
            
                        writePostCard.find('#write-post-card').on('click', function () {
            
                            $(this).closest('.col-md-4').fadeOut(function () {
            
                                $(this).remove(); 
            
                                $('#write-post-expanded').fadeIn(); 
                            });
            
                            $('#write-post-expanded').css('display', 'block'); 
                        });
                    });

                } else {
                    alert('Error: ' + response.message);
                    $('#submit-post').prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#submit-post').prop('disabled', false);
            }
        });
    });
});


