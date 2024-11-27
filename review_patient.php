<?php
session_start();

// If the form was not submitted, redirect back to add_patient.php
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
$date_of_birth = $_POST['dob']; // Matches `date_of_birth` column in your database
$age = $_POST['age'];
$birthplace = $_POST['birthplace'];
$email = $_POST['email'] ?? ''; 
$mobile_number = $_POST['mobile_number'];
$sex = $_POST['sex'];
$civil_status = $_POST['civil_status'];
$nationality = $_POST['nationality'] ?? 'Filipino'; // Default to Filipino if not provided
$pwd_senior = $_POST['pwd_senior'];
$pwd_sc_no = $_POST['pwd_sc_no'] ?? null;
$member_status = $_POST['member_status'];
$member_pin_no = $_POST['member_pin'] ?? null; // Matches `member_pin_no`
$dependent_pin_no = $_POST['dependent_pin'] ?? null; // Matches `dependent_pin_no`
$consent = isset($_POST['consent']) ? 1 : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Patient Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="text-center mb-4">Review Patient Information</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>First Name</td><td><?= htmlspecialchars($fname); ?></td></tr>
                <tr><td>Middle Name</td><td><?= htmlspecialchars($mname); ?></td></tr>
                <tr><td>Last Name</td><td><?= htmlspecialchars($lname); ?></td></tr>
                <tr><td>Nickname</td><td><?= htmlspecialchars($nickname); ?></td></tr>
                <tr><td>Barangay</td><td><?= htmlspecialchars($barangay); ?></td></tr>
                <tr><td>Municipality</td><td><?= htmlspecialchars($municipality); ?></td></tr>
                <tr><td>Province</td><td><?= htmlspecialchars($province); ?></td></tr>
                <tr><td>Date of Birth</td><td><?= htmlspecialchars($date_of_birth); ?></td></tr>
                <tr><td>Age</td><td><?= htmlspecialchars($age); ?></td></tr>
                <tr><td>Birthplace</td><td><?= htmlspecialchars($birthplace); ?></td></tr>
                <tr><td>Email</td><td><?= htmlspecialchars($email); ?></td></tr>
                <tr><td>Mobile Number</td><td><?= htmlspecialchars($mobile_number); ?></td></tr>
                <tr><td>Sex</td><td><?= htmlspecialchars($sex); ?></td></tr>
                <tr><td>Civil Status</td><td><?= htmlspecialchars($civil_status); ?></td></tr>
                <tr><td>Nationality</td><td><?= htmlspecialchars($nationality); ?></td></tr>
                <tr><td>PWD/Senior</td><td><?= htmlspecialchars($pwd_senior); ?></td></tr>
                <tr><td>PWD/SC No.</td><td><?= htmlspecialchars($pwd_sc_no); ?></td></tr>
                <tr><td>Member Status</td><td><?= htmlspecialchars($member_status); ?></td></tr>
                <tr><td>Member Pin No.</td><td><?= htmlspecialchars($member_pin_no); ?></td></tr>
                <tr><td>Dependent Pin No.</td><td><?= htmlspecialchars($dependent_pin_no); ?></td></tr>
                <tr><td>Consent</td><td><?= $consent ? 'Yes' : 'No'; ?></td></tr>
            </tbody>
        </table>

        <!-- Pass data to the final save script -->
        <form action="save_patient.php" method="POST">
            <input type="hidden" name="fname" value="<?= htmlspecialchars($fname); ?>">
            <input type="hidden" name="mname" value="<?= htmlspecialchars($mname); ?>">
            <input type="hidden" name="lname" value="<?= htmlspecialchars($lname); ?>">
            <input type="hidden" name="nickname" value="<?= htmlspecialchars($nickname); ?>">
            <input type="hidden" name="barangay" value="<?= htmlspecialchars($barangay); ?>">
            <input type="hidden" name="municipality" value="<?= htmlspecialchars($municipality); ?>">
            <input type="hidden" name="province" value="<?= htmlspecialchars($province); ?>">
            <input type="hidden" name="dob" value="<?= htmlspecialchars($date_of_birth); ?>">
            <input type="hidden" name="age" value="<?= htmlspecialchars($age); ?>">
            <input type="hidden" name="birthplace" value="<?= htmlspecialchars($birthplace); ?>">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email); ?>">
            <input type="hidden" name="mobile_number" value="<?= htmlspecialchars($mobile_number); ?>">
            <input type="hidden" name="sex" value="<?= htmlspecialchars($sex); ?>">
            <input type="hidden" name="civil_status" value="<?= htmlspecialchars($civil_status); ?>">
            <input type="hidden" name="nationality" value="<?= htmlspecialchars($nationality); ?>">
            <input type="hidden" name="pwd_senior" value="<?= htmlspecialchars($pwd_senior); ?>">
            <input type="hidden" name="pwd_sc_no" value="<?= htmlspecialchars($pwd_sc_no); ?>">
            <input type="hidden" name="member_status" value="<?= htmlspecialchars($member_status); ?>">
            <input type="hidden" name="member_pin_no" value="<?= htmlspecialchars($member_pin_no); ?>">
            <input type="hidden" name="dependent_pin_no" value="<?= htmlspecialchars($dependent_pin_no); ?>">
            <input type="hidden" name="consent" value="<?= $consent; ?>">

            <button type="submit" class="btn btn-success">Confirm and Save</button>
            <a href="add_patient.php" class="btn btn-danger">Go Back</a>
        </form>
    </div>
</body>
</html>
