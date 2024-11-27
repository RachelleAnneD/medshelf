<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include('db_connection.php');

// Fetch all patients from the database
$sql = "SELECT * FROM patients";
$result = $conn->query($sql);

// Handle search query for barangays
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
    $sql = "SELECT * FROM patients WHERE barangay LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
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
    <button class="dropdown-btn">Patients</button>
    <div class="dropdown-container">
        <a href="add_patient.php" class="nav-link">Add Patients</a>
    </div>
    <button class="dropdown-btn">Barangay</button>
    <div class="dropdown-container">
        <a href="barangay_list.php" class="nav-link">View Barangays</a>
    </div>
</div>

<!-- Main Content -->
<main class="content">
    <div class="form-container">
        <h3 class="text-center mb-4">View Patients</h3>

        <!-- Search Form -->
        <form action="view_patients.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search Barangay..."
                       value="<?= htmlspecialchars($searchQuery); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Mobile Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['patientid']); ?></td> <!-- Correct field for patient ID -->
                        <td><?= htmlspecialchars($row['fname']); ?></td>
                        <td><?= htmlspecialchars($row['lname']); ?></td>
                        <td><?= htmlspecialchars($row['mobile_number']); ?></td>
                        <td>
                            <!-- View button -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#viewPatientModal<?= htmlspecialchars($row['patientid']); ?>">View
                            </button>
                            <!-- Edit button -->
                            <a href="edit_patient.php?id=<?= htmlspecialchars($row['patientid']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <!-- Delete button -->
                            <a href="delete_patient.php?id=<?= htmlspecialchars($row['patientid']); ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this patient?')">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal to view patient details -->
                    <div class="modal fade" id="viewPatientModal<?= htmlspecialchars($row['patientid']); ?>" tabindex="-1"
                         aria-labelledby="viewPatientModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewPatientModalLabel">Patient Details:
                                        <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li><strong>Patient ID:</strong> <?= htmlspecialchars($row['patientid']); ?></li>
                                        <li><strong>First Name:</strong> <?= htmlspecialchars($row['fname']); ?></li>
                                        <li><strong>Last Name:</strong> <?= htmlspecialchars($row['lname']); ?></li>
                                        <li><strong>Mobile Number:</strong> <?= htmlspecialchars($row['mobile_number']); ?></li>
                                        <!-- Add additional fields as needed -->
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".dropdown-btn").forEach(function (btn) {
            btn.addEventListener("click", function () {
                const dropdownContainer = btn.nextElementSibling;
                dropdownContainer.style.display = dropdownContainer.style.display === "block" ? "none" : "block";
            });
        });
    });
</script>
</body>

</html>
