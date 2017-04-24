<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// TODO: In the future, we'll want to specify which survey results to fetch
$surveyId = 1;
$filepath = '/file_storage/results/';
$filename = "L2_Speech_Ratings_Results__Survey-" . $surveyId . "__" . date("Y-m-d__H-i-s") . ".csv";
$response = $databaseApi->createCsvFromResults(1, $filepath, $filename);

if ($response['success'] === true) {
    $response = array(
        'success' => true,
        'filepath' => $filepath,
        'filename' => $filename
    );
}
print json_encode($response);
die();
