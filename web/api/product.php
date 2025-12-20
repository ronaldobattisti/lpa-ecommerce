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
}

//////If API receives a GET request\\\\\\
function handleGet($conn) {
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
        "SELECT lpa_stock_id as prodId,
                lpa_Stock_name as prodName,
                lpa_stock_desc as prodDesc,
                lpa_stock_onhand as prodStock,
                lpa_stock_price as prodPrice,
                lpa_stock_cat as prodCat,
                lpa_stock_image as prodImade,
                lpa_stock_status as prodStatus FROM lpa_stock WHERE prodId = ?"
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
        "SELECT lpa_stock_id as prodId,
                lpa_Stock_name as prodName,
                lpa_stock_desc as prodDesc,
                lpa_stock_onhand as prodStock,
                lpa_stock_price as prodPrice,
                lpa_stock_cat as prodCat,
                lpa_stock_image as prodImage,
                lpa_stock_status as prodStatus FROM lpa_stock"
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
function handleCreate($conn){
    
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
    $required = ['prodName', 'prodDesc', 'prodStock', 'prodPrice', 'prodCat', 'prodImage'];
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing field: $field"]);
            return;
        }
    }

    // Prepare SQL
    $stmt = $conn->prepare(
        "INSERT INTO lpa_stock 
        (lpa_stock_name, lpa_stock_desc, lpa_stock_onhand, lpa_stock_price, lpa_stock_cat, lpa_stock_image)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssidss",
        $data['prodName'],
        $data['prodDesc'],
        $data['prodStock'],
        $data['prodPrice'],
        $data['prodCat'],
        $data['prodImage']
    );

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "id" => $stmt->insert_id
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "error" => $stmt->error
        ]);
    }
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
    $required = ['id', 'name', 'description', 'stockOnhand', 'price', 'category', 'imageUrl'];
    foreach ($required as $field) {
        if (!isset($data[$field])) {
            http_response_code(400);
            echo json_encode(["error" => "Missing field: $field"]);
            return;
        }
    }

    // Prepare SQL
    $stmt = $conn->prepare(
        "UPDATE lpa_stock SET lpa_stock_name=?, 
                                lpa_stock_desc=?, 
                                lpa_stock_onhand=?, 
                                lpa_stock_price=?, 
                                lpa_stock_cat=?, 
                                lpa_stock_image=?)
        WHERE `lpa_stock`.`lpa_stock_id`=?"
        );

    $stmt->bind_param(
        "ssidssi",
        $data['name'],
        $data['description'],
        $data['stockOnhand'],
        $data['price'],
        $data['category'],
        $data['imageUrl'],
        $data['id']
    );

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "id" => $stmt->insert_id
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

