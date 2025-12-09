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

//////If API receives a DELETE request\\\\\\

