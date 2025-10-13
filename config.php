<?php
    include 'disable_cache.php';
    include 'start_session_safe.php';
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
            <p>Welcome to you account's settings, <?php echo $_SESSION['user_name']; ?></p>
            <p>Click <a href="logout.php">here</a> to log out</p>
        </div>

        <div><?php include 'footer.html'; ?></div>
    </body>
</html>