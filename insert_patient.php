<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once 'db_connection.php';

// Capture form data
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$nickname = $_POST['nickname'];
$address = $_POST['address'];
$barangay = $_POST['barangay']; // Note: this should match the barangay ID from the select
$municipality = $_POST['municipality'];
$province = $_POST['province'];
$dob = $_POST['dob'];
$age = $_POST['age'];
$birthplace = $_POST['birthplace'];
$email = $_POST['email'] ?? ''; // Make email optional
$mobile_number = $_POST['mobile_number'];
$sex = $_POST['sex'];
$civil_status = $_POST['civil_status'];
$nationality = 'Filipino'; // Default to Filipino
$pwd_senior = $_POST['pwd_senior'];
$pwd_sc_no = $_POST['pwd_sc_no'] ?? null;
$member_status = $_POST['member_status'];
$member_pin = $_POST['member_pin'] ?? null;
$dependent_pin = $_POST['dependent_pin'] ?? null;
$consent = isset($_POST['consent']) ? 1 : 0;

// SQL Insert Query - Exactly matching the table schema
$sql = "INSERT INTO patients (
    fname, mname, lname, nickname, address, barangay, 
    municipality, province, date_of_birth, age, 
    birthplace, email, mobile_number, sex, 
    nationality, pwd_senior, pwd_sc_no, 
    member_status, member_pin_no, dependent_pin_no, 
    consent, civil_status
) VALUES (
    ?, ?, ?, ?, ?, ?, 
    ?, ?, ?, ?, 
    ?, ?, ?, ?, 
    ?, ?, ?, 
    ?, ?, ?, 
    ?, ?
)";

try {
    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters 
    $stmt->bind_param(
        "sssssssssisssssssssssi", 
        $fname, $mname, $lname, $nickname, $address, $barangay, 
        $municipality, $province, $dob, $age, 
        $birthplace, $email, $mobile_number, $sex, 
        $nationality, $pwd_senior, $pwd_sc_no, 
        $member_status, $member_pin, $dependent_pin, 
        $consent, $civil_status
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Successful insertion
        $_SESSION['success_message'] = "Patient added successfully!";
        header("Location: view_patients.php");
        exit();
    } else {
        // Insertion failed
        $_SESSION['error_message'] = "Error adding patient: " . $stmt->error;
        header("Location: add_patient.php");
        exit();
    }
} catch (Exception $e) {
    // Catch any unexpected errors
    $_SESSION['error_message'] = "An error occurred: " . $e->getMessage();
    header("Location: add_patient.php");
    exit();
}
?>
