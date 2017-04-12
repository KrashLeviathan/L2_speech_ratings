<?php
session_start([
    'cookie_lifetime' => 10
]);
session_destroy();
unset($listener);
