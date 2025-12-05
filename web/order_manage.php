<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';
    include __DIR__ . '/config/site.php';
    include __DIR__ . '/assets/csrf.php';

    // Require admin access
    if (empty($_SESSION['user_isadm'])) {
        if (defined('BASE_URL')) {
            header('Location: ' . rtrim(BASE_URL, '/') . '/index.php');
        } else {
            header('Location: /index.php');
        }
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT i.*, c.lpa_client_firstname, c.lpa_client_lastname 
            FROM lpa_invoices i
            JOIN lpa_clients c on i.lpa_inv_client_id = c.lpa_client_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $hasOrder = $result->num_rows > 0;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // CSRF validation
        if (empty($_POST['csrf_token']) || !csrf_check($_POST['csrf_token'])) {
            echo 'Invalid CSRF token';
            exit;
        }
        $inv_id = $_POST['inv_no'];
        $inv_payment = $_POST['inv_payment'];
        $inv_status = $_POST['inv_status'];

        $sql = "UPDATE `lpa_invoices` SET lpa_inv_payment_type=?, 
                                        lpa_inv_status=?
                                        WHERE `lpa_invoices`.`lpa_inv_no`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $inv_payment, $inv_status, $inv_id);
        
        if ($stmt->execute()){
            echo '<meta http-equiv="refresh" content="5">';
        } else echo 'Fail updating';
    }
    $stmt->close();
    $conn->close();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TempStore - Orders</title>
        <link rel="icon" type="image/x-icon" href="assets/images/logo.ico">
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/styles.css'; ?>">
    </head>
    <body class="body">
    <div><?php include __DIR__ . '/includes/header.php'; ?></div>

    <div class="admin-orders-container">
        <h2>Manage Invoices</h2>

        <?php if ($hasOrder): ?>
        <table class="orders-table">
            <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total (AUD)</th>
                <th>Payment</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()):
                $inv_no = $row['lpa_inv_no'];
                $client_name = $row['lpa_client_firstname'] . ' ' . $row['lpa_client_lastname'];
                $inv_date = (new DateTime($row['lpa_inv_date']))->format("d/m/Y");
                $inv_amount = number_format($row['lpa_inv_amount'], 2);
                $inv_payment = $row['lpa_inv_payment_type'];
                $inv_status = $row['lpa_inv_status'];
            ?>
                <tr>
                <td><?= $inv_no ?></td>
                <td><?= htmlspecialchars($client_name) ?></td>
                <td><?= htmlspecialchars($inv_date) ?></td>
                <td><?= htmlspecialchars($inv_amount) ?></td>
                <td><?= htmlspecialchars(ucfirst($inv_payment)) ?></td>
                <td>
                    <a href="#"
                    class="status-link"
                    onclick="show_popup(
                        <?= $inv_no ?>,
                        '<?= htmlspecialchars($client_name, ENT_QUOTES) ?>',
                        '<?= $inv_date ?>',
                        '<?= $inv_amount ?>',
                        '<?= $inv_payment ?>',
                        '<?= $inv_status ?>'
                    )">
                    <i class="bi bi-pencil-square"></i>
                    <?= htmlspecialchars(ucfirst($inv_status)) ?>
                    </a>
                </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-orders">No invoices found.</p>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
        <h3>Edit Invoice</h3>
        <form method="POST" class="modal-form">
            <?php csrf_field(); ?>

            <div class="form-group">
            <label for="inv_no">Invoice #</label>
            <input type="text" name="inv_no" id="inv_no" readonly>
            </div>

            <div class="form-group">
            <label for="client_name">Client</label>
            <input type="text" name="client_name" id="client_name" readonly>
            </div>

            <div class="form-group">
            <label for="inv_date">Date</label>
            <input type="text" name="inv_date" id="inv_date" readonly>
            </div>

            <div class="form-group">
            <label for="inv_amount">Total</label>
            <input type="text" name="inv_amount" id="inv_amount" readonly>
            </div>

            <div class="form-row">
            <div class="form-group">
                <label for="inv_payment">Payment</label>
                <select id="inv_payment" name="inv_payment">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inv_status">Order status</label>
                <select id="inv_status" name="inv_status">
                <option value="u">Packaging</option>
                <option value="s">Shipped</option>
                <option value="p">Processed</option>
                </select>
            </div>
            </div>

            <div class="modal-actions">
            <button type="button" class="btn-close" onclick="closeModal()">Cancel</button>
            <button type="button" class="btn-submit" onclick="document.querySelector('#myModal form').submit()">Update</button>
            </div>
        </form>
        </div>
    </div>

    <?php include __DIR__ . '/includes/footer.html'; ?>
    </body>
</html>

<script>
    function show_popup(inv_no, client_name, inv_date, inv_amount, inv_payment, inv_status) {
        document.getElementById("myModal").style.display = "block";
        document.getElementById("inv_no").value = inv_no;
        document.getElementById("client_name").value = client_name;
        document.getElementById("inv_date").value = inv_date;
        document.getElementById("inv_amount").value = inv_amount;
        document.getElementById("inv_payment").value = inv_payment;
        document.getElementById("inv_status").value = inv_status;
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
</script>