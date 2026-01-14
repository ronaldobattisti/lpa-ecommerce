<?php

require_once __DIR__ . "/../app/database/connection.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

switch ($_SERVER["REQUEST_METHOD"]) {

    case "GET":
        handleGet($conn);
        break;

    case "POST":
        handleCreate($conn);
        break;

    case "PUT":
        handleUpdate($conn);
        break;

    /*case "DELETE":
        handleDelete($conn);
        break;*/

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;

}

//////If API receives a GET request\\\\\\
function handleGet($conn) {
    if (isset($_GET['id'])) {
        getOrdersById($conn, $_GET['id']);
        return;
    }

    // default = all users
    getAllOrders($conn);
}

//Return of GET user by email
function getOrdersById($conn, $id) {

    $stmt = $conn->prepare(
        /*"SELECT i.*, c.lpa_client_firstname, c.lpa_client_lastname 
            FROM lpa_invoices i
            JOIN lpa_clients c ON i.lpa_inv_client_id = c.lpa_client_id
            WHERE id = ?"*/
            "SELECT * FROM lpa_invoices WHERE lpa_inv_client_id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    echo json_encode($orders);
}

//Return all products
function getAllOrders($conn) {

    $stmt = $conn->prepare(
        "SELECT i.*, c.lpa_client_firstname, c.lpa_client_lastname 
            FROM lpa_invoices i
            JOIN lpa_clients c on i.lpa_inv_client_id = c.lpa_client_id");

    $stmt->execute();

    $result = $stmt->get_result();
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    echo json_encode($orders);
}

//////If API receives a POST request\\\\\\
function handleCreate($conn){
    return;
}

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
    $required = ['id', 'amount', 'status', 'invStatus'];
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing field: $field"]);
            return;
        }
    }

    // Prepare SQL
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

