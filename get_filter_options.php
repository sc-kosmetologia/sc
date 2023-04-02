<?php
require 'database.php';

$query_clients = "SELECT DISTINCT client_name FROM treatments ORDER BY client_name";
$result_clients = $conn->query($query_clients);

$clients = [];
$treatments = [];

while ($row = $result_clients->fetch_assoc()) {
    $clients[] = $row['client_name'];
}

$query_treatments = "SELECT DISTINCT treatment_name FROM treatments ORDER BY treatment_name";
$result_treatments = $conn->query($query_treatments);

while ($row = $result_treatments->fetch_assoc()) {
    $treatments[] = $row['treatment_name'];
}

$output = [
    "clients" => $clients,
    "treatments" => $treatments,
];

echo json_encode($output);

$conn->close();
