<?php
require 'database.php';

$query = "SELECT * FROM clients ORDER BY id ASC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $clients = [];
    while($row = $result->fetch_assoc()) {
        array_push($clients, $row["client_name"]);
    }
    echo json_encode($clients);
} else {
    echo json_encode([]);
}
$conn->close();
?>
