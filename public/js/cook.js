var socket = io(':6001'),
    New = 'saloon:order',
    Work = 'saloon:work';

socket.on(New, function (data) {
    console.log(data)
    $('#accordion').append(
        $('<div class="panel panel-default" id = "' + data.id + '">').append(
            $('<div class="panel-heading">').append(
                $('<div class="panel-title">').append(
                    $('<div class="title-all" data-toggle="collapse" data-parent="#accordion" href="#body' + data.id + '">').append(
                        $('<div class="status-name">').append(
                            $('<p class="panel-title">').text('Order #' + data.id)
                        ),
                        $('<div class="status-order ' + data.id + '">').append(
                            $('<div class="alert alert-info alert-dismissable">').append(
                                $('<button type="button" class="close" aria-hidden="true">'),
                                $('<strong class="status-name-size">').text('Cooking')
                            )
                        )
                    )
                )
            ),
            $('<div id="body' + data.id + '" class="panel-collapse collapse in">').append(
                $('<div class="panel-body">').append(
                    $('<div class="order-body">').append(
                        $('<strong>Dish: ' + data.dish + '</strong><br>'),
                        $('<strong>Table: ' + data.table + '</strong><br>'),
                        $('<strong>Waiter name: ' + data.waiterName + '</strong><br>'),
                        $('<div class="clock' + data.id + '">')
                    ),
                    $('<div class="order-button">').append(
                        $('<button type="button" class="btn btn-primary">Done!</button>')
                    )
                )
            )
        )
    );
    $(document).ready(function () {
        var clock = $('.clock' + data.id).FlipClock({
            clockFace : 'MinuteCounter',
            autoStart : false,
            callbacks : {
                stop : function () {
                    $('.clock' + data.id).html('Time is over');
                    $("."+ data.id).html('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" aria-hidden="true"></button> <strong>Delayed</strong></div>');
                }
            }
        });
        clock.setTime(data.time);
        clock.setCountdown(true);
        clock.start();
    });
});

socket.on(Work, function (data) {
    alert('Work on ' + data + ' order!');
});

$(document).ready(function () {
    $(document).on('click', '.order-button .btn-primary', function () {

        var orderId = $(this).parent().parent().parent().parent().attr('id');

        $.ajax({
            type: 'POST',
            url: '/done',
            dataType: 'html',
            data: {orderId: orderId},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $("#" + orderId).remove();
            }

        });

    });
});