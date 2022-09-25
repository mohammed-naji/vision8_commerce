import './bootstrap';

Echo.private('App.Models.User.' + userId)
    .notification((notification) => {
        toastr.success(notification.data)
    });
