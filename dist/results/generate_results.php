<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

$allSurveys = $databaseApi->adminGetSurveys();
$filepath = '/file_storage/results/';
$finalResponse = array('filepath' => $filepath, 'filenames' => array());
foreach ($allSurveys as $survey) {
    $surveyId = $survey[0];
    $filename = "L2_Speech_Ratings_Results__Survey-" . $surveyId . "__" . date("Y-m-d__H-i-s") . ".csv";
    $response = $databaseApi->createCsvFromResults($surveyId, $filepath, $filename);
    if ($response['success'] === true) {
        array_push($finalResponse['filenames'], $filename);
    } else {
        print json_encode($response);
        die();
    }
}
$finalResponse['success'] = true;
print json_encode($finalResponse);
die();
