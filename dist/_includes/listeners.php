<?php

include '_includes/config.php';
include '_includes/database_api.php';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_errno) {
    // TODO: include server error page
    echo "Sorry, this website is experiencing problems.";

    // TODO: remove these after testing
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";

    exit;
}

// TODO
$arr = getAllListeners($mysqli);
var_dump($arr);

$mysqli->close();
