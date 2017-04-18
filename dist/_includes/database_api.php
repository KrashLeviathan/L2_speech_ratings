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
     * @param $universityId
     * @param $email
     * @param $phone
     */
    function updateUserSettings($userId, $firstName, $lastName, $universityId, $email, $phone)
    {
        $sql = "UPDATE Users SET first_name='$firstName', last_name='$lastName', university_id='$universityId', " .
            "email='$email', phone='$phone' WHERE user_id=$userId";

        $result = $this->link->query($sql);
        if (!$result) {
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
        $sql = "SELECT email FROM Invites " .
            "WHERE access_code = '$accessCode' AND (validation <> 'COMPLETE' OR validation IS NULL)";
        $result = $this->link->query($sql);
        if (!$result) {
            $this->failureToJson('accessCodeToInviteEmail: !$result');
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
        $sql = "UPDATE Invites SET validation='$validation' WHERE access_code='$accessCode'";
        $result = $this->link->query($sql);
        if (!$result) {
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
        $sql = "SELECT email FROM Invites WHERE validation='$validation'";
        $result = $this->link->query($sql);
        if (!$result) {
            $this->failureToJson('checkInviteValidation');
        }
        $isValid = (mysqli_num_rows($result) != 0);
        mysqli_free_result($result);
        return $isValid;
    }

    function completeInvite($userId, $validation)
    {
        $sql = "UPDATE Invites SET accepted_by=$userId, validation='COMPLETE'" .
            ", accepted_date=NOW() WHERE validation='$validation'";
        $result = $this->link->query($sql);
        if (!$result) {
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
        $sql = "INSERT INTO Users (google_id, first_name, last_name, email, date_signed_up) " .
            "VALUES ('$googleId','$firstName','$lastName','$email',NOW())";
        $result = $this->link->query($sql);
        if (!$result) {
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
        $sql = "SELECT * FROM Users WHERE google_id='$googleId'";
        $result = $this->link->query($sql);
        if (!$result) {
            $this->failureToJson('getUserIdFromGoogleId: !$result');
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
        $sql = "SELECT * FROM Admins WHERE user_id = $userId";
        $result = $this->link->query($sql);
        if (!$result) {
            $this->failureToJson('isUserAdmin');
        }
        $userIsAdmin = (mysqli_num_rows($result) != 0);
        mysqli_free_result($result);
        return $userIsAdmin;
    }

    function createCsvFromResults($filename)
    {
        $csv = new CsvCreator($filename);
        if ($csv->hasError()) {
            return array('success' => false, 'errorMsg' => $csv->errorMsg);
        }

        // TODO: Fix me to return actual results
        $csv->append('user_id,google_id,yada,yada,yada,...');
        $sql = "SELECT * FROM Users";
        $result = $this->link->query($sql);
        while ($row = $result->fetch_row()) {
            $csv->append($row[0] . ',' . $row[1] . ',' . $row[2] . ',' . $row[3] . ',' . $row[4] .
                ',' . $row[5] . ',' . $row[6] . ',' . $row[7] . ',' . $row[8] . "\n");
        }
        mysqli_free_result($result);
        return array('success' => true);
    }

    function getAllUsers()
    {
        $sql = "SELECT user_id, first_name, last_name, email, phone, date_signed_up, university_id FROM Users";
        $result = $this->link->query($sql);
        if (!$result) {
            $this->failureToJson('getAllUsers: !$result');
        }
        $users = $result->fetch_all();
        mysqli_free_result($result);
        return $users;
    }
}
