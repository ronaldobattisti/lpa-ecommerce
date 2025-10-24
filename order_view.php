<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';
    include __DIR__ . '/config/site.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM lpa_invoices WHERE lpa_inv_client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $hasOrder = $result->num_rows > 0;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Orders</title>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/styles.css'; ?>">
    </head>
    <body class="body"> 
        <div><?php include __DIR__ . '/includes/header.php'; ?></div>

        <table border='1'>
            <tr>
                <th>Invoice Number</th>
                <th>Date</th>
                <th>Total value</th>
                <th>Payment status</th>
                <th>Order status</th>
            </tr>

            <?php if ($hasOrder) {
                while ($row = $result->fetch_assoc()) {
                    $inv_no = $row['lpa_inv_no'];
                    $inv_date = $row['lpa_inv_date'];
                    $inv_amount = $row['lpa_inv_amount'];
                    $inv_payment = $row['lpa_inv_payment_type'];
                    $inv_status = $row['lpa_inv_status'];
                    ?>
                    <tr>
                        <td><?php echo $inv_no ?></td>
                        <td><?php echo $inv_date ?></td>
                        <td><?php echo $inv_amount ?></td>
                        <td><?php echo $inv_payment ?></td>
                        <td><?php echo $inv_status ?></td>
                    </tr>
                    <?php
                }
            }

            ?>
        </table>

    </body>
    <?php include __DIR__ . '/includes/footer.html'; ?>
</html>