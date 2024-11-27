<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Get patient ID from URL
$id = $_GET['id'];

// Fetch patient data from the database
$sql = "SELECT * FROM patients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Patient not found.";
    exit();
}

$row = $result->fetch_assoc();
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
    <div class="container mt-4">
        <h3>Edit Patient</h3>
        <form action="update_patient.php" method="POST">
            <input type="hidden" name="id" value="<?= $row['id']; ?>">

            <div class="mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?= $row['fname']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?= $row['lname']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="mname" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="mname" name="mname" value="<?= $row['mname']; ?>">
            </div>

            <div class="mb-3">
                <label for="nickname" class="form-label">Nickname</label>
                <input type="text" class="form-control" id="nickname" name="nickname" value="<?= $row['nickname']; ?>">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" required><?= $row['address']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="sex" class="form-label">Sex</label>
                <select class="form-control" id="sex" name="sex" required>
                    <option value="Male" <?= $row['sex'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?= $row['sex'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="<?= $row['mobile_number']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="civil_status" class="form-label">Civil Status</label>
                <select class="form-control" id="civil_status" name="civil_status" required>
                    <option value="Single" <?= $row['civil_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                    <option value="Married" <?= $row['civil_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                    <option value="Widowed" <?= $row['civil_status'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                    <option value="Divorced" <?= $row['civil_status'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label">Birthday</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $row['birthday']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="<?= $row['age']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="place_of_birth" class="form-label">Place of Birth</label>
                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="<?= $row['place_of_birth']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="nationality" class="form-label">Nationality</label>
                <input type="text" class="form-control" id="nationality" name="nationality" value="<?= $row['nationality']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="pwd_or_senior" class="form-label">PWD/Senior Citizen</label>
                <select class="form-control" id="pwd_or_senior" name="pwd_or_senior" required>
                    <option value="PWD" <?= $row['pwd_or_senior'] == 'PWD' ? 'selected' : ''; ?>>PWD</option>
                    <option value="Senior" <?= $row['pwd_or_senior'] == 'Senior' ? 'selected' : ''; ?>>Senior Citizen</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="pwd_senior_no" class="form-label">PWD/Senior No</label>
                <input type="text" class="form-control" id="pwd_senior_no" name="pwd_senior_no" value="<?= $row['pwd_senior_no']; ?>">
            </div>

            <div class="mb-3">
                <label for="dependent_pin_no" class="form-label">Dependent PIN No</label>
                <input type="text" class="form-control" id="dependent_pin_no" name="dependent_pin_no" value="<?= $row['dependent_pin_no']; ?>">
            </div>

            <div class="mb-3">
                <label for="member_pin_no" class="form-label">Member PIN No</label>
                <input type="text" class="form-control" id="member_pin_no" name="member_pin_no" value="<?= $row['member_pin_no']; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Update Patient</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
