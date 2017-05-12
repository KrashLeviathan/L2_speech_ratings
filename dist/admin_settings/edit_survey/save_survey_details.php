<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../../_includes/checkSession.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

$surveyProperties = array(
    'name' => $databaseApi->escapeAndShorten($_POST['name'], 64),
    'description' => $databaseApi->escapeAndShorten($_POST['description'], 1024),
    'num_replays_allowed' => $databaseApi->escapeAndShorten($_POST['replays_allowed'], 64),
    'total_time_limit' => $databaseApi->escapeAndShorten($_POST['survey_time_limit'], 64),
    'estimated_length_minutes' => $databaseApi->escapeAndShorten($_POST['est_length'], 64),
    'notifications_enabled' => $databaseApi->escapeAndShorten($_POST['notif_enabled'], 64),
    'notification_email' => $databaseApi->escapeAndShorten($_POST['notif_email'], 64),
    'target_rating_threshold' => $databaseApi->escapeAndShorten($_POST['rating_threshold'], 64),
    'closed' => $databaseApi->escapeAndShorten($_POST['closed'], 64),
    'instructional_info' => $databaseApi->escapeAndShorten($_POST['addl_instructions'], 8192),
    'end_date' => ($_POST['closed'] == 1) ? 'NOW()' : 'NULL'
);
// TODO: Possibly revisit 'end_date', since it will update every time the form is submitted if closed
$surveyId = $databaseApi->escapeAndShorten($_POST['survey_id'], 10);
$databaseApi->updateSurvey($surveyId, $surveyProperties, true);

$response = array(
    'success' => true
);
print json_encode($response);
die();
