$(document).ready(function () {

    // stuff to declare

    var protocol = window.location.protocol === 'https:' ? 'https://' : 'http://';
    var hostname = window.location.hostname;
    var port = window.location.port ? ':' + window.location.port : '';
    var siteUrl = protocol + hostname + port;

    function GetCookie(name) {
        var decoded = decodeURIComponent(document.cookie);
        var ca = decoded.split(';');
        name = name + "=";
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function GetNearestPostId(e) {
        var x = e.pageX, y = e.pageY;
        var nearest = null;
        var minDist = Infinity;

        $('.post-card').each(function () {
            var $el = $(this);
            var offset = $el.offset();
            var centerX = offset.left + $el.outerWidth() / 2;
            var centerY = offset.top + $el.outerHeight() / 2;

            var dx = x - centerX;
            var dy = y - centerY;
            var dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < minDist) {
                minDist = dist;
                nearest = $el;
            }
        });

        return nearest ? nearest.attr('id') : null;
    }

    function RemoveNearestCol(e) {
        var x = e.pageX, y = e.pageY;
        var nearest = null;
        var minDist = Infinity;

        $('.col-md-4.col-sm-6.col-xs-12').each(function () {
            var $el = $(this);
            var offset = $el.offset();
            var centerX = offset.left + $el.outerWidth() / 2;
            var centerY = offset.top + $el.outerHeight() / 2;

            var dx = x - centerX;
            var dy = y - centerY;
            var dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < minDist) {
                minDist = dist;
                nearest = $el;
            }
        });

        if (nearest) {
            nearest.fadeOut(300, function () {
                nearest.remove();
            });
        }
    }

    function FormatText(text) {
        return text.replace(
            /(\*-(.+?)-\*)|(\*\*(.+?)\*\*)|(\*([^*]+)\*)|(_([^_]+)_)|(\+([a-zA-Z0-9_]+))|(\[b\](.+?)\[\/b\])|(\[i\](.+?)\[\/i\])|(\[s\](.+?)\[\/s\])|(\[url=(.+?)\](.+?)\[\/url\])/gi,
            function (
                match,
                strike, strikeText,
                bold, boldText,
                italic, italicText,
                underline, underlineText,
                mention, mentionName,
                bb_b, bb_bText,
                bb_i, bb_iText,
                bb_s, bb_sText,
                bb_url, bb_urlLink, bb_urlText
            ) {
                if (strike) return `<s>${strikeText}</s>`;
                if (bold) return `<b>${boldText}</b>`;
                if (italic) return `<i>${italicText}</i>`;
                if (underline) return `<i>${underlineText}</i>`;
                if (mention) return `<a href="/u/${mentionName}">+${mentionName}</a>`;
                if (bb_b) return `<b>${bb_bText}</b>`;
                if (bb_i) return `<i>${bb_iText}</i>`;
                if (bb_s) return `<s>${bb_sText}</s>`;
                if (bb_url) return `<a href="${bb_urlLink}" target="_blank" rel="noopener noreferrer">${bb_urlText}</a>`;
                return match;
            }
        );
    }

    // alert stuff

    function SetAlert(message, type) {
        var validTypes = ['info', 'success', 'warning', 'danger'];
        if (validTypes.indexOf(type) === -1) type = 'info';

        message = message
            .replace(/\n/g, '<br>')
            .replace(/\\d(.*?)\\de/g, function (_, text) {
                return '<a href="#" class="dismiss-alert-linkstyle" data-dismiss="alert" aria-label="Close">' + text + '</a>';
            });

        var alertHtml = `
            <div class="alert alert-${type} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                ${message}
            </div>`;

        $(".site-alert").html(alertHtml).fadeIn(200);
    }

    function ClearAlert() {
        $(".site-alert").fadeOut(200, function () {
            $(this).html('');
        });
    }

    // end

    // uploading pfp

    $('.upload-button-profile').on('click', function () {
        console.log("saaas");
        $('.upload-profile-picture').click();
    });

    $('.upload-profile-picture').on('change', function () {
        var file = this.files[0];
        if (!file) return;

        var validTypes = ['image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/webp'];

        if ($.inArray(file.type, validTypes) === -1) {
            SetAlert('There was an upload error. \nMake sure to upload a JPG, GIF, WEBP, or PNG file and try again. \\dDismiss\\de', 'warning');
            return;
        }

        var username = GetCookie("username");
        var password = GetCookie("password");

        var formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);
        formData.append('image', file);

        $.ajax({
            url: siteUrl + '/api/v1/upload_profile_picture.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === 'success') {
                    SetAlert('Profile picture updated!', 'success');

                    var timestamp = new Date().getTime();
                    $('.profile-dropdown-image').attr('src', siteUrl + '/api/v1/fetch_profile_picture.php?username=' + username + '&_=' + timestamp);
                } else {

                    if(res.message != "Unsupported file type") {
                        SetAlert('Error: ' + res.message, 'danger');
                    } else {
                        SetAlert('There was an upload error. \nMake sure to upload a JPG, GIF, WEBP, or PNG file and try again. \\dDismiss\\de', 'warning');
                    }
                 
                }
            },
            error: function () {
                SetAlert('Upload failed due to network or server error.', 'danger');
            }
        });
    });

    // end

    // logout 
    
    document.getElementById('logout').addEventListener('click', function (e) {
        e.preventDefault();

        document.cookie.split(";").forEach(function(cookie) {
            const eqPos = cookie.indexOf("=");
            const name = eqPos > -1 ? cookie.substr(0, eqPos).trim() : cookie.trim();
            if (name) {
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;domain=" + window.location.hostname + ";";
            }
        });

        try {
            localStorage.clear();
            sessionStorage.clear();
        } catch (e) {}

        if (window.indexedDB && indexedDB.databases) {
            indexedDB.databases().then(function(dbs) {
                let deletions = dbs.map(db => indexedDB.deleteDatabase(db.name));
                Promise.allSettled(deletions).finally(() => {
                    $('body').fadeOut(300, function () {
                        window.location.href = "/account/login.php";
                    });
                });
            });
        } else {
            $('body').fadeOut(300, function () {
                window.location.href = "/account/login.php";
            });
        }
    });

    // end

});