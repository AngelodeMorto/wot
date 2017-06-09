var socket = io(':6001'),
    Delay = 'saloon:orderDelay',
    Done = 'saloon:orderDone',
    New = 'saloon:order';

socket.on(Delay, function (data) {
    console.log(data)
    $('#' + data.id + ' .panel-heading .panel-title .title-all .status-order').html('<div class="alert alert-warning alert-dismissable">'+
        '<button type="button" class="close" aria-hidden="true"></button><strong>Delayed</strong></div>');
    $('.clock' + data.id).text('Time is over');
});

socket.on(Done, function (data) {
    console.log(data)
    $('#' + data.id + ' .panel-heading .panel-title .title-all .status-order').html('<div class="alert alert-success alert-dismissable">' +
        '<button type="button" class="close" aria-hidden="true"></button> <strong class="status-name-size">Done</strong></div>');
    $('#body' + data.id + ' .order-button').html('<button type="submit" class="btn btn-success btn-on-main">To history</button>');
    $('.clock' + data.id).text('Time is over');
});

socket.on(New, function (data) {
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
                    $('<div class="order-button">')
                )
            )
        )
    );

    $(document).ready(function () {
        var clock = $('.clock' + data.id).FlipClock({
            clockFace : 'MinuteCounter',
            autoStart : false,
        });
        clock.setTime(data.time);
        clock.setCountdown(true);
        clock.start();
    });
});

$(document).ready(function () {

    $(document).on('submit', '#makeOrder', function () {
        var form = $(this);
        var data = form.serialize();

        $.ajax({
            type: 'POST',
            url: '/new-order',
            dataType: 'html',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

        });
        return false;
    });

    $(document).on('click', '.order-button .btn-success', function () {

        var orderId = $(this).parent().parent().parent().parent().attr('id');

        $.ajax({
            type: 'POST',
            url: '/history',
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
