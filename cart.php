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

    //SELECT DISTINCT returns only unique values, deleting doplicates
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
        $item_ids = array_map('intval', $item_ids);//certifying that all ids are integer
        $id_list = implode(',', $item_ids);
        echo $id_list; // e.g. "2,5,7"
        $sql = "SELECT * FROM dbproducts WHERE id IN($id_list)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
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
                        <p><strong>$<?php echo $row['price']; ?></strong></p>
                        <p>Quantity: <?php  $sql_quant = "SELECT quant FROM dbcart WHERE userID = $user_id AND itemID = {$row['id']}";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            echo $result['quant'];
                                    ?>
                        </p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                echo: "Your cart is empty";
            <?php endif; ?>

        </div>


        <div><?php include 'footer.html'; ?></div>
    </body>
</html>