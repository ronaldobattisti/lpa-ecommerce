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

    // Admin-only: load products and handle updates
    $sql = "SELECT * FROM lpa_stock WHERE 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $has_products = ($result->num_rows > 0);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // CSRF check
        if (empty($_POST['csrf_token']) || !csrf_check($_POST['csrf_token'])) {
            echo 'Invalid CSRF token';
            exit;
        }
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quant = $_POST['quant'];
        $category = $_POST['category'];

        if (!empty($_POST['new_image'])) {
            $image = 'assets/images/' . $_POST['new_image'];
        } else {
            $image = $_POST['image'];
        }

        $sql = "UPDATE `lpa_stock` SET  lpa_stock_name=?, 
                                        lpa_stock_desc=?, 
                                        lpa_stock_onhand=?,
                                        lpa_stock_price=?, 
                                        lpa_stock_cat=?, 
                                        lpa_stock_image=? 
                                        WHERE `lpa_stock`.`lpa_stock_id`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdissi", $name, $description, $quant, $price, $category, $image, $id);

        if ($stmt->execute()){
            echo '<meta http-equiv="refresh" content="5">';
        } else echo 'Fail updating';
    }
    $stmt->close();
    $conn->close();

    
?>

<!DOCTYPE html>
<html lang="en">
<header>
    <link rel="stylesheet" href="assets/css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
</header>

<body>
    <div><?php include __DIR__ . '/includes/header.php'; ?></div>

    <div>
        <?php if ($has_products): ?>
            <table border='1'>
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quant</th>
                    <th>Edit</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['lpa_stock_id'] ?></td>
                        <td><?php echo $row['lpa_stock_name'] ?></td>
                        <td><?php echo $row['lpa_stock_price'] ?></td>
                        <td><?php echo $row['lpa_stock_onhand'] ?></td>
                        <td><a href="#" onclick="show_popup(<?php echo $row['lpa_stock_id']; ?>, 
                                                            '<?php echo $row['lpa_stock_name']; ?>',
                                                            '<?php echo $row['lpa_stock_desc']; ?>',
                                                            <?php echo $row['lpa_stock_price']; ?>,
                                                            <?php echo $row['lpa_stock_onhand']; ?>,
                                                            '<?php echo $row['lpa_stock_cat']; ?>',
                                                            '<?php echo $row['lpa_stock_image']; ?>');">Edit</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No items were registered yet</p>
        <?php endif; ?>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>Edit item</p>
            <form method="post">
                <?php csrf_field(); ?>
                <label for="id">ID</label>
                <input type="text" name="id" id="id" readonly>

                <br>
    
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>

                <br>
    
                <label for="description">Description</label>
                <input type="text" name="description" id="description" required>

                <br>
    
                <label for="price">Price</label>
                <input type="text" name="price" id="price" required>

                <br>
    
                <label for="quant">Quantity</label>
                <input type="text" name="quant" id="quant" required>

                <br>

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

                <br>
    
                <label for="image">Product image:</label>
                <input type="text" name="image" id="image" readonly>
                <input type="file" name="new_image" id="new_image" accept="image/*">

                <br>
                <br>
                <button onclick="closeModal()">Close</button>
                <br>
                <br>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

</body>
    <?php include __DIR__ . '/includes/footer.html'; ?>
</body>
</html>

<script>
    function show_popup(id, name, desc, price, quant, cat, image_url) {
        document.getElementById("myModal").style.display = "block";
        document.getElementById("id").value = id;
        document.getElementById("name").value = name;
        document.getElementById("description").value = desc;
        document.getElementById("price").value = price;
        document.getElementById("quant").value = quant;
        document.getElementById("category").value = cat;
        document.getElementById("image").value = image_url;
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
</script>