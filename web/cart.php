<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';
    include __DIR__ . '/config/site.php';
    
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT lpa_client_firstname, lpa_client_lastname, lpa_client_email FROM lpa_clients WHERE lpa_client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['lpa_client_firstname'] . ' ' . $row['lpa_client_lastname'];
        $email = $row['lpa_client_email'];
    }

    // Fetch all cart items with product info in a single query
    //check thisq query
    $sql = "
        SELECT s.*, c.lpa_cart_item_qty
        FROM lpa_stock s
        JOIN lpa_cart c ON s.lpa_stock_id = c.lpa_cart_item_id 
        WHERE c.lpa_cart_user_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $hasItemsInCart = $result->num_rows > 0;
    $total = 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TempStore - Cart</title>
        <link rel="icon" type="image/x-icon" href="assets/images/logo.ico">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>
    <body class="body">

        <script>
            window.BASE_URL = '<?php echo defined("BASE_URL") ? rtrim(BASE_URL, "\\/") : ""; ?>';
            window.CSRF_TOKEN = '<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : ''; ?>';
        </script>

        <div><?php include __DIR__ . '/includes/header.php'; ?></div>

        <div class="cart-container">
            <h2>Shopping Cart</h2>
            <p class="cart-welcome">Welcome to your cart, <span><?php echo htmlspecialchars($username); ?></span>.</p>

            <form id="purchaseForm" method="POST" class="cart-form">
                <?php if ($hasItemsInCart): ?>
                <table class="cart-table">
                    <thead>
                    <tr>
                        <th>Select</th>
                        <th>Thumbnail</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()):
                        $id = $row['lpa_stock_id'];
                        $name = $row['lpa_stock_name'];
                        $price = $row['lpa_stock_price'];
                        $quant = $row['lpa_cart_item_qty'];
                        $imgFile = $row['lpa_stock_image'] ?: 'no-image.png';
                        $itemTotal = $price * $quant;
                        $total += $itemTotal;
                    ?>
                        <tr>
                        <td><input type="checkbox" name="selected_ids[]" value="<?php echo $id; ?>"></td>
                        <td>
                            <img src="<?php echo $imgFile; ?>" alt="<?php echo htmlspecialchars($name); ?>" class="cart-thumb">
                        </td>
                        <td><?php echo htmlspecialchars($name); ?></td>
                        <td>AUD <?php echo number_format($price, 2); ?></td>
                        <td>
                            <input
                            type="number"
                            name="quantity[<?php echo $id; ?>]"
                            value="<?php echo $quant; ?>"
                            min="1"
                            max="999"
                            step="1"
                            class="quantity"
                            data-id="<?php echo $id; ?>"
                            aria-label="Quantity for <?php echo htmlspecialchars($name); ?>"
                            >
                        </td>
                        <td class="total">AUD <?php echo number_format($itemTotal, 2); ?></td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/ajax/delete_from_cart.php?item_id=<?php echo $id; ?>"
                            class="delete-link"
                            onclick="return confirm('Delete this item?');">
                            <i class="bi bi-trash"></i>
                            </a>
                        </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <p><strong>Total:</strong> AUD <span id="cartTotal"><?php echo number_format($total, 2); ?></span></p>
                    <button type="submit" class="btn-purchase" onclick="alert('Purchase successful!')">
                        <i class="bi bi-cash-coin"></i> Purchase
                    </button>
                </div>
                <?php else: ?>
                <p class="empty-cart">Your cart is empty.</p>
                <?php endif; ?>
            </form>

            <div id="responseMessage"></div>
        </div>

        
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                let quantityInputs = document.querySelectorAll('.quantity');
                let deleteButtons = document.querySelectorAll('.delete');

                quantityInputs.forEach(function(input) {

                    input.addEventListener('change', function() {

                        // 4- Get the item ID and new quantity
                        let id = this.dataset.id;      // which product
                        let quant = this.value;        // new quantity entered by user

                        // 5- Send AJAX request to PHP, POST because we're sending data and 
                        // the content type is regarding the type of data(HTML format).
                        // body is the content sent, where the encodeURIComponent assure thet special characters are safely send
                        // that's what php file receives:
                        // $_POST['id']
                        // $_POST['quant']
                        let link = 'ajax/update_cart_quantity.php';
                                    fetch(link, {
                                        method: 'POST',
                                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                        body: 'id=' + encodeURIComponent(id) + '&quant=' + encodeURIComponent(quant)
                                    })
                                    .then(function(response) {
                                        if (!response.ok) throw new Error('Network response was not ok: ' + response.status);
                                        return response.json(); // converts response into json
                                    })
                                    .then(function(json) {
                                        console.log('AJAX result:', json);
                                        if (json.ok) {
                                            // Update the total price in the table row immediately
                                            var priceText = this.closest('tr').querySelector('td:nth-child(4)').innerText;
                                            var price = parseFloat(priceText.replace('AUD ', ''));
                                            this.closest('tr').querySelector('.total').innerText = 'AUD ' + (price * quant).toFixed(2);
                                            updateCartTotal();
                                        } else {
                                            console.error('Server error:', json.error || json.message);
                                            alert('Could not update quantity: ' + (json.error || json.message));
                                        }
                                    }.bind(this))
                                    .catch(function(err) {
                                        console.error('Fetch error:', err);
                                        alert('An error occurred while updating quantity. See console for details.');
                                    });
                    });
                });
            });

            function updateCartTotal() {
                let totals = document.querySelectorAll('.total');
                let sum = 0;

                totals.forEach(function(td){
                    let text = td.innerText.replace('AUD ', '').trim();
                    let value = parseFloat(text);

                    if (!isNaN(value)){
                        sum += value;
                    }
                });
                
                document.getElementById('cartTotal').innerText = sum.toFixed(2);
                //document.querySelector('.cart-summary cartTotal').innerText = 'AUD' + sum.toFixed(2);
                
                
            }

            document.getElementById('purchaseForm').addEventListener('submit', function(e) {
                e.preventDefault(); // prevent page reload

                const checked = document.querySelectorAll('input[name="selected_ids[]"]:checked');
                const selectedIds = Array.from(checked).map(function(cb) { return parseInt(cb.value, 10); });
                //Array.from(selectedCheckboxes) -> convert NodeList into JS array, allowing to use map
                //.map(cb => cb.value) -> extract only the values
                //before map:<input type="checkbox" name="selected_ids[]" value="12" checked>
                //after map: selectedIds = ["12", "25", "37"];

                const quantities = {};
                document.querySelectorAll('input.quantity').forEach(function(input) {
                    var id = parseInt(input.getAttribute('data-id'), 10);
                    quantities[id] = parseInt(input.value, 10) || 1;
                });
                
                if (selectedIds.length === 0) {
                    document.getElementById('responseMessage').innerText = "Please select at least one product.";
                    return;
                }

                // use BASE_URL if defined server-side to build absolute path
                const createUrl = (typeof BASE_URL !== 'undefined' && BASE_URL) ? BASE_URL + '/ajax/create_invoice.php' : 'ajax/create_invoice.php';

                const purchaseBtn = document.querySelector('#purchaseForm button[type="submit"]');
                if (purchaseBtn) purchaseBtn.disabled = true;

                fetch(createUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ selected_ids: selectedIds, quantity: quantities, csrf_token: window.CSRF_TOKEN })
                })
                .then(function(response) {
                    if (!response.ok) throw new Error('Server returned ' + response.status);
                    return response.json();
                })
                .then(function(data) {
                    var respEl = document.getElementById('responseMessage');
                    respEl.innerText = data.message || 'No message from server.';
                    var purchaseBtnLocal = document.querySelector('#purchaseForm button[type="submit"]');
                    if (purchaseBtnLocal) purchaseBtnLocal.disabled = false;

                    if (data.success) {
                        // remove checked rows from DOM
                        checked.forEach(function(cb) {
                            var row = cb.closest('tr');
                            if (row) row.parentNode.removeChild(row);
                        });
                        // recalc total
                        updateCartTotal();
                    }
                })
                .catch(function(err) {
                    document.getElementById('responseMessage').innerText = 'Error: ' + err.message;
                    var purchaseBtnLocal = document.querySelector('#purchaseForm button[type="submit"]');
                    if (purchaseBtnLocal) purchaseBtnLocal.disabled = false;
                });
            
            });

        </script>
    </body>
    <?php include __DIR__ . '/includes/footer.html'; ?>
</html>
