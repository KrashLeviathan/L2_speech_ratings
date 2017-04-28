document.addEventListener("DOMContentLoaded", function () {
    $('#edit-survey-form').submit(onFormSubmit);
});

function onFormSubmit(event) {
    event.preventDefault();
    $.ajax({
        url: '/admin_settings/edit_survey/save_survey_details.php',
        type: 'post',
        dataType: 'json',
        data: $('#edit-survey-form').serialize(),
        success: function (data) {
            if (data.success) {
                backToAdminSettings();
            } else {
                console.log(data);
                displayAlert(data.errmsg, true);
            }
        }
    });
}

function backToAdminSettings() {
    window.location = "/admin_settings";
}
