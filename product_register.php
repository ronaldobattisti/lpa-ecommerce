<?php
// Disable caching for test purposes
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies and browsers
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
        <div id="header-placeholder"></div>

        <div id="menu-placeholder"></div>

        <form>
            <div>
                <label for="name">Product name:</label>
                <input type="text" id="name" class="" name="name" required>
            </div>

            <div>
                <label for="description">Product description:</label>
                <input type="text" id="description" class="" name="description" required>
            </div>

            <div>
                <label for="price">Product price:</label>
                <input type="number" id="price" class="" name="price" required>
            </div>

            <div>
                <label for="category">Category:</label>
                <select id="category" name="category">
                    <option value="desktop">Desktop</option>
                    <option value="laptop">Laptop</option>
                    <option value="component">Component</option>
                    <option value="storage">Storage</option>
                    <option value="perihperal">Perihperal</option>
                    <option value="display">Display</option>
                    <option value="network">Network</option>
                    <option value="printer">Printer</option>
                </select>
            </div>

            <div>
                <label for="image">Product image:</label>
                <input type="" id="image" class="" name="image" accept="image/*" required>
            </div>

            <div>
                <button type="submit" class="button-submit">Login</button>
            </div>
        </form>

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