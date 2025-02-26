<?php

use php\ConnectDb;

header('Content-Type: application/json; charset=utf-8');

// 1. Ensure this script only handles POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Only POST requests are allowed"]);
    exit;
}

// 2. Read raw input and decode JSON
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

// 3. Validate that we have an email
if (!isset($data['email']) || empty($data['email'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "No email provided"]);
    exit;
}

$email = $data['email'];

// 4. Connect to database and validate email
try {
    $db = ConnectDb::getConnection();
    $stmt = $db->prepare("SELECT * FROM student WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // 4.a if a student is found, return a welcome message with the registered email
    if ($row) {
        echo json_encode(["message" => "Welcome back, {$row['email']} !"]);
    }
    // 4.b if no student is found, return an error message
    else {
        http_response_code(404); // Not Found
        echo json_encode(["error" => "No student found with that email"]);
    }
}
catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}