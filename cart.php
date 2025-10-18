<?php
    include 'disable_cache.php';
    include 'connection.php';
    include 'start_session_safe.php';

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
        <title>Temp Store</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="body">

        <div><?php include 'header.php'; ?></div>

        <div>
            <p>Welcome to your cart, <?php echo htmlspecialchars($username); ?>.</p>

            <form method='POST'>

                <table>
                    <tr>
                        <th>Select</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>

                <?php if ($hasItemsInCart){
                    while ($row = $result->fetch_assoc()){
                        $id = $row['lpa_stock_id'];
                        $name = $row['lpa_stock_name'];
                        $price = $row['lpa_stock_price'];
                        $quant = $row['lpa_cart_item_qty'];
                        echo "
                        <tr>
                            <td><input type='checkbox' name='selected_ids[]' value='$id'></td>
                            <td>$id -> $name</td>
                            <td>AUD $price</td>
                            <td><input type='number' name='quantity[$id]' value='$quant' min='1'></td>
                            <td class='total'>$" . ($price * $quant) . "</td>
                            <td>
                                <a href='delete_from_cart.php?item_id=" . $id . "' 
                                onclick='return confirm('Delete this item?');'>Delete</a>
                            </td>
                        </tr>";
                        
                        $total += $row['lpa_cart_item_qty'] * $row['lpa_stock_price'];
                    }      
                } else {
                    echo "<p>Your car is empty</p>";
                }?>

                <div class="cart-total">
                    <p>Total: $<?php echo number_format($total, 2); ?></p>
                </div>

                <div>
                    <button type="submit">Purchase</button>
                </div>
                
                <div><?php include 'footer.html'; ?></div>
            </form>
    </body>
</html>