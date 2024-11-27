<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "medshelf");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all patients from the database
$sql = "SELECT * FROM patients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar a:hover {
            color: white;
        }

        .sidebar .active {
            color: white;
            font-weight: bold;
        }

        .content {
            padding: 20px;
            margin-left: 250px;
        }

        .navbar-brand {
            color: #f8f9fa !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar d-flex flex-column p-3">
                <h4 class="text-center py-3">Medshelf</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_patient.php">Add Patient</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="patients.php">View Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 content">
                <h3>Patient List</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Sex</th>
                            <th>Age</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['fname']; ?></td>
                                <td><?php echo $row['lname']; ?></td>
                                <td><?php echo $row['sex']; ?></td>
                                <td><?php echo $row['age']; ?></td>
                                <td>
                                    <a href="view_patient.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                                    <a href="edit_patient.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                    <a href="delete_patient.php?id=<?php echo $row['id']; ?>"
                                        class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>