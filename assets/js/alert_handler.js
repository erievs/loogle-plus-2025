$(document).ready(function () {
    alert_handler();

    function getCookie(name) {
        let cookieArr = document.cookie.split(";");
        for (let i = 0; i < cookieArr.length; i++) {
            let cookie = cookieArr[i].trim();
            if (cookie.startsWith(name + "=")) {
                return cookie.substring(name.length + 1);
            }
        }
        return null;
    }

    function alert_handler() {

        if (getCookie("hide_alerts") === "true") {
            console.log("Alerts are hidden due to cookie.");
            return; 
        }

        $.getJSON("/assets/json/active_alert.json", function (data) {
            if (data && data.alert_message && data.alert_type) {
                var alert_message = data.alert_message;
                var alert_type = data.alert_type;

                var valid_alert_types = ["info", "success", "warning", "danger"];
                if (valid_alert_types.indexOf(alert_type) === -1) {
                    alert_type = "info";
                }

                var alert_html =
                    '<div class="alert alert-' +
                    alert_type +
                    ' alert-dismissible" role="alert">';
                alert_html +=
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                alert_html += '<span aria-hidden="true">&times;</span></button>';
                alert_html += alert_message;
                alert_html += "</div>";

                $(".site-alert").html(alert_html);
            }
        }).fail(function () {
            console.log("Error: active_alert.json not found.");
        });
    }
});