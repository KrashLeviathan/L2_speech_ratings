<?php
// Include database_api to be used in the specific_instructions include
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';
?>

<div class="container">
    <?php
    if ($_SESSION['survey_in_progress']) {
        // Display the specific instructions if there's a survey in progress
        print '<div class="page-header" id="banner"><div class="row"><div class="col-lg-12">'
            . '<h1>Survey-specific Instructions</h1>'
            . '</div></div></div>';
        @include '../_includes/html/specific_instructions.php';
    }
    ?>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>General Instructions</h1>
            </div>
        </div>
    </div>
    <?php @include '../_includes/html/instructions.html'; ?>
</div>

</body>
</html>
