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

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated values from the form
    $id = $_POST['id'];
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
    $pwd_or_senior = $_POST['pwd_or_senior'];  // Ensure this is passed properly
    $pwd_senior_no = $_POST['pwd_senior_no'];
    $dependent_pin_no = $_POST['dependent_pin_no'];
    $member_pin_no = $_POST['member_pin_no'];

    // Update the patient details in the database
    $sql = "UPDATE patients SET fname = ?, lname = ?, mname = ?, nickname = ?, address = ?, sex = ?, mobile_number = ?, civil_status = ?, birthday = ?, age = ?, place_of_birth = ?, nationality = ?, pwd_or_senior = ?, pwd_senior_no = ?, dependent_pin_no = ?, member_pin_no = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('MySQL prepare failed: ' . $conn->error);
    }

    // Binding the parameters and executing
    $stmt->bind_param("sssssssssssssissi", $fname, $lname, $mname, $nickname, $address, $sex, $mobile_number, $civil_status, $birthday, $age, $place_of_birth, $nationality, $pwd_or_senior, $pwd_senior_no, $dependent_pin_no, $member_pin_no, $id);

    if ($stmt->execute()) {
        // If the update is successful, redirect and display a success message
        $_SESSION['message'] = "Patient information updated successfully!";
        header("Location: view_patients.php?id=$id"); // Redirect to the patient's view page
        exit();
    } else {
        echo "Error updating patient details: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
