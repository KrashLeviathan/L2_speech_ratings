<?php
@include '../_includes/config.php';
@include '../_includes/checkSession.php';

$_SESSION['survey_id'] = 1;
$_SESSION['survey_state'] = 'SURVEY_SELECTED';

$response = array(
    'success' => true
);
print json_encode($response);
die();
