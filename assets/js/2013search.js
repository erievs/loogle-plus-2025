
$(document).ready(function() {

    // stuff for checking compitibailtly (idk we we will use it later just here for funs ig)

	/* var totalReplacements = 0;

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
	*/

    // stuff to declare first (just some method used and varibles)

	var protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';
	var hostname = window.location.hostname;
	var port = window.location.port ? ':' + window.location.port : '';
	var siteUrl = protocol + hostname + port;


	// some thing I found off of w3 schools works well enough
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
			
			nearest.fadeOut(300, function(){ 
				nearest.remove();
			});

        }
    }

	
	function FormatText(text) {

		text = $('<div>').text(text).html();

		text = text.replace(
			/(\*-(.+?)-\*)|(\*\*(.+?)\*\*)|(\*([^*]+)\*)|(_([^_]+)_)|(\+([a-zA-Z0-9_]+))|(\[b\](.+?)\[\/b\])|(\[i\](.+?)\[\/i\])|(\[s\](.+?)\[\/s\])|(\[url=(.+?)\](.+?)\[\/url\])/gi,
			(match,
				strike, strikeText,
				bold, boldText,
				italic, italicText,
				underline, underlineText,
				mention, mentionName,
				bb_b, bb_bText,
				bb_i, bb_iText,
				bb_s, bb_sText,
				bb_url, bb_urlLink, bb_urlText
			) => {
				if (strike) {
					return `<s>${strikeText}</s>`;
				} else if (bold) {
					return `<b>${boldText}</b>`;
				} else if (italic) {
					return `<i>${italicText}</i>`;
				} else if (underline) {
					return `<i>${underlineText}</i>`;
				} else if (mention) {
					return `<a href="/u/${mentionName}">+${mentionName}</a>`;
				} else if (bb_b) {
					return `<b>${bb_bText}</b>`;
				} else if (bb_i) {
					return `<i>${bb_iText}</i>`;
				} else if (bb_s) {
					return `<s>${bb_sText}</s>`;
				} else if (bb_url) {
					const safeURL = $('<div>').text(bb_urlLink).html();
					const safeText = $('<div>').text(bb_urlText).html();
					return `<a href="${safeURL}" target="_blank" rel="noopener noreferrer">${safeText}</a>`;
				}
				return match;
			}
		);

		return text.replace(/\n/g, "<br>");
	}

	// another thing I found online
	var GetUrlParameter = function GetUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;

		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
		return false;
	};


	// alert stuff (I wish I could have them in alert_handler but too pain in the as to figure out)

    function ClearAlert() {
        $(".site-alert").css("display: none");
    }

	function SetAlert(alert_message, alert_type) {

		var valid_alert_types = ["info", "success", "warning", "danger"];

		if (valid_alert_types.indexOf(alert_type) === -1) {
			alert_type = "info";
		}

		// \d starts a dimiss link \de ends a dismis link
		
		alert_message = alert_message
        .replace(/\n/g, '<br>')
        .replace(/\\d(.*?)\\de/g, function (_, text) {
            return '<a href="#" class="dismiss-alert-linkstyle" data-dismiss="alert" aria-label="Close">' + text + '</a>';
        });


		var alert_html = `
        <div class="alert alert-${alert_type} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            ${alert_message}
        </div>`;

		$(".site-alert").html(alert_html).fadeIn(200);
		
    }
		
	function SetSearchAlert(alert_message) {


		// \d starts a dimiss link \de ends a dismis link
		
		alert_message = alert_message
        .replace(/\n/g, '<br>')
        .replace(/\\d(.*?)\\de/g, function (_, text) {
            return '<a href="#" class="dismiss-alert-linkstyle" data-dismiss="alert" aria-label="Close">' + text + '</a>';
        });


		var alert_html = `
        <div class="alert alert-info alert-dismissible search-alert" role="alert">
            <p class="alert-search-text" >${alert_message}</p>
        </div>`;

		$(".container").prepend(alert_html).fadeIn(200);
		
    }
	// end


	// search ui stuff

	if(GetUrlParameter("query") != '') { 
		SetSearchAlert(GetUrlParameter("query"));
	}

	$('#search-box').attr('placeholder', GetUrlParameter("query")); 

	function CreateNoResultsFound() {


		console.log("men");

		SetAlert("No results found. \\dDismiss\\de", "warning")

	}

	// end
	
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
				page_size: pageSize,
				search: GetUrlParameter("query")
			},
            
			success: function(response) {
				
				if(response.status === "404") {
					CreateNoResultsFound();
				}

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

                                    <div class="post-body">${FormatText(post.content)}</div>
                                    <img class="post-image" ${post.image_url ? `src="${post.image_url}"` : ''}>

									<div class="comment-area">
									
										${post.comments && post.comments.length > 0
											? post.comments
												.slice()
												.sort(function(a, b) {
													return new Date(a.created_at) - new Date(b.created_at);
												})
												.map(comment => {
													const commentDate = new Date(comment.created_at);
													const commentFormattedDate = commentDate.toLocaleDateString(undefined, options);
													return `
														<div class="comment">
															<img src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${comment.username}" alt="${comment.username} profile picture" class="comment-pfp" />
															<div class="comment-main">
																<div class="comment-header">
																	<strong class="comment-username">${comment.username}</strong> 
																	<span class="comment-date">${commentFormattedDate}</span>
																</div>
																<div class="comment-body">
																	${FormatText(comment.content)}
																</div>
															</div>
														</div>
													`;
												}).join('')
											: ''
										}
										
									</div>

										<div class="comment-input-container" >
											<textarea type="text" placeholder="Add a comment..." class="comment-input" spellcheck="false" data-gramm="false"></textarea>
											
											<img class="submit-comment-pfp" style="display: none" src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${GetCookie("username")}">

											<div class="comment-buttons">
												<button class="submit-comment-button">Post comment</button>
												<button class="cancel-comment-button">Cancel</button>
											</div>

										</div>
						
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

                                        <div class="post-body">${FormatText(post.content)}</div>

                                        <img class="post-image" ${post.image_url ? `src="${post.image_url}"` : ''}>

										<div class="comment-area">

										${post.comments && post.comments.length > 0
											? post.comments
												.slice()
												.sort(function(a, b) {
													return new Date(a.created_at) - new Date(b.created_at);
												})
												.map(comment => {
													const commentDate = new Date(comment.created_at);
													const commentFormattedDate = commentDate.toLocaleDateString(undefined, options);
													return `
														<div class="comment">
															<img src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${comment.username}" alt="${comment.username} profile picture" class="comment-pfp" />
															<div class="comment-main">
																<div class="comment-header">
																	<strong class="comment-username">${comment.username}</strong> 
																	<span class="comment-date">${commentFormattedDate}</span>
																</div>
																<div class="comment-body">
																	${FormatText(comment.content)}
																</div>
															</div>
														</div>
													`;
												}).join('')
											: ''
										}

										</div>

										<div class="comment-input-container" >
											<textarea type="text" placeholder="Add a comment..." class="comment-input" spellcheck="false" data-gramm="false"></textarea>
											
											<img class="submit-comment-pfp" style="display: none" src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${GetCookie("username")}">

											<div class="comment-buttons">
												<button class="submit-comment-button">Post comment</button>
												<button class="cancel-comment-button">Cancel</button>
											</div>

										</div>

                                    </div>
                                </div>

                            `;

                        };

						$('.row').append(postHtml);
					});
					
		
					var pageDetails = response.data.pagination;

					console.log("Page Details:\n" + JSON.stringify(pageDetails, null, 2));

					if (pageDetails && pageDetails.next_url) {
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

	$(window).on('scroll', function(){
		if( $(window).scrollTop() > $(document).height() - $(window).height() ) {	
			FetchPosts(currentPage);
		}
	}).scroll();
	

	FetchPosts(currentPage);


	$(document).on('focus', '.comment-input', function (e) {
		
		const $input = $(this);
		const $container = $input.closest('.comment-input-container');
		const $post = $input.closest('.post-card');

		$input.stop(true, true).animate({
			height: '60px',
			width: '425px'
		}, 200);

		$post.addClass('post-expanded');

		$container.addClass('comment-container-expended');
		$container.find('.comment-buttons').fadeIn(150);
		$container.find('.submit-comment-pfp').css('display', 'block').fadeIn(150);;
	});

	$(document).on('click', '.submit-comment-button', function (e) { 
		SubmitComment(e);
	});

	$(document).on('click', '.cancel-comment-button', function (e) {
		RevertComment(e);
	});

	
	// end


	// submiting commenting and comment stuff


	function AddComment(username, content, date, postId) {
		const $post = $(`.post-card[id="${postId}"]`);
		const $commentArea = $post.find('.comment-area');

		const safeContent = $('<div>').text(content).html();

		const $newComment = $(`
			<div class="comment">
				<img src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${username}" alt="${username} profile picture" class="comment-pfp" />
				<div class="comment-main">
					<div class="comment-header">
						<strong class="comment-username">${username}</strong>
						<span class="comment-date">${date}</span>
					</div>
					<div class="comment-body">
						${safeContent}
					</div>
				</div>
			</div>
		`);

		$commentArea.append($newComment);
	}


	function SubmitComment(e) {

		var username = GetCookie('username');
		var password = GetCookie('password');

		var content = $(e.target).closest('.comment-input-container').find('.comment-input').val();

		var post_id = $(e.target).closest('[id]').attr('id');


		console.log("Post Data: ", {
			username: username,
			password: password,
			content: content,
			post_id: post_id
		});

		var formData = new FormData();
		
		formData.append('post_id', post_id);

		formData.append('username', username);
		
		formData.append('password', password);

		formData.append('content', content);

		$.ajax({
			url: `${siteUrl}/api/v1/submit_comment.php`,
			type: 'POST',
			data: JSON.stringify({
				username: username,
				password: password,
				post_id: post_id,
				content: content
			}),
			contentType: false,
			processData: false,
			success: function(response) {
				if (response.status === 'success') {
					
					RevertComment(e);

					var $commentArea = $('.comment-area');
					$commentArea.animate({ scrollTop: $commentArea.prop("scrollHeight") }, 300);

					AddComment(response.data.username, response.data.content, response.data.created_at, response.data.post_id)

				} else {

					ClearAlert();
					SetAlert("Failed to comment your post, " + response.message, "danger");

					$(this).closest('.submit-comment-button').prop('disabled', true);
				}
			},

			error: function(xhr, status, error) {
				console.error('AJAX Error:', error);
				$(this).closest('.submit-comment-button').prop('disabled', true);
			}
		});
	}

	// end
    

    // deleting posts

    $(document).on('click', '.delete-post', function(e) {

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

					ClearAlert();
					SetAlert("Failed to delete your post, " + response.message, "danger");

				}
			},

			error: function(xhr, status, error) {
				console.error('AJAX Error:', error);
				$('#submit-post').prop('disabled', false);
			}

		});

	});

	// end


    // plus-oneing a post

	// end 

    // reverting stuff (for when you click cancel, rn just write post but latter comment writing)
	function RevertComment(e) {
		const $container = $(e.target).closest('.comment-input-container');
		const $input = $container.find('.comment-input');
		const $post = $container.closest('.post-card');

		$input.val('');
		$input.stop(true, true).animate({
			height: '30px',
			width: '275px'
		}, 200);

		$post.removeClass('post-expanded');
		$container.removeClass('comment-container-expended'); // keep same typo if that's what rest of code expects
		$container.find('.comment-buttons').fadeOut(150);
		$container.find('.submit-comment-pfp').css('display', 'none').fadeOut(150);
	}


    function RevertPostWriting(response = null) {
        
		$(".yap-here").val(""); 
		$(".yap-here").attr("placeholder", "Share what's new"); 

		$("#image-upload").val(null); 

		if(response != null) {

			var date = new Date(response.data.created_at);
			var options = {
				year: 'numeric',
				month: 'long',
				day: 'numeric'
			};
			
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
						<div class="post-body">${FormatText(response.data.content)}</div>
						<img class="post-image" ${response.data.image_url ? `src="${response.data.image_url}"` : ''}>
						
						<div class="comment-area">
						
							${response.comments && response.comments.length > 0
								? post.comments
									.slice()
									.sort(function(a, b) {
										return new Date(a.created_at) - new Date(b.created_at);
									})
									.map(comment => {
										const commentDate = new Date(comment.created_at);
										const commentFormattedDate = commentDate.toLocaleDateString(undefined, options);
										return `
											<div class="comment">
												<img src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${comment.username}" alt="${comment.username} profile picture" class="comment-pfp" />
												<div class="comment-main">
													<div class="comment-header">
														<strong class="comment-username">${comment.username}</strong> 
														<span class="comment-date">${commentFormattedDate}</span>
													</div>
													<div class="comment-body">
														${FormatText(comment.content)}
													</div>
												</div>
											</div>
										`;
									}).join('')
								: ''
							}
							
						</div>

						<div class="comment-input-container" >
							<textarea type="text" placeholder="Add a comment..." class="comment-input" spellcheck="false" data-gramm="false"></textarea>
							
							<img class="submit-comment-pfp" style="display: none" src="${siteUrl}/api/v1/fetch_profile_picture.php?username=${GetCookie("username")}">

							<div class="comment-buttons">
								<button class="submit-comment-button">Post comment</button>
								<button class="cancel-comment-button">Cancel</button>
							</div>

						</div>

					</div>
					
				</div>
			`;
		}

        $('.row').prepend(postHtml);

        $('#post-content').val('');

        $('#submit-post').prop('disabled', false);

        $('#write-post-expanded').fadeOut(function() {

			var writePostCard = $(
				'<div class="col-md-4 col-sm-6 col-xs-12">' +
				  '<div class="write-post-card" id="write-post-card">' +
			  
					'<textarea id="post-text-area">Share what\'s new...</textarea>' +
			  
					'<div id="triangle-write" class="triangle-write"></div>' +
			  
					'<div class="post-create-icons">' +
			  
					  '<div class="write-post-icon">' +
						'<div id="ue-image-write" class="image-write"></div>' +
						'<br><br>' +
						'<span style="color: black; font-weight: bold;">Text</span>' +
					  '</div>' +
			  
					  '<div class="write-post-icon">' +
						'<div id="ue-image-photo" class="image-photo"></div>' +
						'<br><br>' +
						'<span class="ue-attach-photo-row-photo-icon-adjust">Photos</span>' +
					  '</div>' +
			  
					'</div>' + 
			  
				  '</div>' + 
			  
				'</div>' 
			);
			  

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

	// end

    // writing posts 

	$('#write-post-card').on('click', function() {
		

		$(this).closest('.col-md-4').fadeOut(300, function() {

			$(this).remove();

			$('#write-post-expanded').fadeIn();
		});

		$('#write-post-expanded').css('display', 'block');
	});


	$('#mymotherquestionmark').on('click', function() {
		$('.attach-photos-row').hide();
		$('.upload-area').fadeIn();
		$('.write-post-footer').css('margin-top', '9%');
	});


	$('#openFileDialog').on('click', function() {
		$('#image-upload').click();
	});


	$('#cancel-post').on('click', function() {
		RevertPostWriting();
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
		SubmitPost();
	});

	// end

	// submiting posts logic

	function SubmitPost() {
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

		if(content != null || content != "") {
			formData.append('content', content);
		}

		var imageFile = $('#image-upload')[0].files[0];

		let validTypes = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/webp'];

		if (imageFile) {

			if ($.inArray(imageFile.type, validTypes) === -1) {
				SetAlert('There was an upload error. \nMake sure to upload a JPG, GIF, WEBP, or PNG file and try again. \\dDismiss\\de', 'warning');
				return;
			}

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

					ClearAlert();
					SetAlert("Failed to submit your post, " + response.message, "danger");

					$('#submit-post').prop('disabled', false);
				}
			},

			error: function(xhr, status, error) {
				console.error('AJAX Error:', error);
				$('#submit-post').prop('disabled', false);
			}
		});
	}

	// end

});