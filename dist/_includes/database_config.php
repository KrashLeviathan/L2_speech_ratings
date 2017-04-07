<?php
// Load up configuration info for connecting to the database

$this_file = str_replace('dist', '', $_SERVER['DOCUMENT_ROOT']);
//$this_file = str_replace('L2_speech_ratings.iastate.edu', '', $_SERVER['DOCUMENT_ROOT']);

$sql_file = $this_file . 'config.txt';

$json = "";
if (file_exists($sql_file)) {
    $contents = file_get_contents($sql_file);
    $json = $contents;
}
$json = json_decode($json);

$dbHost = $json->{'mysql_database'}->{'host'};
$dbName = $json->{'mysql_database'}->{'database'};
$dbUser = $json->{'mysql_database'}->{'username'};
$dbPass = $json->{'mysql_database'}->{'password'};

$port = $json->{'port'};

// Uncomment this section for your local database.
// #############################################
$dbHost = 'localhost';
$dbName = 'L2_speech_ratings';
$dbUser = 'root';
$dbPass = 'root';
$port = 3306;
// #############################################
