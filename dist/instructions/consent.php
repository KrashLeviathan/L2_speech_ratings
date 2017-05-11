<?php
@include '../_includes/database_api.php';
@include '../_includes/checkSession.php';

// Make sure it's POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    print "Not a POST request!";
    die();
}

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$databaseApi->updateUserConsent($_SESSION['user_id'], 1);

$_SESSION['consent'] = 1;

$response = array(
    'success' => true
);
print json_encode($response);
die();
