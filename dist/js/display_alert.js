/**
 * This script gets included in head.php (right after the head element) and offers an
 * API to display alert toasts.
 * @param msg
 * @param isError
 * @param timeout
 */
function displayAlert(msg, isError, timeout) {
    // Defaults
    isError = (typeof isError !== 'undefined') ? isError : false;
    timeout = (typeof timeout !== 'undefined') ? timeout : 30000;

    // Change color and prefix depending on if it's an error
    var errStrong = (isError) ? '<strong>ERROR:</strong> ' : '';
    var alertType = (isError) ? 'alert-danger' : 'alert-success';

    // Attach the alert to the body
    $('body').append('<div class="alert ' + alertType + ' alert-dismissible bottom-alert" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span></button>' +
        errStrong + msg + '</div>');

    // Close after the timeout elapses
    setTimeout(function () {
        $('.alert').remove();
    }, timeout);
}
