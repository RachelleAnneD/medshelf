<?php
// Include database connection file
include('db_connection.php');

// Get POST data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$mname = $_POST['mname'];
$nickname = $_POST['nickname'];
$address = $_POST['address'];
$sex = $_POST['sex'];
$mobile_number = $_POST['mobile_number'];
$civil_status = $_POST['civil_status'];
$birthday = $_POST['birthday'];
$age = $_POST['age'];
$place_of_birth = $_POST['place_of_birth'];
$nationality = $_POST['nationality'];

// Check if 'pwd_or_senior' is set, otherwise default to 'None'
$pwd_or_senior = isset($_POST['pwd_or_senior']) ? $_POST['pwd_or_senior'] : 'None';

// Optional fields: if not set, assign empty string
$pwd_senior_no = isset($_POST['pwd_senior_no']) ? $_POST['pwd_senior_no'] : '';
$dependent_pin_no = isset($_POST['dependent_pin_no']) ? $_POST['dependent_pin_no'] : '';
$member_pin_no = isset($_POST['member_pin_no']) ? $_POST['member_pin_no'] : '';

// Create connection
$conn = new mysqli("localhost", "root", "", "medshelf");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement with placeholders for data
$sql = "INSERT INTO patients 
            (fname, lname, mname, nickname, address, sex, mobile_number, civil_status, 
            birthday, age, place_of_birth, nationality, pwd_or_senior, pwd_senior_no, 
            dependent_pin_no, member_pin_no) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the variables to the prepared statement
$stmt->bind_param("ssssssssssssssss", 
    $fname, $lname, $mname, $nickname, $address, $sex, $mobile_number, $civil_status, 
    $birthday, $age, $place_of_birth, $nationality, $pwd_or_senior, $pwd_senior_no, 
    $dependent_pin_no, $member_pin_no);

// Execute the statement
if ($stmt->execute()) {
    header("Location: view_patients.php"); // Redirect to View Patients page after successful save
    exit();
} else {
    echo "Error saving patient: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
