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

$adminOnlyPage = true;
@include '../../_includes/config.php';
@include '../../_includes/checkSession.php';
@include '../../_includes/filename_parser.php';
@include '../../_includes/wav_duration.php';

$options = array(
    'delete_type' => 'POST',
    'db_host' => $dbHost,
    'db_user' => $dbUser,
    'db_pass' => $dbPass,
    'db_name' => $dbName,
    'db_table' => 'AudioSamples'
);

error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler
{
    protected function initialize()
    {
        $this->db = new mysqli(
            $this->options['db_host'],
            $this->options['db_user'],
            $this->options['db_pass'],
            $this->options['db_name']
        );
        parent::initialize();
        $this->db->close();
    }

//    protected function handle_form_data($file, $index)
//    {
//        $file->title = @$_REQUEST['title'][$index];
//        $file->description = @$_REQUEST['description'][$index];
//    }

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
            $sql = 'INSERT INTO `' . $this->options['db_table']
                . '` (`filename`,`size`,`duration_ms`,`type`,`language`,`level`,`speaker_id`,`wave`,`task`,`item`,`error_tokens`)'
                . ' VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                . ' ON DUPLICATE KEY UPDATE'
                . ' size=?, duration_ms=?, type=?, language=?, level=?, speaker_id=?, wave=?, task=?, item=?, error_tokens=?,'
                . ' upload_date=NOW()';
            $query = $this->db->prepare($sql);
            $query->bind_param(
                'sissssiiiis' . 'issssiiiis',
                $file->name,
                $file->size,
                $duration,
                $file->type,
                $parser->language,
                $parser->level,
                $parser->id,
                $parser->wave,
                $parser->task,
                $parser->item,
                $errorTokens,
                $file->size,
                $duration,
                $file->type,
                $parser->language,
                $parser->level,
                $parser->id,
                $parser->wave,
                $parser->task,
                $parser->item,
                $errorTokens
            );
            $query->execute();
            $file->id = $this->db->insert_id;
        }
        return $file;
    }

    protected function set_additional_file_properties($file)
    {
        parent::set_additional_file_properties($file);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $sql = 'SELECT `audio_sample_id`, `type` FROM `'
                . $this->options['db_table'] . '` WHERE `filename`=?';
            $query = $this->db->prepare($sql);
            $query->bind_param('s', $file->name);
            $query->execute();
            $query->bind_result(
                $id,
                $type
            );
            while ($query->fetch()) {
                $file->id = $id;
                $file->type = $type;
            }
        }
    }

    public function delete($print_response = true)
    {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                $sql = 'DELETE FROM `'
                    . $this->options['db_table'] . '` WHERE `filename`=?';
                $query = $this->db->prepare($sql);
                $query->bind_param('s', $name);
                $query->execute();
            }
        }
        return $this->generate_response($response, $print_response);
    }

}

$upload_handler = new CustomUploadHandler($options);
