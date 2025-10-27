<?php
header('Content-Type: application/json');

// Simple, easy-to-read create_invoice endpoint
include __DIR__ . '/../app/database/connection.php';
include __DIR__ . '/../assets/start_session_safe.php';
include __DIR__ . '/../assets/csrf.php';

function json_error($msg, $code = 400) {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
if (!$user_id) json_error('Not authenticated', 401);

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data) || empty($data['selected_ids'])) json_error('No products selected', 400);

// verify CSRF token sent from client
if (empty($data['csrf_token']) || !csrf_check($data['csrf_token'])) {
    json_error('Invalid CSRF token', 403);
}

$selectedIds = array_map('intval', $data['selected_ids']);
$quantities = isset($data['quantity']) && is_array($data['quantity']) ? $data['quantity'] : [];

// Start transaction
$conn->begin_transaction();
try {
    // Create invoice
    $stmt = $conn->prepare("INSERT INTO lpa_invoices (lpa_inv_date, lpa_inv_client_id, lpa_inv_amount, lpa_inv_payment_type, lpa_inv_status) VALUES (NOW(), ?, 0, 'Pending', 'U')");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $invoice_no = $conn->insert_id;

    // Prepare statements
    $pstmt = $conn->prepare("SELECT lpa_stock_name, lpa_stock_price FROM lpa_stock WHERE lpa_stock_id = ?");
    $item_stmt = $conn->prepare("INSERT INTO lpa_invoice_items (lpa_invitem_inv_no, lpa_invitem_stock_id, lpa_invitem_stock_name, lpa_invitem_qty, lpa_invitem_price, lpa_invitem_amount) VALUES (?, ?, ?, ?, ?, ?)");

    $total = 0.0;
    foreach ($selectedIds as $id) {
        $qty = isset($quantities[$id]) ? (int)$quantities[$id] : 1;

        $pstmt->bind_param('i', $id);
        $pstmt->execute();
        $pstmt->store_result();
        if ($pstmt->num_rows === 0) throw new Exception('Product not found: ' . $id);
        $pstmt->bind_result($name, $price);
        $pstmt->fetch();
        $pstmt->free_result();

        $amount = $price * $qty;
        $total += $amount;

        $item_stmt->bind_param('iisidd', $invoice_no, $id, $name, $qty, $price, $amount);
        if (!$item_stmt->execute()) {
            // If the table disallows multiple items per invoice, give a readable error
            throw new Exception('Failed inserting invoice item: ' . $item_stmt->error);
        }
    }

    // update invoice total
    $upd = $conn->prepare("UPDATE lpa_invoices SET lpa_inv_amount = ? WHERE lpa_inv_no = ?");
    $upd->bind_param('di', $total, $invoice_no);
    $upd->execute();

    // remove from cart
    $idsToDelete = implode(',', $selectedIds);
    if (!empty($idsToDelete)) {
        $conn->query("DELETE FROM lpa_cart WHERE lpa_cart_user_id = $user_id AND lpa_cart_item_id IN ($idsToDelete)");
    }

    $conn->commit();

    echo json_encode(['success' => true, 'message' => "Invoice #$invoice_no created. Total: AUD " . number_format($total,2)]);
    exit;

} catch (Exception $e) {
    $conn->rollback();
    json_error('Error creating invoice: ' . $e->getMessage(), 500);
}
