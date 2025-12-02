<?php

    $uploadDir = __DIR__ . "/../images/";

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!isset($_FILES['image'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'No file']);
        exit;
    }

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid("img") . "." . $ext;

    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename);

    $imageUrl = "https://ecomms.wuaze.com/images/" . $filename;

    echo json_encode([
        'success' => true,
        'filename' => $filename,
        'url' => $imageUrl
    ]);
    
?>