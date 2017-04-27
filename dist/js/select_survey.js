function selectSurvey() {
    $.ajax({
        url: '/survey/select_survey.php',
        type: 'post',
        dataType: 'json',
        data: $('#select-survey-form').serialize(),
        success: function (data) {
            if (data.success) {
                window.location = "/survey/instructions";
            } else {
                console.log(data);
                displayAlert(data.errmsg, true, 30000);
            }
        }
    });
}

function displayAlert(msg, isError, timeout) {
    var errStrong = (isError) ? '<strong>ERROR:</strong> ' : '';
    var alertType = (isError) ? 'alert-danger' : 'alert-success';
    $('body').append('<div class="alert ' + alertType + ' alert-dismissible bottom-alert" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span></button>' +
        errStrong + msg + '</div>');
    setTimeout(function () {
        $('.alert').remove();
    }, timeout);
}
