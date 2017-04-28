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
                displayAlert(data.errmsg, true);
            }
        }
    });
}

