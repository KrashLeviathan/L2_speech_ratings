document.addEventListener("DOMContentLoaded", function () {
    // Attach buttons
    $('#spanish-section-btn').click(function () {
        $('#spanish-fieldset').show();
        $('#spanish-section-btn').hide();
    });
    $('#french-section-btn').click(function () {
        $('#french-fieldset').show();
        $('#french-section-btn').hide();
    });
    $('#cancel-btn').click(function () {
        window.location.href = "/user_settings";
    });
    $('#submit-btn').click(submitForm);
});

function submitForm() {
    $.ajax({
        url: '/user_settings/demographics/post_demographics.php',
        type: 'post',
        dataType: 'json',
        data: $('#demographics-form').serialize(),
        success: function (data) {
            if (data.success) {
                window.location.href = "/user_settings";
            } else {
                console.log(data);
                errorAlert(data.errmsg);
            }
        }
    });
}

function errorAlert(msg) {
    $('body').append('<div class="alert alert-danger alert-dismissible bottom-alert" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span></button>' +
        '<strong>ERROR:</strong> ' + msg + '</div>');
    setTimeout(function () {
        $('.alert').remove();
    }, 30000);
}
