<?php
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// TODO: Will fetch other surveys in future iterations
$_SESSION['survey_id'] = 1;
$_SESSION['survey_in_progress'] = false;
$_SESSION['survey_complete'] = false;
$survey = $databaseApi->getSurvey($_SESSION['survey_id']);
?>

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
                    print '<dd>This survey will take around <mark>' . $survey['estimated_length_minutes']
                        . ' minutes</mark> to complete. <mark>You must complete the entire survey in one sitting,'
                        . '</mark> so please leave yourself enough time before starting.</dd>';
                    ?>
                    <dt>Time Limit</dt>
                    <?php
                    if ($survey['total_time_limit'] > 0) {
                        print '<dd>This survey has a time limit of <mark>' . $survey['total_time_limit']
                            . ' minutes</mark>.</dd>';
                    } else {
                        print '<dd>There is <mark>no time limit</mark> for this survey.</dd>';
                    }
                    ?>
                    <dt>Max # Replays</dt>
                    <?php
                    if ($survey['num_replays_allowed'] > -1) {
                        print '<dd>You must listen to each audio sample from beginning to end at least once. The '
                            . 'maximum number of times a clip can be replayed is <mark>' . $survey['num_replays_allowed']
                            . ' times</mark>.</dd>';
                    } else {
                        print '<dd>You must listen to each audio sample from beginning to end at least once. ' .
                            'There is <mark>no maximum number of replays</mark> for each audio clip.</dd>';
                    }
                    ?>
                    <dt>Additional Information</dt>
                    <?php
                    if ($survey['instructional_info'] !== '') {
                        print '<dd>' . $survey['instructional_info'] . '</dd>';
                    } else {
                        print '<dd>None</dd>';
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
