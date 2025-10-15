<?php
    include 'disable_cache.php';
    include 'connection.php';
    include 'start_session_safe.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT user, email FROM dbuser WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['user'];
        $email = $row['email'];
    }

    // Fetch all cart items with product info in a single query
    //check thisq query
    $sql = "
        SELECT p.*, c.quant
        FROM dbproducts p
        JOIN dbcart c ON p.id = c.itemID
        WHERE c.userID = ?
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
                    </tr>

                <?php if ($hasItemsInCart){
                    while ($row = $result->fetch_assoc()){
                        $id = $row['id'];
                        $name = $row['name'];
                        $price = $row['price'];
                        $quant = $row['quant'];
                        echo "
                        <tr>
                            <td><input type='checkbox' name='selected_ids[]' value='$id'></td>
                            <td>$name</td>
                            <td>AUD $price</td>
                            <td><input type='number' name='quantity[$id]' value='$quant' min='1'></td>
                            <td class='total'>$" . ($price * $quant) . "</td>
                        </tr>";
                        
                        $total += $row['quant'] * $row['price'];
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