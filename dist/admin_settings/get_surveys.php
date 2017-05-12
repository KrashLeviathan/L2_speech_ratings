<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

$surveys = $databaseApi->adminGetSurveys();

// Get number of files for each survey
// TODO: Look into a more efficient way of doing this. Fine for small number of surveys for now.
for ($i = 0; $i < sizeof($surveys); $i++) {
    $numberOfFiles = $databaseApi->getSurveyFileCount($surveys[$i][0]);
    array_push($surveys[$i], $numberOfFiles);
}

$response = array(
    'success' => true,
    'surveys' => $surveys
);
print json_encode($response);
die();
