<?php
    include 'connection.php';
    include 'start_session_safe.php';

    if (isset($_SESSION['user_id'])){
        //echo $_SESSION['user_id'];
        // add_cart.php
        if (isset($_POST['itemID'])) {
            $itemID = $_POST['user_id'];
            echo $_SESSION[user_id];
            $sql = "SELECT * FROM dbcart WHERE user = '{$_SESSION[user_id]}'";
            $result = $conn->query($sql);
            if ($result === null){
                echo 'first cart';
            } else {
                echo 'Already have a cart';
            }
            // Example: add to cart table or session
            // $_SESSION['cart'][$itemID] = ($_SESSION['cart'][$itemID] ?? 0) + 1;
        } else {
            echo "No itemID received!";
        }
    } else {
        header('login.php');
    }
?>