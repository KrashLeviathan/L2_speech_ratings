document.addEventListener("DOMContentLoaded", function () {
    // Check if access code is valid
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/users/get_users.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        var responseJson = JSON.parse(xhr.response);
        if (responseJson.success) {
            // Access code is valid
            onSuccess(responseJson);
        } else {
            // Access code is NOT valid. Display an alert message.
            onFailure(responseJson);
        }
    };
    xhr.send('');
});

function errorAlert(msg) {
    $('body').append('<div class="alert alert-danger alert-dismissible bottom-alert" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span></button>' +
        '<strong>ERROR:</strong> ' + msg + '</div>');
    setTimeout(function () {
        $('.alert').remove();
    }, 30000);
}

function onSuccess(json) {
    var tableBody = $('#table-body');
    tableBody.children().remove();

    for (var userIndex in json.users) {
        var id = json.users[userIndex][0];
        var first = json.users[userIndex][1];
        var last = json.users[userIndex][2];
        var email = json.users[userIndex][3];
        var phone = json.users[userIndex][4];
        var date = json.users[userIndex][5];
        var univId = json.users[userIndex][6];
        tableBody.append('<tr><td>' + id + '</td><td>' + first + '</td><td>' + last + '</td><td>' + email + '</td><td>' + phone + '</td><td>' + date + '</td><td>' + univId + '</td></tr>')
    }
}

function onFailure(response) {
    var tableBody = $('#table-body');
    tableBody.children().remove();

    console.log(response);
    errorAlert(response.errmsg);
}
