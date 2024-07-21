<?php
include 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $sql = "SELECT * FROM bookings";
    $result = $conn->query($sql);
    $bookings = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
    echo json_encode($bookings);
} elseif ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $customer_name = $data->customer_name;
    $service = $data->service;
    $date = $data->date;
    $status = $data->status;

    $sql = "INSERT INTO bookings (customer_name, service, date, status) VALUES ('$customer_name', '$service', '$date', '$status')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Booking added successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} elseif ($method == 'DELETE') {
    $id = $_GET['id'];
    $sql = "DELETE FROM bookings WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Booking deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

$conn->close();
?>
