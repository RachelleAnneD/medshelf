<?php
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "medshelf"; // your database name

// Enable detailed error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error message
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to UTF-8 to support international characters
$conn->set_charset("utf8mb4");

?>
