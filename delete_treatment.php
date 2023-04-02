<?php
require 'database.php';

$id = $_POST['id'];

$query = "DELETE FROM treatments WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(500);
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
