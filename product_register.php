<?php
    include 'disable_cache.php'
    include 'connection.php';
    include 'start_session_safe.php';

    //getting data from forms
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            //getting data
        $prod_name = $_POST['name'];
        $prod_desc = $_POST['description'];
        $prod_onhand = $_POST['onhand'];
        $prod_price = $_POST['price'];
        $prod_cat = $_POST['category'];
        $prod_url = 'images/' . $_POST['image'];
        //db sets by default status = 'a' (available)

        //prepare to run the query wo filling the values
        $stmt = $conn->prepare("INSERT INTO dbproducts (lpa_stock_name, 
                                                        lpa_stock_desc, 
                                                        lpa_stock_onhand, 
                                                        lpa_stock_price, 
                                                        lpa_stock_cat, 
                                                        lpa_stock_image) 
                                                        VALUES (?, ?, ?, ?, ?, ?)");
        //Avoid SQL injection by making sure that data will be pushed in the correct format
        $stmt->bind_param("ssidss", $prod_name, $prod_desc, $prod_onhand, $prod_price,  $prod_cat, $prod_url);

        //Run the query
        if ($stmt->execute()) {
            // ✅ Registration successful → go to index
            header("Location: index.php");
            exit();
        } else {
            // ❌ Registration failed → go back to registration
            header("Location: register.php?error=1");
            exit();
        }

        //Close connection
        $stmt->close();
        $conn->close();
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
        <div><?php include 'header.php'; ?></div>

        <form method='post'>
            <div>
                <label for="name">Product name:</label>
                <input type="text" id="name" class="" name="name" required>
            </div>

            <div>
                <label for="description">Product description:</label>
                <input type="text" id="description" class="" name="description" required>
            </div>

            <div>
                <label for="onhand">Quantity available:</label>
                <input type="text" id="onhand" class="" name="onhand" required>
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
                    <option value="peripheral">Perihperal</option>
                    <option value="display">Display</option>
                    <option value="network">Network</option>
                    <option value="printer">Printer</option>
                </select>
            </div>

            <div>
                <label for="image">Product image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <div>
                <button type="submit" class="button-submit">Register product</button>
            </div>
        </form>

        <div><?php include 'footer.html'; ?></div>
    </body>
</html>