<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/assets/start_session_safe.php';
    include __DIR__ . '/config/site.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TempStore - Acc Settings</title>
        <link rel="icon" type="image/x-icon" href="assets/images/logo.ico">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body class="body">
    <div><?php include __DIR__ . '/includes/header.php'; ?></div>

    <div class="account-panel">
        <h2>Account Settings</h2>
        <p class="welcome-msg">
            Welcome to your account settings, 
            <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>.
        </p>

        <div class="account-links">
            <a href="<?php echo BASE_URL . '/order_view.php'; ?>" class="account-link">
            <i class="bi bi-box-seam"></i> View your orders
            </a>

            <a href="<?php echo BASE_URL . '/includes/logout.php'; ?>" class="account-link logout">
            <i class="bi bi-box-arrow-right"></i> Log out
            </a>
        </div>
    </div>


        <?php include __DIR__ . '/includes/footer.html'; ?>
    </body>
</html>