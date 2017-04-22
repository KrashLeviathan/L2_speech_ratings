<?php
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// Handle POST form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $databaseApi->escapeAndShorten($_POST['firstName'], 255);
    $lastName = $databaseApi->escapeAndShorten($_POST['lastName'], 255);
    $univId = $databaseApi->escapeAndShorten($_POST['universityId'], 12);
    $email = $databaseApi->escapeAndShorten($_POST['email'], 255);
    $phone = $databaseApi->escapeAndShorten($_POST['phone'], 16);

    $uid = $user['user_id'];

    $databaseApi->updateUserSettings($uid, $firstName, $lastName, $univId, $email, $phone);

    // Update session variable on success
    $_SESSION['first_name'] = $firstName;
    $_SESSION['last_name'] = $lastName;
    $_SESSION['university_id'] = $univId;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;

    // Reload page to refresh session data (that populates the form as well)
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

$dateDemographicCompleted = $databaseApi->getLastDemographicDate($_SESSION['user_id']);
if ($dateDemographicCompleted) {
    // If the demographic form was completed more than 6 months ago, the user can complete it again
    $demographicFormAvailable = ((time() - (60 * 60 * 24 * 30 * 6)) > strtotime($dateDemographicCompleted));
} else {
    $demographicFormAvailable = true;
}
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
                                           value="<?= $dateStarted ?>" readonly>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Submission Buttons -->
                        <fieldset>
                            <div class="form-group col-lg-12">
                                <button id="edit-btn" type="button" class="btn btn-primary" onclick="onEditClicked()">
                                    Edit
                                </button>
                                <button id="cancel-btn" type="reset" class="btn btn-default hidden"
                                        onclick="onCancelClicked()">Cancel
                                </button>
                                <button id="submit-btn" type="submit" class="btn btn-primary hidden"
                                        onclick="onSubmitClicked()">Submit
                                </button>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <h3>Demographics</h3>
                <?php
                if ($demographicFormAvailable) {
                    print '<p>If you haven\'t already filled out the demographics form, please click the button below
and complete before taking a survey.</p><a type="button" class="btn btn-primary demographics-btn" 
href="/user_settings/demographics">Complete Demographics Form</a>';
                } else {
                    print '<p>The demographics form has already been completed recently.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="/js/user_settings.js" type="text/javascript" defer>
</script>
</body>
</html>
