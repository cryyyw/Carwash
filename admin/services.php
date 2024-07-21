<?php
include 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $sql = "SELECT * FROM services";
    $result = $conn->query($sql);
    $services = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }
    echo json_encode($services);
} elseif ($method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $service_name = $data->service_name;
    $price = $data->price;

    $sql = "INSERT INTO services (service_name, price) VALUES ('$service_name', '$price')";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Service added successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} elseif ($method == 'DELETE') {
    $id = $_GET['id'];
    $sql = "DELETE FROM services WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Service deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

$conn->close();
?>
