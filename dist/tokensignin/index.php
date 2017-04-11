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

// Gets the googleClientId for L2 Speech Ratings application, as well as MySQL config
@include '../_includes/config.php';

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
} else {
    // Invalid ID token
    $response = array(
        'success' => false,
        'errmsg' => 'Google login is invalid or expired!'
    );
    print json_encode($response);
    die();
}

// Verify user's id with the application
// Connect to the mysql database
$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
mysqli_set_charset($link, 'utf8');

function checkSqlSuccess($result)
{
    if (!$result) {
        $response = array(
            'success' => false,
            'errmsg' => 'Database connection failure!'
        );
        print json_encode($response);
        die();
    }
}

// Check if it's a valid user
$sql = "SELECT * FROM Listeners WHERE Listeners.google_id = $google_id";
$result = $link->query($sql);
checkSqlSuccess($result);
if (mysqli_num_rows($result) == 0) {
    $response = array(
        'success' => false,
        'errmsg' => 'No such user! Create a new account first.'
    );
    print json_encode($response);
    die();
}
$listener = $result->fetch_assoc();
mysqli_free_result($result);

// Check if that user is an admin
$lid = $listener['listener_id'];
$sql = "SELECT * FROM Admins WHERE Admins.listener_id = $lid";
$result = $link->query($sql);
checkSqlSuccess($result);
$userIsAdmin = (mysqli_num_rows($result) != 0);
mysqli_free_result($result);

mysqli_close($link);

// SUCCESS! Create a session for this verified user
session_start();
$_SESSION['user_id'] = $listener['listener_id'];
$_SESSION['first_name'] = $listener['first_name'];
$_SESSION['last_name'] = $listener['last_name'];
$_SESSION['email'] = $listener['email'];
$_SESSION['phone'] = $listener['phone'];
$_SESSION['university_id'] = $listener['university_id'];
$_SESSION['user_is_admin'] = $userIsAdmin;

$domain = 'http://localhost:5000';

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
        'redirectTo' => '/instructions'
    );
    print json_encode($response);
    die();
}
