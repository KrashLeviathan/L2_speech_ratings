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
$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
// Check connection
if ($link->connect_error) {
    $response = array(
        'success' => false,
        'errmsg' => 'Database connection failure!'
    );
    print json_encode($response);
    die();
}
mysqli_set_charset($link, 'utf8');

function checkSqlSuccess($result, $link)
{
    if (!$result) {
        $response = array(
            'success' => false,
            'errmsg' => 'Database connection failure!',
            'mysql_errno' => mysqli_errno($link),
            'mysql_error' => mysqli_error($link)
        );
        print json_encode($response);
        die();
    }
}

// Create new account if needed
$newAccount = false;
if (isset($_POST['validation']) && $_POST['validation'] !== 'NONE') {
    // Check validation matches
    $sql = "SELECT email FROM Invites WHERE validation='" . $_POST['validation'] . "'";
    $result = $link->query($sql);
    checkSqlSuccess($result, $link);

    if (mysqli_num_rows($result) != 0) {
        mysqli_free_result($result);

        // The invite is validated, so create a new user for that code
        $sql = "INSERT INTO Listeners (google_id, first_name, last_name, email, date_signed_up) " .
            "VALUES ('$google_id','$firstName','$lastName','$email',NOW())";
        $result = $link->query($sql);
        checkSqlSuccess($result, $link);
        mysqli_free_result($result);

        // Then remove the invite
        $sql = "DELETE FROM Invites WHERE validation='" . $_POST['validation'] . "'";
        $result = $link->query($sql);
        checkSqlSuccess($result, $link);
        $newAccount = true;
    }
    mysqli_free_result($result);
}

// Verify user's id with the application
$sql = "SELECT * FROM Listeners WHERE Listeners.google_id = $google_id";
$result = $link->query($sql);
checkSqlSuccess($result, $link);
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
checkSqlSuccess($result, $link);
$userIsAdmin = (mysqli_num_rows($result) != 0);
mysqli_free_result($result);

mysqli_close($link);

// SUCCESS! Create a session for this verified user (7 day expiration)
session_start([
    'cookie_lifetime' => 604800
]);
$_SESSION['user_id'] = $listener['listener_id'];
$_SESSION['first_name'] = $listener['first_name'];
$_SESSION['last_name'] = $listener['last_name'];
$_SESSION['email'] = $listener['email'];
$_SESSION['phone'] = $listener['phone'];
$_SESSION['university_id'] = $listener['university_id'];
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
        'redirectTo' => ($newAccount) ? '/listener_settings' : '/instructions'
    );
    print json_encode($response);
    die();
}
