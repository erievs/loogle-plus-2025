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

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    if (getCookie("hide_alerts") === "true") {
        $("#hide-alerts-checkbox").prop("checked", true);
    }

    $("#hide-alerts-checkbox").on("change", function () {
        if ($(this).is(":checked")) {
            setCookie("hide_alerts", "true", 7); 
        } else {
            setCookie("hide_alerts", "false", 7); 
        }
    });

});