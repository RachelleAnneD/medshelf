<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $barangay_id = $_POST['barangay_id'];
    $patient_id = $_POST['patient_id'];

    // Insert the patient into the barangay_patients table
    $sql = "INSERT INTO barangay_patients (barangay_id, patient_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $barangay_id, $patient_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Patient successfully added to barangay.";
    } else {
        $_SESSION['error_message'] = "Failed to add patient. Please try again.";
    }

    header("Location: view_barangay.php?barangay_id=" . $barangay_id);
    exit();
}
?>