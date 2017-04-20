<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

$files = $databaseApi->getAllFiles();

$response = array(
    'success' => true,
    'files' => $files
);
print json_encode($response);
die();
