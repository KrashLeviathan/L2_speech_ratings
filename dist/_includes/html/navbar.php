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
            if (isset($listener)) {
                // Set left navbar items based on user type
                if ($listener['user_is_admin'] == true) {
                    @include 'navbarAdminItems.php';
                } else {
                    @include 'navbarListenerItems.php';
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
                if (isset($listener)) {
                    // If $userIsAdmin is set, then user must be able to log out
                    print '<li><a href="#" onclick="signOut()">Log out</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<script>
    function onLoad() {
        gapi.load('auth2', function () {
            gapi.auth2.init();
        });
    }

    function signOut() {
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
