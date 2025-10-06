<?php
    // Disable caching for test
    header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies and browsers

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

        <div><?php include 'menu.html'; ?></div>

        <div>
            <p>Welcome adm <?php echo $_SESSION['user_name']; ?></p>
        </div>

        <div>
            <p>Click <a href="adm_page.php">here</a> to manage products</p>
        </div>

        <div><?php include 'footer.html'; ?></div>
    </body>
</html>