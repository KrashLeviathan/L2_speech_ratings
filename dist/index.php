<?php

$style = '<style>
.bottom-alert {
    position: fixed;
    text-align: center;
    left: 0;
    bottom: 0;
    right: 0;
    margin: 1em;
}
#spinner {
    float: right;
    margin-right: 1em;
    height: 2.5em;
    display: none;
}
</style>';

$injectedHeadElements = array($style);

@include '_includes/pageSetup.php';
@include '_includes/html/login.html';
?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>L2 Speech Ratings</h1>
                <p class="lead">Audio rating surveys supporting second language research at Iowa State University</p>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-sm-6">
                <div class="well bs-component">
                    <form class="form-horizontal" id="access-code-form">
                        <fieldset>
                            <legend>New Users</legend>
                            <div class="form-group">
                                <label for="inputAccessCode" class="col-lg-2 control-label">Access Code</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" id="inputAccessCode" name="accessCode"
                                           placeholder="XXXX-XXXX-XXXX-XXXX">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button id="access-code-button" type="submit" class="btn btn-primary"
                                            onclick="submitAccessCode(event)">Verify
                                    </button>
                                    <img id="spinner" src="/images/spinner.gif">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="well bs-component">
                    <form class="form-horizontal">
                        <fieldset>
                            <legend>Existing Users</legend>
                            <div class="form-group">
                                <div class="col-lg-10">
                                    <div class="g-signin2" data-onsuccess="onSignIn" onclick="initialSignIn()"
                                         style="width:120px;margin:0 auto;"></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var shouldRedirect = false;
    var validation = 'NONE';

    function errorAlert(msg) {
        $('body').append('<div class="alert alert-danger alert-dismissible bottom-alert" role="alert">' +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span></button>' +
            '<strong>ERROR:</strong> ' + msg + '</div>');
        setTimeout(function () {
            $('.alert').remove();
        }, 30000);
    }

    function onValidAccessCode(v) {
        validation = v;
        var btn = $('#access-code-button');
        btn.parent().append('<p>Access code verified! Please sign in as an <b>\'Existing User\'</b> with ' +
            'a Google account.</p>');
        btn.remove();
    }

    function onInvalidAccessCode(response) {
        console.log(response);
        errorAlert('That is not a valid access code!');
    }

    function submitAccessCode(event) {
        event.preventDefault();

        // Show spinner
        var spinner = $('#spinner');
        spinner.show();

        // Check if access code is valid
        var data = $('#access-code-form').serialize();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?=$domain?>/tokensignin/check_access_code.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            spinner.hide();
            var responseJson = JSON.parse(xhr.response);
            if (responseJson.success) {
                // Access code is valid
                onValidAccessCode(responseJson.validation);
            } else {
                // Access code is NOT valid. Display an alert message.
                onInvalidAccessCode(responseJson);
            }
        };
        xhr.send(data);
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
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?=$domain?>/logout');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                // This just makes sure the session is destroyed (if there was one)
            };
            xhr.send();
        });

        // Display an error message alert
        if (response.mysql_errno === 1062) {
            var msg = "That user account has already been created!";
        } else {
            msg = response.errmsg;
        }
        errorAlert(msg);
    }

    function onSignIn(googleUser) {
        if (shouldRedirect) {
            var id_token = googleUser.getAuthResponse().id_token;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?=$domain?>/tokensignin');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                var responseJson = JSON.parse(xhr.response);
                if (responseJson.success) {
                    onSuccess(responseJson.redirectTo);
                } else {
                    onFail(responseJson);
                }
            };
            xhr.send('idtoken=' + id_token + '&validation=' + validation);
        }
    }
</script>
</body></html>
