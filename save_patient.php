<?php
session_start();
include('db_connection.php');

// If the form was not submitted, redirect back
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: add_patient.php");
    exit();
}

// Capture form data
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$nickname = $_POST['nickname'];
$barangay = $_POST['barangay'];
$municipality = $_POST['municipality'];
$province = $_POST['province'];
$date_of_birth = $_POST['dob'];
$age = $_POST['age'];
$birthplace = $_POST['birthplace'];
$email = $_POST['email'];
$mobile_number = $_POST['mobile_number'];
$sex = $_POST['sex'];
$civil_status = $_POST['civil_status'];
$nationality = $_POST['nationality'];
$pwd_senior = $_POST['pwd_senior'];
$pwd_sc_no = $_POST['pwd_sc_no'];
$member_status = $_POST['member_status'];
$member_pin_no = $_POST['member_pin_no'];
$dependent_pin_no = $_POST['dependent_pin_no'];
$consent = $_POST['consent'];

// Insert data into the database
$sql = "INSERT INTO patients (fname, mname, lname, nickname, barangay, municipality, province, date_of_birth, age, birthplace, email, mobile_number, sex, civil_status, nationality, pwd_senior, pwd_sc_no, member_status, member_pin_no, dependent_pin_no, consent) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssssssssssssssb",
    $fname, $mname, $lname, $nickname, $barangay, $municipality, $province, $date_of_birth, $age, $birthplace,
    $email, $mobile_number, $sex, $civil_status, $nationality, $pwd_senior, $pwd_sc_no, $member_status,
    $member_pin_no, $dependent_pin_no, $consent
);

if ($stmt->execute()) {
    // Redirect to Add Patient page with a success message
    header("Location: add_patient.php?success=1");
    exit();
} else {
    // Redirect to Add Patient page with an error message
    header("Location: add_patient.php?error=" . urlencode($stmt->error));
    exit();
}

$stmt->close();
$conn->close();
?>
