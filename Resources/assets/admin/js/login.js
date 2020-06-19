$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('form[name="login"').submit(function (event) {
        event.preventDefault();

        const form = $(this);
        const action = form.attr('action');
        const username = form.find('input[name="username"]').val();
        const password = form.find('input[name="password"]').val();

        $.post(action, { username, password }, function (response) {

            console.log(response);

            if (response.message) {
                ajaxMessage(response.message, ajaxResponseBaseTime);
            }

            if (response.redirect) {
                window.location.href = response.redirect;
            }
        });
    });

    // AJAX RESPONSE
    var ajaxResponseBaseTime = 3;

    function ajaxMessage(message, time) {
        var ajaxMessage = $(message);

        ajaxMessage.append("<div class='message_time'></div>");
        ajaxMessage.find(".message_time").animate({ "width": "100%" }, time * 1000, function () {
            $(this).parents(".message").fadeOut(200);
        });

        $(".ajax_response").append(ajaxMessage);
    }

    // AJAX RESPONSE MONITOR
    $(".ajax_response .message").each(function (e, m) {
        ajaxMessage(m, ajaxResponseBaseTime += 1);
    });

    // AJAX MESSAGE CLOSE ON CLICK
    $(".ajax_response").on("click", ".message", function (e) {
        $(this).effect("bounce").fadeOut(1);
    });

})
