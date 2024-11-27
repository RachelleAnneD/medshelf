<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['fname']; ?></td>
                            <td><?= $row['lname']; ?></td>
                            <td><?= $row['mobile_number']; ?></td>
                            <td>
                                <!-- View button - opens a modal to display details -->
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#viewPatientModal<?= $row['id']; ?>">View</button>
                                <!-- Edit button -->
                                <a href="edit_patient.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <!-- Delete button -->
                                <a href="delete_patient.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this patient?')">Delete</a>
                            </td>
                        </tr>

                        <!-- Modal to view patient details -->
                        <div class="modal fade" id="viewPatientModal<?= $row['id']; ?>" tabindex="-1"
                            aria-labelledby="viewPatientModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="viewPatientModalLabel">Patient Details:
                                            <?= $row['fname'] . ' ' . $row['lname']; ?>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li><strong>First Name:</strong> <?= $row['fname']; ?></li>
                                            <li><strong>Last Name:</strong> <?= $row['lname']; ?></li>
                                            <li><strong>Middle Name:</strong> <?= $row['mname']; ?></li>
                                            <li><strong>Nickname:</strong> <?= $row['nickname']; ?></li>
                                            <li><strong>Address:</strong> <?= $row['address']; ?></li>
                                            <li><strong>Sex:</strong> <?= $row['sex']; ?></li>
                                            <li><strong>Mobile Number:</strong> <?= $row['mobile_number']; ?></li>
                                            <li><strong>Civil Status:</strong> <?= $row['civil_status']; ?></li>
                                            <li><strong>Birthday:</strong> <?= $row['birthday']; ?></li>
                                            <li><strong>Age:</strong> <?= $row['age']; ?></li>
                                            <li><strong>Place of Birth:</strong> <?= $row['place_of_birth']; ?></li>
                                            <li><strong>Nationality:</strong> <?= $row['nationality']; ?></li>
                                            <li><strong>PWD/Senior:</strong> <?= $row['pwd_or_senior']; ?></li>
                                            <li><strong>PWD/Senior No:</strong> <?= $row['pwd_senior_no']; ?></li>
                                            <li><strong>Dependent PIN No:</strong> <?= $row['dependent_pin_no']; ?></li>
                                            <li><strong>Member PIN No:</strong> <?= $row['member_pin_no']; ?></li>
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
            var dropdownBtns = document.querySelectorAll(".dropdown-btn");
            dropdownBtns.forEach(function (btn) {
                btn.addEventListener("click", function () {
                    var dropdownContainer = btn.nextElementSibling;
                    dropdownContainer.style.display = dropdownContainer.style.display === "block" ? "none" : "block";
                });
            });
        });
    </script>
</body>

</html>