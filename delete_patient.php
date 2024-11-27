<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connection.php';

// Check if the patient ID is provided
if (!isset($_GET['id'])) {
    die('Patient ID is missing!');
}

$patientId = intval($_GET['id']);

// Delete the patient record
$sql = "DELETE FROM patients WHERE patientid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $patientId);

if ($stmt->execute()) {
    header("Location: view_barangay_patient.php?barangay_id=" . intval($_GET['barangay_id']));
    exit();
} else {
    echo "Error deleting patient: " . $conn->error;
}
?>
