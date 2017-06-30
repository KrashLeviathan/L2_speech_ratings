<!DOCTYPE html>
<!--[if lte IE 6]>
<html class="preIE7 preIE8 preIE9"><![endif]-->
<!--[if IE 7]>
<html class="preIE8 preIE9"><![endif]-->
<!--[if IE 8]>
<html class="preIE9"><![endif]-->
<!--[if gte IE 9]><!-->
<html><!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>L2 Speech Ratings</title>
    <meta name="author" content="Dr Charles Nagle">
    <meta name="description"
          content="A web application for rating audio files. Supports the research of Dr. Nagle at ISU's World Languages and Cultures department.">
    <meta name="keywords"
          content="ESL, L2, non-native speaker, English as a second language, Second language, ISU, Iowa State University, World Languages and Cultures, research">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/css/reset.css" type="text/css">
    <link rel="stylesheet" href="/css/superhero/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/css/stylesheet.css" type="text/css">
    <!-- BEGIN INJECTS-->
    <?php
    if (isset($injectedHeadElements)) {
        foreach ($injectedHeadElements as $headElement) {
            print $headElement;
        }
    }
    ?>
    <!-- END INJECTS-->
    <script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="https://apis.google.com/js/client:platform.js?onload=onLoad" async defer></script>
    <script src="/js/tether.min.js" type="text/javascript" defer></script>
    <script src="/js/bootstrap.min.js" type="text/javascript" defer></script>
</head>
<body>
<script src="/js/display_alert.js" type="text/javascript"></script>
