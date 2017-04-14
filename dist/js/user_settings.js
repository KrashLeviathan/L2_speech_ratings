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
    $('#form-fieldset').removeAttr('disabled');
}

function onCancelClicked() {
    editButton.removeClass('hidden');
    cancelButton.addClass('hidden');
    submitButton.addClass('hidden');
    editModeActive = false;
    $('#form-fieldset').prop('disabled', true);
}

function onSubmitClicked() {
}
