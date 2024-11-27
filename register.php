<?php
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "medshelf");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $center_name = trim($_POST['center_name']);
    $location = trim($_POST['location']);

    // Basic form validation
    if (empty($fullname) || empty($email) || empty($password) || empty($password_confirm) || empty($center_name) || empty($location)) {
        $message = "All fields are required.";
    } elseif ($password !== $password_confirm) {
        $message = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long.";
    } else {
        // Sanitize email input
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        // Check if the email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Email is already registered.";
        } else {
            // Hash the password before saving it
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, center_name, location) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $email, $password_hashed, $center_name, $location);

            if ($stmt->execute()) {
                $message = "Account created successfully!";
            } else {
                $message = "Error: Could not create account. Please try again.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .header-bar {
            background-color: #ff7a00;
            color: #ffffff;
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }

        .header-bar img {
            width: 50px;
            margin-right: 15px;
        }

        .header-bar h1 {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .header-bar p {
            margin: 0;
            font-size: 14px;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 40px auto;
        }

        .form-title {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
            color: #333333;
        }

        .btn-register {
            background-color: #ff7a00;
            border: none;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            transition: all 0.3s ease;
            border-radius: 5px;
        }

        .btn-register:hover {
            background-color: #ff8c33;
        }

        .form-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
        }

        .form-footer a {
            color: #ff7a00;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Header Bar -->
    <div class="header-bar">
        <img src="logo.png" alt="Medshelf Logo">
        <div>
            <h1>Inventory Management System</h1>
            <p>San Juan, La Union Health Care</p>
        </div>
    </div>

    <div class="container">
        <div class="form-title">Register</div>

        <!-- Display message -->
        <?php if (isset($message)): ?>
            <div class="alert <?= strpos($message, 'Error') !== false ? 'alert-danger' : 'alert-info' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form action="register.php" method="POST">
            <div class="row">
                <!-- Account Section -->
                <div class="col-md-6">
                    <h4 class="mb-3"><strong>ACCOUNT</strong></h4>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                            placeholder="Confirm Password" required>
                    </div>
                </div>

                <!-- Center Details Section -->
                <div class="col-md-6">
                    <h4 class="mb-3"><strong>CENTER DETAILS</strong></h4>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="center_name" name="center_name"
                            placeholder="Center Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="location" name="location" placeholder="Location"
                            required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-register w-100">Register</button>
        </form>

        <div class="form-footer mt-4">
            Already have an account? <a href="login.php">Log in here</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>