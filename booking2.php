<?php
session_start();
include('db.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicle_type = $_POST['vehicle_type'];
    $wash_package = $_POST['wash_package'];
    $add_ons = implode(", ", $_POST['add_ons']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO bookings (user_id, vehicle_type, wash_package, add_ons) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $vehicle_type, $wash_package, $add_ons);

    if ($stmt->execute()) {
        header("Location: booking2.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Wash Booking</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="booking.css">
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
                    <a class="nav-link" href="#vehicle-type">Vehicle Type</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#wash-packages">Wash Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#add-ons">Add-on Options</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#confirmation">Confirmation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#booking-complete">Booking Complete</a>
                </li>
                <?php if (isset($_SESSION['email'])): ?>
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
    <h2>Carwash 2</h2>
    <div class="container mt-4">
        <!-- Vehicle Type -->
        <div class="card mb-4" id="vehicle-type">
            <div class="step">
                <div class="number">1/5</div>
                <h2>Select Vehicle Type</h2>
            </div>
            <div class="grid">
                <div class="option" onclick="selectVehicle(this)">Regular Size Car</div>
                <div class="option" onclick="selectVehicle(this)">Medium Size Car</div>
                <div class="option" onclick="selectVehicle(this)">Compact SUV</div>
                <div class="option" onclick="selectVehicle(this)">Minivan</div>
                <div class="option" onclick="selectVehicle(this)">Pickup Truck</div>
                <div class="option" onclick="selectVehicle(this)">Motorcycle</div>
            </div>
        </div>

        <!-- Wash Packages -->
        <div class="card mb-4" id="wash-packages">
            <div class="step">
                <div class="number">2/5</div>
                <h2>Select Wash Package</h2>
            </div>
            <div class="grid">
                <div class="option" onclick="selectPackage(this)">
                    <h3>Basic Wash</h3>
                    <p>₱</p>
                </div>
                <div class="option" onclick="selectPackage(this)">
                    <h3>Premium Wash</h3>
                    <p>₱</p>
                </div>
                <div class="option" onclick="selectPackage(this)">
                    <h3>Wash + Detailing</h3>
                    <p>₱</p>
                </div>
                <div class="option" onclick="selectPackage(this)">
                    <h3>Underwash</h3>
                    <p>₱</p>
                </div>
            </div>
        </div>

        <!-- Add-on Options -->
        <div class="card mb-4" id="add-ons">
            <div class="step">
                <div class="number">3/5</div>
                <h2>Add-on options</h2>
            </div>
            <p>Select additional options for your wash package.</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="option">
                        <td>Exterior Hand Wash</td>
                        <td>₱</td>
                        <td><button class="btn btn-primary" onclick="selectAddOn(this)">Add</button></td>
                    </tr>
                    <tr>
                        <td>Towel Hand Dry</td>
                        <td>₱</td>
                        <td><button class="btn btn-primary" onclick="selectAddOn(this)">Add</button></td>
                    </tr>
                    <tr>
                        <td>Wheel Shine</td>
                        <td>₱</td>
                        <td><button class="btn btn-primary" onclick="selectAddOn(this)">Add</button></td>
                    </tr>
                    <tr>
                        <td>Tire Dressing</td>
                        <td>₱</td>
                        <td><button class="btn btn-primary" onclick="selectAddOn(this)">Add</button></td>
                    </tr>
                    <tr>
                        <td>Windows In & Out</td>
                        <td>₱</td>
                        <td><button class="btn btn-primary" onclick="selectAddOn(this)">Add</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Confirmation -->
        <div class="card mb-4" id="confirmation">
            <div class="step">
                <div class="number">4/5</div>
                <h2>Confirmation</h2>
            </div>
            <p>Confirm your selection.</p>
            <form id="bookingForm" method="POST" action="">
                <input type="hidden" name="vehicle_type" id="vehicle_type_input">
                <input type="hidden" name="wash_package" id="wash_package_input">
                <input type="hidden" name="add_ons[]" id="add_ons_input">
                <p><strong>Vehicle Type:</strong> <span id="selectedVehicle"></span></p>
                <p><strong>Wash Package:</strong> <span id="selectedPackage"></span></p>
                <p><strong>Wash Add-ons:</strong> <span id="selectedAddOns"></span></p>
                <button type="button" class="btn btn-primary" onclick="showConfirmationModal()">Confirm and Book</button>
            </form>
        </div>

        <!-- Booking Complete -->
        <div class="card mb-4" id="booking-complete">
            <div class="step">
                <div class="number">5/5</div>
                <h2>Booking Complete</h2>
            </div>
            <p>Thank you for choosing CleanConnect carwash.</p>
            <div>
                <button class="btn btn-primary" onclick="locateCarwash()">Locate Carwash</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Modal HTML -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Booking Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Thank you for your booking. Your car wash appointment has been confirmed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirmBooking()">Confirm Booking</button>
                </div>
            </div>
        </div>
    </div>

  <script>
let selectedVehicle = '';
let selectedPackage = '';
let selectedAddOns = [];

function selectVehicle(element) {
    document.querySelectorAll('#vehicle-type .option').forEach(div => div.classList.remove('selected'));
    element.classList.add('selected');
    selectedVehicle = element.textContent.trim();
    document.getElementById('selectedVehicle').textContent = selectedVehicle;
    document.getElementById('vehicle_type_input').value = selectedVehicle;

    // Enable the confirm button if all selections are made
    updateConfirmButton();
}

function selectPackage(element) {
    document.querySelectorAll('#wash-packages .option').forEach(div => div.classList.remove('selected'));
    element.classList.add('selected');
    selectedPackage = element.querySelector('h3').textContent.trim();
    document.getElementById('selectedPackage').textContent = selectedPackage;
    document.getElementById('wash_package_input').value = selectedPackage;

    // Enable the confirm button if all selections are made
    updateConfirmButton();
}

function selectAddOn(element) {
    const service = element.closest('tr').querySelector('td:first-child').textContent.trim();
    const index = selectedAddOns.indexOf(service);

    if (index === -1) {
        selectedAddOns.push(service);
        element.classList.add('selected');
        element.textContent = 'Remove';
    } else {
        selectedAddOns.splice(index, 1);
        element.classList.remove('selected');
        element.textContent = 'Add';
    }

    document.getElementById('selectedAddOns').textContent = selectedAddOns.join(', ');
    document.getElementById('add_ons_input').value = selectedAddOns.join(',');

    // Enable the confirm button if all selections are made
    updateConfirmButton();
}

function updateConfirmButton() {
    const isVehicleSelected = selectedVehicle !== '';
    const isPackageSelected = selectedPackage !== '';

    const confirmButton = document.querySelector('#confirmation .btn-primary');
    if (isVehicleSelected && isPackageSelected) {
        confirmButton.disabled = false;
    } else {
        confirmButton.disabled = true;
    }
}

function showConfirmationModal() {
    if (document.querySelector('#confirmation .btn-primary').disabled) {
        alert('Please complete all selections before proceeding.');
        return;
    }
    $('#confirmationModal').modal('show');
}

function confirmBooking() {
    document.getElementById('bookingForm').submit();
}

function locateCarwash() {
    window.location.href = 'locate_carwash.php';
}
</script>

</body>
</html>
