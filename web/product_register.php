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

        //getting data
        $prod_name = $_POST['name'];
        $prod_desc = $_POST['description'];
        $prod_onhand = $_POST['onhand'];
        $prod_price = $_POST['price'];
        $prod_cat = $_POST['category'];
        $prod_url = $_POST['image_filename'];
        //echo "<script>alert('Image URL: ' + " . json_encode($prod_url) . ");</script>";
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
        } else {
            include __DIR__ . '/config/site.php';
            header("Location: " . BASE_URL . "/register.php?error=1");
        }

        //Close connection
        $stmt->close();
        $conn->close();
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TempStore - Product Register</title>
        <link rel="icon" type="image/x-icon" href="assets/images/logo.ico">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body class="body">
        <div><?php include __DIR__ . '/includes/header.php'; ?></div>

        <!-- enctype is crucial -->
        <form method='post' action='product_register.php' enctype="multipart/form-data">
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
                <input type="file" id="image" name="image" accept="image/*" required>
                <input type="hidden" name="image_filename" id="image_filename">
            </div>

            <div>
                <button type="submit" class="button-submit">Register product</button>
            </div>
        </form>

        <?php include __DIR__ . '/includes/footer.html'; ?>

        <script>
        document.getElementById('image').addEventListener('change', async function() {

            const file = this.files[0];
            if (!file) return;

            const data = new FormData();
            data.append("image", file);

            try {
                const response = await fetch("api/upload.php", {
                    method: "POST",
                    body: data
                });

                const text = await response.text();
                let json;
                try {
                    json = JSON.parse(text);
                } catch (e) {
                    alert("Upload failed: invalid response");
                    console.error("Upload parse error", text);
                    return;
                }

                if (!response.ok || !json.success) {
                    alert("Upload failed: " + (json.error || response.status));
                    console.error("Upload error detail:", json);
                    return;
                }

                const value = json.url || json.filename;
                if (!value) {
                    alert("Upload failed: missing filename");
                    return;
                }

                alert("url: " + document.getElementById('image').value);
                document.getElementById("image_filename").value = value;

            } catch (error) {
                alert("Upload error");
                console.error(error);
            }

        });
        </script>
    </body>
</html>
