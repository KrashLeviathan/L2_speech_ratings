<ul class="nav navbar-nav">
    <?php
    if (preg_match('/^\/instructions\/?/', $_SERVER['REQUEST_URI'])) {
        print '<li class="active"><a href="#">Instructions <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/instructions">Instructions</a></li>';
    }
    if (isset ($_SESSION['survey_state']) && $_SESSION['survey_state'] !== 'NO_SURVEY_SELECTED'
        && $_SESSION['survey_state'] !== 'POST_COMPLETE'
    ) {
        if (preg_match('/^\/survey\/((in_progress)|(instructions))\/?/', $_SERVER['REQUEST_URI'])) {
            print '<li class="active"><a href="#">Survey In Progress <span class="sr-only">(current)</span></a></li>';
        } else {
            print '<li><a href="/survey/in_progress">Survey In Progress</a></li>';
        }
    } else {
        if (preg_match('/^\/survey\/?/', $_SERVER['REQUEST_URI'])) {
            print '<li class="active"><a href="#">Start Survey <span class="sr-only">(current)</span></a></li>';
        } else {
            print '<li><a href="/survey">Start Survey</a></li>';
        }
        if (preg_match('/^\/user_settings\/?/', $_SERVER['REQUEST_URI'])) {
            print '<li class="active"><a href="/user_settings">Settings <span class="sr-only">(current)</span></a></li>';
        } else {
            print '<li><a href="/user_settings">Settings</a></li>';
        }
    }
    ?>
</ul>
