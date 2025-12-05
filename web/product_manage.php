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

        //Calls the same script used at register_product
        //TODO: Create a script folder to share the same script user to upload image in register product and in update product
        $prod_url = $_POST['image_filename'];
        //echo "<script>alert('Image URL: ' + " . json_encode($prod_url) . ");</script>";
        
        $stmt = $conn->prepare("UPDATE `lpa_stock` SET lpa_stock_name=?, 
                                                        lpa_stock_desc=?, 
                                                        lpa_stock_onhand=?, 
                                                        lpa_stock_price=?, 
                                                        lpa_stock_cat=?, 
                                                        lpa_stock_image=? 
                                                        WHERE `lpa_stock`.`lpa_stock_id`=?");
        $stmt->bind_param("ssidssi", $name, $description, $quant, $price, $category, $prod_url, $id);

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
    <link rel="icon" type="image/x-icon" href="assets/images/logo.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TempStore - Manage Products</title>
</header>

    <body class="body">
        <div><?php include __DIR__ . '/includes/header.php'; ?></div>

        <div class="admin-products-container">
        <h2>Manage Products</h2>

        <?php if ($has_products): ?>
            <table class="products-table">
            <thead>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price (AUD)</th>
                <th>Qty</th>
                <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['lpa_stock_id'] ?></td>
                    <td><?= htmlspecialchars($row['lpa_stock_name']) ?></td>
                    <td><?= number_format($row['lpa_stock_price'], 2) ?></td>
                    <td><?= $row['lpa_stock_onhand'] ?></td>
                    <td>
                    <a href="#"
                        class="edit-link"
                        onclick="show_popup(
                            <?= $row['lpa_stock_id'] ?>,
                            '<?= htmlspecialchars($row['lpa_stock_name'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['lpa_stock_desc'], ENT_QUOTES) ?>',
                            <?= $row['lpa_stock_price'] ?>,
                            <?= $row['lpa_stock_onhand'] ?>,
                            '<?= htmlspecialchars($row['lpa_stock_cat'], ENT_QUOTES) ?>',
                            '<?= htmlspecialchars($row['lpa_stock_image'], ENT_QUOTES) ?>'
                        )">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            </table>
        <?php else: ?>
            <p class="no-products">No items have been registered yet.</p>
        <?php endif; ?>
        </div>

        <!-- MODAL -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <h3>Edit Product</h3>
                <form method="post" class="modal-form">
                <?php csrf_field(); ?>

                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" name="id" id="id" readonly>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" id="description" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                    <label for="price">Price (AUD)</label>
                    <input type="number" name="price" id="price" step="0.01" required>
                    </div>
                    <div class="form-group">
                    <label for="quant">Quantity</label>
                    <input type="number" name="quant" id="quant" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category">
                    <option value="desktop">Desktop</option>
                    <option value="laptop">Laptop</option>
                    <option value="component">Component</option>
                    <option value="storage">Storage</option>
                    <option value="peripheral">Peripheral</option>
                    <option value="display">Display</option>
                    <option value="network">Network</option>
                    <option value="printer">Printer</option>
                    </select>
                </div>

                <!-- Same snippet used at register product -->
                <div class="form-group">
                    <label for="image">Product image:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <input type="hidden" name="image_filename" id="image_filename">
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-close" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-submit">Update</button>
                </div>
                </form>
            </div>
        </div>

        <?php include __DIR__ . '/includes/footer.html'; ?>

        <script>
            function show_popup(id, name, desc, price, quant, cat, image_url) {
                document.getElementById("myModal").style.display = "block";
                document.getElementById("id").value = id;
                document.getElementById("name").value = name;
                document.getElementById("description").value = desc;
                document.getElementById("price").value = price;
                document.getElementById("quant").value = quant;
                document.getElementById("category").value = cat;
                document.getElementById("image_filename").value = image_url; // keep current URL if no new upload
            }

            function closeModal() {
                document.getElementById("myModal").style.display = "none";
            }

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

                    document.getElementById("image_filename").value = value;

                } catch (error) {
                    alert("Upload error");
                    console.error(error);
                }
            });

        </script>
    </body>
</html>
