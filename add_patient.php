<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php'); // Include the database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
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
    $sex = $_POST['sex'] ?? null;
    $civil_status = $_POST['civil_status'];
    $nationality = $_POST['nationality'];
    $pwd_senior = $_POST['pwd_senior'];
    $pwd_sc_no = $_POST['pwd_sc_no'];
    $member_status = $_POST['member_status'];
    $member_pin = $_POST['member_pin'];
    $dependent_pin = $_POST['dependent_pin'];
    $consent = isset($_POST['consent']) ? 1 : 0; // Checkbox

    // Insert patient data into the database
    $sql = "INSERT INTO patients (fname, mname, lname, nickname, address, barangay, municipality, province, date_of_birth, age, birthplace, email, mobile_number, sex, civil_status, nationality, pwd_senior, pwd_sc_no, member_status, member_pin_no, dependent_pin_no, consent) 
            VALUES ('$fname', '$mname', '$lname', '$nickname', '$address', '$barangay', '$municipality', '$province', '$dob', '$age', '$birthplace', '$email', '$mobile_number', '$sex', '$civil_status', '$nationality', '$pwd_senior', '$pwd_sc_no', '$member_status', '$member_pin', '$dependent_pin', '$consent')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view_patients.php"); // Redirect to view patients after successful insertion
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
    <script>
        // This function ensures that the form is submitted to review_patient.php for previewing the patient information.
        function reviewPatient() {
            document.getElementById('patientForm').submit();
        }
    </script>
</head>

<body>
    <!-- Header Bar -->
    <div class="header-bar">
        <div class="header-content d-flex align-items-center">
            <img src="logo.png" alt="Medshelf Logo">
            <div>
                <h1>Inventory Management System</h1>
                <p>San Juan, La Union Health Care</p>
            </div>
        </div>
        <div class="profile-links">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <button class="dropdown-btn">Patients
            <span class="ms-1">&#9660;</span>
        </button>
        <div class="dropdown-container">
            <a href="add_patient.php" class="nav-link">Add Patients</a>
            <a href="view_patients.php" class="nav-link">View Patients</a>
        </div>
        <button class="dropdown-btn">Barangay
            <span class="ms-1">&#9660;</span>
        </button>
        <div class="dropdown-container">
            <a href="barangay_list.php" class="nav-link">View Barangays</a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="content">
        <div class="form-container">
            <h3 class="text-center mb-4">Add Patient</h3>
            <form id="patientForm" action="review_patient.php" method="POST">
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

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="barangay" class="form-label">Barangay</label>
                            <select class="form-control" id="barangay" name="barangay" required>
                                <?php
                                    // Fetch barangay options from the database
                                    $barangay_query = "SELECT * FROM barangays";
                                    $barangay_result = mysqli_query($conn, $barangay_query);
                                    while ($barangay = mysqli_fetch_assoc($barangay_result)) {
                                        echo "<option value='" . $barangay['id'] . "'>" . $barangay['name'] . "</option>";
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
                    <select class="form-control" id="birthplace" name="birthplace" required>
                        <option value="Place 1">Place 1</option>
                        <option value="Place 2">Place 2</option>
                    </select>
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

                <button type="submit" class="btn btn-custom w-100 button-spacing">Confirm Patient</button>
                <button type="button" class="btn btn-secondary w-100 button-spacing" onclick="reviewPatient()">Review Patient Information</button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
    // Add this script to handle the dropdown toggles
    document.querySelectorAll('.dropdown-btn').forEach(button => {
        button.addEventListener('click', function () {
            const dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === 'block') {
                dropdownContent.style.display = 'none';
            } else {
                dropdownContent.style.display = 'block';
            }
        });
    });
</script>
</body>
</html>
