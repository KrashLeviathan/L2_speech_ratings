<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';
@include '../_includes/validation.php';
@include '../_includes/generate_access_code.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$accessCode = generateAccessCode(16);

$response = array('success' => false, 'errmsg' => '');
if (isset($_POST['email'])) {
    $newEmail = $databaseApi->escapeAndShorten($_POST['email'], 255);
    if (isValidEmail($newEmail) && $newEmail !== $_POST['email']) {
        $response['errmsg'] = 'Invalid email! Invalid characters found, or email was too long.';
    } else {
        $databaseApi->addInvite($accessCode, $newEmail);
        // TODO: Send invite to the intended recipient email via some API
        $response['success'] = true;
    }
} else {
    $response['errmsg'] = 'Invalid email!';
}
print json_encode($response);
die();
