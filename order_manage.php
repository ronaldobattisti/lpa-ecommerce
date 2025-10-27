<?php
    include __DIR__ . '/assets/disable_cache.php';
    include __DIR__ . '/app/database/connection.php';
    include __DIR__ . '/assets/start_session_safe.php';
    include __DIR__ . '/config/site.php';

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT i.*, c.lpa_client_firstname, c.lpa_client_lastname 
            FROM lpa_invoices i
            JOIN lpa_clients c on i.lpa_inv_client_id = c.lpa_client_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $hasOrder = $result->num_rows > 0;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
        <title>View Orders</title>
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/styles.css'; ?>">
    </head>
    <body class="body"> 
        <div><?php include __DIR__ . '/includes/header.php'; ?></div>

        <div>
            <table border='1'>
                <tr>
                    <th>Invoice Number</th>
                    <th>Costumer name</th>
                    <th>Date</th>
                    <th>Total value</th>
                    <th>Payment status</th>
                    <th>Order status</th>
                </tr>
                
                <?php if ($hasOrder) {
                    while ($row = $result->fetch_assoc()) {
                        $inv_no = $row['lpa_inv_no'];
                        $client_name = $row['lpa_client_firstname'] . ' ' . $row['lpa_client_lastname'];
                        $inv_date = (new DateTime($row['lpa_inv_date']))->format("d/m/Y");
                        $inv_amount = $row['lpa_inv_amount'];
                        $inv_payment = $row['lpa_inv_payment_type'];
                        $inv_status = $row['lpa_inv_status'];
                    ?>
                    <tr>
                        <td><?php echo $inv_no ?></td>
                        <td><?php echo $client_name ?></td>
                        <td><?php echo $inv_date ?></td>
                        <td><?php echo $inv_amount ?></td>
                        <td><?php echo $inv_payment ?></td>
                        <td><a href="#" onclick="show_popup(<?php echo $inv_no; ?>, 
                                                            '<?php echo $client_name; ?>',
                                                            '<?php echo $inv_date; ?>',
                                                            <?php echo $inv_amount; ?>,
                                                            '<?php echo $inv_payment; ?>',
                                                            '<?php echo $inv_status; ?>');"> <?php echo $inv_status ?></a></td>
                    </tr>
                    <?php
                }
            }?>
        </table>
    </div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <p>Edit invoices</p>
        <form method="POST">
            <label for="inv_no">Invoice number: </label>
            <input type="text" name="inv_no" id="inv_no" readonly>
            <br>

            <label for="client_name">Client name: </label>
            <input type="text" name="client_name" id="client_name" readonly>
            <br>

            <label for="inv_date">Date: </label>
            <input type="text" name="inv_date" id="inv_date" readonly>
            <br>

            <label for="inv_amount">Total amount: </label>
            <input type="text" name="inv_amount" id="inv_amount" readonly>
            <br>

            <label for="inv_payment">Payment status: </label>
            <select id="inv_payment" name="inv_payment">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
            </select>
            <br>

            <label for="inv_status">Order status: </label>
            <select id="inv_status" name="inv_status">
                <option value="u">Packaging</option>
                <option value="s">Shipped</option>
                <option value="p">Processed</option>
            </select>
        </form>

        <br>
        <br>
        <button onclick="closeModal()">Close</button>
        <br>
        <br>
        <button type="button" onclick="document.querySelector('#myModal form').submit()">Update</button>
    </div>
</div>

    </body>
    <?php include __DIR__ . '/includes/footer.html'; ?>
</html>

<script>
    function show_popup(inv_no, client_name, inv_date, inv_amount, inv_payment, inv_status) {
        document.getElementById("myModal").style.display = "block";
        document.getElementById("inv_no").value = inv_no;
        document.getElementById("client_name").value = client_name;
        document.getElementById("inv_date").value = inv_date;
        document.getElementById("inv_amount").value = inv_amount;
        let sel_inv_payment = sel_inv_payment.charAt(0).toUpperCase();
        document.getElementById("inv_payment").value = sel_inv_payment;
        document.getElementById("inv_status").value = inv_status;
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
</script>