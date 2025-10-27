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

    $sql = "SELECT lpa_client_id, lpa_client_firstname, lpa_client_lastname, lpa_client_email, lpa_client_address, lpa_client_phone, lpa_client_group
            FROM lpa_clients";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $hasClient = $result->num_rows > 0;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // CSRF validation
        if (empty($_POST['csrf_token']) || !csrf_check($_POST['csrf_token'])) {
            echo 'Invalid CSRF token';
            exit;
        }
        $client_id = $_POST['client_id'];
        $client_firstname = $_POST['client_firstname'];
        $client_surname = $_POST['client_lastname'];
        $client_email = $_POST['client_email'];
        $client_address = $_POST['client_address'];
        $client_phone = $_POST['client_phone'];
        $client_isadm = $_POST['client_isadm'];

        $sql = "UPDATE `lpa_clients` SET lpa_client_firstname=?,
                                        lpa_client_lastname=?,
                                        lpa_client_email=?,
                                        lpa_client_address=?,
                                        lpa_client_phone=?,
                                        lpa_client_group=?
                                        WHERE `lpa_clients`.`lpa_client_id`=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssii", $client_name, 
                                    $client_surname, 
                                    $client_email, 
                                    $client_address, 
                                    $client_phone, 
                                    $client_isadm,
                                    $client_id);

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
                    <th>Client ID</th>
                    <th>Client name</th>
                    <th>Client email</th>
                    <th>Client address</th>
                    <th>Client phone</th>
                    <th>isAdm</th>
                    <th>Edit</th>
                </tr>
                
                <?php if ($hasClient) {
                    while ($row = $result->fetch_assoc()) {
                        $client_id = $row['lpa_client_id'];
                        $client_name = $row['lpa_client_firstname'] . ' ' . $row['lpa_client_lastname'];
                        $client_firstname = $row['lpa_client_firstname'];
                        $client_lastname = $row['lpa_client_lastname'];
                        $client_email = $row['lpa_client_email'];
                        $client_address = $row['lpa_client_address'];
                        $client_phone = $row['lpa_client_phone'];
                        $client_isadm = $row['lpa_client_group'];
                    ?>
                    <tr>
                        <td><?php echo $client_id ?></td>
                        <td><?php echo $client_name ?></td>
                        <td><?php echo $client_email ?></td>
                        <td><?php echo $client_address ?></td>
                        <td><?php echo $client_phone ?></td>
                        <td><?php echo $client_isadm ?></td>
                        <td><a href="#" onclick="show_popup(<?php echo $client_id; ?>, 
                                                            '<?php echo $client_firstname; ?>',
                                                            '<?php echo $client_lastname; ?>',
                                                            '<?php echo $client_email; ?>',
                                                            '<?php echo $client_address; ?>',
                                                            '<?php echo $client_phone; ?>',
                                                            '<?php echo $client_isadm; ?>');"> Edit</a></td>
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
            <label for="client_id">Client ID: </label>
            <input type="text" name="client_id" id="client_id" readonly>
            <br>

            <label for="client_firstname">Client frst name: </label>
            <input type="text" name="client_firstname" id="client_firstname" required>
            <br>

            <label for="client_lastname">Client last name: </label>
            <input type="text" name="client_lastname" id="client_lastname" required>
            <br>

            <label for="client_email">Email: </label>
            <input type="text" name="client_email" id="client_email" required>
            <br>

            <label for="client_address">Client address: </label>
            <input type="text" name="client_address" id="client_address" required>
            <br>

            <label for="client_phone">Client phone: </label>
            <input type="text" name="client_phone" id="client_phone" required>
            <br>
            <?php csrf_field(); ?>

            <label for="client_isadm">Client permissions: </label>
            <input type="text" name="client_isadm" id="client_isadm" required>
            <br>
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
    function show_popup(client_id, client_firstname, client_lastname, client_email, client_address, client_phone, client_isadm) {
        document.getElementById("myModal").style.display = "block";
        document.getElementById("client_id").value = client_id;
        document.getElementById("client_firstname").value = client_firstname;
        document.getElementById("client_lastname").value = client_lastname;
        document.getElementById("client_email").value = client_email;
        document.getElementById("client_address").value = client_address;
        document.getElementById("client_phone").value = client_phone;
        document.getElementById("client_isadm").value = client_isadm;
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
</script>