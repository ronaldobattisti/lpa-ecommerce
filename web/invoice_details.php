<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';

    $inv_id = $_POST['invoice_id'] ?? '';
    $total = 0;

    $sql = "SELECT * FROM lpa_invoice_items WHERE lpa_invitem_inv_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inv_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hasOrder = $result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TempStore - Inv Details</title>
        <link rel="icon" type="image/x-icon" href="assets/images/logo.ico">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>

    <body class="body">
        <div><?php include __DIR__ . '/includes/header.php'; ?></div>

        <p>invoice number: <?= $inv_id ?></p>
        <?php while ($row = $result->fetch_assoc()):?>
            <br>
            <p>item id: <?= $row['lpa_invitem_stock_id'] ?>,
                item: <?= $row['lpa_invitem_stock_name'] ?>,
                qty: <?= $row['lpa_invitem_qty'] ?>,
                price: <?= $row['lpa_invitem_stock_name'] ?>,
                amount: <?= $row['lpa_invitem_amount'] ?></p>
                <?php $total += $row['lpa_invitem_amount']?>
        <?php endwhile; ?>

        <p>Total invoice: <?= $total ?></p>
        
    <?php include __DIR__ . '/includes/footer.html'; ?>
    </body>
</html>