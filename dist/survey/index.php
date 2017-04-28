<?php
// Include database_api to be used in the specific_instructions include
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$surveys = $databaseApi->getAllOpenSurveys($_SESSION['user_id']);

$_SESSION['survey_state'] = 'NO_SURVEY_SELECTED';
?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Select a Survey</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section text-justify">
        <form id="select-survey-form">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if (sizeof($surveys) === 0) {
                        print '<p>All surveys have been completed, or none are currently available.'
                            . ' Please check back later or contact an administrator if you believe you are seeing this'
                            . ' message in error.</p>';
                    } else {
                        print '<p class="l2sr-mbot-sm">Please select a survey corresponding to your spoken language.</p>'
                            . '<div class="btn-group-vertical clearfix buffer-top" role="group"'
                            . ' aria-label="Select a survey" data-toggle="buttons">';
                        foreach ($surveys as $survey) {
                            print '<label class="btn btn-default l2sr-select-survey-btn">'
                                . '<input type="radio" name="surveyIdSelection" value="'
                                . $survey['survey_id'] . '" required>'
                                . $survey['survey_id'] . ' - ' . $survey['description'] . '</label>';
                        }
                        print '</div>';
                    }
                    ?>
                </div>
            </div>
            <?php
            if (sizeof($surveys) !== 0) {
                print '<div class="row l2sr-mtop-sm">'
                    . '<div class="col-lg-12">'
                    . '<button type="button" class="btn btn-primary" onclick="selectSurvey()">Continue</button>'
                    . '</div></div>';
            }
            ?>
        </form>
    </div>

</div>
<script src="/js/select_survey.js" type="text/javascript"></script>
</body>
</html>
