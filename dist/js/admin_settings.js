var editButton;
var cancelButton;
var submitButton;

var editModeActive = false;

document.addEventListener("DOMContentLoaded", function () {
    editButton = $('#edit-btn');
    cancelButton = $('#cancel-btn');
    submitButton = $('#submit-btn');
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
