<?php
    include 'assets/disable_cache.php';
    include 'assets/start_session_safe.php';
?>

<!DOCTYPE html>
<html lang="en">
    <header>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Temp Store</title>
        <link rel="stylesheet" href="assets/css/styles.css">
    </header>
    <body class="body">
        <div><?php include 'includes/header.php'; ?></div>

        <div><?php include 'includes/menu.php'; ?></div>

        <div class="product">
            <?php include 'includes/products_div.php'; ?>
        </div>

        <div><?php include 'includes/footer.html'; ?></div>
    </body>
</html>