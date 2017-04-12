<?php

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
                    <form class="form-horizontal">
                        <fieldset>
                            <legend>New Users</legend>
                            <div class="form-group">
                                <label for="inputAccessCode" class="col-lg-2 control-label">Access Code</label>
                                <div class="col-lg-10">
                                    <input type="password" class="form-control" id="inputAccessCode"
                                           placeholder="XXXX-XXXX-XXXX-XXXX">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary">Create Account</button>
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

    function initialSignIn() {
        shouldRedirect = true;
    }

    function onSuccess(redirectTo) {
        window.location = redirectTo;
    }

    function onFail(errmsg) {
        console.log(errmsg);
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
    }

    function onSignIn(googleUser) {
        if (shouldRedirect) {
            var id_token = googleUser.getAuthResponse().id_token;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost:5000/tokensignin');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                var responseJson = JSON.parse(xhr.response);
                if (responseJson.success) {
                    onSuccess(responseJson.redirectTo);
                } else {
                    onFail(responseJson.errmsg);
                }
            };
            xhr.send('idtoken=' + id_token);
        }
    }
</script>
</body></html>
