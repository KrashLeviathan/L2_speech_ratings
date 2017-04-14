<?php
@include '_includes/pageSetup.php';
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
                                    <div class="g-signin2 l2sr-signin-btn" data-onsuccess="onSignIn"
                                         onclick="initialSignIn()"></div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/home_page.js" type="text/javascript"></script>
</body></html>
