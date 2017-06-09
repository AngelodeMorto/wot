var socket = io(':6001'),
    Delay = 'saloon:orderDelay',
    Done = 'saloon:orderDone',
    History = 'saloon:orderHistory';

socket.on(Delay, function (data) {
    $('#accordion').append(
        $('<div class="panel panel-default" id = "' + data.id + '">').append(
            $('<div class="panel-heading">').append(
                $('<div class="panel-title">').append(
                    $('<div class="title-all" data-toggle="collapse" data-parent="#accordion" href="#body' + data.id + '">').append(
                        $('<div class="status-name">').append(
                            $('<p class="panel-title">').text('Order #' + data.id)
                        ),
                        $('<div class="status-order ' + data.id + '">').append(
                            $('<div class="alert alert-warning alert-dismissable">').append(
                                $('<button type="button" class="close" aria-hidden="true">'),
                                $('<strong>').text('Delayed')
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
                        $('<div class="clock">').text('Time is over')
                    ),
                    $('<div class="order-button">').html('<button type="button" class="btn btn-warning">Work!</button>')
                )
            )
        )
    );
});

socket.on(Done, function (data) {
    $('#' + data.id).remove();
});

socket.on(History, function (data) {
    $('#history tbody').prepend(
        $('<tr id="order' + data.id + '">').append(
            $('<td>').text(data.dish),
            $('<td>').text(data.table),
            $('<td>').text(data.waiterName),
            $('<td>').text(data.created_at),
            $('<td class="remove-order"><span class="glyphicon glyphicon-remove"></span></td>>')
        )
    );
});

$(document).ready(function () {

    $(document).on('click', '.order-button .btn-warning', function () {

        var orderId = $(this).parent().parent().parent().parent().attr('id');


        socket.emit('saloon:work', orderId);

    });

    $(document).on('click', '.remove-worker', function () {

        var workerId = $(this).parent().attr('id'),
            len = workerId.length;
        workerId = workerId.substr(6, len);

        $.ajax({
            type: 'POST',
            url: '/delete-worker',
            dataType: 'html',
            data: {workerId: workerId},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(this).parent().remove();

    });
    
    $(document).on('click', '.remove-order', function () {

        var orderId = $(this).parent().attr('id'),
            len = orderId.length;
        orderId = orderId.substr(5, len);

        $.ajax({
            type: 'POST',
            url: '/delete-order',
            dataType: 'html',
            data: {orderId: orderId},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(this).parent().remove();

    });
    
    $(document).on('submit', '.change', function () {
        var form = $(this);
        var data = form.serialize();

        $.ajax({
            type: 'POST',
            url: '/change-role',
            dataType: 'html',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });
        
        return false;
    });
    
    
});