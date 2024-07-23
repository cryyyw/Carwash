<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            max-width: 360px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-header h2 {
            margin-bottom: 20px;
            font-weight: 500;
            color: #333;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004089;
        }
        .alert {
            border-radius: 8px;
        }
        .login-footer a {
            color: #007bff;
            font-weight: 400;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }
        .form-control {
            border-radius: 8px;
            border-color: #ddd;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
        .form-group label {
            font-weight: 500;
            color: #333;
        }
    </style>
</head>
<body>
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">CleanConnect</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact us</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="login-container">
            <div class="login-header text-center">
                <h2>Login</h2>
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <div class="login-footer mt-4 text-center">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
