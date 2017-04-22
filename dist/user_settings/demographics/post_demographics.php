<?php
@include '../../_includes/database_api.php';
@include '../../_includes/checkSession.php';

// Make sure it's POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    print "Not a POST request!";
    die();
}

$formData = array(
    'age' => $_POST['inputAge'] || '',
    'gender' => $_POST['inputGender'] || '',
    'birthplace' => $_POST['inputBirthplace'] || '',
    'locationRaised' => $_POST['inputLocationRaised'] || '',
    'nativeLanguages' => $_POST['inputNativeLanguages'] || '',
    'educationLevel' => $_POST['inputEducationLevel'] || '',
    'educationLevelOther' => $_POST['inputEducationLevelOther'] || '',
    'spListening' => $_POST['inputSpanishListening'] || '',
    'spSpeaking' => $_POST['inputSpanishSpeaking'] || '',
    'spReading' => $_POST['inputSpanishReading'] || '',
    'spWriting' => $_POST['inputSpanishWriting'] || '',
    'spAge' => $_POST['inputSpanishAge'] || '',
    'spWithFamily' => $_POST['inputSpanishWithFamily'] || '',
    'spUsagePercent' => $_POST['inputSpanishUsagePercent'] || '',
    'spNNInteraction' => $_POST['inputSpNNInteraction'] || '',
    'spInteractionCap' => $_POST['inputSpInteractionCapacity'] || '',
    'spInteractionCapOther' => $_POST['inputSpInteractionCapacityOther'] || '',
    'spNNFamiliarity' => $_POST['inputNonNativeSpanishFamiliarity'] || '',
    'frListening' => $_POST['inputFrenchListening'] || '',
    'frSpeaking' => $_POST['inputFrenchSpeaking'] || '',
    'frReading' => $_POST['inputFrenchReading'] || '',
    'frWriting' => $_POST['inputFrenchWriting'] || '',
    'frAge' => $_POST['inputFrenchAge'] || '',
    'frWithFamily' => $_POST['inputFrenchWithFamily'] || '',
    'frUsagePercent' => $_POST['inputFrenchUsagePercent'] || '',
    'frNNInteraction' => $_POST['inputFrNNInteraction'] || '',
    'frInteractionCap' => $_POST['inputFrInteractionCapacity'] || '',
    'frInteractionCapOther' => $_POST['inputFrInteractionCapacityOther'] || '',
    'frNNFamiliarity' => $_POST['inputNonNativeFrenchFamiliarity'] || '',
    'enListening' => $_POST['inputEnglishListening'] || '',
    'enSpeaking' => $_POST['inputEnglishSpeaking'] || '',
    'enReading' => $_POST['inputEnglishReading'] || '',
    'enWriting' => $_POST['inputEnglishWriting'] || '',
    'enAge' => $_POST['inputEnglishAge'] || '',
    'enWithFamily' => $_POST['inputEnglishWithFamily'] || '',
    'enUsagePercent' => $_POST['inputEnglishUsagePercent'] || '',
    'instrElementary' => $_POST['inputInstructionElementary'] || '',
    'instrSecondary' => $_POST['inputInstructionSecondary'] || '',
    'instrHS' => $_POST['inputInstructionHS'] || '',
    'instrCollege' => $_POST['inputInstructionCollege'] || '',
    'instrGraduate' => $_POST['inputInstructionGraduate'] || '',
    'addlLanguages' => $_POST['inputAdditionalLanguages'] || '',
    'lingTraining' => $_POST['inputLinguisticsTraining'] || '',
    'taughtLanguage' => $_POST['inputTaughtLanguage'] || '',
    'personalInfo' => $_POST['inputPersonalInfo'] || ''
);

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$response = $databaseApi->postDemographicFormData($formData);

print json_encode($response);
die();
