<?php
// Include database_api to be used in the specific_instructions include
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';
?>

<div class="container">
    <?php
    if (isset ($_SESSION['survey_state']) && $_SESSION['survey_state'] !== 'NO_SURVEY_SELECTED'
        && $_SESSION['survey_state'] !== 'POST_COMPLETE'
    ) {
        // Display the specific instructions if there's a survey in progress
        print '<div class="page-header" id="banner"><div class="row"><div class="col-lg-12">'
            . '<h1>Survey-specific Instructions</h1>'
            . '</div></div></div>';
        @include '../_includes/html/specific_instructions.php';
    }
    ?>

    <div class="page-header">
        <div class="row">
            <div class="col-lg-12">
                <h1>Research Information</h1>
            </div>
        </div>
    </div>
    <?php @include '../_includes/html/research_information.php'; ?>

    <div class="row">
        <div class="col-lg-12">
            <a type="button" class="btn btn-primary center-block l2sr-start-survey-btn">
                I CONSENT TO PARTICIPATE IN THIS RESEARCH</a>
        </div>
    </div>

    <div class="page-header">
        <div class="row">
            <div class="col-lg-12">
                <h1>Survey Instructions</h1>
            </div>
        </div>
    </div>
    <?php @include '../_includes/html/instructions.html'; ?>
</div>

</body>
</html>
