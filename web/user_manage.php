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

    <div class="admin-clients-container">
        <h2>Manage Clients</h2>

        <?php if ($hasClient): ?>
        <table class="clients-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>isAdm</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                <td><?= $row['lpa_client_id'] ?></td>
                <td><?= htmlspecialchars($row['lpa_client_firstname'] . ' ' . $row['lpa_client_lastname']) ?></td>
                <td><?= htmlspecialchars($row['lpa_client_email']) ?></td>
                <td><?= htmlspecialchars($row['lpa_client_address']) ?></td>
                <td><?= htmlspecialchars($row['lpa_client_phone']) ?></td>
                <td><?= htmlspecialchars($row['lpa_client_group']) ?></td>
                <td>
                    <a href="#"
                    class="edit-link"
                    onclick="show_popup(
                        <?= $row['lpa_client_id'] ?>,
                        '<?= htmlspecialchars($row['lpa_client_firstname'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($row['lpa_client_lastname'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($row['lpa_client_email'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($row['lpa_client_address'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($row['lpa_client_phone'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($row['lpa_client_group'], ENT_QUOTES) ?>'
                    )">
                    <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-clients">No clients found.</p>
        <?php endif; ?>
    </div>

    <!-- MODAL -->
    <div id="myModal" class="modal">
        <div class="modal-content">
        <h3>Edit Client</h3>
        <form method="POST" class="modal-form">
            <?php csrf_field(); ?>

            <div class="form-group">
            <label for="client_id">Client ID</label>
            <input type="text" name="client_id" id="client_id" readonly>
            </div>

            <div class="form-row">
            <div class="form-group">
                <label for="client_firstname">First name</label>
                <input type="text" name="client_firstname" id="client_firstname" required>
            </div>
            <div class="form-group">
                <label for="client_lastname">Last name</label>
                <input type="text" name="client_lastname" id="client_lastname" required>
            </div>
            </div>

            <div class="form-group">
            <label for="client_email">Email</label>
            <input type="email" name="client_email" id="client_email" required>
            </div>

            <div class="form-group">
            <label for="client_address">Address</label>
            <input type="text" name="client_address" id="client_address" required>
            </div>

            <div class="form-group">
            <label for="client_phone">Phone</label>
            <input type="text" name="client_phone" id="client_phone" required>
            </div>

            <div class="form-group">
            <label for="client_isadm">Admin privileges</label>
            <select name="client_isadm" id="client_isadm">
                <option value="0">Regular user</option>
                <option value="1">Administrator</option>
            </select>
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