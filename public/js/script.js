$(document).ready(function () {

    $(document).on('click', '#myTabExample li a', function () {

        var href = $(this).attr('href'),
            len = href.length;
        href = href.substr(1, len);

        $.ajax({
            type: 'POST',
            url: href,
            dataType: 'html',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $(".main-content").html(data);
            }

        });

    });
    
});