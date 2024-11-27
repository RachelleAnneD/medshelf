<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php'); // Include the database connection

$reviewData = false;
$successMessage = '';

// Handle form submission for review
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['review'])) {
    $_SESSION['patient_data'] = $_POST;
    $reviewData = true;
}

// Handle form confirmation for saving
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
    $formData = $_SESSION['patient_data'];

    // Escape all input fields
    $fname = mysqli_real_escape_string($conn, $formData['fname']);
    $mname = mysqli_real_escape_string($conn, $formData['mname']);
    $lname = mysqli_real_escape_string($conn, $formData['lname']);
    $nickname = mysqli_real_escape_string($conn, $formData['nickname']);
    $barangay_id = mysqli_real_escape_string($conn, $formData['barangay']);
    $municipality = mysqli_real_escape_string($conn, $formData['municipality']);
    $province = mysqli_real_escape_string($conn, $formData['province']);
    $dob = mysqli_real_escape_string($conn, $formData['dob']);
    $age = mysqli_real_escape_string($conn, $formData['age']);
    $birthplace = mysqli_real_escape_string($conn, $formData['birthplace']);
    $email = mysqli_real_escape_string($conn, $formData['email']);
    $mobile_number = mysqli_real_escape_string($conn, $formData['mobile_number']);
    $sex = mysqli_real_escape_string($conn, $formData['sex']);
    $civil_status = mysqli_real_escape_string($conn, $formData['civil_status']);
    $nationality = mysqli_real_escape_string($conn, $formData['nationality']);
    $pwd_senior = mysqli_real_escape_string($conn, $formData['pwd_senior']);
    $pwd_sc_no = mysqli_real_escape_string($conn, $formData['pwd_sc_no']);
    $member_status = mysqli_real_escape_string($conn, $formData['member_status']);
    $member_pin = mysqli_real_escape_string($conn, $formData['member_pin']);
    $dependent_pin = mysqli_real_escape_string($conn, $formData['dependent_pin']);
    $consent = isset($formData['consent']) ? 'Yes' : 'No';

    // Insert data into the database
    $sql = "INSERT INTO patients (fname, mname, lname, nickname, barangay_id, municipality, province, date_of_birth, age, birthplace, email, mobile_number, sex, civil_status, nationality, pwd_senior, pwd_sc_no, member_status, member_pin_no, dependent_pin_no, consent) 
            VALUES ('$fname', '$mname', '$lname', '$nickname', '$barangay_id', '$municipality', '$province', '$dob', '$age', '$birthplace', '$email', '$mobile_number', '$sex', '$civil_status', '$nationality', '$pwd_senior', '$pwd_sc_no', '$member_status', '$member_pin', '$dependent_pin', '$consent')";

    if (mysqli_query($conn, $sql)) {
        unset($_SESSION['patient_data']);
        $successMessage = "Patient successfully added!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common-style.css">
    <style>
        /* Dashboard-Matching Header Bar */
        <style>
    .header-bar {
        background-color: #343a40; /* Dark background for better contrast */
        color: #ffffff; /* White text for visibility */
        border-bottom: 1px solid #495057; /* Subtle border */
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        padding: 10px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-content {
        display: flex;
        align-items: center;
    }

    .header-logo {
        height: 40px; /* Smaller logo height */
        margin-right: 15px;
    }

    .header-text {
        line-height: 1.2; /* Reduce text spacing */
    }

    .header-title {
        font-size: 18px; /* Smaller title */
        margin: 0;
        font-weight: bold;
    }

    .header-subtitle {
        font-size: 14px; /* Smaller subtitle */
        margin: 0;
    }

    .profile-links a {
        margin-left: 15px;
        font-size: 14px; /* Smaller links */
        color: #ffffff; /* White text */
        text-decoration: none;
        font-weight: bold;
    }

    .profile-links a:hover {
        color: #ffc107; /* Add a yellow hover effect */
        text-decoration: underline;
    }
</style>

</head>

<body>
<!-- Header Bar -->
<div class="header-bar">
    <div class="header-content d-flex align-items-center">
        <img src="logo.png" alt="Medshelf Logo" class="header-logo">
        <div class="header-text">
            <h1 class="header-title">Inventory Management System</h1>
            <p class="header-subtitle">San Juan, La Union Health Care</p>
        </div>
    </div>
    <div class="profile-links">
        <a href="profile.php" class="profile-link">Profile</a>
        <a href="logout.php" class="profile-link">Logout</a>
    </div>
</div>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <button class="dropdown-btn">Patients
            <span class="ms-1">&#9660;</span>
        </button>
        <div class="dropdown-container">
            <a href="add_patient.php" class="nav-link active">Add Patients</a>
        </div>
        <button class="dropdown-btn">Barangay</a>
            <span class="ms-1">&#9660;</span>
        </button>
        <div class="dropdown-container">
            <a href="barangay_list.php" class="nav-link">View Barangays</a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="content">
        <div class="container">
            <div class="form-container">
                <h3 class="text-center mb-4">Add Patient</h3>
                <?php if ($successMessage): ?>
                    <div class="alert alert-success text-center"><?= $successMessage; ?></div>
                <?php endif; ?>

                <!-- Patient Form -->
                <?php if ($reviewData): ?>
                    <h5 class="text-center">Review Patient Data</h5>
                    <ul>
                        <?php foreach ($_SESSION['patient_data'] as $key => $value): ?>
                            <?php if ($key !== 'review'): ?>
                                <li><strong><?= ucfirst($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <form method="POST">
                        <button type="submit" name="confirm" class="btn btn-success">Confirm</button>
                        <a href="add_patient.php" class="btn btn-secondary">Edit</a>
                    </form>
                <?php else: ?>
                    <form id="patientForm" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="fname" name="fname" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mname" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="mname" name="mname" required>
                                </div>
                            </div>
                        </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" name="lname">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nickname" class="form-label">Nickname</label>
                            <input type="text" class="form-control" id="nickname" name="nickname">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="barangay" class="form-label">Barangay</label>
                            <select class="form-control" id="barangay" name="barangay" required>
                                <option value="" disabled selected>Select Barangay</option>
                                <?php
                                    $barangay_query = "SELECT id, barangay_name FROM barangays";
                                    $barangay_result = mysqli_query($conn, $barangay_query);
                                    while ($barangay = mysqli_fetch_assoc($barangay_result)) {
                                        echo "<option value='" . $barangay['id'] . "'>" . $barangay['barangay_name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="municipality" class="form-label">Municipality</label>
                            <input type="text" class="form-control" id="municipality" name="municipality" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" class="form-control" id="province" name="province" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" required>
                </div>

                <div class="mb-3">
                    <label for="birthplace" class="form-label">Birthplace</label>
                    <input type="text" class="form-control" id="birthplace" name="birthplace" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email (Optional)</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mobile_number" class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sex" class="form-label">Sex</label>
                    <select class="form-control" id="sex" name="sex" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="civil_status" class="form-label">Civil Status</label>
                    <select class="form-control" id="civil_status" name="civil_status" required>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Deceased">Deceased</option>
                        <option value="Separated">Separated</option>
                        <option value="Child">Child</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nationality" class="form-label">Nationality</label>
                    <input type="text" class="form-control" id="nationality" name="nationality" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pwd_senior" class="form-label">PWD/Senior/None</label>
                            <select class="form-control" id="pwd_senior" name="pwd_senior" required>
                                <option value="PWD">PWD</option>
                                <option value="Senior">Senior</option>
                                <option value="None">None</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pwd_sc_no" class="form-label">PWD/SC No.</label>
                            <input type="text" class="form-control" id="pwd_sc_no" name="pwd_sc_no">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="member_status" class="form-label">Member Status</label>
                            <select class="form-control" id="member_status" name="member_status" required>
                                <option value="Dependent">Dependent</option>
                                <option value="Member">Member</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="member_pin" class="form-label">Member Pin No.</label>
                            <input type="text" class="form-control" id="member_pin" name="member_pin">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="dependent_pin" class="form-label">Dependent Pin No.</label>
                    <input type="text" class="form-control" id="dependent_pin" name="dependent_pin">
                </div>

                <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="consent" name="consent" required>
                            <label class="form-check-label" for="consent">I consent to the process of my data</label>
                        </div>
                        <button type="submit" name="review" class="btn btn-custom w-100 button-spacing">Review Patient</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <script>
        const dropdownBtns = document.querySelectorAll(".dropdown-btn");
        dropdownBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                const container = btn.nextElementSibling;
                const isOpen = container.style.display === "block";
                document.querySelectorAll(".dropdown-container").forEach(c => c.style.display = "none");
                container.style.display = isOpen ? "none" : "block";
            });
        });
    </script>
</body>

</html>