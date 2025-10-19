<?php
    include 'app/database/connection.php';
    include 'assets/start_session_safe.php';

    if (isset($_POST['id']) && isset($_POST['quant'])) {
        $item_id = intval($_POST['id']);
        $quant = intval($_POST['quant']);
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("UPDATE lpa_cart SET lpa_cart_item_qty = ? WHERE lpa_cart_user_id = ? AND lpa_cart_item_id = ?");
        $stmt->bind_param("iii", $quant, $user_id, $item_id);
        $stmt->execute();

        echo "Quantity updated successfully";
    }
?>
