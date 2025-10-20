<?php
    include __DIR__ . '/../app/database/connection.php';
    include __DIR__ . '/../assets/start_session_safe.php';

    // No output before headers — remove any debugging echoes above

    // Ensure user is authenticated
    if (empty($_SESSION['user_id'])) {
        include __DIR__ . '/../config/site.php';
        header("Location: " . BASE_URL . "/login.php");
        exit;
    }

    if (isset($_GET['item_id'])) {
        $item_id = intval($_GET['item_id']);  // sanitize input
        $user_id = $_SESSION['user_id']; // current user

        $stmt = $conn->prepare("DELETE FROM lpa_cart 
                                WHERE lpa_cart_item_id = ? 
                                AND lpa_cart_user_id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $item_id, $user_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Redirect back to the cart page
    include __DIR__ . '/../config/site.php';
    header("Location: " . BASE_URL . "/cart.php");
    exit;
?>