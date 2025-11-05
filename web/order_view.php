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
  <title>My Orders</title>
  <link rel="stylesheet" href="<?= BASE_URL . '/assets/css/styles.css'; ?>">
</head>
<body class="body">
  <div><?php include __DIR__ . '/includes/header.php'; ?></div>

  <div class="orders-container">
    <h2>Your Orders</h2>

    <?php if ($hasOrder): ?>
      <table class="orders-table">
        <thead>
          <tr>
            <th>Invoice #</th>
            <th>Date</th>
            <th>Total (AUD)</th>
            <th>Payment Type</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()):
            $inv_no = $row['lpa_inv_no'];
            $inv_date = (new DateTime($row['lpa_inv_date']))->format("d/m/Y");
            $inv_amount = number_format($row['lpa_inv_amount'], 2);
            $inv_payment = $row['lpa_inv_payment_type'];
            $inv_status = $row['lpa_inv_status'];
          ?>
            <tr>
              <td><?= htmlspecialchars($inv_no) ?></td>
              <td><?= htmlspecialchars($inv_date) ?></td>
              <td><?= htmlspecialchars($inv_amount) ?></td>
              <td><?= htmlspecialchars($inv_payment) ?></td>
              <td class="status <?= strtolower($inv_status) ?>">
                <?= htmlspecialchars(ucfirst($inv_status)) ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="no-orders">You don’t have any orders yet.</p>
    <?php endif; ?>
  </div>

</body>
<?php include __DIR__ . '/includes/footer.html'; ?>
</html>
