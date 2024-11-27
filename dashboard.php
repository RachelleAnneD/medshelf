<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include('db_connection.php');

// Fetch total patients
$totalPatients = 0;
$totalBarangays = 0;

// Count total patients
$patientQuery = "SELECT COUNT(*) as total FROM patients";
$patientResult = $conn->query($patientQuery);
if ($patientResult && $patientResult->num_rows > 0) {
    $patientData = $patientResult->fetch_assoc();
    $totalPatients = $patientData['total'];
}

// Count total barangays
$barangayQuery = "SELECT COUNT(*) as total FROM barangays";
$barangayResult = $conn->query($barangayQuery);
if ($barangayResult && $barangayResult->num_rows > 0) {
    $barangayData = $barangayResult->fetch_assoc();
    $totalBarangays = $barangayData['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="common-style.css">
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
        <a href="dashboard.php" class="nav-link active">Dashboard</a>
        <button class="dropdown-btn">Patients
            <span class="ms-1">&#9660;</span>
        </button>
        <div class="dropdown-container">
            <a href="add_patient.php" class="nav-link">Add Patient</a>
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
        <div class="container">
            <!-- Welcome Section -->
            <div class="form-container text-center">
                <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
                <p>Manage patients, barangays, and healthcare-related data efficiently.</p>
            </div>

            <!-- Statistics Section -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-light-orange">
                        <div class="card-body">
                            <h5 class="card-title">Total Patients</h5>
                            <p class="card-text"><?= $totalPatients; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-light-orange">
                        <div class="card-body">
                            <h5 class="card-title">Total Barangays</h5>
                            <p class="card-text"><?= $totalBarangays; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-light-orange">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activities</h5>
                            <p class="card-text">Check recent updates on patients and barangays.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Section -->
            <div class="form-container text-center">
                <a href="add_patient.php" class="btn btn-custom mx-2">Add Patient</a>
                <a href="view_patients.php" class="btn btn-custom mx-2">View Patients</a>
                <a href="barangay_list.php" class="btn btn-custom mx-2">View Barangays</a>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        // Sidebar dropdown functionality
        document.addEventListener("DOMContentLoaded", function () {
            const dropdownBtns = document.querySelectorAll(".dropdown-btn");
            dropdownBtns.forEach(function (btn) {
                btn.addEventListener("click", function () {
                    const dropdownContainer = btn.nextElementSibling;
                    dropdownContainer.style.display = dropdownContainer.style.display === "block" ? "none" : "block";
                });
            });
        });
    </script>
</body>

</html>
