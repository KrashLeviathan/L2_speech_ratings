<?php

// Login derived from http://phpclicks.com/php-token-based-authentication/

require_once('../../vendor/autoload.php');
use \Firebase\JWT\JWT;

include "config.php";

// Connect to the mysql database
$link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
mysqli_set_charset($link, 'utf8');

// secret key can be a random string and keep in secret from anyone
define('SECRET_KEY', 'Your-Secret-Key');
// Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
define('ALGORITHM', 'HS512');

$username = preg_replace('/[^a-z0-9_]+/i', '', $_POST['username']);
// TODO: Fixme
$password = $_POST['password'];
$action = $_REQUEST['action'];
if ($username && $password && $action == 'login') {

    // Fetch matching username from database
    $statement = "SELECT * FROM login WHERE UserName = '" . $username . "'";
    $result = mysqli_query($link, $statement);

    // Die if SQL statement failed
    if (!$result) {
        http_response_code(404);
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
//        include("_includes/notFound.php");
        mysqli_close($link);
        die();
    }

    // Get matching rows
    for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row[$i] = mysqli_fetch_object($result);
    }
    mysqli_free_result($result);

    $hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
    if (count($row) > 0 && password_verify($row[0]->Password, $hashAndSalt)) {
//        $tokenId = base64_encode(mcrypt_create_iv(32));
        $issuedAt = time();
        $notBefore = $issuedAt + 10;  //Adding 10 seconds
        $expire = $notBefore + 7200; // Adding 60 seconds
        $serverName = 'http://localhost/php-json/'; /// TODO: set your domain name

        //Create the token as an array
        $data = [
            'iat' => $issuedAt,         // Issued at: time when the token was generated
//            'jti' => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss' => $serverName,       // Issuer
            'nbf' => $notBefore,        // Not before
            'exp' => $expire,           // Expire
            'data' => [                 // Data related to the logged user you can set your required data
                'id' => $row[0]->UserId, // id from the users table
                'name' => $row[0]->UserName, //  name
            ]
        ];
        $secretKey = base64_decode(SECRET_KEY);

        // Here we will transform this array into JWT:
        $jwt = JWT::encode(
            $data,   // Data to be encoded in the JWT
            $secretKey, // The signing key
            ALGORITHM
        );

        $unencodedArray = ['jwt' => $jwt];
        echo '{"status":"success", "resp":' . json_encode($unencodedArray) . '}';
    } else {
        echo '{"status":"error", "msg":"Invalid email or password"}';
    }
}

/*
 * decode the jwt using the key from config
 */
if ($action == 'authenticate') {
    try {
        $secretKey = base64_decode(SECRET_KEY);
        $DecodedDataArray = JWT::decode($_REQUEST['tokVal'], $secretKey, array(ALGORITHM));

        echo '{"status":"success" ,"data":' . json_encode($DecodedDataArray) . '}';

    } catch (Exception $e) {
        echo '{"status":"fail" ,"msg":"Unauthorized"}';
    }
}

mysqli_close($link);
