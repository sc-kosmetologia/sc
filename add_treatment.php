<?php
require 'database.php';

$treatmentName = $_POST['treatmentName'];
$treatmentDate = $_POST['treatmentDate'];
$clientName = $_POST['clientName'];
$treatmentPrice = $_POST['treatmentPrice'];
$detailedDescription = $_POST['detailedDescription'];

$query = "INSERT INTO treatments (treatment_name, treatment_date, client_name, treatment_price, detailed_description) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssds", $treatmentName, $treatmentDate, $clientName, $treatmentPrice, $detailedDescription);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();