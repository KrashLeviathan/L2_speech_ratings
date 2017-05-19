var shouldRedirect = false;
var validation = 'NONE';

function onValidAccessCode(v) {
    validation = v;
    var btn = $('#access-code-button');
    btn.parent().append('<p>Access code verified! Please sign in as an <b>\'Existing User\'</b> with ' +
        'a Google account.</p>');
    btn.remove();
}

function onInvalidAccessCode(response) {
    console.log(response);
    displayAlert('That is not a valid access code!', true);
}

function submitAccessCode(event) {
    event.preventDefault();

    // Show spinner
    var spinner = $('#spinner');
    spinner.show();

    // Check if access code is valid
    $.ajax({
        url: '/tokensignin/check_access_code.php',
        type: 'post',
        dataType: 'json',
        data: $('#access-code-form').serialize(),
        success: function (data) {
            spinner.hide();
            if (data.success) {
                // Access code is valid
                onValidAccessCode(data.validation);
            } else {
                // Access code is NOT valid. Display an alert message.
                onInvalidAccessCode(data);
            }
        }
    });
}

function initialSignIn() {
    shouldRedirect = true;
}

function onSuccess(redirectTo) {
    window.location = redirectTo;
}

function onFail(response) {
    console.log(response);

    // If Google sign-in is successful but user isn't authorized in our application,
    // he should be logged back out
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        $.ajax({
            url: '/logout/index.php',
            type: 'post'
        });
    });

    // Display an error message alert
    if (response.mysql_errno === 1062) {
        var msg = "That user account has already been created!";
    } else {
        msg = response.errmsg;
    }
    displayAlert(msg, true);
}

function onSignIn(googleUser) {
    if (shouldRedirect) {
        var id_token = googleUser.getAuthResponse().id_token;

        $.ajax({
            url: '/tokensignin/index.php',
            type: 'post',
            dataType: 'json',
            data: 'idtoken=' + id_token + '&validation=' + validation,
            success: function (data) {
                if (data.success) {
                    onSuccess(data.redirectTo);
                } else {
                    onFail(data);
                }
            }
        });
    }
}
