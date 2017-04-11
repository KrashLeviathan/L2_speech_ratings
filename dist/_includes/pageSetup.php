<?php
// This file gets included before every page begins.
// It sets up basic configuration, login verification, <head>, and navbar elements
@include 'config.php';
@include 'checkSession.php';
@include 'html/head.php';
@include 'html/navbar.php';
