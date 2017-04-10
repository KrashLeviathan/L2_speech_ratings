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
            if (isset($userIsAdmin)) {
                // Set left navbar items based on user type
                if ($userIsAdmin == true) {
                    @include 'navbarAdminItems.php';
                } else {
                    @include 'navbarListenerItems.php';
                }

                // If $userIsAdmin is set, then user must be able to log out
                print '<ul class="nav navbar-nav navbar-right"><li><a href="#">Log out</a></li></ul>';
            } else {
                if ($_SERVER['REQUEST_URI'] == '/about') {
                    print '<ul class="nav navbar-nav navbar-right"><li class="active"><a href="#">About <span class="sr-only">(current)</span></a></li>';
                } else {
                    print '<ul class="nav navbar-nav navbar-right"><li><a href="/about">About</a></li>';
                }
            }
            ?>
        </div>
    </div>
</div>
