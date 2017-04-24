<?php

@include '../../_includes/generate_access_code.php';
@include '../../_includes/database_api.php';
@include '../../_includes/checkSession.php';
@include '../../_includes/html/head.php';

if ($_SESSION['survey_complete']) {
    @include '../../_includes/html/navbar.php';
    @include 'end_of_survey.php';
    die();
}

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// If this is the first item in the survey, we initialize some values
if (!$_SESSION['survey_in_progress']) {
    $_SESSION['survey_in_progress'] = true;
    $_SESSION['survey_current_id_index'] = 0;
    $_SESSION['survey_start_time'] = time();

    // Get all audio ids for this survey
    $audioSampleIds = $databaseApi->getAudioIdsFromSurveyBlock($_SESSION['survey_id']);

    // Randomize order of audio ids
    // TODO: Check if Dr Nagle actually wants these randomized
    shuffle($audioSampleIds);

    // Clean up and put in session variable
    $_SESSION['survey_audio_id_order'] = array();
    foreach ($audioSampleIds as $audioSampleId) {
        array_push($_SESSION['survey_audio_id_order'], $audioSampleId[0]);
    }
}

// We put the navbar after setting session_in_progress so that it can change appropriately
@include '../../_includes/html/navbar.php';

// Generate a random token to try to help prevent survey progress tampering (not foolproof)
$randomToken = generateAccessCode(16, false);
$_SESSION['in_progress_token'] = $randomToken;

// Get the filename for the current audio sample
$audioId = $_SESSION['survey_audio_id_order'][$_SESSION['survey_current_id_index']];
$audioFilename = $databaseApi->getAudioFilename($audioId);
$audioSample = '/file_storage/audio_samples/' . $audioFilename;
?>

<div class="container">

    <div class="page-header l2sr-mtop-lg">
        <div class="row">
            <div class="col-lg-12">
                <p>To open the instructions in a new window,
                    <a href="/instructions" target="_blank">please click here</a>.
                </p>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <form id="survey-form">
            <div class="row">
                <h2 class="col-lg-12 text-center">Comprehensibility</h2>
            </div>
            <div class="row text-center">
                <div class="col-sm-2 col-md-3 col-lg-4">
                    <span class="visible-xs xs-arrow arrow-top">&larr;</span>Very difficult to understand
                </div>
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="btn-group center-block clearfix buffer-top np-scale" role="group"
                         aria-label="Nine-point scale" data-toggle="buttons">
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="1"
                                                           required>1</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="2">2</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="3">3</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="4">4</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="5">5</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="6">6</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="7">7</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="8">8</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="9">9</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 col-lg-4">
                    Very easy to understand<span class="visible-xs xs-arrow">&rarr;</span>
                </div>
            </div>
            <div class="row">
                <h2 class="col-lg-12 text-center">Fluency</h2>
            </div>
            <div class="row text-center">
                <div class="col-sm-2 col-md-3 col-lg-4">
                    <span class="visible-xs xs-arrow arrow-top">&larr;</span>Extremely disfluent
                </div>
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="btn-group center-block clearfix buffer-top np-scale" role="group"
                         aria-label="Nine-point scale" data-toggle="buttons">
                        <label class="btn btn-info"><input type="radio" name="fluency" value="1" required>1</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="2">2</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="3">3</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="4">4</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="5">5</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="6">6</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="7">7</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="8">8</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="9">9</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 col-lg-4">
                    Extremely fluent<span class="visible-xs xs-arrow">&rarr;</span>
                </div>
            </div>
            <div class="row">
                <h2 class="col-lg-12 text-center">Accentedness</h2>
            </div>
            <div class="row text-center">
                <div class="col-sm-2 col-md-3 col-lg-4">
                    <span class="visible-xs xs-arrow arrow-top">&larr;</span>Very strong foreign accent
                </div>
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="btn-group center-block clearfix buffer-top np-scale" role="group"
                         aria-label="Nine-point scale" data-toggle="buttons">
                        <label class="btn btn-info"><input type="radio" name="accent" value="1" required>1</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="2">2</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="3">3</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="4">4</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="5">5</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="6">6</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="7">7</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="8">8</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="9">9</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 col-lg-4">
                    No foreign accent whatsoever<span class="visible-xs xs-arrow">&rarr;</span>
                </div>
            </div>
            <input type="hidden" value="<?= $randomToken ?>" name="token">
        </form>
    </div>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <audio controls preload autoplay id="audio-player">
                    <source src="<?= $audioSample ?>" type="audio/wav">
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
    </div>

    <div id="submit-btn-container"></div>
</div>
<script src="/js/survey_in_progress.js" type="text/javascript"></script>
</body>
</html>
