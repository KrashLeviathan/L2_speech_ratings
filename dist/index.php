<?php

@include '_includes/html/head.php';
echo '<body>';
@include '_includes/html/navbar.php';

// TODO: Check if user is logged in, and redirect if he is.

// If not logged in...
@include '_includes/html/login.html';
echo '</body></html>';
