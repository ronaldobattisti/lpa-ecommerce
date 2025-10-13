<?php
    include 'disable_cache.php';
    include 'start_session_safe.php';

    //$sql = "SELECT name, description, price"
?>

<!DOCTYPE html>
<html lang="en">
    <header>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Temp Store</title>
        <link rel="stylesheet" href="css/styles.css">
    </header>
    <body class="body">
        <div><?php include 'header.php'; ?></div>

        <div><?php include 'menu.php'; ?></div>

        <div class="product">
            <?php include 'products_div.php'; ?>
        </div>

        <div><?php include 'footer.html'; ?></div>
    </body>
</html>