<ul class="nav navbar-nav">
    <?php
    if ($_SERVER['REQUEST_URI'] === '/results') {
        print '<li class="active"><a href="#">Instructions <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/instructions">Instructions</a></li>';
    }
    if ($_SERVER['REQUEST_URI'] === '/listeners') {
        print '<li class="active"><a href="#">Start Survey <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/start_survey">Start Survey</a></li>';
    }
    if (substr($_SERVER['REQUEST_URI'], 0, 18) === '/listener_settings') {
        print '<li class="active"><a href="#">Settings <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/listener_settings">Settings</a></li>';
    }
    ?>
</ul>
