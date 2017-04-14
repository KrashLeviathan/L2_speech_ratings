<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response = array(
        'success' => false,
        'errmsg' => 'Only POST methods are allowed to this URI!'
    );
    print json_encode($response);
    die();
}

// Slow down bots with brute force attempts to guess access codes
sleep(2);

// Gets the MySQL config and database API
@include '../_includes/database_api.php';
$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// Get $accessCode via HTTPS POST.
if (isset($_POST['accessCode'])) {
    $accessCode = $_POST['accessCode'];
} else {
    $response = array(
        'success' => false,
        'errmsg' => 'Invalid POST parameters!'
    );
    print json_encode($response);
    die();
}

// Verify access code
$email = $databaseApi->accessCodeToInviteEmail($accessCode);

// Put validation token in Invites table
$validation = $databaseApi->escapeAndShorten(md5(date("Y-m-d H:i:s") . $email), 255);
$databaseApi->accessCodeValidation($accessCode, $validation);

// Return success with validation code
$response = array(
    'success' => true,
    'validation' => $validation
);
print json_encode($response);
die();
