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

    /*case "PUT":
        handleUpdate($conn);
        break;

    case "DELETE":
        handleDelete($conn);
        break;*/
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
    $orders = $result->fetch_assoc();

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

//////If API receives a DELETE request\\\\\\

