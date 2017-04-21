<ul class="nav navbar-nav">
    <?php
    if ($_SERVER['REQUEST_URI'] === '/instructions') {
        print '<li class="active"><a href="#">Instructions <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/instructions">Instructions</a></li>';
    }
    if ($_SESSION['survey_in_progress']) {
        if ($_SERVER['REQUEST_URI'] === '/survey/in_progress') {
            print '<li class="active"><a href="#">Survey In Progress <span class="sr-only">(current)</span></a></li>';
        } else {
            print '<li><a href="/survey/in_progress">Survey In Progress</a></li>';
        }
    } else {
        if ($_SERVER['REQUEST_URI'] === '/survey' || $_SERVER['REQUEST_URI'] === '/survey/in_progress') {
            print '<li class="active"><a href="#">Start Survey <span class="sr-only">(current)</span></a></li>';
        } else {
            print '<li><a href="/survey">Start Survey</a></li>';
        }
        if (substr($_SERVER['REQUEST_URI'], 0, 18) === '/user_settings') {
            print '<li class="active"><a href="/user_settings">Settings <span class="sr-only">(current)</span></a></li>';
        } else {
            print '<li><a href="/user_settings">Settings</a></li>';
        }
    }
    ?>
</ul>
