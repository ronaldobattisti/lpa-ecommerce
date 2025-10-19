<?php
    include 'assets/disable_cache.php';
    include 'assets/start_session_safe.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Temp Store</title>
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body class="body">
        <div><?php include 'includes/header.php'; ?></div>

        <div>
            <p>Welcome adm <?php echo $_SESSION['user_name']; ?></p>
        </div>

        <div>
            <p>Click <a href="product_register.php">here</a> to add products</p>
        </div>

        <div>
            <p>Click <a href="product_manage.php">here</a> to manage products</p>
        </div>

        <div>
            <p>Click <a href="manage_orders.php">here</a> to manage orders</p>
        </div>

        <div><?php include 'includes/footer.html'; ?></div>
    </body>
</html>