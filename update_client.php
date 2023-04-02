<?php
require 'database.php';

$id = $_POST['id'];
$birthDate = $_POST['birthDate'];
$phoneNumber = $_POST['phoneNumber'];
$location = $_POST['location'];
$additionalInfo = $_POST['additionalInfo'];

$query = "UPDATE clients SET birth_date = ?, phone_number = ?, location = ?, additional_info = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $birthDate, $phoneNumber, $location, $additionalInfo, $id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
