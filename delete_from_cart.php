<?php
    include 'connection.php';
    include 'start_session_safe.php';

    echo 'id' . $_GET['item_id'];

    if (isset($_GET['item_id'])) {
        $item_id = intval($_GET['item_id']);  // sanitize input
        $user_id = $_SESSION['user_id']; // current user

        $stmt = $conn->prepare("DELETE FROM lpa_cart WHERE lpa_cart_item_id = ? AND lpa_cart_user_id = ?");
        $stmt->bind_param("ii", $item_id, $user_id);
        $stmt->execute();
    }

    // Redirect back to the cart page
    header("Location: cart.php");
    exit;
?>