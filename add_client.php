<?php
require 'database.php';

$clientName = $_POST['clientName'];
$birthDate = $_POST['birthDate'];
$phoneNumber = $_POST['phoneNumber'];
$location = $_POST['location'];
$additionalInfo = $_POST['additionalInfo'];

$query = "INSERT INTO clients (client_name, birth_date, phone_number, location, additional_info) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssss", $clientName, $birthDate, $phoneNumber, $location, $additionalInfo);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
