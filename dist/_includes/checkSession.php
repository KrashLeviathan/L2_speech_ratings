<?php

if (!$includedConfig) {
    @include 'config.php';
    $includedConfig = true;
}

// 7 day expiration
session_start([
    'cookie_lifetime' => 604800
]);
if (isset($_SESSION['user_id'])) {
    $user = array(
        'user_id' => $_SESSION['user_id'],
        'first_name' => $_SESSION['first_name'],
        'last_name' => $_SESSION['last_name'],
        'email' => $_SESSION['email'],
        'phone' => $_SESSION['phone'],
        'user_is_admin' => $_SESSION['user_is_admin'],
        'consent' => $_SESSION['consent']
    );

    // NOTE: For admin-only pages, make sure to set $adminOnlyPage = true.
    if ($_SERVER['REQUEST_URI'] === '/' || (!$user['user_is_admin']) && $adminOnlyPage) {
        // If a user is signed in and tried to go back to the home page,
        // OR if a non-admin user is trying to access a restricted page,
        // redirect them to the about page. $domain is loaded
        // from the config file.
        header('Location: ' . $domain . '/about');
        die();
    }
} else if ($_SERVER['REQUEST_URI'] !== '/' && $_SERVER['REQUEST_URI'] !== '/about') {
    // User can only visit the homepage and the about page when logged out
    session_abort();
    header('Location: ' . $domain);
    die();
}
