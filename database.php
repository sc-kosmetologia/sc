<?php
$servername = "localhost";
$username = "00859474_kursy";
$password = "BOxer123$";
$dbname = "00859474_kursy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");
$conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
