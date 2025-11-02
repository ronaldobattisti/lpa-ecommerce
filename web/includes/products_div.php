<?php
include __DIR__ . '/../assets/disable_cache.php';
include __DIR__ . '/../app/database/connection.php';
include __DIR__ . '/../assets/start_session_safe.php';
if (file_exists(__DIR__ . '/../config/site.php')) {
    include __DIR__ . '/../config/site.php';
}

// Check if user is logged
$islogged = isset($_SESSION['user_id']);

// Build base SQL
$sql = "SELECT * FROM lpa_stock";
$params = [];
$types = "";

// If search term exists (for example, from an input field)
if (!empty($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE lpa_stock_name LIKE ?";
    $params[] = "%$search%";
    $types .= "s";

// If no search, but category is selected
} else if (!empty($_SESSION['category'])) {
    $sql .= " WHERE lpa_stock_cat = ?";
    $params[] = $_SESSION['category'];
    $types .= "s";
}

// Prepare and execute safely
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="products">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="product">
            <img src="<?php echo htmlspecialchars($row['lpa_stock_image']); ?>" alt="<?php echo htmlspecialchars($row['lpa_stock_name']); ?>" class="image">
            <h3><?php echo htmlspecialchars($row['lpa_stock_name']); ?></h3>
            <p><?php echo htmlspecialchars($row['lpa_stock_desc']); ?></p>
            <p><strong>$<?php echo number_format($row['lpa_stock_price'], 2); ?></strong></p>
            
            <?php if ($islogged): ?>
                <form method="post" action="<?php echo defined('BASE_URL') ? BASE_URL : ''; ?>/ajax/add_cart.php">
                    <input type="hidden" name="item_id" value="<?php echo $row['lpa_stock_id']; ?>">
                    <button type="submit">Add to cart</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<?php
$stmt->close();
$conn->close();
?>
