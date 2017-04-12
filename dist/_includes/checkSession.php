<?php

$domain = 'http://localhost:5000';

// 7 day expiration
session_start([
    'cookie_lifetime' => 604800
]);
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
} else if ($_SERVER['REQUEST_URI'] !== '/' && $_SERVER['REQUEST_URI'] !== '/about') {
    // User can only visit the homepage and the about page when logged out
    session_abort();
    header('Location: ' . $domain);
    die();
}
