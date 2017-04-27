<?php
@include '../_includes/config.php';
@include '../_includes/checkSession.php';

// TODO: Validation / authentication / etc

$_SESSION['survey_id'] = (isset($_POST['surveyIdSelection']) ? $_POST['surveyIdSelection'] : -1);
$_SESSION['survey_state'] = 'SURVEY_SELECTED';

$response = array(
    'success' => true,
    'surveyId' => $_SESSION['survey_id']
);
print json_encode($response);
die();
