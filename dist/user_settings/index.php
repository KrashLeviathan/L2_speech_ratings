<?php
@include '../_includes/pageSetup.php';

function handleSqlError()
{
    print '<div class="alert alert-danger alert-dismissible text-center" role="alert" style="position:fixed;bottom:0;left:0;right:0;margin:1em;">
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<strong>Database Operation Error!</strong> Try again later, or contact IT.';
    die();
}

// Handle POST form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Make updates to database
    $sql = "UPDATE Users SET ";
    $foundParams = false;

    // Prep connection
    $link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
    if ($link->connect_error) {
        handleSqlError();
    }
    mysqli_set_charset($link, 'utf8');


    if (isset($_POST['firstName'])) {
        $firstName = substr(mysqli_real_escape_string($link, $_POST['firstName']), 0, 255);
        $_SESSION['first_name'] = $firstName;
        $sql = $sql . "first_name='$firstName', ";
        $foundParams = true;
    }
    if (isset($_POST['lastName'])) {
        $lastName = substr(mysqli_real_escape_string($link, $_POST['lastName']), 0, 255);
        $_SESSION['last_name'] = $lastName;
        $sql = $sql . "last_name='$lastName', ";
        $foundParams = true;
    }
    if (isset($_POST['universityId'])) {
        $univId = substr(mysqli_real_escape_string($link, $_POST['universityId']), 0, 12);
        $_SESSION['university_id'] = $univId;
        $sql = $sql . "university_id='$univId', ";
        $foundParams = true;
    }
    if (isset($_POST['email'])) {
        $email = substr(mysqli_real_escape_string($link, $_POST['email']), 0, 255);
        $_SESSION['email'] = $email;
        $sql = $sql . "email='$email', ";
        $foundParams = true;
    }
    if (isset($_POST['phone'])) {
        $phone = substr(mysqli_real_escape_string($link, $_POST['phone']), 0, 16);
        $_SESSION['phone'] = $phone;
        $sql = $sql . "phone='$phone' ";
        $foundParams = true;
    }

    if ($foundParams) {
        $uid = $user['user_id'];
        $sql = $sql . "WHERE user_id=$uid";
        $result = $link->query($sql);
        if (!$result) {
            print $sql;
            handleSqlError();
        }
        mysqli_free_result($result);
    }

    mysqli_close($link);

    // Reload page to refresh session data (that populates the form as well)
    $domain = 'http://localhost:5000';
    print '<script type="text/javascript">window.location = "' . $domain . '/user_settings";</script>';
    die();
}

$firstName = $user['first_name'];
$lastName = $user['last_name'];
$univId = $user['university_id'];
$email = $user['email'];
$phone = $user['phone'];
// TODO
$dateStarted = '2017-04-11';
?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>User Settings</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">
                <div class="well bs-component">
                    <form method="post">
                        <fieldset id="form-fieldset" disabled>
                            <div class="form-group col-sm-4">
                                <label for="inputFirstName" class="control-label">First Name</label>
                                <div>
                                    <input type="text" class="form-control" name="firstName" id="inputFirstName"
                                           value="<?= $firstName ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputLastName" class="control-label">Last Name</label>
                                <div>
                                    <input type="text" class="form-control" name="lastName" id="inputLastName"
                                           value="<?= $lastName ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputUniversityId" class="control-label">University ID (if
                                    applicable)</label>
                                <div>
                                    <input type="text" class="form-control" name="universityId" id="inputUniversityId"
                                           value="<?= $univId ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputEmail" class="control-label">Email</label>
                                <div>
                                    <input type="email" class="form-control" name="email" id="inputEmail"
                                           value="<?= $email ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputPhone" class="control-label">Phone Number</label>
                                <div>
                                    <input type="text" class="form-control" name="phone" id="inputPhone"
                                           value="<?= $phone ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="inputDateStarted" class="control-label">Date Started</label>
                                <div>
                                    <input type="date" class="form-control" id="inputDateStarted"
                                           value="<?= $dateStarted ?>" disabled>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group col-lg-12">
                            <button id="edit-btn" type="button" class="btn btn-primary" onclick="onEditClicked()">Edit
                            </button>
                            <button id="cancel-btn" type="reset" class="btn btn-default hidden"
                                    onclick="onCancelClicked()">Cancel
                            </button>
                            <button id="submit-btn" type="submit" class="btn btn-primary hidden"
                                    onclick="onSubmitClicked()">Submit
                            </button>
                        </div>
                    </form>
                </div>
                <h3>Demographics</h3>
                <p>If you haven't already filled out the demographics form, please click the button below and
                    complete before taking a survey.</p>
                <a type="button" class="btn btn-primary" href="/user_settings/demographics" style="margin:1em 0;">
                    Complete Demographics Form</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" defer>
    var editButton;
    var cancelButton;
    var submitButton;

    var editModeActive = false;

    document.addEventListener("DOMContentLoaded", function () {
        editButton = $('#edit-btn');
        cancelButton = $('#cancel-btn');
        submitButton = $('#submit-btn');
    });

    function onEditClicked() {
        editButton.addClass('hidden');
        cancelButton.removeClass('hidden');
        submitButton.removeClass('hidden');
        editModeActive = true;
        $('#form-fieldset').removeAttr('disabled');
    }

    function onCancelClicked() {
        editButton.removeClass('hidden');
        cancelButton.addClass('hidden');
        submitButton.addClass('hidden');
        editModeActive = false;
        $('#form-fieldset').prop('disabled', true);
    }

    function onSubmitClicked() {
    }
</script>
</body>
</html>
