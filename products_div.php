<?php
    include 'connection.php';
    include 'start_session_safe.php';

    // Fetch all products by category
    if (@$_SESSION['category'] != ''){
        $sql = "SELECT * FROM dbproducts WHERE category = '{$_SESSION['category']}'";
    } else {
        $sql = "SELECT * FROM dbproducts";
    }

    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }
?>

<div class="products">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product">
            <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>"; class="image">
            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo $row['description']; ?></p>
            <p><strong>$<?php echo $row['price']; ?></strong></p>
            <p><em><?php echo $row['category']; ?></em></p>
        </div>
    <?php endwhile; ?>
</div>

<?php $conn->close(); ?>
