// lors du click sur le bouton de notification

function removeNotifications() {
    try {
        var Notification = document.getElementById("notifications");
        var NoNotification = document.getElementById("noNotificationsLabel");
        var AllNotificationsBadges = document.getElementsByClassName("badge-notification");

        for (var i = 0; i < AllNotificationsBadges.length; i++) {
            AllNotificationsBadges[i].style.display = "none";
        }

        Notification.style.display = "none";
        NoNotification.classList.remove("hidden");
    }
    catch (e) {}
}


document.getElementById("readNotifications").addEventListener("click", removeNotifications);