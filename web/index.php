<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/assets/start_session_safe.php';

    $search = $_GET['search'] ?? '';
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
    <div><?php include __DIR__ . '/includes/header.php'; ?></div>

    <div><?php include __DIR__ . '/includes/menu.php'; ?></div>

    <div class="product">
        <?php include __DIR__ . '/includes/products_div.php'; ?>
    </div>

</body>
<?php include __DIR__ . '/includes/footer.html'; ?>
</html>