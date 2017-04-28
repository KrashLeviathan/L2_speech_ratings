<?php
// Load up configuration info for connecting to the database

$this_file = str_replace('dist', '', $_SERVER['DOCUMENT_ROOT']);
//$this_file = str_replace('html/l2speechratings', '', $_SERVER['DOCUMENT_ROOT']);

$sql_file = $this_file . 'config.txt';

$json = "";
if (file_exists($sql_file)) {
    $contents = file_get_contents($sql_file);
    $json = $contents;
}
$json = json_decode($json);


/**
 * Most places that make URL references should access the domain name here
 */
$domain = 'http://l2speechratings-dev.las.iastate.edu';
$dbHost = $json->{'mysql_database'}->{'host'};
$dbName = $json->{'mysql_database'}->{'database'};
$dbUser = $json->{'mysql_database'}->{'username'};
$dbPass = $json->{'mysql_database'}->{'password'};
$port = $json->{'port'};

/**
 * API key from Google for use in user authentication. The ClientId is added to
 * the page header.
 */
$googleClientId = $json->{'googleClientId'};
if (isset($injectedHeadElements)) {
    array_push($injectedHeadElements, '<meta name="google-signin-client_id" content="' . $googleClientId . '">');
} else {
    $injectedHeadElements = array('<meta name="google-signin-client_id" content="' . $googleClientId . '">');
}

// Uncomment this section for your local database.
// #############################################
$domain = 'http://localhost:5000';
$dbHost = 'localhost';
$dbName = 'l2speechratings';
$dbUser = 'root';
$dbPass = 'root';
$port = 3306;
// #############################################
