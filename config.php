<?php
    // Disable caching for test
    header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies and browsers

    session_start();

    if (!empty($_SESSION['user_id'])){
        echo 'Welcome, ' . $_SESSION['user_name'];
    }


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
        <div>
            <p>Welcome to you account's settings, <?php echo $_SESSION['user_name']; ?></p>
            <p>Click <a href="logout.php">here</a> to log out</p>
        </div>
    </body>
</html>

<script>
    function loadContent(){
        fetch('header.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
        });

        fetch('menu.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('menu-placeholder').innerHTML = data;
        });

        fetch('footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-placeholder').innerHTML = data;
        });
    }
    
    document.addEventListener('DOMContentLoaded', loadContent);
</script>