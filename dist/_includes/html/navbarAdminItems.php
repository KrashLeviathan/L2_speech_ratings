<ul class="nav navbar-nav">
    <?php
    if (preg_match('/^\/results\/?/', $_SERVER['REQUEST_URI'])) {
        print '<li class="active"><a href="#">Results <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/results/">Results</a></li>';
    }
    if (preg_match('/^\/users\/?/', $_SERVER['REQUEST_URI'])) {
        print '<li class="active"><a href="#">Users <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/users/">Users</a></li>';
    }
    if (preg_match('/^\/files\/?/', $_SERVER['REQUEST_URI'])) {
        print '<li class="active"><a href="#">Files <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/files/">Files</a></li>';
    }
    if (preg_match('/^\/admin_settings\/?/', $_SERVER['REQUEST_URI'])) {
        print '<li class="active"><a href="#">Settings <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/admin_settings/">Settings</a></li>';
    }
    ?>
</ul>
