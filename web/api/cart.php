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
            //"SELECT * FROM lpa_cart WHERE lpa_cart_user_id = ?"
            "SELECT
          c.lpa_cart_item_qty AS quantity,
          s.lpa_stock_id AS prodId,
          s.lpa_stock_name AS prodName,
          s.lpa_stock_desc AS prodDesc,
          s.lpa_stock_onhand AS prodStock,
          s.lpa_stock_price AS prodPrice,
          s.lpa_stock_cat AS prodCat,
          s.lpa_stock_image AS prodImage,
          s.lpa_stock_status AS prodStatus
        FROM lpa_cart c
        JOIN lpa_stock s
          ON s.lpa_stock_id = c.lpa_cart_item_id
        WHERE c.lpa_cart_user_id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $items = [];

    while ($row = $result->fetch_assoc()) {
        $items[] = [
            "quantity" => (int)$row["quantity"],
            "product" => [
                "prodId"     => (int)$row["prodId"],
                "prodName"   => $row["prodName"],
                "prodDesc"   => $row["prodDesc"],
                "prodStock"  => (int)$row["prodStock"],
                "prodPrice"  => (float)$row["prodPrice"],
                "prodCat"    => $row["prodCat"],
                "prodImage"  => $row["prodImage"],
                "prodStatus" => $row["prodStatus"]
            ]
        ];
    }

    echo json_encode($items);
}