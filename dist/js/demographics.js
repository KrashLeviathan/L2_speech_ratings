document.addEventListener("DOMContentLoaded", function () {
    // Attach buttons
    $('#spanish-section-btn').click(function () {
        $('#spanish-form').show();
        $('#spanish-section-btn').hide();
    });
    $('#french-section-btn').click(function () {
        $('#french-form').show();
        $('#french-section-btn').hide();
    });
    $('#cancel-btn').click(function () {
        window.location.href = "/user_settings"
    });
    $('#submit-btn').click(submitForm);
});

function submitForm() {
    console.log($('#spanish-form').serialize());
    return;
    $.ajax({
        url: '/results/generate_results.php',
        type: 'post',
        data: $('#spanish-form').serialize(),
        success: function (data) {
            if (data.success) {
                // TODO
                console.log(data);
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
