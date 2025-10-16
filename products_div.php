<?php
    include 'disable_cache.php';
    include 'connection.php';
    include 'start_session_safe.php';

    // Fetch all products by category
    if (@$_SESSION['category'] != ''){
        $sql = "SELECT * FROM lpa_stock WHERE lpa_Stock_cat = '{$_SESSION['category']}'";
    } else {
        $sql = "SELECT * FROM dbproducts";
    }

    //Check if user is logged
    if (isset($_SESSION['user_id'])){
        $islogged = true;
    } else {
        $islogged = false;
    }

    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }
?>

<div class="products">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product">
            <img src="<?php echo $row['lpa_stock_image']; ?>" alt="<?php echo $row['lpa_stock_name']; ?>"; class="image">
            <h3><?php echo $row['lpa_stock_name']; ?></h3>
            <p><?php echo $row['lpa_stock_desc']; ?></p>
            <p><strong>$<?php echo $row['lpa_stock_price']; ?></strong></p>
            <!--<p><em><?php //echo $row['category']; ?></em></p>-->
            <!--Post for change server state, GET for retrieve info-->
            <?php if ($islogged): ?>
                <form method="post" action="add_cart.php">
                    <input type="hidden" name='itemID' value="<?php echo $row['lpa_stock_id ']; ?>">
                    <button type="submit">Add to cart</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<?php $conn->close(); ?>
