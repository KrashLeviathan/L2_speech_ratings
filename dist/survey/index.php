<?php @include '../_includes/pageSetup.php'; ?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Survey-specific Instructions</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section text-justify">
        <div class="row">
            <div class="col-lg-12">
                <dl class="dl-horizontal">
                    <dt>Estimated Length</dt>
                    <?php
                    // TODO
                    $estimatedLength = 60;
                    print '<dd>This survey will take around <mark>' . $estimatedLength . ' minutes</mark> to complete. '
                        . '<mark>You must complete the entire survey in one sitting,</mark> so please leave yourself ' .
                        'enough time before starting.</dd>';
                    ?>
                    <dt>Time Limit</dt>
                    <?php
                    // TODO
                    $timeLimit = false;
                    $minutes = 60;
                    if ($timeLimit) {
                        print '<dd>This survey has a time limit of <mark>' . $minutes . ' minutes</mark>.</dd>';
                    } else {
                        print '<dd>There is <mark>no time limit</mark> for this survey.</dd>';
                    }
                    ?>
                    <dt>Max # Replays</dt>
                    <?php
                    // TODO
                    $maxNumReplays = -1;
                    if ($maxNumReplays > 0) {
                        print '<dd>You must listen to each audio sample from beginning to end at least once. The ' .
                            'maximum number of times a clip can be replayed is <mark>' . $maxNumReplays .
                            ' times</mark>.</dd>';
                    } else {
                        print '<dd>You must listen to each audio sample from beginning to end at least once. ' .
                            'There is <mark>no maximum number of replays</mark> for each audio clip.</dd>';
                    }
                    ?>
                </dl>
            </div>
        </div>
    </div>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>General Instructions</h1>
            </div>
        </div>
    </div>

    <?php @include '../_includes/html/instructions.html' ?>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <a type="button" class="btn btn-primary center-block l2sr-start-survey-btn" href="/survey/in_progress">
                    START</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
