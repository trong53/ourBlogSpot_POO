if (document.querySelector('.user-notification')!= undefined) {
    document.querySelector('.guest-homepage-user').style.opacity = '0.2';

    document.querySelector('.user-notification-close').onclick = function() {
        document.querySelector('.user-notification').style.display = 'none';
        document.querySelector('.guest-homepage-user').style.opacity = '1';
        fetch ('/notshow-notif')
    }     
}