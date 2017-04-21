<?php
if ($_SESSION['survey_in_progress']) {
    $_SESSION['survey_end_time'] = time();
}
$_SESSION['survey_in_progress'] = false;
$totalTimeTaken = $_SESSION['survey_end_time'] - $_SESSION['survey_start_time'];
$minutes = floor($totalTimeTaken / 60);
$seconds = floor($totalTimeTaken % 60);
?>
<div class="container">

    <div class="page-header l2sr-mtop-lg">
        <div class="row">
            <div class="col-lg-12">
                <h1>End of Survey</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">
                <p>You're done! Here's the rundown of what you've accomplished.</p>
                <dl class="dl-horizontal">
                    <dt>Start Time</dt>
                    <dd><?= date("Y-m-d H:i:s", $_SESSION['survey_start_time']) ?></dd>
                    <dt>Finish Time</dt>
                    <dd><?= date("Y-m-d H:i:s", $_SESSION['survey_end_time']) ?></dd>
                    <dt>Total Time Taken</dt>
                    <dd><?= $minutes ?> minutes, <?= $seconds ?> seconds</dd>
                    <dt>Samples Rated</dt>
                    <dd><?= $_SESSION['survey_current_id_index'] + 1 ?></dd>
                </dl>
                <p>It is recommended that you take a break for a while before continuing
                    to rate more audio samples.</p>
                <h2 class="l2sr-mtop-sm text-center">
                    Thank you for your participation!
                </h2>
            </div>
        </div>
    </div>
</div>