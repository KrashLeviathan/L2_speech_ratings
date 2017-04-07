<?php
/**
 * Created by PhpStorm.
 * User: nkarasch
 * Date: 4/6/17
 * Time: 10:41 PM
 */

function onSqlFail($mysqli, $sql)
{
    // TODO: Include server error page (handle gracefully)
    echo "Sorry, this website is experiencing problems.";

    // TODO: Remove after testing
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}

function getListener(mysqli $mysqli, $listener_id)
{
    $sql = "SELECT * FROM Listeners WHERE listener_id = $listener_id";
    if (!$result = $mysqli->query($sql)) {
        onSqlFail($mysqli, $sql);
    }
    $listener = $result->fetch_assoc();
    mysqli_free_result($result);
    return $listener;
}

function getAllListeners(mysqli $mysqli)
{
    $sql = "SELECT * FROM Listeners";
    if (!$result = $mysqli->query($sql)) {
        onSqlFail($mysqli, $sql);
    }
    $arr = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $arr;
}
