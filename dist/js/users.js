document.addEventListener("DOMContentLoaded", function () {
    // Attach sendInvite actions
    $('#send-invite-btn').click(sendInvite);
    $("*[data-dismiss='modal']").click(dismissInvite);
    $('#invite-form').submit(submitInvite);

    // Get users from the database
    $.ajax({
        url: '/users/get_users.php',
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                onSuccess(data);
            } else {
                onFailure(data);
            }
        }
    });
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
    $.ajax({
        url: '/users/create_invite.php',
        type: 'post',
        dataType: 'json',
        data: 'email=' + encodeURIComponent(values['email']),
        success: function (data) {
            if (data.success) {
                // Invite creation was successful
                $('#send-invite-modal').removeClass('in');
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                // Invite creation was unsuccessful
                $('#send-invite-modal').removeClass('in');
                console.log(data);
                displayAlert(data.errmsg, true);
            }
        }
    });
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
        userTableBody.append('<tr><td>' + id + '</td><td>' + first + '</td><td>' + last
            + '</td><td>' + email + '</td><td>'
            + ((phone === null) ? '' : phone) + '</td><td>'
            + date + '</td></tr>')
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
    displayAlert(response.errmsg, true);
}
