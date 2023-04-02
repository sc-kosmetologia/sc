<?php
require 'database.php';

$query = "SELECT * FROM clients ORDER BY id ASC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $client_id = $row['id'];
        $client_name = $row['client_name'];
        $birth_date = $row['birth_date'];
        $age = $row['age'];
        $phone_number = $row['phone_number'];
        $location = $row['location'];
        $additional_info = $row['additional_info'];

        echo "<tr>
                <td>$client_name</td>
                <td>$birth_date</td>
                <td>$age</td>
                <td>$phone_number</td>
                <td>$location</td>
                <td>$additional_info</td>
                <td>
                    <button class='edit' data-id='$client_id'>Edytuj</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7'>Brak klientów w bazie danych.</td></tr>";
}

$conn->close();
?>
