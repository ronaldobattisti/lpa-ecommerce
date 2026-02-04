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

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}

//////If API receives a GET request\\\\\\
function handleGet($conn) {
    if (isset($_GET['id'])) {
        getCartItemsByUserId($conn, $_GET['id']);
        return;
    }
}

//Return of GET items from cart by user id
function getCartItemsByUserId($conn, $id) {

    $stmt = $conn->prepare(
            "SELECT * FROM lpa_cart WHERE lpa_cart_user_id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode($items);
}