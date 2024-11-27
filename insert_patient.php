<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connection.php';

// Capture form data
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$nickname = $_POST['nickname'];
$address = $_POST['address'];
$barangay = $_POST['barangay'];
$municipality = $_POST['municipality'];
$province = $_POST['province'];
$dob = $_POST['dob'];
$age = $_POST['age'];
$birthplace = $_POST['birthplace'];
$email = $_POST['email'];
$mobile_number = $_POST['mobile_number'];
$sex = $_POST['sex'];
$civil_status = $_POST['civil_status'];
$nationality = $_POST['nationality'];
$pwd_senior = $_POST['pwd_senior'] ?? '';
$pwd_sc_no = $_POST['pwd_sc_no'] ?? '';
$member_status = $_POST['member_status'] ?? '';
$member_pin = $_POST['member_pin'] ?? '';
$dependent_pin = $_POST['dependent_pin'] ?? '';
$consent = $_POST['consent'] ?? '';

// Prepare the SQL query
$sql = "INSERT INTO `patients` (
    `fname`, `mname`, `lname`, `nickname`, `address`, `barangay`, `municipality`, 
    `province`, `date_of_birth`, `age`, `birthplace`, `email`, `mobile_number`, 
    `sex`, `nationality`, `pwd_senior`, `pwd_sc_no`, `member_status`, 
    `member_pin_no`, `dependent_pin_no`, `consent`, `civil_status`
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters
$stmt->bind_param(
    "sssssssssssssssssi", 
    $fname, $mname, $lname, $nickname, $address, $barangay, $municipality, 
    $province, $dob, $age, $birthplace, $email, $mobile_number, 
    $sex, $nationality, $pwd_senior, $pwd_sc_no, $member_status, 
    $member_pin, $dependent_pin, $consent, $civil_status
);

// Execute the query
if ($stmt->execute()) {
    // Successfully inserted
    echo "<div class='alert alert-success'>Patient added successfully!</div>";
    header("Location: view_patients.php"); // Redirect to view the list of patients
} else {
    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
}

$stmt->close();
$conn->close();
?>
