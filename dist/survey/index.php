<?php
// Include database_api to be used in the specific_instructions include
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// TODO

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
        <div class="row">
            <div class="col-lg-12">
                <form id="select-survey-form">
                    <button type="button" class="btn btn-primary" onclick="selectSurvey()">Continue</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/js/select_survey.js" type="text/javascript"></script>
</body>
</html>
