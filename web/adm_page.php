<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/assets/start_session_safe.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TempStore - Adms</title>
        <link rel="icon" type="image/x-icon" href="assets/images/logo.ico">
        <link rel="stylesheet" href="assets/css/styles.css"/>
    </head>
    <body class="body">
    <div><?php include __DIR__ . '/includes/header.php'; ?></div>

    <main class="admin-dashboard">
    <section class="welcome-box">
        <h1>Welcome, <span><?= htmlspecialchars($_SESSION['user_name']); ?></span></h1>
        <p>Manage your store efficiently using the tools below.</p>
    </section>

    <section class="admin-actions">
        <a href="product_register.php" class="admin-card">
            <i class="bi bi-box-seam"></i>
            <h3>Add Products</h3>
            <p>Register new products in your store.</p>
        </a>

        <a href="product_manage.php" class="admin-card">
            <i class="bi bi-pencil-square"></i>
            <h3>Manage Products</h3>
            <p>Edit or remove existing products.</p>
        </a>

        <a href="order_manage.php" class="admin-card">
            <i class="bi bi-receipt-cutoff"></i>
            <h3>Manage Orders</h3>
            <p>Track and update customer orders.</p>
        </a>

        <a href="user_manage.php" class="admin-card">
            <i class="bi bi-people"></i>
            <h3>Manage Clients</h3>
            <p>View and manage registered users.</p>
        </a>
    </section>
    </main>

        <?php include __DIR__ . '/includes/footer.html'; ?>
    </body>
</html>