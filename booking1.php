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
    $date = $_POST['date'];
    $time = $_POST['time'];
    $user_id = $_SESSION['user_id'];

    // Check if the selected date and time is already booked
    $check_sql = "SELECT COUNT(*) AS count FROM bookings WHERE booking_date = ? AND booking_time = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $date, $time);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        echo "<script>alert('The selected time slot is already booked. Please choose a different time.'); window.history.back();</script>";
    } else {
        $sql = "INSERT INTO bookings (user_id, vehicle_type, wash_package, add_ons, booking_date, booking_time) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $user_id, $vehicle_type, $wash_package, $add_ons, $date, $time);

        if ($stmt->execute()) {
            header("Location: booking1.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
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
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
    <h2>Carwash 1</h2>
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
                <input type="hidden" name="date" id="date_input">
                <input type="hidden" name="time" id="time_input">
                <p><strong>Vehicle Type:</strong> <span id="selectedVehicle"></span></p>
                <p><strong>Wash Package:</strong> <span id="selectedPackage"></span></p>
                <p><strong>Wash Add-ons:</strong> <span id="selectedAddOns"></span></p>
                <div class="form-group">
                    <label for="date_picker">Select Date:</label>
                    <input type="text" class="form-control" id="date_picker" name="date" required>
                </div>
                <div class="form-group">
                    <label for="time_picker">Select Time:</label>
                    <input type="time" class="form-control" id="time_picker" name="time" step="1800" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="showConfirmationModal()" disabled>Confirm Booking</button>
            </form>
        </div>

        <!-- Booking Complete -->
        <div class="card mb-4" id="booking-complete">
            <div class="step">
                <div class="number">5/5</div>
                <h2>Booking Complete</h2>
            </div>
            <p>Your booking has been completed. Thank you!</p>
            <p id="bookingDetails"></p>
        </div>

        <button class="btn btn-primary" onclick="locateCarwash()">Locate Nearby Carwash</button>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- jQuery UI JS -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
                    <p>Thank you for choosing carwash 1. Would you like to confirm the booking?</p>
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

            ConfirmButton();
        }

        function selectPackage(element) {
            document.querySelectorAll('#wash-packages .option').forEach(div => div.classList.remove('selected'));
            element.classList.add('selected');
            selectedPackage = element.querySelector('h3').textContent.trim();
            document.getElementById('selectedPackage').textContent = selectedPackage;
            document.getElementById('wash_package_input').value = selectedPackage;

            ConfirmButton();
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

            ConfirmButton();
        }

        function ConfirmButton() {
            const isVehicleSelected = selectedVehicle !== '';
            const isPackageSelected = selectedPackage !== '';
            const isDateSelected = document.getElementById('date_picker').value !== '';
            const isTimeSelected = document.getElementById('time_picker').value !== '';

            const confirmButton = document.querySelector('#confirmation .btn-primary');
            if (isVehicleSelected && isPackageSelected && isDateSelected && isTimeSelected) {
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

        $(document).ready(function() {
            $("#date_picker").datepicker({
                minDate: 0,
                dateFormat: 'yy-mm-dd',
                onSelect: function() {
                    ConfirmButton();
                }
            });

            $("#time_picker").on("input", function() {
                ConfirmButton();
                adjustTimePicker(this);
            });
        });

        function adjustTimePicker(input) {
            const [hour, minute] = input.value.split(':').map(Number);
            if (minute !== 0 && minute !== 30) {
                if (minute < 15) {
                    input.value = `${hour.toString().padStart(2, '0')}:00`;
                } else if (minute < 45) {
                    input.value = `${hour.toString().padStart(2, '0')}:30`;
                } else {
                    input.value = `${(hour + 1).toString().padStart(2, '0')}:00`;
                }
            }
        }
    </script>
</body>
</html>
