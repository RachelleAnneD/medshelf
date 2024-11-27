<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('db_connection.php');

// Handle search query for barangays
$searchQuery = '';
$sql = "SELECT * FROM barangays"; // Default query
if (isset($_GET['search'])) {
    $searchQuery = trim($_GET['search']);
    if ($searchQuery !== '') {
        $sql = "SELECT * FROM barangays WHERE barangay_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
    }
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
    <style>
        .header-bar {
            background-color: #343a40;
            color: #ffffff;
            border-bottom: 1px solid #495057;
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

        .header-logo {
            height: 40px;
            margin-right: 15px;
        }

        .header-title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .profile-links a {
            margin-left: 15px;
            font-size: 14px;
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

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
<!-- Header Bar -->
<div class="header-bar">
    <div class="header-content d-flex align-items-center">
        <img src="logo.png" alt="Medshelf Logo" class="header-logo">
        <div>
            <h1 class="header-title">Inventory Management System</h1>
            <p class="header-subtitle">San Juan, La Union Health Care</p>
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
                <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search Barangay..."
                       value="<?= htmlspecialchars($searchQuery); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if ($searchQuery !== ''): ?>
                    <a href="barangay_list.php" class="btn btn-secondary ms-2">Clear</a>
                <?php endif; ?>
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
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']); ?></td>
                        <td><?= htmlspecialchars($row['barangay_name']); ?></td>
                        <td>
                            <a href="view_barangay_patients.php?barangay_id=<?= $row['id']; ?>"
                               class="btn btn-info btn-sm">View Patients</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No barangays found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownBtns = document.querySelectorAll(".dropdown-btn");
        dropdownBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                const dropdownContainer = btn.nextElementSibling;
                dropdownContainer.style.display = dropdownContainer.style.display === "block" ? "none" : "block";
            });
        });
    });
</script>
</body>

</html>
