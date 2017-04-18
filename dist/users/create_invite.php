<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;

@include '../_includes/database_api.php';
// Make sure the user is authorized to be here
@include '../_includes/checkSession.php';
@include '../_includes/validation.php';

function generateAccessCode()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $random_string_length = 16;
    $string = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < $random_string_length; $i++) {
        if ($i !== 0 && ($i % 4 === 0)) {
            $string .= '-';
        }
        $string .= $characters[mt_rand(0, $max)];
    }
    return $string;
}

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$accessCode = generateAccessCode();

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
