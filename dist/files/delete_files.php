<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';

$files = json_decode(file_get_contents('php://input'), true);
$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$databaseApi->deleteFiles($files);

$response = array(
    'success' => true
);
print json_encode($response);
die();
