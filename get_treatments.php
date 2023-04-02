<?php
require 'database.php';

$sortBy = $_POST['sortBy'] ?? 'treatment_date';
$filterClient = $_POST['filterClient'] ?? '';
$filterTreatment = $_POST['filterTreatment'] ?? '';
$filterDateStart = $_POST['filterDateStart'] ?? '';
$filterDateEnd = $_POST['filterDateEnd'] ?? '';

$filterClientQuery = $filterClient ? "AND client_name = '$filterClient'" : "";
$filterTreatmentQuery = $filterTreatment ? "AND treatment_name = '$filterTreatment'" : "";
$filterDateQuery = "";
if ($filterDateStart && $filterDateEnd) {
    $filterDateQuery = "AND treatment_date BETWEEN '$filterDateStart' AND '$filterDateEnd'";
} elseif ($filterDateStart) {
    $filterDateQuery = "AND treatment_date >= '$filterDateStart'";
} elseif ($filterDateEnd) {
    $filterDateQuery = "AND treatment_date <= '$filterDateEnd'";
}

$query = "SELECT * FROM treatments WHERE 1 $filterClientQuery $filterTreatmentQuery $filterDateQuery ORDER BY $sortBy DESC";
$result = $conn->query($query);

$totalPrice = 0;

while ($row = $result->fetch_assoc()) {
    $today = date("Y-m-d");
    $rowStyle = $row['treatment_date'] > $today ? "style='color: pink;'" : "";
    echo "<tr $rowStyle>";
    echo "<td>" . $row['treatment_name'] . "</td>";
    echo "<td>" . $row['treatment_date'] . "</td>";
    echo "<td>" . $row['client_name'] . "</td>";
    echo "<td>" . $row['treatment_price'] . " zł</td>";
    echo "<td>" . $row['detailed_description'] . "</td>";
    echo "<td><button class='edit' data-id='" . $row['id'] . "'>Edytuj</button> <button class='delete' data-id='" . $row['id'] . "'>Usuń</button></td>";
    echo "</tr>";

    if ($row['treatment_date'] <= $today) {
        $totalPrice += $row['treatment_price'];
    }
}

echo "<script>$('#total-price').html('Łączna kwota: $totalPrice zł')</script>";

$conn->close();
?>
