<?php

require_once __DIR__ . "/../app/database/connection.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Query
$sql = "SELECT id, name, email FROM users";

$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();

// Convert DB rows → array
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Output JSON
echo json_encode($users);