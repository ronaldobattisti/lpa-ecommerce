<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';
    include __DIR__ . '/assets/csrf.php';
    include __DIR__ . '/config/site.php';

    // Require admin to add products
    $base = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';
    if (empty($_SESSION['user_isadm'])) {
        header('Location: ' . $base . '/index.php');
        exit;
    }

    //getting data from forms
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // CSRF validation
        if (empty($_POST['csrf_token']) || !csrf_check($_POST['csrf_token'])) {
            // simple error response
            echo 'Invalid CSRF token';
            exit;
        }
            //getting data
        $prod_name = $_POST['name'];
        $prod_desc = $_POST['description'];
        $prod_onhand = $_POST['onhand'];
        $prod_price = $_POST['price'];
        $prod_cat = $_POST['category'];
        $prod_url = 'assets/images/' . $_POST['image'];
        //db sets by default status = 'a' (available)

        //prepare to run the query wo filling the values
        $stmt = $conn->prepare("INSERT INTO lpa_stock ( lpa_stock_name, 
                                                        lpa_stock_desc, 
                                                        lpa_stock_onhand, 
                                                        lpa_stock_price, 
                                                        lpa_stock_cat, 
                                                        lpa_stock_image) 
                                                        VALUES (?, ?, ?, ?, ?, ?)");
        //Avoid SQL injection by making sure that data will be pushed in the correct format
        $stmt->bind_param("ssidss", $prod_name, $prod_desc, $prod_onhand, $prod_price, $prod_cat, $prod_url);

        //Run the query
        if ($stmt->execute()) {
              include __DIR__ . '/config/site.php';
              header("Location: " . BASE_URL . "/index.php");
              exit();
        } else {
              include __DIR__ . '/config/site.php';
              header("Location: " . BASE_URL . "/register.php?error=1");
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
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body class="body">
    <div><?php include __DIR__ . '/includes/header.php'; ?></div>

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

            <?php include __DIR__ . '/includes/category_select.php'?>

            <div>
                <label for="image">Product image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            <div>
                <button type="submit" class="button-submit">Register product</button>
            </div>
            <?php csrf_field(); ?>
        </form>

    <?php include __DIR__ . '/includes/footer.html'; ?>
    </body>
</html>