<?php

require_once __DIR__ . "/../app/database/connection.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

switch ($_SERVER["REQUEST_METHOD"]) {

    case "GET":
        handleGet($conn);
        break;

    /*case "POST":
        handleCreate($conn);
        break;*/

    case "PUT":
        handleUpdate($conn);
        break;

    /*case "DELETE":
        handleDelete($conn);
        break;*/
}

//////If API receives a GET request\\\\\\
function handleGet($conn) {
    /*if (isset($_GET['id'])) {
        getUserById($conn, $_GET['id']);
        return;
    }*/

    if (isset($_GET['email'])) {
        getUserByEmail($conn, $_GET['email']);
        return;
    }

    // default = all users
    getAllUsers($conn);
}

//Return of GET user by email
function getUserByEmail($conn, $email) {

    $stmt = $conn->prepare(
        "SELECT * FROM lpa_clients WHERE lpa_client_email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    echo json_encode($user);
}

//Return all users
function getAllUsers($conn) {

    $stmt = $conn->prepare(
        "SELECT * FROM lpa_clients"
    );

    $stmt->execute();

    $result = $stmt->get_result();
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
}

//////If API receives a POST request\\\\\\

//////If API receives a PUT request\\\\\\
function handleUpdate($conn){
    
    // Read raw JSON body
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    // Validate JSON
    if (!$data) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON"]);
        return;
    }

    // Validate required fields
    $required = ['id', 'group', 'firstName', 'lastName', 'adress', 'clientStatus'];
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing field: $field"]);
            return;
        }
    }

    // Prepare SQL -> TODO: continue from here:
    $stmt = $conn->prepare(
        "UPDATE lpa_invoices SET lpa_inv_amount=?,
                                lpa_inv_payment_type=?, 
                                lpa_inv_status=?
        WHERE `lpa_invoices`.`lpa_inv_no`=?"
        );

    $stmt->bind_param(
        "fssi",
        $data['amount'],
        $data['status'],
        $data['invStatus'],
        $data['id']
    );

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => $stmt->error
        ]);
    }
}

//////If API receives a DELETE request\\\\\\

