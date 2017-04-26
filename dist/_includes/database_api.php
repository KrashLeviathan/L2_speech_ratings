<?php

@include 'config.php';
@include 'csv_creator.php';
$includedConfig = true;

class DatabaseApi
{
    var $link;

    function __construct($dbHost, $dbUser, $dbPass, $dbName)
    {
        $this->link = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        $this->link->set_charset('utf8');
    }

    function __destruct()
    {
        $this->link->close();
    }

    function failureToJson($thrownBy = '', $mainMessage = 'Try again later, or contact IT if problems persist.', $finePrint = '')
    {
        $response = array(
            'success' => false,
            'errmsg' => $mainMessage,
            'details' => $finePrint,
            'mysql_errno' => mysqli_errno($this->link),
            'mysql_error' => mysqli_error($this->link),
            'thrown_by' => $thrownBy
        );
        print json_encode($response);
        $this->link->close();
        die();
    }

    function failureToHtml($mainMessage = 'Try again later, or contact IT if problems persist.', $finePrint = '')
    {
        $finePrintParagraph = ($finePrint !== '') ? '<p class="small">' . $finePrint . '</p>' : '';
        print '<div class="alert alert-danger alert-dismissible text-center l2sr-alert" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<p><strong>Error!</strong>' . $mainMessage . '</p>' . $finePrintParagraph . '</div>';
        die();
    }

    /**
     * Used to update the user settings.
     * @param $userId
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $phone
     */
    function updateUserSettings($userId, $firstName, $lastName, $email, $phone)
    {
        $sql = "UPDATE L2_speech_ratings.Users SET first_name='$firstName', last_name='$lastName', " .
            "email='$email', phone='$phone' WHERE user_id=$userId";

        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToHtml();
        }
        mysqli_free_result($result);
    }

    /**
     * Escapes dangerous characters from the string and shortens it to the desired length.
     * @param $string
     * @param $length
     * @return bool|string the escaped and shortened string
     */
    function escapeAndShorten($string, $length)
    {
        return substr(mysqli_real_escape_string($this->link, $string), 0, $length);
    }

    /**
     * Checks to see if the given access code is valid, and then (if valid) returns the invite
     * email for that access code.
     * @param $accessCode
     * @return string The email for the given access code
     */
    function accessCodeToInviteEmail($accessCode)
    {
        $sql = "SELECT email FROM L2_speech_ratings.Invites " .
            "WHERE access_code = '$accessCode' AND (validation <> 'COMPLETE' OR validation IS NULL)";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('accessCodeToInviteEmail: query error');
        }
        if (mysqli_num_rows($result) == 0) {
            $this->failureToJson('accessCodeToInviteEmail: 0 results', 'No such access code!');
        }
        $assoc = $result->fetch_assoc();
        mysqli_free_result($result);
        return $assoc['email'];
    }

    /**
     * Validates the access code with the generated validation token
     * @param $accessCode
     * @param $validation
     */
    function accessCodeValidation($accessCode, $validation)
    {
        $sql = "UPDATE L2_speech_ratings.Invites SET validation='$validation' WHERE access_code='$accessCode'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('accessCodeValidation');
        }
        mysqli_free_result($result);
    }

    /**
     * Makes sure the invite validation code is valid.
     * @param $validation
     * @return bool true if it's valid, otherwise false.
     */
    function checkInviteValidation($validation)
    {
        $sql = "SELECT email FROM L2_speech_ratings.Invites WHERE validation='$validation'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('checkInviteValidation');
        }
        $isValid = (mysqli_num_rows($result) != 0);
        mysqli_free_result($result);
        return $isValid;
    }

    function completeInvite($userId, $validation)
    {
        $sql = "UPDATE L2_speech_ratings.Invites SET accepted_by=$userId, validation='COMPLETE'" .
            ", accepted_date=NOW() WHERE validation='$validation'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('completeInvite');
        }
        mysqli_free_result($result);
    }

    /**
     * Creates a new user with the given parameters
     * @param $googleId
     * @param $firstName
     * @param $lastName
     * @param $email
     */
    function createNewUser($googleId, $firstName, $lastName, $email)
    {
        $sql = "INSERT INTO L2_speech_ratings.Users (google_id, first_name, last_name, email, date_signed_up) " .
            "VALUES ('$googleId','$firstName','$lastName','$email',NOW())";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('createNewUser');
        }
        mysqli_free_result($result);
    }

    /**
     * Gets the user for the given google id.
     * @param $googleId
     * @return array user
     */
    function getUserFromGoogleId($googleId)
    {
        $sql = "SELECT * FROM L2_speech_ratings.Users WHERE google_id='$googleId'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getUserIdFromGoogleId: query error');
        }
        if (mysqli_num_rows($result) == 0) {
            $this->failureToJson('getUserIdFromGoogleId: 0 results', 'No such user! Create a new account first.');
        }
        $user = $result->fetch_assoc();
        mysqli_free_result($result);
        return $user;
    }

    /**
     * Returns true if the user is an admin, otherwise returns false.
     * @param $userId
     * @return bool
     */
    function isUserAdmin($userId)
    {
        $sql = "SELECT * FROM L2_speech_ratings.Admins WHERE user_id = $userId";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('isUserAdmin');
        }
        $userIsAdmin = (mysqli_num_rows($result) != 0);
        mysqli_free_result($result);
        return $userIsAdmin;
    }

    function createCsvFromResults($surveyId, $filepath, $filename)
    {
        $csv = new CsvCreator($filepath, $filename);
        if ($csv->hasError()) {
            return array('success' => false, 'errorMsg' => $csv->errorMsg);
        }

        // Heading
        $headingFields = array('rater', 'block', 'ns', 'id', 'language', 'level', 'wave', 'item', 'task', 'rating',
            'demographics_date', 'age', 'gender', 'birthplace',
            'location_raised', 'native_languages', 'education_level', 'education_level_other',
            'sp_listening', 'sp_speaking', 'sp_reading', 'sp_writing', 'sp_age', 'sp_with_family', 'sp_usage_percent',
            'sp_nn_interaction', 'sp_interaction_cap', 'sp_interaction_cap_other', 'sp_nn_familiarity',
            'fr_listening', 'fr_speaking', 'fr_reading', 'fr_writing', 'fr_age', 'fr_with_family', 'fr_usage_percent',
            'fr_nn_interaction', 'fr_interaction_cap', 'fr_interaction_cap_other', 'fr_nn_familiarity',
            'en_listening', 'en_speaking', 'en_reading', 'en_writing', 'en_age', 'en_with_family', 'en_usage_percent',
            'instr_elementary', 'instr_secondary', 'instr_hs', 'instr_college', 'instr_graduate', 'addl_languages',
            'ling_training', 'taught_language', 'personal_info');
        $csv->append($headingFields);

        // Data
        $sql = "SELECT
re.performed_by_id AS rater,

rp.csv_value AS block,

aud.native_speaker AS ns,
aud.speaker_id AS id,
aud.language,
aud.level,
aud.wave,
aud.item,
aud.task,

rs.score,

dem.date_completed as demographics_date,
dem.age,
dem.gender,
dem.birthplace,
dem.location_raised,
dem.native_languages,
dem.education_level,
dem.education_level_other,

dem.sp_listening,
dem.sp_speaking,
dem.sp_reading,
dem.sp_writing,
dem.sp_age,
dem.sp_with_family,
dem.sp_usage_percent,
dem.sp_nn_interaction,
dem.sp_interaction_cap,
dem.sp_interaction_cap_other,
dem.sp_nn_familiarity,

dem.fr_listening,
dem.fr_speaking,
dem.fr_reading,
dem.fr_writing,
dem.fr_age,
dem.fr_with_family,
dem.fr_usage_percent,
dem.fr_nn_interaction,
dem.fr_interaction_cap,
dem.fr_interaction_cap_other,
dem.fr_nn_familiarity,

dem.en_listening,
dem.en_speaking,
dem.en_reading,
dem.en_writing,
dem.en_age,
dem.en_with_family,
dem.en_usage_percent,

dem.instr_elementary,
dem.instr_secondary,
dem.instr_hs,
dem.instr_college,
dem.instr_graduate,

dem.addl_languages,
dem.ling_training,
dem.taught_language,
dem.personal_info
FROM
L2_speech_ratings.RatingEvents AS re
INNER JOIN
L2_speech_ratings.Demographics AS dem ON re.performed_by_id = dem.user_id
INNER JOIN
L2_speech_ratings.AudioSamples AS aud ON re.audio_sample_id = aud.audio_sample_id
INNER JOIN
L2_speech_ratings.RatingEventScoreLookup AS resl ON re.rating_event_id = resl.rating_event_id
INNER JOIN
L2_speech_ratings.RatingScores AS rs ON resl.rating_score_id = rs.rating_score_id
INNER JOIN
L2_speech_ratings.RatingProperties AS rp ON rs.property = rp.rating_property_id
WHERE
re.survey_id='$surveyId' AND dem.date_completed = (
SELECT MAX(date_completed)
FROM L2_speech_ratings.Demographics AS dem_max
WHERE re.performed_by_id = dem_max.user_id
)";
        $result = $this->link->query($sql);
        while ($row = $result->fetch_row()) {
            $csv->append($row);
        }
        mysqli_free_result($result);
        return array('success' => true);
    }

    function createCsvFromDemographics($filepath, $filename)
    {
        $csv = new CsvCreator($filepath, $filename);
        if ($csv->hasError()) {
            return array('success' => false, 'errorMsg' => $csv->errorMsg);
        }

        // Heading
        $headingFields = array('demographic_id', 'user_id', 'date_completed', 'age', 'gender', 'birthplace',
            'location_raised', 'native_languages', 'education_level', 'education_level_other',
            'sp_listening', 'sp_speaking', 'sp_reading', 'sp_writing', 'sp_age', 'sp_with_family', 'sp_usage_percent',
            'sp_nn_interaction', 'sp_interaction_cap', 'sp_interaction_cap_other', 'sp_nn_familiarity',
            'fr_listening', 'fr_speaking', 'fr_reading', 'fr_writing', 'fr_age', 'fr_with_family', 'fr_usage_percent',
            'fr_nn_interaction', 'fr_interaction_cap', 'fr_interaction_cap_other', 'fr_nn_familiarity',
            'en_listening', 'en_speaking', 'en_reading', 'en_writing', 'en_age', 'en_with_family', 'en_usage_percent',
            'instr_elementary', 'instr_secondary', 'instr_hs', 'instr_college', 'instr_graduate', 'addl_languages',
            'ling_training', 'taught_language', 'personal_info');
        $csv->append($headingFields);

        // Data
        $sql = "SELECT * FROM L2_speech_ratings.Demographics";
        $result = $this->link->query($sql);
        while ($row = $result->fetch_row()) {
            $csv->append($row);
        }
        mysqli_free_result($result);
        return array('success' => true);
    }

    function postDemographicFormData($userId, $formData)
    {
        $sql = "INSERT INTO L2_speech_ratings.Demographics (user_id, age, gender, birthplace, location_raised, native_languages, education_level, education_level_other, sp_listening, sp_speaking, sp_reading, sp_writing, sp_age, sp_with_family, sp_usage_percent, sp_nn_interaction, sp_interaction_cap, sp_interaction_cap_other, sp_nn_familiarity, fr_listening, fr_speaking, fr_reading, fr_writing, fr_age, fr_with_family, fr_usage_percent, fr_nn_interaction, fr_interaction_cap, fr_interaction_cap_other, fr_nn_familiarity, en_listening, en_speaking, en_reading, en_writing, en_age, en_with_family, en_usage_percent, instr_elementary, instr_secondary, instr_hs, instr_college, instr_graduate, addl_languages, ling_training, taught_language, personal_info)"
            . " VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->link->prepare($sql);
        $query->bind_param(
            'iissssssiiiiiiisssiiiiiiiisssiiiiiiiissssssiis',
            $userId,
            $formData['age'],
            $formData['gender'],
            $formData['birthplace'],
            $formData['locationRaised'],
            $formData['nativeLanguages'],
            $formData['educationLevel'],
            $formData['educationLevelOther'],
            $formData['spListening'],
            $formData['spSpeaking'],
            $formData['spReading'],
            $formData['spWriting'],
            $formData['spAge'],
            $formData['spWithFamily'],
            $formData['spUsagePercent'],
            $formData['spNNInteraction'],
            $formData['spInteractionCap'],
            $formData['spInteractionCapOther'],
            $formData['spNNFamiliarity'],
            $formData['frListening'],
            $formData['frSpeaking'],
            $formData['frReading'],
            $formData['frWriting'],
            $formData['frAge'],
            $formData['frWithFamily'],
            $formData['frUsagePercent'],
            $formData['frNNInteraction'],
            $formData['frInteractionCap'],
            $formData['frInteractionCapOther'],
            $formData['frNNFamiliarity'],
            $formData['enListening'],
            $formData['enSpeaking'],
            $formData['enReading'],
            $formData['enWriting'],
            $formData['enAge'],
            $formData['enWithFamily'],
            $formData['enUsagePercent'],
            $formData['instrElementary'],
            $formData['instrSecondary'],
            $formData['instrHS'],
            $formData['instrCollege'],
            $formData['instrGraduate'],
            $formData['addlLanguages'],
            $formData['lingTraining'],
            $formData['taughtLanguage'],
            $formData['personalInfo']
        );
        $result = $query->execute();
        if ($this->link->error) {
            $this->failureToJson('postDemographicFormData: query error');
        }
        return array('success' => true);
    }

    function getLastDemographicDate($userId)
    {
        $sql = "SELECT date_completed FROM L2_speech_ratings.Demographics WHERE user_id = '$userId'"
            . " ORDER BY date_completed DESC LIMIT 1";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getLastDemographicDate: query error');
        }
        if (mysqli_num_rows($result) == 0) {
            return false;
        }
        $date_completed = $result->fetch_row()[0];
        mysqli_free_result($result);
        return $date_completed;

    }

    function getAllFiles()
    {
        $sql = "SELECT audio_sample_id, filename, duration_ms, upload_date, error_tokens FROM L2_speech_ratings.AudioSamples "
            . "ORDER BY filename";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getAllFiles: query error');
        }
        $files = $result->fetch_all();
        mysqli_free_result($result);
        return $files;
    }

    function deleteFiles($fileList)
    {
        foreach ($fileList as $file) {
            $sanitizedFile = $this->escapeAndShorten($file, 255);
            if (strlen($file) !== strlen($sanitizedFile) || strpos($sanitizedFile, '..') !== false) {
                $this->failureToJson('deleteFiles: invalid filename',
                    $file . ' is not a valid filename!');
            }
            $sql = "DELETE FROM L2_speech_ratings.AudioSamples WHERE filename='$sanitizedFile'";
            $result = $this->link->query($sql);
            if ($this->link->error) {
                $this->failureToJson('deleteFiles: query error',
                    'Not all files could be deleted! Contact IT if problems persist.',
                    'Reload the page to refresh the table.');
            }
            mysqli_free_result($result);
            unlink("../file_storage/audio_samples/" . $sanitizedFile);
        }
    }

    function getAllUsers()
    {
        $sql = "SELECT user_id, first_name, last_name, email, phone, date_signed_up FROM L2_speech_ratings.Users";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getAllUsers: query error');
        }
        $users = $result->fetch_all();
        mysqli_free_result($result);
        return $users;
    }

    function getAllInvites()
    {
        $sql = "SELECT * FROM L2_speech_ratings.Invites";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getAllInvites: query error');
        }
        $invites = $result->fetch_all();
        for ($i = 0; $i < sizeof($invites); $i++) {
            if (!$invites[$i] || $invites[$i][3] !== 'COMPLETE') {
                $invites[$i][3] = 'OPEN';
            }
        }
        mysqli_free_result($result);
        return $invites;
    }

    function addInvite($accessCode, $email)
    {
        $sql = "INSERT INTO L2_speech_ratings.Invites (access_code, email)"
            . " VALUES ('$accessCode','$email')";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getAllInvites: query error');
        }
        mysqli_free_result($result);
    }

    function addAudioSample($jq_file, $duration, $parser, $errorTokens)
    {
        $sql = 'INSERT INTO L2_speech_ratings.AudioSamples'
            . ' (`filename`,`size`,`duration_ms`,`type`,`language`,`level`,`speaker_id`,`wave`,`task`,`item`,`error_tokens`)'
            . ' VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            . ' ON DUPLICATE KEY UPDATE'
            . ' size=?, duration_ms=?, type=?, language=?, level=?, speaker_id=?, wave=?, task=?, item=?, error_tokens=?,'
            . ' upload_date=NOW()';
        $query = $this->link->prepare($sql);
        $query->bind_param(
            'sissssiiiisissssiiiis',
            $jq_file->name,
            $jq_file->size,
            $duration,
            $jq_file->type,
            $parser->language,
            $parser->level,
            $parser->id,
            $parser->wave,
            $parser->task,
            $parser->item,
            $errorTokens,
            $jq_file->size,
            $duration,
            $jq_file->type,
            $parser->language,
            $parser->level,
            $parser->id,
            $parser->wave,
            $parser->task,
            $parser->item,
            $errorTokens
        );
        $query->execute();
        return $this->link->insert_id;
    }

    function addAudioSampleToSurveyBlock($fileId, $blockId = 1)
    {
        $sql = "INSERT INTO L2_speech_ratings.SampleBlockAudioLookup (`sample_block_id`, `audio_sample_id`)"
            . "VALUES ('$blockId', '$fileId');";
        $this->link->query($sql);
    }

    function getOrCreateSurveyByLanguageTask($language, $task)
    {
        $name = $language . "_t" . $task;
        $sql = "SELECT survey_id FROM L2_speech_ratings.Surveys WHERE name='$name'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getOrCreateSurveyByLanguageTask: query error');
        }
        if (mysqli_num_rows($result) == 0) {
            // The survey does not yet exist, so create one and return the survey_id
            $surveyId = $this->insertSurvey($name,
                "Contains all samples with the following attributes: Language = $language, Task = $task");
            return $surveyId;
        } else {
            // The survey already exists, so return the survey_id
            return $result->fetch_row()[0];
        }
    }

    function getSurvey($surveyId)
    {
        $sql = "SELECT * FROM L2_speech_ratings.Surveys WHERE survey_id='$surveyId'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getSurvey: query error');
        }
        if (mysqli_num_rows($result) == 0) {
            $this->failureToJson('getSurvey: 0 results',
                'The survey with that ID does not exist!',
                'surveyId: ' . $surveyId);
        }
        $survey = $result->fetch_assoc();
        mysqli_free_result($result);
        return $survey;
    }

    function getSurveyBlockIds($surveyId)
    {
        $sql = "SELECT sample_block_id FROM L2_speech_ratings.SurveySampleBlockLookup WHERE survey_id='$surveyId'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getSurveyBlockIds: query error');
        }
        $blockIds = array();
        while ($row = $result->fetch_row()) {
            array_push($blockIds, $row[0]);
        }
        mysqli_free_result($result);
        return $blockIds;
    }

    function updateSurvey($surveyId, $surveyProperties, $toJson = false)
    {
        $firstProp = true;
        $sql = "UPDATE L2_speech_ratings.Surveys SET";
        foreach ($surveyProperties as $property => $value) {
            $sql .= (($firstProp) ? "" : ",")
                . " $property='$value'";
            $firstProp = false;
        }
        $sql .= " WHERE survey_id='$surveyId'";

        $this->link->query($sql);
        if ($this->link->error) {
            if ($toJson) {
                $this->failureToJson('updateSurvey');
            } else {
                $this->failureToHtml();
            }
        }
    }

    function insertSurvey($name, $description)
    {
        // Get defaults
        $defaultSurvey = $this->getSurvey(1);
        $numReplaysAllowed = $defaultSurvey['num_replays_allowed'];
        $totalTimeLimit = $defaultSurvey['total_time_limit'];
        $estimatedLengthMinutes = $defaultSurvey['estimated_length_minutes'];
        $notificationsEnabled = $defaultSurvey['notifications_enabled'];
        $notificationEmail = $defaultSurvey['notification_email'];
        $targetRatingThreshold = $defaultSurvey['target_rating_threshold'];

        // Create new survey
        $sql = "INSERT INTO L2_speech_ratings.Surveys"
            . " (name, description, num_replays_allowed, total_time_limit, estimated_length_minutes, notifications_enabled, notification_email, target_rating_threshold)"
            . " VALUES ('$name', '$description', '$numReplaysAllowed', '$totalTimeLimit', '$estimatedLengthMinutes', '$notificationsEnabled', '$notificationEmail', '$targetRatingThreshold')";
        $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('insertSurvey: 1');
        }
        $surveyId = $this->link->insert_id;

        // Create a default block for that survey
        $sql = "INSERT INTO L2_speech_ratings.SampleBlocks (name) VALUES ('Default Block')";
        $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('insertSurvey: 2');
        }
        $blockId = $this->link->insert_id;

        // Map the block to the survey
        $sql = "INSERT INTO L2_speech_ratings.SurveySampleBlockLookup (survey_id, sample_block_id)"
            . " VALUES ('$surveyId','$blockId')";
        $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('insertSurvey: 3');
        }

        return $surveyId;
    }

    function completeSurvey($userId, $surveyId)
    {
        $sql = "INSERT INTO L2_speech_ratings.SurveyCompletions (survey_id, user_id) VALUES ('$surveyId', '$userId')";
        $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('completeSurvey: query error');
        }
    }

    function getAudioIdsFromSurveyBlock($surveyId)
    {
        $sql = "SELECT audioLU.audio_sample_id FROM L2_speech_ratings.SampleBlockAudioLookup AS audioLU"
            . " INNER JOIN L2_speech_ratings.SurveySampleBlockLookup AS surveyLU ON audioLU.sample_block_id = surveyLU.sample_block_id"
            . " WHERE surveyLU.survey_id = '$surveyId';";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getAudioIdsFromSurveyBlock: query error');
        }
        if (mysqli_num_rows($result) == 0) {
            $this->failureToJson('getAudioIdsFromSurveyBlock: 0 results',
                'That survey does not have any audio samples to rate!',
                'surveyId: ' . $surveyId);
        }
        $survey = $result->fetch_all();
        mysqli_free_result($result);
        return $survey;
    }

    function getAudioFilename($audioId)
    {
        $sql = "SELECT filename FROM L2_speech_ratings.AudioSamples WHERE audio_sample_id='$audioId'";
        $result = $this->link->query($sql);
        if ($this->link->error) {
            $this->failureToJson('getAudioFilename: query error');
        }
        if (mysqli_num_rows($result) == 0) {
            $this->failureToJson('getAudioFilename: 0 results',
                'There is no audio file for that id!',
                'audioId: ' . $audioId);
        }
        $filename = $result->fetch_row()[0];
        mysqli_free_result($result);
        return $filename;

    }

    function createRatingEvent($comprehension, $fluency, $accent, $userId, $audioId, $surveyId)
    {
        // Create the rating event
        $sql = "INSERT INTO L2_speech_ratings.RatingEvents (performed_by_id, audio_sample_id, survey_id)"
            . " VALUES ('$userId', '$audioId', '$surveyId')";
        $this->link->query($sql);
        $eventId = $this->link->insert_id;

        // Create the scores
        $sql = "INSERT INTO L2_speech_ratings.RatingScores (score, property) VALUES ('$comprehension','1')";
        $this->link->query($sql);
        $scoreId1 = $this->link->insert_id;
        $sql = "INSERT INTO L2_speech_ratings.RatingScores (score, property) VALUES ('$fluency','2')";
        $this->link->query($sql);
        $scoreId2 = $this->link->insert_id;
        $sql = "INSERT INTO L2_speech_ratings.RatingScores (score, property) VALUES ('$accent','3')";
        $this->link->query($sql);
        $scoreId3 = $this->link->insert_id;

        // Map the scores to the event
        $sql = "INSERT INTO L2_speech_ratings.RatingEventScoreLookup (rating_event_id, rating_score_id)"
            . " VALUES ('$eventId', '$scoreId1')";
        $this->link->query($sql);
        $sql = "INSERT INTO L2_speech_ratings.RatingEventScoreLookup (rating_event_id, rating_score_id)"
            . " VALUES ('$eventId', '$scoreId2')";
        $this->link->query($sql);
        $sql = "INSERT INTO L2_speech_ratings.RatingEventScoreLookup (rating_event_id, rating_score_id)"
            . " VALUES ('$eventId', '$scoreId3')";
        $this->link->query($sql);
    }
}
