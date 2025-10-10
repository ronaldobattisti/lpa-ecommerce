<?php
    // Disable caching for test
    header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies and browsers

    include 'connection.php';
    include 'start_session_safe.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT user, email FROM dbuser WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['user'];
        $email = $row['email'];
    }

    // Fetch all cart items with product info in a single query
    $sql = "
        SELECT p.*, c.quant
        FROM dbproducts p
        JOIN dbcart c ON p.id = c.itemID
        WHERE c.userID = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $hasItemsInCart = $result->num_rows > 0;
    $total = 0;
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Temp Store</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="body">

        
        <div><?php include 'header.php'; ?></div>

        <div>
            <p>Welcome to your cart, <?php echo htmlspecialchars($username); ?>.</p>

            <?php if ($hasItemsInCart): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" 
                             alt="<?php echo htmlspecialchars($row['name']); ?>" 
                             class="image">
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <p><strong>$<?php echo number_format($row['price'], 2); ?></strong></p>
                        <p>Quantity: <?php echo (int)$row['quant']; ?></p>
                        <?php
                            $total += $row['quant'] * $row['price'];
                        ?>
                    </div>
                <?php endwhile; ?>

                <div class="cart-total">
                    <h3>Total: $<?php echo number_format($total, 2); ?></h3>
                </div>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <div><?php include 'footer.html'; ?></div>
    </body>
</html>