<?php

// start session if not already started
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// get email from POST data
$email = $_POST["email"];

// set session variable for user
$_SESSION["email"] = $email;

// echo JSON response with status "success"
echo json_encode(array("status" => "success"));

?>
