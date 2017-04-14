<?php

// Only POST is allowed to this endpoint
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response = array(
        'success' => false,
        'errmsg' => 'Only POST methods are allowed to this URI!'
    );
    print json_encode($response);
    die();
}

// Gets the googleClientId for L2 Speech Ratings application and MySQL connection API
@include '../_includes/database_api.php';

// Contains the Google_Client API
require_once '../../vendor/autoload.php';

// Get $id_token via HTTPS POST.
if (isset($_POST['idtoken'])) {
    $id_token = $_POST['idtoken'];
} else {
    $response = array(
        'success' => false,
        'errmsg' => 'Invalid POST parameters!'
    );
    print json_encode($response);
    die();
}

// Verify user's token id with google
$client = new Google_Client(['client_id' => $googleClientId]);
$payload = $client->verifyIdToken($id_token);
if ($payload) {
    $google_id = $payload['sub'];
    $firstName = $payload['given_name'];
    $lastName = $payload['family_name'];
    $email = $payload['email'];
} else {
    // Invalid ID token
    $response = array(
        'success' => false,
        'errmsg' => 'Google login is invalid or expired!'
    );
    print json_encode($response);
    die();
}

// Connect to the mysql database
$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// Create new account if needed
$newAccount = false;
if (isset($_POST['validation']) && $_POST['validation'] !== 'NONE') {
    // Slow down bots with brute force attempts to guess validation codes
    sleep(2);

    // Check validation matches
    $isValid = $databaseApi->checkInviteValidation($_POST['validation']);

    if ($isValid) {
        // The invite is validated, so create a new user for that code
        $databaseApi->createNewUser($google_id, $firstName, $lastName, $email);

        // Get user id for the new user
        $user = $databaseApi->getUserFromGoogleId($google_id);

        // Then update the invite
        $databaseApi->completeInvite($user['user_id'], $_POST['validation']);
        $newAccount = true;
    }
}

// Verify user's google id with the application
if (!isset($user)) {
    $user = $databaseApi->getUserFromGoogleId($google_id);
}

// Check if that user is an admin
$userIsAdmin = $databaseApi->isUserAdmin($user['user_id']);

// SUCCESS! Create a session for this verified user
$secondsPerDay = 86400;
session_start([
    'cookie_lifetime' => $secondsPerDay * 7
]);
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name'] = $user['last_name'];
$_SESSION['email'] = $user['email'];
$_SESSION['phone'] = $user['phone'];
$_SESSION['university_id'] = $user['university_id'];
$_SESSION['user_is_admin'] = $userIsAdmin;

if ($userIsAdmin) {
    // User is admin.
    $response = array(
        'success' => true,
        'redirectTo' => '/results'
    );
    print json_encode($response);
    die();
} else {
    // User is NOT admin.
    $response = array(
        'success' => true,
        'redirectTo' => ($newAccount) ? '/user_settings' : '/instructions'
    );
    print json_encode($response);
    die();
}
