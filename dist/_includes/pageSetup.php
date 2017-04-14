<?php
// This file gets included before every page begins.
// It sets up basic configuration, login verification, <head>, and navbar elements
if (!$includedConfig) {
    @include 'config.php';
    $includedConfig = true;
}
@include 'checkSession.php';
@include 'html/head.php';
@include 'html/navbar.php';
