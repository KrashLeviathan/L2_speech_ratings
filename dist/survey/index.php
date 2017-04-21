<?php
// Include database_api to be used in the specific_instructions include
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';

// TODO: Will fetch other surveys in future iterations
$_SESSION['survey_id'] = 1;
$_SESSION['survey_in_progress'] = false;
$_SESSION['survey_complete'] = false;
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
    @include '../_includes/html/specific_instructions.php';
    ?>

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
