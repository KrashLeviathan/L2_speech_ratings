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
sleep(3);

// Gets the MySQL config
@include '../_includes/config.php';

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

function dbConnectionFailure()
{
    $response = array(
        'success' => false,
        'errmsg' => 'Database connection failure!'
    );
    print json_encode($response);
    die();
}

// Verify access code
// Connect to the mysql database
$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
// Check connection
if ($link->connect_error) {
    dbConnectionFailure();
}
mysqli_set_charset($link, 'utf8');

$sql = "SELECT email FROM Invites WHERE access_code = '$accessCode' AND validation != 'COMPLETE'";
$result = $link->query($sql);
if (!$result) {
    dbConnectionFailure();
}
if (mysqli_num_rows($result) == 0) {
    $response = array(
        'success' => false,
        'errmsg' => 'No such access code!'
    );
    print json_encode($response);
    die();
}
$assoc = $result->fetch_assoc();
mysqli_free_result($result);

// Put validation code in Invites table
$validation = substr(md5(date("Y-m-d H:i:s") . $assoc['email']), 0, 255);
$sql = "UPDATE Invites SET validation='$validation' WHERE access_code='$accessCode'";
$result = $link->query($sql);
if (!$result) {
    dbConnectionFailure();
}
mysqli_close($link);

// Return success with validation code
$response = array(
    'success' => true,
    'validation' => $validation
);
print json_encode($response);
die();
