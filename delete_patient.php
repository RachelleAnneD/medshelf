<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "medshelf");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM patients WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Patient deleted successfully!";
        header("Location: view_patients.php"); // Redirect back to the list
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
