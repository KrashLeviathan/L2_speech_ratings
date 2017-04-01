<?php

?>

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
    <title>title</title>
    <meta name="author" content="name">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <!--    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">-->
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/stylesheet.css" type="text/css">
</head>
<body>

<form id="formLogin">
    <header>Login</header>
    <label for="username">Username <span>*</span></label>
    <input name="username" id="username" required autofocus/>
    <div class="help">At least 6 character</div>
    <label for="password">Password <span>*</span></label>
    <input name="password" id="password" type="password" required/>
    <div class="help">Use upper and lowercase lettes as well</div>
    <button type="submit">Login</button>
</form>

<script src="js/__ajax.googleapis.com_ajax_libs_jquery_1.7.2_jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    function autorun() {
        /// here is our login form that we are using to post username and password information.
        $("#formLogin").submit(function (e) {
            e.preventDefault();
            $.post('login.php?action=login', $("#formLogin").serialize(), function (data) {
                var parsedData = JSON.parse(data);
                // you can set returned token in cookie or session and
                // can send with each request to authenticate user
                document.cookie = "tokenVal=" + parsedData['resp']['jwt'];
                window.location.reload(true);
            });

        });

        // get your-token-value where you have set it in session, cookie, or somewhere and
        // send with each request that you want to authenticate.
        var tokVal = document.cookie.replace(/(?:(?:^|.*;\s*)tokenVal\s*\=\s*([^;]*).*$)|^.*$/, "$1");
        $.post('login.php?action=authenticate&tokVal=' + tokVal, function (resp) {
            //alert(resp);
            if (resp.status == "success") {
                /// if token authenticated successfully
                //// get your data
                console.log("SUCESS");
                console.log(resp);
            } else {
                /// if token authentication failed
                console.log("FAILED");
                console.log(resp);
            }
        }, 'json');
    }
    if (document.addEventListener) document.addEventListener("DOMContentLoaded", autorun, false);
    else if (document.attachEvent) document.attachEvent("onreadystatechange", autorun);
    else window.onload = autorun;
</script>
</body>
</html>
