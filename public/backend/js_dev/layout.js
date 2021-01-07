$(document).ready(function(){
    // Enable pusher logging - don't include this in production
    var element = {
        notification_admin: $('.notification-admin i'),
        content_notify : $('.content-notify'),
        number_notify: $('#number-notify'),
    }
    var pusher = new Pusher('5ee265fbae0adfedf33d', {
        cluster: 'ap1',
        encrypted: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('MessageActionUser');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('send-action-user', function(data) {
        let number = element.number_notify.text();
        element.number_notify.text(Number(number) + 1);
    });

    // toggle content notify
    element.notification_admin.click(function () {
        element.content_notify.toggleClass('active_notify');
        element.number_notify.addClass('none_active');
        if(element.number_notify.text() != ' ') {
            $.ajax({
                url: element.number_notify.data('url2'),
                type: 'get',
                statusCode: {
                    200: function (data) {

                    },
                    500: function () {

                    }
                }

            });
        }
    });

    $.ajax({
        url: element.number_notify.data('url1'),
        type: 'get',
        statusCode: {
            200: function (data) {
                if(data.number != ' ') {
                    element.number_notify.text(data.number);
                } else {
                    element.number_notify.text(data.number);
                    element.number_notify.addClass('none_active');
                }
            },
            500: function () {

            }
        }

    });
});
