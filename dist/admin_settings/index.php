<?php
@include '../_includes/database_api.php';
@include '../_includes/pageSetup.php';

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);

// Handle POST form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update admin settings
    // TODO

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

                            <div class="form-group col-sm-4">
                                <label for="" class="control-label"></label>
                                <div>
                                    <input type="text" class="form-control" name="" id="" value="<?= 'TODO' ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="" class="control-label"></label>
                                <div>
                                    <input type="text" class="form-control" name="" id="" value="<?= 'TODO' ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="" class="control-label"></label>
                                <div>
                                    <input type="text" class="form-control" name="" id="" value="<?= 'TODO' ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="" class="control-label"></label>
                                <div>
                                    <input type="text" class="form-control" name="" id="" value="<?= 'TODO' ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="" class="control-label"></label>
                                <div>
                                    <input type="text" class="form-control" name="" id="" value="<?= 'TODO' ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="" class="control-label"></label>
                                <div>
                                    <input type="text" class="form-control" name="" id="" value="<?= 'TODO' ?>">
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
                                <button id="submit-btn" type="submit" class="btn btn-primary hidden">Submit
                                </button>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="/js/admin_settings.js" type="text/javascript" defer>
</script>
</body>
</html>
