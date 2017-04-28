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
                displayAlert(data.errmsg, true);
            }
        }
    });
}
