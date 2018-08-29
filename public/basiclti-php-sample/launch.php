<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

require_once 'ims-blti/blti.php';
$lti = new BLTI("secret", false, false);

if ($lti->valid) {
    // Store the launch information in the session for later
    foreach($_POST as $key => $val){
        $_SESSION[$key] = $val;
    }
    die('test'.$lti->getResourceTitle());
/*
    Session::start();
    foreach (Request::all() as $key => $value) {
        Session::put($key, $value);
    }
    // Set session value
    Session::save();
*/
    header('Location: http://localhost:8000/clicker');
    exit();
} else {
    echo "This was not a valid LTI launch.\nError message: " . $lti->message;
    die('NOT valid!');
}
?>
