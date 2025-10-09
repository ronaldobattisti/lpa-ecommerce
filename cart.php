<?php
    // Disable caching for test
    header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies and browsers

    include 'connection.php';
    include 'start_session_safe.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT user, email FROM dbuser WHERE id = $user_id";
    $result = $conn->query($sql);
    $total = 0;
    if ($result->num_rows > 0) {
        $user_id = $_SESSION['user_id'];
        $result = $conn->query($sql);
        $row = $result->fetch_assoc(); // fetch one row as associative array
        $username = $row['user'];
        $email = $row['email'];
    }

    $sql = "SELECT DISTINCT itemID FROM dbcart WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        $hasItemsInCart = true;
        $item_ids = [];
        //Creting an array with all items in cart to fetch less items
        //from db when displaying in cart
        while ($row = $result->fetch_assoc()) {
            $item_ids[] = $row['itemID'];
        }
        //impliding it to turn into a string
        $id_list = implode(',', $item_ids);
        echo $id_list; // e.g. "2,5,7"
    } else $hasItemsInCart = false;
    
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
            <p>Welcome to your cart, <?php echo $username; ?></p>
            <?php if ($hasItemsInCart): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>"; class="image">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <p><strong>$<?php echo $row['price']; ?></strong></p>
                        <p><em><?php echo $row['category']; ?></em></p>
                        <!--Post for change server state, GET for retrieve info-->
                        <form method="post" action="add_cart.php">
                            <input type="hidden" name='itemID' value="<?php echo $row['id']; ?>">
                            <button type="submit">Add to cart</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                echo: "Your cart is empty";
            <?php endif; ?>

        </div>


        <div><?php include 'footer.html'; ?></div>
    </body>
</html>