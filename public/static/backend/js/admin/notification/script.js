var arrNoti = [];
var notification = {
    init: function () {
        $.ajax({
            url: laroute.route('admin.notification.add-notification'),
            method: "POST",
            data: {},
            success: function (res) {
                // $.ajax({
                //     url: laroute.route('admin.notification.add-notification-log'),
                //     method: "POST",
                //     data: {},
                //     success: function (res) {
                //     }
                // });
            }
        });
    },
    notificationLog: function () {
        $.ajax({
            url: laroute.route('admin.notification.get-notification-log'),
            method: "POST",
            data: {},
            global: false,
            success: function (res) {
                let count = 0;
                let countNew = 0;
                $('.div-notification').empty();
                jQuery.each(res, function (key, val) {
                    count++;
                    arrNoti.push(val.notification_log_id);
                    if (count <= 10) {
                        let tpl = $('#record-notification').html();
                        tpl = tpl.replace(/{title}/g, val.title);

                        var date = new Date(val.date_created);
                        let day = date.getDate();
                        let month = date.getMonth() + 1;
                        let year = date.getFullYear();
                        let hours = date.getHours();
                        let minute = date.getMinutes();
                        let second = date.getSeconds();
                        if (month < 10) {
                            month = '0' + month;
                        }
                        if (day < 10) {
                            day = '0' + day;
                        }
                        if (hours < 10) {
                            hours = '0' + hours;
                        }
                        if (minute < 10) {
                            minute = '0' + minute;
                        }
                        if (second < 10) {
                            second = '0' + second;
                        }
                        let dateTime = day + '/' + month + '/' + year + ' ' + hours + ':' + minute + ':' + second;
                        if (val.is_read == 0) {
                            tpl = tpl.replace(/{class}/g, 'ss-background-noti');
                            tpl = tpl.replace(/{icon}/g, '<i class="flaticon2-correct kt-font-success"></i>');

                        } else {
                            tpl = tpl.replace(/{class}/g, '');
                            tpl = tpl.replace(/{icon}/g, '');
                        }
                        tpl = tpl.replace(/{datetime}/g, dateTime);
                        tpl = tpl.replace(/{notification_log_id}/g, val.notification_log_id);
                        tpl = tpl.replace(/{object_id}/g, val.object_id);
                        $('.div-notification').append(tpl);
                    }
                    if (val.is_read == 0) {
                        countNew++;
                    }
                });
                if (res.length > 10) {
                    let tpl2 = $('#footer-notification-tpl').html();
                    $('.div-notification').append(tpl2);
                }
                $('.quantity-noti').text(countNew);
                if (countNew > 0) {
                    $('.chuong').addClass('ss-success');
                }
            }
        });
    },
    seen: function (id, object_id) {
        $.ajax({
            url: laroute.route('admin.notification.is-read-notification'),
            method: "POST",
            data: {notification_log_id: id},
            global: false,
            success: function (res) {
                let link = laroute.route('ticket.show', {id: object_id});
                window.location.href = link;
            }
        });
    },
    viewAll: function () {
        $.ajax({
            url: laroute.route('admin.notification.view-all'),
            method: "POST",
            data: {arrNoti: arrNoti},
            success: function (res) {
                window.location.href = laroute.route('ticket.index');
            }
        });
    }
};
notification.notificationLog();
notification.init();
setInterval(function() {
    notification.notificationLog();
}, 180000);

