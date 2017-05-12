<?php
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// Handle POST form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update admin settings
    $surveyProperties = array(
        'num_replays_allowed' => $databaseApi->escapeAndShorten($_POST['replays_allowed'], 64),
        'total_time_limit' => $databaseApi->escapeAndShorten($_POST['survey_time_limit'], 64),
        'estimated_length_minutes' => $databaseApi->escapeAndShorten($_POST['est_length'], 64),
        'notifications_enabled' => $databaseApi->escapeAndShorten($_POST['notif_enabled'], 64),
        'notification_email' => $databaseApi->escapeAndShorten($_POST['notif_email'], 64),
        'target_rating_threshold' => $databaseApi->escapeAndShorten($_POST['rating_threshold'], 64)
    );
    $databaseApi->updateSurvey(1, $surveyProperties);

    // Update user settings
    $firstName = $databaseApi->escapeAndShorten($_POST['firstName'], 255);
    $lastName = $databaseApi->escapeAndShorten($_POST['lastName'], 255);
    $email = $databaseApi->escapeAndShorten($_POST['email'], 255);
    $phone = $databaseApi->escapeAndShorten($_POST['phone'], 16);

    $uid = $user['user_id'];

    $databaseApi->updateUserSettings($uid, $firstName, $lastName, $email, $phone);

    // Update session variable on success
    $_SESSION['first_name'] = $firstName;
    $_SESSION['last_name'] = $lastName;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;

    // Reload page to refresh session data (that populates the form as well)
    print '<script type="text/javascript">window.location = "' . $domain . '/admin_settings";</script>';
    die();
}

$firstName = $user['first_name'];
$lastName = $user['last_name'];
$email = $user['email'];
$phone = $user['phone'];

// Survey 1 is the default survey information
$defaultSurvey = $databaseApi->getSurvey(1);
?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Admin Settings</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">
                <form method="post">
                    <div class="well bs-component">
                        <fieldset id="form-user-fieldset" disabled>

                            <div class="col-lg-12">
                                <h3>User Settings</h3>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputFirstName" class="control-label">First Name</label>
                                <div>
                                    <input type="text" class="form-control" name="firstName" id="inputFirstName"
                                           value="<?= $firstName ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputLastName" class="control-label">Last Name</label>
                                <div>
                                    <input type="text" class="form-control" name="lastName" id="inputLastName"
                                           value="<?= $lastName ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail" class="control-label">Email</label>
                                <div>
                                    <input type="email" class="form-control" name="email" id="inputEmail"
                                           value="<?= $email ?>" required>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputPhone" class="control-label">Phone Number (optional)</label>
                                <div>
                                    <input type="text" class="form-control" name="phone" id="inputPhone"
                                           value="<?= $phone ?>">
                                </div>
                            </div>

                        </fieldset>
                    </div>
                    <div class="well bs-component">

                        <fieldset id="form-admin-fieldset" disabled>
                            <div class="col-lg-12">
                                <h3>Survey Defaults</h3>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="replays_allowed" class="control-label">Replays Allowed (-1 is
                                    UNLIMITED)</label>
                                <div>
                                    <input type="number" class="form-control" name="replays_allowed"
                                           id="replays_allowed" value="<?= $defaultSurvey['num_replays_allowed'] ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="survey_time_limit" class="control-label">Survey Time Limit (-1 is
                                    NONE) <span class="badge" style="color:white;background:#d9534f;">NOT YET IMPLEMENTED</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="survey_time_limit"
                                           id="survey_time_limit" value="<?= $defaultSurvey['total_time_limit'] ?>">
                                    <span class="input-group-addon">minutes</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="est_length" class="control-label">Estimated Length</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="est_length"
                                           id="est_length" value="<?= $defaultSurvey['estimated_length_minutes'] ?>">
                                    <span class="input-group-addon">minutes</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="notif_enabled" class="control-label">Notifications Enabled</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="notif_enabled"
                                                   value="1" <?= ($defaultSurvey['notifications_enabled']) ? 'checked' : '' ?>>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="notif_enabled"
                                                   value="0" <?= (!$defaultSurvey['notifications_enabled']) ? 'checked' : '' ?>>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="notif_email" class="control-label">Notification Email</label>
                                <div>
                                    <input type="email" class="form-control" name="notif_email"
                                           id="notif_email" value="<?= $defaultSurvey['notification_email'] ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="rating_threshold" class="control-label">Target Rating Threshold</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="rating_threshold"
                                           id="rating_threshold"
                                           value="<?= $defaultSurvey['target_rating_threshold'] ?>">
                                    <span class="input-group-addon">ratings per file</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Submission Buttons -->
                    <fieldset>
                        <div class="form-group col-lg-12">
                            <button id="edit-btn" type="button" class="btn btn-primary" onclick="onEditClicked()">
                                Edit
                            </button>
                            <button id="cancel-btn" type="reset" class="btn btn-default hidden"
                                    onclick="backToAdminSettings()">Cancel
                            </button>
                            <button id="submit-btn" type="submit" class="btn btn-primary hidden">Submit
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Surveys</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">
                <p>Click on a survey to edit the settings for that survey.</p>
            </div>
        </div>
        <div class="row l2sr-mbot-md">
            <div class="col-lg-12 table-responsive">
                <table class="table table-hover table-striped l2sr-table">
                    <thead class="font-weight-bold">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Start</th>
                        <th>End</th>
                        <th># Replays</th>
                        <th>Time Limit</th>
                        <th>Est. Length</th>
                        <th>Notif. Email</th>
                        <th>Notif. Threshold</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="survey-table-body">
                    <tr>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="/js/admin_settings.js" type="text/javascript" defer>
</script>
</body>
</html>
