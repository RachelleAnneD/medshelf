<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Handle search query for barangays
$searchQuery = '';
if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
    if ($searchQuery !== '') {
        $sql = "SELECT * FROM barangays WHERE name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    } else {
        $sql = "SELECT * FROM barangays";
    }
} else {
    // Fetch all barangays from the database
    $sql = "SELECT * FROM barangays";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay List</title>
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
            <h3 class="text-center mb-4">Barangay List</h3>

            <!-- Search Form -->
            <form action="barangay_list.php" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" name="search"
                        placeholder="Search Barangay..." value="<?= htmlspecialchars($searchQuery); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Barangay Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td>
                                <a href="view_barangay.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm">View
                                    Patients</a>
                            </td>
                        </tr>
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

            var searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function () {
                if (searchInput.value === '') {
                    window.location.href = 'barangay_list.php';
                }
            });
        });
    </script>
</body>

</html>