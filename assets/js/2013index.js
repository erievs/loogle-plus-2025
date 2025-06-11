
$(document).ready(function() {

    // stuff for checking compitibailtly

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

    // stuff to declare first (just some method used and varibles)

	var protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';
	var hostname = window.location.hostname;
	var port = window.location.port ? ':' + window.location.port : '';
	var siteUrl = protocol + hostname + port;

    function GetCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function GetNearestPostId(e) {
        var x = e.pageX;
        var y = e.pageY;
    
        var nearest = null;
        var minDistance = Infinity;
    
        $('.post-card').each(function () {
            var $el = $(this);
            var offset = $el.offset();
            var width = $el.outerWidth();
            var height = $el.outerHeight();

            var centerX = offset.left + width / 2;
            var centerY = offset.top + height / 2;
    
            var dx = x - centerX;
            var dy = y - centerY;
            var distance = Math.sqrt(dx * dx + dy * dy);
    
            if (distance < minDistance) {
                minDistance = distance;
                nearest = $el;
            }
        });
        
        return nearest ? nearest.attr('id') : null;

    }
    
    function RemoveNearestCol(e) {
        var x = e.pageX;
        var y = e.pageY;

        var nearest = null;
        var minDistance = Infinity;

        $('.col-md-4.col-sm-6.col-xs-12').each(function () {
            var $el = $(this);
            var offset = $el.offset();
            var width = $el.outerWidth();
            var height = $el.outerHeight();

            var centerX = offset.left + width / 2;
            var centerY = offset.top + height / 2;

            var dx = x - centerX;
            var dy = y - centerY;
            var distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < minDistance) {
                minDistance = distance;
                nearest = $el;
            }
        });

        if (nearest) {
            nearest.fadeOut(500);
            nearest.remove();
        }
    }

    // fetching posts


	//console.log("Site URL: ", siteUrl);

	var currentPage = 1;
	var pageSize = 15;
	var isLoading = false;
	var hasMorePosts = true;

	function FetchPosts(page) {
		if (isLoading || !hasMorePosts) return;
		isLoading = true;

		console.log(`Fetching posts for page: ${page}`);

		$.ajax({
			url: `${siteUrl}/api/v1/fetch_posts.php`,
			type: 'GET',
			data: {
				page,
				page_size: pageSize
			},
            
			success: function(response) {
		
				if (response.status === 'success' && response.data.posts.length > 0) {
					var posts = response.data.posts;

					posts.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

					posts.forEach(post => {
						var date = new Date(post.created_at);
						var options = {
							year: 'numeric',
							month: 'long',
							day: 'numeric'
						};
						var formattedDate = date.toLocaleDateString(undefined, options);

						console.log('Formatted Date:', formattedDate);
                    
						var postHtml = `
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="post-card" id=${post.id}>

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
                                    <img class="post-image" ${post.image_url ? `src="${post.image_url}"` : ''}>
                                </div>
                            </div>

                        `;


                        if(GetCookie("username") === post.username) {

                            postHtml = `

                                <div class="col-md-4 col-sm-6 col-xs-12">
                                    <div class="post-card" id=${post.id}>

                                        <div class="dropdown-post">

                                            <div class="dropdown">

                                                <p class="dropdown-icon" data-toggle="dropdown">﹀</p>

                                                <ul class="dropdown-menu" id="dropdown-menu-post">
                                                    <li><a href="#">Edit post</a></li>
                                                    <li><a class="delete-post" href="#">Delete post</a></li>
                                                    <li><a href="#">Link to post</a></li>
                                                    <li><a href="#">Disable comments</a></li>
                                                </ul>
                                            </div> 

                                        </div>

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
                                        <img class="post-image" ${post.image_url ? `src="${post.image_url}"` : ''}>
                                    </div>
                                </div>
                            `;

                        };

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

	function OnScroll() {
		if (!hasMorePosts || isLoading) return;

		var scrollY = window.scrollY;
		var windowHeight = window.innerHeight;
		var docHeight = document.documentElement.scrollHeight;

		if (scrollY + windowHeight >= docHeight - 200) {
			console.log('Near bottom, fetching more posts...');
			FetchPosts(currentPage);
		}
	}

	$(window).on('scroll', OnScroll);


	FetchPosts(currentPage);

    // deleting posts

    $(document).on('click', '.delete-post', function(e) {

        console.log("yap");

		var username = GetCookie('username');
		var password = GetCookie('password');

		var id = GetNearestPostId(e);

		console.log("Post Data: ", {
			username: username,
			password: password,
			id: id,
		});

		var formData = new FormData();

		formData.append('username', username);
		formData.append('password', password);
		formData.append('id', id);

		$.ajax({
			url: `${siteUrl}/api/v1/delete_post.php`,
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.status === 'success') {
					
                    RemoveNearestCol(e);

				} else {
					alert('Error: ' + response.message);
				}
			},
			error: function(xhr, status, error) {
				console.error('AJAX Error:', error);
				$('#submit-post').prop('disabled', false);
			}
		});

	});

    
    // plus-oneing a post



    // reverting stuff (for when you click cancel, rn just write post but latter comment writing)

    function RevertPostWriting(response) {
        
        var date = new Date(response.data.created_at);
        var options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        
        console.log(response);

        var formattedDate = date.toLocaleDateString(undefined, options);

        var postHtml = `

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="post-card" id="${response.data.id}">

                    <div class="dropdown-post">

                        <div class="dropdown">

                            <p class="dropdown-icon" data-toggle="dropdown">﹀</p>

                            <ul class="dropdown-menu" id="dropdown-menu-post">
                                <li><a href="#">Edit post</a></li>
                                <li><a class="delete-post" href="#">Delete post</a></li>
                                <li><a href="#">Link to post</a></li>
                                <li><a href="#">Disable comments</a></li>
                            </ul>
                        </div> 

                    </div>

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
                    <img class="post-image" ${response.data.image_url ? `src="${response.data.image_url}"` : ''}>
                </div>
            </div>

        `;

        $('.row').prepend(postHtml);

        $('#post-content').val('');

        $('#submit-post').prop('disabled', false);

        $('#write-post-expanded').fadeOut(function() {

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

            writePostCard.find('#write-post-card').on('click', function() {

                $(this).closest('.col-md-4').fadeOut(function() {

                    $(this).remove();

                    $('#write-post-expanded').fadeIn();
                });

                $('#write-post-expanded').css('display', 'block');
            });
        });

    }

    
    // writing posts 

	$('#write-post-card').on('click', function() {

		$(this).closest('.col-md-4').fadeOut(function() {

			$(this).remove();

			$('#write-post-expanded').fadeIn();
		});

		$('#write-post-expanded').css('display', 'block');
	});


	$('#mymotherquestionmark').on('click', function() {
		$('.attach-photos-row').hide();
		$('.upload-area').fadeIn();
		$('.write-post-footer').css('margin-top', '9    %');
	});

	$('#cancel-post').on('click', function() {
		if ($('.upload-area').is(':visible')) {
			$('.upload-area').hide();
			$('.attach-photos-row').show();
			$('.write-post-footer').css('margin-top', '12%');
		} else {
			$('#write-post-expanded').fadeOut(function() {
				var writePostCard = $(
                    '<div class="col-md-4 col-sm-6 col-xs-12">' +
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

				writePostCard.find('#write-post-card').on('click', function() {
					$(this).closest('.col-md-4').fadeOut(function() {
						$(this).remove();
						$('#write-post-expanded').fadeIn();
					});
					$('#write-post-expanded').css('display', 'block');
				});

			});
		}
	}); 


	$('#openFileDialog').on('click', function() {
		$('#image-upload').click();
	});

	/* For the future
	$('#image-upload').on('change', function() {
	    var file = this.files[0]; 
	    if (file) {
	        var reader = new FileReader();
	        reader.onload = function(e) {
	            $('#image-preview').remove();
	            var previewHtml = `<img src="${e.target.result}" id="image-preview" style="max-width: 200px; margin-top: 10px;">`;
	            $('#openFileDialog').after(previewHtml); 
	        };
	        reader.readAsDataURL(file); 
	    }
	});
	*/

    /* 
        Rememeber every time we change how posts look we must update here!!!!!!

        M̶a̶y̶b̶e̶ ̶I̶ ̶s̶h̶o̶u̶l̶d̶ ̶m̶a̶k̶e̶ ̶a̶m̶ ̶e̶t̶h̶o̶d̶ ̶o̶r̶ ̶s̶o̶m̶e̶t̶h̶i̶n̶g̶ ̶t̶o̶ ̶r̶e̶v̶e̶r̶t̶?̶
        Never mind I did!

    */

	$('#submit-post').on('click', function() {

		var username = GetCookie('username');
		var password = GetCookie('password');

		var content = $('.yap-here').val();


		console.log("Post Data: ", {
			username: username,
			password: password,
			content: content,
		});

		var formData = new FormData();
		formData.append('username', username);
		formData.append('password', password);
		formData.append('content', content);

		var imageFile = $('#image-upload')[0].files[0];
		if (imageFile) {
			formData.append('image', imageFile);
		}

		$('#submit-post').prop('disabled', true);

		$.ajax({
			url: `${siteUrl}/api/v1/submit_post.php`,
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.status === 'success') {
					
                    RevertPostWriting(response);

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