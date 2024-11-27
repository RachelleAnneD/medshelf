<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'db_connection.php';

// Fetch the patient ID from the GET request
$patientId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($patientId > 0) {
    // Retrieve patient details from the database
    $sql = "SELECT * FROM patients WHERE patientid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $patientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Patient not found.";
        header("Location: view_barangay_patient.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid patient ID.";
    header("Location: view_barangay_patient.php");
    exit();
}

// Handle form submission for updating patient details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form data
    $fname = $_POST['fname'] ?? '';
    $mname = $_POST['mname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $nickname = $_POST['nickname'] ?? '';
    $barangay_id = $_POST['barangay_id'] ?? 0;
    $municipality = $_POST['municipality'] ?? '';
    $province = $_POST['province'] ?? '';
    $date_of_birth = $_POST['date_of_birth'] ?? '';
    $age = $_POST['age'] ?? 0;
    $birthplace = $_POST['birthplace'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile_number = $_POST['mobile_number'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $pwd_senior = $_POST['pwd_senior'] ?? '';
    $pwd_sc_no = $_POST['pwd_sc_no'] ?? '';
    $member_status = $_POST['member_status'] ?? '';
    $member_pin_no = $_POST['member_pin_no'] ?? '';
    $dependent_pin_no = $_POST['dependent_pin_no'] ?? '';
    $consent = $_POST['consent'] ?? '';
    $civil_status = $_POST['civil_status'] ?? '';

    // SQL Update Statement
    $updateSql = "UPDATE patients SET 
                    fname = ?, mname = ?, lname = ?, nickname = ?, 
                    barangay_id = ?, municipality = ?, province = ?, 
                    date_of_birth = ?, age = ?, birthplace = ?, email = ?, 
                    mobile_number = ?, sex = ?, nationality = ?, 
                    pwd_senior = ?, pwd_sc_no = ?, member_status = ?, 
                    member_pin_no = ?, dependent_pin_no = ?, consent = ?, 
                    civil_status = ?
                  WHERE patientid = ?";

    $updateStmt = $conn->prepare($updateSql);

    // Bind parameters with matching data types
    $updateStmt->bind_param(
        'ssssisississssssssssi',
        $fname, $mname, $lname, $nickname, $barangay_id, $municipality, $province,
        $date_of_birth, $age, $birthplace, $email, $mobile_number, $sex,
        $nationality, $pwd_senior, $pwd_sc_no, $member_status, $member_pin_no,
        $dependent_pin_no, $consent, $civil_status, $patientId
    );

    // Execute the statement and check for errors
    if ($updateStmt->execute()) {
        $_SESSION['success_message'] = "Patient details updated successfully.";
        header("Location: view_barangay_patient.php");
        exit();
    } else {
        $error_message = "Error updating patient: " . $updateStmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Patient</h1>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="<?= htmlspecialchars($patient['fname']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="mname" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="mname" name="mname" value="<?= htmlspecialchars($patient['mname']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" value="<?= htmlspecialchars($patient['lname']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="nickname" class="form-label">Nickname</label>
                        <input type="text" class="form-control" id="nickname" name="nickname" value="<?= htmlspecialchars($patient['nickname']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="barangay_id" class="form-label">Barangay ID</label>
                        <input type="number" class="form-control" id="barangay_id" name="barangay_id" value="<?= htmlspecialchars($patient['barangay_id']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="municipality" class="form-label">Municipality</label>
                        <input type="text" class="form-control" id="municipality" name="municipality" value="<?= htmlspecialchars($patient['municipality']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="province" class="form-label">Province</label>
                        <input type="text" class="form-control" id="province" name="province" value="<?= htmlspecialchars($patient['province']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($patient['date_of_birth']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" value="<?= htmlspecialchars($patient['age']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="birthplace" class="form-label">Birthplace</label>
                        <input type="text" class="form-control" id="birthplace" name="birthplace" value="<?= htmlspecialchars($patient['birthplace']) ?>">
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($patient['email']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?= htmlspecialchars($patient['mobile_number']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="sex" class="form-label">Sex</label>
                        <select class="form-control" id="sex" name="sex">
                            <option value="Male" <?= $patient['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $patient['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nationality" class="form-label">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" value="<?= htmlspecialchars($patient['nationality']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pwd_senior" class="form-label">PWD/Senior</label>
                        <input type="text" class="form-control" id="pwd_senior" name="pwd_senior" value="<?= htmlspecialchars($patient['pwd_senior']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pwd_sc_no" class="form-label">PWD/SC No</label>
                        <input type="text" class="form-control" id="pwd_sc_no" name="pwd_sc_no" value="<?= htmlspecialchars($patient['pwd_sc_no']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="member_status" class="form-label">Member Status</label>
                        <input type="text" class="form-control" id="member_status" name="member_status" value="<?= htmlspecialchars($patient['member_status']) ?>">
                    </div>
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="consent" name="consent" value="Yes" <?= $patient['consent'] === 'Yes' ? 'checked' : '' ?>>
                <label class="form-check-label" for="consent">Consent</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
            <a href="view_barangay_patient.php" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</body>

</html>
