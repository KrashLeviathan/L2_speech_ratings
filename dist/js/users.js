document.addEventListener("DOMContentLoaded", function () {
    // Attach sendInvite actions
    $('#send-invite-btn').click(sendInvite);
    $("*[data-dismiss='modal']").click(dismissInvite);
    $('#invite-form').submit(submitInvite);

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

function sendInvite() {
    setTimeout(function () {
        $('#send-invite-modal').addClass('in');
    }, 250);
}

function dismissInvite() {
    $('#send-invite-modal').removeClass('in');
}

function submitInvite(event) {
    event.preventDefault();

    // Get input values
    var values = {};
    $('#invite-form :input').each(function () {
        values[this.name] = $(this).val();
    });

    // Send invite to server
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/users/create_invite.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        var responseJson = JSON.parse(xhr.response);
        if (responseJson.success) {
            // Invite creation was successful
            $('#send-invite-modal').removeClass('in');
            setTimeout(function () {
                location.reload();
            }, 1000);
        } else {
            // Invite creation was unsuccessful
            $('#send-invite-modal').removeClass('in');
            console.log(responseJson);
            errorAlert(responseJson.errmsg);
        }
    };
    xhr.send('email=' + encodeURIComponent(values['email']));
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

function onSuccess(json) {
    var userTableBody = $('#user-table-body');
    userTableBody.children().remove();

    for (var userIndex in json.users) {
        var id = json.users[userIndex][0];
        var first = json.users[userIndex][1];
        var last = json.users[userIndex][2];
        var email = json.users[userIndex][3];
        var phone = json.users[userIndex][4];
        var date = json.users[userIndex][5];
        var univId = json.users[userIndex][6];
        userTableBody.append('<tr><td>' + id + '</td><td>' + first + '</td><td>' + last
            + '</td><td>' + email + '</td><td>'
            + ((phone === null) ? '' : phone) + '</td><td>'
            + date + '</td><td>'
            + ((univId === null) ? '' : univId) + '</td></tr>')
    }

    var inviteTableBody = $('#invite-table-body');
    inviteTableBody.children().remove();

    for (var inviteIndex in json.invites) {
        var code = json.invites[inviteIndex][1];
        var email = json.invites[inviteIndex][2];
        var status = json.invites[inviteIndex][3];
        var acceptedBy = json.invites[inviteIndex][4];
        var dateAccepted = json.invites[inviteIndex][5];
        inviteTableBody.append('<tr><td>' + code + '</td><td>' + email + '</td><td>' + status
            + '</td><td>' + ((acceptedBy === null) ? '' : acceptedBy)
            + '</td><td>' + ((dateAccepted === null) ? '' : dateAccepted) + '</td></tr>')
    }
}

function onFailure(response) {
    $('#user-table-body').children.remove();
    $('#invite-table-body').children().remove();

    console.log(response);
    errorAlert(response.errmsg);
}
