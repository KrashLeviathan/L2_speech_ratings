<ul class="nav navbar-nav">
    <?php
    if ($_SERVER['REQUEST_URI'] == '/results') {
        print '<li class="active"><a href="#">Results <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/results">Results</a></li>';
    }
    if ($_SERVER['REQUEST_URI'] == '/listeners') {
        print '<li class="active"><a href="#">Listeners <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/listeners">Listeners</a></li>';
    }
    if ($_SERVER['REQUEST_URI'] == '/files') {
        print '<li class="active"><a href="#">Files <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/files">Files</a></li>';
    }
    if ($_SERVER['REQUEST_URI'] == '/settings') {
        print '<li class="active"><a href="#">Settings <span class="sr-only">(current)</span></a></li>';
    } else {
        print '<li><a href="/settings">Settings</a></li>';
    }
    ?>
</ul>
