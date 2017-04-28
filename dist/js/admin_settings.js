var editButton;
var cancelButton;
var submitButton;

var editModeActive = false;

document.addEventListener("DOMContentLoaded", function () {
    editButton = $('#edit-btn');
    cancelButton = $('#cancel-btn');
    submitButton = $('#submit-btn');

    $.ajax({
        url: '/admin_settings/get_surveys.php',
        type: 'post',
        dataType: 'json',
        data: '',
        success: function (data) {
            if (data.success) {
                onSuccess(data);
            } else {
                $('#survey-table-body').children().remove();
                console.log(data);
                displayAlert(data.errmsg, true);
            }
        }
    });
});

function onEditClicked() {
    editButton.addClass('hidden');
    cancelButton.removeClass('hidden');
    submitButton.removeClass('hidden');
    editModeActive = true;
    $('#form-user-fieldset').removeAttr('disabled');
    $('#form-admin-fieldset').removeAttr('disabled');
}

function onCancelClicked() {
    editButton.removeClass('hidden');
    cancelButton.addClass('hidden');
    submitButton.addClass('hidden');
    editModeActive = false;
    $('#form-user-fieldset').prop('disabled', true);
    $('#form-admin-fieldset').prop('disabled', true);
}

function editSurvey(surveyId) {
    window.location = "/admin_settings/edit_survey?surveyId=" + surveyId;
}

function onSuccess(json) {
    var surveyTableBody = $('#survey-table-body');
    surveyTableBody.children().remove();

    for (var surveyIndex in json.surveys) {
        // Make the table row clickable -- takes you to the page to edit that survey
        var surveyId = json.surveys[surveyIndex][0];
        var tableRowString = '<tr class="l2sr-clickable" onclick="editSurvey(' + surveyId + ')">';

        // Id, Name, Description
        for (var i = 0; i < 3; i++) {
            tableRowString += '<td>' + json.surveys[surveyIndex][i] + '</td>';
        }

        // Start, End
        for (i = 3; i < 5; i++) {
            var dateString = (json.surveys[surveyIndex][i]) ? json.surveys[surveyIndex][i].split(' ')[0] : '';
            tableRowString += '<td>' + dateString + '</td>';
        }

        // # Replays, Time Limit, Est. Length
        for (i = 5; i < 8; i++) {
            tableRowString += '<td>' + json.surveys[surveyIndex][i] + '</td>';
        }

        // Notif. Email, Notif. Threshold
        for (i = 8; i < 10; i++) {
            // If not enabled, cross it out
            var crossedOut = (json.surveys[surveyIndex][11] == 1) ? '' : 'style="text-decoration: line-through;"';
            tableRowString += '<td ' + crossedOut + '>' + json.surveys[surveyIndex][i] + '</td>';
        }

        // Status
        var status = (json.surveys[surveyIndex][10] == 1) ? 'CLOSED' : 'OPEN';
        tableRowString += '<td>' + status + '</td>';

        // Append to survey table body
        surveyTableBody.append(tableRowString + '</tr>');
    }
}
