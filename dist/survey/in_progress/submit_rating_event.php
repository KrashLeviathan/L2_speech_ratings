<?php

@include '../../_includes/database_api.php';
@include '../../_includes/checkSession.php';
@include '../../_includes/generate_access_code.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// Make sure it's POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    print "Not a POST request!";
    die();
}

// Make sure there's no tampering with survey progression
if ($_POST['token'] !== $_SESSION['in_progress_token']) {
    $response = array(
        'success' => false,
        'errmsg' => 'Invalid token!',
        'details' => ''
    );
    print json_encode($response);
    die();
}

// Check to see if survey is already complete
if ($_SESSION['survey_complete']) {
    $response = array(
        'success' => false,
        'errmsg' => 'Survey is already complete',
        'details' => ''
    );
    print json_encode($response);
    die();
}

// Validate input
$comprehension = $databaseApi->escapeAndShorten($_POST['comprehension'], 1);
$fluency = $databaseApi->escapeAndShorten($_POST['fluency'], 1);
$accent = $databaseApi->escapeAndShorten($_POST['accent'], 1);

// Update database
$audioId = $_SESSION['survey_audio_id_order'][$_SESSION['survey_current_id_index']];
$databaseApi->createRatingEvent($comprehension, $fluency, $accent, $_SESSION['user_id'], $audioId, $_SESSION['survey_id']);

// Progress through survey
$_SESSION['survey_current_id_index']++;
if ($_SESSION['survey_current_id_index'] >= sizeof($_SESSION['survey_audio_id_order'])) {
    // It has reached the end of the survey, so we take the user to another page.
    $_SESSION['survey_complete'] = true;
}

// Successful response
$response = array(
    'success' => true,
    'endOfSurvey' => $_SESSION['survey_complete']
);
print json_encode($response);
die();
