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
        break;

    case "PUT":
        handleUpdate($conn);
        break;

    case "DELETE":
        handleDelete($conn);
        break;*/
}

//////If API receives a GET request\\\\\\
function handleGet($conn) {
    /*if (isset($_GET['id'])) {
        getUserById($conn, $_GET['id']);
        return;
    }*/

    if (isset($_GET['id'])) {
        getProductsById($conn, $_GET['id']);
        return;
    }

    // default = all users
    getAllProducts($conn);
}

//Return of GET user by email
function getProductsById($conn, $id) {

    $stmt = $conn->prepare(
        "SELECT * FROM lpa_stock WHERE lpa_stock_id = ?"
    );

    $stmt->bind_param("d", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    echo json_encode($user);
}

//Return all products
function getAllProducts($conn) {

    $stmt = $conn->prepare(
        "SELECT * FROM lpa_stock"//implement stock
    );

    $stmt->execute();

    $result = $stmt->get_result();
    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}

//////If API receives a POST request\\\\\\

//////If API receives a PUT request\\\\\\

//////If API receives a DELETE request\\\\\\

