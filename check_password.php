<?php
session_start();

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    if (time() < $_SESSION['expire']) {
        header("Location: index.html");
        exit;
    } else {
        // Usuń zmienne sesyjne, jeśli czas wygaśnięcia minął
        unset($_SESSION['authenticated']);
        unset($_SESSION['expire']);
    }
}

$password = $_POST['password'];
$stored_password = "sasisasi";

if ($password === $stored_password) {
    $_SESSION['authenticated'] = true;
    $_SESSION['expire'] = time() + (15 * 60); // 15 minut

    http_response_code(200);
    echo json_encode(["status" => "success"]);
} else {
    http_response_code(401);
    echo json_encode(["status" => "error"]);
}
