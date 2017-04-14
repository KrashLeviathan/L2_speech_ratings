<?php

@include 'config.php';
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

    function failureToJson($mainMessage = 'Try again later, or contact IT if problems persist.', $finePrint = '')
    {
        $response = array(
            'success' => false,
            'errmsg' => $mainMessage,
            'details' => $finePrint,
            'mysql_errno' => mysqli_errno($this->link),
            'mysql_error' => mysqli_error($this->link)
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

    function escapeAndShorten($string, $length)
    {
        return substr(mysqli_real_escape_string($this->link, $string), 0, $length);
    }
}


function getUser(mysqli $mysqli, $user_id)
{
    $sql = "SELECT * FROM Users WHERE user_id = $user_id";
    if (!$result = $mysqli->query($sql)) {
        onSqlFail($mysqli, $sql);
    }
    $user = $result->fetch_assoc();
    mysqli_free_result($result);
    return $user;
}

function getAllUsers(mysqli $mysqli)
{
    $sql = "SELECT * FROM Users";
    if (!$result = $mysqli->query($sql)) {
        onSqlFail($mysqli, $sql);
    }
    $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $arr;
}
