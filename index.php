<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carwash Booking System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .navbar-brand {
            font-size: 1.75rem;
        }

        #home {
            background: #007bff;
            color: white;
        }

        #services .card {
            transition: transform 0.2s;
        }

        #services .card:hover {
            transform: scale(1.05);
        }

        .facility-img {
            height: 200px;
            object-fit: cover;
        }

        .facility-title {
            font-size: 1.5rem;
            color: #007bff;
        }

        .facility-price {
            color: #28a745;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
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
                <?php if(isset($_SESSION['email'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <section id="home" class="text-center py-5">
        <div class="container">
            <h2 class="display-5">Welcome to CleanConnect: A Carwash Booking System in Nasugbu, Batangas</h2>
            <p class="lead">Book your car wash online hassle-free!</p>
        </div>
    </section>

    <section id="services" class="py-5">
        <div class="container">
            <h2 class="display-5 text-center">Car Wash Facilities Available</h2>
            <p class="lead text-center">Choose from a variety of car wash and detailing services:</p>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="carwash.png" class="card-img-top facility-img" alt="Facility 1">
                        <div class="card-body">
                            <h3 class="facility-title">Facility 1</h3>
                            <p class="card-text">Basic exterior wash and dry</p>
                            <p class="card-text facility-price">Starting Price:</p>
                            <a href="booking1.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="carwash.png" class="card-img-top facility-img" alt="Facility 2">
                        <div class="card-body">
                            <h3 class="facility-title">Facility 2</h3>
                            <p class="card-text">Interior and exterior wash</p>
                            <p class="card-text facility-price">Starting Price:</p>
                            <a href="booking2.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="carwash.png" class="card-img-top facility-img" alt="Facility 3">
                        <div class="card-body">
                            <h3 class="facility-title">Facility 3</h3>
                            <p class="card-text">Full wash, wax, and polish</p>
                            <p class="card-text facility-price">Starting Price:</p>
                            <a href="booking3.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="carwash.png" class="card-img-top facility-img" alt="Facility 4">
                        <div class="card-body">
                            <h3 class="facility-title">Facility 4</h3>
                            <p class="card-text">Detailing and premium wash</p>
                            <p class="card-text facility-price">Starting Price: </p>
                            <a href="booking4.php" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <footer class="bg-dark text-white py-1">
        <div class="container text-center">
            <p>&copy; 2024 Carwash Booking System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
