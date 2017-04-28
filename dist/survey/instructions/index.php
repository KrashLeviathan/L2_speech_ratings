<?php
// Include database_api to be used in the specific_instructions include
@include '../../_includes/database_api.php';
@include '../../_includes/pageSetup.php';

// Ensure the proper order of events
if ($_SESSION['survey_state'] !== 'SURVEY_SELECTED' && $_SESSION['survey_state'] !== 'INSTRUCTIONS_VISITED') {
    print '<script type="text/javascript">window.location = "' . $domain . '/instructions";</script>';
    die();
}

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$survey = $databaseApi->getSurvey($_SESSION['survey_id']);
$_SESSION['survey_num_replays_allowed'] = $survey['num_replays_allowed'];
$_SESSION['survey_total_time_limit'] = $survey['total_time_limit'];
$_SESSION['survey_state'] = 'INSTRUCTIONS_VISITED';

?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Survey-specific Instructions</h1>
            </div>
        </div>
    </div>

    <?php
    @include '../../_includes/html/specific_instructions.php';
    ?>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>General Instructions</h1>
            </div>
        </div>
    </div>

    <?php @include '../../_includes/html/instructions.html' ?>

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
