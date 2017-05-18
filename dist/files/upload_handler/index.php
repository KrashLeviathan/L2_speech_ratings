<?php
/*
 * jQuery File Upload Plugin PHP Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;
@include '../../_includes/database_api.php';
@include '../../_includes/checkSession.php';
@include '../../_includes/filename_parser.php';
@include '../../_includes/wav_duration.php';

$options = array(
    'db_host' => $dbHost,
    'db_user' => $dbUser,
    'db_pass' => $dbPass,
    'db_name' => $dbName
);

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler
{
    protected function initialize()
    {
        $this->databaseApi = new DatabaseApi(
            $this->options['db_host'],
            $this->options['db_user'],
            $this->options['db_pass'],
            $this->options['db_name']
        );
        parent::initialize();
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
                                          $index = null, $content_range = null)
    {
        $file = parent::handle_file_upload(
            $uploaded_file, $name, $size, $type, $error, $index, $content_range
        );
        if (empty($file->error)) {
            $parser = new FilenameParser($file->name);
            $errorTokens = ($parser->hasErrors()) ? json_encode($parser->errorTokens) : '';
            $duration = wavDur($this->options['upload_dir'] . $file->name);
            $file->id = $this->databaseApi->addAudioSample($file, $duration, $parser, $errorTokens);

            // Block audio by language and task
            $surveyId = $this->databaseApi->getOrCreateSurveyByLanguageTask($parser->language, $parser->task);
            $blockIds = $this->databaseApi->getSurveyBlockIds($surveyId);
            $this->databaseApi->addAudioSampleToSurveyBlock($file->id, $blockIds[0]);
        }
        return $file;
    }
}

$upload_handler = new CustomUploadHandler($options);
