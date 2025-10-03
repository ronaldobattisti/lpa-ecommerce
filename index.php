<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temp Store</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="body">
    <div id="header-placeholder"></div>

    <div id="menu-placeholder"></div>

    <div class="product">
        <?php include 'products_div.php'; ?>
    </div>

    <div id="footer-placeholder"></div>
</body>
</html>

<script>
    function loadContent(){
        fetch('header.html')
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