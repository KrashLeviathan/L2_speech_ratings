<?php

$domain = 'http://localhost:5000';

session_start();
if (isset($_SESSION['user_id'])) {
    $listener = array(
        'listener_id' => $_SESSION['user_id'],
        'first_name' => $_SESSION['first_name'],
        'last_name' => $_SESSION['last_name'],
        'email' => $_SESSION['email'],
        'phone' => $_SESSION['phone'],
        'university_id' => $_SESSION['university_id'],
        'user_is_admin' => $_SESSION['user_is_admin']
    );
} else {
    session_abort();
    header('Location: ' . $domain);
    die();
}
