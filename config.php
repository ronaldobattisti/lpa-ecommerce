<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/assets/start_session_safe.php';
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

        <div>
            <p>Welcome to you account's settings, <?php echo $_SESSION['user_name']; ?></p>
            <p>Click <a href="includes/logout.php">here</a> to log out</p>
        </div>

    <div><?php include __DIR__ . '/includes/footer.html'; ?></div>
    </body>
</html>