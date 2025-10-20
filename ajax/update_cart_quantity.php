<?php
    // AJAX endpoint to update cart item quantity
    header('Content-Type: application/json; charset=utf-8');
    include __DIR__ . '/../app/database/connection.php';
    include __DIR__ . '/../assets/start_session_safe.php';

    // Ensure user is logged in
    if (empty($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['ok' => false, 'error' => 'Not authenticated']);
        exit;
    }

    $item_id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $quant = isset($_POST['quant']) ? intval($_POST['quant']) : null;

    if ($item_id === null || $quant === null) {
        http_response_code(400);
        echo json_encode(['ok' => false, 'error' => 'Missing parameters']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Validate quantity
    if ($quant < 1) $quant = 1;

    $stmt = $conn->prepare("UPDATE lpa_cart 
                            SET lpa_cart_item_qty = ? 
                            WHERE lpa_cart_user_id = ? 
                            AND lpa_cart_item_id = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Prepare failed']);
        exit;
    }

    $stmt->bind_param('iii', $quant, $user_id, $item_id);
    if ($stmt->execute()) {
        echo json_encode(['ok' => true, 'message' => 'Quantity updated']);
    } else {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => 'Execute failed']);
    }
    $stmt->close();
    exit;
?>
