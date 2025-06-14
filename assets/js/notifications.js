$(document).ready(function() {
    var updateNotifications = async () => {
        try {

            var config = await loadConfig();
            var siteUrl = config.siteUrl;
            
            var redSquare = $('.red-square');

            console.log("Current username:", username);

            if (username === 'Guest') {
                $('#notifications-count').text('0');
                return;
            }

            var response = await $.ajax({
                url: `${siteUrl}/api/v1/notifications.php`,  
                method: 'GET',
                data: {
                    username: username,
                    request: 'unread_count'
                },
                dataType: 'json'
            });

            console.log("API response:", response);

            if (response.status === 'success') {

                $('#notifications-count').text(response.data.count);


                if (response.data.count === 0) {
                    redSquare.addClass('red-square-zero');
                } else {
                    redSquare.removeClass('red-square-zero');
                }

            } else {

                console.error("Failed to fetch notifications:", response.message);
            }
        } catch (error) {

            console.error("Error fetching notifications:", error);
        }
    };

    updateNotifications();

    setInterval(updateNotifications, 30000);  
});

$(document).ready(function () {
    var updateNotifications = async () => {
        try {

            var config = await loadConfig();
            var siteUrl = config.siteUrl;

            console.log("Current username:", username);

            if (username === 'Guest') {
                $('#notifications-count').text('0');
                $('.mentions-container').empty();
                return;
            }

            var response = await $.ajax({
                url: `${siteUrl}/api/v1/notifications.php`,
                method: 'GET',
                data: {
                    username: username,
                    request: 'all_data'
                },
                dataType: 'json'
            });

            console.log("API response:", response);

            if (response.status === 'success') {

                $('#notifications-count').text(response.data.notifications.length);


                var notifications = response.data.notifications;
                var mentionsContainer = $('.mentions-container');
                mentionsContainer.empty(); 

                notifications.forEach(notification => {
                    var mentionHTML = `
                        <div class="mention" data-id="${notification.id}">
                            <img src="${siteUrl}/api/v1/fetch_profile_picture.php?name=${notification.sender}" 
                                 alt="PFP" 
                                 class="not-pfp-image">
                            <div class="not-text-container">
                                <div class="not-username">${notification.sender}</div>
                                <div class="not-content">${notification.content}</div>
                            </div>
                            <div class="topper">
                                <div class="hacky-fix">
                                    <div class="gplus"></div>
                                    <div class="exit" data-id="${notification.id}"></div>
                                </div>
                            </div>
                        </div>
                    `;
                    mentionsContainer.append(mentionHTML);
                });

                $('.mentions-container .exit').off('click').on('click', function () {
                    var notificationId = $(this).data('id');
                    removeNotification(notificationId, siteUrl);
                    $(this).closest('.mention').animate({
                        marginLeft: "-100%",
                        opacity: 0
                    }, 300, function() {
                        $(this).remove();
                    });                                     
                });
            } else {
                console.error("Failed to fetch notifications:", response.message);
            }
        } catch (error) {
            console.error("Error fetching notifications:", error);
        }
    };

    var removeNotification = async (notificationId, siteUrl) => {
        try {

            var requestUrl = `${siteUrl}/api/v1/notifications.php?request=read_notification&username=${encodeURIComponent(username)}&id=${encodeURIComponent(notificationId)}`;

            console.log("Request URL:", requestUrl);

            var response = await $.ajax({
                url: requestUrl,
                method: 'GET',
                dataType: 'json'
            });

            console.log(`Notification ${notificationId} removed:`, response);

            if (response.status === 'success') {
                var currentCount = parseInt($('#notifications-count').text(), 10) || 0;
                $('#notifications-count').text(Math.max(0, currentCount - 1));
            } else {
                console.error(`Failed to mark notification ${notificationId} as read:`, response.message);
            }
        } catch (error) {
            console.error(`Error marking notification ${notificationId} as read:`, error);
        }
    };

    updateNotifications();

    setInterval(updateNotifications, 20000);
});

$(document).ready(function () {
    $('#read-icon').on('click', async function() {
        try {
            var config = await loadConfig();
            var siteUrl = config.siteUrl;

            if (username === 'Guest') {
                $('#notifications-count').text('0');
                return;
            }

            var response = await $.ajax({
                url: `${siteUrl}/api/v1/notifications.php`,  
                method: 'GET',
                data: {
                    username: username,
                    request: 'read_all_notifications'
                },
                dataType: 'json'
            });

            console.log("API response for marking all as read:", response);

            if (response.status === 'success') {
                $('#notifications-count').text('0'); 
                $('.mentions-container').empty(); 
            } else {
                console.error("Failed to mark all notifications as read:", response.message);
            }
        } catch (error) {
            console.error("Error marking all notifications as read:", error);
        }
    });
});

$(document).ready(function () {
    $('.dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });
});