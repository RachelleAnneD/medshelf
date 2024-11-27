<?php
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientid = intval($_POST['patientid']);
    $barangay_id = intval($_POST['barangay_id']);
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $nickname = $_POST['nickname'];
    $mobile_number = $_POST['mobile_number'];
    // Retrieve additional fields as needed

    $sql = "UPDATE patients 
            SET fname = ?, mname = ?, lname = ?, nickname = ?, mobile_number = ?
            WHERE patientid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $fname, $mname, $lname, $nickname, $mobile_number, $patientid);

    if ($stmt->execute()) {
        // Redirect back to the view_barangay_patients.php page with the barangay ID
        header("Location: view_barangay_patients.php?barangay_id=" . $barangay_id);
        exit();
    } else {
        echo "Error updating patient: " . $conn->error;
    }
}
?>
