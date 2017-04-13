<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="/" class="navbar-brand">L2 Speech Ratings</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <?php
            if (isset($user)) {
                // Set left navbar items based on user type
                if ($user['user_is_admin'] == true) {
                    @include 'navbarAdminItems.php';
                } else {
                    @include 'navbarUserItems.php';
                }
            }
            ?>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if ($_SERVER['REQUEST_URI'] == '/about') {
                    print '<li class="active"><a href="#">About <span class="sr-only">(current)</span></a></li>';
                } else {
                    print '<li><a href="/about">About</a></li>';
                }
                if (isset($user)) {
                    print '<li><a href="#" onclick="signOut()">Log out</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<script defer>
    var gapiReady = false;
    var attemptedSignOut = false;
    var timer;

    document.addEventListener("DOMContentLoaded", function() {
        timer = setTimeout(function() {
            // Sometimes the google api fails to load for some reason. If so, this will time
            // out and display in the console.
            console.log("Google authentication API failed to load! Try refreshing the page.");
            // TODO: Present a popup or toast of some sort in the future?
        }, 5000);
    });

    function onLoad() {
        gapi.load('auth2', function () {
            gapi.auth2.init().then(function () {
                console.log("Google authentication API ready!");
                clearTimeout(timer);
                gapiReady = true;
                if (attemptedSignOut) {
                    signOut();
                }
            });
        });
    }

    function signOut() {
        if (!gapiReady) {
            // Can't sign out before Google API is ready, but now once it's
            // ready it will call signOut() again
            attemptedSignOut = true;
            return;
        }
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'http://localhost:5000/logout');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                window.location = '/';
            };
            xhr.send('logout=true');
        });
    }
</script>
