<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
require_once 'db_connection.php';

// Fetch patient details
$patientId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($patientId > 0) {
    $sql = "SELECT * FROM patients WHERE patientid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $patientId);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
} else {
    $_SESSION['error_message'] = "Invalid patient ID.";
    header("Location: view_patients.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common-style.css">
    <style>
        
        .header-bar {
            background-color: #343a40;
            color: #ffffff;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-logo {
            height: 40px;
            margin-right: 15px;
        }

        .header-title {
            font-size: 18px;
            font-weight: bold;
        }

        .profile-links a {
            margin-left: 15px;
            color: #ffffff;
            text-decoration: none;
        }

        .profile-links a:hover {
            color: #ffc107;
        }

        .sidebar {
            width: 200px;
            background-color: #f8f9fa;
            position: fixed;
            top: 60px;
            height: 100vh;
            overflow-y: auto;
            padding-top: 10px;
        }

        .content {
            margin-left: 220px;
            margin-top: 70px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header-bar">
        <div class="header-content d-flex align-items-center">
            <img src="logo.png" alt="Medshelf Logo" class="header-logo">
            <h1 class="header-title">Inventory Management System</h1>
        </div>
        <div class="profile-links">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="view_patients.php" class="nav-link">Back to Patients</a>
    </div>

    <!-- Content -->
    <main class="content">
        <h3>Patient Details</h3>
        <?php if (!empty($patient)): ?>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td><?= htmlspecialchars($patient['fname']); ?></td>
                    </tr>
                    <tr>
                        <th>Middle Name</th>
                        <td><?= htmlspecialchars($patient['mname']); ?></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><?= htmlspecialchars($patient['lname']); ?></td>
                    </tr>
                    <tr>
                        <th>Nickname</th>
                        <td><?= htmlspecialchars($patient['nickname']); ?></td>
                    </tr>
                    <tr>
                        <th>Barangay</th>
                        <td><?= htmlspecialchars($patient['barangay']); ?></td>
                    </tr>
                    <tr>
                        <th>Municipality</th>
                        <td><?= htmlspecialchars($patient['municipality']); ?></td>
                    </tr>
                    <tr>
                        <th>Province</th>
                        <td><?= htmlspecialchars($patient['province']); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?= htmlspecialchars($patient['date_of_birth']); ?></td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td><?= htmlspecialchars($patient['age']); ?></td>
                    </tr>
                    <tr>
                        <th>Birthplace</th>
                        <td><?= htmlspecialchars($patient['birthplace']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= htmlspecialchars($patient['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td><?= htmlspecialchars($patient['mobile_number']); ?></td>
                    </tr>
                    <tr>
                        <th>Sex</th>
                        <td><?= htmlspecialchars($patient['sex']); ?></td>
                    </tr>
                    <tr>
                        <th>Civil Status</th>
                        <td><?= htmlspecialchars($patient['civil_status']); ?></td>
                    </tr>
                    <tr>
                        <th>Nationality</th>
                        <td><?= htmlspecialchars($patient['nationality']); ?></td>
                    </tr>
                    <tr>
                        <th>PWD/Senior</th>
                        <td><?= htmlspecialchars($patient['pwd_senior']); ?></td>
                    </tr>
                    <tr>
                        <th>PWD/SC No</th>
                        <td><?= htmlspecialchars($patient['pwd_sc_no']); ?></td>
                    </tr>
                    <tr>
                        <th>Member Status</th>
                        <td><?= htmlspecialchars($patient['member_status']); ?></td>
                    </tr>
                    <tr>
                        <th>Member Pin</th>
                        <td><?= htmlspecialchars($patient['member_pin_no']); ?></td>
                    </tr>
                    <tr>
                        <th>Dependent Pin</th>
                        <td><?= htmlspecialchars($patient['dependent_pin_no']); ?></td>
                    </tr>
                    <tr>
                        <th>Consent</th>
                        <td><?= htmlspecialchars($patient['consent']); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-danger">No patient details found.</p>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>
