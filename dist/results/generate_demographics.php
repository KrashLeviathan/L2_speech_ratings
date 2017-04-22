<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

$filepath = '/results/files/';
$filename = "L2_Speech_Ratings_Demographics__" . date("Y-m-d__H-i-s") . ".csv";
$response = $databaseApi->createCsvFromDemographics($filepath, $filename);

if ($response['success'] === true) {
    $response = array(
        'success' => true,
        'filepath' => $filepath,
        'filename' => $filename
    );
}
print json_encode($response);
die();
