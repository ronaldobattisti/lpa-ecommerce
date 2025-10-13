<?php
    include 'disable_cache.php';
    include 'connection.php';
    include 'start_session_safe.php';

    $sql = "SELECT * FROM dbproducts";
    $smtm = $conn->prepare($sql);
    $smtm->execute();
    $result = $smtm->get_result();
    $has_products = ($result->num_rows > 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<style>
    .modal {
        display: none; /* hidden by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.5);
    }
</style>

<body>
    <div><?php include 'header.php'; ?></div>

    <div>
        <?php if ($has_products): ?>
            <table border='1'>
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quant</th>
                    <th>Anything</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['price'] ?></td>
                        <td><?php echo $row['quant'] ?></td>
                        <td><a href="#" onclick="show_popup(<?php ?>);">Edit</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No items were registered yet</p>
        <?php endif; ?>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <p>Hello! This is a nicer popup!</p>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

    <div><?php include 'footer.html'; ?></div>
</body>
</html>

<script>
    function show_popup() {
        document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
</script>