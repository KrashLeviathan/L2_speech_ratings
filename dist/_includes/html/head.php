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
    <?php
    if (isset($injectedStylesheets)) {
        foreach ($injectedStylesheets as $stylesheet) {
            print '<link rel="stylesheet" href="' . $stylesheet . '" type="text/css">';
        }
    }
    ?>
</head>
