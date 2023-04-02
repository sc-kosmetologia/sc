<?php
require 'database.php';

$id = $_POST['id'];
$treatmentName = $_POST['treatmentName'];
$treatmentDate = $_POST['treatmentDate'];
$clientName = $_POST['clientName'];
$treatmentPrice = $_POST['treatmentPrice'];

$query = "UPDATE treatments SET treatment_name = ?, treatment_date = ?, client_name = ?, treatment_price = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssii", $treatmentName, $treatmentDate, $clientName, $treatmentPrice, $id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();