<?php
    include 'assets/disable_cache.php';
    include 'app/database/connection.php';
    include 'assets/start_session_safe.php';

    $sql = "SELECT * FROM lpa_stock";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $has_products = ($result->num_rows > 0);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quant = $_POST['quant'];
        $category = $_POST['category'];

        if ($_POST['new_image'] != '') {
            $image = 'assets/images/' . $_POST['new_image'];
        } else $image = $_POST['image'];

        $sql = "UPDATE `lpa_stock` SET  lpa_stock_name=?, 
                                        lpa_stock_desc=?, 
                                        lpa_stock_onhand=?,
                                        lpa_stock_price=?, 
                                        lpa_stock_cat=?, 
                                        lpa_stock_image=?, 
                                        WHERE `lpa_stock`.`lpa_stock_id `=?";
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

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
    }

    .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        text-align: center;
    }
</style>

<body>
    <div><?php include 'includes/header.php'; ?></div>

    <div>
        <?php if ($has_products): ?>
            <table border='1'>
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quant</th>
                    <th>Anything</th>
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

    <div><?php include 'includes/footer.html'; ?></div>
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