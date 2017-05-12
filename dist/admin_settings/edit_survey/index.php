<?php
@include '../../_includes/database_api.php';
@include '../../_includes/pageSetup.php';

// Get survey id from url param
if (!isset($_GET['surveyId'])) {
    @include '../../_includes/html/no_such_survey.html';
    die();
}

$databaseApi = new DatabaseApi($dbHost, $dbUser, $dbPass, $dbName);
$surveyId = $databaseApi->escapeAndShorten($_GET['surveyId'], 10);
$survey = $databaseApi->getSurvey($surveyId);

?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Edit Survey</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">
                <form method="post" id="edit-survey-form">
                    <div class="well bs-component">

                        <fieldset>
                            <div class="col-lg-12">
                                <h3>Survey #<?= $survey['survey_id'] ?></h3>
                            </div>
                            <input type="hidden" name="survey_id" value="<?= $survey['survey_id'] ?>">
                            <div class="form-group col-sm-4">
                                <label for="name" class="control-label">Name</label>
                                <div>
                                    <input type="text" class="form-control" name="name"
                                           id="replays_allowed" value="<?= $survey['name'] ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-8">
                                <label for="description" class="control-label">Description</label>
                                <div>
                                    <input type="text" class="form-control" name="description"
                                           id="survey_time_limit" value="<?= $survey['description'] ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="replays_allowed" class="control-label">Replays Allowed (-1 is
                                    UNLIMITED)</label>
                                <div>
                                    <input type="number" class="form-control" name="replays_allowed"
                                           id="replays_allowed" value="<?= $survey['num_replays_allowed'] ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="survey_time_limit" class="control-label">Survey Time Limit (-1 is
                                    NONE) <span class="badge" style="color:white;background:#d9534f;">NOT YET IMPLEMENTED</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="survey_time_limit"
                                           id="survey_time_limit" value="<?= $survey['total_time_limit'] ?>">
                                    <span class="input-group-addon">minutes</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="est_length" class="control-label">Estimated Length</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="est_length"
                                           id="est_length" value="<?= $survey['estimated_length_minutes'] ?>">
                                    <span class="input-group-addon">minutes</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="notif_enabled" class="control-label">Notifications Enabled</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="notif_enabled"
                                                   value="1" <?= ($survey['notifications_enabled']) ? 'checked' : '' ?>>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="notif_enabled"
                                                   value="0" <?= (!$survey['notifications_enabled']) ? 'checked' : '' ?>>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="notif_email" class="control-label">Notification Email</label>
                                <div>
                                    <input type="email" class="form-control" name="notif_email"
                                           id="notif_email" value="<?= $survey['notification_email'] ?>">
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="rating_threshold" class="control-label">Target Rating Threshold</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="rating_threshold"
                                           id="rating_threshold"
                                           value="<?= $survey['target_rating_threshold'] ?>">
                                    <span class="input-group-addon">ratings per file</span>
                                </div>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="closed" class="control-label">Survey Closed</label>
                                <div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="closed"
                                                   value="1" <?= ($survey['closed']) ? 'checked' : '' ?>>
                                            Yes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="closed"
                                                   value="0" <?= (!$survey['closed']) ? 'checked' : '' ?>>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="addl_instructions" class="control-label">
                                    Additional Instructions (~8000 characters max)
                                </label>
                                <div>
                                    <textarea class="form-control" name="addl_instructions"
                                              id="addl_instructions"
                                              rows="4"><?= $survey['instructional_info'] ?></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <!-- Submission Buttons -->
                    <fieldset>
                        <div class="form-group col-lg-12">
                            <button id="cancel-btn" type="reset" class="btn btn-default"
                                    onclick="backToAdminSettings()">Cancel
                            </button>
                            <button id="submit-btn" type="submit" class="btn btn-primary">Submit
                            </button>
                        </div>
                        <div class="col-lg-12 l2sr-mtop-sm l2sr-mbot-sm">
                            <p>
                                <mark><strong>PLEASE NOTE:</strong> Changing the survey name will change
                                    which new file uploads will be placed in this survey.
                                </mark>
                                Files are automatically blocked by language and task, and they're placed into a survey
                                with the following name format:
                            </p>
                            <p class="text-center">
                                <code class="l2sr-code">&lt;language&gt;_t&lt;task&gt;</code>
                            </p>
                            <p>If a survey by that name does not exist, a new survey with the default settings is
                                created. This is useful to know when creating new surveys or archiving old surveys.
                                For example, let's say in
                                August you upload a bunch of files in Spanish for task 2. Later, in December, if
                                you want to upload more files for Spanish task 2, you can change the name of the
                                original survey to <code class="l2sr-code">sp_t2_aug2017</code>, which prevents
                                any more files from being added to it. When you add more files for this
                                language/task, a new survey will be created.
                                <code class="l2sr-code">sp_t2</code>.</p>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/js/edit_survey.js" type="text/javascript"></script>

</body>
</html>
