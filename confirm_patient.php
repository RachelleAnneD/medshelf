<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Capture form data
$fname = $_POST['fname'] ?? null;
$lname = $_POST['lname'] ?? null;
$mname = $_POST['mname'] ?? null;
$nickname = $_POST['nickname'] ?? null;
$address = $_POST['address'] ?? null;
$barangay = $_POST['barangay'] ?? null;
$municipality = $_POST['municipality'] ?? null;
$province = $_POST['province'] ?? null;
$sex = $_POST['sex'] ?? null;
$mobile_number = $_POST['mobile_number'] ?? null;
$civil_status = $_POST['civil_status'] ?? null;
$birthday = $_POST['birthday'] ?? null;
$age = $_POST['age'] ?? null;
$birthplace = $_POST['birthplace'] ?? null;
$nationality = $_POST['nationality'] ?? null;
$pwd_or_senior = $_POST['pwd_or_senior'] ?? null;
$pwd_senior_no = $_POST['pwd_senior_no'] ?? null;
$dependent_pin_no = $_POST['dependent_pin_no'] ?? null;
$member_pin_no = $_POST['member_pin_no'] ?? null;
$consent = isset($_POST['consent']) ? 1 : 0;

// Check for required fields
if (!$fname || !$lname || !$address || !$barangay || !$municipality || !$province || !$sex || !$birthday || !$civil_status || !$mobile_number) {
    echo "Required fields are missing. Please go back and fill in all the necessary information.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Confirm Patient Details</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>First Name</td>
                    <td><?= htmlspecialchars($fname); ?></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><?= htmlspecialchars($lname); ?></td>
                </tr>
                <tr>
                    <td>Middle Name</td>
                    <td><?= htmlspecialchars($mname); ?></td>
                </tr>
                <tr>
                    <td>Nickname</td>
                    <td><?= htmlspecialchars($nickname); ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><?= htmlspecialchars($address); ?></td>
                </tr>
                <tr>
                    <td>Barangay</td>
                    <td><?= htmlspecialchars($barangay); ?></td>
                </tr>
                <tr>
                    <td>Municipality</td>
                    <td><?= htmlspecialchars($municipality); ?></td>
                </tr>
                <tr>
                    <td>Province</td>
                    <td><?= htmlspecialchars($province); ?></td>
                </tr>
                <tr>
                    <td>Sex</td>
                    <td><?= htmlspecialchars($sex); ?></td>
                </tr>
                <tr>
                    <td>Mobile Number</td>
                    <td><?= htmlspecialchars($mobile_number); ?></td>
                </tr>
                <tr>
                    <td>Civil Status</td>
                    <td><?= htmlspecialchars($civil_status); ?></td>
                </tr>
                <tr>
                    <td>Birthday</td>
                    <td><?= htmlspecialchars($birthday); ?></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><?= htmlspecialchars($age); ?></td>
                </tr>
                <tr>
                    <td>Birthplace</td>
                    <td><?= htmlspecialchars($birthplace); ?></td>
                </tr>
                <tr>
                    <td>Nationality</td>
                    <td><?= htmlspecialchars($nationality); ?></td>
                </tr>
                <tr>
                    <td>PWD/Senior Citizen</td>
                    <td><?= htmlspecialchars($pwd_or_senior); ?></td>
                </tr>
                <tr>
                    <td>PWD/Senior No</td>
                    <td><?= htmlspecialchars($pwd_senior_no); ?></td>
                </tr>
                <tr>
                    <td>Dependent PIN No</td>
                    <td><?= htmlspecialchars($dependent_pin_no); ?></td>
                </tr>
                <tr>
                    <td>Member PIN No</td>
                    <td><?= htmlspecialchars($member_pin_no); ?></td>
                </tr>
                <tr>
                    <td>Consent</td>
                    <td><?= $consent ? 'Yes' : 'No'; ?></td>
                </tr>
            </tbody>
        </table>
        <form action="insert_patient.php" method="POST">
            <!-- Hidden inputs to pass data to the next page -->
            <input type="hidden" name="fname" value="<?= htmlspecialchars($fname); ?>">
            <input type="hidden" name="lname" value="<?= htmlspecialchars($lname); ?>">
            <input type="hidden" name="mname" value="<?= htmlspecialchars($mname); ?>">
            <input type="hidden" name="nickname" value="<?= htmlspecialchars($nickname); ?>">
            <input type="hidden" name="address" value="<?= htmlspecialchars($address); ?>">
            <input type="hidden" name="barangay" value="<?= htmlspecialchars($barangay); ?>">
            <input type="hidden" name="municipality" value="<?= htmlspecialchars($municipality); ?>">
            <input type="hidden" name="province" value="<?= htmlspecialchars($province); ?>">
            <input type="hidden" name="sex" value="<?= htmlspecialchars($sex); ?>">
            <input type="hidden" name="mobile_number" value="<?= htmlspecialchars($mobile_number); ?>">
            <input type="hidden" name="civil_status" value="<?= htmlspecialchars($civil_status); ?>">
            <input type="hidden" name="birthday" value="<?= htmlspecialchars($birthday); ?>">
            <input type="hidden" name="age" value="<?= htmlspecialchars($age); ?>">
            <input type="hidden" name="birthplace" value="<?= htmlspecialchars($birthplace); ?>">
            <input type="hidden" name="nationality" value="<?= htmlspecialchars($nationality); ?>">
            <input type="hidden" name="pwd_or_senior" value="<?= htmlspecialchars($pwd_or_senior); ?>">
            <input type="hidden" name="pwd_senior_no" value="<?= htmlspecialchars($pwd_senior_no); ?>">
            <input type="hidden" name="dependent_pin_no" value="<?= htmlspecialchars($dependent_pin_no); ?>">
            <input type="hidden" name="member_pin_no" value="<?= htmlspecialchars($member_pin_no); ?>">
            <input type="hidden" name="consent" value="<?= $consent; ?>">

            <button type="submit" class="btn btn-success">Confirm and Add Patient</button>
            <a href="add_patient.php" class="btn btn-danger">Go Back</a>
        </form>
    </div>
</body>

</html>
