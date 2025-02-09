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

            var writePostCard = $('<div class="col-md-4 col-sm-6 col-xs-12"><div class="write-post-card" id="write-post-card"><p>Write something...</p></div></div>');
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

    const protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';
    const hostname = window.location.hostname;
    const port = window.location.port ? ':' + window.location.port : '';  
    const siteUrl = protocol + hostname + port;

    console.log("Site URL: ", siteUrl);  

    let currentPage = 1;  
    const pageSize = 15;  
    let isLoading = false;  
    let hasMorePosts = true;  

    function fetchPosts(page) {

        isLoading = true;
        console.log('Fetching posts for page:', page);  

        $.ajax({
            url: `${siteUrl}/api/v1/fetch_posts.php`,
            type: 'GET',
            data: {
                page: page,
                page_size: pageSize,
            },
            success: function(response) {
                console.log('API Response:', response);  

                if (response.status === 'success') {
                    let posts = response.data.posts;

                    // Sort posts by created_at in descending order
                    posts = posts.sort(function(a, b) {
                        return new Date(b.created_at) - new Date(a.created_at);
                    });

                    posts.forEach(function(post) {
                        const date = new Date(post.created_at);
                        
                        const options = { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        };

                        const formattedDate = date.toLocaleDateString(undefined, options);

                        console.log('Formatted Date:', formattedDate); 

                        const postHtml = `
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
                    console.error('API Error:', response.message);  
                }

                isLoading = false;  
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);  
                isLoading = false;
            }
        });
    }

    window.addEventListener('scroll', onScroll);

    function onScroll() {
        const columns = document.querySelectorAll('.post-container');  
        let nearBottom = false;

        columns.forEach(column => {
            const columnBottom = column.getBoundingClientRect().bottom;  
            const viewportBottom = window.innerHeight + window.scrollY;  

            console.log('Column Bottom:', columnBottom);  
            console.log('Viewport Bottom:', viewportBottom);  

            if (columnBottom <= viewportBottom + 100) {
                nearBottom = true;
            }
        });

        if (nearBottom) {
            console.log('Near the bottom, fetching more posts...');
            fetchPosts(currentPage);  
            currentPage++;  
        }
        
    }

});

$(document).ready(function () {

    function getCookie(name) {
        let cookieArr = document.cookie.split(';');
        for (let i = 0; i < cookieArr.length; i++) {
            let cookie = cookieArr[i].trim();
            if (cookie.startsWith(name + "=")) {
                return cookie.substring(name.length + 1);
            }
        }
        return null;
    }    

    const protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';
    const hostname = window.location.hostname;
    const port = window.location.port ? ':' + window.location.port : '';  
    const siteUrl = protocol + hostname + port;

    console.log("Site URL: ", siteUrl);  

    $('#submit-post').on('click', function () {

        const username = getCookie('username'); 
        const password = getCookie('password'); 

        const content = $('.yap-here').val(); 

        console.log("Post Data: ", {
            username: username,
            password: password,
            content: content,
        });

        const postData = {
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
                    const date = new Date(response.data.created_at);
                    const options = { year: 'numeric', month: 'long', day: 'numeric' };
                    const formattedDate = date.toLocaleDateString(undefined, options);

                    const postHtml = `
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

                        var writePostCard = $('<div class="col-md-4 col-sm-6 col-xs-12"><div class="write-post-card" id="write-post-card"><p>Write something...</p></div></div>');
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


