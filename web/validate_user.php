<?php

// start session if not already started
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

// connect to the database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "assessment_database";

$conn = new mysqli($host, $username, $password, $dbname);
// check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// get username and password from POST data
$email = $_POST["email"];
$password = $_POST["password"];

// prepare SQL statement to retrieve user from database
$stmt = $conn->prepare("SELECT * FROM assdt_users WHERE email_id = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// check if user exists and password is correct
if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	if (md5($password) == $row["password"]) {
		// set session variable for user
		$_SESSION["email"] = $email;
		$_SESSION["loggedin"] = true;

		echo json_encode(array("status" => "success"));
	} else {
		echo json_encode(array("status" => "error"));
	}
} else {
	echo json_encode(array("status" => "error"));
}

// close database connection
$stmt->close();
$conn->close();

?>
