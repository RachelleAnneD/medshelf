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

// Login logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Sanitize username input
    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists and verify password
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Start session for the user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medshelf - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        .container {
            display: flex;
            flex-direction: row;
            width: 90%;
            max-width: 1100px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
        }

        .image-section {
            flex: 1.5;
            background: url('bg.jpg') no-repeat center center;
            background-size: cover;
        }

        .form-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-header img {
            width: 80px;
            margin-bottom: 15px;
        }

        .form-header h1 {
            font-size: 28px;
            color: #ff7a00;
            font-weight: bold;
            margin: 0;
        }

        .form-header p {
            color: #6c757d;
            font-size: 18px;
            margin: 0;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: #333333;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #ff7a00;
            border: none;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            margin-top: 25px;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #ff8c33;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 122, 0, 0.3);
        }

        .form-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
            font-size: 14px;
        }

        .forgot-password a {
            color: #ff7a00;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        input[type="text"],
        input[type="password"] {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 12px;
            font-size: 16px;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .input-group-text i {
            color: #6c757d;
        }

        .input-group-text:hover i {
            color: #ff7a00;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 95%;
            }

            .image-section {
                height: 300px;
            }

            .form-section {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Left Image Section -->
        <div class="image-section"></div>

        <!-- Right Form Section -->
        <div class="form-section">
            <div class="form-header">
                <img src="logo.png" alt="Medshelf Logo">
                <h1>MEDSHELF</h1>
                <p>Inventory Management System</p>
            </div>
            <div class="form-title">WELCOME!</div>

            <!-- Display error message if exists -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                            required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                        <span class="input-group-text" id="togglePassword">
                            <i class="bi bi-eye-slash-fill" onclick="togglePasswordVisibility()"></i>
                        </span>
                    </div>
                    <div class="forgot-password">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Log In</button>
            </form>

            <div class="form-footer">
                <p>New user? <a href="register.php">Register</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('togglePassword').querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('bi-eye-slash-fill');
                passwordIcon.classList.add('bi-eye-fill');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('bi-eye-fill');
                passwordIcon.classList.add('bi-eye-slash-fill');
            }
        }
    </script>
</body>

</html>